<?php
/**
 *
 * @package Auto db Backup
 * @copyright (c) 2015 david63
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace leinad4mind\autodbbackup\core;

use phpbb\config\db_text;
use phpbb\filesystem\filesystem;

/**
 * Tracks backup files owned by this extension and prunes only those files.
 */
class backup_registry
{
	const CONFIG_KEY = 'auto_db_backup_manifest';

	/** @var db_text */
	protected $config_text;

	/** @var filesystem */
	protected $filesystem;

	/**
	 * @param db_text   $config_text Arbitrary-length configuration storage
	 * @param filesystem $filesystem phpBB filesystem service
	 */
	public function __construct(db_text $config_text, filesystem $filesystem)
	{
		$this->config_text = $config_text;
		$this->filesystem = $filesystem;
	}

	/**
	 * Record a successfully published backup.
	 *
	 * @param string $location Backup directory
	 * @param string $filename Backup filename
	 * @param int    $created_at Completion timestamp
	 *
	 * @return array Recorded metadata
	 */
	public function record($location, $filename, $created_at)
	{
		$path = $this->resolve_owned_file($location, $filename);
		$size = filesize($path);
		$checksum = hash_file('sha256', $path);

		if ($size === false || $size <= 0 || $checksum === false)
		{
			throw new \RuntimeException('AUTO_DB_BACKUP_VERIFY_FAILED');
		}

		$entries = $this->load();
		$entries[$filename] = array(
			'created_at' => (int) $created_at,
			'size'       => (int) $size,
			'sha256'     => $checksum,
		);
		$this->save($entries);

		return $entries[$filename];
	}

	/**
	 * Delete old files recorded as owned by this extension.
	 *
	 * @param string $location Backup directory
	 * @param int    $copies Number of copies to retain; zero disables pruning
	 *
	 * @return array Deleted filenames
	 */
	public function prune($location, $copies)
	{
		if ($copies < 0)
		{
			throw new \InvalidArgumentException('AUTO_DB_BACKUP_COPIES_ERROR');
		}

		$entries = $this->load();

		foreach (array_keys($entries) as $filename)
		{
			if (!is_file($this->join_path($location, $filename)))
			{
				unset($entries[$filename]);
			}
		}

		if ($copies === 0)
		{
			$this->save($entries);

			return array();
		}

		uasort($entries, function (array $first, array $second)
		{
			return $second['created_at'] <=> $first['created_at'];
		});

		$deleted = array();
		$position = 0;
		foreach (array_keys($entries) as $filename)
		{
			$position++;
			if ($position <= $copies)
			{
				continue;
			}

			$path = $this->resolve_owned_file($location, $filename);
			$this->filesystem->remove($path);
			unset($entries[$filename]);
			$deleted[] = $filename;
		}

		$this->save($entries);

		return $deleted;
	}

	/**
	 * Return the validated registry contents.
	 *
	 * @return array
	 */
	public function load()
	{
		$encoded = $this->config_text->get(self::CONFIG_KEY);
		$decoded = $encoded ? json_decode($encoded, true) : array();

		if (!is_array($decoded))
		{
			return array();
		}

		$entries = array();
		foreach ($decoded as $filename => $metadata)
		{
			if (!backup_policy::is_backup_filename($filename) || !is_array($metadata))
			{
				continue;
			}

			$entries[$filename] = array(
				'created_at' => isset($metadata['created_at']) ? (int) $metadata['created_at'] : 0,
				'size'       => isset($metadata['size']) ? (int) $metadata['size'] : 0,
				'sha256'     => isset($metadata['sha256']) ? (string) $metadata['sha256'] : '',
			);
		}

		return $entries;
	}

	/**
	 * Persist registry contents.
	 *
	 * @param array $entries Validated registry entries
	 */
	protected function save(array $entries)
	{
		$encoded = json_encode($entries, JSON_UNESCAPED_SLASHES);

		if ($encoded === false)
		{
			throw new \RuntimeException('AUTO_DB_BACKUP_MANIFEST_FAILED');
		}

		$this->config_text->set(self::CONFIG_KEY, $encoded);
	}

	/**
	 * Resolve a filename and prove that it is a regular file in the backup directory.
	 *
	 * @param string $location Backup directory
	 * @param string $filename Backup filename
	 *
	 * @return string Canonical file path
	 */
	protected function resolve_owned_file($location, $filename)
	{
		if (!backup_policy::is_backup_filename($filename) || basename($filename) !== $filename)
		{
			throw new \RuntimeException('AUTO_DB_BACKUP_INVALID_FILENAME');
		}

		$directory = $this->normalize_path($this->filesystem->realpath($location));
		$path = $this->normalize_path($this->filesystem->realpath($this->join_path($location, $filename)));

		if (!is_file($path) || $this->path_compare(dirname($path)) !== $this->path_compare($directory))
		{
			throw new \RuntimeException('AUTO_DB_BACKUP_INVALID_PATH');
		}

		return $path;
	}

	/**
	 * Normalize path separators and trailing slashes.
	 *
	 * @param string $path Filesystem path
	 *
	 * @return string
	 */
	protected function normalize_path($path)
	{
		return rtrim(str_replace('\\', '/', $path), '/');
	}

	/**
	 * @param string $location Directory
	 * @param string $filename Filename
	 *
	 * @return string
	 */
	protected function join_path($location, $filename)
	{
		return rtrim($location, '/\\') . DIRECTORY_SEPARATOR . $filename;
	}

	/**
	 * Normalize case for comparisons on Windows.
	 *
	 * @param string $path Filesystem path
	 *
	 * @return string
	 */
	protected function path_compare($path)
	{
		return DIRECTORY_SEPARATOR === '\\' ? strtolower($path) : $path;
	}
}
