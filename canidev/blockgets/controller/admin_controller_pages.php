<?php
/**
 * @package cBB Blockgets
 * @version 2.0.7 01/07/2024
 *
 * @copyright (c) 2024 CaniDev
 * @license https://creativecommons.org/licenses/by-nc/4.0/
 */

namespace canidev\blockgets\controller;

use canidev\blockgets\libraries\constants;
use \canidev\core\JsonResponse;

class admin_controller_pages extends admin_controller_base
{
	/** @var \canidev\blockgets\libraries\links */
	protected $filters;

	/** @var \canidev\core\Media */
	protected $media;

	/**
	 * {@inheritDoc}
	 */
	protected function _display($mode)
	{
		$this->tpl_name	= 'acp_blockgets_pages';
		
		$page_id 	= $this->request->variable('p', 0);
		$submit		= $this->request->is_set_post('submit');
		$board_url	= generate_board_url() . '/';
		
		$action 	= $this->request->variable('action', '');
		$action		= $this->request->is_set_post('add') ? 'add' : $action;

		$this->page_title = 'PAGES_TITLE';
		
		$this->media = $this->helper->get_media(true, true);

		if($this->manage_page($page_id, $action, $submit) !== false)
		{
			return;
		}
		
		$page_ary	= $this->obtain_pagelist();
		$ignore_ary	= [];

		foreach($page_ary as $page_type => $rows)
		{
			foreach($rows as $row_id => $row)
			{
				if(!$row_id)
				{
					$this->template->assign_block_vars('pagerow', [
						'S_LEGEND'		=> $this->language->lang($row),
						'S_EXPLAIN'		=> $this->language->lang($row . '_EXPLAIN'),
					]);
					
					continue;
				}
				
				$s_url	= '';
				$switch	= ($row['page_enabled']) ? 'DISABLE' : 'ENABLE';

				$u_actions = [
					$switch		=> $this->form_action . '&amp;action=' . strtolower($switch) . '&amp;p=' . $row['page_id'],
					'MANAGE'	=> $this->form_action . '&amp;action=manage&amp;p=' . $row['page_id'],
					'EDIT'		=> $this->form_action . '&amp;action=edit&amp;p=' . $row['page_id'],
					'DELETE'	=> $this->form_action . '&amp;action=delete&amp;p=' . $row['page_id'],
				];
				
				switch($page_type)
				{
					case constants::PAGE_HOME:
						// Delete action is no available for Home Page
						unset($u_actions['DELETE']);
						
						$s_url = $this->helper->route('canidev_blockgets_controller', [], true, false, true);
					break;
						
					case constants::PAGE_CUSTOM:
						$s_url = $this->helper->route('canidev_blockgets_page_' . $row['page_id'], [], true, false, true);
					break;
					
					case constants::PAGE_FORUM:
						$s_url = $row['page_alias'] . '.' . $this->php_ext;

						if(strpos($row['page_alias'], 'app/') === 0)
						{
							$row['page_title'] = (strpos($row['page_title'], 'APP/') === 0) ? $row['page_alias'] : $row['page_title'];
							$s_url = ((!$this->config['blg_rewrite']) ? 'app.' . $this->php_ext . '/' : '') . str_replace('app/', '', $row['page_alias']);
						}

						$s_url = $board_url . $s_url;
						
						$ignore_ary[] = $row['page_alias'];
					break;
				}
				
				$page_row = [
					'S_ACTIONS'			=> $this->helper_acp->build_list_actions($u_actions),
					'S_ID'				=> $row['page_id'],
					'S_TITLE'			=> $row['page_title'],
					'S_STATE'			=> ($row['page_enabled']) ? 'active' : 'inactive',
					'S_URL'				=> $this->clear_path($s_url),
				];
				
				if($row['page_type'] == constants::PAGE_FORUM)
				{
					$page_row['S_SHOW_FILTERS'] = true;

					if(!empty($row['filters']))
					{
						foreach($row['filters'] as $id => $filter)
						{
							$row['filters'][$id] = $filter['method'] . ': ' . $filter['param'];
						}
						
						$page_row['S_FILTERS'] = implode('<br />', $row['filters']);
					}
				}

				/**
				 * @event blockgets.acp_pages_row
				 * @var array	page_row		The output array
				 * @var array	row				The original data
				 * @since 2.0.0
				 */
				$vars = ['page_row', 'row'];
				extract($this->dispatcher->trigger_event('blockgets.acp_pages_row', compact($vars)));

				$this->template->assign_block_vars('pagerow', $page_row);
			}
		}

		$this->template->assign_vars([
			'S_TITLE'			=> $this->language->lang('PAGES_TITLE'),
			'S_TITLE_EXPLAIN'	=> $this->language->lang('PAGES_TITLE_EXPLAIN'),
			'S_PAGE_LIST'		=> true,
			'S_FILE_OPTIONS'	=> $this->build_file_select($ignore_ary),
			
			'U_ACTION'			=> $this->form_action,
		]);
	}
	
	/**
	 * Obtain page list
	 * 
	 * @param array|false 	$ignore_ids
	 * @param bool 			$only_rows
	 * 
	 * @return array
	 */
	function obtain_pagelist($ignore_ids = false, $only_rows = false)
	{
		$page_ary = [
			constants::PAGE_HOME		=> ['PAGE_HOME'],
			constants::PAGE_FORUM		=> ['PAGE_FORUM'],
			constants::PAGE_CUSTOM		=> ['PAGE_CUSTOM'],
		];
		
		$page_rows = [];
		
		$sql = 'SELECT *
			FROM ' . $this->tables['pages'] . '
			ORDER BY page_type, page_alias, page_title';
		$result = $this->db->sql_query($sql);
		while($row = $this->db->sql_fetchrow($result))
		{
			if(!$row['page_title'])
			{
				$row['page_title'] = strtoupper(str_replace(".{$this->php_ext}", '', basename($row['page_alias'])));
			}
				
			$row['page_title'] = ($this->language->is_set($row['page_title']) ? $this->language->lang($row['page_title']) : ucfirst(strtolower($row['page_title'])));

			if($unserialize_config = @unserialize($row['page_data']))
			{
				$row = array_merge($row, $unserialize_config);
			}
			
			if($ignore_ids !== false && in_array($row['page_id'], $ignore_ids))
			{
				continue;
			}
			
			if($only_rows)
			{
				$page_rows[$row['page_id']] = $row;
			}
			else
			{
				$page_ary[$row['page_type']][] = $row;
			}
		}
		$this->db->sql_freeresult($result);
		
		if($only_rows)
		{
			return $page_rows;
		}
		
		// Remove empty groups of pages
		foreach($page_ary as $page_type => $page_data)
		{
			if(sizeof($page_data) == 1)
			{
				unset($page_ary[$page_type]);
			}
		}
		
		return $page_ary;
	}
	
