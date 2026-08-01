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

class image_subtitle extends migration
{
	public static function depends_on(): array
	{
		return ['\phpbbgallery\core\migrations\remove_legacy_image_plugins'];
	}

	public function update_schema(): array
	{
		return [
			'add_columns' => [
				$this->table_prefix . 'gallery_images' => [
					'image_subtitle' => ['VCHAR:255', ''],
				],
			],
		];
	}

	public function revert_schema(): array
	{
		return [
			'drop_columns' => [
				$this->table_prefix . 'gallery_images' => [
					'image_subtitle',
				],
			],
		];
	}
}
