<?php
/*
* @name main_module.php
* @package cBB Chat
* @version v1.1.0 16/12/2014
*
* @copyright (c) 2014 CaniDev
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/

namespace canidev\chat\acp;

// @ignore
if(!defined('IN_PHPBB'))
{
	exit;
}

/**
* @package acp
*/
class main_module
{
	var $u_action;
	var $new_config 	= array();
	var $exclude_files 	= array('app', 'chat', 'common', 'config', 'cron', 'feed', 'report');

	function main($id, $mode)
	{
		global $user, $template, $config, $request, $chat;

		$user->add_lang_ext('canidev/chat', array('acp', 'main'));
		
		if(empty($chat->installed))
		{
			trigger_error('MOD_NOT_INSTALLED', E_USER_WARNING);
		}

		$action = $request->variable('action', '');
		$error	= $notice = array();
		$submit = ($request->is_set_post('submit')) ? true : false;
		
		// Security check
		if(in_array($action, array('delete', 'add_auth')) && !$request->is_set_post('icajx'))
		{
			exit_handler();
		}

		if(!method_exists($this, "_mode_$mode"))
		{
			trigger_error('NO_MODE', E_USER_WARNING);
		}

		call_user_func_array(array($this, "_mode_$mode"), array($action, $submit, &$error, &$notice));

		$this->page_title 	= (empty($this->page_title) ? 'CHAT_' . strtoupper($mode) . '_TITLE' : $this->page_title);
		$this->page_title	= $user->lang($this->page_title);
		$this->page_explain = (empty($this->page_explain) ? 'CHAT_' . strtoupper($mode) . '_EXPLAIN' : $this->page_explain);

		$template->assign_vars(array(
			'IN_CHAT_ADMIN'		=> true,
			'L_TITLE'			=> $this->page_title,
			'L_TITLE_EXPLAIN'	=> $user->lang($this->page_explain),

			'U_ACTION'			=> $this->u_action,
			'U_HELP'			=> 'http://www.canidev.com/docs.php?i=cbb-chat-v' . $config['chat_version'],
		));
		
		if(sizeof($error) || sizeof($notice))
		{
			$notice_rows = (sizeof($error) ? $error : $notice);
			
			foreach($notice_rows as $id => $value)
			{
				if(isset($user->lang[$value]))
				{
					$notice_rows[$id] = $user->lang[$value];
				}
			}
			
			$template->assign_vars(array(
				'NOTICE'		=> implode('<br />', $notice_rows),
				'NOTICE_ERROR'	=> (sizeof($error) ? true : false),
			));
		}
		
		$this->page_title = $user->lang['CHAT'] . ' &bull; ' . $this->page_title;
	}
	