	/**
	 * Manage pages
	 * 
	 * @param int 		$page_id
	 * @param string	$action
	 * @param bool 		$submit
	 * 
	 * @return bool
	 */
	function manage_page($page_id, $action, $submit)
	{
		$page_ids	= $this->request->variable('page_ids', [0]);
		$alias		= $this->request->variable('alias', '');
		
		if(empty($page_ids) && $page_id)
		{
			$page_ids = [(int)$page_id];
		}
		
		// Insert a page with default values if not exists
		if(!$page_id && $alias && in_array($action, ['edit', 'manage']))
		{
			$page_id = $this->insert_page($alias);
		}

		if(empty($page_ids) && !$page_id && $action != 'add')
		{
			return false;
		}
		
		$error = [];
		
		$hidden_fields = [
			'p'			=> $page_id,
			'action'	=> $action,
		];

		switch($action)
		{
			case 'enable':
			case 'disable':
				$sql = 'UPDATE ' . $this->tables['pages'] . '
					SET page_enabled = ' . (($action == 'enable') ? 1 : 0) . '
					WHERE ' . $this->db->sql_in_set('page_id', $page_ids);
				$this->db->sql_query($sql);
				
				// If we disable the home page, update the home_type config
				if($action == 'disable' && $this->config['blg_home_type'] != constants::TYPE_FORUM_SECONDARY)
				{
					$sql = 'SELECT page_id
						FROM ' . $this->tables['pages'] . '
						WHERE page_type = ' . constants::PAGE_HOME;
					$result = $this->db->sql_query($sql);
					$home_page_id = (int)$this->db->sql_fetchfield('page_id');
					$this->db->sql_freeresult($result);
					
					if(in_array($home_page_id, $page_ids))
					{
						$this->config->set('blg_home_type', constants::TYPE_FORUM_SECONDARY);
					}
				}
				
				$this->cache->destroy('_blockgets_pages');

				$this->helper->json->add(['message' => $this->language->lang('PAGE_UPDATED')]);
				return false;

			case 'edit':
				$sql = 'SELECT *
					FROM ' . $this->tables['pages'] . "
					WHERE page_id = $page_id";
				$result = $this->db->sql_query($sql);
				$page_data = $this->db->sql_fetchrow($result);
				$this->db->sql_freeresult($result);
				
				if(!$page_data)
				{
					return false;
				}

				unset($page_data['page_id']);
				
				if($unserialize_config = @unserialize($page_data['page_data']))
				{
					$page_data = array_merge($page_data, $unserialize_config);
				}

			// no break;

			case 'add':
				if($action == 'add')
				{
					$page_file = $this->request->variable('page_file', '');

					// Default data for new pages
					$page_data = [
						'page_alias'	=> '',
						'page_title'	=> '',
						'page_enabled'	=> 1,
						'page_groups'	=> 'all',
						'filters'		=> [],
						'page_theme'	=> 'default',
						
						'left_column_width'		=> '200px',
						'right_column_width'	=> '200px',
						'block_space'			=> '6px',
						'header'				=> 1,
						'footer'				=> 1,
					];

					if($page_file == 'custom')
					{
						$page_data['page_type'] = constants::PAGE_CUSTOM;
					}
					else
					{
						$page_data['page_type']		= constants::PAGE_FORUM;
						$page_data['page_alias']	= $page_file;
					}
					
					$hidden_fields['page_file']	= $page_file;
				}

				$serialize_ary = ['filters', 'description', 'header', 'footer', 'page_theme', 'background', 'stylesheet', 'style', 'logo',
					'left_column_width', 'right_column_width', 'block_space', 'link_position', 'link_icon'];
				
				$page_theme_options = [
					'default'		=> 'PAGE_THEME_DEFAULT',
					'background'	=> 'PAGE_THEME_BACKGROUND',
					'style'			=> 'PAGE_THEME_STYLE',
					'stylesheet'	=> 'PAGE_THEME_STYLESHEET',
				];
				
				// Style option is not available on forum pages
				if($page_data['page_type'] == constants::PAGE_FORUM)
				{
					unset($page_theme_options['style']);
				}
				
				$display_vars = [
					'legend1'			=> 'MANAGE_PAGE',
					'page_enabled'		=> ['lang' => 'PAGE_ENABLED',		'validate' => 'bool',			'type' => 'radio:yes_no'],
					'page_alias'		=> ['lang' => 'PAGE_ALIAS',			'validate' => 'string',			'type' => 'text:40:200'],
					'page_title'		=> ['lang' => 'PAGE_TITLE',			'validate' => 'string:1:200',	'type' => 'text:40:255'],
					'page_groups'		=> ['lang' => 'PAGE_GROUP',			'type' => 'custom',				'function' => [$this->tools, 'groups_select'],	'params' => ['page_groups', '{CONFIG_VALUE}']],
					'filters'			=> ['lang' => 'PAGE_FILTERS',		'type' => 'custom', 			'function' => [$this, 'display_filter_list']],
					
					'legend2'		=> 'ADVANCED_OPTIONS',
					'description'	=> ['lang' => 'PAGE_DESCRIPTION',	'validate' => 'string:0:255', 	'type' => 'text:40:255'],
					'header'		=> ['lang' => 'SHOW_HEADER',		'validate' => 'bool',			'type' => 'radio:yes_no'],
					'footer'		=> ['lang' => 'SHOW_FOOTER',		'validate' => 'bool',			'type' => 'radio:yes_no'],
					'logo'			=> ['lang' => 'PAGE_LOGO',			'validate' => 'string:0:255',	'type' => 'custom',		'function' => [$this->helper_acp, 'easy_input_template'], 	'params' => ['{KEY}', '{CONFIG_VALUE}', 1]],
					'page_theme'	=> ['lang' => 'PAGE_THEME',			'validate' => 'string',			'type' => 'custom',		'function' => ['tools', 'make_select'],						'params' => [$page_theme_options, '{KEY}', '{CONFIG_VALUE}']],
					'background'	=> ['lang' => 'PAGE_BACKGROUND',	'validate' => 'string:1:200',	'type' => 'custom',		'function' => [$this->helper_acp, 'easy_input_template'], 	'params' => ['{KEY}', '{CONFIG_VALUE}', 1, 1],	'display' => false],
					'stylesheet'	=> ['lang' => 'PAGE_STYLESHEET',	'type' => 'textarea:10:40',		'display' => false],
					'style'			=> ['lang' => 'PAGE_STYLE',			'validate' => 'int:1',			'type' => 'select',	'function' => 'style_select',	'params' => ['{CONFIG_VALUE}'],	'display' => false],

					'legend3'				=> 'COLUMN_SETTINGS',
					'left_column_width'		=> ['lang' => 'LEFT_COLUMN',		'type' => 'custom',		'function' => [$this->helper_acp, 'size_formatter'], 	'params' => ['{KEY}', '{CONFIG_VALUE}']],
					'right_column_width'	=> ['lang' => 'RIGHT_COLUMN',		'type' => 'custom',		'function' => [$this->helper_acp, 'size_formatter'], 	'params' => ['{KEY}', '{CONFIG_VALUE}']],
					'block_space'			=> ['lang' => 'BLOCK_SPACE',		'type' => 'custom',		'function' => [$this->helper_acp, 'size_formatter'], 	'params' => ['{KEY}', '{CONFIG_VALUE}']],
				];
				
				if($page_data['page_type'] == constants::PAGE_CUSTOM)
				{
					$display_vars += [
						'legend4'			=> 'PAGE_LINK',
						'link_position'		=> ['lang' => 'PAGE_LINK_POSITION',	'type' => 'custom',		'function' => [$this->helper_acp, 'pagelinks_select']],
						'link_icon'			=> ['lang' => 'PAGE_LINK_ICON',		'type' => 'custom',		'function' => [$this->media, 'buildSelector'],	'params' => ['{KEY}', 'icon', '{CONFIG_VALUE}', 1],	'default' => ''],
					];
				}
				
				/**
				 * @event blockgets.acp_page_vars
				 * @var array	display_vars		Variables to show
				 * @var array	page_data			Current page data
				 * @var string	action				Current action
				 * @var array 	serialize_ary 		Variable keys serialized as page_data
				 * @since 2.0.0
				 */
				$vars = ['display_vars', 'page_data', 'action', 'serialize_ary'];
				extract($this->dispatcher->trigger_event('blockgets.acp_page_vars', compact($vars)));

				switch($page_data['page_type'])
				{
					case constants::PAGE_FORUM:
						unset($display_vars['description']);

						$this->filters = $this->container->get('canidev.blockgets.admin.links');
						
						$link_base_action = $this->form_action . '&amp;action=' . $action;
						$link_base_action .= '&amp;' . (($action == 'add') ? 'page_file=' . $page_file : 'p=' . $page_id);

						$this->filters
							->set_options([
								'format'	=> 'minimal',
								'key'		=> 'filters',
								'type'		=> constants::LIST_TYPE_NONE,
								'mask'		=> ['title' => 'param',	'subtitle' => 'method'],
							])
							->set_data($page_data, (($action == 'edit') ? 'p' . $page_id : 0))
							->set_base_url($link_base_action)
							->set_events([
								'edit.before'	=> [$this, 'filter_edit_before'],
							]);
							
						// Execute the ajax action over the links in this point
						if($this->request->is_ajax())
						{
							$this->filters->execute_action();
						}

						unset($display_vars['style']);
					
					// no break
					
					case constants::PAGE_HOME:
						unset($display_vars['page_alias']);
						
						if($page_data['page_type'] == constants::PAGE_FORUM)
						{
							break;
						}

					case constants::PAGE_CUSTOM:
						unset($display_vars['filters']);
					break;
				}

				if(isset($_REQUEST['config']))
				{
					$page_data = array_merge($page_data, $this->request->variable('config', ['' => ''], true));
					$page_data['page_groups'] = $this->tools->groups_select_submit('page_groups');
					
					// Format some variables
					$page_data = $this->helper_acp->size_formatter([
						'left_column_width',
						'right_column_width',
						'block_space'
					], $page_data, true);
				}

				if($submit)
				{
					// Allows empty title for forum pages (use default)
					if($page_data['page_type'] == constants::PAGE_FORUM)
					{
						$display_vars['page_title']['validate'] = 'string:0:200';
					}
					
					// Disable the check for no selected page themes
					foreach($page_theme_options as $key => $null)
					{
						if($page_data['page_theme'] == 'default' || $key != $page_data['page_theme'])
						{
							unset($display_vars[$key], $page_data[$key]);
						}
					}
					
					// check the page alias
					if($page_data['page_type'] == constants::PAGE_CUSTOM)
					{
						if($page_data['page_alias'] && !preg_match('#^([a-z0-9_-]+)$#', $page_data['page_alias']))
						{
							$error[] = $this->language->lang('PAGE_ALIAS_ERROR');	
						}
					}
					
					// We validate the complete config if whished
					validate_config_vars($display_vars, $page_data, $error);

					/**
					 * @event blockgets.acp_page_check_vars
					 * @var array	page_data		Submitted data
					 * @var array	error			Array with error messages
					 * @since 2.0.0
					 */
					$vars = ['page_data', 'error'];
					extract($this->dispatcher->trigger_event('blockgets.acp_page_check_vars', compact($vars)));
				}

				// Do not write values if there is an error
				if(sizeof($error))
				{
					$submit = false;
				}

				if($submit)
				{
					if($page_data['page_type'] == constants::PAGE_FORUM && ($list_data = $this->filters->acp_submit()) !== false)
					{
						$page_data['filters'] = $list_data;
					}

					// Serialize values
					$to_serialize = [];

					foreach($serialize_ary as $config_name)
					{
						$to_serialize[$config_name] = (isset($page_data[$config_name]) ? $page_data[$config_name] : '');
						unset($page_data[$config_name]);
					}
					
					$page_data['page_data'] = (count($to_serialize) ? serialize($to_serialize) : '');

					if($action == 'add')
					{
						$sql = 'INSERT INTO ' . $this->tables['pages'] . $this->db->sql_build_array('INSERT', $page_data);
						$message = 'ADDED';
					}
					else
					{
		            	$sql = 'UPDATE ' . $this->tables['pages'] . '
							SET ' . $this->db->sql_build_array('UPDATE', $page_data) . "
							WHERE page_id = $page_id";

		                $message = 'UPDATED';
					}
					
					$this->db->sql_query($sql);
					
					// Set the global values if needed
					switch($page_data['page_type'])
					{
						case constants::PAGE_FORUM:
							// Insert forum content block if neccessary
							if($action == 'add')
							{
								$page_id = $this->db->sql_nextid();
							}
								
							$this->insert_forum_block($page_id, true);
						break;
					}
					
					$this->destroy_pages_cache();

					$title = ($page_data['page_title']) ? $this->language->lang($page_data['page_title']) : $page_data['page_alias'] . ".{$this->php_ext}";
	
					$this->log->add('admin', $this->user->data['user_id'], $this->user->ip, "LOG_PAGE_$message", time(), [$title]);
					
					$this->helper->json->send([
						'message'		=> $this->language->lang("PAGE_$message"),
						'returnUrl'		=> $this->form_action
					]);
				}

				$this->display_vars($display_vars, 'options', $page_data);
				
				$title = 'PAGES_' . strtoupper($action) . '_TITLE';
				
				if(!$page_data['page_title'])
				{
					$page_data['page_title'] = strtoupper(str_replace(".{$this->php_ext}", '', basename($page_data['page_alias'])));
				}
					
				$page_data['page_title'] = ($this->language->is_set($page_data['page_title']) ? $this->language->lang($page_data['page_title']) : ucfirst(strtolower($page_data['page_title'])));

				$this->page_title = $this->language->lang($title, $page_data['page_title']);
				
				$this->template->assign_vars([
					'S_TITLE'			=> $this->page_title,
					'S_TITLE_EXPLAIN'	=> $this->language->lang($title . '_EXPLAIN'),
				]);
			break;
		
			case 'delete':
				if(confirm_box(true))
				{
					$page_titles = [];

					// Get the page titles before remove and exclude the portal page if selected (for batch actions)
					$page_ary = $this->obtain_pagelist(false, true);
					
					foreach($page_ids as $id => $page_id)
					{
						if(!isset($page_ary[$page_id]) || $page_ary[$page_id]['page_type'] == constants::PAGE_HOME)
						{
							unset($page_ids[$id]);
							continue;
						}

						$page_titles[] = $page_ary[$page_id]['page_title'];
					}
					
					if(!sizeof($page_ids))
					{
						$this->helper->json->send([
							'message'	=> $this->language->lang('ACTION_ERROR'),
							'status'	=> JsonResponse::JSON_STATUS_ERROR,
						]);
					}

					// Remove the block in the pages
					$sql = 'DELETE FROM ' . $this->tables['blocks'] . '
						WHERE ' . $this->db->sql_in_set('block_page', $page_ids);
					$this->db->sql_query($sql);

					// Remove the pages
					$sql = 'DELETE FROM ' . $this->tables['pages'] . '
						WHERE ' . $this->db->sql_in_set('page_id', $page_ids);
					$this->db->sql_query($sql);

					$this->destroy_pages_cache();

					$this->log->add('admin', $this->user->data['user_id'], $this->user->ip, 'LOG_PAGE_REMOVED', time(), [implode(', ', $page_titles)]);
					
					$this->helper->json->send([
						'message' => $this->language->lang('PAGE_REMOVED', sizeof($page_ids))
					]);
				}
				else
				{
					confirm_box(
						false,
						$this->language->lang('CONFIRM_PAGE_DELETE'),
						build_hidden_fields([
							'page_ids'	=> $page_ids,
							'action'	=> 'delete',
						]),
						'@canidev_core/confirmbox.html'
					);
					
					return false;
				}
			break;
			
			case 'manage':
				$this->page_title = 'ACP_MANAGE_BLOCKS';
				
				$block_ids	= $this->request->is_set_post('block_id_list') ? $this->request->variable('block_id_list', [0]) : [$this->request->variable('b', 0)];
				$subaction	= $this->request->variable('subaction', '');

				if($this->manage_block($block_ids, $page_id, $subaction, $submit) !== false)
				{
					return;
				}

				$page_ary = $this->obtain_pagelist(false, true);
				
				// If no page, redirect to page's list
				if(!isset($page_ary[$page_id]))
				{
					redirect($this->form_action);
				}
				
				$page_data = $page_ary[$page_id];
				
				$blocks_dir = $this->helper->get_ext_path() . 'blocks/';
				$has_forum_block = false;
				$block_row = [0 => []];

				// Load the blocks
				$sql = 'SELECT *
					FROM ' . $this->tables['blocks'] . "
					WHERE block_page = $page_id
					ORDER BY block_order ASC";
					
				$result_block = $this->db->sql_query($sql);
				while($row = $this->db->sql_fetchrow($result_block))
				{
					$parent_id = (int)$row['parent_id'];
					
					if(!isset($block_row[$parent_id]))
					{
						$block_row[$parent_id] = [];
					}
					
					$block_row[$parent_id][] = $row;
					
					if($row['block_alias'] == 'forum_content')
					{
						$has_forum_block = true;
					}
				}
				$this->db->sql_freeresult($result_block);
				
				// If is a forum page and dont' have block with forum content, create it
				if($page_data['page_type'] == constants::PAGE_FORUM && !$has_forum_block)
				{
					$block_row[0][] = $this->insert_forum_block($page_id);
				}
				
				foreach($block_row[0] as $row)
				{
					$block_position_name = \canidev\blockgets\libraries\blockgets::$block_position_names[$row['block_position']] . '_block';
					
					// Put block into general template to display
					if($row['block_alias'] == 'group')
					{
						$this->template->assign_block_vars($block_position_name, [
							'BLOCK_ID'			=> $row['block_id'],
							'IS_GROUP'			=> true,
							'S_HIDDEN_FIELDS'	=> build_hidden_fields([
								$block_position_name . '[]'			=> $row['block_id'],
								'sizes[' . $row['block_id'] . ']' 	=> $row['block_content'],
							]),
							
							'U_REMOVE'			=> $this->form_action . '&amp;p=' . $page_id . '&amp;action=manage&amp;b=' . $row['block_id'] . '&amp;subaction=delete',
						]);
						
						if(isset($block_row[$row['block_id']]))
						{
							foreach($block_row[$row['block_id']] as $subrow)
							{
								$this->block_to_template($block_position_name . '.blocks', $subrow, $page_id);
							}
						}
					}
					else
					{
						$this->block_to_template($block_position_name, $row, $page_id);
					}
				}
				
				// Read all the available blocks
				$block_html = [];

				if($dir = @opendir($blocks_dir))
				{
					while(($file = @readdir($dir)) !== false)
					{
						if(preg_match('#^(([^&\'"<>]+)_(block|addon)+)\.php$#i', $file, $match))
						{
							$block_html[$match[1]] = $this->get_block_info($match[1], true);
						}
					}
					closedir($dir);
					
					asort($block_html);
				}

				foreach($block_html as $alias => $info)
				{
					if($info === false)
					{
						continue;
					}

					$this->template->assign_block_vars('block_alias', [
						'S_TITLE' 		=> $info['title'],
						'S_EXPLAIN'		=> str_replace('"', "'", $info['explain']),
						'S_ICON'		=> $info['icon'],
						'U_ACTION'		=> $this->form_action . '&amp;p=' . $page_id . '&amp;action=manage&amp;subaction=add&amp;block_alias=' . urlencode($alias)
					]);
				}	
				unset($block_html);
				
				$this->page_title = $this->language->lang('PAGES_BLOCKS_TITLE', $page_data['page_title']);
				
				$this->template->assign_vars([
					'S_TITLE'			=> $this->page_title,
					'S_TITLE_EXPLAIN'	=> $this->language->lang('PAGES_BLOCKS_TITLE_EXPLAIN'),
					'S_BLOCK_LIST'		=> true,
				]);
			break;
		}
		
		if(sizeof($error))
		{
			$this->helper->json->send([
				'message'	=> implode('<br />', $error),
				'status'	=> JsonResponse::JSON_STATUS_ERROR
			]);
		}
		
		$this->template->assign_vars([
			'S_MANAGE_PAGE'		=> true,

			'S_HIDDEN_FIELDS'	=> build_hidden_fields($hidden_fields),

			'U_ACTION'		=> $this->form_action . '&amp;action=' . $action . '&amp;p=' . $page_id,
			'U_BACK'		=> $this->form_action,
		]);

		return true;
	}
	
