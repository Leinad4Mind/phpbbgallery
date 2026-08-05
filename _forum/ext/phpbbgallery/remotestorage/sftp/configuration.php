<?php
/**
 * phpBB Gallery - Remote Storage Add-on
 *
 * @package   phpbbgallery/remotestorage
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\remotestorage\sftp;

/** Validated SFTP endpoint, credentials and private Gallery root. */
final class configuration
{
	public function __construct(
		private string $host,
		private int $port,
		private string $username,
		private string $password,
		private string $host_fingerprint,
		private string $root = '/phpbbgallery'
	)
	{
		$this->host = strtolower(trim($host));
		$this->username = trim($username);
		$this->host_fingerprint = strtolower(str_replace(':', '', trim($host_fingerprint)));
		$this->root = '/' . trim(str_replace('\\', '/', $root), '/');
		if (filter_var($this->host, FILTER_VALIDATE_IP) === false
			&& preg_match('/^(?=.{1,253}$)(?:[a-z0-9](?:[a-z0-9-]{0,61}[a-z0-9])?\.)*[a-z0-9](?:[a-z0-9-]{0,61}[a-z0-9])?$/D', $this->host) !== 1)
		{
			throw new \InvalidArgumentException('The SFTP host is invalid.');
		}
		if ($this->port < 1 || $this->port > 65535 || $this->username === '' || strlen($this->username) > 255
			|| $this->password === '' || strlen($this->password) > 4096)
		{
			throw new \InvalidArgumentException('The SFTP credentials or port are invalid.');
		}
		if (preg_match('/^[a-f0-9]{40}$/D', $this->host_fingerprint) !== 1)
		{
			throw new \InvalidArgumentException('The SFTP SHA-1 host fingerprint is invalid.');
		}
		if ($this->root === '/' || strlen($this->root) > 1024 || !$this->valid_path(ltrim($this->root, '/')))
		{
			throw new \InvalidArgumentException('The SFTP storage root is invalid.');
		}
	}

	public function host(): string
 {
 return $this->host; }
	public function port(): int
 {
 return $this->port; }
	public function username(): string
 {
 return $this->username; }
	public function password(): string
 {
 return $this->password; }
	public function host_fingerprint(): string
 {
 return $this->host_fingerprint; }

	public function object_path(string $variant, string $key): string
	{
		$this->assert_variant($variant);
		if (!$this->valid_path($key))
		{
			throw new \InvalidArgumentException('The SFTP object key is invalid.');
		}

		return $this->variant_root($variant) . '/' . $key;
	}

	public function variant_root(string $variant): string
	{
		$this->assert_variant($variant);

		return $this->root . '/' . $variant;
	}

	private function assert_variant(string $variant): void
	{
		if (!in_array($variant, ['source', 'medium', 'mini'], true))
		{
			throw new \InvalidArgumentException('The SFTP object variant is invalid.');
		}
	}

	private function valid_path(string $path): bool
	{
		return $path !== '' && strlen($path) <= 1024 && !str_starts_with($path, '/')
			&& !str_contains($path, '\\') && preg_match('/[\x00-\x1f\x7f]/', $path) !== 1
			&& !in_array('..', explode('/', $path), true);
	}
}
