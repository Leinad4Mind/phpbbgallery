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

	function main($id, $mode)
	{
		global $db, $user, $auth, $cache, $phpbb_log, $phpbb_container;

		$config			= $phpbb_container->get('config');
		$language		= $phpbb_container->get('language');
		$request		= $phpbb_container->get('request');
		$template		= $phpbb_container->get('template');

		$submit			= $request->variable('submit', '');

		$auth->acl($user->data);
		if (!$auth->acl_get('a_'))
		{
			trigger_error('NO_PERMISSION', E_USER_WARNING);
		}

		$this->tpl_name = 'acp_notes';
		$this->page_title = 'ACP_NOTES';

		if ($submit && !check_form_key('notes_config'))
		{
			trigger_error('FORM_INVALID', E_USER_WARNING);
		}

		if (!$submit)
		{
			add_form_key('notes_config');
		}

		if ($submit)
		{
			$notes_per_user = $request->variable('notes', 0);

			$config->set('notes', $notes_per_user);

			$phpbb_log->add('admin', $user->data['user_id'], $user->ip, 'NOTES_LOG_CONFIG');
			$cache->destroy('config');

			$message = $language->lang('NOTES_CONFIG_SUCCESSFULL', '<a href="' . $this->u_action . '">', '</a>') . adm_back_link($this->u_action);
			trigger_error($message);
		}

		$template->assign_vars(array(
			'NOTES'			=> $config['notes'],
			'U_FORM_ACTION'	=> $this->u_action,
		));
	}
}
