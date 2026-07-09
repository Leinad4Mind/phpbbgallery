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

	function main()
	{
		global $db, $user, $language, $request, $template;

		$this->tpl_name = 'ucp_notes';
		$this->page_title = 'UCP_NOTES';

		$submit = $request->variable('submit', '');

		if ($submit)
		{
			if (!check_form_key('notes_config'))
			{
				trigger_error('FORM_INVALID', E_USER_WARNING);
			}

			$notes_popup = $request->variable('notes_popup', 0);
			$notes_slide = $request->variable('notes_slide', 0);

			$sql = 'UPDATE ' . USERS_TABLE . ' set ' . $db->sql_build_array('UPDATE', [
				'user_popup_notes'	=> $notes_popup,
				'user_slide_notes'	=> $notes_slide,
			]) . ' WHERE user_id = ' . (int) $user->data['user_id'];
			$db->sql_query($sql);

			$message = $language->lang('NOTES_CONFIG_SUCCESSFULL') . '<br /><br /><a href="' . $this->u_action . '">' . $language->lang('RETURN_TO', $language->lang('NOTES')) . '</a>';

			trigger_error($message);
		}

		add_form_key('notes_config');

		$template->assign_vars([
			'NOTES_POPUP'			=> ($user->data['user_popup_notes']) ? true : false,
			'NOTES_SLIDE'			=> ($user->data['user_slide_notes']) ? true : false,
			'U_NOTES_FORM_ACTION'	=> $this->u_action,
		]);
	}
}
