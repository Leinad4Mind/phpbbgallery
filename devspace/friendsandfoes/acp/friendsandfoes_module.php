<?php
/**
 *
 * @package Friends & Foes Extension
 * @copyright (c) 2022 devspace
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace devspace\friendsandfoes\acp;

class friendsandfoes_module
{
	public $u_action;

	public function main($id, $mode)
	{
		global $phpbb_container;

		$this->tpl_name   = 'friends_and_foes';
		$this->page_title = $phpbb_container->get('language')->lang('FRIENDS_AND_FOES');

		// Get an instance of the admin controller
		$admin_controller = $phpbb_container->get('devspace.friendsandfoes.admin.controller');

		// Make the $u_action url available in the admin controller
		$admin_controller->set_page_url($this->u_action);

		$admin_controller->display_output();
	}
}
