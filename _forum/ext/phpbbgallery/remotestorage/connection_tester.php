<?php
/**
 * phpBB Gallery - Remote Storage Add-on
 *
 * @package   phpbbgallery/remotestorage
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\remotestorage;

use phpbbgallery\core\storage\provider_interface;

/** Verify every storage operation required by a controlled provider migration. */
final class connection_tester
{
	public function test(provider_interface $provider): void
	{
		$contents = random_bytes(64);
		$key = '.connection-test-' . bin2hex(random_bytes(16)) . '.bin';
		$local_file = tempnam(sys_get_temp_dir(), 'phpbbgallery-storage-');
		if ($local_file === false)
		{
			throw new \RuntimeException('Unable to create the local remote-storage connection test file.');
		}
		if (file_put_contents($local_file, $contents) !== strlen($contents))
		{
			unlink($local_file);
			throw new \RuntimeException('Unable to write the local remote-storage connection test file.');
		}

		$written = false;
		try
		{
			if (!$provider->prepare(provider_interface::SOURCE, $key))
			{
				throw new \RuntimeException('The remote-storage provider could not be prepared.');
			}
			$provider->list_objects(provider_interface::SOURCE, null, 1);
			if (!$provider->write(provider_interface::SOURCE, $key, $local_file))
			{
				throw new \RuntimeException('The remote-storage connection test object could not be written.');
			}
			$written = true;
			if ($provider->size(provider_interface::SOURCE, $key) !== strlen($contents)
				|| $provider->checksum(provider_interface::SOURCE, $key) !== hash('sha256', $contents))
			{
				throw new \RuntimeException('The remote-storage connection test object could not be verified.');
			}

			$stream = $provider->open_stream(provider_interface::SOURCE, $key);
			if (!is_resource($stream))
			{
				throw new \RuntimeException('The remote-storage connection test object could not be read.');
			}
			try
			{
				$downloaded = stream_get_contents($stream, strlen($contents) + 1);
			}
			finally
			{
				fclose($stream);
			}
			if (!is_string($downloaded) || !hash_equals($contents, $downloaded))
			{
				throw new \RuntimeException('The remote-storage connection test object content did not match.');
			}
		}
		finally
		{
			if ($written && !$provider->delete(provider_interface::SOURCE, $key))
			{
					throw new \RuntimeException('The remote-storage connection test object could not be deleted.');
			}
			unlink($local_file);
		}

		if ($provider->exists(provider_interface::SOURCE, $key))
		{
			throw new \RuntimeException('The remote-storage connection test object still exists after deletion.');
		}
	}
}
