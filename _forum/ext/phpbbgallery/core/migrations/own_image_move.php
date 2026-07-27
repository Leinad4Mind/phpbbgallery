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

class own_image_move extends migration
{
	public static function depends_on(): array
	{
		return ['\phpbbgallery\core\migrations\gallery_title'];
	}

	public function update_schema(): array
	{
		return [
			'add_columns' => [
				$this->table_prefix . 'gallery_roles' => [
					'i_move' => ['UINT:3', 0],
				],
			],
		];
	}

	public function revert_schema(): array
	{
		return [
			'drop_columns' => [
				$this->table_prefix . 'gallery_roles' => [
					'i_move',
				],
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
		$sql = 'UPDATE ' . $this->table_prefix . "gallery_users
			SET user_permissions = ''";
		$this->db->sql_query($sql);

		return true;
	}
}
