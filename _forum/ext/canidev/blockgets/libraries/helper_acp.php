<?php
/*
* @name chat.php
* @package cBB Blockgets
* @version v2.0.0 30/05/2017
*
* @copyright (c) 2017 CaniDev
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/

namespace canidev\blockgets\libraries;

class helper_acp
{
	protected $db;
	protected $helper;
	protected $lang;
	protected $request;
	protected $template;
	protected $user;

	/**
	* Constructor
	*
	* @param \phpbb\db\driver\driver_interface			$db					DB Object
	* @param \canidev\blockgets\libraries\helper		$helper				Blockgets helper Object
	* @param \canidev\blockgets\libraries\language		$language			Blockgets language Object
	* @param \phpbb\request\request 					$request			Request object
	* @param \phpbb\template\template					$template     		Template object
	* @param \phpbb\user								$user				User object
	*
	* @access public
	*/
	public function __construct(\phpbb\db\driver\driver_interface $db, \canidev\blockgets\libraries\helper $helper, \canidev\blockgets\libraries\language $language, \phpbb\request\request $request, \phpbb\template\template $template, \phpbb\user $user)
	{
		$this->db		= $db;
		$this->helper	= $helper;
		$this->lang		= $language;
		$this->request	= $request;
		$this->template	= $template;
		$this->user		= $user;
	}

	/**
	 * icon_template
	 * Create a select with current img and new img request
	*/
	public function icon_template($key, $item = '', $type = 'image')
	{
		$label = strtoupper($type);
		
		$this->template->assign_vars(array(
			'HELPER_NAME'		=> 'icon',
			'IS_BLG_AJAX'		=> $this->request->is_ajax(),
			'IT_ID'				=> gen_rand_string(4),
			'IT_FILENAME'		=> ($type == 'image') ? $this->helper->build_image_filename($item) : '',
			'IT_KEY'			=> $key,
			'IT_LABEL_DELETE'	=> $this->lang->get("DELETE_$label"),
			'IT_LABEL_DIALOG'	=> $this->lang->get("SELECT_$label"),
			'IT_TYPE'			=> $type,
			'IT_VALUE'			=> $item,
		));
		
		return $this->display();
	}
	
	public function url_template($key, $row, $size = 0, $maxlength = 0, $check_key = '')
	{
		$name 		= 'config[' . $key . ']';
		$row[$key]	= (isset($row[$key]) ? $row[$key] : '');

		$result =  '<input type="text" id="' . $key . '" name="' . $name . '" value="' . $row[$key] . '"' .
			(($size) ? ' size="' . $size . '"' : '') .
			(($maxlength) ? ' maxlength="' . $maxlength . '"' : '') . ' />';
			
		if($check_key)
		{
			$name2		= 'config[' . $check_key . ']';
			$checked	= (!empty($row[$check_key]) ? ' checked = "checked"' : '');
			
			$result .= '<label class="full-label"><input type="checkbox" class="radio" name="' . $name2 . '" value="1"' . $checked . ' /> ' . $this->lang->get('LINK_WINDOW') . '</label>';
		}
		
		return $result;
	}
	
	public function easy_input_template($key, $value = '', $gallery_btn = false, $color_btn = false)
	{
		$this->template->assign_vars(array(
			'HELPER_NAME'		=> 'easy_input',
			'HP_ID'				=> gen_rand_string(4),
			'HP_KEY'			=> $key,
			'HP_VALUE'			=> $value,
			
			'IS_COLOR'		=> ($color_btn && preg_match('/#[A-Z0-9]{6}/', $value)) ? true : false,
			'COLOR_BTN'			=> $color_btn,
			'GALLERY_BTN'		=> $gallery_btn,
		));
		
		return $this->display();
	}

	/**
	 * build_editor
	 * Make a Textarea with "Full Editor" button
	*/
	public function build_editor($text, $key, $rows, $cols)
	{
		$this->template->assign_vars(array(
			'HELPER_NAME'		=> 'editor',
			'IT_ID'				=> gen_rand_string(4),
			'IT_KEY'			=> $key,
			'IT_COLS'			=> $cols,
			'IT_ROWS'			=> $rows,
			'IT_VALUE'			=> $text,
		));
		
		return $this->display();
	}

	public function build_list_actions($action_ary, $separator = '|')
	{
		$output = array();
		
		foreach($action_ary as $langid => $action)
		{
			$s_label = $this->lang->get($langid);
			
			if(strpos($langid, 'DELETE') !== false || strpos($langid, 'UNINSTALL') !== false)
			{
				$s_label = '<span class="critical-action">' . $s_label . '</span>';
			}
			
			$output[] = '<a href="' . $action . '">' . $s_label . '</a>';
		}
		
		return implode(' ' . $separator . ' ', $output);
	}
	
	/**
	 * forums_select
	 * Make select with the forum names
	*/
	public function forums_select($config_key = 'forums', $select_ids = false, $ignore_cats = false)
	{
		$output = '<select style="width: 100%;" name="' . $config_key . '[]" id="' . $config_key . '" multiple="multiple" size="5">';
		$output .= (($ignore_cats) ? make_forum_select($select_ids, false, true, true, true, true) : make_forum_select($select_ids, false, true));
		$output .= '</select>';

		return $output;
	}
	
	/**
	 * blg_groups_select
	 * Create a select with all groups
	*/
	public function groups_select($config_key, $select_groups, $is_config = true, $include_all = true)
	{
		$output = '';
		$group_ary = array();

		if(!empty($select_groups))
		{
			$group_ary = (is_array($select_groups) ? $select_groups : explode(',', $select_groups));
		}

		// Get all the groups
		$sql = 'SELECT DISTINCT group_type, group_name, group_id
			FROM ' . GROUPS_TABLE . '
			ORDER BY group_type DESC, group_name ASC';
		$result = $this->db->sql_query($sql);

		$output = '<div class="js-groups-select">
			<select class="blg-inputbox" name="' . $config_key . '[]" id="' . $config_key . '" multiple="multiple" size="5">';

		while($row = $this->db->sql_fetchrow($result))
		{
			$s_selected = (in_array($row['group_id'], $group_ary)) ? ' selected="selected"' : '';
			$output .= '<option' . (($row['group_type'] == GROUP_SPECIAL) ? ' class="sep"' : '') . ' value="' . $row['group_id'] . '"' . $s_selected . '>' . (($row['group_type'] == GROUP_SPECIAL) ? $this->lang->get('G_' . $row['group_name']) : $row['group_name']) . '</option>';
		}
		$this->db->sql_freeresult($result);

		$output .= '</select>';

		if($include_all)
		{
			$output .= '<label class="full-label"><input type="checkbox" class="radio" name="all_groups" value="1"' . (($select_groups == 'all' || $this->request->is_set_post('all_groups')) ? ' checked="checked"' : '') . '/> ' . $this->lang->get('ALL_GROUPS') . '</label>';
		}
		
		$output .= '</div>';

		return $output;
	}
	
	public function pagelinks_select($value)
	{
		$options = array(
			''			=> 'LINK_NONE',
			'top'		=> 'LINK_TOP',
			'bottom'	=> 'LINK_BOTTOM',
		);
		
		return $this->make_select($options, $value);
	}
	
	public function size_formatter($key, $data, $submit = false)
	{
		if($submit)
		{
			if(is_array($key))
			{
				foreach($key as $skey)
				{
					$data = $this->size_formatter($skey, $data, true);
				}
				
				return $data;
			}

			$type = 'px';
			
			if(isset($data[$key . '_type']))
			{
				$type = $data[$key . '_type'];
				unset($data[$key . '_type']);
			}
			
			$data[$key] .= $type;
			
			return $data;
		}
		else
		{
			$options = array(
				'px'	=> 'px',
				'%'		=> '%',
			);
			
			$number	= $type	= '';
			
			if(preg_match('#([0-9]+)(px|\%)?#', $data, $match))
			{
				$number = $match[1];
				$type	= (isset($match[2]) ? $match[2] : '');
			}

			$this->template->assign_vars(array(
				'HELPER_NAME'	=> 'size_formatter',
				'HP_ID'			=> gen_rand_string(4),
				'HP_KEY'		=> $key,
				'HP_VALUE'		=> $number,
				'HP_OPTIONS'	=> $this->make_select($options, $type),
			));
			
			return $this->display();
		}
	}
	
	/**
	 * scroll_select
	 * Make selects with scroller options
	*/
	public function scroll_select($item = '', $list = '')
	{
		$lists = array(
			'direction'		=> array('left', 'right', 'up', 'down'),
			'direction_x'	=> array('left', 'right'),
			'align'			=> array('left', 'center', 'right'),
		);

		if(!isset($lists[$list]))
		{
			return '';
		}

		$options = array();
		foreach($lists[$list] as $id)
		{
			$options[$id] =  $this->lang->get(strtoupper($id));
		}

		return $this->make_select($options, $item);
	}
	
	/**
	 * blg_make_select
	 * Build select input for blocks config
	*/
	public function make_select($options, $select = false, $parse_lang = true, $empty_label = false)
	{
		$string = '';
		
		$in_group = false;

		foreach($options as $value => $lang)
		{
			$title	= ($parse_lang) ? $this->lang->get($lang) : $lang;

			if(strpos($value, 'legend') !== false)
			{
				$string .= (($in_group) ? '</optgroup>' : '') . '<optgroup label="' . $title . '">';
				$in_group = true;
				
				continue;
			}

			$selected	= (($value == $select) ? ' selected="selected"' : '');
			$string .= '<option value="' . $value . '"' . $selected . '>' . $title . '</option>';
		}
		
		if($in_group)
		{
			$string .= '</optgroup>';
		}
		
		if(!$string && $empty_label !== false)
		{
			$string = '<option value="0">' . $this->lang->get($empty_label) . '</option>';
		}

		return $string;
	}
	
	/**
	 * counter_rst
	 * Make a button for global and local counter reset
	*/
	public function counter_rst($form_id = '')
	{
		return '<input class="blg-button small" name="counter_reset" value="' . $this->lang->get('RUN') . '" ' .
			(($form_id) ? 'type="button" onclick="jblockgets.counter_reset(\'' . $form_id . '\');"' : 'type="submit"') .
			' />';
	}
	
	private function display()
	{
		$this->template->set_filenames(array(
			'helper'	=> 'helper_body.html'
		));
		
		return $this->template->assign_display('helper');
	}
}
