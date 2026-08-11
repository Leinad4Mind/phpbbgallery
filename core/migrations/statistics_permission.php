<?php
/**
 * phpBB Gallery - statistics access permission.
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\migrations;

use phpbb\db\migration\migration;

/** Allow statistics access to be controlled independently for every album. */
class statistics_permission extends migration
{
	public static function depends_on(): array
	{
		return ['\phpbbgallery\core\migrations\statistics_dashboard'];
	}

	public function update_schema(): array
	{
		return [
			'add_columns' => [
				$this->table_prefix . 'gallery_roles' => [
					'i_statistics' => ['UINT:3', 0],
				],
			],
		];
	}

	public function revert_schema(): array
	{
		return [
			'drop_columns' => [
				$this->table_prefix . 'gallery_roles' => ['i_statistics'],
			],
		];
	}

	public function update_data(): array
	{
		return [
			['custom', [[$this, 'inherit_view_permission']]],
			['custom', [[$this, 'clear_gallery_permission_cache']]],
		];
	}

	public function revert_data(): array
	{
		return [
			['custom', [[$this, 'clear_gallery_permission_cache']]],
		];
	}

	public function inherit_view_permission(): bool
	{
		$this->db->sql_query('UPDATE ' . $this->table_prefix . 'gallery_roles
			SET i_statistics = i_view');

		return true;
	}

	public function clear_gallery_permission_cache(): bool
	{
		$this->db->sql_query('UPDATE ' . $this->table_prefix . "gallery_users
			SET user_permissions = ''");

		return true;
	}
}