	function _mode_config($action, $submit, &$error, &$notice)
	{
		global $user, $config, $template, $request;
		
		$this->tpl_name = 'chat_config';

		$display_vars = array(
			'legend1'			=> 'CHAT_MAIN_CONFIG',
			'chat_enabled'				=> array('lang' => 'CHAT_ENABLED',			'validate' => 'bool',		'type' => 'radio:yes_no'),
			'chat_page_enabled'			=> array('lang' => 'CHAT_PAGE_ENABLED',		'validate' => 'bool',		'type' => 'radio:yes_no'),
			'chat_show_topics'			=> array('lang' => 'CHAT_SHOW_TOPICS',		'validate' => 'bool',		'type' => 'radio:yes_no'),
			'chat_autoconnect'			=> array('lang' => 'CHAT_AUTOCONNECT',		'validate' => 'bool',		'type' => 'radio:yes_no'),
			'chat_sound'				=> array('lang' => 'CHAT_SOUND_ENABLED',	'validate' => 'bool',		'type' => 'radio:yes_no'),
			'chat_flood_time'			=> array('lang' => 'CHAT_FLOOD',			'validate' => 'int:0:60',	'type' => 'text:3:2'),
			'chat_height'				=> array('lang' => 'CHAT_HEIGHT',			'validate' => 'int:50:800',	'type' => 'text:4:3'),
			'chat_refresh'				=> array('lang' => 'CHAT_REFRESH_TIME',		'validate' => 'int:5:60',	'type' => 'text:3:2'),

			'legend2'			=> 'CHAT_USERS_CONFIG',
			'chat_timeout'				=> array('lang' => 'CHAT_TIMEOUT',			'validate' => 'int:0:60',	'type' => 'text:3:2'),
			'chat_auto_away'			=> array('lang' => 'CHAT_AUTO_AWAY',		'validate' => 'int:0:60',	'type' => 'text:3:2'),
			'chat_remember_status'		=> array('lang' => 'CHAT_REMEMBER_STATUS',	'validate' => 'bool',		'type' => 'radio:yes_no'),
		
			'legend3'			=> 'CHAT_MESSAGES_CONFIG',
			'chat_direction'			=> array('lang' => 'CHAT_DIRECTION',		'validate' => 'string',		'type' => 'custom',	'method' => 'make_select',	'params' => array('{KEY}', '{CONFIG_VALUE}')),
			'chat_max_rows'				=> array('lang' => 'CHAT_ROWS',				'validate' => 'int:1:100',	'type' => 'text:4:3'),
			'chat_max_chars'			=> array('lang' => 'CHAT_CHARS',			'validate' => 'int',		'type' => 'text:4:4'),
			'chat_show_avatars'			=> array('lang' => 'CHAT_AVATARS',			'validate' => 'bool',		'type' => 'radio:yes_no'),
			'chat_allow_bbcode'			=> array('lang' => 'CHAT_ALLOW_BBCODE',		'validate' => 'bool',		'type' => 'radio:yes_no'),
			'chat_disallowed_bbcode'	=> array('lang' => 'CHAT_DISALLOWED_BBCODE',	'type' => 'custom',		'method' => 'make_select',	'params' => array('{KEY}', '{CONFIG_VALUE}', 8)),
			'chat_bbcode_format'		=> array('lang' => 'CHAT_BBCODE_FORMAT',	'type' => 'custom',			'method' => 'make_select',	'params' => array('{KEY}', '{CONFIG_VALUE}')),
			'chat_store_time'			=> array('lang' => 'CHAT_STORE',			'validate' => 'int',		'type' => 'custom',		'method' => 'make_select',	'params' => array('{KEY}', '{CONFIG_VALUE}')),
		
			'legend4'		=> 'CHAT_PM_CONFIG',
			'chat_allow_pm'			=> array('lang' => 'CHAT_ALLOW_PM',			'validate' => 'bool',		'type' => 'radio:yes_no'),
			'chat_max_pm'			=> array('lang' => 'CHAT_MAX_PM',			'validate' => 'int:0:60',	'type' => 'text:3:2'),
		);
		
		$cfg_array	= $config;
		
		if(isset($_REQUEST['config']))
		{
			$cfg_array = utf8_normalize_nfc($request->variable('config', array('' => ''), true));
			$cfg_array['chat_disallowed_bbcode'] = $request->variable('chat_disallowed_bbcode', array(0));
			
			if(!empty($cfg_array['chat_disallowed_bbcode']))
			{
				$bitfield = new \bitfield();
				
				foreach($cfg_array['chat_disallowed_bbcode'] as $bbcode_id)
				{
					$bitfield->set($bbcode_id);
				}
				
				$cfg_array['chat_disallowed_bbcode'] = $bitfield->get_base64();
			}
			else
			{
				$cfg_array['chat_disallowed_bbcode'] = '';
			}
		}

		// We validate the complete config if whished
		validate_config_vars($display_vars, $cfg_array, $error);
		
		// Validate the timeouts
		if($cfg_array['chat_timeout'] && $cfg_array['chat_auto_away'] && $cfg_array['chat_timeout'] <= $cfg_array['chat_auto_away'])
		{
			$error[] = 'CHAT_AUTO_AWAY_ERROR';
		}
		
		// Do not write values if there is an error
		if(sizeof($error))
		{
			$submit = false;
		}
		
		// We go through the display_vars to make sure no one is trying to set variables he/she is not allowed to...
		foreach($display_vars as $config_name => $null)
		{
			if(!isset($cfg_array[$config_name]) || strpos($config_name, 'legend') !== false)
			{
				continue;
			}

			$this->new_config[$config_name] = $config_value = $cfg_array[$config_name];

			if($submit)
			{
				set_config($config_name, $config_value);
			}
		}

		if($submit)
		{
			add_log('admin', 'LOG_CHAT_CONFIG');
			$notice[] = 'CONFIG_UPDATED';
		}
		
		$this->display_vars($display_vars);
	}
	
