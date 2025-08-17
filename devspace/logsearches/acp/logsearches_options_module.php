<?php
/**
*
* @package Log Searches Extension
* @copyright (c) 2015 david63
* @license GNU General Public License, version 2 (GPL-2.0)
*
*/

namespace david63\logsearches\acp;

class logsearches_options_module
{
	public $u_action;

	function main($id, $mode)
	{
		global $phpbb_container;

		$this->tpl_name		= 'logsearches_options';
		$this->page_title	= $phpbb_container->get('language')->lang('SEARCH_LOG');

		// Get an instance of the admin controller
		$admin_controller = $phpbb_container->get('david63.logsearches.admin.controller');

		$admin_controller->display_options();
	}
}
