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
use phpbbgallery\remotestorage\s3\configured_factory;

final class provider_resolver implements provider_resolver_interface
{
	public function __construct(private local_provider $local, private configured_factory $s3)
	{
	}

	public function resolve(string $provider_id): provider_interface
	{
		return match ($provider_id)
		{
			'local' => $this->local,
			's3' => $this->s3->create(),
			default => throw new \InvalidArgumentException('The Gallery storage migration provider is invalid.'),
		};
	}
}
