<?php

namespace Symfony\Component\DependencyInjection;

if (!class_exists(Container::class))
{
	// phpcs:disable PhpbbCodingStandard.NamingConventions.LowercaseUnderscoredClasses.NotAllowed -- External Symfony API name.
	class Container
	{
		private array $services = [];

		public function set(string $id, object $service): void
		{
			$this->services[$id] = $service;
		}

		public function get(string $id): object
		{
			return $this->services[$id];
		}
	}
	// phpcs:enable PhpbbCodingStandard.NamingConventions.LowercaseUnderscoredClasses.NotAllowed
}
