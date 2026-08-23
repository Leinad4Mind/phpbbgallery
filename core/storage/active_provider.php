<?php
/**
 * phpBB Gallery - Core Extension
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\storage;

/** Resolve and proxy the storage provider selected in the Gallery configuration. */
class active_provider implements provider_interface
{
	private \phpbbgallery\core\config $config;
	/** @var iterable<provider_factory_interface> */
	private iterable $provider_factory_collection;
	private local_provider $local;
	private variant_key $variant_key;
	/** @var array<string, provider_interface> */
	private array $providers = [];
	/** @var array<string, provider_factory_interface> */
	private array $provider_factories = [];
	private bool $provider_factories_loaded = false;

	public function __construct(
		\phpbbgallery\core\config $config,
		iterable $provider_factory_collection,
		local_provider $local,
		?variant_key $variant_key = null
	)
	{
		$this->config = $config;
		$this->provider_factory_collection = $provider_factory_collection;
		$this->local = $local;
		$this->variant_key = $variant_key ?? new variant_key();
	}

	public function get_id(): string
	{
		// The storage contract predates variant routing. Keep its identifier
		// compatible by exposing the provider of the original source file.
		return $this->provider(provider_interface::SOURCE)->get_id();
	}

	/** Return the provider assigned to one Gallery file variant. */
	public function get_variant_provider_id(string $variant): string
	{
		return $this->provider($variant)->get_id();
	}

	public function prepare(string $variant, string $key): bool
	{
		$key = $this->variant_key->resolve($variant, $key);
		$primary = $this->provider($variant);
		$peer = $this->migration_peer($primary, $variant);

		return $primary->prepare($variant, $key)
			&& ($peer === null || $peer->prepare($variant, $key));
	}

	public function write(string $variant, string $key, string $local_file): bool
	{
		$key = $this->variant_key->resolve($variant, $key);
		$primary = $this->provider($variant);
		$peer = $this->migration_peer($primary, $variant);
		if (!$primary->write($variant, $key, $local_file))
		{
			return false;
		}

		if ($peer === null || $this->publish_peer($peer, $variant, $key, $local_file))
		{
			return true;
		}

		$primary->delete($variant, $key);

		return false;
	}

	public function replace(string $variant, string $key, string $local_file): bool
	{
		$key = $this->variant_key->resolve($variant, $key);
		$primary = $this->provider($variant);
		$peer = $this->migration_peer($primary, $variant);
		if ($peer !== null && !$this->replace_peer($peer, $variant, $key, $local_file))
		{
			return false;
		}

		return $primary->replace($variant, $key, $local_file);
	}

	public function open_stream(string $variant, string $key): mixed
	{
		$key = $this->variant_key->resolve($variant, $key);
		return $this->provider($variant)->open_stream($variant, $key);
	}

	public function local_path(string $variant, string $key): ?string
	{
		$key = $this->variant_key->resolve($variant, $key);
		return $this->provider($variant)->local_path($variant, $key);
	}

	public function exists(string $variant, string $key): bool
	{
		$key = $this->variant_key->resolve($variant, $key);
		return $this->provider($variant)->exists($variant, $key);
	}

	public function delete(string $variant, string $key): bool
	{
		$key = $this->variant_key->resolve($variant, $key);
		$primary = $this->provider($variant);
		$peer = $this->migration_peer($primary, $variant);
		if ($peer !== null && !$peer->delete($variant, $key))
		{
			return false;
		}

		return $primary->delete($variant, $key);
	}

	public function size(string $variant, string $key): ?int
	{
		$key = $this->variant_key->resolve($variant, $key);
		return $this->provider($variant)->size($variant, $key);
	}

	public function modified_time(string $variant, string $key): ?int
	{
		$key = $this->variant_key->resolve($variant, $key);
		return $this->provider($variant)->modified_time($variant, $key);
	}

	public function list_objects(string $variant, ?string $cursor = null, int $limit = 500): array
	{
		return $this->provider($variant)->list_objects($variant, $cursor, $limit);
	}

	public function checksum(string $variant, string $key, string $algorithm = 'sha256'): ?string
	{
		$key = $this->variant_key->resolve($variant, $key);
		return $this->provider($variant)->checksum($variant, $key, $algorithm);
	}

	private function provider(string $variant): provider_interface
	{
		$this->validate_variant($variant);
		$provider_id = strtolower(trim((string) $this->config->get('storage_provider_' . $variant, '')));
		if ($provider_id === '')
		{
			$provider_id = strtolower(trim((string) $this->config->get('storage_provider')));
		}

		return $this->resolve($provider_id);
	}