	function _mode_pages($action, $submit, &$error, &$notice)
	{
		global $db, $template, $user, $cache, $request, $phpbb_root_path, $phpEx;

		$this->tpl_name = 'chat_pages';
		
		$page_id = $request->variable('id', 0);
		
		switch($action)
		{
			case 'edit':
				$sql = 'SELECT *
					FROM ' . CHAT_PAGES_TABLE . "
					WHERE page_id = $page_id";
				$result = $db->sql_query($sql);
				$page_data = $db->sql_fetchrow($result);
				$db->sql_freeresult($result);
				
				if(!$page_data)
				{
					$action = '';
					break;
				}

				$page_data['page_data'] = ($page_data['page_data']) ? @unserialize($page_data['page_data']) : array();
				
			// no break

			case 'add':
				$display_vars = array(
					'legend1'		=> 'CHAT_PAGE_CONFIG',
					'page_file'			=> array('lang' => 'CHAT_PAGE_FILE',	'type' => 'custom',			'method' => 'make_select',	'params' => array('{KEY}', '{CONFIG_VALUE}', 1, $action)),
					'custom_file'		=> array('lang' => 'CHAT_PAGE_CUSTOM',	'validate' => 'string',		'type' => 'text:40:255',	'display' => false),
					'page_alias'		=> array('lang' => 'CHAT_PAGE_ALIAS',	'validate' => 'string',		'type' => 'text:40:50',		'display' => false),
					'chat_position'		=> array('lang' => 'CHAT_POSITION',		'type' => 'custom',			'method' => 'make_select',	'params' => array('{KEY}', '{CONFIG_VALUE}')),
					'chat_height'		=> array('lang' => 'CHAT_HEIGHT_PAGE',	'validate' => 'int:0:800',	'type' => 'text:4:3'),
					'forum_ids'			=> array('lang' => 'CHAT_PAGE_FORUMS',	'type' => 'custom',			'method' => 'make_select',	'params' => array('{KEY}', '{CONFIG_VALUE}'),	'display' => false),
				);
				
				if($action == 'add')
				{
					$page_data = array(
						'page_alias'	=> '',
						'page_filename'	=> '',
						'page_path'		=> '',
						'page_data'		=> array(),
					);
				}
				
				$page_data['forum_ids'] = (!empty($page_data['page_data']['forum_ids']) ? $page_data['page_data']['forum_ids'] : array());
				
				if($submit)
				{
					$this->new_config = utf8_normalize_nfc($request->variable('config', array('' => ''), true));
					
					if($this->new_config['page_file'] == '-')
					{
						if(!preg_match("#^(?:\.\/|\/)?(.*\/)?([\w\d\-\_]+)(\.$phpEx)?$#", $this->new_config['custom_file'], $matches))
						{
							$error[] = 'INVALID_FILE';
						}
						
						if(!sizeof($error))
						{
							$filename = $phpbb_root_path . $matches[1] . $matches[2] . $matches[3];
							
							if(!$matches[1] && in_array($matches[2], $this->exclude_files))
							{
								$error[] = 'INVALID_FILE';
							}
							
							if(!$this->new_config['page_alias'])
							{
								$error[] = 'NO_ALIAS';
							}
							
							$this->new_config['page_filename']	= $matches[2] . $matches[3];
							$this->new_config['page_path']		= $matches[1];
						}
					}
					else
					{
						$this->new_config['page_alias']		= $this->new_config['page_file'];
						$this->new_config['page_filename']	= $this->new_config['page_file'] . ".$phpEx";
						$this->new_config['page_path']		= '';
					}
					
					if(in_array($this->new_config['page_alias'], array('viewforum', 'viewtopic')))
					{
						$this->new_config['forum_ids'] = $request->variable('forum_ids', array(0));
						
						$this->new_config['page_data'] = array(
							'forum_ids'		=> $this->new_config['forum_ids'],
						);
					}
					
					// Check if page already exists
					if(!sizeof($error))
					{
						$sql = 'SELECT page_id
							FROM ' . CHAT_PAGES_TABLE . "
							WHERE page_filename = '" . $db->sql_escape($this->new_config['page_filename']) . "'
							AND page_path = '" . $db->sql_escape($this->new_config['page_path']) . "'
							AND page_id <> $page_id";
						$result = $db->sql_query($sql);
						$already_page_id = (int)$db->sql_fetchfield('page_id');
						$db->sql_freeresult($result);
						
						if($already_page_id)
						{
							$error[] = 'PAGE_ALREADY_EXISTS';
						}
					}
					
					if(!sizeof($error))
					{
						$sql_ary = array(
							'page_alias'	=> str_replace(' ', '_', $this->new_config['page_alias']),
							'page_filename'	=> $this->new_config['page_filename'],
							'page_path'		=> $this->new_config['page_path'],
							'page_data'		=> (!empty($this->new_config['page_data']) ? @serialize($this->new_config['page_data']) : ''),
							'chat_position'	=> $this->new_config['chat_position'],
							'chat_height'	=> (int)$this->new_config['chat_height'],
						);
						
						if($action == 'add')
						{
							$sql = 'INSERT INTO ' . CHAT_PAGES_TABLE . ' ' . $db->sql_build_array('INSERT', $sql_ary);
						}
						else
						{
							$sql = 'UPDATE ' . CHAT_PAGES_TABLE . '
								SET ' . $db->sql_build_array('UPDATE', $sql_ary) . "
								WHERE page_id = $page_id";
						}
						
						$db->sql_query($sql);
						
						$cache->destroy('_chat_pages');
						
						$action = '';
						break;
					}
				}
				else
				{
					$this->new_config = $page_data;
					
					if($page_data['page_path'])
					{
						$this->new_config = array_merge($this->new_config, array(
							'page_file'		=> '-',
							'custom_file'	=> $page_data['page_path'] . $page_data['page_filename'],
						));
					}
					else
					{
						$this->new_config['page_file']	= $page_data['page_alias'];
						$this->new_config['page_alias']	= '';
					}
				}
				
				if(in_array($this->new_config['page_file'], array('viewforum', 'viewtopic')))
				{
					$display_vars['forum_ids']['display'] = true;
				}
				
				$this->display_vars($display_vars);
				
				$template->assign_vars(array(
					'S_EDIT'	=> true,
					'U_BACK'	=> $this->u_action,
					
					'S_HIDDEN_FIELDS'	=> build_hidden_fields(array(
						'action'	=> $action,
						'id'		=> $page_id
					)),
				));
			break;
			
			case 'delete':
				$sql = 'DELETE FROM ' . CHAT_PAGES_TABLE . "
					WHERE page_id = $page_id";
				$db->sql_query($sql);
				
				$cache->destroy('_chat_pages');
				
				$this->set_json_display(array(
					'action'	=> 'delete_row',
					'row_id'	=> $page_id,
				));
			break;
		}

		if(!$action)
		{
			$sql = 'SELECT *
				FROM ' . CHAT_PAGES_TABLE . '
				ORDER BY page_alias';
			$result = $db->sql_query($sql);
			while($row = $db->sql_fetchrow($result))
			{
				$title = ($row['page_alias']) ? $row['page_alias'] : str_replace(".$phpEx", '', $row['page_filename']);
				$title = (isset($user->lang[strtoupper($title)]) ? $user->lang[strtoupper($title)] : ucfirst($title));
		
				$template->assign_block_vars('pagerow', array(
					'S_ID'		=> $row['page_id'],
					'S_TITLE'	=> $title,
					'S_URL'		=> generate_board_url() . '/' . $row['page_path'] . $row['page_filename'],
					
					'U_DELETE'	=> $this->u_action . '&amp;action=delete&amp;id=' . $row['page_id'],
					'U_EDIT'	=> $this->u_action . '&amp;action=edit&amp;id=' . $row['page_id'],
				));
			}
			$db->sql_freeresult($result);
			
			$template->assign_var('U_PAGE_ADD', $this->u_action . '&amp;action=add');
		}
	}
	
