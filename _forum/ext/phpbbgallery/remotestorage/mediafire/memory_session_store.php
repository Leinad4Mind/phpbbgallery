<?php
/**
 * phpBB Gallery - Remote Storage Add-on
 *
 * @package   phpbbgallery/remotestorage
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\remotestorage\mediafire;

/** Request-local MediaFire signing state used by ACP connection tests. */
final class memory_session_store implements session_store_interface
{
	public function __construct(
		private string $session_token = '',
		private int $secret_key = 0,
		private string $time = '',
		private int $issued_at = 0
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
			'session_token' => $this->session_token,
			'secret_key' => $this->secret_key,
			'time' => $this->time,
			'issued_at' => $this->issued_at,
		];
	}

	public function save(string $session_token, int $secret_key, string $time, int $issued_at): void
	{
		$this->session_token = $session_token;
		$this->secret_key = $secret_key;
		$this->time = $time;
		$this->issued_at = $issued_at;
	}

	public function save_secret_key(int $secret_key): void
	{
		$this->secret_key = $secret_key;
	}
}
