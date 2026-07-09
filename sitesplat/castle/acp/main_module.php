<?php
/**
*
* Castle
*
* @copyright (c) 2018 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\castle\acp;

use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class main_module
{
	var $u_action;

	function main($id, $mode)
	{
		global $user, $template, $request, $config, $phpbb_container;
		$controller_helper = $phpbb_container->get('controller.helper');

		$user->add_lang('acp/common');
		$this->tpl_name = 'castle';
		$this->page_title = $user->lang('ACP_CASTLE_TITLE');
		add_form_key('sitesplat/castle');

		if ($request->is_set_post('submit'))
		{
			if (!check_form_key('sitesplat/castle'))
			{
				trigger_error('FORM_INVALID');
			}

			$config->set('castle_app_id', $request->variable('castle_app_id', ''));
			$config->set('castle_api_secret', $request->variable('castle_api_secret', ''));
			$config->set('castle_hook_configured', $request->variable('castle_hook_configured', false));
			$config->set('castle_feedback_redirect_configured', $request->variable('castle_feedback_redirect_configured', false));

			trigger_error($user->lang('ACP_CASTLE_SETTING_SAVED') . adm_back_link($this->u_action));
		}

		$template->assign_vars(array(
			'U_ACTION'								=> $this->u_action,
			'CASTLE_APP_ID'							=> $config['castle_app_id'],
			'CASTLE_API_SECRET'						=> $config['castle_api_secret'],
			'CASTLE_HOOK_CONFIGURED'				=> $config['castle_hook_configured'],
			'CASTLE_FEEDBACK_REDIRECT_CONFIGURED'	=> $config['castle_feedback_redirect_configured'],
			'U_CASTLE_HOOK_ENPOINT'					=> $controller_helper->route('sitesplat_castle_hook', array(), true, '', UrlGeneratorInterface::ABSOLUTE_URL),
			'U_CASTLE_FEEDBACK_ENPOINT'				=> $controller_helper->route('sitesplat_castle_feedback', array(), true, '', UrlGeneratorInterface::ABSOLUTE_URL),
		));
	}
}
