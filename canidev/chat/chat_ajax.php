<?php
/*
* @name chat_ajax.php
* @package cBB Chat
* @version v1.1.1 01/07/2015
*
* @copyright (c) 2015 CaniDev
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/

namespace canidev\chat;

// @ignore
if(!defined('IN_PHPBB'))
{
	exit;
}

class chat_ajax
{
	private $user_key	= false;
	private $user_data	= false;

	private $actions = array(
		'pmuser'		=> array('lang' => 'CHAT_SEND_PM',		'auth' => 'u_chat_sendpm',	'check' => 'chat_allow_pm'),
		'mentionuser'	=> array('lang' => 'CHAT_MENTION',		'auth' => 'u_chat_post'),
		'banuser'		=> array('lang' => 'CHAT_BAN_USER',		'auth' => 'm_ban'),
		'unbanuser'		=> array('lang' => 'CHAT_UNBAN_USER',	'auth' => 'm_ban'),
		'deluser'		=> array('lang' => 'CHAT_DELETE_USER',	'auth' => 'a_userdel'),
	);
	
	private $status_ary = array(
		CHAT_STATUS_AVAILABLE		=> 'available',
		CHAT_STATUS_AWAY			=> 'away',
		CHAT_STATUS_BUSY			=> 'busy',
		CHAT_STATUS_HIDDEN			=> 'hidden',
	);
	
	protected $chat;
	protected $config;
	protected $db;
	protected $helper;
	protected $request;
	protected $template;
	protected $user;
	
	protected $root_path;
	protected $php_ext;
	
	/**
	* Constructor
	*
	* @param \phpbb\auth\auth 					$auth			Authentication object
	* @param \phpbb\config\config 				$config			Config Object
	* @param \phpbb\db\driver\driver_interface	$db				DB Object
	* @param \phpbb\controller\helper			$helper       	Controller helper object
	* @param \phpbb\request\request 			$request		Request object
	* @param \phpbb\template\template			$template     	Template object
	* @param \phpbb\user						$user			User object
	* @param string								$root_path		phpBB root path
	* @param string								$php_ext		phpEx
	*
	* @access public
	*/
	public function __construct(\phpbb\auth\auth $auth, \phpbb\config\config $config, \phpbb\db\driver\driver_interface $db, \phpbb\controller\helper $helper, \phpbb\request\request $request, \phpbb\template\template $template, \phpbb\user $user, $root_path, $php_ext)
	{
		global $chat;

		$this->auth		= $auth;
		$this->chat 	= &$chat;
		$this->config	= $config;
		$this->db		= $db;
		$this->helper	= $helper;
		$this->request	= $request;
		$this->template	= $template;
		$this->user		= $user;
		
		$this->root_path	= $root_path;
		$this->php_ext		= $php_ext;
		
		$this->user_key = $request->variable($config['cookie_name'] . '_chat_key', 0, false, \phpbb\request\request_interface::COOKIE);
		
		@define('PHPBB_USE_BOARD_URL_PATH', true);
	}
	
	public function auth($auth_option, $data = false)
	{
		if($auth_option[0] == '-')
		{
			return ($this->auth->acl_get(substr($auth_option, 1, strlen($auth_option))) ? true : false);
		}
	
		if($data === false)
		{
			if($this->auth->acl_gets(array("u_chat_$auth_option", "m_chat_$auth_option"), 0))
			{
				return true;
			}
			
			return false;
		}
		else
		{
			if($this->auth->acl_get("u_chat_$auth_option") && $data['poster_key'] == $this->user_key)
			{
				return true;
			}
			
			if($this->auth->acl_get("m_chat_$auth_option"))
			{
				return true;
			}
		}
		
		return false;
	}
	
	public function run($force_action = '')
	{
		$action			= ($force_action) ? $force_action : $this->request->variable('action', '');
		$action			= (!$this->chat->enabled) ? 'disable' : $action;

		$last_update 	= $this->request->variable('last_update', 0);
		$submit			= $this->request->variable('submit', false);
		
		$allow_bbcode	= ($this->config['allow_bbcode'] && $this->config['chat_allow_bbcode']) ? true : false;
		$allow_smilies	= ($this->config['allow_smilies']) ? true : false;
		$allow_urls		= ($this->config['allow_post_links']) ? true : false;
		
		$json = array(
			'action'	=> '',
			'success'	=> true,
		);
		
		if(in_array($action, array('delete', 'edit', 'quote', 'whois')))
		{
			$message_id = $this->request->variable('id', 0);
		}

		switch($action)
		{
			case 'disable':
				$json['action'] = 'disable';
			break;

			case 'disconnect':
			case 'disconnect_on_refresh':
				$sql = 'UPDATE ' . CHAT_USERS_TABLE . '
					SET user_online = 0
					WHERE user_id = ' . $this->user->data['user_id'];
					
				if($this->user->data['user_id'] == ANONYMOUS)
				{
					$sql .= ' AND (user_key = ' . $this->user_key . "
						OR user_ip = '" . $this->user->ip . "')";
				}
				
				$this->db->sql_query($sql);
				
				$this->room_ary = $this->chat->obtain_rooms();
				
				// Delete private messages
				$sql = 'DELETE FROM ' . CHAT_MESSAGES_TABLE . '
					WHERE (dest_key = ' . $this->user_key . '
					OR (poster_key = ' . $this->user_key . '
						AND ' . $this->db->sql_in_set('dest_key', array_keys($this->room_ary), true) . ')
					)';
				$this->db->sql_query($sql);
				
				if($action == 'disconnect_on_refresh')
				{
					return true;
				}
			break;

			case 'connect':
				// Recover the user session
				$this->get_current_user();
				
			// no break;
			
			case 'connect_on_post':
				$update_ary = array();
				
				// Add a new session if no exists
				if(!$this->user_data)
				{
					$username 			= '';
					$correct_connect	= true;

					if($this->user->data['user_id'] != ANONYMOUS)
					{
						// Bots never allowed
						if($this->user->data['user_type'] == USER_IGNORE)
						{
							break;
						}
						
						// Delete previous guest sessions from the same user
						$sql = 'DELETE FROM ' . CHAT_USERS_TABLE . '
							WHERE user_id = ' . ANONYMOUS . '
							AND user_key = ' . $this->user_key . "
							AND user_ip = '" . $this->user->ip . "'";
						$this->db->sql_query($sql);
						
						$this->user_key = $this->user->data['user_id'];
					}
					else
					{
						$username 			= utf8_normalize_nfc($this->request->variable('username', '', true));
						$username_register	= utf8_normalize_nfc($this->request->variable('username_register', '', true));
						$password			= utf8_normalize_nfc($this->request->variable('password', '', true));
						
						$this->user_key	= time() - 1001;
						
						// Login dialog
						if(!$username && !$username_register)
						{
							$json['action'] = $action = 'login';
							
							$this->template->assign_vars(array(
								'S_LOGIN'	=> true,
								'S_TITLE'	=> $this->user->lang['LOGIN'],
								
								'ALLOW_GUESTS'	=> $this->auth('view'),
								'U_REGISTER'	=> append_sid($this->root_path . 'ucp.' . $this->php_ext, 'mode=register'),
							));
							
							break;
						}
						
						if(!$username_register)
						{
							// Check if username already exists
							$sql = 'SELECT u.user_id, uc.user_id
								FROM ' . USERS_TABLE . ' u,' . CHAT_USERS_TABLE . " uc
								WHERE u.username_clean = '" . $this->db->sql_escape(utf8_clean_string($username)) . "'
								OR LOWER(uc.username) = '" . $this->db->sql_escape(strtolower($username)) . "'";
							$result = $this->db->sql_query($sql);
							$user_row = $this->db->sql_fetchrow($result);
							$this->db->sql_freeresult($result);
							
							if($user_row)
							{
								$submit = false;
								$json['action'] = $action = 'login';
								
								$this->template->assign_vars(array(
									'S_LOGIN'	=> true,
									'S_TITLE'	=> $this->user->lang['CHAT_USER_ALREADY_EXISTS']
								));
								
								break;
							}
						}
						else
						{
							// Login in the forum
							$autologin			= true;
							$viewonline 		= 1;
							$correct_connect	= false;

							$result = $this->auth->login($username_register, $password, $autologin, $viewonline, false);

							switch($result['status'])
							{
								case LOGIN_SUCCESS:
									$correct_connect = true;
									$username = $this->user->data['username'];
									
									$this->auth->acl($this->user->data);

									$json['username'] = get_username_string('full', $this->user->data['user_id'], $this->user->data['username'], $this->user->data['user_colour']);

									if($this->config['chat_show_avatars'])
									{
										if(!function_exists('get_user_avatar'))
										{
											include($this->root_path . 'includes/functions_display.' . $this->php_ext);
										}
									
										$row_avatar = get_user_avatar($this->user->data['user_avatar'], $this->user->data['user_avatar_type'], $this->user->data['user_avatar_width'], $this->user->data['user_avatar_height']);
										
										// Fix path error occurs in some cases
										if($row_avatar && $this->user->data['user_avatar_type'] != 'avatar.driver.gravatar')
										{
											$row_avatar = preg_replace('#src\="(\.|\/)+#', 'src="' . $this->chat->web_path, $row_avatar);
										}

										if(!$row_avatar)
										{
											$row_avatar = '<img src="' . $this->chat->web_path . $this->chat->path . 'images/no-avatar.gif" />';
										}
										
										$json['user_avatar'] = $row_avatar;
									}
									
								//	$user->setup();

									$this->user_key = $this->user->data['user_id'];
								break;
								
								case LOGIN_BREAK:
									$err = $this->user->lang[$result['error_msg']];
								break;
								
								case LOGIN_ERROR_ATTEMPTS:
									$redirect = $this->helper->route('canidev_chat_controller');
									$json['redirect'] = append_sid($this->root_path . 'ucp.' . $this->php_ext . '?mode=login&amp;redirect=' . urlencode($redirect));
								
									$err = $this->user->lang[$result['error_msg']];
								break;

								case LOGIN_ERROR_PASSWORD_CONVERT:
									$err = sprintf(
										$user->lang[$result['error_msg']],
										($this->config['email_enable']) ? '<a href="' . append_sid($this->root_path . 'ucp' . $this->php_ext, 'mode=sendpassword') . '">' : '',
										($this->config['email_enable']) ? '</a>' : '',
										($this->config['board_contact']) ? '<a href="mailto:' . htmlspecialchars($this->config['board_contact']) . '">' : '',
										($this->config['board_contact']) ? '</a>' : ''
									);
								break;

								// Username, password, etc...
								default:
									$err = $this->user->lang[$result['error_msg']];

									// Assign admin contact to some error messages
									if ($result['error_msg'] == 'LOGIN_ERROR_USERNAME' || $result['error_msg'] == 'LOGIN_ERROR_PASSWORD')
									{
										$err = (!$this->config['board_contact']) ? $this->user->lang($result['error_msg'], '', '') : $this->user->lang($result['error_msg'], '<a href="mailto:' . htmlspecialchars($this->config['board_contact']) . '">', '</a>');
									}
								break;
							}
							
							if(!empty($err))
							{
								$submit = false;
								$json['action'] = $action = 'login';
								
								$this->template->assign_vars(array(
									'S_LOGIN'	=> true,
									'S_TITLE'	=> $this->user->lang['LOGIN'],
									'S_ERROR'	=> $err
								));
								
								break;
							}
						}
					}
					
					if($correct_connect)
					{
						// Delete previous sessions from the same user
						$sql = 'DELETE FROM ' . CHAT_USERS_TABLE . '
							WHERE user_id = ' . $this->user->data['user_id'];

						if($this->user->data['user_id'] == ANONYMOUS)
						{
							$sql .= " AND user_ip = '" . $this->user->ip . "'";
						}
						
						$result = $this->db->sql_query($sql);
					
						$this->user_data = array(
							'user_id'				=> $this->user->data['user_id'],
							'user_ip'				=> $this->user->ip,
							'username'				=> $username,
							'session_start'			=> time(),
							'session_viewonline'	=> $this->user->data['session_viewonline'],
							'user_lastjoin'			=> time(),
							'user_key'				=> $this->user_key,
							'user_online'			=> 1,
							'user_status'			=> CHAT_STATUS_AVAILABLE,
							'exclude_time'			=> 0,
						);
						
						$sql = 'INSERT INTO ' . CHAT_USERS_TABLE . ' ' . $this->db->sql_build_array('INSERT', $this->user_data);
						$this->db->sql_query($sql);
						
						$cookie_expire = ($this->user->data['user_id'] != ANONYMOUS) ? $this->user->time_now + (($this->config['max_autologin_time']) ? 86400 * (int) $this->config['max_autologin_time'] : 31536000) : 0;
						$this->user->set_cookie('chat_key', $this->user_key, $cookie_expire);
					}
				}
				else
				{
					$update_ary = array(
						'user_online'			=> 1,
						'session_start'			=> time(),
						'session_viewonline'	=> $this->user->data['session_viewonline'],
						'user_lastjoin'			=> time(),
					);
					
					if(!$this->config['chat_remember_status'] || ($this->user_data['user_status'] == CHAT_STATUS_AWAY && $this->request->variable('auto_away', false)))
					{
						$update_ary['user_status'] = CHAT_STATUS_AVAILABLE;
					}
				}
				
				// Remove exclusion
				if($this->user_data['exclude_time'] && $this->user_data['exclude_time'] != 1 && $this->user_data['exclude_time'] < time())
				{
					$update_ary['exclude_time'] = 0;
				}
				
				if(sizeof($update_ary))
				{
					$sql = 'UPDATE ' . CHAT_USERS_TABLE . '
						SET ' . $this->db->sql_build_array('UPDATE', $update_ary) . '
						WHERE user_key = ' . $this->user_key;
					$this->db->sql_query($sql);
					
					$this->user_data = array_merge($this->user_data, $update_ary);
				}
				
				// Cron work
				$day_limit	= time() - 86400; // yesterday (One day)
				
				if($day_limit > (int)$this->config['chat_cron_lock'])
				{
					// Delete inactive guests (one day of inactivity) or same session of the current user
					$sql = 'DELETE FROM ' . CHAT_USERS_TABLE . '
						WHERE user_id = ' . ANONYMOUS . '
						AND (user_lastjoin < ' . $day_limit . "
						OR user_ip = '" . $this->user_data['user_ip'] . "')
						AND user_key <> " . $this->user_data['user_key'] . '
						AND exclude_time = 0';
					$this->db->sql_query($sql);
					
					// Delete messages out of store time
					if($this->config['chat_store_time'])
					{
						$sql = 'DELETE FROM ' . CHAT_MESSAGES_TABLE . '
							WHERE message_time < ' . (time() - (int)$this->config['chat_store_time']);
						$this->db->sql_query($sql);
					}

					set_config('chat_cron_lock', time());
				}
				
				if($action == 'connect_on_post')
				{
					return true;
				}

			// no break;
			
			case 'refresh':
			case 'refresh_after_post':
			case 'refresh_after_status':
				$row_users = $row_data = $user_cache = array();
				$max_time = $last_update;

				$bbcode_bitfield = '';

				// Get the user session if no exists
				$this->get_current_user(true);

				// Disconnect the user if it exceeds the inactivity limit
				if(!$this->user_data || ($this->chat->time_limit !== false && $action == 'refresh' && $this->user_data['user_lastjoin'] < $this->chat->time_limit))
				{
					$this->run('disconnect_on_refresh');
					$json['action'] = 'disconnect';
					break;
				}
				
				// If user is excluded, disconnect it here
				if($this->user_data['exclude_time'] && ($this->user_data['exclude_time'] == 1 || $this->user_data['exclude_time'] > $this->user->time_now))
				{
					$json = array_merge($json, array(
						'action'	=> 'exclude',
						'message'	=> ($this->user_data['exclude_time'] == 1) ? $this->user->lang['CHAT_USER_BANNED_PERMANENT'] : $this->user->lang('CHAT_USER_BANNED_PERIOD', $this->user->format_date($this->user_data['exclude_time'])),
					));
					break;
				}

				// Delete inactive users
				if($this->chat->time_limit !== false && ($action == 'connect' || $action == 'refresh'))
				{
					$sql = 'UPDATE ' . CHAT_USERS_TABLE . '
						SET user_online = 0
						WHERE user_lastjoin < ' . $this->chat->time_limit . '
						AND user_key <> ' . $this->user_key;
					$result = $this->db->sql_query($sql);
				}
				
				// Get connected users
				$auto_away_changed = false;

				$sql = 'SELECT *
					FROM ' . CHAT_USERS_TABLE . '
					WHERE user_online = 1';
				$result = $this->db->sql_query($sql);
				while($row = $this->db->sql_fetchrow($result))
				{
					// Change user status to "away" if "auto away" function is enabled
					if($row['user_key'] == $this->user_key)
					{
						if($action == 'refresh' && $this->user_data['user_status'] == CHAT_STATUS_AVAILABLE && $this->config['chat_auto_away'] && $this->user_data['user_lastjoin'] < (time() - (intval($this->config['chat_auto_away']) * 60)))
						{
							$row['user_status'] = $this->user_data['user_status'] = CHAT_STATUS_AWAY;
							$auto_away_changed = true;
							
							$json['auto_away'] = 1;
						}
					}
					
					$row_users[$row['user_key']] 	= $row;
					$user_cache[$row['user_key']] 	= $row['user_key'];
				}
				$this->db->sql_freeresult($result);
				
				if($auto_away_changed)
				{
					$sql = 'UPDATE ' . CHAT_USERS_TABLE . '
						SET user_status = ' . CHAT_STATUS_AWAY . '
						WHERE user_key = ' . $this->user_key;
					$this->db->sql_query($sql);
				}
				
				// Get new messages and rooms
				
				// Load "public" rooms
				$this->room_ary = $this->chat->obtain_rooms();

				foreach($this->room_ary as $room_key => $row)
				{
					if($room_key != CHAT_GUEST_ROOM &&
						((!in_array($this->user->data['group_id'], $row['room_data']['groups']) && !isset($row['room_data']['users'][$this->user->data['user_id']]))
						|| !$row['room_enabled']))
					{
						continue;
					}
					
					$row_data[$room_key] = array();
				}

				// Always set the guest room
				if(!isset($row_data[CHAT_GUEST_ROOM]))
				{
					$this->room_ary[CHAT_GUEST_ROOM] = array(
						'title'		=> 'CHAT_GUEST_ROOM',
					);

					$row_data = array_merge(array(CHAT_GUEST_ROOM => array()), $row_data);
				}

				// Load "private" rooms
				if($this->config['chat_allow_pm'])
				{
					$sql = 'SELECT DISTINCT dest_key, poster_key
						FROM ' . CHAT_MESSAGES_TABLE . "
						WHERE message_time > $last_update
						AND (dest_key = " . $this->user_key . '
							OR (poster_key = ' . $this->user_key . ' AND dest_key <> ' . CHAT_GUEST_ROOM . '))
						ORDER BY dest_key ASC';
					$result = $this->db->sql_query($sql);
					while($row = $this->db->sql_fetchrow($result))
					{
						$key = ($row['poster_key'] != $this->user_key) ? $row['poster_key'] : $row['dest_key'];

						if(isset($row_users[$key]) && empty($row_users[$key]['exclude_time']))
						{
							$row_data[$key] = array();
						}
					}
					$this->db->sql_freeresult($result);
				}
				
				// Force to refresh the userlist of all open rooms
				$open_rooms = $this->request->variable('rooms', array(0));
				
				foreach($open_rooms as $room_key)
				{
					if(!isset($row_data[$room_key]))
					{
						$row_data[$room_key] = array();
					}
				}

				// Get messages for each room
				foreach($row_data as $dest_key => $null)
				{
					if(isset($this->room_ary[$dest_key]))
					{
						// is a room
						$sql_where = "dest_key = $dest_key";
					}
					else
					{
						// is a user
						$sql_where = '((dest_key = ' . $dest_key . ' AND poster_key = ' . $this->user_key . ')
							OR (poster_key = ' . $dest_key . ' AND dest_key = ' . $this->user_key . '))';
					}

					$sql = 'SELECT *
						FROM ' . CHAT_MESSAGES_TABLE . "
						WHERE $sql_where
						AND message_time > $last_update
						ORDER BY message_time DESC";
					$result = $this->db->sql_query_limit($sql, $this->config['chat_max_rows']);
					while($row = $this->db->sql_fetchrow($result))
					{
						$message_row_key = $row['message_time'] . '-' . $row['message_id'];
						
						if($row['poster_key'] != $this->user_key && !isset($this->room_ary[$dest_key]))
						{
							$row_data[$row['poster_key']][$message_row_key] = $row;
						}
						else
						{
							$row_data[$dest_key][$message_row_key] = $row;
						}
						
						$user_cache[$row['poster_key']] = $row['poster_key'];
						
						if(!isset($this->room_ary[$dest_key]))
						{
							$user_cache[$dest_key] = $dest_key;
						}
						
						// Define the global bbcode bitfield, will be used to load bbcodes
						$bbcode_bitfield = $bbcode_bitfield | base64_decode($row['bbcode_bitfield']);
						
						$max_time = max($max_time, $row['message_time']);
					}
					$this->db->sql_freeresult($result);
				}
				
				// Get the new topics of forums if allowed
				if($this->config['chat_show_topics'])
				{
					$sql = 'SELECT topic_id, forum_id, topic_title, topic_time, topic_visibility, topic_first_post_id,
						topic_poster AS poster_id, topic_first_poster_name AS poster_username
						FROM ' . TOPICS_TABLE . "
						WHERE topic_time > $last_update
						ORDER BY topic_time DESC";
					$result = $this->db->sql_query_limit($sql, $this->config['chat_max_rows']);
					while($row = $this->db->sql_fetchrow($result))
					{
						$row_time = $row['topic_time'];
						
						if(($this->auth->acl_get('m_approve', $row['forum_id']) || $row['topic_visibility'] == ITEM_APPROVED) && $this->auth->acl_get('f_read', $row['forum_id']))
						{
							if(isset($row_data[CHAT_GUEST_ROOM][$row_time]))
							{
								$row_time = $row_time . '-' . $row['topic_id'];
							}
							
							$row_data[CHAT_GUEST_ROOM][$row_time] = $row;
							$user_cache[$row['poster_id']] = $row['poster_id'];
							
							$max_time = max($max_time, $row['topic_time']);
						}
					}
					$this->db->sql_freeresult($result);
					
					krsort($row_data[CHAT_GUEST_ROOM]);
					
					if(sizeof($row_data[CHAT_GUEST_ROOM]) > $this->config['chat_max_rows'])
					{
						$row_data[CHAT_GUEST_ROOM] = array_slice($row_data[CHAT_GUEST_ROOM], 0, $this->config['chat_max_rows'], true);
					}
				}

				// Get the users data
				if(!empty($user_cache))
				{
					$sql = 'SELECT user_id, group_id, user_type, username, user_colour,
						user_avatar, user_avatar_type, user_avatar_width, user_avatar_height
						FROM ' . USERS_TABLE . '
						WHERE (user_id = ' . ANONYMOUS . '
							OR ' . $this->db->sql_in_set('user_id', array_keys($user_cache)) . ')';
					$result = $this->db->sql_query($sql);
					while($row = $this->db->sql_fetchrow($result))
					{
						$user_cache[$row['user_id']] = $row;
					}
					$this->db->sql_freeresult($result);
				}
				
				if($this->config['chat_show_avatars'] && !function_exists('get_user_avatar'))
				{
					include($this->root_path . 'includes/functions_display.' . $this->php_ext);
				}
				
				// Instantiate BBCode if needed
				if($bbcode_bitfield !== '')
				{
					if(!class_exists('bbcode', false))
					{
						include($this->root_path . 'includes/bbcode.' . $this->php_ext);
					}

					$bbcode = new \bbcode(base64_encode($bbcode_bitfield));
				}

				// Update the values in javascript
				$json = array_merge($json, array(
					'action'		=> 'update',
					'last_time'		=> $max_time,
					'msg_direction'	=> $this->config['chat_direction'],
					'flood_time'	=> ($this->config['chat_flood_time'] && !$this->auth->acl_get('u_chat_ignoreflood')) ? $this->config['chat_flood_time'] * 1000 : 0,
				));
				
				// Compose
				foreach($row_data as $room_key => $room_data)
				{
					$is_public_room = (isset($this->room_ary[$room_key]) ? true : false);

					if(!$is_public_room && $row_users[$room_key]['user_id'] == ANONYMOUS)
					{
						$user_cache[$room_key] = $row_users[$room_key];
					}

					// Room info
					if($is_public_room)
					{
						$room_title = $this->room_ary[$room_key]['room_title'];
						$room_title = (isset($this->user->lang[$room_title]) ? $this->user->lang[$room_title] : $room_title);
					}
					else
					{
						$room_title = $user_cache[$room_key]['username'];
					}

					$this->template->assign_block_vars('room', array(
						'ID'		=> $room_key,
						'S_TITLE'	=> $room_title,
						'S_CLASS'	=> 'room' . (($is_public_room) ? ' js-public-room' : ''),
					));
					
					if($this->config['chat_direction'] != 'up')
					{
						ksort($room_data);
					}
					
					// Messages
					foreach($room_data as $null => $row)
					{
						$row_avatar = '';
						
						if(isset($row['topic_id']))
						{
							if(is_array($user_cache[$row['poster_id']]))
							{
								$row += $user_cache[$row['poster_id']];
							}
							
							$edit_allowed = ($this->user->data['is_registered'] && ($this->auth->acl_get('m_edit', $row['forum_id']) || (
								$this->user->data['user_id'] == $row['poster_id'] &&
								$this->auth->acl_get('f_edit', $row['forum_id']) &&
								($row['topic_time'] > time() - ($this->config['edit_time'] * 60) || !$this->config['edit_time'])
							)));
							
							$row['poster_key'] = $row['poster_id'];
						}
						else
						{
							if(is_array($user_cache[$row['poster_key']]))
							{
								$row += $user_cache[$row['poster_key']];
							}
		
							// Parse the message and subject
							$message = censor_text($row['message_text']);
							
							// Second parse bbcode here
							if($row['bbcode_bitfield'])
							{
								$bbcode->bbcode_second_pass($message, $row['bbcode_uid'], $row['bbcode_bitfield']);
							}

							$message = bbcode_nl2br($message);
							$message = smiley_text($message);
						}
						
						if($this->config['chat_show_avatars'])
						{
							if($row['poster_id'] != ANONYMOUS)
							{
								$row_avatar = get_user_avatar($row['user_avatar'], $row['user_avatar_type'], $row['user_avatar_width'], $row['user_avatar_height']);

								// Fix path error occurs in some cases
								if($row_avatar && $this->chat->web_path != $this->root_path && $row['user_avatar_type'] != 'avatar.driver.gravatar')
								{
									$row_avatar = preg_replace('#src\="(\.|\/)+#', 'src="' . $this->chat->web_path, $row_avatar);
								}
							}
							
							if(!$row_avatar)
							{
								$row_avatar = '<img src="' . $this->chat->web_path . $this->chat->path . 'images/no-avatar.gif" />';
							}
						}

						$ary = array(
							'S_AUTHOR_AVATAR'	=> $row_avatar,
							'S_AUTHOR_FULL'		=> ($row['poster_id'] == ANONYMOUS) ? $row['poster_username'] : get_username_string('full', $row['poster_key'], $row['username'], $row['user_colour']),
						);

						if(isset($row['topic_id']))
						{
							$ary += array(
								'IS_TOPIC'			=> true,
								'TOPIC_TITLE'		=> censor_text($row['topic_title']),
								'S_DATE'			=> $this->user->format_date($row['topic_time']),
								
								'U_TOPIC'			=> append_sid($this->root_path . 'viewtopic.' . $this->php_ext . '?f=' . $row['forum_id'] . '&amp;t=' . $row['topic_id']),
								'U_TOPIC_EDIT'		=> ($edit_allowed) ? append_sid($this->root_path . 'posting.' . $this->php_ext, 'mode=edit&amp;f=' . $row['forum_id'] . '&amp;p=' . $row['topic_first_post_id']) : '',
							);
						}
						else
						{
							$ary += array(
								'S_ID'				=> $row['message_id'],

								'S_TEXT'			=> $message,
								'S_DATE'			=> $this->user->format_date($row['message_time']),
								
								'CAN_DELETE'		=> $this->auth('delete', $row),
								'CAN_EDIT'			=> $this->auth('edit', $row),
								'CAN_QUOTE'			=> (!in_array('quote', $this->chat->disallowed_bbcodes) && $this->auth('post')) ? true : false,
								'CAN_VIEW_WHOIS'	=> $this->auth('-a_'),
							);
						}
							
						$this->template->assign_block_vars('room.message', $ary);
					}
					
					// Users
					$this->generate_userlist($row_users, $user_cache, $room_key);
				}
			break;
			
			case 'clear':
				if($this->auth('-m_chat_delete'))
				{
					// Load "public" rooms
					$this->room_ary = $this->chat->obtain_rooms();
					
					$room_key = $this->request->variable('room', CHAT_GUEST_ROOM);
					
					if(isset($this->room_ary[$room_key]))
					{
						if($submit)
						{
							$sql = 'DELETE FROM ' . CHAT_MESSAGES_TABLE . '
								WHERE dest_key = ' . $room_key;
							$this->db->sql_query($sql);
							
							break;
						}
						
						$room_title = $this->room_ary[$room_key]['room_title'];
						$room_title = (isset($this->user->lang[$room_title]) ? $this->user->lang[$room_title] : $room_title);
						
						$this->template->assign_vars(array(
							'S_CONFIRM_DIALOG'	=> true,
							'S_TITLE'			=> $this->user->lang['CONFIRM'],
							'S_DIALOG_CONTENT'	=> $this->user->lang('CHAT_PURGE_CONFIRM', $room_title),
						));
					}
				}
			break;
			
			case 'delete':
				$sql = 'SELECT poster_key
					FROM ' . CHAT_MESSAGES_TABLE . "
					WHERE message_id = $message_id";
				$result = $this->db->sql_query($sql);
				$row = $this->db->sql_fetchrow($result);
				$this->db->sql_freeresult($result);
				
				if(!$row)
				{
					break;
				}
				
				if($this->get_current_user() && $this->auth('delete', $row))
				{
					$sql = 'DELETE FROM ' . CHAT_MESSAGES_TABLE . '
						WHERE message_id = ' . $message_id;
					$this->db->sql_query($sql);
				}
			break;
			
			case 'edit':
				$sql = 'SELECT poster_key, message_text, bbcode_uid
					FROM ' . CHAT_MESSAGES_TABLE . "
					WHERE message_id = $message_id";
				$result = $this->db->sql_query($sql);
				$row = $this->db->sql_fetchrow($result);
				$this->db->sql_freeresult($result);
				
				if(!$row)
				{
					break;
				}

				if($this->get_current_user() && $this->auth('edit', $row))
				{
					if($submit)
					{
						// Parse and insert the new message
						$message = utf8_normalize_nfc($this->request->variable('ic_edit_message', '', true));

						// BBcode control
						$this->strip_bbcode($message);
						
						if($message)
						{
							$uid = $bitfield = $options = '';
							$this->generate_text_for_storage($message, $uid, $bitfield, $options, $allow_bbcode, $allow_urls, $allow_smilies);
							
							$sql_ary = array(
								'message_text'		=> $message,
								'bbcode_bitfield'	=> $bitfield,
								'bbcode_uid'		=> $uid,
							);
							
							$sql = 'UPDATE ' . CHAT_MESSAGES_TABLE . '
								SET ' . $this->db->sql_build_array('UPDATE', $sql_ary) . '
								WHERE message_id = ' . $message_id;
							$this->db->sql_query($sql);

							$this->template->assign_var('CUSTOM_PRINT', generate_text_for_display($message, $uid, $bitfield, $options));
						}

						break;
					}

					decode_message($row['message_text'], $row['bbcode_uid']);

					$this->template->assign_vars(array(
						'S_EDIT'			=> true,
						'S_CHAT_MAX_CHARS'	=> $this->config['chat_max_chars'],
						
						'S_MESSAGE'	=> $row['message_text'],
						'S_TITLE'	=> $this->user->lang['EDIT'],
					));
				}
			break;
			
			case 'post':
				if(!$this->get_current_user())
				{
					$this->run('connect_on_post');
				}

				$message 		= utf8_normalize_nfc($this->request->variable('ic_message', '', true));
				$room_key		= $this->request->variable('room', CHAT_GUEST_ROOM);
				$last_post_time = $this->request->variable('last_post_time', 0);

				if(!$this->user_data || !$this->auth('post') || !$message || !empty($this->user_data['exclude_time']) || ($room_key != CHAT_GUEST_ROOM && !$this->config['chat_allow_pm']))
				{
					break;
				}
				
				// If room is disabled, no post and close the room
				$room_ary = $this->chat->obtain_rooms();
				
				if(isset($room_ary[$room_key]) && !$room_ary[$room_key]['room_enabled'])
				{
					$json = array(
						'action'	=> 'close_room',
						'room_key'	=> $room_key,
						'success'	=> true,
					);

					break;
				}

				// Flood control
				if($this->config['chat_flood_time'] && !$this->auth('ignoreflood') && $this->user_data['session_start'] != $this->user_data['user_lastjoin'])
				{
					if(($last_post_time + $this->config['chat_flood_time']) >= time())
					{
						break;
					}
				}

				// BBcode control
				$this->strip_bbcode($message);

				if($message)
				{
					$uid = $bitfield = $options = '';
					$this->generate_text_for_storage($message, $uid, $bitfield, $options, $allow_bbcode, $allow_urls, $allow_smilies);

					$sql_ary = array(
						'poster_key'		=> $this->user_data['user_key'],
						'dest_key'			=> $room_key,
						'poster_id'			=> $this->user_data['user_id'],
						'poster_ip'			=> $this->user_data['user_ip'],
						'poster_username'	=> $this->user_data['username'],
						'message_text'		=> $message,
						'message_time'		=> time(),
						'bbcode_bitfield'	=> $bitfield,
						'bbcode_uid'		=> $uid,
					);

					$sql = 'INSERT INTO ' . CHAT_MESSAGES_TABLE . ' ' . $this->db->sql_build_array('INSERT', $sql_ary);
					$this->db->sql_query($sql);

					// Update the user activity
					$sql_ary = array(
						'user_lastjoin'	=> $sql_ary['message_time'],
						'user_online'	=> 1
					);
					
					if(request_var('auto_away', false))
					{
						$sql_ary['user_status'] = CHAT_STATUS_AVAILABLE;
					}
					
					$sql = 'UPDATE ' . CHAT_USERS_TABLE . '
						SET ' . $this->db->sql_build_array('UPDATE', $sql_ary) . '
						WHERE user_key = ' . $this->user_key;
					$this->db->sql_query($sql);

					// Refresh the chat 
					return $this->run('refresh_after_post');
				}
			break;
			
			case 'quote':
				if($this->auth('post') && $this->config['chat_allow_bbcode'] && !in_array('quote', $this->chat->disallowed_bbcodes))
				{
					$sql = 'SELECT m.poster_username, m.message_text, m.bbcode_uid, u.username
						FROM ' . CHAT_MESSAGES_TABLE . ' m
							LEFT JOIN ' . USERS_TABLE . ' u ON(u.user_id = m.poster_id AND u.user_type <> ' . USER_IGNORE . ')
						WHERE m.message_id = ' . $message_id;
					$result = $this->db->sql_query($sql);
					$row = $this->db->sql_fetchrow($result);
					$this->db->sql_freeresult($result);
					
					if($row)
					{
						decode_message($row['message_text'], $row['bbcode_uid']);

						$new_text = '[quote=&quot;' . (($row['poster_username']) ? $row['poster_username'] : $row['username']) . '&quot;] ' . $row['message_text'] . ' [/quote]';
						$this->template->assign_var('CUSTOM_PRINT', htmlspecialchars_decode($new_text));
					}
				}
			break;
			
			case 'rules':
				$rules = $this->chat->obtain_texts(CHAT_TEXT_RULE);

				foreach($rules as $rule_text)
				{
					$this->template->assign_block_vars('rulerow', array(
						'S_TEXT'	=> $rule_text,
					));
				}

				$this->template->assign_vars(array(
					'S_RULES'	=> true,
					'S_TITLE'	=> $this->user->lang['CHAT_RULES'],
				));
			break;
			
			case 'whois':
				if($this->auth('-u_viewprofile'))
				{
					$sql = 'SELECT poster_ip
						FROM ' . CHAT_MESSAGES_TABLE . '
						WHERE message_id = ' . $message_id;
					$result = $this->db->sql_query($sql);
					$poster_ip = (string)$this->db->sql_fetchfield('poster_ip');
					$this->db->sql_freeresult($result);

					if($poster_ip)
					{
						if(!function_exists('user_ipwhois'))
						{
							include($this->root_path . 'includes/functions_user.' . $this->php_ext);
						}

						$ipwhois = explode("\n", user_ipwhois($poster_ip));
						
						foreach($ipwhois as $line_id => $line)
						{
							$line = trim($line);
							
							if($line && $line[0] == '#')
							{
								unset($ipwhois[$line_id]);
							}
						}

						$this->template->assign_vars(array(
							'S_DIALOG_CONTENT'	=> (sizeof($ipwhois) ? preg_replace('#(^(<br />)*|<br />$)#', '', implode('<br />', $ipwhois)) : $this->user->lang['CHAT_NO_INFORMATION']),
							'S_TITLE'			=> $this->user->lang['WHOIS'],
						));
					}
				}
			break;
			
			case 'banuser':
			case 'unbanuser':
				if(!$this->get_current_user())
				{
					break;
				}

				if($submit || $action == 'unbanuser')
				{
					$user_key 		= $this->request->variable('uk', 0);
					$period_time	= $this->request->variable('period', 0);
					$period_date	= $this->request->variable('date', '');
					$exclude_time	= 0;
					$row_users 		= array();

					$sql = 'SELECT cu.*, u.username AS member_name, u.user_type, u.user_colour
						FROM ' . CHAT_USERS_TABLE . ' cu
							LEFT JOIN ' . USERS_TABLE . " u ON(u.user_id = cu.user_id)
						WHERE cu.user_key = $user_key";
					$result = $this->db->sql_query($sql);
					$user_data = $this->db->sql_fetchrow($result);
					$this->db->sql_freeresult($result);

					if(!$user_data)
					{
						break;
					}

					if($action == 'banuser')
					{
						switch($period_time)
						{
							case 0:
								if(preg_match('#^(\w{2})\/(\w{2})\/(\d{4}) (\w{2})\:(\w{2})\:(\w{2})#', $period_date, $match))
								{
									if(($exclude_time = @strtotime(vsprintf('%4$s:%3$s:%2$s %5$s:%6$s:%7$s', $match))) <= time())
									{
										$exclude_time = 0;
									}
								}
							break;

							case 1:
								$exclude_time = 1;
							break;

							default:
								$exclude_time = time() + $period_time;
							break;
						}
						
						if(!$user_key || !$exclude_time || $user_key == $this->user_key)
						{
							break;
						}
					}

					$sql = 'UPDATE ' . CHAT_USERS_TABLE . "
						SET exclude_time = $exclude_time
						WHERE user_key = $user_key";
					$result = $this->db->sql_query($sql);

					if($this->db->sql_affectedrows($result))
					{
						$user_data['exclude_time'] = $exclude_time;

						if($user_data['user_id'] != ANONYMOUS)
						{
							$user_data['username'] = $user_data['member_name'];
						}

						$row_users[$user_data['user_key']] = $user_data;

						$this->template->assign_block_vars('room', array(
							'ID'		=> 'temp_room',
							'S_TITLE'	=> 'temp',
							'S_CLASS'	=> 'room',
						));

						$this->generate_userlist($row_users);

						$json = array_merge($json, array(
							'action'	=> $action,
							'user_key'	=> $user_key
						));
					}
					break;
				}
				
				if($action == 'banuser')
				{
					$option_ary = array(
						1			=> 'PERMANENT',
						1800		=> 'HALF_AN_HOUR',
						3600		=> 'ONE_HOUR',
						86400		=> 'ONE_DAY',
						604800		=> 'ONE_WEEK',
						2592000		=> 'ONE_MONTH',
						31104000	=> 'ONE_YEAR',
						0			=> 'CUSTOM_DATE',
					);

					$option_str = '';

					foreach($option_ary as $value => $title)
					{
						$option_str .= '<option value="' . $value . '">' . $this->user->lang($title) . '</option>';
					}

					$this->template->assign_vars(array(
						'S_BAN'				=> true,
						'S_PERIOD_OPTIONS'	=> $option_str,
						'S_TITLE'			=> $this->user->lang['CHAT_BAN_USER'],
					));
				}
			break;
			
			case 'pmuser':
				if(!$this->get_current_user())
				{
					break;
				}

				if($this->config['chat_max_pm'])
				{
					$open_rooms 		= $this->request->variable('rooms', array(0));
					$public_room_ary	= $this->chat->obtain_rooms();
					$pm_count 			= 0;
					
					foreach($open_rooms as $room_key)
					{
						if(!isset($public_room_ary[$room_key]))
						{
							$pm_count++;
						}
					}

					if($pm_count >= $this->config['chat_max_pm'])
					{
						$this->template->assign_vars(array(
							'S_DIALOG_CONTENT'	=> $this->user->lang['CHAT_PM_EXCEED'],
							'S_TITLE'			=> $this->user->lang['INFORMATION'],
						));
						
						$json['dialog'] = true;
						break;
					}
				}
				
				$row_users	= array();
				$user_key	= $this->request->variable('uk', 0);
				
				$sql = 'SELECT cu.*, u.username AS member_name, u.user_type, u.user_colour
					FROM ' . CHAT_USERS_TABLE . ' cu
						LEFT JOIN ' . USERS_TABLE . ' u ON(u.user_id = cu.user_id AND u.user_id <> ' . ANONYMOUS . ')
					WHERE ' . $this->db->sql_in_set('cu.user_key', array($user_key, $this->user_key));
				$result = $this->db->sql_query($sql);
				while($row = $this->db->sql_fetchrow($result))
				{
					if($row['user_id'] != ANONYMOUS)
					{
						$row['username'] = $row['member_name'];
					}
					
					$row_users[$row['user_key']] = $row;
				}
				$this->db->sql_freeresult($result);
				
				$this->template->assign_block_vars('room', array(
					'ID'		=> $user_key,
					'S_TITLE'	=> $row_users[$user_key]['username'],
					'S_CLASS'	=> 'room',
				));
				
				// Users
				$this->generate_userlist($row_users);
			break;
			
			case 'set_available':
			case 'set_away':
			case 'set_busy':
			case 'set_hidden':
				$user_key = $this->request->variable('uk', 0);

				if(!$this->get_current_user() || $user_key != $this->user_key)
				{
					break;
				}
				
				$status_id = array_search(str_replace('set_', '', $action), $this->status_ary);
				
				$sql = 'UPDATE ' . CHAT_USERS_TABLE . '
					SET user_status = ' . (($status_id === false) ? CHAT_STATUS_AVAILABLE : $status_id) . '
					WHERE user_key = ' . $user_key;
				$this->db->sql_query($sql);
				
				// Refresh the chat 
				return $this->run('refresh_after_status');
			break;
			
			case 'close_room':
				$room_key = $this->request->variable('rk', 0);
				
				if(!$this->get_current_user())
				{
					$json['success'] = false;
					break;
				}
				
				// Delete room messages
				$sql = 'DELETE FROM ' . CHAT_MESSAGES_TABLE . '
					WHERE ((poster_key = ' . $this->user_key . ' AND dest_key = ' . $room_key . ')
					OR (poster_key = ' . $room_key . ' AND dest_key = ' . $this->user_key . '))';
				$this->db->sql_query($sql);
			break;
		}

		$this->template->assign_var('S_JSON', json_encode($json));
		
		if((in_array($action, array('login', 'edit', 'rules', 'whois', 'banuser')) || !empty($json['dialog'])) && !$submit)
		{
			$this->template->assign_var('S_DIALOG', true);
		}
		
		if (!defined('HEADER_INC'))
		{
			$http_headers = array(
				'Content-type' 	=> 'text/html; charset=UTF-8',
				'Cache-Control' => 'private, no-cache="set-cookie"',
				'Expires' 		=> gmdate('D, d M Y H:i:s', time()) . ' GMT',
			);

			if(!empty($user->data['is_bot']))
			{
				// Let reverse proxies know we detected a bot.
				$http_headers['X-PHPBB-IS-BOT'] = 'yes';
			}

			foreach($http_headers as $hname => $hval)
			{
				header((string) $hname . ': ' . (string) $hval);
			}
		}

		$this->template->set_filenames(array(
			'chat' => 'chat_ajax.html'
		));

		$this->template->set_style(array('ext/canidev/chat/styles'));
		$this->template->display('chat');
		
		garbage_collection();
		exit_handler();
	}
	
	private function generate_userlist($row_users, $user_cache = false, $room_key = false)
	{
		$rows = array();

		foreach($row_users as $user_key => $row)
		{
			$row_actions = array();
			
			// If private room, only show the two users of the conversation
			if($room_key !== false && !isset($this->room_ary[$room_key]) && !in_array($user_key, array($room_key, $this->user_key)))
			{
				continue;
			}
			
			if(!$this->auth('-m_ban') && $row['exclude_time'])
			{
				continue;
			}
			
			// Excluded users always show as "hidden" users
			if($row['exclude_time'])
			{
				$row['user_status'] = CHAT_STATUS_HIDDEN;
			}

			if($user_cache !== false && isset($user_cache[$row['user_id']]))
			{
				if($row['user_id'] == ANONYMOUS)
				{
					unset($user_cache[$row['user_id']]['username']);
				}
				
				$row = array_merge($row, $user_cache[$row['user_id']]);
			}
			
			// If is public room, only show the users can see the room
			if($room_key != CHAT_GUEST_ROOM && isset($row['group_id']) && isset($this->room_ary[$room_key]) &&
				(!in_array($row['group_id'], $this->room_ary[$room_key]['room_data']['groups']) && !isset($this->room_ary[$room_key]['room_data']['users'][$row['user_id']])))
			{
				continue;
			}
			
			if($row['user_id'] != ANONYMOUS && (!$row['session_viewonline'] || $row['user_status'] == CHAT_STATUS_HIDDEN))
			{
				if(!$this->auth('-u_viewonline') && $user_key != $this->user_key && !in_array($user_key, array($room_key, $this->user_key)))
				{
					continue;
				}
				
				$row['username'] = '<em>' . $row['username'] . '</em>';
			}

			if($user_key != $this->user_key)
			{
				foreach($this->actions as $user_action => $action_data)
				{
					$u_action 	= '';
					$u_data		= $user_action . '/' . $user_key;
					
					if(isset($action_data['check']) && empty($this->config[$action_data['check']]))
					{
						continue;
					}
					
					if($this->auth('-' . $action_data['auth']))
					{
						$founder_case 	= false;
						$valid 			= true;
						
						if(!empty($row['user_type']) && $row['user_type'] == USER_FOUNDER && $this->user->data['user_type'] != USER_FOUNDER)
						{
							$founder_case = true;
						}

						switch($user_action)
						{
							case 'banuser':
								if($founder_case)
								{
									$valid = false;
									break;
								}

							// no break

							case 'pmuser':
								if($row['exclude_time'])
								{
									$valid = false;
								}
							break;
							
							case 'deluser':
								if($row['user_id'] == ANONYMOUS || $founder_case)
								{
									$valid = false;
									break;
								}

								$u_action 	= append_sid($this->root_path . 'adm/index.' . $this->php_ext, 'i=users&amp;mode=overview&amp;u=' . $row['user_id'], true, $this->user->session_id);
								$u_data		= '';
							break;
							
							case 'unbanuser':
								if(!$row['exclude_time'])
								{
									$valid = false;
								}
							break;
						}
						
						if($valid)
						{
							$row_actions[] = array(
								'S_ACTION'	=> $user_action,
								'S_TITLE'	=> $this->user->lang[$action_data['lang']],
								'U_ACTION'	=> $u_action . (($u_data) ? '#!' . $u_data : ''),
							);
						}
					}
				}
			}
			else
			{
				foreach($this->status_ary as $status_id => $action)
				{
					if($status_id == CHAT_STATUS_HIDDEN && !$this->auth('-u_hideonline'))
					{
						continue;
					}

					$title = $this->user->lang['CHAT_STATUS_' . strtoupper($action)];
					
					if($row['user_status'] == $status_id)
					{
						$title = '<strong>' . $title . '</strong>';
					}
					
					$img = '<img src="' . $this->chat->web_path . $this->chat->path . 'images/status_' . $action . '.png" alt="' . $action . '" />';

					$row_actions[] = array(
						'S_ACTION'		=> 'set_' . $action,
						'IS_STATUS'		=> true,
						'S_IMG'			=> $img,
						'S_TITLE'		=> $img . ' ' . $title,
						'U_ACTION'		=> '#!set_' . $action . '/' . $user_key,
					);
				}
			}
			
			$user_status = $this->status_ary[$row['user_status']];
			
			$rows[strtolower($row['username'])] = array(
				'S_KEY'			=> $user_key,
				'S_IMG'			=> '<img src="' . $this->chat->web_path . $this->chat->path . 'images/status_' . $user_status . '.png" alt="' . $user_status . '" />',
				'S_USERNAME'	=> ($row['user_id'] == ANONYMOUS || $row['exclude_time']) ? $row['username'] : get_username_string('no_profile', $row['user_id'], $row['username'], $row['user_colour'], $row['username']),
				'IS_EXCLUDED'	=> ($row['exclude_time']) ? true : false,
				'U_ACTION'		=> ($row['user_id'] == ANONYMOUS) ? '#!user' : get_username_string('profile', $row['user_id'], $row['username'], $row['user_colour'], $row['username']) . '#!user/' . $row['user_id'],
				
				'S_HAS_SUBMENU'		=> (sizeof($row_actions) ? true : false),
				'contextmenu'		=> $row_actions,
			);
		}
		
		if(sizeof($rows))
		{
			ksort($rows);
			
			foreach($rows as $username => $row)
			{
				$this->template->assign_block_vars('room.user', $row);
			}
		}
	}
	
	private function get_current_user($only_online = false)
	{
		if(empty($this->user_data))
		{
			$sql = 'SELECT *
				FROM ' . CHAT_USERS_TABLE . '
				WHERE (user_id = ' . $this->user->data['user_id'] . '
					AND user_key = ' . $this->user_key . ')';
				
			if($this->user->data['user_id'] == ANONYMOUS)
			{
				$sql .= ' OR (user_id = ' . ANONYMOUS . "
					AND user_ip = '" . $this->user->ip . "')";
			}

			$result = $this->db->sql_query($sql);
			$this->user_data = $this->db->sql_fetchrow($result);
			$this->db->sql_freeresult($result);

			// Check for excluded guest user
			if(!$this->user_data && !$only_online && $this->user->data['user_id'] == ANONYMOUS)
			{
				$sql = 'SELECT *
					FROM ' . CHAT_USERS_TABLE . "
					WHERE exclude_time > 0
					AND (user_ip = '" . $this->user->ip . "'
					OR user_key = " . $this->user_key . ')';
				$result = $this->db->sql_query($sql);
				$this->user_data = $this->db->sql_fetchrow($result);
				$this->db->sql_freeresult($result);
			}
			
			if(!$this->user_data)
			{
				return false;
			}
			
			if($only_online)
			{
				if(!$this->user_data['user_online'] && $this->user->data['session_time'] > $this->user_data['user_lastjoin'])
				{
					$sql = 'UPDATE ' . CHAT_USERS_TABLE . '
						SET user_online = 1, user_lastjoin = ' . time() . '
						WHERE user_key = ' . $this->user_data['user_key'];
					$this->db->sql_query($sql);
					
					$this->user_data['user_online']		= 1;
					$this->user_data['user_lastjoin']	= time();
				}
				
				if(!$this->user_data['user_online'])
				{
					$this->user_data = false;
					return false;
				}
			}
			
			$this->user_key = $this->user_data['user_key'];
		}
		
		return true;
	}
	
	private function strip_bbcode(&$message)
	{
		$bbcode_preg = '';
		
		if(!$this->config['chat_allow_bbcode'])
		{
			$bbcode_preg = '#\[\/?([a-z0-9\*\+\-]+).*?\]#i';
		}
		else if(sizeof($this->chat->disallowed_bbcodes))
		{
			$bbcode_preg = '#\[\/?(' . implode('|', array_map('preg_quote', $this->chat->disallowed_bbcodes)) . ').*?\]#i';
		}
		
		if($bbcode_preg)
		{
			$message = preg_replace($bbcode_preg, '', $message);
		}
	}
	
	private function generate_text_for_storage(&$text, &$uid, &$bitfield, &$flags, $allow_bbcode = false, $allow_urls = false, $allow_smilies = false)
	{
		global $phpbb_root_path, $phpEx, $phpbb_dispatcher;

		/**
		* Use this event to modify the text before it is prepared for storage
		*
		* @event core.modify_text_for_storage_before
		* @var string	text			The text to parse
		* @var string	uid				The BBCode UID
		* @var string	bitfield		The BBCode Bitfield
		* @var int		flags			The BBCode Flags
		* @var bool		allow_bbcode	Whether or not to parse BBCode
		* @var bool		allow_urls		Whether or not to parse URLs
		* @var bool		allow_smilies	Whether or not to parse Smilies
		* @since 3.1.0-a1
		*/
		$vars = array(
			'text',
			'uid',
			'bitfield',
			'flags',
			'allow_bbcode',
			'allow_urls',
			'allow_smilies',
		);
		extract($phpbb_dispatcher->trigger_event('core.modify_text_for_storage_before', compact($vars)));

		$uid = $bitfield = '';
		$flags = (($allow_bbcode) ? OPTION_FLAG_BBCODE : 0) + (($allow_smilies) ? OPTION_FLAG_SMILIES : 0) + (($allow_urls) ? OPTION_FLAG_LINKS : 0);

		if ($text === '')
		{
			return;
		}

		if(!class_exists('parse_message', false))
		{
			include($phpbb_root_path . 'includes/message_parser.' . $phpEx);
		}

		$message_parser = new \parse_message($text);
		$message_parser->parse($allow_bbcode, $allow_urls, $allow_smilies, $allow_bbcode, $allow_bbcode, $allow_bbcode, $allow_urls, true, 'chat');

		$text = $message_parser->message;
		$uid = $message_parser->bbcode_uid;

		// If the bbcode_bitfield is empty, there is no need for the uid to be stored.
		if (!$message_parser->bbcode_bitfield)
		{
			$uid = '';
		}

		$bitfield = $message_parser->bbcode_bitfield;

		/**
		* Use this event to modify the text after it is prepared for storage
		*
		* @event core.modify_text_for_storage_after
		* @var string	text			The text to parse
		* @var string	uid				The BBCode UID
		* @var string	bitfield		The BBCode Bitfield
		* @var int		flags			The BBCode Flags
		* @since 3.1.0-a1
		*/
		$vars = array('text', 'uid', 'bitfield', 'flags');
		extract($phpbb_dispatcher->trigger_event('core.modify_text_for_storage_after', compact($vars)));

		return $message_parser->warn_msg;
	}
}
