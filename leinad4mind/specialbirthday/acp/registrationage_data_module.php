<?php
/**
*
* @package Registration Age Check
* @copyright (c) 2016 david63
* @license GNU General Public License, version 2 (GPL-2.0)
*
*/

namespace david63\registrationage\acp;

class registrationage_data_module
{
	public $u_action;

	function main($id, $mode)
	{
		global $phpbb_container;

		$this->tpl_name		= 'registrationage_data';
		$this->page_title	= $phpbb_container->get('language')->lang('REGISTRATION_AGE');

		// Get an instance of the data controller
		$admin_controller = $phpbb_container->get('david63.registrationage.data.controller');

		// Make the $u_action url available in the admin controller
		$admin_controller->set_page_url($this->u_action);

		$admin_controller->display_output();
	}
}
