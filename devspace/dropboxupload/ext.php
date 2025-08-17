<?php
/**
*
* @package Dropbox Upload
* @copyright (c) 2016 david63
* @license GNU General Public License, version 2 (GPL-2.0)
*
*/

namespace david63\dropboxupload;

use phpbb\extension\base;

/**
* Extension class for dropbox upload
*/
class ext extends base
{
	/**
	* Enable extension if phpBB version requirement is met
	* and Auto Database Backup is installed
	*
	* @return bool
	* @access public
	*/
	public function is_enableable()
	{
		// Set globals for use in the language file
		global $ver_error, $db_error;

		// Requires phpBB 3.2.0 or newer.
		$ver 		= phpbb_version_compare(PHPBB_VERSION, '3.2.0', '>=');
		// Display a custom warning message if this requirement fails.
		$ver_error 	= ($ver) ? false : true;

		// Is auto db backup installed?
		$config 	= $this->container->get('config');
		$auto_db 	= isset($config['auto_db_backup_enable']);
		// Display a custom warning message if this requirement fails.
		$db_error 	= ($auto_db) ? false : true;

		// Need to cater for 3.1 and 3.2
		if (phpbb_version_compare(PHPBB_VERSION, '3.2.0', '>='))
		{
			$this->container->get('language')->add_lang('ext_enable_error', 'david63/dropboxupload');
		}
		else
		{
			$this->container->get('user')->add_lang_ext('david63/dropboxupload', 'ext_enable_error');
		}

		return $ver && $auto_db;
	}
}
