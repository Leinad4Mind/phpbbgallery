<?php
/**
 * phpBB Gallery - Remote Storage Add-on
 *
 * @package   phpbbgallery/remotestorage
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\remotestorage\providers\box;

/** Validated Box OAuth application settings and private folder naming. */
final class configuration
{
	public function __construct(
		private string $client_id,
		private string $client_secret,
		private string $root_name = 'phpbbgallery'
	)
	{
		foreach ([$client_id, $client_secret] as $credential)
		{
			if ($credential === '' || strlen($credential) > 4096
				|| preg_match('/[\x00-\x1f\x7f]/', $credential))
			{
				throw new \InvalidArgumentException('A Box OAuth credential is invalid.');
			}
		}
		if ($root_name === '' || strlen($root_name) > 255
			|| trim($root_name) !== $root_name || in_array($root_name, ['.', '..'], true)
			|| preg_match('/[\x00-\x1f\x7f\/\\\\<>\x22|?*]/', $root_name))
		{
			throw new \InvalidArgumentException('The Box root folder name is invalid.');
		}
	}

	public function client_id(): string
	{
		return $this->client_id;
	}

	public function client_secret(): string
	{
		return $this->client_secret;
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
			throw new \InvalidArgumentException('The Box object key is invalid.');
		}
		$name = 'g_' . bin2hex($key);
		if (strlen($name) > 255)
		{
			throw new \InvalidArgumentException('The Box object key exceeds the provider name limit.');
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

	public function assert_item_id(string $item_id): string
	{
		if (preg_match('/^[0-9]{1,30}$/D', $item_id) !== 1)
		{
			throw new \RuntimeException('Box returned an invalid item identifier.');
		}

		return $item_id;
	}

	private function assert_variant(string $variant): void
	{
		if (!in_array($variant, [
			\phpbbgallery\core\storage\provider_interface::SOURCE,
			\phpbbgallery\core\storage\provider_interface::MEDIUM,
			\phpbbgallery\core\storage\provider_interface::MINI,
		], true))
		{
			throw new \InvalidArgumentException('The Box object variant is invalid.');
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
