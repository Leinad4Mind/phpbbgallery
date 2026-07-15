<?php
/**
 *
 * @package User Defaults Extension
 * @copyright (c) 2022 devspace
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace devspace\userdefaults\acp;

class userdefaults_module
{
	public $u_action;

	public function main($id, $mode)
	{
		global $phpbb_container;

		$this->tpl_name   = 'user_defaults';
		$this->page_title = $phpbb_container->get('language')->lang('USER_DEFAULTS');

		// Get an instance of the admin controller
		$admin_controller = $phpbb_container->get('devspace.userdefaults.admin.controller');

		$admin_controller->display_options();
	}
}
