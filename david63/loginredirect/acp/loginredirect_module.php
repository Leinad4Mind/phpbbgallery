<?php
/**
*
* @package User Login Redirect
* @copyright (c) 2014 david63
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace david63\loginredirect\acp;

class loginredirect_module
{
	public $u_action;

	function main($id, $mode)
	{
		global $phpbb_container, $user;

		$this->tpl_name		= 'login_redirect_manage';
		$this->page_title	= $user->lang('REDIRECT');

		// Get an instance of the admin controller
		$admin_controller = $phpbb_container->get('david63.loginredirect.admin.controller');

		$admin_controller->display_options();
	}
}
