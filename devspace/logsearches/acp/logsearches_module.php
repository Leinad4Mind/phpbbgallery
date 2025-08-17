<?php
/**
*
* @package Log Searches Extension
* @copyright (c) 2015 david63
* @license GNU General Public License, version 2 (GPL-2.0)
*
*/

namespace david63\logsearches\acp;

class logsearches_module
{
	public $u_action;

	function main($id, $mode)
	{
		global $phpbb_container;

		$this->tpl_name		= 'logsearches';
		$this->page_title	= $phpbb_container->get('language')->lang('SEARCH_LOG');

		// Get an instance of the admin controller
		$admin_controller = $phpbb_container->get('david63.logsearches.admin.controller');

		// Make the $u_action url available in the admin controller
		$admin_controller->set_page_url($this->u_action);

		$admin_controller->display_output();
	}
}