	function _mode_rooms($action, $submit, &$error, &$notice)
	{
		global $db, $template, $user, $cache, $request, $phpbb_root_path, $phpEx;

		$this->tpl_name = 'chat_rooms';
		
		$room_id = $request->variable('id', 0);
		
		switch($action)
		{
			case 'delete':
				if(confirm_box(true))
				{
					if($room_id != CHAT_GUEST_ROOM)
					{
						// Get the title and key of the room before remove
						$sql = 'SELECT room_title, room_key
							FROM ' . CHAT_ROOMS_TABLE . '
							WHERE room_id = ' . $room_id;
						$result = $db->sql_query($sql);
						$data = $db->sql_fetchrow($result);
						$db->sql_freeresult($result);
						
						if($data)
						{
							$data['room_title'] = (isset($user->lang[$data['room_title']]) ? $user->lang[$data['room_title']] : $data['room_title']);
							
							// Delete the room
							$sql = 'DELETE FROM ' . CHAT_ROOMS_TABLE . '
								WHERE room_id = ' . $room_id;
							$db->sql_query($sql);
							
							// Delete the messages of the room
							$sql = 'DELETE FROM ' . CHAT_MESSAGES_TABLE . '
								WHERE dest_key = ' . $data['room_key'];
							$db->sql_query($sql);
							
							add_log('admin', 'LOG_CHAT_ROOM_REMOVED', $data['room_title']);
							$cache->destroy('_chat_rooms');
				
							$this->set_json_display(array(
								'action'	=> 'delete_row',
								'row_id'	=> $room_id,
							));
						}
					}
				}
				else
				{
					$this->set_json_display(array(
						'action'	=> 'confirm'
					));
					
					$template->assign_vars(array(
						'S_CONFIRM_DIALOG'	=> true,
					));

					confirm_box(false, $user->lang['REMOVE_ROOM_CONFIRM'], '', 'chat_ajax.html');
				}
			break;

			case 'edit':
				$sql = 'SELECT *
					FROM ' . CHAT_ROOMS_TABLE . "
					WHERE room_id = $room_id";
				$result = $db->sql_query($sql);
				$room_data = $db->sql_fetchrow($result);
				$db->sql_freeresult($result);
				
				if(!$room_data)
				{
					$action = '';
					break;
				}
				
				$room_auth = @unserialize($room_data['room_data']);
				
				$room_data['room_groups']	= (empty($room_auth['groups']) ? array() : $room_auth['groups']);
				$room_data['room_users']	= (empty($room_auth['users']) ? '' : implode("\n", $room_auth['users']));
				
			// no break

			case 'add':
				$display_vars = array(
					'legend1'		=> 'CHAT_ROOM_CONFIG',
					'room_title'		=> array('lang' => 'CHAT_ROOM_TITLE',		'validate' => 'string:1:255',	'type' => 'text:40:255'),
					'room_enabled'		=> array('lang' => 'CHAT_ROOM_ENABLED',		'validate' => 'bool',			'type' => 'radio:yes_no'),
				);
				
				if($room_id != CHAT_GUEST_ROOM)
				{
					$display_vars += array(
						'legend2'		=> 'CHAT_ROOM_AUTH',
						'room_groups'	=> array('lang' => 'CHAT_ROOM_GROUPS',	'type' => 'custom',	'method' => 'make_select',	'params' => array('{KEY}', '{CONFIG_VALUE}')),
						'room_users'	=> array('lang' => 'CHAT_ROOM_USERS',	'type' => 'textarea:5:5'),
					);
				}
				
				if($action == 'add')
				{
					$room_id = 0;

					$room_data = array(
						'room_enabled'	=> true,
						'room_groups'	=> array(),
						'room_users'	=> '',
					);
				}
				
				$this->new_config = $room_data;
				
				if($submit)
				{
					$this->new_config = utf8_normalize_nfc($request->variable('config', array('' => ''), true));
					$this->new_config['room_groups'] = $request->variable('room_groups', array(0));
					
					// We validate the complete config if whished
					validate_config_vars($display_vars, $this->new_config, $error);
					
					$data = array();
					
					if(!sizeof($error))
					{
						if($room_id != CHAT_GUEST_ROOM)
						{
							if(!empty($this->new_config['room_groups']))
							{
								$data['groups'] = $this->new_config['room_groups'];
							}
							
							if($this->new_config['room_users'])
							{
								$user_ary = array();
								
								foreach(explode("\n", $this->new_config['room_users']) as $username)
								{
									$username = trim($username);
									
									if($username)
									{
										$user_ary[] = utf8_clean_string($username);
									}
								}
								
								if(sizeof($user_ary))
								{
									$data['users'] = array();

									$sql = 'SELECT user_id, username
										FROM ' . USERS_TABLE . '
										WHERE ' . $db->sql_in_set('username_clean', $user_ary);
									$result = $db->sql_query($sql);
									while($row = $db->sql_fetchrow($result))
									{
										$data['users'][$row['user_id']] = $row['username'];
									}
									$db->sql_freeresult($result);
								}
							}
						}

						$sql_ary = array(
							'room_title'	=> $this->new_config['room_title'],
							'room_enabled'	=> ($room_id == CHAT_GUEST_ROOM) ? 1 : $this->new_config['room_enabled'],
							'room_data'		=> (sizeof($data) ? serialize($data) : ''),
						);
						
						if($action == 'add')
						{
							// Get max order
							$sql = 'SELECT MAX(room_order) AS max_order
								FROM ' . CHAT_ROOMS_TABLE;
							$result = $db->sql_query($sql);
							$sql_ary['room_order'] = (int)$db->sql_fetchfield('max_order') + 1;
							$db->sql_freeresult($result);
							
							$sql_ary['room_key'] = time() - 1001;

							$sql = 'INSERT INTO ' . CHAT_ROOMS_TABLE . ' ' . $db->sql_build_array('INSERT', $sql_ary);
							$notice[] = 'CHAT_ROOM_ADDED';
						}
						else
						{
							$sql = 'UPDATE ' . CHAT_ROOMS_TABLE . '
								SET ' . $db->sql_build_array('UPDATE', $sql_ary) . "
								WHERE room_id = $room_id";
								
							$notice[] = 'CHAT_ROOM_UPDATED';
						}
						
						$db->sql_query($sql);
						
						$cache->destroy('_chat_rooms');
					}

					$action = '';
					break;
				}

				if($room_id == CHAT_GUEST_ROOM)
				{
					$display_vars['room_enabled']['display'] = false;
				}
				
				$this->display_vars($display_vars);
				
				$template->assign_vars(array(
					'S_EDIT'	=> true,
					'S_HIDDEN_FIELDS'	=> build_hidden_fields(array(
						'action'	=> $action,
						'id'		=> $room_id
					)),
					
					'U_BACK'			=> $this->u_action,
					'U_FIND_USERNAME'	=> append_sid("{$phpbb_root_path}memberlist.$phpEx", 'mode=searchuser&amp;form=acp_chat_rooms&amp;field=room_users')
				));
			break;
			
			case 'sort':
				$rows = $request->variable('row', array(0 => 0));
				
				foreach($rows as $position => $room_id)
				{
					$sql = 'UPDATE ' . CHAT_ROOMS_TABLE . '
						SET room_order = ' . ((int)$position + 1) . "
						WHERE room_id = $room_id";
					$db->sql_query($sql);
				}
				
				$cache->destroy('_chat_rooms');
				exit_handler();
			break;
		}
		
		if(!$action)
		{
			$room_ary = array();

			$sql = 'SELECT *
				FROM ' . CHAT_ROOMS_TABLE . '
				ORDER BY room_order';
			$result = $db->sql_query($sql);
			while($row = $db->sql_fetchrow($result))
			{
				$title 		= $row['room_title'];
				$title 		= (isset($user->lang[strtoupper($title)]) ? $user->lang[strtoupper($title)] : ucfirst($title));

				$template->assign_block_vars('roomrow', array(
					'S_ID'		=> $row['room_id'],
					'S_TITLE'	=> $title,
					
					'U_DELETE'	=> ($row['room_id'] != CHAT_GUEST_ROOM) ? $this->u_action . '&amp;action=delete&amp;id=' . $row['room_id'] : '',
					'U_EDIT'	=> $this->u_action . '&amp;action=edit&amp;id=' . $row['room_id'],
				));
			}
			$db->sql_freeresult($result);

			$template->assign_vars(array(
				'S_HIDDEN_FIELDS'	=> build_hidden_fields(array(
					'action'	=> 'sort'
				)),
				
				'U_ROOM_ADD'	=> $this->u_action . '&amp;action=add'
			));
		}
	}
	
