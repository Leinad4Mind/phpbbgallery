<?php
/**
*
* @package User Login Redirect
* @copyright (c) 2014 david63
* @license GNU General Public License, version 2 (GPL-2.0)
*
*/

namespace david63\loginredirect\acp;

class loginredirect_module
{
	public $u_action;

	function main($id, $mode)
	{
		global $phpbb_container;

		$this->tpl_name		= 'login_redirect_manage';
		$this->page_title	= $phpbb_container->get('language')->lang('REDIRECT');

		// Get an instance of the admin controller
		$admin_controller = $phpbb_container->get('david63.loginredirect.admin.controller');

		// Make the $u_action url available in the admin controller
		$admin_controller->set_page_url($this->u_action);

		$admin_controller->display_options();
	}
}
