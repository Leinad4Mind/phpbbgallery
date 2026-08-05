<?php
/**
 * phpBB Gallery - Remote Storage Add-on
 *
 * @package   phpbbgallery/remotestorage
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\remotestorage\sftp;

/** Native PECL SSH2 client with pinned-host verification. */
final class native_client implements client_interface
{
	private mixed $session = null;
	private mixed $sftp = null;

	public function __construct(private configuration $configuration)
	{
	}

	public function ensure_directory(string $path): bool
	{
		$this->connect();
		if ($this->stat($path) !== null)
		{
			return true;
		}

		return @ssh2_sftp_mkdir($this->sftp, $path, 0700, true);
	}

	public function upload(string $remote_path, string $local_file, bool $create_only): bool
	{
		if ($create_only && $this->stat($remote_path) !== null)
		{
			return false;
		}
		$this->connect();
		$temporary = $remote_path . '.upload-' . bin2hex(random_bytes(12));
		$expected_size = filesize($local_file);
		if ($expected_size === false)
		{
			return false;
		}
		$input = @fopen($local_file, 'rb');
		$output = @fopen($this->uri($temporary), 'wb');
		if ($input === false || $output === false)
		{
			is_resource($input) && fclose($input);
			is_resource($output) && fclose($output);
			return false;
		}
		try
		{
			$copied = stream_copy_to_stream($input, $output);
		}
		finally
		{
			fclose($input);
			fclose($output);
		}
		if ($copied !== $expected_size || !@ssh2_sftp_rename($this->sftp, $temporary, $remote_path))
		{
			@ssh2_sftp_unlink($this->sftp, $temporary);
			return false;
		}

		return true;
	}

	public function open_read(string $path): mixed
	{
		$this->connect();

		return @fopen($this->uri($path), 'rb');
	}

	public function stat(string $path): ?array
	{
		$this->connect();
		$stat = @ssh2_sftp_stat($this->sftp, $path);
		if (!is_array($stat) || !isset($stat['size'], $stat['mtime']))
		{
			return null;
		}

		return ['size' => (int) $stat['size'], 'mtime' => (int) $stat['mtime']];
	}

	public function delete(string $path): bool
	{
		$this->connect();

		return $this->stat($path) === null || @ssh2_sftp_unlink($this->sftp, $path);
	}

	public function list_files(string $root): iterable
	{
		$this->connect();
		yield from $this->walk($root, '');
	}

	/** @return \Generator<int, string> */
	private function walk(string $directory, string $relative): \Generator
	{
		$handle = @opendir($this->uri($directory));
		if ($handle === false)
		{
			return;
		}
		$entries = [];
		try
		{
			while (($entry = readdir($handle)) !== false)
			{
				if ($entry !== '.' && $entry !== '..')
				{
					$entries[] = $entry;
				}
			}
		}
		finally
		{
			closedir($handle);
		}
		sort($entries, SORT_STRING);
		foreach ($entries as $entry)
		{
			$path = $directory . '/' . $entry;
			$name = $relative === '' ? $entry : $relative . '/' . $entry;
			$stat = @ssh2_sftp_lstat($this->sftp, $path);
			$mode = is_array($stat) ? (int) ($stat['mode'] ?? 0) : 0;
			if (($mode & 0170000) === 0040000)
			{
				yield from $this->walk($path, $name);
			}
			else if (($mode & 0170000) === 0100000)
			{
				yield $name;
			}
		}
	}

	private function connect(): void
	{
		if ($this->sftp !== null)
		{
			return;
		}
		if (!function_exists('ssh2_connect'))
		{
			throw new \RuntimeException('The PECL SSH2 extension is required for SFTP storage.');
		}
		$this->session = @ssh2_connect($this->configuration->host(), $this->configuration->port());
		if ($this->session === false)
		{
			throw new \RuntimeException('The SFTP server connection failed.');
		}
		$fingerprint = strtolower((string) ssh2_fingerprint(
			$this->session,
			SSH2_FINGERPRINT_SHA1 | SSH2_FINGERPRINT_HEX
		));
		if (!hash_equals($this->configuration->host_fingerprint(), $fingerprint))
		{
			throw new \RuntimeException('The SFTP server host fingerprint does not match.');
		}
		if (!@ssh2_auth_password($this->session, $this->configuration->username(), $this->configuration->password()))
		{
			throw new \RuntimeException('SFTP authentication failed.');
		}
		$this->sftp = @ssh2_sftp($this->session);
		if ($this->sftp === false)
		{
			throw new \RuntimeException('The SFTP subsystem could not be initialized.');
		}
	}

	private function uri(string $path): string
	{
		return 'ssh2.sftp://' . (int) $this->sftp . $path;
	}
}
