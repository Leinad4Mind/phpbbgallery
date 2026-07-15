<?php
/*
* @package cBB Debugger
* @version v1.0.0 21/06/2021
*
* @copyright (c) 2021 CaniDev
* @license https://opensource.org/licenses/gpl-license.php GNU Public License
*/

	$config = \canidev\debugger\libraries\config::instance();

	if($config->get('debug_enable'))
	{
		@ini_set('log_errors', 0);
		@define('DEBUG', true);
		
		\phpbb\debug\debug::enable();
	}

	if(phpbb_version_compare(PHPBB_VERSION, '3.3.0', '<') && $config->get('show_stats'))
	{
		@define('PHPBB_DISPLAY_LOAD_TIME', true);
	}