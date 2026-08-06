<?php
/**
 * phpBB Gallery - Remote Storage Add-on
 *
 * @package   phpbbgallery/remotestorage
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\remotestorage\box;

/** Atomic persistence boundary for Box rotating OAuth credentials. */
interface token_store_interface
{
	/** Execute a token operation while holding the store lock. */
	public function synchronized(\Closure $operation): mixed;

	/** @return array{access_token: string, access_expires: int, refresh_token: string} */
	public function load(): array;

	public function save(string $access_token, int $access_expires, string $refresh_token): void;
}
