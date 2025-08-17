<?php
/**
*
* @package Active Sessions Extension
* @copyright (c) 2015 david63
* @license GNU General Public License, version 2 (GPL-2.0)
*
*/

namespace david63\activesessions\acp;

class activesessions_module
{
	public $u_action;

	/**
	* @internal param $id
	* @internal param $mode
	*/
	function main($id, $mode)
	{
		global $phpbb_container;

		$this->tpl_name		= 'active_sessions';
		$this->page_title	= $phpbb_container->get('language')->lang('ACTIVE_SESSIONS');

		// Get an instance of the admin controller
		$admin_controller = $phpbb_container->get('david63.activesessions.admin.controller');

		// Make the $u_action url available in the admin controller
		$admin_controller->set_page_url($this->u_action);

		$admin_controller->display_output();
	}
}
