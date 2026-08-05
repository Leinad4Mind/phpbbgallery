<?php
/**
 * phpBB Gallery - EXIF capture-date sorting storage
 *
 * @package   phpbbgallery/exif
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\exif\migrations;

use phpbb\db\migration\migration;

final class m4_capture_sort extends migration
{
	public static function depends_on(): array
	{
		return ['\phpbbgallery\exif\migrations\m3_granular_display'];
	}

	public function update_schema(): array
	{
		return [
			'add_tables' => [
				$this->table_prefix . 'gallery_exif_capture' => [
					'COLUMNS' => [
						'exif_image_id' => ['UINT', 0],
						'exif_taken_time' => ['BINT', 0],
					],
					'PRIMARY_KEY' => 'exif_image_id',
					'KEYS' => [
						'exif_taken' => ['INDEX', ['exif_taken_time', 'exif_image_id']],
					],
				],
			],
		];
	}

	public function revert_schema(): array
	{
		return [
			'drop_tables' => [
				$this->table_prefix . 'gallery_exif_capture',
			],
		];
	}

	public function update_data(): array
	{
		return [[
			'module.add',
			['acp', 'PHPBB_GALLERY', [
				'module_basename' => '\phpbbgallery\exif\acp\main_module',
				'module_langname' => 'ACP_GALLERY_EXIF',
				'module_mode' => 'settings',
				'module_auth' => 'acl_a_gallery_albums && ext_phpbbgallery/exif',
			]],
		]];
	}

	public function revert_data(): array
	{
		return [[
			'module.remove',
			['acp', 'PHPBB_GALLERY', 'ACP_GALLERY_EXIF'],
		]];
	}
}
