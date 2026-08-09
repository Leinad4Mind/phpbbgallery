<?php
/**
 * phpBB Gallery - group leader permission inheritance correction.
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\migrations;

use phpbb\db\migration\migration;

/** Invalidate Gallery ACL snapshots created with incorrect group leader filtering. */
class group_leader_permissions extends migration
{
	public static function depends_on(): array
	{
		return ['\phpbbgallery\core\migrations\gallery_index_featured_modes'];
	}

	public function update_data(): array
	{
		return [
			['custom', [[$this, 'clear_gallery_permission_cache']]],
		];
	}

	public function revert_data(): array
	{
		return [];
	}

	public function clear_gallery_permission_cache(): bool
	{
		$this->db->sql_query('UPDATE ' . $this->table_prefix . 'gallery_users
			SET user_permissions = \'\'');

		return true;
	}
}