	function _mode_texts($action, $submit, &$error, &$notice)
	{
		global $db, $user, $cache, $config, $template, $request, $phpbb_root_path, $phpEx;

		$this->tpl_name = 'chat_texts';
		
		$text_id 	= $request->variable('id', 0);
		$text_type	= $request->variable('type', 0);
		
		$text_ary = array(
			CHAT_TEXT_NOTICE	=> array('title' => 'CHAT_NOTICES',	'rows' => array()),
			CHAT_TEXT_TIP		=> array('title' => 'CHAT_TIPS',	'rows' => array()),
			CHAT_TEXT_RULE		=> array('title' => 'CHAT_RULES',	'rows' => array()),
		);
		
		switch($action)
		{
			case 'edit':
				$sql = 'SELECT text_content, bbcode_uid
					FROM ' . CHAT_TEXTS_TABLE . "
					WHERE text_id = $text_id
					AND text_type = $text_type";
				$result = $db->sql_query($sql);
				$text_row = $db->sql_fetchrow($result);
				$db->sql_freeresult($result);
				
				if(!$text_row)
				{
					$action = '';
					break;
				}
				
				decode_message($text_row['text_content'], $text_row['bbcode_uid']);
				
				$this->new_config['text_content'] = $text_row['text_content'];
				unset($text_row);
				
			// no break

			case 'add':
				if(!isset($text_ary[$text_type]['title']))
				{
					$action = '';
					break;
				}

				$display_vars = array(
					'legend1'		=> 'CONTENT',
					'text_content'	=> array('lang' => $text_ary[$text_type]['title'] . '_ITEM',	'validate'	=> 'string:1',	'type' => 'textarea:5:40'),
				);
				
				if($action == 'add')
				{
					$this->new_config['text_content'] = '';
				}
				
				if($submit)
				{
					$this->new_config = utf8_normalize_nfc($request->variable('config', array('' => ''), true));
					
					// We validate the complete config if whished
					validate_config_vars($display_vars, $this->new_config, $error);
					
					// Do not write values if there is an error
					if(!sizeof($error))
					{
						$message = $this->new_config['text_content'];

						$this->new_config['bbcode_uid'] = $this->new_config['bbcode_bitfield'] = $options = '';
						generate_text_for_storage($this->new_config['text_content'], $this->new_config['bbcode_uid'], $this->new_config['bbcode_bitfield'], $options, $config['allow_bbcode'], $config['allow_post_links'], $config['allow_smilies']);
						
						if($action == 'add')
						{
							// Get last text position
							$sql = 'SELECT MAX(text_order) AS last_position
								FROM ' . CHAT_TEXTS_TABLE;
							$result = $db->sql_query($sql);
							$this->new_config['text_order'] = (int)$db->sql_fetchfield('last_position') + 1;
							$db->sql_freeresult($result);
							
							$this->new_config['text_type'] = $text_type;

							$sql = 'INSERT INTO ' . CHAT_TEXTS_TABLE . ' ' . $db->sql_build_array('INSERT', $this->new_config);
						}
						else
						{
							$sql = 'UPDATE ' . CHAT_TEXTS_TABLE . '
								SET ' . $db->sql_build_array('UPDATE', $this->new_config) . "
								WHERE text_id = $text_id
								AND text_type = $text_type";
						}
						$db->sql_query($sql);
	
						$cache->destroy('_chat_texts');
						
						$action = '';
						break;
					}
				}
				
				$this->display_vars($display_vars);
				
				$this->page_title = $text_ary[$text_type]['title'] . '_' . strtoupper($action);
				
				$template->assign_vars(array(
					'S_EDIT'	=> true,
					'U_BACK'	=> $this->u_action,
					
					'S_HIDDEN_FIELDS'	=> build_hidden_fields(array(
						'action'	=> $action,
						'type'		=> $text_type,
						'id'		=> $text_id,
					)),
				));
			break;
			
			case 'delete':
				$sql = 'DELETE FROM ' . CHAT_TEXTS_TABLE . "
					WHERE text_id = $text_id
					AND text_type = $text_type";
				$db->sql_query($sql);

				$cache->destroy('_chat_texts');
				
				$this->set_json_display(array(
					'action'	=> 'delete_row',
					'row_id'	=> $text_id,
				));
			break;
			
			case 'sort':
				$rows = $request->variable('row', array(0 => 0));
				
				foreach($rows as $position => $text_id)
				{
					$sql = 'UPDATE ' . CHAT_TEXTS_TABLE . '
						SET text_order = ' . ((int)$position + 1) . "
						WHERE text_id = $text_id";
					$db->sql_query($sql);
				}
				
				$cache->destroy('_chat_texts');
				exit_handler();
			break;
		}
		
		if(!$action)
		{
			$bbcode_bitfield = '';

			$sql = 'SELECT *
				FROM ' . CHAT_TEXTS_TABLE . '
				ORDER BY text_order';
			$result = $db->sql_query($sql);
			while($row = $db->sql_fetchrow($result))
			{
				$row_type = (int)$row['text_type'];

				if(!isset($text_ary[$row_type]))
				{
					continue;
				}
				
				$text_ary[$row_type]['rows'][] = $row;
				
				// Define the global bbcode bitfield, will be used to load bbcodes
				$bbcode_bitfield = $bbcode_bitfield | base64_decode($row['bbcode_bitfield']);
			}
			$db->sql_freeresult($result);
			
			// Instantiate BBCode if needed
			if($bbcode_bitfield !== '')
			{
				if(!class_exists('bbcode', false))
				{
					include($phpbb_root_path . 'includes/bbcode.' . $phpEx);
				}
					
				$bbcode = new \bbcode(base64_encode($bbcode_bitfield));
			}
			
			foreach($text_ary as $text_type => $data_ary)
			{
				$s_title = $data_ary['title'];
	
				$template->assign_block_vars('textrow', array(
					'S_LEGEND'			=> (isset($user->lang[$s_title . '_TITLE']) ? $user->lang[$s_title . '_TITLE'] : $s_title),
					'S_EXPLAIN'			=> (isset($user->lang[$s_title . '_EXPLAIN']) ? $user->lang[$s_title . '_EXPLAIN'] : ''),
					'S_IS_EMPTY'		=> (sizeof($data_ary['rows']) ? false : true),
					'S_BUTTON_TITLE'	=> $user->lang($s_title . '_ADD'),
					'U_ADD'				=> $this->u_action . '&amp;action=add&amp;type=' . $text_type,
				));
				
				foreach($data_ary['rows'] as $row)
				{
					// Second parse bbcode here
					if($row['bbcode_bitfield'])
					{
						$bbcode->bbcode_second_pass($row['text_content'], $row['bbcode_uid'], $row['bbcode_bitfield']);
					}
					else
					{
						$row['text_content'] = htmlspecialchars_decode($row['text_content']);
					}
					
					$row['text_content'] = preg_replace('#\{L_([A-Z0-9_\-]+)\}#e', "isset(\$user->lang['\$1']) ? \$user->lang['\$1'] : '\$1'", $row['text_content']);
					$row['text_content'] = bbcode_nl2br($row['text_content']);
					$row['text_content'] = smiley_text($row['text_content']);
					
					$template->assign_block_vars('textrow.item', array(
						'S_CONTENT'		=> $row['text_content'],
						'S_ID'			=> $row['text_id'],
						
						'U_DELETE'		=> $this->u_action . '&amp;action=delete&amp;type=' . $text_type . '&amp;id=' . $row['text_id'],
						'U_EDIT'		=> $this->u_action . '&amp;action=edit&amp;type=' . $text_type . '&amp;id=' . $row['text_id'],
					));
				}
			}
			
			$template->assign_vars(array(
				'S_HIDDEN_FIELDS'	=> build_hidden_fields(array(
					'action'	=> 'sort'
				))
			));
		}
	}
	
