<?php
/**
 * phpBB Gallery - Core Extension
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\storage;

/** Materialize provider objects in a private local workspace when required. */
final class workspace
{
	private provider_interface $storage;
	private string $root;

	public function __construct(provider_interface $storage, string $root)
	{
		$this->storage = $storage;
		$this->root = rtrim(str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $root), DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
	}

	public function materialize(string $variant, string $key): local_object
	{
		$local_path = $this->storage->local_path($variant, $key);
		if ($local_path !== null && is_file($local_path) && !is_link($local_path) && is_readable($local_path))
		{
			return new local_object($local_path, false);
		}

		$stream = $this->storage->open_stream($variant, $key);
		if (!is_resource($stream))
		{
			throw new \RuntimeException('The Gallery storage object is unavailable.');
		}

		$path = '';
		try
		{
			$path = $this->create_path($key);
			$destination = @fopen($path, 'xb');
			if ($destination === false)
			{
				throw new \RuntimeException('The Gallery storage workspace file could not be created.');
			}

			$bytes = stream_copy_to_stream($stream, $destination);
			$flushed = fflush($destination);
			fclose($destination);
			@chmod($path, 0600);
			if ($bytes === false || !$flushed || !$this->verify($variant, $key, $path, (int) $bytes))
			{
				throw new \RuntimeException('The Gallery storage object failed local verification.');
			}
		}
		catch (\Throwable $exception)
		{
			if ($path !== '' && is_file($path) && !is_link($path))
			{
				@unlink($path);
			}
			throw $exception;
		}
		finally
		{
			fclose($stream);
		}

		return new local_object($path, true);
	}

	/** Publish a new object and verify that the provider stored the complete file. */
	public function publish(string $variant, string $key, string $local_file): void
	{
		$this->assert_local_file($local_file);
		if ($this->storage->exists($variant, $key))
		{
			throw new \RuntimeException('The Gallery storage object already exists.');
		}

		$written = $this->storage->prepare($variant, $key)
			&& $this->storage->write($variant, $key, $local_file);
		if (!$written || !$this->verify_published($variant, $key, $local_file))
		{
			if ($written || $this->storage->exists($variant, $key))
			{
				$this->storage->delete($variant, $key);
			}
			throw new \RuntimeException('The Gallery storage object could not be published safely.');
		}
	}

	/** Replace an existing object and verify the resulting provider contents. */
	public function replace(string $variant, string $key, string $local_file): void
	{
		$this->assert_local_file($local_file);
		if (!$this->storage->exists($variant, $key)
			|| !$this->storage->replace($variant, $key, $local_file)
			|| !$this->verify_published($variant, $key, $local_file))
		{
			throw new \RuntimeException('The Gallery storage object could not be replaced safely.');
		}
	}

	public function delete(string $variant, string $key): bool
	{
		return $this->storage->delete($variant, $key);
	}

	private function create_path(string $key): string
	{
		if ((file_exists($this->root) && (!is_dir($this->root) || is_link($this->root)))
			|| (!is_dir($this->root) && !@mkdir($this->root, 0700, true)))
		{
			throw new \RuntimeException('The Gallery storage workspace is unavailable.');
		}
		@chmod($this->root, 0700);

		$extension = strtolower((string) pathinfo(basename($key), PATHINFO_EXTENSION));
		$extension = preg_match('/^[a-z0-9]{1,10}$/D', $extension) === 1 ? '.' . $extension : '.bin';

		try
		{
			$name = bin2hex(random_bytes(16)) . $extension;
		}
		catch (\Throwable)
		{
			throw new \RuntimeException('A secure Gallery workspace filename could not be generated.');
		}

		return $this->root . $name;
	}

	private function verify(string $variant, string $key, string $path, int $copied_bytes): bool
	{
		$expected_size = $this->storage->size($variant, $key);
		if ($expected_size !== null && $expected_size !== $copied_bytes)
		{
			return false;
		}

		$expected_checksum = $this->storage->checksum($variant, $key);
		if ($expected_checksum === null)
		{
			return true;
		}
		$actual_checksum = @hash_file('sha256', $path);

		return $actual_checksum !== false && hash_equals($expected_checksum, $actual_checksum);
	}

	private function assert_local_file(string $local_file): void
	{
		if (!is_file($local_file) || is_link($local_file) || !is_readable($local_file))
		{
			throw new \RuntimeException('The Gallery storage publication source is invalid.');
		}
	}

	private function verify_published(string $variant, string $key, string $local_file): bool
	{
		$local_size = @filesize($local_file);
		$remote_size = $this->storage->size($variant, $key);
		if ($local_size === false || $remote_size === null || (int) $local_size !== $remote_size)
		{
			return false;
		}

		$local_checksum = @hash_file('sha256', $local_file);
		$remote_checksum = $this->storage->checksum($variant, $key);

		return $local_checksum !== false && $remote_checksum !== null
			&& hash_equals($local_checksum, $remote_checksum);
	}
}
