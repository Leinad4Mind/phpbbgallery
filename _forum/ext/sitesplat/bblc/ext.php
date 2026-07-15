<?php
/**
 * BBlivechat Giphy Addon
 * @copyright (c) 2021 SiteSplat. All rights reserved.
 * @license Proprietary
 */

namespace sitesplat\bblc_giphy;

class ext extends \phpbb\extension\base
{
	protected $db, $config;

	public function __construct($container, $extension_finder, $migrator, $extension_name, $extension_path)
	{
		$this->db = $container->get('dbal.conn');
		$this->config = $container->get('config');
	}

	public function is_enableable()
	{
		$sql = 'SELECT module_id FROM ' . MODULES_TABLE . " WHERE module_class = 'acp' AND module_langname = 'BBlivechat'";
		$result = $this->db->sql_query($sql);
		$module_id = (int) $this->db->sql_fetchfield('module_id');
		$this->db->sql_freeresult($result);

		return $module_id > 0;
	}

	public function enable_step($whocares)
	{
		$addons = \sitesplat\addon::$addons;
		$addons['bblivechat']['bblc_giphy'] = 'sitesplat';
		\sitesplat\addon::$addons = $addons;

		$json = $this->db->sql_escape(json_encode($addons, 320));
		$this->db->sql_query('REPLACE INTO ' . CONFIG_TEXT_TABLE . " VALUES('sitesplat_addons', '$json')");

		if (empty($this->config['bblc_giphy']))
		{
			$this->config->set('bblc_giphy', '');
		}

		return false;
	}

	public function disable_step($whocares)
	{
		$addons = \sitesplat\addon::$addons;
		unset($addons['bblivechat']['bblc_giphy']);
		if (empty($addons['bblivechat']))
		{
			unset($addons['bblivechat']);
		}

		\sitesplat\addon::$addons = $addons;

		$json = $this->db->sql_escape(json_encode($addons, 320));
		$this->db->sql_query('REPLACE INTO ' . CONFIG_TEXT_TABLE . " VALUES('sitesplat_addons', '$json')");
		return false;
	}

	public function purge_step($whocares)
	{
		$this->config->delete('bblc_giphy');
		return false;
	}
}
