<?php
/**
*
* BBPoints extension for the phpBB Forum Software package.
*
* @copyright (c) 2015-2022 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\bbpoints\acp;

class bbpoints_module
{
	public $u_action;

	public function main($id, $mode)
	{
		global $phpbb_container, $request, $language, $config, $phpbb_extension_manager, $template, $phpbb_root_path;

		// Get an instance of the admin controller
		$admin_controller = $phpbb_container->get('sitesplat.bbpoints.admin_controller');

		// Make the $u_action url available in the admin controller
		$admin_controller->set_page_url($this->u_action);

		// Load a template from adm/style for our ACP auto groups
		$this->tpl_name = 'manage_bbpoints';

		// Set the page title for our ACP bbpoints
		$this->page_title = $language->lang('ACP_POINTS_INDEX_TITLE');

		if ($request->is_set_post('reset_points'))
		{
			if (confirm_box(true))
			{
				$admin_controller->reset_points();
			} else
			{
				// Request confirmation from the user to reset point
				confirm_box(false, $language->lang('RESET_POINTS_CONFIRM'), build_hidden_fields([
					'i'				=> $id,
					'mode'			=> $mode,
					'reset_points'	=> true,
				]));
			}
		}

		if ($request->is_set_post('sync_points') || $request->variable('action', '') == 'progressbar')
		{
			if ($request->variable('skiprows', 0) == 0)
			{
				$config->set('search_indexing_state', 0, true);
				$admin_controller->sync_points();
				$admin_controller->sync_post();
			} else
			{
				$admin_controller->sync_post();
			}
		}

		// Quick-submit settings from the general options form
		if ($request->is_set_post('set_config'))
		{
			if (($request->variable('group_id', 0) > 0 || $request->variable('transfer_to', 0) > 0 )&& $request->variable('transfer_amount', 0) != 0)
			{
				$admin_controller->transfer_amount();
			}
		
			$admin_controller->submit_config_options();
		}

		if ($request->variable('action', '') == 'details')
		{
			$language->add_lang('info_acp_bbpoints', 'sitesplat/bbpoints');
			$phpbb_container->get('sitesplat.BBCore.helper')->detail('sitesplat/bbpoints');
			$this->tpl_name = 'acp_ext_details';
		}

		// Display setup
		$admin_controller->display();
	}
}