	private function validate_variant(string $variant): void
	{
		if (!in_array($variant, [
			provider_interface::SOURCE,
			provider_interface::MEDIUM,
			provider_interface::MINI,
		], true))
		{
			throw new \InvalidArgumentException('The Gallery storage variant is invalid.');
		}
	}

	private function resolve(string $provider_id): provider_interface
	{
		if (preg_match('/^[a-z][a-z0-9_.-]{0,63}$/D', $provider_id) !== 1)
		{
			throw new \RuntimeException('The configured Gallery storage provider identifier is invalid.');
		}

		if (isset($this->providers[$provider_id]))
		{
			return $this->providers[$provider_id];
		}

		if ($provider_id === 'local')
		{
			return $this->providers[$provider_id] = $this->local;
		}

		$this->load_provider_factories();
		if (!isset($this->provider_factories[$provider_id]))
		{
			throw new \RuntimeException('The configured Gallery storage provider is not available: ' . $provider_id);
		}

		$provider = $this->provider_factories[$provider_id]->create();
		if ($provider->get_id() !== $provider_id)
		{
			throw new \RuntimeException('The configured Gallery storage provider factory returned an incompatible provider.');
		}

		return $this->providers[$provider_id] = $provider;
	}

	private function load_provider_factories(): void
	{
		if ($this->provider_factories_loaded)
		{
			return;
		}

		foreach ($this->provider_factory_collection as $factory)
		{
			if (!$factory instanceof provider_factory_interface)
			{
				throw new \RuntimeException('A registered Gallery storage provider factory is incompatible.');
			}

			$provider_id = strtolower(trim($factory->get_id()));
			if ($provider_id === 'local' || preg_match('/^[a-z][a-z0-9_.-]{0,63}$/D', $provider_id) !== 1)
			{
				throw new \RuntimeException('A registered Gallery storage provider identifier is invalid.');
			}
			if (isset($this->provider_factories[$provider_id]))
			{
				throw new \RuntimeException('A Gallery storage provider identifier is registered more than once: ' . $provider_id);
			}

			$this->provider_factories[$provider_id] = $factory;
		}

		$this->provider_factories_loaded = true;
	}

	private function migration_peer(provider_interface $primary, string $variant): ?provider_interface
	{
		$source = strtolower(trim((string) $this->config->get('storage_migration_source')));
		$target = strtolower(trim((string) $this->config->get('storage_migration_target')));
		$migration_variant = strtolower(trim((string) $this->config->get('storage_migration_variant', '')));
		// Configuration rows are persisted separately. A request may observe the
		// short transition while a migration is being started or completed.
		if ($source === '' || $target === '')
		{
			return null;
		}
		// An empty value belongs to migrations started by an older add-on
		// release and deliberately retains its former all-variant mirroring.
		if ($migration_variant !== '' && $migration_variant !== $variant)
		{
			return null;
		}
		if ($source === $target)
		{
			throw new \RuntimeException('The Gallery storage migration state is invalid.');
		}

		$primary_id = $primary->get_id();
		if ($primary_id !== $source && $primary_id !== $target)
		{
			throw new \RuntimeException('The active Gallery storage provider does not match the migration state.');
		}

		return $this->resolve($primary_id === $source ? $target : $source);
	}

	private function publish_peer(
		provider_interface $peer,
		string $variant,
		string $key,
		string $local_file
	): bool
	{
		if ($peer->exists($variant, $key))
		{
			return $this->matches_local($peer, $variant, $key, $local_file);
		}

		return $peer->prepare($variant, $key)
			&& $peer->write($variant, $key, $local_file)
			&& $this->matches_local($peer, $variant, $key, $local_file);
	}

	private function replace_peer(
		provider_interface $peer,
		string $variant,
		string $key,
		string $local_file
	): bool
	{
		$updated = $peer->exists($variant, $key)
			? $peer->replace($variant, $key, $local_file)
			: $peer->prepare($variant, $key) && $peer->write($variant, $key, $local_file);

		return $updated && $this->matches_local($peer, $variant, $key, $local_file);
	}

	private function matches_local(
		provider_interface $provider,
		string $variant,
		string $key,
		string $local_file
	): bool
	{
		clearstatcache(true, $local_file);
		$size = filesize($local_file);
		$checksum = hash_file('sha256', $local_file);

		return $size !== false && is_string($checksum)
			&& $provider->size($variant, $key) === (int) $size
			&& $provider->checksum($variant, $key) === $checksum;
	}
}
