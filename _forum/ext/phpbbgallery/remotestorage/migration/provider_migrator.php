<?php
/**
 * phpBB Gallery - Remote Storage Add-on
 *
 * @package   phpbbgallery/remotestorage
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\remotestorage\migration;

use phpbb\config\config;
use phpbbgallery\core\storage\provider_interface;

/** Copy complete provider contents in resumable, verified batches. */
final class provider_migrator
{
	private const VARIANTS = [
		provider_interface::SOURCE,
		provider_interface::MEDIUM,
		provider_interface::MINI,
	];
	private const MAX_STABILITY_ATTEMPTS = 3;

	public function __construct(
		private config $config,
		private provider_resolver_interface $providers,
		private state_store_interface $states,
		private string $workspace_root
	)
	{
		$this->workspace_root = rtrim(str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $workspace_root), DIRECTORY_SEPARATOR);
	}

	/** @return array<string, mixed>|null */
	public function state(): ?array
	{
		return $this->states->load();
	}

	/** @return array<string, mixed> */
	public function start(string $target_provider): array
	{
		$source_provider = strtolower(trim((string) $this->config['phpbb_gallery_storage_provider']));
		$target_provider = strtolower(trim($target_provider));
		$allowed_providers = array_merge(['local'], $this->providers->remote_provider_ids());
		if (!in_array($source_provider, $allowed_providers, true)
			|| !in_array($target_provider, $allowed_providers, true)
			|| $source_provider === $target_provider)
		{
			throw new \InvalidArgumentException('The Gallery storage migration direction is invalid.');
		}
		$current = $this->states->load();
		if ($current !== null && in_array((string) $current['status'], ['running', 'error', 'activating'], true))
		{
			throw new \RuntimeException('A Gallery storage migration is already active.');
		}

		$this->providers->resolve($source_provider);
		$this->providers->resolve($target_provider);
		$now = time();
		$state = [
			'source_provider' => $source_provider,
			'target_provider' => $target_provider,
			'variant' => self::VARIANTS[0],
			'migration_cursor' => '',
			'copied' => 0,
			'skipped' => 0,
			'failed' => 0,
			'status' => 'running',
			'started' => $now,
			'updated' => $now,
			'last_error' => '',
		];
		$this->states->clear();
		$this->states->save($state);
		$this->config->set('phpbb_gallery_storage_migration_target', $target_provider);
		$this->config->set('phpbb_gallery_storage_migration_source', $source_provider);

		return $state;
	}

	/** @return array<string, mixed> */
	public function process(int $limit = 25): array
	{
		$state = $this->states->load();
		if ($state === null || !in_array((string) $state['status'], ['running', 'error', 'activating'], true))
		{
			throw new \RuntimeException('There is no active Gallery storage migration.');
		}
		if ((string) $state['status'] === 'activating')
		{
			return $this->finish_activation($state);
		}
		if ((string) $this->config['phpbb_gallery_storage_provider'] !== (string) $state['source_provider'])
		{
			throw new \RuntimeException('The active Gallery storage provider changed during migration.');
		}
		$this->config->set('phpbb_gallery_storage_migration_target', (string) $state['target_provider']);
		$this->config->set('phpbb_gallery_storage_migration_source', (string) $state['source_provider']);
		$state['status'] = 'running';
		$state['last_error'] = '';
		$source = $this->providers->resolve((string) $state['source_provider']);
		$target = $this->providers->resolve((string) $state['target_provider']);
		$variant = (string) $state['variant'];
		$cursor = (string) $state['migration_cursor'];
		$cursor = $cursor === '' ? null : $cursor;

		try
		{
			$page = $source->list_objects($variant, $cursor, max(1, min(100, $limit)));
			$this->validate_page($page, $cursor);
			foreach ($page['keys'] as $key)
			{
				$result = $this->copy_stable($source, $target, $variant, $key);
				$state[$result]++;
			}
		}
		catch (\Throwable $exception)
		{
			$state['failed']++;
			$state['status'] = 'error';
			$state['last_error'] = $exception->getMessage();
			$state['updated'] = time();
			$this->states->save($state);

			return $state;
		}

		if ($page['cursor'] !== null)
		{
			$state['migration_cursor'] = $page['cursor'];
		}
		else
		{
			$index = array_search($variant, self::VARIANTS, true);
			if ($index === false)
			{
				throw new \RuntimeException('The Gallery storage migration variant is invalid.');
			}
			if (isset(self::VARIANTS[$index + 1]))
			{
				$state['variant'] = self::VARIANTS[$index + 1];
				$state['migration_cursor'] = '';
			}
			else
			{
				$state['status'] = 'activating';
				$state['updated'] = time();
				$this->states->save($state);

				return $this->finish_activation($state);
			}
		}
		$state['updated'] = time();
		$this->states->save($state);

		return $state;
	}

	/** @return array<string, mixed> */
	public function abort(): array
	{
		$state = $this->states->load();
		if ($state === null || !in_array((string) $state['status'], ['running', 'error'], true))
		{
			throw new \RuntimeException('There is no active Gallery storage migration.');
		}

		$this->config->set('phpbb_gallery_storage_migration_source', '');
		$this->config->set('phpbb_gallery_storage_migration_target', '');
		$state['status'] = 'aborted';
		$state['updated'] = time();
		$this->states->save($state);

		return $state;
	}

	/**
	 * Complete the provider switch idempotently after all objects were verified.
	 *
	 * @param array<string, mixed> $state
	 * @return array<string, mixed>
	 */
	private function finish_activation(array $state): array
	{
		$active = (string) $this->config['phpbb_gallery_storage_provider'];
		if (!in_array($active, [(string) $state['source_provider'], (string) $state['target_provider']], true))
		{
			throw new \RuntimeException('The active Gallery storage provider changed before activation completed.');
		}
		if ($active === (string) $state['source_provider'])
		{
			$this->config->set('phpbb_gallery_storage_provider', (string) $state['target_provider']);
		}
		$this->config->set('phpbb_gallery_storage_migration_source', '');
		$this->config->set('phpbb_gallery_storage_migration_target', '');
		$state['status'] = 'complete';
		$state['updated'] = time();
		$this->states->save($state);

		return $state;
	}

	/** @param array{keys: mixed, cursor: mixed} $page */
	private function validate_page(array $page, ?string $current_cursor): void
	{
		if (!isset($page['keys']) || !is_array($page['keys']) || !array_key_exists('cursor', $page)
			|| ($page['cursor'] !== null && (!is_string($page['cursor']) || $page['cursor'] === ''))
			|| ($page['cursor'] !== null && $page['cursor'] === $current_cursor))
		{
			throw new \RuntimeException('The Gallery storage provider returned an invalid migration page.');
		}
		foreach ($page['keys'] as $key)
		{
			if (!is_string($key) || $key === '')
			{
				throw new \RuntimeException('The Gallery storage provider returned an invalid migration key.');
			}
		}
	}

	private function copy_stable(
		provider_interface $source,
		provider_interface $target,
		string $variant,
		string $key
	): string
	{
		for ($attempt = 0; $attempt < self::MAX_STABILITY_ATTEMPTS; $attempt++)
		{
			$snapshot = $this->snapshot($source, $variant, $key);
			if ($this->matches($target, $variant, $key, $snapshot)
				&& $this->matches($source, $variant, $key, $snapshot))
			{
				return 'skipped';
			}

			[$local_file, $temporary] = $this->materialize($source, $variant, $key, $snapshot);
			try
			{
				$written = $target->exists($variant, $key)
					? $target->replace($variant, $key, $local_file)
					: $target->prepare($variant, $key) && $target->write($variant, $key, $local_file);
				if (!$written || !$this->matches($target, $variant, $key, $snapshot))
				{
					throw new \RuntimeException('A Gallery storage object could not be copied and verified.');
				}
			}
			finally
			{
				if ($temporary && is_file($local_file) && !is_link($local_file))
				{
					@unlink($local_file);
				}
			}

			if ($this->matches($source, $variant, $key, $snapshot))
			{
				return 'copied';
			}
		}

		throw new \RuntimeException('A Gallery storage object changed repeatedly during migration.');
	}

	/** @return array{size: int, checksum: string} */
	private function snapshot(provider_interface $provider, string $variant, string $key): array
	{
		$size = $provider->size($variant, $key);
		$checksum = $provider->checksum($variant, $key);
		if ($size === null || $checksum === null || preg_match('/^[a-f0-9]{64}$/D', $checksum) !== 1)
		{
			throw new \RuntimeException('A Gallery storage source object is unavailable or unverifiable.');
		}

		return ['size' => $size, 'checksum' => $checksum];
	}

	/** @param array{size: int, checksum: string} $snapshot */
	private function matches(
		provider_interface $provider,
		string $variant,
		string $key,
		array $snapshot
	): bool
	{
		return $provider->size($variant, $key) === $snapshot['size']
			&& $provider->checksum($variant, $key) === $snapshot['checksum'];
	}

	/**
	 * @param array{size: int, checksum: string} $snapshot
	 * @return array{string, bool}
	 */
	private function materialize(
		provider_interface $source,
		string $variant,
		string $key,
		array $snapshot
	): array
	{
		$local_path = $source->local_path($variant, $key);
		if ($local_path !== null && $this->valid_local_file($local_path, $snapshot))
		{
			return [$local_path, false];
		}

		$this->prepare_workspace();
		$temporary = tempnam($this->workspace_root, 'object-');
		$input = $source->open_stream($variant, $key);
		if ($temporary === false || !is_resource($input))
		{
			if (is_string($temporary) && is_file($temporary))
			{
				@unlink($temporary);
			}
			throw new \RuntimeException('A Gallery storage object could not be materialized.');
		}

		$output = @fopen($temporary, 'wb');
		try
		{
			if ($output === false || stream_copy_to_stream($input, $output) === false || !fflush($output))
			{
				throw new \RuntimeException('A Gallery storage object could not be materialized.');
			}
		}
		finally
		{
			fclose($input);
			if (is_resource($output))
			{
				fclose($output);
			}
		}
		@chmod($temporary, 0600);
		if (!$this->valid_local_file($temporary, $snapshot))
		{
			@unlink($temporary);
			throw new \RuntimeException('A materialized Gallery storage object failed verification.');
		}

		return [$temporary, true];
	}

	/** @param array{size: int, checksum: string} $snapshot */
	private function valid_local_file(string $file, array $snapshot): bool
	{
		if (!is_file($file) || is_link($file) || !is_readable($file))
		{
			return false;
		}
		clearstatcache(true, $file);
		$size = @filesize($file);
		$checksum = @hash_file('sha256', $file);

		return $size !== false && $checksum !== false && (int) $size === $snapshot['size']
			&& hash_equals($snapshot['checksum'], $checksum);
	}

	private function prepare_workspace(): void
	{
		if ((file_exists($this->workspace_root) && (!is_dir($this->workspace_root) || is_link($this->workspace_root)))
			|| (!is_dir($this->workspace_root) && !@mkdir($this->workspace_root, 0700, true)))
		{
			throw new \RuntimeException('The Gallery storage migration workspace is unavailable.');
		}
		@chmod($this->workspace_root, 0700);
	}
}
