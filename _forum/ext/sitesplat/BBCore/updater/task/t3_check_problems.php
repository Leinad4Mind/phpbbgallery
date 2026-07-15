<?php
/**
*
* @package sitesplat BBcore
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\BBCore\updater\task;

class t3_check_problems
{
	public function run($style_name, $updater_config)
	{
		if (version_compare($updater_config['cfg_data']['style_version'], $updater_config['style_data']['version'], '>='))
		{
			throw new \Exception('ALREADY_UP_TO_DATE');
		}

		if (empty($updater_config['style_data']['direct_download_dir']))
		{
			throw new \Exception('NO_DIRECT_DOWNLOAD');
		}

		$updater_config['last_step'] = 't3_check_problems';
		return $updater_config;
	}
}
