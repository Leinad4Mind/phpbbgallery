<?php
/**
 * phpBB Gallery - Remote Storage Add-on
 *
 * @package   phpbbgallery/remotestorage
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\remotestorage\mediafire;

/** Validated MediaFire application, account and private folder settings. */
final class configuration
{
	public function __construct(
		private string $application_id,
		private string $api_key,
		private string $email,
		private string $password,
		private string $root_name = 'phpbbgallery'
	)
	{
		if (preg_match('/^[1-9][0-9]{0,19}$/D', $application_id) !== 1)
		{
			throw new \InvalidArgumentException('The MediaFire application ID is invalid.');
		}
		foreach ([$api_key, $password] as $credential)
		{
			if ($credential === '' || strlen($credential) > 4096
				|| preg_match('/[\x00-\x1f\x7f]/', $credential))
			{
				throw new \InvalidArgumentException('A MediaFire credential is invalid.');
			}
		}
		if ($email === '' || strlen($email) > 254 || filter_var($email, FILTER_VALIDATE_EMAIL) === false
			|| preg_match('/[\x00-\x1f\x7f]/', $email))
		{
			throw new \InvalidArgumentException('The MediaFire account email is invalid.');
		}
		if ($root_name === '' || strlen($root_name) > 255 || trim($root_name) !== $root_name
			|| in_array($root_name, ['.', '..'], true)
			|| preg_match('/[\x00-\x1f\x7f\/\\\\<>\x22|?*]/', $root_name))
		{
			throw new \InvalidArgumentException('The MediaFire root folder name is invalid.');
		}
	}

	public function application_id(): string
	{
		return $this->application_id;
	}

	public function api_key(): string
	{
		return $this->api_key;
	}

	public function email(): string
	{
		return $this->email;
	}

	public function password(): string
	{
		return $this->password;
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
			throw new \InvalidArgumentException('The MediaFire object key is invalid.');
		}
		$name = 'g_' . bin2hex($key);
		if (strlen($name) < 3 || strlen($name) > 255)
		{
			throw new \InvalidArgumentException('The MediaFire object key exceeds the provider name limit.');
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

	public function assert_folder_key(string $key): string
	{
		if (preg_match('/^[A-Za-z0-9]{1,64}$/D', $key) !== 1)
		{
			throw new \RuntimeException('MediaFire returned an invalid folder key.');
		}

		return $key;
	}

	public function assert_quickkey(string $key): string
	{
		if (preg_match('/^[A-Za-z0-9]{1,64}$/D', $key) !== 1)
		{
			throw new \RuntimeException('MediaFire returned an invalid file key.');
		}

		return $key;
	}

	private function assert_variant(string $variant): void
	{
		if (!in_array($variant, [
			\phpbbgallery\core\storage\provider_interface::SOURCE,
			\phpbbgallery\core\storage\provider_interface::MEDIUM,
			\phpbbgallery\core\storage\provider_interface::MINI,
		], true))
		{
			throw new \InvalidArgumentException('The MediaFire object variant is invalid.');
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
