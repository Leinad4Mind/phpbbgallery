<?php
/*
* @package cBB Chat
* @version v1.2.4 17/06/2022
*
* @copyright (c) 2022 CaniDev
* @license https://creativecommons.org/licenses/by-nc/4.0/
*/

namespace canidev\chat\controller;

use canidev\chat\libraries\constants;

class admin_controller_rooms extends admin_controller_base
{
	/**
	 * {@inheritDoc}
	 */
	public function _display($mode)
	{
		$this->tpl_name		= 'acp_chat_rooms';
		$this->page_title	= 'ACP_CHAT_ROOMS';

		$room_id 	= $this->request->variable('id', 0);
		$error		= array();
		
		switch($this->action)
		{
			case 'delete':
				if(confirm_box(true))
				{
					if($room_id != constants::GUEST_ROOM)
					{
						// Get the title and key of the room before remove
						$sql = 'SELECT room_title, room_key
							FROM ' . $this->tables['rooms'] . '
							WHERE room_id = ' . $room_id;
						$result = $this->db->sql_query($sql);
						$data = $this->db->sql_fetchrow($result);
						$this->db->sql_freeresult($result);
						
						if($data)
						{
							$data['room_title'] = $this->language->lang($data['room_title']);
							
							// Delete the room
							$sql = 'DELETE FROM ' . $this->tables['rooms'] . '
								WHERE room_id = ' . $room_id;
							$this->db->sql_query($sql);
							
							// Delete the messages of the room
							$sql = 'DELETE FROM ' . $this->tables['messages'] . '
								WHERE dest_key = ' . $data['room_key'];
							$this->db->sql_query($sql);

							$this->log->add('admin', $this->user->data['user_id'], $this->user->ip, 'LOG_CHAT_ROOM_REMOVED', time(), array($data['room_title']));
							$this->cache->destroy('_chat_options');
				
							$this->json->send(array(
								'action'	=> 'deleteRow',
								'rowId'		=> $room_id,
							));
						}
					}
				}
				else
				{
					confirm_box(false, $this->language->lang('REMOVE_ROOM_CONFIRM'), '', '@canidev_core/confirmbox.html');
				}
			break;

			case 'edit':
				$sql = 'SELECT *
					FROM ' . $this->tables['rooms'] . "
					WHERE room_id = $room_id";
				$result = $this->db->sql_query($sql);
				$room_data = $this->db->sql_fetchrow($result);
				$this->db->sql_freeresult($result);
				
				if(!$room_data)
				{
					trigger_error('NO_ROOM', E_USER_WARNING);
				}
				
				$room_auth = @unserialize($room_data['room_data']);
				
				$room_data['room_groups']	= (empty($room_auth['groups']) ? array() : $room_auth['groups']);
				$room_data['room_users']	= (empty($room_auth['users']) ? '' : implode("\n", $room_auth['users']));
				$room_data['linked_forums']	= (empty($room_auth['linked_forums']) ? array() : $room_auth['linked_forums']);
				$room_data['linked_groups']	= (empty($room_auth['linked_groups']) ? array() : $room_auth['linked_groups']);
				
			// no break

			case 'add':
				add_form_key(self::FORM_KEY);

				$autopurge_options = array(
					0			=> 'DISABLED',
					86400		=> 'EACH_DAY',
					604800		=> 'EACH_WEEK',
					2592000		=> 'EACH_MONTH',
					31104000	=> 'EACH_YEAR',
				);

				$display_vars = array(
					'legend1'		=> 'CHAT_ROOM_CONFIG',
					'room_title'			=> array('lang' => 'CHAT_ROOM_TITLE',		'validate' => 'string:1:255',	'type' => 'text:40:255'),
					'room_enabled'			=> array('lang' => 'CHAT_ROOM_ENABLED',		'validate' => 'bool',			'type' => 'radio:yes_no'),
					'room_autopurge_time'	=> array('lang' => 'CHAT_ROOM_AUTOPURGE',	'validate' => 'int',			'type' => 'custom',				'function' => array($this->tools, 'make_select'),	'params' => array($autopurge_options, '{KEY}', '{CONFIG_VALUE}')),
					'room_msg_limit'		=> array('lang' => 'CHAT_ROOM_MSG_LIMIT',	'validate' => 'int:0:99999',	'type' => 'number:0:99999',		'default' => 0),
				);
				
				if($room_id != constants::GUEST_ROOM)
				{
					$display_vars += array(
						'legend2'		=> 'CHAT_ROOM_AUTH',
						'room_groups'	=> array('lang' => 'CHAT_ROOM_GROUPS',	'type' => 'custom',	'function' => array($this->tools, 'groups_select'),	'params' => array('{KEY}', '{CONFIG_VALUE}')),
						'room_users'	=> array('lang' => 'CHAT_ROOM_USERS',	'type' => 'textarea:5:5'),
					);
				}
				
				$display_vars += array(
					'legend3'		=> 'CHAT_ROOM_CONNECTIONS',
					'linked_forums'	=> array('lang' => 'CHAT_ROOM_LINKED_FORUMS',	'type' => 'custom',	'function' => array($this->tools, 'make_select'),		'params' => array($this->forum_ids_options(), '{KEY}', '{CONFIG_VALUE}', \canidev\core\tools::SELECT_MULTIPLE)),
					'linked_groups'	=> array('lang' => 'CHAT_ROOM_LINKED_GROUPS',	'type' => 'custom',	'function' => array($this->tools, 'groups_select'),		'params' => array('{KEY}', '{CONFIG_VALUE}', false),	'display' => ($room_id != constants::GUEST_ROOM)),
				);
				
				// Guest room have different use for forums
				if($room_id == constants::GUEST_ROOM)
				{
					$display_vars['linked_forums']['lang'] = 'CHAT_ROOM_GUEST_FORUMS';
				}
				
				if($this->action == 'add')
				{
					$room_id = 0;

					$room_data = array(
						'room_enabled'	=> true,
						'room_groups'	=> 'all',
						'room_users'	=> '',
					);
				}
				
				/**
				* @event chat.acp_rooms_vars
				* @var	array		display_vars	Array of config values to display and process
				* @var	array		room_data		Original data of room
				* @var	boolean		submit			Do we display the form or process the submission
				* @since 1.2.0
				*/
				$submit = &$this->submit;
				$vars = array('display_vars', 'room_data', 'submit');
				extract($this->dispatcher->trigger_event('chat.acp_rooms_vars', compact($vars)));
				
				$this->new_config = $room_data;
				
				if($this->submit)
				{
					$this->new_config = utf8_normalize_nfc($this->request->variable('config', array('' => ''), true));
					$this->new_config['room_groups']	= ($this->request->is_set_post('all_groups_room_groups')) ? 'all' : $this->request->variable('room_groups', array(0));
					$this->new_config['linked_forums']	= $this->request->variable('linked_forums', array(0));
					$this->new_config['linked_groups']	= $this->request->variable('linked_groups', array(0));
					
					if(!check_form_key(self::FORM_KEY))
					{
						$error[] = $this->language->lang('FORM_INVALID');
					}
					
					// We validate the complete config if whished
					validate_config_vars($display_vars, $this->new_config, $error);
					
					$data = array();
					
					if(!sizeof($error))
					{
						if($room_id != constants::GUEST_ROOM)
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
										WHERE ' . $this->db->sql_in_set('username_clean', $user_ary);
									$result = $this->db->sql_query($sql);
									while($row = $this->db->sql_fetchrow($result))
									{
										$data['users'][$row['user_id']] = $row['username'];
									}
									$this->db->sql_freeresult($result);
								}
							}
							
							if(!empty($this->new_config['linked_groups']))
							{
								$data['linked_groups'] = $this->new_config['linked_groups'];
							}
						}
						
						if(!empty($this->new_config['linked_forums']))
						{
							$data['linked_forums'] = $this->new_config['linked_forums'];
						}

						$sql_ary = array(
							'room_title'			=> $this->new_config['room_title'],
							'room_enabled'			=> ($room_id == constants::GUEST_ROOM) ? 1 : $this->new_config['room_enabled'],
							'room_autopurge_time'	=> $this->new_config['room_autopurge_time'],
							'room_msg_limit'		=> $this->new_config['room_msg_limit'],
							'room_data'				=> $data,
						);
						
						/**
						* @event chat.acp_rooms_submit
						* @var	array	sql_ary		Array to insert on DB
						* @since 1.2.0
						*/
						$vars = array('sql_ary');
						extract($this->dispatcher->trigger_event('chat.acp_rooms_submit', compact($vars)));
						
						$sql_ary['room_data'] = (sizeof($sql_ary['room_data']) ? serialize($data) : '');
						
						if($this->action == 'add')
						{
							// Get max order
							$sql = 'SELECT MAX(room_order) AS max_order
								FROM ' . $this->tables['rooms'];
							$result = $this->db->sql_query($sql);
							$sql_ary['room_order'] = (int)$this->db->sql_fetchfield('max_order') + 1;
							$this->db->sql_freeresult($result);
							
							$sql_ary['room_key'] = time() - 1001;

							$sql = 'INSERT INTO ' . $this->tables['rooms'] . ' ' . $this->db->sql_build_array('INSERT', $sql_ary);
							$notice[] = 'CHAT_ROOM_ADDED';
						}
						else
						{
							$sql = 'UPDATE ' . $this->tables['rooms'] . '
								SET ' . $this->db->sql_build_array('UPDATE', $sql_ary) . "
								WHERE room_id = $room_id";
								
							$notice[] = 'CHAT_ROOM_UPDATED';
						}
						
						$this->db->sql_query($sql);
						
						$this->cache->destroy('_chat_options');
						
						trigger_error($this->language->lang('CONFIG_UPDATED') . adm_back_link($this->form_action));
					}
				}

				if($room_id == constants::GUEST_ROOM)
				{
					$display_vars['room_enabled']['display'] = false;
				}
				
				$this->display_vars($display_vars);
				
				$this->template->assign_vars(array(
					'S_EDIT'	=> true,
					'S_HIDDEN_FIELDS'	=> build_hidden_fields(array(
						'action'	=> $this->action,
						'id'		=> $room_id
					)),
					
					'U_BACK'			=> $this->form_action,
					'U_FIND_USERNAME'	=> append_sid($this->phpbb_root_path . 'memberlist.' . $this->php_ext, 'mode=searchuser&amp;form=acp_chat_rooms&amp;field=room_users')
				));
			break;
			
			case 'sort':
				$rows = $this->request->variable('row', array(0 => 0));
				
				foreach($rows as $position => $room_id)
				{
					$sql = 'UPDATE ' . $this->tables['rooms'] . '
						SET room_order = ' . ((int)$position + 1) . "
						WHERE room_id = $room_id";
					$this->db->sql_query($sql);
				}
				
				$this->cache->destroy('_chat_options');
				$this->json->send();
			break;
			
			default:
				$sql = 'SELECT *
					FROM ' . $this->tables['rooms'] . '
					ORDER BY room_order';
				$result = $this->db->sql_query($sql);
				while($row = $this->db->sql_fetchrow($result))
				{
					$title 		= $row['room_title'];
					$title 		= $this->language->is_set(strtoupper($title)) ? $this->language->lang(strtoupper($title)) : ucfirst($title);

					$this->template->assign_block_vars('roomrow', array(
						'S_ID'		=> $row['room_id'],
						'S_KEY'		=> $row['room_key'],
						'S_TITLE'	=> $title,
						
						'U_DELETE'	=> ($row['room_id'] != constants::GUEST_ROOM) ? $this->form_action . '&amp;action=delete&amp;id=' . $row['room_id'] : '',
						'U_EDIT'	=> $this->form_action . '&amp;action=edit&amp;id=' . $row['room_id'],
					));
				}
				$this->db->sql_freeresult($result);

				$this->template->assign_vars(array(
					'S_HIDDEN_FIELDS'	=> build_hidden_fields(array(
						'action'	=> 'sort'
					)),
					
					'U_ROOM_ADD'	=> $this->form_action . '&amp;action=add'
				));
			break;
		}
		
		$this->template->assign_vars(array(
			'IN_CHAT_ADMIN'		=> true,
			'S_ERROR'			=> (sizeof($error)) ? true : false,
			'ERROR_MSG'			=> implode('<br />', $error),
		));
	}
	
	/**
	 * Forums selector options
	 * @return array
	 */
	protected function forum_ids_options()
	{
		$forum_ary = make_forum_select(false, false, true, false, true, false, true);
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
		
		return $ary;
	}
}
