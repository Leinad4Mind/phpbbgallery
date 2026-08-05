<?php
/**
 * phpBB Gallery - Core Extension
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\storage;

use Symfony\Component\DependencyInjection\ContainerInterface;

/** Resolve and proxy the storage provider selected in the Gallery configuration. */
class active_provider implements provider_interface
{
	private const SERVICE_PREFIX = 'phpbbgallery.storage.provider.';

	private \phpbbgallery\core\config $config;
	private ContainerInterface $container;
	private local_provider $local;
	/** @var array<string, provider_interface> */
	private array $providers = [];

	public function __construct(
		\phpbbgallery\core\config $config,
		ContainerInterface $container,
		local_provider $local
	)
	{
		$this->config = $config;
		$this->container = $container;
		$this->local = $local;
	}

	public function get_id(): string
	{
		return $this->provider()->get_id();
	}

	public function prepare(string $variant, string $key): bool
	{
		$primary = $this->provider();
		$peer = $this->migration_peer($primary);

		return $primary->prepare($variant, $key)
			&& ($peer === null || $peer->prepare($variant, $key));
	}

	public function write(string $variant, string $key, string $local_file): bool
	{
		$primary = $this->provider();
		$peer = $this->migration_peer($primary);
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
		$primary = $this->provider();
		$peer = $this->migration_peer($primary);
		if ($peer !== null && !$this->replace_peer($peer, $variant, $key, $local_file))
		{
			return false;
		}

		return $primary->replace($variant, $key, $local_file);
	}

	public function open_stream(string $variant, string $key): mixed
	{
		return $this->provider()->open_stream($variant, $key);
	}

	public function local_path(string $variant, string $key): ?string
	{
		return $this->provider()->local_path($variant, $key);
	}

	public function exists(string $variant, string $key): bool
	{
		return $this->provider()->exists($variant, $key);
	}

	public function delete(string $variant, string $key): bool
	{
		$primary = $this->provider();
		$peer = $this->migration_peer($primary);
		if ($peer !== null && !$peer->delete($variant, $key))
		{
			return false;
		}

		return $primary->delete($variant, $key);
	}

	public function size(string $variant, string $key): ?int
	{
		return $this->provider()->size($variant, $key);
	}

	public function modified_time(string $variant, string $key): ?int
	{
		return $this->provider()->modified_time($variant, $key);
	}

	public function list_objects(string $variant, ?string $cursor = null, int $limit = 500): array
	{
		return $this->provider()->list_objects($variant, $cursor, $limit);
	}

	public function checksum(string $variant, string $key, string $algorithm = 'sha256'): ?string
	{
		return $this->provider()->checksum($variant, $key, $algorithm);
	}

	private function provider(): provider_interface
	{
		$provider_id = strtolower(trim((string) $this->config->get('storage_provider')));

		return $this->resolve($provider_id);
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

		$service_id = self::SERVICE_PREFIX . $provider_id;
		if (!$this->container->has($service_id))
		{
			throw new \RuntimeException('The configured Gallery storage provider is not available: ' . $provider_id);
		}

		$provider = $this->container->get($service_id);
		if (!$provider instanceof provider_interface || $provider->get_id() !== $provider_id)
		{
			throw new \RuntimeException('The configured Gallery storage provider service is incompatible: ' . $provider_id);
		}

		return $this->providers[$provider_id] = $provider;
	}

	private function migration_peer(provider_interface $primary): ?provider_interface
	{
		$source = strtolower(trim((string) $this->config->get('storage_migration_source')));
		$target = strtolower(trim((string) $this->config->get('storage_migration_target')));
		// Configuration rows are persisted separately. A request may observe the
		// short transition while a migration is being started or completed.
		if ($source === '' || $target === '')
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
