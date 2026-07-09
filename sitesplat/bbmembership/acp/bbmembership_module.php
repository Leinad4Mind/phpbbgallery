<?php
/**
*
* BBmembership extension for the phpBB Forum Software package.
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\bbmembership\acp;

class bbmembership_module
{
	public $u_action;

	public function main($id, $mode)
	{
		global $phpbb_container, $request, $user, $config, $phpbb_extension_manager, $template, $phpbb_root_path;

		// Get an instance of the admin controller
		$admin_controller = $phpbb_container->get('sitesplat.bbmembership.admin_controller');

		// Make the $u_action url available in the admin controller
		$admin_controller->set_page_url($this->u_action);

		// Load a template from adm/style for our memberships
		$this->tpl_name = 'acp_bbmembership';

		// Set the page title for our ACP memberships
		$this->page_title = $user->lang('ACP_BBMEMBERSHIP_TITLE');

		if ($request->variable('action', '') == 'details')
		{
			$user->add_lang_ext('sitesplat/bbmembership', 'info_acp_bbmembership');
			$phpbb_container->get('sitesplat.BBCore.helper')->detail('sitesplat/bbmembership');
			$this->tpl_name = 'acp_ext_details';
		}

		if ($request->is_set_post('sync_membership') || $request->variable('action', '') == 'progressbar')
		{
			if ($request->variable('skiprows', 0) == 0)
			{
				$config->set('search_indexing_state', 0, true);
				$admin_controller->sync_membership();
			} else
			{
				$admin_controller->sync_membership();
			}
		}

		// Display setup
		$admin_controller->display();
	}
}
