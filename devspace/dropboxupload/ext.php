<?php
/**
*
* @package Dropbox Upload
* @copyright (c) 2016 david63
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace david63\dropboxupload;

use \phpbb\extension\base;

/**
* Extension class for stop forum spam
*/

class ext extends base
{
	const DROPBOX_UPLOAD_VERSION = '2.1.0-rc1';

	/**
	* Enable extension if phpBB version requirement is met
	* and Auto Database Backup is installed
	*
	* @return bool
	* @access public
	*/
	public function is_enableable()
	{
		$config = $this->container->get('config');
		$this->container->get('language')->add_lang('ext_dropboxupload', 'david63/dropboxupload');

		if (!phpbb_version_compare($config['version'], '3.2.0', '>='))
		{
			trigger_error($this->container->get('language')->lang('VERSION_32') . adm_back_link(append_sid('index.' . $this->container->getParameter('core.php_ext'), 'i=acp_extensions&amp;mode=main')), E_USER_WARNING);
		}
		else if (!isset($config['auto_db_backup_enable']))
		{
			trigger_error($this->container->get('language')->lang('NO_AUTO_DB_BACKUP') . adm_back_link(append_sid('index.' . $this->container->getParameter('core.php_ext'), 'i=acp_extensions&amp;mode=main')), E_USER_WARNING);
		}
		else
		{
			return true;
		}
	}
}
