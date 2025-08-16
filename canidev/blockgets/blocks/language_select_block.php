<?php
/*
* @package cBB Blockgets
* @version v2.0.1 01/02/2020
*
* @copyright (c) 2020 CaniDev
* @license https://opensource.org/licenses/gpl-license.php GNU Public License
*/

namespace canidev\blockgets\blocks;

// @ignore
if(!defined('IN_PHPBB'))
{
	exit;
}

class language_select_block extends base
{
	static $icon = 'fa-flag';

	public function init($method = '')
	{
		$this->tpl_name = 'language_select_block';
	
		$lang = $this->request->variable('lng', '');
		
		if($method == 'submit')
		{
			if($this->request->variable('default', 0) && $this->user->data['is_registered'] && $lang != $this->user->data['user_lang'])
			{
				// Update user language
				$sql = 'UPDATE ' . USERS_TABLE . "
					SET user_lang = '". $this->db->sql_escape($lang) . "'
					WHERE user_id = " . $this->user->data['user_id'];
				$this->db->sql_query($sql);
			}

			$this->helper->json->add(array(
				'redirect'		=> $this->helper->current_url(array('lng' => $lang), false)
			));

			return true;
		}
		
		$language_select = '<option disabled>' . $this->lang->lang('LANGUAGE_SELECT') . '</option>';

		$sql = 'SELECT lang_id, lang_iso, lang_local_name
			FROM ' . LANG_TABLE . '
			ORDER BY lang_local_name ASC';
		$result = $this->db->sql_query($sql, 3600);
		while($row = $this->db->sql_fetchrow($result))
		{
			$selected = ($this->user->lang_name == $row['lang_iso']) ? ' selected' : '';
			$language_select .= '<option value="' . $row['lang_iso'] . '"' . $selected . '>&nbsp;' . $row['lang_local_name'] . '&nbsp;</option>';
		}
		$this->db->sql_freeresult($result);

		$this->template->assign_vars(array(
			'LANGUAGE_SELECT' 	=> $language_select,
			'CAN_SAVE_LANGUAGE'	=> ($this->user->data['is_registered']) ? true : false,

			'S_BLOCK_HIDDEN_FIELDS'	=> build_hidden_fields(array(
				'jblgm'	=> $this->data['block_id']
			)),

			'U_LANGUAGE_DEFAULT'	=> (($lang && $lang != $this->user->data['user_lang']) ? preg_replace(array("#lng=$lang(&amp;|&|$)+#", '#\?$#'), '', $this->helper->current_url()) : ''),
		));

		return true;
	}
}
