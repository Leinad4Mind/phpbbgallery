<?php
/**
*
* @package sitesplat BBcore
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\BBCore\updater\task;

class t0_backup
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
		$backup_dir = $this->root_path . 'store/' . $style_name . '_' . time();
		$this->filesystem->mkdir($backup_dir);
		$this->filesystem->mirror($this->root_path . 'styles/' . $style_name, $backup_dir);

		$updater_config['last_step'] = 't0_backup';
		return $updater_config;
	}
}
