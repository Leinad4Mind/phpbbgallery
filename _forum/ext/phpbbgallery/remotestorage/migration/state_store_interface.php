<?php
/**
 * phpBB Gallery - Remote Storage Add-on
 *
 * @package   phpbbgallery/remotestorage
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\remotestorage\migration;

interface state_store_interface
{
	/** @return array<string, mixed>|null */
	public function load(): ?array;

	/** @param array<string, mixed> $state */
	public function save(array $state): void;

	public function clear(): void;
}
