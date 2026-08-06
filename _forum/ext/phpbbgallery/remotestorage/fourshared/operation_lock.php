<?php
/**
 * phpBB Gallery - Remote Storage Add-on
 *
 * @package   phpbbgallery/remotestorage
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\remotestorage\fourshared;

/** Serialize non-conditional 4shared mutations within one phpBB installation. */
final class operation_lock
{
	private bool $locked = false;

	public function __construct(private string $path)
	{
		if ($path === '' || str_contains($path, chr(0)))
		{
			throw new \InvalidArgumentException('The 4shared operation lock path is invalid.');
		}
	}

	public function synchronized(callable $operation): mixed
	{
		if ($this->locked)
		{
			return $operation();
		}
		$directory = dirname($this->path);
		if (!is_dir($directory) && !mkdir($directory, 0700, true) && !is_dir($directory))
		{
			throw new \RuntimeException('Could not create the 4shared operation lock directory.');
		}
		$handle = fopen($this->path, 'c+b');
		if ($handle === false || !flock($handle, LOCK_EX))
		{
			if (is_resource($handle))
			{
				fclose($handle);
			}
			throw new \RuntimeException('Could not acquire the 4shared operation lock.');
		}
		$this->locked = true;
		try
		{
			return $operation();
		}
		finally
		{
			$this->locked = false;
			flock($handle, LOCK_UN);
			fclose($handle);
		}
	}
}
