<?php
/**
 * phpBB Gallery - persisted image dimensions.
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\migrations;

use phpbb\db\migration\migration;

class image_dimensions extends migration
{
	public static function depends_on(): array
	{
		return ['\phpbbgallery\core\migrations\inherit_source_download_permission'];
	}

	public function update_schema(): array
	{
		return [
			'add_columns' => [
				$this->table_prefix . 'gallery_images' => [
					'image_width'  => ['UINT:11', 0],
					'image_height' => ['UINT:11', 0],
				],
			],
		];
	}

	public function revert_schema(): array
	{
		return [
			'drop_columns' => [
				$this->table_prefix . 'gallery_images' => ['image_width', 'image_height'],
			],
		];
	}
}
