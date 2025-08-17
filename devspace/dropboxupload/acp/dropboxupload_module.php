<?php
/**
*
* @package Dropbox Upload
* @copyright (c) 2016 david63
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
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

		$admin_controller->display_options();
	}
}
