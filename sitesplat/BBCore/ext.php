<?php

/**
 *
 * @package sitesplat BBcore
 * @copyright (c) 2020 SiteSplat All rights reserved
 * @license Proprietary
 *
 */

namespace sitesplat\BBCore;

class ext extends \phpbb\extension\base
{
	public function enable_step($whocares)
	{
		$db = $this->container->get('dbal.conn');
		$sql = 'SELECT module_id FROM ' . MODULES_TABLE . " WHERE module_class = 'acp' AND module_langname = 'SiteSplat'";
		$result = $db->sql_query($sql);
		$parent_id = (int) $db->sql_fetchfield('module_id');
		$db->sql_freeresult($result);
		if ($parent_id) {
			return false;
		}
		$module = $this->container->get('module.manager');
		$data = ['module_basename' => '', 'module_enabled' => 1, 'module_display' => 1, 'module_class' => 'acp', 'parent_id' => 0, 'module_langname' => 'SiteSplat',];
		$module->update_module_data($data);
		$ss_id = $data['module_id'];
		$sql = 'SELECT module_langname FROM ' . MODULES_TABLE . " WHERE module_class = 'acp' AND parent_id = 0 ORDER BY left_id DESC";
		$result = $db->sql_query($sql);
		$tabs = [];
		while ($row = $db->sql_fetchrow($result)) {
			$tabs[] = $row['module_langname'];
		}
		$db->sql_freeresult($result);
		for ($move = 0; $move < count($tabs); $move++) {
			if ($tabs[$move] == 'ACP_CAT_CUSTOMISE') {
				break;
			}
			$move++;
		}
		$module->move_module_by($data, 'acp', 'move_up', $move);
		$data = ['module_basename' => '', 'module_enabled' => 1, 'module_display' => 1, 'module_class' => 'acp', 'parent_id' => $ss_id, 'module_langname' => 'BBCore',];
		$module->update_module_data($data);
		$bb_id = $data['module_id'];
		$data = ['module_basename' => '', 'module_enabled' => 1, 'module_display' => 1, 'module_class' => 'acp', 'parent_id' => $ss_id, 'module_langname' => 'SITESPLAT_EXT',];
		$module->update_module_data($data);
		$data = ['module_basename' => '\sitesplat\BBCore\acp\bbcore_module', 'module_enabled' => 1, 'module_display' => 1, 'module_class' => 'acp', 'parent_id' => $bb_id, 'module_langname' => 'BBCORE_DASHBOARD', 'module_mode' => 'dash', 'module_auth' => 'ext_sitesplat/BBCore && acl_a_board',];
		$module->update_module_data($data);
		$data = ['module_basename' => '\sitesplat\BBCore\acp\bbcore_module', 'module_enabled' => 1, 'module_display' => 1, 'module_class' => 'acp', 'parent_id' => $bb_id, 'module_langname' => 'SITESPLAT_UPDATE_MANAGER', 'module_mode' => 'update', 'module_auth' => 'ext_sitesplat/BBCore && acl_a_board',];
		$module->update_module_data($data);
		$data = ['module_basename' => '\sitesplat\BBCore\acp\bbcore_module', 'module_enabled' => 1, 'module_display' => 1, 'module_class' => 'acp', 'parent_id' => $bb_id, 'module_langname' => 'BBCORE_SETTINGS', 'module_mode' => 'settings', 'module_auth' => 'ext_sitesplat/BBCore && acl_a_board',];
		$module->update_module_data($data);
		while (parent::enable_step($whocares));
		return false;
	}
	public function disable_step($whocares)
	{
		$extensions = $this->container->get('ext.manager')->all_enabled();
		foreach ($extensions as $key => $value) {
			if (strpos($value, 'sitesplat') === false) {
				unset($extensions[$key]);
			}
		}
		unset($extensions['sitesplat/BBCore']);
		if (sizeof($extensions)) {
			$user = $this->container->get('user');
			trigger_error(sprintf($user->lang['BBCORE_ERROR_DISABLE'], implode('<br />', array_keys($extensions))), E_USER_WARNING);
		}
		$config = $this->container->get('config');
		if (!empty($config['bbcore_ext_fix']) && $this->container->has('sitesplat.filesystem')) {
			$fs = $this->container->get('sitesplat.filesystem');
			$extfile = "{$fs->phpbb_root_dir}/adm/style/acp_ext_actions.html";
			$fs->init();
			if ($fs->fs_type && file_exists($extfile)) {
				$fs->put($extfile, str_replace('xdata-xajax', 'data-ajax', file_get_contents($extfile)));
				$config->delete('bbcore_ext_fix');
			}
		}
		$ids = [];
		$db = $this->container->get('dbal.conn');
		$sql = 'SELECT module_id FROM ' . MODULES_TABLE . " WHERE module_class = 'acp' AND module_langname IN ('SiteSplat', 'BBCore', 'BBCORE_DASHBOARD', 'SITESPLAT_UPDATE_MANAGER', 'BBCORE_SETTINGS', 'SITESPLAT_EXT') ORDER BY left_id DESC";
		$result = $db->sql_query($sql);
		while ($row = $db->sql_fetchrow($result)) {
			$ids[] = (int) $row['module_id'];
		}
		$db->sql_freeresult($result);
		if (!count($ids)) {
			return false;
		}
		$module = $this->container->get('module.manager');
		foreach ($ids as $module_id) {
			try {
				$module->delete_module($module_id, 'acp');
			} catch (\phpbb\module\exception\module_exception $exception) {
			}
		}
		return false;
	}
	public function purge_step($whocares)
	{
		$this->container->get('config')->delete('dd_fs');
		while (parent::purge_step($whocares));
		return false;
	}
}
