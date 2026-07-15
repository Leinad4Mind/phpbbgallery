<?php
/**
* @package Ext Common Core
* @version 1.1.1 15/01/2023
*
* @copyright (c) 2023 CaniDev
* @license https://creativecommons.org/licenses/by-nc/4.0/
*
* @deprecated To be moved to controller/acp
*/

namespace canidev\core;

class acp extends \canidev\core\controller\acp
{
	const SELECT_PARSE_LANG		= 1;
	const SELECT_MULTIPLE		= 2;

	protected $lang; // Backward compatibility

	/**
	* Constructor
	*
	* @param \phpbb\cache\driver\driver_interface|null			$cache 				Cache instance
	* @param \phpbb\config\config 								$config				Config Object
	* @param \phpbb\language\language							$language			Language Object
	* @param \canidev\core\template|\phpbb\template				$template 			Template Object
	*
	* @access public
	*/
	public function __construct(
		$cache,
		\phpbb\config\config $config,
		\phpbb\language\language $language,
		$template
	)
	{
		$this->cache 		= $cache;
		$this->config 		= $config;
		$this->language 	= $language;
		$this->template 	= $template;
	}

	public function display_vars($display_vars, $tpl_key = 'options', $cfg_array = null, $individual_name = false)
	{
		$this->backward_language_compatibility();

		return parent::display_vars($display_vars, $tpl_key, $cfg_array, $individual_name);
	}

	public function get_title($prefix = '')
	{
		$this->backward_language_compatibility();

		return parent::get_title($prefix);
	}

	/**
	 * Build select input
	*/
	public function make_select($options, $key, $select_ids = '', $flags = self::SELECT_PARSE_LANG, $classname = '')
	{
		$in_group		= false;
		$string 		= '';
		$flags 			= (int)$flags; // Make sure it is a number
		$dispatcher 	= isset($this->dispatcher) ? $this->dispatcher : (isset($this->container) ? $this->container->get('dispatcher') : null);
		
		if(!is_array($select_ids) && !is_null($select_ids))
		{
			$select_ids = explode(',', $select_ids);
		}

		$this->backward_language_compatibility();

		if($dispatcher !== null)
		{
			/*
			* @event core.acp_make_select
			* @var array	options			Options to show in the select "value => title"
			* @var string	key				Key (name) for the select
			* @var array	select_ids		Selected values
			* @var int 		flags 			Config for the select
			* @var string 	classname 		Additional class name
			* @since 1.0.8
			*/
			$vars = ['options', 'key', 'select_ids', 'flags', 'classname'];
			extract($dispatcher->trigger_event('canidev.core.acp_make_select', compact($vars)));
		}

		$classname = ($classname) ? ' class="' . $classname . '"' : '';
		
		if($flags & self::SELECT_MULTIPLE)
		{
			$string = '<select' . $classname . ' id="' . $key . '" name="' . $key . '[]" multiple="multiple" size="8">';
		}
		else if($key !== false)
		{
			$select_ids = array($select_ids[0]);
			$string = '<select' . $classname . ' id="' . $key . '" name="config[' . $key . ']">';
		}

		foreach($options as $value => $lang)
		{
			$title	= ($flags & self::SELECT_PARSE_LANG) ? $this->language->lang($lang) : $lang;

			if(strpos($value, 'legend') !== false)
			{
				$string .= (($in_group) ? '</optgroup>' : '') . '<optgroup label="' . $title . '">';
				$in_group = true;
				
				continue;
			}

			$selected	= ($select_ids !== null && in_array($value, $select_ids) ? ' selected="selected"' : '');
			$string .= '<option value="' . $value . '"' . $selected . '>' . $title . '</option>';
		}
		
		if($in_group)
		{
			$string .= '</optgroup>';
		}
		
		if($key !== false || $flags & self::SELECT_MULTIPLE)
		{
			$string .= '</select>';
		}

		return $string;
	}
	
	/**
	 * Create a select with all groups
	*/
	public function groups_select($config_key, $select_groups, $include_all = true)
	{
		$output 	= '';
		$group_ary 	= [];

		if(!empty($select_groups))
		{
			$group_ary = is_array($select_groups) ? $select_groups : explode(',', $select_groups);
		}

		$this->backward_language_compatibility();

		// Get all the groups
		$sql = 'SELECT DISTINCT group_type, group_name, group_id
			FROM ' . GROUPS_TABLE . '
			ORDER BY group_type DESC, group_name ASC';
		$result = $this->db->sql_query($sql);

		$output = '<div class="js-groups-select cbb-groups-selector">
			<select name="' . $config_key . '[]" id="' . $config_key . '" multiple="multiple" size="5">';

		while($row = $this->db->sql_fetchrow($result))
		{
			$s_selected = (in_array($row['group_id'], $group_ary)) ? ' selected="selected"' : '';
			$output .= '<option' . (($row['group_type'] == GROUP_SPECIAL) ? ' class="group-special"' : '') . ' value="' . $row['group_id'] . '"' . $s_selected . '>' . (($row['group_type'] == GROUP_SPECIAL) ? $this->language->lang('G_' . $row['group_name']) : $row['group_name']) . '</option>';
		}
		$this->db->sql_freeresult($result);

		$output .= '</select>';

		if($include_all)
		{
			$all_groups_key = 'all_groups_' . $config_key;
			$output .= '<input type="checkbox" class="radio" id="all-groups-' . $config_key . '" name="' . $all_groups_key . '" value="1"' . (($select_groups == 'all' || $this->request->is_set_post($all_groups_key)) ? ' checked="checked"' : '') . '/><label for="all-groups-' . $config_key . '">' . $this->language->lang('ALL_GROUPS') . '</label>';
		}
		
		$output .= '</div>';

		return $output;
	}
	
	/**
	 * Make select with the forum names
	*/
	public function forums_select($config_key = 'forums', $select_ids = false, $ignore_cats = false, $classname = '')
	{
		$output = '<select ' . (($classname) ? 'class="' . $classname . '" ' : '') . 'name="' . $config_key . '[]" id="' . $config_key . '" multiple="multiple" size="5">';
		$output .= (($ignore_cats) ? make_forum_select($select_ids, false, true, true, true, true) : make_forum_select($select_ids, false, true));
		$output .= '</select>';

		return $output;
	}

	/* $this->lang is deprecated, kept for compatibility */
	private function backward_language_compatibility()
	{
		if(!isset($this->language) && isset($this->lang))
		{
			$this->language = $this->lang;
		}
	}
}
