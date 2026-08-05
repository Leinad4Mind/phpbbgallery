<?php
/**
 * phpBB Gallery - Remote Storage Add-on
 *
 * @package   phpbbgallery/remotestorage
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\remotestorage\dropbox;

/** Validated Dropbox credentials and private Gallery namespace. */
final class configuration
{
	private string $root;

	public function __construct(
		private string $app_key,
		private string $app_secret,
		private string $refresh_token,
		string $root = '/phpbbgallery'
	)
	{
		foreach ([$app_key, $app_secret, $refresh_token] as $credential)
		{
			if ($credential === '' || strlen($credential) > 4096 || preg_match('/[\x00-\x1f\x7f]/', $credential))
			{
				throw new \InvalidArgumentException('A Dropbox credential is invalid.');
			}
		}
		$root = '/' . trim($root, '/');
		if ($root === '/' || strlen($root) > 512 || !$this->valid_path($root))
		{
			throw new \InvalidArgumentException('The Dropbox root path is invalid.');
		}
		$this->root = $root;
	}

	public function app_key(): string
	{
		return $this->app_key;
	}

	public function app_secret(): string
	{
		return $this->app_secret;
	}

	public function refresh_token(): string
	{
		return $this->refresh_token;
	}

	public function object_path(string $variant, string $key): string
	{
		$this->assert_variant($variant);
		if (!$this->valid_key($key))
		{
			throw new \InvalidArgumentException('The Dropbox object key is invalid.');
		}

		return $this->variant_path($variant) . '/' . $key;
	}

	public function variant_path(string $variant): string
	{
		$this->assert_variant($variant);

		return $this->root . '/' . $variant;
	}

	public function relative_key(string $variant, string $path): ?string
	{
		$prefix = $this->variant_path($variant) . '/';
		if (strncasecmp($path, $prefix, strlen($prefix)) !== 0)
		{
			return null;
		}
		$key = substr($path, strlen($prefix));

		return $this->valid_key($key) ? $key : null;
	}

	/** @return list<string> */
	public function parent_paths(string $variant, string $key): array
	{
		$path = $this->object_path($variant, $key);
		$parts = explode('/', trim(dirname($path), '/'));
		$paths = [];
		$current = '';
		foreach ($parts as $part)
		{
			$current .= '/' . $part;
			$paths[] = $current;
		}

		return $paths;
	}

	private function assert_variant(string $variant): void
	{
		if (!in_array($variant, [
			\phpbbgallery\core\storage\provider_interface::SOURCE,
			\phpbbgallery\core\storage\provider_interface::MEDIUM,
			\phpbbgallery\core\storage\provider_interface::MINI,
		], true))
		{
			throw new \InvalidArgumentException('The Dropbox object variant is invalid.');
		}
	}

	private function valid_path(string $path): bool
	{
		if (!str_starts_with($path, '/') || str_contains($path, '\\')
			|| preg_match('/[\x00-\x1f\x7f]/', $path) === 1)
		{
			return false;
		}

		return $this->valid_segments(explode('/', ltrim($path, '/')));
	}

	private function valid_key(string $key): bool
	{
		return $key !== '' && strlen($key) <= 1024 && !str_starts_with($key, '/')
			&& !str_contains($key, '\\') && preg_match('/[\x00-\x1f\x7f]/', $key) !== 1
			&& $this->valid_segments(explode('/', $key));
	}

	/** @param list<string> $segments */
	private function valid_segments(array $segments): bool
	{
		foreach ($segments as $segment)
		{
			if ($segment === '' || $segment === '.' || $segment === '..')
			{
				return false;
			}
		}

		return true;
	}
}
