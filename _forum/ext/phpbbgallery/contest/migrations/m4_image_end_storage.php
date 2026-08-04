<?php
/**
 * phpBB Gallery - Contest image end storage.
 *
 * @package   phpbbgallery/contest
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\contest\migrations;

use phpbb\db\migration\migration;

class m4_image_end_storage extends migration
{
	public static function depends_on(): array
	{
		return ['\phpbbgallery\contest\migrations\m3_album_storage'];
	}

	public function effectively_installed(): bool
	{
		return $this->db_tools->sql_column_exists($this->table_prefix . 'gallery_images', 'image_contest_end');
	}

	public function update_schema(): array
	{
		return [
			'add_columns' => [
				$this->table_prefix . 'gallery_images' => [
					'image_contest_end' => ['TIMESTAMP', 0],
				],
			],
		];
	}

	public function revert_schema(): array
	{
		return [
			'drop_columns' => [
				$this->table_prefix . 'gallery_images' => [
					'image_contest_end',
				],
			],
		];
	}
}
