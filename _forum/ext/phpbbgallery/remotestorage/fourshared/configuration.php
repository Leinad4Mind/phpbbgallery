<?php
/**
 * phpBB Gallery - Remote Storage Add-on
 *
 * @package   phpbbgallery/remotestorage
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\remotestorage\fourshared;

/** Validated 4shared OAuth identity and dedicated private folder settings. */
final class configuration
{
	private const API_ROOT = 'https://api.4shared.com/v1_2';
	private const UPLOAD_ROOT = 'https://upload.4shared.com/v1_2';

	public function __construct(
		private string $consumer_key,
		private string $consumer_secret,
		private string $access_token,
		private string $access_token_secret,
		private string $root_name = 'phpbbgallery'
	)
	{
		foreach ([
			'consumer key' => $consumer_key,
			'consumer secret' => $consumer_secret,
			'access token' => $access_token,
			'access token secret' => $access_token_secret,
		] as $label => $credential)
		{
			if ($credential === '' || strlen($credential) > 4096
				|| preg_match('/[\x00-\x20\x7f]/', $credential))
			{
				throw new \InvalidArgumentException('The 4shared ' . $label . ' is invalid.');
			}
		}
		if ($root_name === '' || strlen($root_name) > 255 || trim($root_name) !== $root_name
			|| in_array($root_name, ['.', '..'], true)
			|| preg_match('/[\x00-\x1f\x7f\/\\\\<>\x22|?*]/', $root_name))
		{
			throw new \InvalidArgumentException('The 4shared root folder name is invalid.');
		}
	}

	public function consumer_key(): string
	{
		return $this->consumer_key;
	}

	public function consumer_secret(): string
	{
		return $this->consumer_secret;
	}

	public function access_token(): string
	{
		return $this->access_token;
	}

	public function access_token_secret(): string
	{
		return $this->access_token_secret;
	}

	public function root_name(): string
	{
		return $this->root_name;
	}

	public function api_url(string $path): string
	{
		return self::API_ROOT . $this->path($path);
	}

	public function upload_url(string $path): string
	{
		return self::UPLOAD_ROOT . $this->path($path);
	}

	public function object_name(string $variant, string $key): string
	{
		$this->assert_variant($variant);
		if (!$this->valid_key($key))
		{
			throw new \InvalidArgumentException('The 4shared object key is invalid.');
		}
		$name = 'g_' . bin2hex($key);
		if (strlen($name) > 210)
		{
			throw new \InvalidArgumentException('The 4shared object key exceeds the provider name limit.');
		}

		return $name;
	}

	public function relative_key(string $variant, string $name): ?string
	{
		$this->assert_variant($variant);
		if (!str_starts_with($name, 'g_'))
		{
			return null;
		}
		$encoded = substr($name, 2);
		if ($encoded === '' || strlen($encoded) % 2 !== 0
			|| preg_match('/^[a-f0-9]+$/D', $encoded) !== 1)
		{
			return null;
		}
		$key = hex2bin($encoded);

		return is_string($key) && $this->valid_key($key) ? $key : null;
	}

	public function id(mixed $value): string
	{
		$value = is_int($value) || is_string($value) ? (string) $value : '';
		if (preg_match('/^[A-Za-z0-9_-]{1,128}$/D', $value) !== 1)
		{
			throw new \RuntimeException('4shared returned an invalid object identifier.');
		}

		return $value;
	}

	private function path(string $path): string
	{
		if (preg_match('#^/[A-Za-z0-9_/-]{1,512}$#D', $path) !== 1
			|| str_contains($path, '//') || str_contains($path, '/./') || str_contains($path, '/../'))
		{
			throw new \InvalidArgumentException('The 4shared API path is invalid.');
		}

		return $path;
	}

	private function assert_variant(string $variant): void
	{
		if (!in_array($variant, [
			\phpbbgallery\core\storage\provider_interface::SOURCE,
			\phpbbgallery\core\storage\provider_interface::MEDIUM,
			\phpbbgallery\core\storage\provider_interface::MINI,
		], true))
		{
			throw new \InvalidArgumentException('The 4shared object variant is invalid.');
		}
	}

	private function valid_key(string $key): bool
	{
		if ($key === '' || strlen($key) > 1024 || str_starts_with($key, '/')
			|| str_contains($key, '\\') || preg_match('/[\x00-\x1f\x7f]/', $key))
		{
			return false;
		}
		foreach (explode('/', $key) as $segment)
		{
			if ($segment === '' || $segment === '.' || $segment === '..')
			{
				return false;
			}
		}

		return true;
	}
}
