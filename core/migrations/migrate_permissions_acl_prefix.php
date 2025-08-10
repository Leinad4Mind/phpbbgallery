<?php
/**
 * phpBB Gallery - Core Extension
 *
 * @package   phpbbgallery/core
 * @author    Leinad4Mind
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\migrations;

use phpbb\db\migration\migration;

class fix_permissions extends migration
{
	public function effectively_installed()
	{
		return false;
	}

	public function update_schema()
	{
		return [];
	}

	public function update_data()
	{
		return [['custom', [[$this, 'fix_permissions']]]];
	}

	public function fix_permissions()
	{
		global $db, $table_prefix;

		$old_perms = array(
				'a_gallery_manage',
				'a_gallery_albums',
				'a_gallery_cleanup',
		);

		foreach ($old_perms as $old_perm)
		{
				// Search old auth_option_id (if exists)
				$sql = 'SELECT auth_option_id FROM ' . $table_prefix . "acl_options WHERE auth_option = '" . $db->sql_escape($old_perm) . "'";
				$result = $db->sql_query($sql);
				$old_auth_id = $db->sql_fetchfield('auth_option_id');
				$db->sql_freeresult($result);

				// If exists, delete to avoid duplicates
				if ($old_auth_id)
				{
					$sql = 'DELETE FROM ' . $table_prefix . 'acl_options WHERE auth_option_id = ' . (int) $old_auth_id;
					$db->sql_query($sql);
				}

				// Insert new permission with acl_ prefix
				$perm = 'acl_' . $old_perm;
				$sql = 'SELECT auth_option_id FROM ' . $table_prefix . "acl_options WHERE auth_option = '" . $db->sql_escape($perm) . "'";
				$result = $db->sql_query($sql);
				$new_auth_id = $db->sql_fetchfield('auth_option_id');
				$db->sql_freeresult($result);

				if (!$new_auth_id)
				{
					$sql = 'INSERT INTO ' . $table_prefix . "acl_options (auth_option, is_global, auth_option_type) VALUES ('" . $db->sql_escape($perm) . "', 0, 0)";
					$db->sql_query($sql);
				}
		}

		return true;
	}

	public function revert_data()
	{
		global $db, $table_prefix;

		$old_perms = array(
			'a_gallery_manage',
			'a_gallery_albums',
			'a_gallery_cleanup',
		);

		foreach ($old_perms as $old_perm)
		{
			// Delete new perm with acl_ prefix
			$perm = 'acl_' . $old_perm;
			$sql = 'DELETE FROM ' . $table_prefix . "acl_options WHERE auth_option = '" . $db->sql_escape($perm) . "'";
			$db->sql_query($sql);

			// Re-insert old perm if missing
			$sql = 'SELECT auth_option_id FROM ' . $table_prefix . "acl_options WHERE auth_option = '" . $db->sql_escape($old_perm) . "'";
			$result = $db->sql_query($sql);
			$old_auth_id = $db->sql_fetchfield('auth_option_id');
			$db->sql_freeresult($result);

			if (!$old_auth_id)
			{
					$sql = 'INSERT INTO ' . $table_prefix . "acl_options (auth_option, is_global, auth_option_type) VALUES ('" . $db->sql_escape($old_perm) . "', 0, 0)";
					$db->sql_query($sql);
			}
		}

		return true;
	}
}
