<?php
/**
 *
 * @package Log Searches Extension
 * @copyright (c) 2022 devspace
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace devspace\logsearches\acp;

class logsearches_module
{
	public $u_action;

	public function main($id, $mode)
	{
		global $phpbb_container;

		$this->tpl_name   = 'logsearches';
		$this->page_title = $phpbb_container->get('language')->lang('SEARCH_LOG');

		// Get an instance of the admin controller
		$admin_controller = $phpbb_container->get('devspace.logsearches.admin.controller');

		// Make the $u_action url available in the admin controller
		$admin_controller->set_page_url($this->u_action);

		$admin_controller->display_output();
	}
}
