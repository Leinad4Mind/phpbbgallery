<?php
/**
*
* @package Special Birthday
* @copyright (c) 2019 Leinad4Mind
* @license GNU General Public License, version 2 (GPL-2.0)
*
*/

namespace leinad4mind\specialbirthday\acp;

class specialbirthday_data_module
{
	public $u_action;

	function main($id, $mode)
	{
		global $phpbb_container;

		$this->tpl_name		= 'specialbirthday_data';
		$this->page_title	= $phpbb_container->get('language')->lang('REGISTRATION_AGE');

		// Get an instance of the data controller
		$admin_controller = $phpbb_container->get('leinad4mind.specialbirthday.data.controller');

		// Make the $u_action url available in the admin controller
		$admin_controller->set_page_url($this->u_action);

		$admin_controller->display_output();
	}
}
