<?php
/**
 * Gallery BBTags administrative policy module migration.
 *
 * @package   phpbbgallery/bbtagsimages
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\bbtagsimages\migrations;

use phpbb\db\migration\container_aware_migration;

final class m2_acp_policy extends container_aware_migration
{
	public static function depends_on(): array
	{
		return ['\phpbbgallery\bbtagsimages\migrations\m1_init'];
	}

	public function update_data(): array
	{
		return [
			// Remove the module left by the provisional bbtagsbridge package name.
			// This must not use module.remove because phpBB reverses that operation
			// during purge and would recreate the obsolete module below the Core
			// category, preventing the category itself from being removed.
			['custom', [[$this, 'remove_provisional_module']]],
			['module.add', [
				'acp',
				'PHPBB_GALLERY',
				[
					'module_basename' => '\phpbbgallery\bbtagsimages\acp\policy_module',
					'module_langname' => 'ACP_BBTAGSIMAGES_POLICIES',
					'module_mode' => 'policies',
					'module_auth' => 'ext_phpbbgallery/bbtagsimages && acl_a_gallery_albums',
				],
			]],
		];
	}

	public function remove_provisional_module(): void
	{
		$sql = 'SELECT module_id
			FROM ' . $this->table_prefix . "modules
			WHERE module_class = 'acp'
				AND module_langname = 'ACP_BBTAGSBRIDGE_POLICIES'";
		$result = $this->db->sql_query($sql);
		$module_ids = [];
		while ($row = $this->db->sql_fetchrow($result))
		{
			$module_ids[] = (int) $row['module_id'];
		}
		$this->db->sql_freeresult($result);

		$module_manager = $this->container->get('module.manager');
		foreach ($module_ids as $module_id)
		{
			$module_manager->delete_module($module_id, 'acp');
		}
		if ($module_ids)
		{
			$module_manager->remove_cache_file('acp');
		}
	}

	public function revert_data(): array
	{
		return [
			['module.remove', ['acp', 'PHPBB_GALLERY', 'ACP_BBTAGSIMAGES_POLICIES']],
		];
	}
}
