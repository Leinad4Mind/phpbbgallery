<?php
/**
*
* BBAwards extension for the phpBB Forum Software package.
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\badge\acp;

class badge_module
{
	public $u_action;

	public function main($id, $mode)
	{
		global $phpbb_container, $request, $config, $phpbb_extension_manager, $template, $user, $phpbb_root_path;

		$user->add_lang_ext('sitesplat/badge', 'badge_acp');
		$admin_controller = $phpbb_container->get('sitesplat.badge.admin_controller');

		// Requests
		$action = $request->variable('action', '');
		$rule_id = $request->variable('rule_id', 0);
		$admin_controller->set_page_url($this->u_action);

		// Load a template from adm/style
		$this->tpl_name = 'manage_badge';
		$this->page_title = $user->lang('ACP_BADGE_MANAGE');

		// Quick-submit settings from the general options form
		if ($request->is_set_post('generalsubmit'))
		{
			$admin_controller->submit_badge_options();
		}

		$admin_controller->check_ext();


		// Perform any actions submitted by the user
		switch ($action)
		{
			case 'details':
				$user->add_lang_ext('sitesplat/badge', 'info_acp_badge');
				$phpbb_container->get('sitesplat.BBCore.helper')->detail('sitesplat/badge');
				$this->tpl_name = 'acp_ext_details';
			break;
			
			case 'add':
			case 'edit':
				$this->page_title = $user->lang(strtoupper("ACP_BADGE_$action"));
				$admin_controller->save_badge_rule($rule_id);
				return;
			break;

			case 'sync':
				$admin_controller->resync_badge_rule($rule_id);
			break;

			case 'delete':
				if (confirm_box(true))
				{
					$admin_controller->delete_badge_rule($rule_id);
				}
				else
				{
					confirm_box(false, $user->lang('ACP_BADGE_DELETE_CONFIRM'), build_hidden_fields(array(
						'rule_id'		=> $rule_id,
						'mode'			=> $mode,
						'action'		=> $action,
					)));
				}
			break;
		}
		$admin_controller->display_badge_rules();
	}
}
