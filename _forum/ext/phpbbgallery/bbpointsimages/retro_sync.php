<?php
/**
 * phpBB Gallery - BBPoints historical reward synchronization
 *
 * @package   phpbbgallery/bbpointsimages
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\bbpointsimages;

use phpbb\db\driver\driver_interface;
use phpbbgallery\core\storage\provider_interface;
use phpbbgallery\core\storage\workspace;

final class retro_sync
{
	public function __construct(
		private driver_interface $db,
		private reward_manager $rewards,
		private workspace $storage_workspace,
		private string $images_table
	)
	{
	}

	/**
	 * @return array{last_id: int, scanned: int, rewarded: int, has_more: bool}
	 */
	public function run_batch(int $after_id, int $limit = 100): array
	{
		$after_id = max(0, $after_id);
		$limit = max(1, min(500, $limit));
		$sql = 'SELECT image_id, image_album_id, image_user_id, image_status, image_filename
			FROM ' . $this->images_table . '
			WHERE image_status = ' . (int) \phpbbgallery\core\block::STATUS_APPROVED . '
				AND image_id > ' . (int) $after_id . '
			ORDER BY image_id ASC';
		$result = $this->db->sql_query_limit($sql, $limit + 1);
		$rows = [];
		while ($row = $this->db->sql_fetchrow($result))
		{
			$rows[] = $row;
		}
		$this->db->sql_freeresult($result);

		$has_more = count($rows) > $limit;
		if ($has_more)
		{
			array_pop($rows);
		}
		$rewarded = 0;
		foreach ($rows as $row)
		{
			try
			{
				$source = $this->storage_workspace->materialize(provider_interface::SOURCE, (string) $row['image_filename']);
			}
			catch (\RuntimeException)
			{
				continue;
			}
			try
			{
				$rewarded += (int) $this->rewards->reward($row, $source->get_path());
			}
			finally
			{
				$source->release();
			}
		}

		return [
			'last_id' => $rows ? (int) end($rows)['image_id'] : $after_id,
			'scanned' => count($rows),
			'rewarded' => $rewarded,
			'has_more' => $has_more,
		];
	}
}
