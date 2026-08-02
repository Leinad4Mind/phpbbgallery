<?php
/**
 * @package User Login Redirect
 * @copyright (c) 2026 Leinad4Mind
 * @license GNU General Public License, version 2 (GPL-2.0)
 */

namespace david63\loginredirect\acp;

class loginredirect_module
{
	public $u_action;
	public $tpl_name;
	public $page_title;

	public function main($id, $mode)
	{
		global $phpbb_container;
		$this->tpl_name = 'login_redirect_manage';
		$this->page_title = $phpbb_container->get('language')->lang('REDIRECT');
		$controller = $phpbb_container->get('david63.loginredirect.admin.controller');
		$controller->set_page_url($this->u_action);
		$controller->display_options();
	}
}
