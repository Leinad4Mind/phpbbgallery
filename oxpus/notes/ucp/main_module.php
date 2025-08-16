<?php

/**
*
* @package phpBB Extension - Personal notes
* @copyright (c) 2014 OXPUS - www.oxpus.net
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace oxpus\notes\ucp;

/**
* @package acp
*/
class main_module
{
	var $u_action;

	function main($id, $mode)
	{
		global $db, $user, $auth, $cache;
		global $phpbb_root_path, $phpbb_admin_path, $phpEx, $table_prefix;
		global $phpbb_container, $phpbb_extension_manager, $phpbb_log, $phpbb_path_helper;

		$config			= $phpbb_container->get('config');
		$language		= $phpbb_container->get('language');
		$request		= $phpbb_container->get('request');
		$template		= $phpbb_container->get('template');

		$ext_path		= $phpbb_extension_manager->get_extension_path('oxpus/notes', true);
		$ext_path_web	= $phpbb_path_helper->update_web_root_path($ext_path);

		$this->tpl_name = 'ucp_notes';
		$this->page_title = 'UCP_NOTES';

		$submit			= $request->variable('submit', '');

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
			$notes_popup = $request->variable('notes_popup', 0);

			$sql = 'UPDATE ' . USERS_TABLE . ' set ' . $db->sql_build_array('UPDATE', array(
				'user_popup_notes'	=> $notes_popup,
			)) . ' WHERE user_id = ' . (int) $user->data['user_id'];
			$db->sql_query($sql);

			$message = $language->lang('NOTES_CONFIG_SUCCESSFULL', '<a href="' . $this->u_action . '" />', '</a>');
			trigger_error($message);
		}

		$template->assign_vars(array(
			'NOTES_POPUP'	=> ($user->data['user_popup_notes']) ? true : false,
			'U_FORM_ACTION'	=> $this->u_action,
		));
	}
}