	/**
	 * Put block variables into template
	 * 
	 * @param string 	$tpl_var 		Template variable name
	 * @param array		$row 			Block data
	 * @param int		$page_id 		Page ID
	 * 
	 * @access private
	 */
	private function block_to_template($tpl_var, $row, $page_id)
	{
		$block_position_name	= \canidev\blockgets\libraries\blockgets::$block_position_names[$row['block_position']] . '_block';
		$block_action 			= $this->form_action . '&amp;p=' . $page_id . '&amp;action=manage&amp;b=' . $row['block_id'] . '&amp;subaction=';
		$is_forum_block 		= ($block_position_name == 'center_block' && $row['block_alias'] == 'forum_content') ? true : false;
		$hidden_field_name 		= ($row['parent_id']) ? 'parent[' . $row['parent_id'] . '][]' : $block_position_name . '[]';

		$actions = [
			'ENABLE'		=> ['fa-power-off enable', $block_action . 'enable', !$row['block_enabled']],
			'DISABLE'		=> ['fa-power-off disable', $block_action . 'disable', $row['block_enabled']],
			'EDIT'			=> ['fa-pencil', $block_action . 'edit', !$is_forum_block],
			'DELETE'		=> ['fa-remove', $block_action . 'delete', !$is_forum_block],
		];

		$this->template->assign_block_vars($tpl_var, [
			'BLOCK_ID'			=> $row['block_id'],
			'BLOCK_CLASS'		=> str_replace('_', '-', $row['block_alias']),
			'BLOCK_TITLE'		=> $this->language->lang($row['block_title']),
			'BLOCK_ENABLED'		=> $row['block_enabled'],
			'IS_FORUM'			=> $is_forum_block,
			'S_HIDDEN_FIELDS'	=> build_hidden_fields([
				$hidden_field_name 		=> $row['block_id']
			]),
		]);
		
		foreach($actions as $lang_key => $action_data)
		{
			if(isset($action_data[2]) && !$action_data[2])
			{
				continue;
			}

			$this->template->assign_block_vars($tpl_var . '.action', [
				'ACTION'	=> $action_data[1],
				'ICON'		=> $action_data[0],
				'LABEL'		=> $this->language->lang($lang_key),
			]);
		}
	}
	
