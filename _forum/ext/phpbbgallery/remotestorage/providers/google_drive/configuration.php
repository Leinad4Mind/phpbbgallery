<?php
/**
 * phpBB Gallery - Remote Storage Add-on
 *
 * @package   phpbbgallery/remotestorage
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\remotestorage\providers\google_drive;

/** Validated Google OAuth credentials and dedicated Drive root name. */
final class configuration
{
	public function __construct(
		private string $client_id,
		private string $client_secret,
		private string $refresh_token,
		private string $root_name = 'phpbbgallery'
	)
	{
		foreach ([$client_id, $client_secret, $refresh_token] as $credential)
		{
			if ($credential === '' || strlen($credential) > 4096 || preg_match('/[\x00-\x1f\x7f]/', $credential))
			{
				throw new \InvalidArgumentException('A Google Drive credential is invalid.');
			}
		}
		if ($root_name === '' || strlen($root_name) > 255
			|| preg_match('/[\x00-\x1f\x7f\/\\\\]/', $root_name))
		{
			throw new \InvalidArgumentException('The Google Drive root folder name is invalid.');
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

	public function refresh_token(): string
	{
		return $this->refresh_token;
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
			throw new \InvalidArgumentException('The Google Drive object key is invalid.');
		}

		return $key;
	}

	public function variant_name(string $variant): string
	{
		$this->assert_variant($variant);

		return $variant;
	}

	public function relative_key(string $variant, string $name): ?string
	{
		$this->assert_variant($variant);

		return $this->valid_key($name) ? $name : null;
	}

	public function query_literal(string $value): string
	{
		if ($value === '' || strlen($value) > 4096 || preg_match('/[\x00-\x1f\x7f]/', $value))
		{
			throw new \InvalidArgumentException('A Google Drive query value is invalid.');
		}

		return str_replace(['\\', chr(39)], ['\\\\', '\\' . chr(39)], $value);
	}

	public function assert_file_id(string $file_id): string
	{
		if (preg_match('/^[A-Za-z0-9_-]{10,200}$/D', $file_id) !== 1)
		{
			throw new \RuntimeException('Google Drive returned an invalid file identifier.');
		}

		return $file_id;
	}

	private function assert_variant(string $variant): void
	{
		if (!in_array($variant, [
			\phpbbgallery\core\storage\provider_interface::SOURCE,
			\phpbbgallery\core\storage\provider_interface::MEDIUM,
			\phpbbgallery\core\storage\provider_interface::MINI,
		], true))
		{
			throw new \InvalidArgumentException('The Google Drive object variant is invalid.');
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
