<?php

/**
*
* @package phpBB Extension - Personal notes
* @copyright (c) 2014 OXPUS - www.oxpus.net
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace oxpus\notes\acp;

/**
* @package acp
*/
class main_module
{
	var $u_action;
	var $edit_lang_id;
	var $lang_defs;

	function main()
	{
		global $user, $cache, $phpbb_log, $config, $language, $request, $template;

		$submit = $request->variable('submit', '');

		$this->tpl_name = 'acp_notes';
		$this->page_title = 'ACP_NOTES';

		if ($submit)
		{
			if (!check_form_key('notes_config'))
			{
				trigger_error('FORM_INVALID', E_USER_WARNING);
			}

			$notes_per_user = $request->variable('notes', 0);

			$config->set('notes', $notes_per_user);

			$phpbb_log->add('admin', $user->data['user_id'], $user->ip, 'NOTES_LOG_CONFIG');
			$cache->destroy('config');

			$message = $language->lang('NOTES_CONFIG_SUCCESSFULL') . adm_back_link($this->u_action);

			trigger_error($message);
		}

		add_form_key('notes_config');

		$template->assign_vars([
			'NOTES'			=> $config['notes'],
			'U_FORM_ACTION'	=> $this->u_action,
		]);
	}
}