	/**
	 * Manage blocks
	 * 
	 * @param array 	$block_ids
	 * @param int 		$page_id
	 * @param string 	$action
	 * @param bool 		$submit
	 * 
	 * @return bool
	 */
	function manage_block($block_ids, $page_id, $action, $submit)
	{
		if(empty($block_ids[0]) && !in_array($action, ['add', 'add_group', 'save_position', 'save_size']))
		{
			return false;
		}

		$error = $block_config_vars = $hidden_fields = [];
		
		$submit = ($this->request->is_set_post('submitmore') ? true : $submit);
		
		$style_options = [
			constants::BLOCK_STYLE_DEFAULT			=> 'STYLE_DEFAULT',
			constants::BLOCK_STYLE_ALTERNATIVE		=> 'STYLE_ALTERNATIVE',
			constants::BLOCK_STYLE_CONTENT_FULL		=> 'STYLE_CONTENT_FULL',
			constants::BLOCK_STYLE_CONTENT_SIMPLE	=> 'STYLE_CONTENT_SIMPLE',
		];

		$collapse_options = [
			constants::BLOCK_COLLAPSE_NONE 		=> 'COLLAPSE_NONE',
			constants::BLOCK_COLLAPSE_VISIBLE 	=> 'COLLAPSE_VISIBLE',
			constants::BLOCK_COLLAPSE_HIDDEN 	=> 'COLLAPSE_HIDDEN',
		];
		
		$display_vars = [
			'legend1'			=> 'BLOCK_SETTINGS',
			'block_title'		=> ['lang' => 'BLOCK_TITLE',			'validate' => 'string:1:100',	'type' => 'text:30:100'],

			'block_icon'		=> ['lang' => 'BLOCK_CURRENT_ICON',		'type' => 'custom',		'function' => [$this->media, 'buildSelector'],		'params' => ['{KEY}', 'icon', '{CONFIG_VALUE}', 1],		'default' => ''],
			'block_groups'		=> ['lang' => 'BLOCK_GROUP',			'type' => 'custom',		'function' => [$this->tools, 'groups_select'],		'params' => ['block_groups', '{CONFIG_VALUE}'],			'default' => 'all'],
			'block_enabled'		=> ['lang' => 'BLOCK_ENABLED',			'validate' => 'bool',	'type' => 'radio:yes_no',							'default' => 1],
			'allow_collapse'	=> ['lang' => 'BLOCK_COLLAPSE',			'type' => 'custom',		'function' => [$this->tools, 'make_select'],		'params' => [$collapse_options, '{KEY}', '{CONFIG_VALUE}'],		'default' => constants::BLOCK_COLLAPSE_VISIBLE],
			'block_style'		=> ['lang' => 'BLOCK_STYLE',			'type' => 'custom',		'function' => [$this->tools, 'make_select'],		'params' => [$style_options, '{KEY}', '{CONFIG_VALUE}'],		'default' => 1],
		];
		
		if(!$submit && !in_array($action, ['enable', 'disable', 'remove', 'move']))
		{
			$this->form_action .= '&amp;p=' . $page_id . '&amp;action=manage';
		}
		
		// Obtain the page title for logs
		$page_ary = $this->obtain_pagelist(false, true);
		
		if(!isset($page_ary[$page_id]))
		{
			return false;
		}

		$page_title = $page_ary[$page_id]['page_title'];

		switch($action)
		{
			case 'edit':
				// Get the block data
				$sql = 'SELECT *
					FROM ' . $this->tables['blocks'] . '
					WHERE block_id = ' . $block_ids[0];
				$result = $this->db->sql_query($sql);
				$block_data = $this->db->sql_fetchrow($result);
				$this->db->sql_freeresult($result);

				// If no data, exit in this point
				if(!$block_data || $block_data['block_alias'] == 'forum_content')
				{
					break;
				}

				$page_id = (int)$block_data['block_page'];

			// no break

			case 'add':
				$this->language->add_lang('acp_blocks', 'canidev/blockgets');
				
				if($action == 'add')
				{
					$block_alias = $this->request->variable('block_alias', '');
					
					if(!preg_match('#^([^&\'"<>]+)_(block|addon)+$#i', $block_alias, $match))
					{
						return false;
					}

					// Default data for new blocks
					$block_data = [
						'block_id'			=> 0,
						'parent_id'			=> $this->request->variable('parent', 0),
						'block_title'		=> '',
						'block_alias'		=> $block_alias,
						'block_content'		=> '',
						'block_page'		=> $page_id,
						'block_position'	=> 0,
						'allow_collapse'	=> constants::BLOCK_COLLAPSE_VISIBLE,
						'block_style'		=> constants::BLOCK_STYLE_DEFAULT,
						'bbcode_bitfield'	=> '',
						'bbcode_uid'		=> '',
					];
					
					$hidden_fields = [
						'block_alias'	=> $block_alias,
						'position'		=> $this->request->variable('position', ''),
						'index'			=> $this->request->variable('index', 0),
						'parent'		=> $block_data['parent_id'],
					];
				}

				$hidden_fields = array_merge($hidden_fields, [
					'p'		=> $page_id,
					'b'		=> $block_data['block_id'],
				]);
				
				$cfg_array = $block_data;

				if(isset($_REQUEST['config']))
				{
					$cfg_array = array_merge($cfg_array, $this->request->variable('config', ['' => ''], true));
					$cfg_array['block_groups'] = $this->tools->groups_select_submit('block_groups');
				}

				$class_name	= '\\canidev\\blockgets\\blocks\\' . $block_data['block_alias'];

				if(!class_exists($class_name))
				{
					trigger_error($this->language->lang('BLOCK_NOT_EXISTS') . adm_back_link($this->form_action), E_USER_WARNING);
				}
				
				// Initialize the block class
				$block_class = new $class_name($this->container, $block_data);
				$block_class->manager = $this;
				
				// Check for block requirements at install if neccesary
				if($action == 'add' && method_exists($block_class, 'check'))
				{
					if(!$block_class->check())
					{
						trigger_error($this->language->lang('BLOCK_NEED_REQUIREMENTS') . adm_back_link($this->form_action), E_USER_WARNING);
					}
				}
				
				// Get extra vars and config from the block
				$has_config = $block_class->get_config();
				$has_list	= !empty($block_class->list);

				/**
				 * @event blockgets.acp_block_config
				 * @var object	block_class		The block object
				 * @var bool		has_config		Define if the block has config
				 * @var bool		has_list		Define if the block has a list
				 * @var array	block_data		Original block data
				 * @since 2.0.1
				 */
				$vars = ['block_class', 'has_config', 'has_list', 'block_data'];
				extract($this->dispatcher->trigger_event('blockgets.acp_block_config', compact($vars)));

				if($has_config && is_array($block_class->display_vars))
				{
					$block_config_vars = $block_class->display_vars;

					// Load separate language file if exists (for addons)
					$block_class->setup();
				}
				
				if(!$block_class->custom_config && ($has_config || $has_list))
				{
					$cfg_array = $block_class->unserialize($block_data['block_content'], true, $cfg_array);
				}
				
				// Initialize link management
				if($has_list)
				{
					if($action == 'edit')
					{
						$block_class->list->set_data($cfg_array, $block_data['block_id']);
					}
					
					$link_base_action = $this->form_action . '&amp;subaction=' . $action;
					$link_base_action .= '&amp;' . (($action == 'add') ? 'block_alias=' . $block_data['block_alias'] : 'b=' . $block_data['block_id']);
					
					$block_class->list
						->set_base_url($link_base_action)
						->acp_template();
				}
				
				$block_class->configure('validate', $block_data, $cfg_array, $submit);

				/**
				 * @event blockgets.acp_block_validate
				 * @var object	block_class		The block object
				 * @var array	block_data		Original block data
				 * @var array	cfg_array		Submitted block data
				 * @var bool 	submit 			
				 * @since 2.0.1
				 */
				$vars = ['block_class', 'block_data', 'cfg_array', 'submit'];
				extract($this->dispatcher->trigger_event('blockgets.acp_block_validate', compact($vars)));

				// Execute the ajax action over the links in this point
				if($has_list && $this->request->is_ajax())
				{
					$block_class->list->execute_action();
				}

				// We go through the display_vars to make sure no one is trying to set variables he/she is not allowed to...
				foreach(array_merge($display_vars, $block_config_vars) as $config_name => $vars)
				{
					if(strpos($config_name, 'legend') !== false)
					{
						continue;
					}

					if(!isset($cfg_array[$config_name]))
					{
						if(isset($vars['default']))
						{
							$cfg_array[$config_name] = $vars['default'];
						}
						else if(isset($vars['validate']))
						{
							$cfg_array[$config_name] = (strpos($vars['validate'], 'int') !== false || $vars['validate'] == 'bool') ? 0 : '';
						}
					}
				}
	
				if($submit)
				{
					// We validate the complete config if whished
					validate_config_vars($display_vars, $cfg_array, $error);
					validate_config_vars($block_config_vars, $cfg_array, $error);

					// Do not write values if there is an error
					if(sizeof($error))
					{
						$submit = false;
					}
				}
				
				// Check the block extra config
				if($submit)
				{
					if($has_list && ($list_data = $block_class->list->acp_submit()) !== false)
					{
						$cfg_array['list'] = $list_data;
					}
					
					$block_class->configure('submit', $block_data, $cfg_array, $submit);

					/**
					 * @event blockgets.acp_block_submit
					 * @var object	block_class		The block object
					 * @var array	block_data		Original block data
					 * @var array	cfg_array		Submitted block data
					 * @var bool 	submit 			
					 * @since 2.0.1
					 */
					$vars = ['block_class', 'block_data', 'cfg_array', 'submit'];
					extract($this->dispatcher->trigger_event('blockgets.acp_block_submit', compact($vars)));

					if(!$block_class->custom_config && ($has_config || $has_list))
					{
						$cfg_array['block_content'] = $block_class->serialize($cfg_array);
					}
				}
				
				// Save the changes
				if($submit)
				{
					$bbcode = $block_class->bbcode('get');
					
					$sql_ary = [
						'block_title'		=> $cfg_array['block_title'],
						'block_content'		=> (isset($cfg_array['block_content']) ? $cfg_array['block_content'] : $block_data['block_content']),
						'block_alias'		=> $block_data['block_alias'],
						'block_icon'		=> $cfg_array['block_icon'],
						'block_page'		=> $block_data['block_page'],
						'block_enabled'		=> $cfg_array['block_enabled'],
						'block_groups'		=> $cfg_array['block_groups'],
						'allow_collapse'	=> $cfg_array['allow_collapse'],
						'block_style'		=> $cfg_array['block_style'],
						'bbcode_bitfield'	=> $bbcode['bitfield'],
						'bbcode_uid'		=> $bbcode['uid'],
					];

		            if($action == 'edit')
		            {               
		            	$sql = 'UPDATE ' . $this->tables['blocks'] . '
							SET ' . $this->db->sql_build_array('UPDATE', $sql_ary) . '
							WHERE block_id = ' . $block_data['block_id'];
						$this->db->sql_query($sql);

		                $message = 'UPDATED';
		            }
		            else
		            {
						$sql_ary += [
							'parent_id'			=> $hidden_fields['parent'],
							'block_position'	=> ($hidden_fields['position']) ? array_search($hidden_fields['position'], \canidev\blockgets\libraries\blockgets::$block_position_names) : 0,
							'block_order'		=> $hidden_fields['index'],
						];

						$sql = 'INSERT INTO ' . $this->tables['blocks'] . ' ' . $this->db->sql_build_array('INSERT', $sql_ary);
						$this->db->sql_query($sql);
						
						$block_data['block_id'] = $this->db->sql_nextid();
						
						// Update order of other blocks
						$sql = 'UPDATE ' . $this->tables['blocks'] . '
							SET block_order = block_order + 1
							WHERE block_page = ' . $sql_ary['block_page'] . '
							AND block_position = ' . $sql_ary['block_position'] . '
							AND block_order >= ' . $sql_ary['block_order'] . '
							AND block_id <> ' . $block_data['block_id'];
						$this->db->sql_query($sql);

						$message = 'ADDED';
		            }

					$this->log->add('admin', $this->user->data['user_id'], $this->user->ip, "LOG_BLOCK_$message", time(), [$this->language->lang($sql_ary['block_title']), $page_title]);

					$this->helper->json->send([
						'message' 		=> $this->language->lang("BLOCK_$message"),
						'returnUrl'		=> $this->form_action . '&amp;p=' . $page_id . '&amp;action=manage' . (($action == 'add' && $this->request->is_set_post('submitmore')) ? '#add' : ''),
					]);
				}
				
				if(sizeof($error))
				{
					$this->helper->json->send([
						'message'	=> implode('<br />', $error),
						'status'	=> JsonResponse::JSON_STATUS_ERROR
					]);
				}
				
				// Title and Icon for new blocks
				if($action == 'add')
				{
					$block_info = $this->get_block_info($block_data['block_alias'], $block_class);
					$block_data['block_title'] = $cfg_array['block_title'] = $block_info['title'];

					$cfg_array['block_icon'] = $block_info['icon'];
				}
				
				$this->new_config = &$cfg_array;
				
				$this->display_vars($display_vars);
				$this->display_vars($block_config_vars, 'config');
				
				$title = strtoupper($action) . '_BLOCK_TITLE';
				
				$block_data['block_title'] = ($this->language->is_set($block_data['block_title']) ? $this->language->lang($block_data['block_title']) : $block_data['block_title']);
				$this->page_title = $this->language->lang($title, $block_data['block_title']);

				$this->template->assign_vars([
					'S_TITLE'			=> $this->page_title,
					'S_TITLE_EXPLAIN'	=> $this->language->lang($title . '_EXPLAIN'),

					'HAS_CONFIG'		=> $has_config,
					'HAS_LINKS'			=> $has_list,
					'S_LINKS_TITLE'		=> ($has_list) ? $block_class->list->get_title() : '',
					'CONFIG_TEMPLATE'	=> ($has_config && $block_class->tpl_name) ? "blocks/{$block_class->tpl_name}.html" : '',

					'S_ADD_MODE'		=> ($action == 'add') ? true : false,
					'S_HIDDEN_FIELDS'	=> build_hidden_fields($hidden_fields),

					'U_ACTION'			=> $this->form_action . '&amp;subaction=' . $action,
					'U_BACK'			=> $this->form_action,
				]);

				$this->tpl_name = 'acp_block_edit';
			break;
			
			case 'add_group':
				$position	= $this->request->variable('position', '');
				$index		= $this->request->variable('index', 0);

				$sql_ary = [
					'block_title'		=> '',
					'block_content'		=> '',
					'block_alias'		=> 'group',
					'block_icon'		=> '',
					'block_page'		=> $page_id,
					'block_enabled'		=> 1,
					'block_groups'		=> 'all',
					'allow_collapse'	=> constants::BLOCK_COLLAPSE_NONE,
					'block_style'		=> 0,
					'bbcode_bitfield'	=> '',
					'bbcode_uid'		=> '',
					'block_position'	=> array_search($position, \canidev\blockgets\libraries\blockgets::$block_position_names),
					'block_order'		=> $index,
				];

				$sql = 'INSERT INTO ' . $this->tables['blocks'] . ' ' . $this->db->sql_build_array('INSERT', $sql_ary);
				$this->db->sql_query($sql);
					
				$sql_ary['block_id'] = $this->db->sql_nextid();
					
				// Update order of other blocks
				$sql = 'UPDATE ' . $this->tables['blocks'] . '
					SET block_order = block_order + 1
					WHERE block_page = ' . $sql_ary['block_page'] . '
					AND block_position = ' . $sql_ary['block_position'] . '
					AND block_order >= ' . $sql_ary['block_order'] . '
					AND block_id <> ' . $sql_ary['block_id'];
				$this->db->sql_query($sql);
				
				$this->helper->json->send([
					'blockId'	=> $sql_ary['block_id'],
					'uRemove'	=> $this->form_action . '&amp;p=' . $page_id . '&amp;action=manage&amp;b=' . $sql_ary['block_id'] . '&amp;subaction=delete'
				]);
			break;

			case 'save_position':
				$success	= true;
				$positions	= \canidev\blockgets\libraries\blockgets::$block_position_names;
				$parents 	= $this->request->variable('parent', [0 => [0 => 0]]);
				$sql_ary	= [];

				// Update blocks for default positions
				for($i = 1; $i < count($positions); $i++)
				{
					$block_name = $positions[$i] . '_block';

					$item_positions = $this->request->variable($block_name, [0 => 0]);

					if(empty($item_positions))
					{
						continue;
					}

					foreach($item_positions as $position => $block_id)
					{
						$sql_ary[$block_id] = [
							'parent_id'			=> 0,
							'block_order'		=> (int)$position + 1,
							'block_position'	=> $i,
						];
					}
				}

				// Update blocks inside groups
				foreach($parents as $parent_id => $childs)
				{
					foreach($childs as $position => $block_id)
					{
						$sql_ary[$block_id] = [
							'parent_id'			=> $parent_id,
							'block_order'		=> (int)$position + 1,
							'block_position'	=> 0,
						];
					}
				}
				
				foreach($sql_ary as $block_id => $sql)
				{
					$sql = 'UPDATE ' . $this->tables['blocks'] . '
						SET ' . $this->db->sql_build_array('UPDATE', $sql) . "
						WHERE block_id = $block_id
						AND block_page = $page_id";

					if(!$this->db->sql_query($sql))
					{
						$success = false;
						break;
					}
				}

			// no break

			case 'save_size':
				$sizes = $this->request->variable('sizes', [0 => '']);

				if($action == 'save_size')
				{
					$success = true;
				}

				if($success)
				{
					foreach($sizes as $block_id => $values)
					{
						$sql_ary = [
							'block_content'	=> $values
						];

						$sql = 'UPDATE ' . $this->tables['blocks'] . '
							SET ' . $this->db->sql_build_array('UPDATE', $sql_ary) . "
							WHERE block_id = $block_id
							AND block_page = $page_id";

						if(!$this->db->sql_query($sql))
						{
							$success = false;
							break;
						}
					}
				}

				if(!$success)
				{
					$this->helper->json->send([
						'message'	=> $this->language->lang('BLOCK_POSITION_NOT_UPDATED'),
						'status'	=> JsonResponse::JSON_STATUS_ERROR
					]);
				}

				$this->log->add('admin', $this->user->data['user_id'], $this->user->ip, 'LOG_BLOCK_MOVED', time(), [$page_title]);
				$this->helper->json->send();
			break;

			case 'enable':
			case 'disable':
				$sql = 'UPDATE ' . $this->tables['blocks'] . '
					SET block_enabled = ' . (($action == 'enable') ? 1 : 0) . '
					WHERE ' . $this->db->sql_in_set('block_id', $block_ids) . "
					AND block_page = $page_id";

				$this->db->sql_query($sql);
				
				$this->helper->json->add(['message' => $this->language->lang('CONFIG_UPDATED')]);
				return false;

			case 'delete':
				if(confirm_box(true))
				{
					// Remove the blocks and childs
					$sql = 'DELETE FROM ' . $this->tables['blocks'] . '
						WHERE ' . $this->db->sql_in_set('block_id', $block_ids) . '
						OR ' . $this->db->sql_in_set('parent_id', $block_ids);
					$this->db->sql_query($sql);

					// Reajust the order of the blocks, prevent errors
					$positions = [];
					
					$sql = 'SELECT block_id, block_position
						FROM ' . $this->tables['blocks'] . "
						WHERE block_page = $page_id
						AND parent_id = 0
						ORDER BY block_order ASC";
					$result = $this->db->sql_query($sql);
					while($row = $this->db->sql_fetchrow($result))
					{
						$pos = (int)$row['block_position'];
						
						if(!isset($positions[$pos]))
						{
							$positions[$pos] = [];
						}
						
						$positions[$pos][] = $row['block_id'];
					}
					$this->db->sql_freeresult($result);
					
					if(!empty($positions))
					{
						foreach($positions as $pos => $blocks)
						{
							foreach($blocks as $id => $block)
							{
								$sql = 'UPDATE ' . $this->tables['blocks'] . '
									SET block_order = ' . ($id + 1) . "
									WHERE block_id = $block
									AND block_position = $pos";
								$this->db->sql_query($sql);
							}
						}
					}

					$this->log->add('admin', $this->user->data['user_id'], $this->user->ip, 'LOG_BLOCK_REMOVED', time(), [$page_title]);
					$this->helper->json->send(['message' => $this->language->lang('BLOCK_REMOVED')]);
				}
				else
				{
					confirm_box(
						false,
						strtoupper($action) . '_BLOCK',
						build_hidden_fields([
							'block_id_list'		=> $block_ids,
							'subaction'			=> $action,
						]),
						'@canidev_core/confirmbox.html'
					);
				}
				return false;
			
			case 'move':
			case 'copy':
				if(confirm_box(true))
				{
					$target_page_id = $this->request->variable('target_page_id', 0);
					
					$max_orders = $block_positions = [];
					
					// Obtain the title of new page (for log)
					$page_ary = $this->obtain_pagelist(false, true);
					
					if(!isset($page_ary[$target_page_id]))
					{
						break;
					}
					
					$new_page_title = $page_ary[$target_page_id]['page_title'];

					// Obtain the last block order in the target page
					$sql = 'SELECT MAX(block_order) AS max_order, block_position
						FROM ' . $this->tables['blocks'] . "
						WHERE block_page = $target_page_id
						GROUP BY block_position";
					$result = $this->db->sql_query($sql);
					while($row = $this->db->sql_fetchrow($result))
					{
						$position = (int)$row['block_position'];
						$max_orders[$position] = (int)$row['max_order'];
					}
					$this->db->sql_freeresult($result);
					
					// Get relevant data from selected blocks
					$parents = [];

					$sql = 'SELECT *
						FROM ' . $this->tables['blocks'] . '
						WHERE ' . $this->db->sql_in_set('block_id', $block_ids) . '
						ORDER BY block_order ASC';
					$result = $this->db->sql_query($sql);
					while($row = $this->db->sql_fetchrow($result))
					{
						$parent_id = (int)$row['parent_id'];

						if($parent_id)
						{
							if(!isset($parents[$parent_id]))
							{
								$parents[$parent_id] = [];
							}
							
							$parents[$parent_id][] = $row;
						}
						else
						{
							$position = (int)$row['block_position'];

							if(!isset($block_positions[$position]))
							{
								$block_positions[$position] = [];
							}
							
							$block_positions[$position][] = $row;
						}
					}
					$this->db->sql_freeresult($result);
					
					if(sizeof($parents))
					{
						$sql = 'SELECT *
							FROM ' . $this->tables['blocks'] . '
							WHERE ' . $this->db->sql_in_set('block_id', array_keys($parents));
						$result = $this->db->sql_query($sql);
						while($row = $this->db->sql_fetchrow($result))
						{
							$parent_id	= (int)$row['block_id'];
							$position	= (int)$row['block_position'];
							
							if(!isset($block_positions[$position]))
							{
								$block_positions[$position] = [];
							}

							foreach($parents[$parent_id] as $block_row)
							{
								$block_positions[$position][] = array_merge($block_row, [
									'parent_id'			=> 0,
									'block_position'	=> $position,
								]);
							}
						}
						$this->db->sql_freeresult($result);
					}
					
					// Apply the changes
					$copy_blocks = [];
					foreach($block_positions as $position => $data)
					{
						foreach($data as $order => $row)
						{
							$order = (isset($max_orders[$position]) ? $max_orders[$position] : 0) + $order + 1;

							if($action == 'move')
							{
								$sql_ary = [
									'block_page'		=> $target_page_id,
									'block_order'		=> $order,
									'block_position'	=> $row['block_position'],
									'parent_id'			=> $row['parent_id'],
								];
								
								$sql = 'UPDATE ' . $this->tables['blocks'] . '
									SET ' . $this->db->sql_build_array('UPDATE', $sql_ary) . '
									WHERE block_id = ' . $row['block_id'];
								$this->db->sql_query($sql);
							}
							else
							{
								unset($row['block_id']);
								
								$row = array_merge($row, [
									'block_page'	=> $target_page_id,
									'block_order'	=> $order,
								]);

								$copy_blocks[] = $row;
							}
						}
					}
					
					if($action == 'copy')
					{
						if(sizeof($copy_blocks))
						{
							$this->db->sql_multi_insert($this->tables['blocks'], $copy_blocks);

							$this->log->add('admin', $this->user->data['user_id'], $this->user->ip, 'LOG_BLOCK_COPY_PAGE', time(), [$page_title, $new_page_title]);
						}

						$this->helper->json->send(['message' => $this->language->lang('BLOCK_COPIED')]);
					}
					else
					{
						$this->log->add('admin', $this->user->data['user_id'], $this->user->ip, 'LOG_BLOCK_MOVED_PAGE', time(), [$page_title, $new_page_title]);
						$this->helper->json->send(['message' => $this->language->lang('BLOCK_MOVED')]);
					}
				}
				else
				{
					$page_ary = $this->obtain_pagelist([$page_id]);
					$page_options = [];

					foreach($page_ary as $page_type => $rows)
					{
						foreach($rows as $row_id => $row)
						{
							if(!$row_id)
							{
								$page_options['legend' . $page_type] = $row;
								continue;
							}
							
							$page_options[$row['page_id']] = $row['page_title'];
						}
					}
					
					$this->template->assign_vars([
						'L_EXPLAIN'			=> $this->language->lang('TARGET_PAGE_EXPLAIN'),
						'S_PAGE_OPTIONS'	=> $this->tools->make_select($page_options, false)
					]);

					confirm_box(
						false,
						strtoupper($action) . '_BLOCK',
						build_hidden_fields([
							'block_id_list'		=> $block_ids,
							'subaction'			=> $action,
						]),
						'ajax_body.html'
					);
				}
				return false;
			
			case 'chg_groups':
				if(confirm_box(true))
				{
					$new_group_str = $this->tools->groups_select_submit('chg_group');

					$sql = 'UPDATE ' . $this->tables['blocks'] . "
						SET block_groups = '" . $this->db->sql_escape($new_group_str) . "'
						WHERE " . $this->db->sql_in_set('block_id', $block_ids);
					$this->db->sql_query($sql);
					
					$this->helper->json->send(['message' => $this->language->lang('GROUPS_CHANGED')]);
				}
				else
				{
					$this->template->assign_vars([
						'L_EXPLAIN'			=> $this->language->lang('CHG_GROUP_EXPLAIN'),
						'S_GROUP_SELECT'	=> $this->tools->groups_select('chg_group', false),
					]);

					confirm_box(
						false,
						strtoupper($action) . '_BLOCK',
						build_hidden_fields([
							'block_id_list'		=> $block_ids,
							'subaction'			=> $action,
						]),
						'ajax_body.html'
					);
				}
				
				return false;
		}
		
		return true;
	}

