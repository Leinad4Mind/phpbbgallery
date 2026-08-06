<?php
/**
 * phpBB Gallery - Remote Storage Add-on
 *
 * @package   phpbbgallery/remotestorage
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\remotestorage\providers\box;

/** Request-local Box credential store used by ACP connection tests. */
final class memory_token_store implements token_store_interface
{
	public function __construct(
		private string $refresh_token,
		private string $access_token = '',
		private int $access_expires = 0
	)
	{
	}

	public function synchronized(\Closure $operation): mixed
	{
		return $operation();
	}

	public function load(): array
	{
		return [
			'access_token' => $this->access_token,
			'access_expires' => $this->access_expires,
			'refresh_token' => $this->refresh_token,
		];
	}

	public function save(string $access_token, int $access_expires, string $refresh_token): void
	{
		$this->access_token = $access_token;
		$this->access_expires = $access_expires;
		$this->refresh_token = $refresh_token;
	}
}
