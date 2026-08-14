<?php
/**
 * phpBB Gallery - EXIF tracking storage provider
 *
 * @package   phpbbgallery/exif
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\exif\tests;

final class exif_tracking_provider implements \phpbbgallery\core\storage\provider_interface
{
	public int $local_path_calls = 0;

	public function __construct(private string $source_path)
	{
	}

	public function get_id(): string
	{
		return 'test';
	}

	public function prepare(string $variant, string $key): bool
	{
		return true;
	}

	public function write(string $variant, string $key, string $local_file): bool
	{
		return true;
	}

	public function replace(string $variant, string $key, string $local_file): bool
	{
		return true;
	}

	public function open_stream(string $variant, string $key): mixed
	{
		return false;
	}

	public function local_path(string $variant, string $key): ?string
	{
		$this->local_path_calls++;

		return $this->source_path;
	}

	public function exists(string $variant, string $key): bool
	{
		return true;
	}

	public function delete(string $variant, string $key): bool
	{
		return true;
	}

	public function size(string $variant, string $key): ?int
	{
		return filesize($this->source_path);
	}

	public function modified_time(string $variant, string $key): ?int
	{
		return filemtime($this->source_path);
	}

	public function list_objects(string $variant, ?string $cursor = null, int $limit = 500): array
	{
		return ['keys' => [], 'cursor' => null];
	}

	public function checksum(string $variant, string $key, string $algorithm = 'sha256'): ?string
	{
		return hash_file($algorithm, $this->source_path);
	}
}
