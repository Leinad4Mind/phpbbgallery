<?php
/**
 * phpBB Gallery - BBPoints Images policy resolver
 *
 * @package   phpbbgallery/bbpointsimages
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\bbpointsimages;

use phpbb\config\config;
use phpbb\db\driver\driver_interface;

/**
 * Resolve the nearest per-album points rule with a global fallback.
 */
final class policy
{
	public const INHERIT = -1;
	public const MAX_POINTS = 2147483647;

	public function __construct(
		private driver_interface $db,
		private config $config,
		private string $albums_table,
		private string $rules_table
	)
	{
	}

	/**
	 * @return array{upload_reward: int, source_cost: int}
	 */
	public function resolve(int $album_id): array
	{
		if ($album_id <= 0)
		{
			throw new \OutOfBoundsException('A valid Gallery album is required.');
		}

		$resolved = [
			'upload_reward' => null,
			'source_cost' => null,
		];
		$sql = 'SELECT rules.upload_reward, rules.source_cost
			FROM ' . $this->albums_table . ' current_album
			INNER JOIN ' . $this->albums_table . ' ancestor
				ON ancestor.left_id <= current_album.left_id
				AND ancestor.right_id >= current_album.right_id
			LEFT JOIN ' . $this->rules_table . ' rules
				ON rules.album_id = ancestor.album_id
			WHERE current_album.album_id = ' . $album_id . '
			ORDER BY ancestor.left_id DESC';
		$result = $this->db->sql_query($sql);
		$album_exists = false;
		while ($row = $this->db->sql_fetchrow($result))
		{
			$album_exists = true;
			foreach (array_keys($resolved) as $setting)
			{
				if ($resolved[$setting] === null && $row[$setting] !== null
					&& (int) $row[$setting] >= 0)
				{
					$resolved[$setting] = (int) $row[$setting];
				}
			}
		}
		$this->db->sql_freeresult($result);

		if (!$album_exists)
		{
			throw new \OutOfBoundsException('The Gallery album does not exist.');
		}

		return [
			'upload_reward' => $resolved['upload_reward']
				?? self::normalize_amount((int) $this->config['phpbb_gallery_bbpoints_upload_reward']),
			'source_cost' => $resolved['source_cost']
				?? self::normalize_amount((int) $this->config['phpbb_gallery_bbpoints_source_cost']),
		];
	}

	public static function normalize_override(int $value): int
	{
		return min(self::MAX_POINTS, max(self::INHERIT, $value));
	}

	public static function normalize_amount(int $value): int
	{
		return min(self::MAX_POINTS, max(0, $value));
	}

	/**
	 * Return the complete album tree with its direct overrides.
	 */
	public function get_album_rules(): array
	{
		$sql = 'SELECT albums.album_id, albums.album_name, albums.left_id, albums.right_id,
				rules.upload_reward, rules.source_cost
			FROM ' . $this->albums_table . ' albums
			LEFT JOIN ' . $this->rules_table . ' rules ON rules.album_id = albums.album_id
			ORDER BY albums.left_id ASC';
		$result = $this->db->sql_query($sql);
		$rows = [];
		$parents = [];
		while ($row = $this->db->sql_fetchrow($result))
		{
			$left_id = (int) $row['left_id'];
			while ($parents && end($parents) < $left_id)
			{
				array_pop($parents);
			}
			$row['depth'] = count($parents);
			$rows[] = $row;
			$parents[] = (int) $row['right_id'];
		}
		$this->db->sql_freeresult($result);
		return $rows;
	}

	/**
	 * Replace direct overrides for the submitted, existing albums.
	 *
	 * @param array<int, array{upload_reward: int, source_cost: int}> $rules
	 */
	public function save_album_rules(array $rules): void
	{
		$available = [];
		foreach ($this->get_album_rules() as $album)
		{
			$available[(int) $album['album_id']] = true;
		}
		$album_ids = array_values(array_filter(
			array_map('intval', array_keys($rules)),
			static fn (int $album_id): bool => isset($available[$album_id])
		));
		if (!$album_ids)
		{
			return;
		}

		$sql = 'DELETE FROM ' . $this->rules_table . '
			WHERE ' . $this->db->sql_in_set('album_id', $album_ids);
		$this->db->sql_query($sql);
		$insert = [];
		foreach ($album_ids as $album_id)
		{
			$upload_reward = self::normalize_override((int) ($rules[$album_id]['upload_reward'] ?? self::INHERIT));
			$source_cost = self::normalize_override((int) ($rules[$album_id]['source_cost'] ?? self::INHERIT));
			if ($upload_reward !== self::INHERIT || $source_cost !== self::INHERIT)
			{
				$insert[] = compact('album_id', 'upload_reward', 'source_cost');
			}
		}
		if ($insert)
		{
			$this->db->sql_multi_insert($this->rules_table, $insert);
		}
	}
}
