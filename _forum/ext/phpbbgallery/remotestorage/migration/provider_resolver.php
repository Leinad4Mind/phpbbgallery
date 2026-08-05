<?php
/**
 * phpBB Gallery - Remote Storage Add-on
 *
 * @package   phpbbgallery/remotestorage
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\remotestorage\migration;

use phpbbgallery\core\storage\local_provider;
use phpbbgallery\core\storage\provider_interface;
use phpbbgallery\remotestorage\configured_provider_factory_interface;
use Symfony\Component\DependencyInjection\ContainerInterface;

final class provider_resolver implements provider_resolver_interface
{
	private const FACTORY_PREFIX = 'phpbbgallery.remotestorage.provider_factory.';

	/** @var list<string> */
	private array $remote_provider_ids;

	/** @param list<string> $remote_provider_ids */
	public function __construct(
		private local_provider $local,
		private ContainerInterface $container,
		array $remote_provider_ids
	)
	{
		$this->remote_provider_ids = $this->validate_ids($remote_provider_ids);
	}

	public function resolve(string $provider_id): provider_interface
	{
		$provider_id = strtolower(trim($provider_id));
		if ($provider_id === 'local')
		{
			return $this->local;
		}

		return $this->factory($provider_id)->create();
	}

	/** @return list<string> */
	public function remote_provider_ids(): array
	{
		return $this->remote_provider_ids;
	}

	public function factory(string $provider_id): configured_provider_factory_interface
	{
		$provider_id = strtolower(trim($provider_id));
		if (!in_array($provider_id, $this->remote_provider_ids, true))
		{
			throw new \InvalidArgumentException('The Gallery storage migration provider is invalid.');
		}

		$service_id = self::FACTORY_PREFIX . $provider_id;
		if (!$this->container->has($service_id))
		{
			throw new \RuntimeException('The Gallery storage provider factory is not available: ' . $provider_id);
		}
		$factory = $this->container->get($service_id);
		if (!$factory instanceof configured_provider_factory_interface || $factory->get_id() !== $provider_id)
		{
			throw new \RuntimeException('The Gallery storage provider factory is incompatible: ' . $provider_id);
		}

		return $factory;
	}

	/** @param list<string> $provider_ids
	 * @return list<string>
	 */
	private function validate_ids(array $provider_ids): array
	{
		$validated = [];
		foreach ($provider_ids as $provider_id)
		{
			$provider_id = strtolower(trim((string) $provider_id));
			if (preg_match('/^[a-z][a-z0-9_.-]{0,63}$/D', $provider_id) !== 1
				|| $provider_id === 'local' || in_array($provider_id, $validated, true))
			{
				throw new \InvalidArgumentException('The Gallery remote storage provider catalogue is invalid.');
			}
			$validated[] = $provider_id;
		}

		return $validated;
	}
}
