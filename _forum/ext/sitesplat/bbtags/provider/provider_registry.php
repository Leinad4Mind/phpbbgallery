<?php
/**
 * Lazy registry for tagged BBTags content providers.
 *
 * @copyright (c) 2015 SiteSplat All rights reserved
 * @license Proprietary
 */

namespace sitesplat\bbtags\provider;

class provider_registry
{
	private iterable $provider_services;
	private ?array $providers = null;

	public function __construct(iterable $provider_services)
	{
		$this->provider_services = $provider_services;
	}

	public function has(string $name): bool
	{
		return $this->get($name) !== null;
	}

	public function get(string $name): ?provider_interface
	{
		$this->load();

		return $this->providers[$name] ?? null;
	}

	/**
	 * @return array<string, provider_interface>
	 */
	public function all(): array
	{
		$this->load();

		return $this->providers;
	}

	private function load(): void
	{
		if ($this->providers !== null)
		{
			return;
		}

		$this->providers = [];
		foreach ($this->provider_services as $provider)
		{
			if (!$provider instanceof provider_interface)
			{
				throw new \LogicException('Every sitesplat.bbtags.provider service must implement provider_interface.');
			}
			$name = $provider->get_name();
			if (!preg_match('/^[a-z][a-z0-9_]{1,31}$/D', $name))
			{
				throw new \LogicException('Invalid BBTags provider name: ' . $name);
			}
			if (isset($this->providers[$name]))
			{
				throw new \LogicException('Duplicate BBTags provider name: ' . $name);
			}
			$this->providers[$name] = $provider;
		}
	}
}
