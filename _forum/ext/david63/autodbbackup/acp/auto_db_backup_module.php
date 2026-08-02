<?php
/**
 * @package Auto db Backup
 * @copyright (c) 2015 david63
 * @license GNU General Public License, version 2 (GPL-2.0)
 */

namespace david63\autodbbackup\acp;

class auto_db_backup_module
{
	/** @var string */
	public $u_action;

	/** @var string */
	public $tpl_name;

	/** @var string */
	public $page_title;

	/**
	 * @param int    $id Module ID
	 * @param string $mode Module mode
	 */
	public function main($id, $mode)
	{
		global $phpbb_container;

		$this->tpl_name = 'auto_db_backup';
		$this->page_title = $phpbb_container->get('language')->lang('AUTO_DB_BACKUP_SETTINGS');

		$admin_controller = $phpbb_container->get('david63.autodbbackup.admin.controller');
		$admin_controller->set_page_url($this->u_action);
		$admin_controller->display_options();
	}
}
