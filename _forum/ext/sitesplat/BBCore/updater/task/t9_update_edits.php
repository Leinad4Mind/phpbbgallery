<?php
/**
*
* @package sitesplat BBcore
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\BBCore\updater\task;

class t9_update_edits
{
	protected $cache;
	protected $root_path;
	public function __construct(\phpbb\cache\driver\driver_interface $cache, $root_path)
	{
		$this->cache = $cache;
		$this->root_path = $root_path;
	}

	public function run($style_name, $updater_config)
	{
		if (empty($updater_config['merge_calculated']))
		{
			$updater_config['last_step'] = 't9_update_edits';
			return $updater_config;
		}

		$current_files_path = $this->root_path . 'styles/' . $style_name . '/';
		foreach ($updater_config['merge_calculated'] as $key => $file_path)
		{
			$cache_name = '_bbcore_updater_' . md5($file_path);
			file_put_contents($current_files_path . $file_path, $this->cache->get($cache_name));
			$this->cache->destroy($cache_name);

			unset($updater_config['merge_calculated'][$key]);
			break;
		}

		return $updater_config;
	}
}
