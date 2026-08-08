<?php
/**
 * phpBB Gallery - per-image read tracking.
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\migrations;

use phpbb\db\migration\migration;

/** Store the images individually viewed by each member. */
class image_read_tracking extends migration
{
	public static function depends_on(): array
	{
		return ['\phpbbgallery\core\migrations\bmp_support'];
	}

	public function update_schema(): array
	{
		return [
			'add_tables' => [
				$this->table_prefix . 'gallery_images_track' => [
					'COLUMNS' => [
						'user_id' => ['UINT', 0],
						'image_id' => ['UINT', 0],
						'mark_time' => ['TIMESTAMP', 0],
					],
					'PRIMARY_KEY' => ['user_id', 'image_id'],
					'KEYS' => [
						'image_id' => ['INDEX', 'image_id'],
					],
				],
			],
		];
	}

	public function revert_schema(): array
	{
		return [
			'drop_tables' => [
				$this->table_prefix . 'gallery_images_track',
			],
		];
	}
}
