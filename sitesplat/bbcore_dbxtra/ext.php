<?php

/**
 * BBCore DB Addon
 * @copyright (c) 2020 SiteSplat. All rights reserved.
 * @license Proprietary
 */

namespace sitesplat\bbcore_dbxtra;

class ext extends \phpbb\extension\base
{
	protected $db;
	public function __construct($container, $extension_finder, $migrator, $extension_name, $extension_path)
	{
		$this->db = $container->get('dbal.conn');
	}
	public function is_enableable()
	{
		if ($this->db->get_sql_layer() != 'mysqli') {
			return false;
		}
		$sql = 'SELECT module_id FROM ' . MODULES_TABLE . " WHERE module_class = 'acp' AND module_langname = 'BBCORE_DASHBOARD'";
		$result = $this->db->sql_query($sql);
		$module_id = (int) $this->db->sql_fetchfield('module_id');
		$this->db->sql_freeresult($result);
		return $module_id > 0;
	}
	public function enable_step($whocares)
	{
		$addons = \sitesplat\addon::$addons;
		$addons['bbcore']['bbcore_dbxtra'] = 'sitesplat';
		\sitesplat\addon::$addons = $addons;
		$json = $this->db->sql_escape(json_encode($addons, 320));
		$this->db->sql_query('REPLACE INTO ' . CONFIG_TEXT_TABLE . " VALUES('sitesplat_addons', '$json')");
		return false;
	}
	public function disable_step($whocares)
	{
		if (class_exists('\sitesplat\addon')) {
			$addons = \sitesplat\addon::$addons;
		} else {
		}
		unset($addons['bbcore']['bbcore_dbxtra']);
		if (empty($addons['bbcore'])) {
			unset($addons['bbcore']);
		}
		if (class_exists('\sitesplat\addon')) {
			\sitesplat\addon::$addons = $addons;
		}
		$json = $this->db->sql_escape(json_encode($addons, 320));
		$this->db->sql_query('REPLACE INTO ' . CONFIG_TEXT_TABLE . " VALUES('sitesplat_addons', '$json')");
		$this->db->sql_query('DELETE FROM ' . EXT_TABLE . " WHERE ext_name = 'sitesplat/bbcore_dbxtra'");
		return false;
	}
}