	/**
	 * Build filters selector
	 * @return string
	 */
	public function display_filter_list()
	{
		return (!empty($this->filters) ? $this->filters->acp_template(true) : '');
	}
	
	/**
	 * Event for filter list
	 * 
	 * @param \phpbb\event\data 	$event
	 */
	public function filter_edit_before($event)
	{
		$method_options = [
			'GET'	=> 'FILTER_TYPE_GET',
			'POST'	=> 'FILTER_TYPE_POST',
		];

		$event['display_vars'] = [
			'param'		=> ['lang' => 'PAGE_FILTER_PARAM',		'type' => 'text:40:255',	'validate' => 'string:1:255'],
			'method'	=> ['lang' => 'PAGE_FILTER_TYPE',		'type' => 'select',			'function' => [$this->tools, 'make_select'],	'params' => [$method_options, false, '{CONFIG_VALUE}']],
		];
	}
	
	/**
	 * Get block information
	 * 
	 * @param string 		$block_alias
	 * @param object|bool 	$block_object
	 * 
	 * @return array|false
	 */
	function get_block_info($block_alias = '', $block_object = false)
	{
		$title = $explain = '';
		$block_type = 'block';
		
		if(preg_match('#^([^&\'"<>]+)_(block|addon)+$#i', $block_alias, $match))
		{
			$block_alias	= $match[1];
			$block_type		= $match[2];
		}
		
		$class_name = '\\canidev\\blockgets\\blocks\\' . $block_alias . '_' . $block_type;

		if(!class_exists($class_name))
		{
			return false;
		}
		
		if($block_object !== false)
		{
			if($block_object === true)
			{
				$block = new $class_name($this->container);
			}
			else
			{
				$block = $block_object;
			}

			$block->setup();
		}

		if($this->language->is_set(['blocks', "{$block_alias}_title"]))
		{
			$title = $this->language->lang(['blocks', "{$block_alias}_title"]);
		}
		
		if($this->language->is_set(['blocks', "{$block_alias}_explain"]))
		{
			$explain = $this->language->lang(['blocks', "{$block_alias}_explain"]);
		}
		
		if(!$explain && strpos($block_type, 'addon') !== false)
		{
			$explain = 'AddOn';
		}

		$block = new \ReflectionClass((!empty($block) ? $block : $class_name));
		$icon = $block->getStaticPropertyValue('icon');
		unset($block);

		return [
			'title'		=> ($title) ? $title : ucfirst(str_replace('_', ' ', $block_alias)),
			'explain'	=> $explain,
			'icon'		=> $icon,
			'type'		=> $block_type,
		];
	}
	
