<?php
/**
*
* @package Registration Age Check
* @copyright (c) 2016 david63
* @license GNU General Public License, version 2 (GPL-2.0)
*
*/

namespace david63\registrationage\acp;

class registrationage_module
{
	public $u_action;

	function main($id, $mode)
	{
		global $phpbb_container;

		$this->tpl_name		= 'registrationage';
		$this->page_title	= $phpbb_container->get('language')->lang('REGISTRATION_AGE');

		// Get an instance of the admin controller
		$admin_controller = $phpbb_container->get('david63.registrationage.admin.controller');

		$admin_controller->display_options();
	}
}
