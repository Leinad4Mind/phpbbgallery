<?php
/**
 * @package User Defaults
 * @copyright (c) 2016 David Wood
 * @copyright (c) 2026 Leinad4Mind
 * @license GNU General Public License, version 2 (GPL-2.0)
 */

namespace david63\userdefaults\acp;

class userdefaults_module
{
	public $u_action;

	public function main($id, $mode)
	{
		global $phpbb_container;

		$this->tpl_name = 'user_defaults';
		$this->page_title = $phpbb_container->get('language')->lang('USER_DEFAULTS');

		$controller = $phpbb_container->get('david63.userdefaults.admin.controller');
		$controller->set_page_url($this->u_action);
		$controller->display_options();
	}
}
