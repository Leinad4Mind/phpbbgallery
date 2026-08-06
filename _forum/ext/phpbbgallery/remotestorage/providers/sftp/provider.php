<?php
/**
 * phpBB Gallery - Remote Storage Add-on
 *
 * @package   phpbbgallery/remotestorage
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\remotestorage\providers\sftp;

use phpbbgallery\core\storage\provider_interface;

final class provider implements provider_interface
{
	public function __construct(private configuration $configuration, private client_interface $client)
	{
	}

	public function get_id(): string
 {
 return 'sftp'; }

	public function prepare(string $variant, string $key): bool
	{
		$path = $this->configuration->object_path($variant, $key);

		return $this->client->ensure_directory(str_replace('\\', '/', dirname($path)));
	}

	public function write(string $variant, string $key, string $local_file): bool
	{
		return $this->valid_local($local_file)
			&& $this->client->upload($this->configuration->object_path($variant, $key), $local_file, true);
	}

	public function replace(string $variant, string $key, string $local_file): bool
	{
		$path = $this->configuration->object_path($variant, $key);

		return $this->valid_local($local_file) && $this->client->stat($path) !== null
			&& $this->client->upload($path, $local_file, false);
	}

	public function open_stream(string $variant, string $key): mixed
	{
		return $this->client->open_read($this->configuration->object_path($variant, $key));
	}

	public function local_path(string $variant, string $key): ?string
	{
		$this->configuration->object_path($variant, $key);

		return null;
	}

	public function exists(string $variant, string $key): bool
	{
		return $this->metadata($variant, $key) !== null;
	}

	public function delete(string $variant, string $key): bool
	{
		return $this->client->delete($this->configuration->object_path($variant, $key));
	}

	public function size(string $variant, string $key): ?int
	{
		return $this->metadata($variant, $key)['size'] ?? null;
	}

	public function modified_time(string $variant, string $key): ?int
	{
		return $this->metadata($variant, $key)['mtime'] ?? null;
	}

	public function checksum(string $variant, string $key, string $algorithm = 'sha256'): ?string
	{
		if ($algorithm !== 'sha256')
		{
			return null;
		}
		$stream = $this->open_stream($variant, $key);
		if (!is_resource($stream))
		{
			return null;
		}
		try
		{
			$context = hash_init('sha256');
			if (hash_update_stream($context, $stream) === false)
			{
				return null;
			}

			return hash_final($context);
		}
		finally
		{
			fclose($stream);
		}
	}

	public function list_objects(string $variant, ?string $cursor = null, int $limit = 500): array
	{
		if ($cursor !== null && !$this->valid_cursor($cursor))
		{
			throw new \InvalidArgumentException('The SFTP object cursor is invalid.');
		}
		$limit = max(1, min(5000, $limit));
		$keys = [];
		$has_more = false;
		foreach ($this->client->list_files($this->configuration->variant_root($variant)) as $key)
		{
			if (!$this->valid_cursor($key))
			{
				throw new \RuntimeException('The SFTP server returned an invalid Gallery object key.');
			}
			if ($cursor !== null && strcmp($key, $cursor) <= 0)
			{
				continue;
			}
			if (count($keys) === $limit)
			{
				$has_more = true;
				break;
			}
			$keys[] = $key;
		}

		return ['keys' => $keys, 'cursor' => $has_more ? end($keys) : null];
	}

	/** @return array{size: int, mtime: int}|null */
	private function metadata(string $variant, string $key): ?array
	{
		return $this->client->stat($this->configuration->object_path($variant, $key));
	}

	private function valid_local(string $path): bool
	{
		return is_file($path) && !is_link($path) && is_readable($path);
	}

	private function valid_cursor(string $key): bool
	{
		return $key !== '' && strlen($key) <= 1024 && !str_starts_with($key, '/')
			&& !str_contains($key, '\\') && preg_match('/[\x00-\x1f\x7f]/', $key) !== 1
			&& !in_array('..', explode('/', $key), true);
	}
}