	function display_vars(&$display_vars)
	{
		global $user, $template;

		foreach($display_vars as $config_key => $vars)
		{
			if(!is_array($vars) && strpos($config_key, 'legend') === false)
			{
				continue;
			}

			if(strpos($config_key, 'legend') !== false)
			{
				$template->assign_block_vars('options', array(
					'S_LEGEND'		=> true,
					'LEGEND'		=> (isset($user->lang[$vars])) ? $user->lang[$vars] : $vars)
				);

				continue;
			}

			$type 		= explode(':', $vars['type']);
			$content 	= build_cfg_template($type, $config_key, $this->new_config, $config_key, $vars);

			if(empty($content))
			{
				continue;
			}

			$template->assign_block_vars('options', array(
				'KEY'			=> $config_key,
				'TITLE'			=> (isset($user->lang[$vars['lang']])) ? $user->lang[$vars['lang']] : $vars['lang'],
				'S_EXPLAIN'		=> (isset($user->lang[$vars['lang'] . '_EXPLAIN'])) ? $user->lang[$vars['lang'] . '_EXPLAIN'] : '',
				'CONTENT'		=> $content,
				'IS_HIDDEN'		=> (isset($vars['display']) ? !$vars['display'] : false),
			));

			unset($display_vars[$config_key]);
		}
	}
	
