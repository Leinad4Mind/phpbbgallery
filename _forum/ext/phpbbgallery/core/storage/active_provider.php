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
	private ?provider_interface $resolved = null;
	private string $resolved_id = '';

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
		return $this->provider()->prepare($variant, $key);
	}

	public function write(string $variant, string $key, string $local_file): bool
	{
		return $this->provider()->write($variant, $key, $local_file);
	}

	public function replace(string $variant, string $key, string $local_file): bool
	{
		return $this->provider()->replace($variant, $key, $local_file);
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
		return $this->provider()->delete($variant, $key);
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
		if (preg_match('/^[a-z][a-z0-9_.-]{0,63}$/D', $provider_id) !== 1)
		{
			throw new \RuntimeException('The configured Gallery storage provider identifier is invalid.');
		}

		if ($this->resolved !== null && $this->resolved_id === $provider_id)
		{
			return $this->resolved;
		}

		if ($provider_id === 'local')
		{
			$this->resolved = $this->local;
			$this->resolved_id = $provider_id;

			return $this->resolved;
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

		$this->resolved = $provider;
		$this->resolved_id = $provider_id;

		return $this->resolved;
	}
}
