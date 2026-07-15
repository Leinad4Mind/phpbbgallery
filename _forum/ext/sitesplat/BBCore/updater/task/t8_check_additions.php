<?php
/**
*
* @package sitesplat BBcore
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\BBCore\updater\task;

class t8_check_additions
{
	protected $language;
	protected $root_path;
	public function __construct(\phpbb\language\language $language, $root_path)
	{
		$this->language = $language;
		$this->root_path = $root_path;
	}

	public function run($style_name, $updater_config, $root_path)
	{
/*
		$this->root_path = $root_path;
		$current_files_path = $this->root_path . 'styles/' . $style_name . '/';
		foreach ($updater_config['update_info']['added'] as $file_path)
		{
			if (file_exists($current_files_path . $file_path))
			{
				throw new \Exception($this->language->lang('NEW_FILE_ALREADY_EXISTS', $file_path));
			}
		}
*/
		$updater_config['last_step'] = 't8_check_additions';
		return $updater_config;
	}
}
