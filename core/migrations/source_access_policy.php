<?php
/**
 * phpBB Gallery - original-source access policy.
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\migrations;

use phpbb\db\migration\migration;

/** Add the independently assignable source-charge bypass permission. */
class source_access_policy extends migration
{
	public static function depends_on(): array
	{
		return [
			'\phpbbgallery\core\migrations\source_download_permission',
			'\phpbbgallery\core\migrations\bmp_support',
		];
	}

	public function update_schema(): array
	{
		return [
			'add_columns' => [
				$this->table_prefix . 'gallery_roles' => [
					'i_download_free' => ['UINT:3', 0],
				],
			],
		];
	}

	public function revert_schema(): array
	{
		return [
			'drop_columns' => [
				$this->table_prefix . 'gallery_roles' => ['i_download_free'],
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