	/**
	 * Insert new page
	 * 
	 * @param string 	$alias
	 * 
	 * @return int
	 * @access private
	 */
	private function insert_page($alias)
	{
		// First, check if page exists
		$sql = 'SELECT page_id
			FROM ' . $this->tables['pages'] . '
			WHERE page_alias = "' . $this->db->sql_escape($alias) . '"';
		$result = $this->db->sql_query($sql);
		$page_id = (int)$this->db->sql_fetchfield('page_id');
		$this->db->sql_freeresult($result);
		
		if($page_id)
		{
			return $page_id;
		}
		
		// Create the page
		$page_data = [
			'page_alias'	=> $alias,
			'page_type'		=> constants::PAGE_FORUM,
			'page_title'	=> '',
			'page_enabled'	=> 1,
			'page_groups'	=> 'all',
			
			'page_data'		=> serialize([
				'filters'				=> [],
				'header'				=> 1,
				'footer'				=> 1,
				'page_theme'			=> 'default',
				'background'			=> '',
				'stylesheet'			=> '',
				'style'					=> '',
				'logo'					=> '',
				'left_column_width'		=> '200px',
				'right_column_width'	=> '200px',
				'block_space'			=> '6px',
			])
		];
		
		$sql = 'INSERT INTO ' . $this->tables['pages'] . $this->db->sql_build_array('INSERT', $page_data);
		$this->db->sql_query($sql);
		$page_id = $this->db->sql_nextid();

		$this->insert_forum_block($page_id);
		$this->cache->destroy('_blockgets_pages');
		
		return $page_id;
	}

