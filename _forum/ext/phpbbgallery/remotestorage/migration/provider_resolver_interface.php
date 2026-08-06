<?php
/**
 * phpBB Gallery - Remote Storage Add-on
 *
 * @package   phpbbgallery/remotestorage
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\remotestorage\migration;

use phpbbgallery\core\storage\provider_interface;

interface provider_resolver_interface
{
	public function resolve(string $provider_id): provider_interface;

	/** @return list<string> */
	public function remote_provider_ids(): array;
}
