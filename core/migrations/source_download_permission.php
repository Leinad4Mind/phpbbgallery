<?php
/**
 * phpBB Gallery - original-source download permission.
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\migrations;

use phpbb\db\migration\migration;

/** Separate viewing derived images from downloading the original file. */
class source_download_permission extends migration
{
	public static function depends_on(): array
	{
		return ['\phpbbgallery\core\migrations\image_read_tracking'];
	}

	public function update_schema(): array
	{
		return [
			'add_columns' => [
				$this->table_prefix . 'gallery_roles' => [
					'i_download' => ['UINT:3', 0],
				],
			],
		];
	}

	public function revert_schema(): array
	{
		return [
			'drop_columns' => [
				$this->table_prefix . 'gallery_roles' => ['i_download'],
			],
		];
	}

	public function update_data(): array
	{
		return [
			['custom', [[$this, 'clear_gallery_permission_cache']]],
		];
	}

	public function revert_data(): array
	{
		return $this->update_data();
	}

	public function clear_gallery_permission_cache(): bool
	{
		$this->db->sql_query('UPDATE ' . $this->table_prefix . "gallery_users
			SET user_permissions = ''");

		return true;
	}
}