	function make_select($key, $select_ids = '', $size = 5, $extra = '')
	{
		global $user, $db, $phpbb_root_path, $phpEx;

		$multiple 	= false;
		$in_group	= false;
		
		switch($key)
		{
			case 'chat_bbcode_format':
				$ary = array(
					'button'	=> 'CHAT_BBCODE_INBUTTON',
					'select'	=> 'CHAT_BBCODE_INSELECT',
				);
			break;

			case 'chat_direction':
				$ary = array(
					'down'		=> 'CHAT_DIRECTION_DOWN',
					'up'		=> 'CHAT_DIRECTION_UP',
				);
			break;
			
			case 'chat_disallowed_bbcode':
				$bbcodes = array(
					'default' 	=> array(
						1	=> 'b',
						2	=> 'i',
						7	=> 'u',
						8	=> 'code',
						6	=> 'color',
						11	=> 'flash',
						4	=> 'img',
						9	=> 'list',
						0	=> 'quote',
						5	=> 'size',
						3	=> 'url'
					),
					'custom'	=> array()
				);
				
				// Custom BBcodes
				$sql = 'SELECT bbcode_id, bbcode_tag
					FROM ' . BBCODES_TABLE . '
					WHERE display_on_posting = 1
					ORDER BY bbcode_tag';
				$result = $db->sql_query($sql);
				while($row = $db->sql_fetchrow($result))
				{
					$bbcodes['custom'][$row['bbcode_id']] = $row['bbcode_tag'];
				}
				$db->sql_freeresult($result);
				
				$ary = array('legend1' => 'DEFAULT_BBCODES');
				
				foreach($bbcodes['default'] as $bbcode_id => $bbcode_tag)
				{
					$ary[$bbcode_id] = ucfirst($bbcode_tag);
				}
				
				if(sizeof($bbcodes['custom']))
				{
					$ary['legend2'] = 'CUSTOM_BBCODES';
					
					foreach($bbcodes['custom'] as $bbcode_id => $bbcode_tag)
					{
						$ary[$bbcode_id] = ucfirst($bbcode_tag);
					}
				}
				
				$bitfield = new \bitfield($select_ids);
				$select_ids = $bitfield->get_all_set();

				$multiple = true;
			break;
			
			case 'chat_position':
				$ary = array(
					'top'		=> 'CHAT_POSITION_TOP',
					'bottom'	=> 'CHAT_POSITION_BOTTOM',
				);
			break;
			
			case 'chat_store_time':
				$ary = array(
					0			=> 'NO_LIMIT',
					86400		=> 'ONE_DAY',
					604800		=> 'ONE_WEEK',
					2592000		=> 'ONE_MONTH',
					31104000	=> 'ONE_YEAR',
					62208000	=> 'TWO_YEARS',
				);
			break;
			
			case 'forum_ids':
				$forum_ary = make_forum_select($select_ids, false, true, false, true, false, true);
				$ary = array();

				$legend_id = 1;
				
				foreach($forum_ary as $forum_id => $row)
				{
					if(!$row['padding'])
					{
						$ary['legend' . $legend_id] = $row['forum_name'];
						$legend_id++;
					}
					else
					{
						$ary[$forum_id] = $row['padding'] . $row['forum_name'];
					}
				}
				
				$multiple = true;
			break;
			
			case 'page_file':
				$ary = array(''	=> 'SELECT_PAGE');
				
				if($extra == 'add')
				{
					// Exclude files already in use
					$sql = 'SELECT page_alias
						FROM ' . CHAT_PAGES_TABLE . "
						WHERE page_path = ''";
					$result = $db->sql_query($sql);
					while($row = $db->sql_fetchrow($result))
					{
						$this->exclude_files[] = $row['page_alias'];
					}
					$db->sql_freeresult($result);
				}
				
				// Read all the avaliable files in phpbb root path
				if($dir = @opendir($phpbb_root_path))
				{
					$file_ary = array();

					while(($file = @readdir($dir)) !== false)
					{
						if(($pos = strpos($file, ".$phpEx")) !== false)
						{
							$filename = substr($file, 0, $pos);
						
							if($filename && !in_array($filename, $this->exclude_files))
							{
								$file_ary[$filename] = $file;
							}
						}
					}
					closedir($dir);
					
					if(sizeof($file_ary))
					{
						asort($file_ary);
						$ary = array_merge($ary, array('legend1' => 'FORUM_FILES'), $file_ary);
					}
				}
				
				$ary = array_merge($ary, array(
					'legend2'	=> 'CUSTOM_FILES',
					'-'			=> 'CUSTOM_FILE',
				));
			break;
			
			case 'room_groups':
				// Get all the groups
				$sql = 'SELECT DISTINCT group_type, group_name, group_id
					FROM ' . GROUPS_TABLE . '
					ORDER BY group_type DESC, group_name ASC';
				$result = $db->sql_query($sql);
				while($row = $db->sql_fetchrow($result))
				{
					$ary[$row['group_id']] = (($row['group_type'] == GROUP_SPECIAL) ? $user->lang['G_' . $row['group_name']] : $row['group_name']);
				}
				$db->sql_freeresult($result);

				$multiple = true;
			break;
			
			default:
				return '';
			break;
		}
		
		if(!is_array($select_ids))
		{
			$select_ids = explode('|', $select_ids);
		}
		
		if($multiple)
		{
			$result = '<select id="' . $key . '" name="' . $key . '[]" multiple="multiple" size="' . $size . '">';
		}
		else
		{
			$select_ids = array($select_ids[0]);
			$result = '<select id="' . $key . '" name="config[' . $key . ']">';
		}
		
		foreach($ary as $value => $lang)
		{
			$title	= (isset($user->lang[$lang]) ? $user->lang[$lang] : $lang);

			if(strpos($value, 'legend') !== false)
			{
				$result .= (($in_group) ? '</optgroup>' : '') . '<optgroup label="' . $title . '">';
				$in_group = true;
				
				continue;
			}
			
			$selected = (in_array($value, $select_ids) ? ' selected="selected"' : '');
			$result .= '<option value="' . $value . '"' . $selected . '>' . $title . '</option>';
		}
		
		if($in_group)
		{
			$result .= '</optgroup>';
		}
		
		$result .= '</select>';
		
		return $result;
	}
	
	function set_json_display($json)
	{
		global $template;

		$this->tpl_name = 'chat_ajax';
		$template->assign_var('S_JSON_DATA', json_encode($json));
	}
}
