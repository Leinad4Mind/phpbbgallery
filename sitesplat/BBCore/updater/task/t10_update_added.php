<?php
/**
*
* @package sitesplat BBcore
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\BBCore\updater\task;

class t10_update_added
{
	protected $root_path;
	public function __construct($root_path)
	{
		$this->root_path = $root_path;
	}

	public function run($style_name, $updater_config, $root_path)
	{
		if (empty($updater_config['update_info']['added']))
		{
			$updater_config['last_step'] = 't10_update_added';
			return $updater_config;
		}

		$this->root_path = $root_path;
		$current_files_path = $this->root_path . 'styles/' . $style_name . '/';
		foreach ($updater_config['update_info']['added'] as $key => $file_path)
		{
			file_put_contents($current_files_path . $file_path, file_get_contents($updater_config['tmp_dir'] . 'new/' . $file_path));

			unset($updater_config['update_info']['added'][$key]);
			break;
		}

		return $updater_config;
	}
}
