<?php
/**
 * phpBB Gallery - Remote Storage Add-on
 *
 * @package   phpbbgallery/remotestorage
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\remotestorage\providers\koofr;

/** Validated Koofr WebDAV identity, app password and dedicated folder. */
final class configuration
{
	private const API_ROOT = 'https://app.koofr.net/dav/Koofr';

	public function __construct(
		private string $email,
		private string $app_password,
		private string $root_name = 'phpbbgallery'
	)
	{
		if ($email === '' || strlen($email) > 254 || str_contains($email, ':')
			|| filter_var($email, FILTER_VALIDATE_EMAIL) === false
			|| preg_match('/[\x00-\x20\x7f]/', $email))
		{
			throw new \InvalidArgumentException('The Koofr account email is invalid.');
		}
		if ($app_password === '' || strlen($app_password) > 4096
			|| preg_match('/[\x00-\x1f\x7f]/', $app_password))
		{
			throw new \InvalidArgumentException('The Koofr application password is invalid.');
		}
		if ($root_name === '' || strlen($root_name) > 255 || trim($root_name) !== $root_name
			|| in_array($root_name, ['.', '..'], true)
			|| preg_match('/[\x00-\x1f\x7f\/\\\\<>\x22|?*]/', $root_name))
		{
			throw new \InvalidArgumentException('The Koofr root folder name is invalid.');
		}
	}

	public function authorization(): string
	{
		return 'Basic ' . base64_encode($this->email . ':' . $this->app_password);
	}

	public function root_name(): string
	{
		return $this->root_name;
	}

	public function root_url(): string
	{
		return self::API_ROOT . '/' . rawurlencode($this->root_name);
	}

	public function variant_url(string $variant): string
	{
		$this->assert_variant($variant);

		return $this->root_url() . '/' . rawurlencode($variant);
	}

	public function object_url(string $variant, string $key): string
	{
		return $this->variant_url($variant) . '/' . rawurlencode($this->object_name($variant, $key));
	}

	public function object_name(string $variant, string $key): string
	{
		$this->assert_variant($variant);
		if (!$this->valid_key($key))
		{
			throw new \InvalidArgumentException('The Koofr object key is invalid.');
		}
		$name = 'g_' . bin2hex($key);
		if (strlen($name) > 255)
		{
			throw new \InvalidArgumentException('The Koofr object key exceeds the provider name limit.');
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

	private function assert_variant(string $variant): void
	{
		if (!in_array($variant, [
			\phpbbgallery\core\storage\provider_interface::SOURCE,
			\phpbbgallery\core\storage\provider_interface::MEDIUM,
			\phpbbgallery\core\storage\provider_interface::MINI,
		], true))
		{
			throw new \InvalidArgumentException('The Koofr object variant is invalid.');
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
