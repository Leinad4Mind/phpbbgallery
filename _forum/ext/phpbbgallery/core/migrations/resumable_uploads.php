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

class resumable_uploads extends migration
{
	public static function depends_on(): array
	{
		return [
			'\phpbbgallery\core\migrations\release_3_4_0',
			'\phpbbgallery\core\migrations\release_1_2_0_db_create',
		];
	}

	public function update_schema(): array
	{
		return [
			'add_columns' => [
				$this->table_prefix . 'gallery_images' => [
					'image_upload_session_hash' => ['VCHAR:64', ''],
				],
			],
			'add_index' => [
				$this->table_prefix . 'gallery_images' => [
					'draft_owner' => ['image_status', 'image_album_id', 'image_user_id', 'image_upload_session_hash'],
				],
			],
		];
	}

	public function revert_schema(): array
	{
		return [
			'drop_keys' => [
				$this->table_prefix . 'gallery_images' => [
					'draft_owner',
				],
			],
			'drop_columns' => [
				$this->table_prefix . 'gallery_images' => [
					'image_upload_session_hash',
				],
			],
		];
	}
}
