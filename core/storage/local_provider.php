<?php
/**
 * phpBB Gallery - Core Extension
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\storage;

/** Local filesystem storage provider. */
class local_provider implements provider_interface
{
	private array $roots;

	public function __construct(string $source_root, string $medium_root, string $mini_root)
	{
		$this->roots = [
			self::SOURCE => $this->normalize_root($source_root),
			self::MEDIUM => $this->normalize_root($medium_root),
			self::MINI => $this->normalize_root($mini_root),
		];
	}

	public function get_id(): string
	{
		return 'local';
	}

	public function prepare(string $variant, string $key): bool
	{
		if (!isset($this->roots[$variant]))
		{
			return false;
		}

		$normalized_key = $this->normalize_key($key);
		if ($normalized_key === null)
		{
			return false;
		}

		$current = rtrim($this->roots[$variant], DIRECTORY_SEPARATOR);
		if ((file_exists($current) && (!is_dir($current) || is_link($current)))
			|| (!is_dir($current) && !@mkdir($current, 0755, true)))
		{
			return false;
		}

		$segments = explode('/', $normalized_key);
		array_pop($segments);
		foreach ($segments as $segment)
		{
			$current .= DIRECTORY_SEPARATOR . $segment;
			if (is_link($current) || (file_exists($current) && !is_dir($current))
				|| (!is_dir($current) && !@mkdir($current, 0755)))
			{
				return false;
			}
		}

		return true;
	}

	public function write(string $variant, string $key, string $local_file): bool
	{
		$destination = $this->resolve_path($variant, $key);
		if ($destination === null || !is_file($local_file) || is_link($local_file) || !$this->prepare($variant, $key))
		{
			return false;
		}

		if (file_exists($destination))
		{
			return false;
		}

		try
		{
			$temporary = $destination . '.part-' . bin2hex(random_bytes(8));
		}
		catch (\Throwable)
		{
			return false;
		}

		if (!@copy($local_file, $temporary))
		{
			@unlink($temporary);
			return false;
		}

		@chmod($temporary, 0644);
		if (file_exists($destination) || !@rename($temporary, $destination))
		{
			@unlink($temporary);
			return false;
		}

		return true;
	}

	public function open_stream(string $variant, string $key): mixed
	{
		$path = $this->existing_path($variant, $key);

		return $path === null ? false : @fopen($path, 'rb');
	}

	public function local_path(string $variant, string $key): ?string
	{
		return $this->resolve_path($variant, $key);
	}

	public function exists(string $variant, string $key): bool
	{
		return $this->existing_path($variant, $key) !== null;
	}

	public function delete(string $variant, string $key): bool
	{
		$path = $this->existing_path($variant, $key);

		return $path === null || @unlink($path);
	}

	public function size(string $variant, string $key): ?int
	{
		$path = $this->existing_path($variant, $key);
		$size = $path === null ? false : @filesize($path);

		return $size === false ? null : (int) $size;
	}

	public function modified_time(string $variant, string $key): ?int
	{
		$path = $this->existing_path($variant, $key);
		$modified_time = $path === null ? false : @filemtime($path);

		return $modified_time === false ? null : (int) $modified_time;
	}

	public function checksum(string $variant, string $key, string $algorithm = 'sha256'): ?string
	{
		if (!in_array($algorithm, hash_algos(), true))
		{
			return null;
		}

		$path = $this->existing_path($variant, $key);
		$checksum = $path === null ? false : @hash_file($algorithm, $path);

		return $checksum === false ? null : $checksum;
	}

	private function existing_path(string $variant, string $key): ?string
	{
		$path = $this->resolve_path($variant, $key);

		return $path !== null && is_file($path) && !is_link($path) ? $path : null;
	}

	private function resolve_path(string $variant, string $key): ?string
	{
		if (!isset($this->roots[$variant]))
		{
			return null;
		}

		$normalized_key = $this->normalize_key($key);
		if ($normalized_key === null)
		{
			return null;
		}

		return $this->roots[$variant] . str_replace('/', DIRECTORY_SEPARATOR, $normalized_key);
	}

	private function normalize_key(string $key): ?string
	{
		if ($key === '' || strlen($key) > 255 || strpos($key, "\0") !== false || strpos($key, '\\') !== false
			|| $key[0] === '/' || preg_match('/^[a-z]:/i', $key))
		{
			return null;
		}

		$segments = explode('/', $key);
		foreach ($segments as $segment)
		{
			if ($segment === '' || in_array($segment, ['.', '..'], true)
				|| preg_match('/^[a-z0-9][a-z0-9._-]*$/iD', $segment) !== 1)
			{
				return null;
			}
		}

		return implode('/', $segments);
	}

	private function normalize_root(string $root): string
	{
		return rtrim(str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $root), DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
	}
}
