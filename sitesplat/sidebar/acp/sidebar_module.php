<?php
/**
*
* @package BBSidebar
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\sidebar\acp;

class sidebar_module
{
	public $u_action;

	function main($id, $mode)
	{
		global $config, $user, $template, $request, $cache, $phpbb_container, $phpbb_root_path;

		if ($request->variable('action', '') == 'details')
		{
			$user->add_lang_ext('sitesplat/sidebar', 'info_acp_sidebar');
			$phpbb_container->get('sitesplat.BBCore.helper')->detail('sitesplat/sidebar');
			$this->tpl_name = 'acp_ext_details';
		} else
		{
			// Get an instance of the admin controller
			$admin_controller = $phpbb_container->get('sitesplat.sidebar.admin_controller');
			$admin_controller->set_page_url($this->u_action);

			$this->tpl_name = 'acp_sidebar';

			$admin_controller->display_sidebars();
		}
	}
}
