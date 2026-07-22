<?php
/**
 * phpBB Gallery - Core Extension
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\migrations;

use phpbb\db\migration\migration;

class performance_indexes extends migration
{
	public static function depends_on(): array
	{
		return ['\phpbbgallery\core\migrations\resumable_uploads'];
	}

	public function update_schema(): array
	{
		return [
			'add_index' => [
				$this->table_prefix . 'gallery_images' => [
					'album_status_time' => ['image_album_id', 'image_status', 'image_time'],
				],
				$this->table_prefix . 'gallery_reports' => [
					'image_status' => ['report_image_id', 'report_status'],
					'album_status' => ['report_album_id', 'report_status'],
				],
			],
		];
	}

	public function revert_schema(): array
	{
		return [
			'drop_keys' => [
				$this->table_prefix . 'gallery_images' => [
					'album_status_time',
				],
				$this->table_prefix . 'gallery_reports' => [
					'image_status',
					'album_status',
				],
			],
		];
	}
}