	/**
	 * Insert forum block
	 * 
	 * @param int 	$page_id
	 * @param bool 	$check
	 * 
	 * @return array|true
	 * @access private
	 */
	private function insert_forum_block($page_id, $check = false)
	{
		if($check)
		{
			$sql = 'SELECT block_id
				FROM ' . $this->tables['blocks'] . "
				WHERE block_alias = 'forum_content'
				AND block_page = $page_id";
			$result = $this->db->sql_query($sql);
			$block_id = (int)$this->db->sql_fetchfield('block_id');
			$this->db->sql_freeresult($result);
			
			if($block_id)
			{
				return true;
			}
		}

		$sql_ary = [
			'parent_id'			=> 0,
			'block_title'		=> 'FORUM',
			'block_content'		=> '',
			'block_alias'		=> 'forum_content',
			'block_icon'		=> '',
			'block_page'		=> $page_id,
			'block_enabled'		=> 1,
			'block_groups'		=> 'all',
			'allow_collapse'	=> constants::BLOCK_COLLAPSE_NONE,
			'bbcode_bitfield'	=> '',
			'bbcode_uid'		=> '',
		];
		
		$block_position = array_search('center', \canidev\blockgets\libraries\blockgets::$block_position_names);

		$sql = 'SELECT MAX(block_order) as max_block_order
			FROM ' . $this->tables['blocks'] . '
			WHERE block_position = ' . $block_position . "
			AND block_page = $page_id";
		$result = $this->db->sql_query($sql);
		$max_block_order = (int) $this->db->sql_fetchfield('max_block_order');
		$this->db->sql_freeresult($result);

		$sql_ary += [
			'block_position'	=> $block_position,
			'block_order'		=> $max_block_order + 1,
		];

		$sql = 'INSERT INTO ' . $this->tables['blocks'] . ' ' . $this->db->sql_build_array('INSERT', $sql_ary);
		$this->db->sql_query($sql);
		
		$sql_ary['block_id'] = $this->db->sql_nextid();
		
		return $sql_ary;
	}
	
