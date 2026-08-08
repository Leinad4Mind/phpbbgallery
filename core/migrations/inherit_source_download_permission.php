<?php
/**
 * phpBB Gallery - inherited original-source download permission.
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\migrations;

use phpbb\db\migration\migration;

/** Preserve the historical source access of every existing Gallery role. */
class inherit_source_download_permission extends migration
{
	public static function depends_on(): array
	{
		return ['\phpbbgallery\core\migrations\source_access_policy'];
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
		return [];
	}

	public function inherit_view_permission(): bool
	{
		$this->db->sql_query('UPDATE ' . $this->table_prefix . 'gallery_roles
			SET i_download = i_view');

		return true;
	}

	public function clear_gallery_permission_cache(): bool
	{
		$this->db->sql_query('UPDATE ' . $this->table_prefix . 'gallery_users
			SET user_permissions = \'\'');

		return true;
	}
}
