<?php
/*
* @package cBB Blockgets
* @version v2.0.3 26/07/2021
*
* @copyright (c) 2021 CaniDev
* @license https://opensource.org/licenses/gpl-license.php GNU Public License
*/

namespace canidev\blockgets\blocks;

class style_select_block extends base
{
	static $icon = 'fa-eye';

	public function init($method = '')
	{
		$this->tpl_name = 'style_select_block';
	
		$style = $this->request->variable('style', 0);
		
		if($method == 'submit')
		{
			if($this->request->variable('default', 0) && $this->user->data['is_registered'] && !$this->config['override_user_style'] && $style != $this->user->data['user_style'])
			{
				// Update user style
				$sql = 'UPDATE ' . USERS_TABLE . "
					SET user_style = $style
					WHERE user_id = " . (int)$this->user->data['user_id'];
				$this->db->sql_query($sql);
			}

			$this->helper->json->add(array(
				'redirect'		=> $this->helper->current_url(array('cstyle' => $style), false)
			));

			return true;
		}
		
		$style_select = '<option disabled>' . $this->lang->lang('STYLE_SELECT') . '</option>';

		$sql = 'SELECT style_id, style_name
			FROM ' . STYLES_TABLE . '
			WHERE style_active = 1 
			ORDER BY style_name ASC';
		$result = $this->db->sql_query($sql, 3600);
		while($row = $this->db->sql_fetchrow($result))
		{
			$selected = ($this->user->style['style_id'] == $row['style_id']) ? ' selected' : '';
			$style_select .= '<option value="' . $row['style_id'] . '"' . $selected . '>&nbsp;' . $row['style_name'] . '&nbsp;</option>';
		}
		$this->db->sql_freeresult($result);

		$this->template->assign_vars(array(
			'STYLE_SELECT' 		=> $style_select,
			'CAN_SAVE_STYLE'	=> ($this->user->data['is_registered'] && !$this->config['override_user_style']) ? true : false,

			'S_BLOCK_HIDDEN_FIELDS'	=> build_hidden_fields(array(
				'jblgm'	=> $this->data['block_id']
			)),

			'U_STYLE_DEFAULT'	=> (($style && $style != $this->user->data['user_style']) ? preg_replace(array("#style=$style(&amp;|&|$)+#", '#\?$#'), '', $this->helper->current_url()) : ''),
		));

		return true;
	}
}
