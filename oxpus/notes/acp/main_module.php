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
		global $db, $config, $user, $template, $request, $auth, $cache;
		global $phpbb_root_path, $phpbb_admin_path, $phpEx;
		global $phpbb_extension_manager, $table_prefix, $phpbb_container, $phpbb_path_helper;

		$provider			= new \phpbb\controller\ provider();
		$symphony_request	= new \phpbb\ symfony_request($request);
		$filesystem			= new \phpbb\ filesystem();
		$helper				= new \phpbb\controller\ helper($template, $user, $config, $provider, $phpbb_extension_manager, $symphony_request, $request, $filesystem, $phpbb_root_path, $phpEx);

		$submit				= $request->variable('submit', '');

		// Define the ext path
		$ext_path					= $phpbb_extension_manager->get_extension_path('oxpus/notes', true);
		$phpbb_path_helper			= $phpbb_container->get('path_helper');

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

			set_config('notes', $notes_per_user);

			add_log('admin', 'NOTES_LOG_CONFIG');
			$cache->destroy('config');

			$message = sprintf($user->lang['NOTES_CONFIG_SUCCESSFULL'], '<a href="' . $this->u_action . '">', '</a>') . adm_back_link($this->u_action);
			trigger_error($message);
		}

		$template->assign_vars(array(
			'NOTES'			=> $config['notes'],
			'U_FORM_ACTION'	=> $this->u_action,
		));
	}
}
