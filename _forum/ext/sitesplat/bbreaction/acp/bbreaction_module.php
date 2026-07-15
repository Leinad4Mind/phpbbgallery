<?php

/**
 *
 * BBReaction
 * @copyright (c) 2015-2022 SiteSplat All rights reserved
 * @license Proprietary
 *
 */

namespace sitesplat\bbreaction\acp;

class bbreaction_module
{
	public $u_action;

	public function main($id, $mode)
	{
		global $phpbb_container, $request, $config, $phpbb_extension_manager, $template, $user, $phpbb_root_path;

		// Get an instance of the admin controller
		$admin_controller = $phpbb_container->get('sitesplat.bbreaction.admin_controller');

		// Requests
		$action = $request->variable('action', '');
		$type_id = $request->variable('type_id', 0);

		// Make the $u_action url available in the admin controller
		$admin_controller->set_page_url($this->u_action);

		// Load a template from adm/style
		$this->tpl_name = 'manage_bbreaction';

		// Set the page title
		$this->page_title = $user->lang('ACP_BBREACTION');

		// Quick-submit settings from the general options form
		if ($request->is_set_post('generalsubmit')) {
			$admin_controller->submit_general_options();
		}

		// Perform any actions submitted by the user
		switch ($action) {
			case 'details':
				$user->add_lang_ext('sitesplat/bbreaction', 'info_acp_bbreaction');
				$phpbb_container->get('sitesplat.BBCore.helper')->detail('sitesplat/bbreaction');
				$this->tpl_name = 'acp_ext_details';
				break;

			case 'add':
			case 'edit':
				// Set the page title
				$this->page_title = $user->lang['ACP_BBREACTION_ADD'];

				// Load the save reaction type handle in the admin controller
				$admin_controller->save_reward_type($type_id);

				// Return to stop execution of this script
				return;
				break;

			case 'sync':
				// Resync reaction counter
				$admin_controller->resync_reward_type($type_id);
				break;

			case 'delete':
				// Use a confirm box routine when deleting an reaction type
				if (confirm_box(true)) {
					// Delete reaction type on confirmation from the user
					$admin_controller->delete_reward_type($type_id);
				} else {
					// Request confirmation from the user to delete reaction type
					confirm_box(false, $user->lang('ACP_BBREACTION_DELETE_CONFIRM'), build_hidden_fields([
						'type_id'		=> $type_id,
						'i'				=> $id,
						'mode'			=> $mode,
						'action'		=> $action,
					]));
				}
				break;

			case 'active':
				// Activate / Deactivate reaction type
				$admin_controller->activate($type_id);
				break;

			case 'move_up':
			case 'move_down':
				// Move reaction type
				$admin_controller->move_reward_type($type_id);
				break;
		}

		// Display reaction types
		$admin_controller->display_reward_types();
	}
}