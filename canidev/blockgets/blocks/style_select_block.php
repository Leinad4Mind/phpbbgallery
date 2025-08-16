<?php
/*
* @name style_select_block.php
* @package cBB Blockgets
* @version v2.0.0 30/05/2017
*
* @copyright (c) 2017 CaniDev
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/

namespace canidev\blockgets\blocks;

// @ignore
if(!defined('IN_PHPBB'))
{
	exit;
}

class style_select_block extends base
{
	static $icon = 'blg-icon-eye';

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
					WHERE user_id = " . $this->user->data['user_id'];
				$this->db->sql_query($sql);
			}

			$this->helper->trigger_error(array(
				'redirect'		=> $this->helper->current_url(array('cstyle' => $style), false)
			), false);

			return true;
		}
		
		$style_select	= '<option selected="selected" disabled="disabled">' . $this->lang->get('STYLE_SELECT') . '</option>';
		$num_styles		= 0;

		$sql = 'SELECT style_id, style_name
			FROM ' . STYLES_TABLE . '
			WHERE style_active = 1 
			ORDER BY style_name ASC';
		$result = $this->db->sql_query($sql, 3600);
		while($row = $this->db->sql_fetchrow($result))
		{
			$selected = ($this->user->style['style_id'] == $row['style_id']) ? ' selected="selected"' : '';
			$style_select .= '<option value="' . $row['style_id'] . '"' . $selected . '>&nbsp;' . $row['style_name'] . '&nbsp;</option>';

			$num_styles++;
		}
		$this->db->sql_freeresult($result);

		$this->template->assign_vars(array(
			'STYLE_SELECT' 		=> $style_select,
			'S_TOTAL_STYLES'	=> $num_styles,
			'CAN_SAVE_STYLE'	=> ($this->user->data['is_registered'] && !$this->config['override_user_style']) ? true : false,

			'S_BLOCK_HIDDEN_FIELDS'	=> build_hidden_fields(array(
				'jblgm'	=> $this->data['block_id']
			)),

			'U_STYLE_DEFAULT'	=> (($style && $style != $this->user->data['user_style']) ? preg_replace(array("#style=$style(&amp;|&|$)+#", '#\?$#'), '', $this->helper->current_url()) : ''),
		));

		return true;
	}
}
