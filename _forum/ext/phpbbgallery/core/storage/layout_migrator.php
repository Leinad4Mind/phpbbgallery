<?php
/**
 * phpBB Gallery - Core Extension
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\storage;

/** Safely migrates Gallery objects from the legacy flat layout. */
class layout_migrator
{
	private \phpbb\db\driver\driver_interface $db;
	private key_generator $keys;
	private local_provider $storage;
	private string $images_table;
	private variant_key $variant_key;

	public function __construct(
		\phpbb\db\driver\driver_interface $db,
		key_generator $keys,
		local_provider $storage,
		string $images_table,
		?variant_key $variant_key = null
	)
	{
		$this->db = $db;
		$this->keys = $keys;
		$this->storage = $storage;
		$this->images_table = $images_table;
		$this->variant_key = $variant_key ?? new variant_key();
	}

	/**
	 * Count database keys by layout without changing files.
	 *
	 * @return array{total: int, distributed: int, pending: int, invalid: int}
	 */
	public function status(): array
	{
		$status = [
			'total' => 0,
			'distributed' => 0,
			'pending' => 0,
			'invalid' => 0,
		];
		$sql = 'SELECT image_filename
			FROM ' . $this->images_table;
		$result = $this->db->sql_query($sql);
		while ($row = $this->db->sql_fetchrow($result))
		{
			$status['total']++;
			$status[$this->classify((string) $row['image_filename'])]++;
		}
		$this->db->sql_freeresult($result);

		return $status;
	}

	/**
	 * Migrate one bounded page of image records.
	 *
	 * @return array{processed: int, migrated: int, skipped: int, failed: int, last_id: int, has_more: bool}
	 */
	public function migrate_batch(int $after_id = 0, int $limit = 25): array
	{
		$limit = max(1, min(100, $limit));
		$sql = 'SELECT image_id, image_filename
			FROM ' . $this->images_table . '
			WHERE image_id > ' . max(0, $after_id) . '
			ORDER BY image_id ASC';
		$result = $this->db->sql_query_limit($sql, $limit);
		$rows = [];
		while ($row = $this->db->sql_fetchrow($result))
		{
			$rows[] = $row;
		}
		$this->db->sql_freeresult($result);

		$summary = [
			'processed' => count($rows),
			'migrated' => 0,
			'skipped' => 0,
			'failed' => 0,
			'last_id' => $after_id,
			'has_more' => count($rows) === $limit,
		];
		foreach ($rows as $row)
		{
			$summary['last_id'] = (int) $row['image_id'];
			$summary[$this->migrate_image((int) $row['image_id'], (string) $row['image_filename'])]++;
		}

		return $summary;
	}

	private function classify(string $key): string
	{
		try
		{
			$expected = $this->keys->create(basename($key));
		}
		catch (\InvalidArgumentException)
		{
			return 'invalid';
		}

		if ($key === $expected)
		{
			return 'distributed';
		}

		return $key === basename($key) ? 'pending' : 'invalid';
	}

	private function migrate_image(int $image_id, string $old_key): string
	{
		$classification = $this->classify($old_key);
		if ($classification === 'distributed')
		{
			return 'skipped';
		}

		if ($classification !== 'pending')
		{
			return 'failed';
		}

		try
		{
			$new_key = $this->keys->create($old_key);
		}
		catch (\InvalidArgumentException)
		{
			return 'failed';
		}

		if (!$this->storage->exists(provider_interface::SOURCE, $old_key))
		{
			return 'failed';
		}

		$created = [];
		foreach ([provider_interface::SOURCE, provider_interface::MEDIUM, provider_interface::MINI] as $variant)
		{
			foreach ([
				[$this->variant_key->resolve($variant, $old_key), $this->variant_key->resolve($variant, $new_key)],
				[$this->variant_key->resolve($variant, $this->watermark_key($old_key)), $this->variant_key->resolve($variant, $this->watermark_key($new_key))],
			] as [$old_object, $new_object])
			{
				if (!$this->storage->exists($variant, $old_object))
				{
					continue;
				}

				if (!$this->copy_verified($variant, $old_object, $new_object, $created))
				{
					$this->rollback($created);
					return 'failed';
				}
			}
		}

		$sql_ary = ['image_filename' => $new_key];
		$sql = 'UPDATE ' . $this->images_table . '
			SET ' . $this->db->sql_build_array('UPDATE', $sql_ary) . '
			WHERE image_id = ' . (int) $image_id . '
				AND ' . $this->db->sql_in_set('image_filename', $old_key);
		$this->db->sql_query($sql);
		if ($this->db->sql_affectedrows() !== 1)
		{
			$this->rollback($created);
			return 'failed';
		}

		foreach ([provider_interface::SOURCE, provider_interface::MEDIUM, provider_interface::MINI] as $variant)
		{
			$this->storage->delete($variant, $this->variant_key->resolve($variant, $old_key));
			$this->storage->delete($variant, $this->variant_key->resolve($variant, $this->watermark_key($old_key)));
		}

		return 'migrated';
	}

	private function copy_verified(string $variant, string $old_key, string $new_key, array &$created): bool
	{
		$old_size = $this->storage->size($variant, $old_key);
		$old_checksum = $this->storage->checksum($variant, $old_key);
		if ($old_size === null || $old_checksum === null)
		{
			return false;
		}

		if ($this->storage->exists($variant, $new_key))
		{
			return $this->storage->size($variant, $new_key) === $old_size
				&& hash_equals($old_checksum, (string) $this->storage->checksum($variant, $new_key));
		}

		$source_path = $this->storage->local_path($variant, $old_key);
		if ($source_path === null || !$this->storage->write($variant, $new_key, $source_path))
		{
			return false;
		}
		$created[] = [$variant, $new_key];

		return $this->storage->size($variant, $new_key) === $old_size
			&& hash_equals($old_checksum, (string) $this->storage->checksum($variant, $new_key));
	}

	private function rollback(array $created): void
	{
		foreach (array_reverse($created) as [$variant, $key])
		{
			$this->storage->delete($variant, $key);
		}
	}

	private function watermark_key(string $key): string
	{
		$dot = strrpos($key, '.');

		return $dot === false ? $key . '_wm' : substr_replace($key, '_wm', $dot, 0);
	}
}
