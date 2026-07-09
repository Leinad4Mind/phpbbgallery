<?php

/**
 *
 * @package sitesplat BBcore
 * @copyright (c) 2021 SiteSplat All rights reserved
 * @license Proprietary
 *
 */

namespace sitesplat\BBCore\updater\task;

class t6_load_list_of_changes
{
	protected $root_path;
	protected $php_ext;
	public function __construct($root_path, $php_ext)
	{
		$this->root_path = $root_path;
		$this->php_ext = $php_ext;
	}
	public function run($style_name, $updater_config)
	{
		include($updater_config['tmp_dir'] . 'index.' . $this->php_ext);
		$updater_config['update_info'] = $updater_config['log_data'] = $update_info;
		$updater_config['last_step'] = 't6_load_list_of_changes';
		return $updater_config;
	}
}
