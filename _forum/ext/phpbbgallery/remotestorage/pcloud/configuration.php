<?php
/**
 * phpBB Gallery - Remote Storage Add-on
 *
 * @package   phpbbgallery/remotestorage
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\remotestorage\pcloud;

/** Validated pCloud region, OAuth token and dedicated folder settings. */
final class configuration
{
	private const API_HOSTS = ['api.pcloud.com', 'eapi.pcloud.com'];

	public function __construct(
		private string $api_host,
		private string $access_token,
		private string $root_name = 'phpbbgallery'
	)
	{
		$this->api_host = strtolower($api_host);
		if (!in_array($this->api_host, self::API_HOSTS, true))
		{
			throw new \InvalidArgumentException('The pCloud API region is invalid.');
		}
		if ($access_token === '' || strlen($access_token) > 4096
			|| preg_match('/[\x00-\x20\x7f]/', $access_token))
		{
			throw new \InvalidArgumentException('The pCloud access token is invalid.');
		}
		if ($root_name === '' || strlen($root_name) > 255 || trim($root_name) !== $root_name
			|| in_array($root_name, ['.', '..'], true)
			|| preg_match('/[\x00-\x1f\x7f\/\\\\<>\x22|?*]/', $root_name))
		{
			throw new \InvalidArgumentException('The pCloud root folder name is invalid.');
		}
	}

	public function api_host(): string
	{
		return $this->api_host;
	}

	public function api_root(): string
	{
		return 'https://' . $this->api_host;
	}

	public function access_token(): string
	{
		return $this->access_token;
	}

	public function root_name(): string
	{
		return $this->root_name;
	}

	public function object_name(string $variant, string $key): string
	{
		$this->assert_variant($variant);
		if (!$this->valid_key($key))
		{
			throw new \InvalidArgumentException('The pCloud object key is invalid.');
		}
		$name = 'g_' . bin2hex($key);
		if (strlen($name) > 255)
		{
			throw new \InvalidArgumentException('The pCloud object key exceeds the provider name limit.');
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

	public function variant_name(string $variant): string
	{
		$this->assert_variant($variant);

		return $variant;
	}

	public function id(mixed $value, bool $allow_root = false): string
	{
		$value = is_int($value) || is_string($value) ? (string) $value : '';
		if (preg_match('/^(?:0|[1-9][0-9]{0,19})$/D', $value) !== 1 || (!$allow_root && $value === '0'))
		{
			throw new \RuntimeException('pCloud returned an invalid object identifier.');
		}

		return $value;
	}

	private function assert_variant(string $variant): void
	{
		if (!in_array($variant, [
			\phpbbgallery\core\storage\provider_interface::SOURCE,
			\phpbbgallery\core\storage\provider_interface::MEDIUM,
			\phpbbgallery\core\storage\provider_interface::MINI,
		], true))
		{
			throw new \InvalidArgumentException('The pCloud object variant is invalid.');
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
