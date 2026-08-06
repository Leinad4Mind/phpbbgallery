<?php
/**
 * phpBB Gallery - Remote Storage Add-on
 *
 * @package   phpbbgallery/remotestorage
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\remotestorage\mediafire;

/** Serialized persistence for MediaFire Session Token v2 signing state. */
interface session_store_interface
{
	public function synchronized(\Closure $operation): mixed;

	/** @return array{session_token: string, secret_key: int, time: string, issued_at: int} */
	public function load(): array;

	public function save(string $session_token, int $secret_key, string $time, int $issued_at): void;

	/** Persist only the per-call signing key while retaining the stable session fields. */
	public function save_secret_key(int $secret_key): void;
}
