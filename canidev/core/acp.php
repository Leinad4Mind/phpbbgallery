<?php
/*
* @package Ext Common Core
* @version v1.0.9 29/03/2021
*
* @copyright (c) 2021 CaniDev
* @license https://opensource.org/licenses/gpl-license.php GNU Public License
*/

namespace canidev\core;

// @ignore
if(!defined('IN_PHPBB'))
{
	exit;
}

class acp
{
	const SELECT_PARSE_LANG		= 1;
	const SELECT_MULTIPLE		= 2;
	
	protected $page_title;
	protected $tpl_name;

	public function page_header($canidev_id, $current_version)
	{
		$this->template->assign_vars(array(
			'U_ACTION'			=> $this->u_action,
			'U_HELP'			=> 'https://www.canidev.com/store/' . $canidev_id . '?rq=documentation&v=' . $current_version,
		));
		
		// Delete the cache in the first call after the installation (prevent error to load extension template events without clear the cache manually)
		if($this->config['cbb_asset_check'] != $this->config['assets_version'])
		{
			$this->config->set('cbb_asset_check', $this->config['assets_version']);
			$this->cache->purge();
		}	
	}

	protected function display_vars($display_vars, $tpl_key = 'options')
	{
		foreach($display_vars as $config_key => $vars)
		{
			if(!is_array($vars) && strpos($config_key, 'legend') === false)
			{
				continue;
			}

			if(strpos($config_key, 'legend') !== false)
			{
				$this->template->assign_block_vars($tpl_key, array(
					'S_LEGEND'		=> true,
					'LEGEND'		=> $this->lang->lang($vars)
				));
				continue;
			}
			
			if(!isset($this->new_config[$config_key]) && isset($vars['default']))
			{
				$this->new_config[$config_key] = $vars['default'];
			}

			$type = explode(':', $vars['type']);

			$content = build_cfg_template($type, $config_key, $this->new_config, $config_key, $vars);
			if(empty($content))
			{
				continue;
			}

			$this->template->assign_block_vars($tpl_key, array(
				'KEY'			=> $config_key,
				'TITLE'			=> $this->lang->lang($vars['lang']),
				'S_EXPLAIN'		=> ($this->lang->is_set($vars['lang'] . '_EXPLAIN') ? $this->lang->lang($vars['lang'] . '_EXPLAIN') : ''),
				'CONTENT'		=> $content,
				'DISPLAY'		=> (isset($vars['display']) && !$vars['display']) ? false : true,
			));

			unset($display_vars[$config_key]);
		}
	}

	public function get_template()
	{
		return $this->tpl_name;
	}
	
	public function get_title($prefix = '')
	{
		if($prefix)
		{
			return $this->lang->lang($prefix) . ' &bull; ' . $this->lang->lang($this->page_title);
		}

		return $this->page_title;
	}

	/**
	 * make_select
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
			$vars = array('options', 'key', 'select_ids', 'flags', 'classname');
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
			$title	= ($flags & self::SELECT_PARSE_LANG) ? $this->lang->lang($lang) : $lang;

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
	 * groups_select
	 * Create a select with all groups
	*/
	public function groups_select($config_key, $select_groups, $include_all = true)
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

		$output = '<div class="js-groups-select cbb-groups-selector">
			<select name="' . $config_key . '[]" id="' . $config_key . '" multiple="multiple" size="5">';

		while($row = $this->db->sql_fetchrow($result))
		{
			$s_selected = (in_array($row['group_id'], $group_ary)) ? ' selected="selected"' : '';
			$output .= '<option' . (($row['group_type'] == GROUP_SPECIAL) ? ' class="group-special"' : '') . ' value="' . $row['group_id'] . '"' . $s_selected . '>' . (($row['group_type'] == GROUP_SPECIAL) ? $this->lang->lang('G_' . $row['group_name']) : $row['group_name']) . '</option>';
		}
		$this->db->sql_freeresult($result);

		$output .= '</select>';

		if($include_all)
		{
			$all_groups_key = 'all_groups_' . $config_key;
			$output .= '<input type="checkbox" class="radio" id="all-groups-' . $config_key . '" name="' . $all_groups_key . '" value="1"' . (($select_groups == 'all' || $this->request->is_set_post($all_groups_key)) ? ' checked="checked"' : '') . '/><label for="all-groups-' . $config_key . '">' . $this->lang->lang('ALL_GROUPS') . '</label>';
		}
		
		$output .= '</div>';

		return $output;
	}
	
	/**
	 * forums_select
	 * Make select with the forum names
	*/
	public function forums_select($config_key = 'forums', $select_ids = false, $ignore_cats = false, $classname = '')
	{
		$output = '<select ' . (($classname) ? 'class="' . $classname . '" ' : '') . 'name="' . $config_key . '[]" id="' . $config_key . '" multiple="multiple" size="5">';
		$output .= (($ignore_cats) ? make_forum_select($select_ids, false, true, true, true, true) : make_forum_select($select_ids, false, true));
		$output .= '</select>';

		return $output;
	}
}
