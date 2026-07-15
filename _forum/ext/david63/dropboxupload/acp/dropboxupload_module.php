<?php
/**
*
* @package Dropbox Upload
* @copyright (c) 2016 david63
* @license GNU General Public License, version 2 (GPL-2.0)
*
*/

namespace david63\dropboxupload\acp;

class dropboxupload_module
{
	public $u_action;

	function main($id, $mode)
	{
		global $phpbb_container;

		$this->tpl_name		= 'dropboxupload_manage';
		$this->page_title	= $phpbb_container->get('language')->lang('DROPBOX_UPLOAD');

		// Get an instance of the admin controller
		$admin_controller = $phpbb_container->get('david63.dropboxupload.admin.controller');

		// Make the $u_action url available in the admin controller
		$admin_controller->set_page_url($this->u_action);

		$admin_controller->display_options();
	}
}
