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
}