	/**
	 * Build select with files
	 * 
	 * @param array 		$ignore_ary		Files to be ignored
	 * @return string
	 */
	protected function build_file_select($ignore_ary = [])
	{
		$forum_routes  	= ['app/help'];
		$exclude_files 	= array_merge($ignore_ary, ['app', 'common', 'config', 'cron', 'faq', 'feed', 'style', 'app/feed', 'app/pm', 'app/post']);
		$ext_pages 		= [];

		$options = [
			'custom'	=> 'PAGE_CUSTOM_ONE',

			'legend1'	=> 'FORUM_ROUTES',
		];
		
		// Read all the avaliable files in phpbb root path
		if($dir = @opendir($this->phpbb_root_path))
		{
			$file_ary = [];

			while(($file = @readdir($dir)) !== false)
			{
				if(($pos = strpos($file, ".{$this->php_ext}")) !== false)
				{
					$filename = substr($file, 0, $pos);
				
					if($filename && !in_array($filename, $exclude_files))
					{
						$file_ary[$filename] = '/' . $file;
					}
				}
			}
			closedir($dir);
			asort($file_ary);

			$options += $file_ary;
		}

		// Get routes
		
		/** @var \phpbb\routing\router */
		$router = $this->container->get('router');;

		$route_collection = $router->getRouteCollection()->getIterator();

		foreach($route_collection as $key => $route)
		{
			if(strpos($key, 'canidev_blockgets') === false && preg_match('#^/([\w\d\-\_]+)/?#i', $route->getPath(), $match))
			{
				$alias = 'app/' . $match[1];
				
				if(!in_array($alias, $exclude_files))
				{
					if(in_array($alias, $forum_routes))
					{
						$options[$alias] = '/' . $match[1];
						continue;
					}
					
					$ext_pages[$alias] = '/' . $match[1];
				}
			}
		}
		
		if(sizeof($ext_pages))
		{
			$options['legend2'] = 'EXT_ROUTES';
			$options = array_merge($options, $ext_pages);
		}

		return $this->tools->make_select($options, false);
	}
	
	/**
	 * Clear the path
	 * 
	 * @param string 	$path
	 * @return string
	 */
	protected function clear_path($path)
	{
		$replaces = [
			'#(^|/)\.\/#'			=> '\\1',
			'#([\w\d\-\_]+)/\.\./#'	=> '/',
			'#[^:]//#'				=> '/',
			'#sid\=([a-z0-9]+)#'	=> '',
			'#^/#' 					=> '',
			'#(\?|&|&amp;)$#' 		=> '',
		];

		return preg_replace(array_keys($replaces), array_values($replaces), $path);
	}

	/**
	 * Destroy cache for pages
	 */
	protected function destroy_pages_cache()
	{
		$this->cache->destroy('_blockgets_pages');

		// Remove route cache manually to prevent full cache purge
		$cache_dir = $this->container->getParameter('core.cache_dir');
		
		@unlink($cache_dir . '/url_generator.' . $this->php_ext);
		@unlink($cache_dir . '/url_generator.meta');
		@unlink($cache_dir . '/url_matcher.' . $this->php_ext);
		@unlink($cache_dir . '/url_matcher.meta');
	}
}
