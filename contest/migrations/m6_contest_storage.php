<?php
/**
 * phpBB Gallery - Contest result storage.
 *
 * @package   phpbbgallery/contest
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\contest\migrations;

use phpbb\db\migration\migration;

class m6_contest_storage extends migration
{
	public static function depends_on(): array
	{
		return ['\phpbbgallery\contest\migrations\m5_image_rank_storage'];
	}

	public function effectively_installed(): bool
	{
		return $this->db_tools->sql_table_exists($this->table_prefix . 'gallery_contests');
	}

	public function update_schema(): array
	{
		return [
			'add_tables' => [
				$this->table_prefix . 'gallery_contests' => [
					'COLUMNS' => [
						'contest_id' => ['UINT', null, 'auto_increment'],
						'contest_album_id' => ['UINT', 0],
						'contest_start' => ['UINT:11', 0],
						'contest_rating' => ['UINT:11', 0],
						'contest_end' => ['UINT:11', 0],
						'contest_marked' => ['TINT:1', 0],
						'contest_first' => ['UINT', 0],
						'contest_second' => ['UINT', 0],
						'contest_third' => ['UINT', 0],
					],
					'PRIMARY_KEY' => 'contest_id',
				],
			],
		];
	}

	public function revert_schema(): array
	{
		return [];
	}
}
