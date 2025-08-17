<?php
/**
*
* @package sitesplat BBcore
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\BBCore\updater\task;

class t11_update_deleted
{
	protected $filesystem;
	protected $root_path;
	public function __construct(\phpbb\filesystem\filesystem_interface $filesystem, $root_path)
	{
		$this->filesystem = $filesystem;
		$this->root_path = $root_path;
	}

	public function run($style_name, $updater_config)
	{
		if (empty($updater_config['update_info']['deleted']))
		{
			$updater_config['last_step'] = 't11_update_deleted';
			return $updater_config;
		}

		$current_files_path = $this->root_path . 'styles/' . $style_name . '/';
		foreach ($updater_config['update_info']['deleted'] as $key => $file_path)
		{
			$this->filesystem->remove($current_files_path . $file_path);

			unset($updater_config['update_info']['deleted'][$key]);
			break;
		}

		return $updater_config;
	}
}
