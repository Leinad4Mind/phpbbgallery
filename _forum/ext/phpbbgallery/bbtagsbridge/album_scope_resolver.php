<?php
/**
 * Resolves a Gallery album followed by its ancestors for BBTags policies.
 *
 * @package   phpbbgallery/bbtagsbridge
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\bbtagsbridge;

use phpbb\db\driver\driver_interface;

final class album_scope_resolver
{
	private const MAX_DEPTH = 100;

	private driver_interface $db;
	private string $albums_table;

	public function __construct(driver_interface $db, string $albums_table)
	{
		$this->db = $db;
		$this->albums_table = $albums_table;
	}

	/**
	 * @return int[] Current album, its ancestors and the provider root zero.
	 */
	public function get_path(int $album_id): array
	{
		if ($album_id <= 0)
		{
			return [];
		}

		$path = [];
		$visited = [];
		$current_id = $album_id;
		while ($current_id > 0 && count($path) < self::MAX_DEPTH)
		{
			if (isset($visited[$current_id]))
			{
				return [];
			}
			$visited[$current_id] = true;
			$sql = 'SELECT parent_id
				FROM ' . $this->albums_table . '
				WHERE album_id = ' . $current_id;
			$result = $this->db->sql_query_limit($sql, 1);
			$row = $this->db->sql_fetchrow($result);
			$this->db->sql_freeresult($result);
			if (!$row)
			{
				return [];
			}
			$path[] = $current_id;
			$current_id = max(0, (int) $row['parent_id']);
		}
		if ($current_id > 0)
		{
			return [];
		}
		$path[] = 0;

		return $path;
	}

	/**
	 * Return every valid album path indexed by its album identifier.
	 *
	 * @return array<int, int[]>
	 */
	public function get_all_paths(): array
	{
		$sql = 'SELECT album_id, parent_id
			FROM ' . $this->albums_table . '
			ORDER BY album_id ASC';
		$result = $this->db->sql_query($sql);
		$parents = [];
		while ($row = $this->db->sql_fetchrow($result))
		{
			$parents[(int) $row['album_id']] = max(0, (int) $row['parent_id']);
		}
		$this->db->sql_freeresult($result);

		$paths = [];
		foreach (array_keys($parents) as $album_id)
		{
			$path = [];
			$visited = [];
			$current_id = $album_id;
			while ($current_id > 0 && count($path) < self::MAX_DEPTH)
			{
				if (isset($visited[$current_id]) || !array_key_exists($current_id, $parents))
				{
					$path = [];
					break;
				}
				$visited[$current_id] = true;
				$path[] = $current_id;
				$current_id = $parents[$current_id];
			}
			if (!empty($path) && $current_id === 0)
			{
				$path[] = 0;
				$paths[$album_id] = $path;
			}
		}

		return $paths;
	}
}
