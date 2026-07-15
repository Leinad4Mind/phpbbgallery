<?php
/*
* @package cBB Chat
* @version v1.2.1 01/02/2020
*
* @copyright (c) 2020 CaniDev
* @license https://opensource.org/licenses/gpl-license.php GNU Public License
*/

namespace canidev\chat\libraries;

// @ignore
if(!defined('IN_PHPBB'))
{
	exit;
}

class action_manager
{
	private $user_key			= false;
	private $cookie_user_key	= false;
	private $user_data			= false;

	private $actions = array(
		'pmuser'		=> array('lang' => 'CHAT_SEND_PM',		'auth' => 'u_chat_sendpm',	'icon' => 'fa-comment',	'check' => 'chat_allow_pm'),
		'mentionuser'	=> array('lang' => 'CHAT_MENTION',		'auth' => 'u_chat_post',	'icon' => 'fa-user'),
		'banuser'		=> array('lang' => 'CHAT_BAN_USER',		'auth' => 'm_ban',			'icon' => 'fa-eye-slash'),
		'unbanuser'		=> array('lang' => 'CHAT_UNBAN_USER',	'auth' => 'm_ban',			'icon' => 'fa-eye'),
		'deluser'		=> array('lang' => 'CHAT_DELETE_USER',	'auth' => 'a_userdel',		'icon' => 'fa-remove'),
	);
	
	private $status_ary = array(
		CHAT_STATUS_AVAILABLE		=> 'available',
		CHAT_STATUS_AWAY			=> 'away',
		CHAT_STATUS_BUSY			=> 'busy',
		CHAT_STATUS_HIDDEN			=> 'hidden',
	);

	protected $cache;
	protected $chat;
	protected $config;
	protected $container;
	protected $core;
	protected $db;
	protected $dispatcher;
	protected $helper;
	protected $lang;
	protected $log;
	protected $request;
	protected $template;
	protected $user;
	
	protected $root_path;
	protected $php_ext;
	
	/**
	* Constructor
	*
	* @param \phpbb\auth\auth 						$auth			Authentication object
	* @param \phpbb\cache\driver\driver_interface 	$cache 			Cache instance
	* @param \canidev\chat\libraries\chat 			$chat			Chat Object
	* @param \phpbb\config\config 					$config			Config Object
	* @param ContainerInterface 					$container		Service container interface
	* @param \phpbb\db\driver\driver_interface		$db				DB Object
	* @param \phpbb\event\dispatcher_interface		$dispatcher		Event dispatcher
	* @param \phpbb\controller\helper				$helper       	Controller helper object
	* @param \phpbb\language\language 				$language		Language object
	* @param \phpbb\log\log                       	$log			The phpBB log system
	* @param \phpbb\request\request 				$request		Request object
	* @param \phpbb\template\template				$template     	Template object
	* @param \phpbb\user							$user			User object
	* @param string									$root_path		phpBB root path
	* @param string									$php_ext		phpEx
	*
	* @access public
	*/
	public function __construct(
		\phpbb\auth\auth $auth,
		\phpbb\cache\driver\driver_interface $cache,
		\canidev\chat\libraries\chat $chat,
		\phpbb\config\config $config,
		\Symfony\Component\DependencyInjection\ContainerInterface $container,
		\phpbb\db\driver\driver_interface $db,
		\phpbb\event\dispatcher_interface $dispatcher,
		\phpbb\controller\helper $helper,
		\phpbb\language\language $language,
		\phpbb\log\log $log,
		\phpbb\request\request $request,
		\phpbb\template\template $template,
		\phpbb\user $user,
		$root_path,
		$php_ext)
	{
		$this->auth			= $auth;
		$this->cache		= $cache;
		$this->chat 		= $chat;
		$this->config		= $config;
		$this->container 	= $container;
		$this->core			= \canidev\core\lib::get_instance($container);
		$this->db			= $db;
		$this->dispatcher	= $dispatcher;
		$this->helper		= $helper;
		$this->lang			= $language;
		$this->log			= $log;
		$this->request		= $request;
		$this->template		= $template;
		$this->user			= $user;
		
		$this->root_path	= $root_path;
		$this->php_ext		= $php_ext;
		
		$this->user_key = $this->cookie_user_key = $request->variable($config['cookie_name'] . '_chat_key', 0, false, \phpbb\request\request_interface::COOKIE);
		
		@define('PHPBB_USE_BOARD_URL_PATH', true);
	}
	
	public function auth($auth_option, $data = false)
	{
		if($auth_option[0] == '-')
		{
			return $this->auth->acl_get(substr($auth_option, 1, strlen($auth_option)));
		}
	
		if($data === false)
		{
			return $this->auth->acl_gets(array("u_chat_$auth_option", "m_chat_$auth_option"), 0);
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
	
	public function run($force_action = '', $json = false)
	{
		$action			= ($force_action) ? $force_action : $this->request->variable('action', '');
		$action			= (!$this->chat->enabled) ? 'disable' : $action;

		$last_update 	= $this->request->variable('last_update', 0);
		$submit			= $this->request->variable('submit', false);
		
		$allow_bbcode		= ($this->config['allow_bbcode'] && $this->config['chat_allow_bbcode']) ? true : false;
		$allow_smilies		= ($this->config['allow_smilies']) ? true : false;
		$allow_urls			= ($this->config['allow_post_links']) ? true : false;
		$template_filename	= '@canidev_chat/chat_ajax.html';
		
		if($json === false)
		{
			$json = array(
				'action'	=> '',
				'success'	=> true,
			);
		}
		
		if(in_array($action, array('delete', 'edit', 'quote', 'whois', 'move')))
		{
			$message_id = $this->request->variable('id', 0);
		}
		
		// Load "public" rooms
		$this->room_ary = $this->chat->obtain_rooms();

		switch($action)
		{
			case 'disable':
				$json['action'] = 'disable';
			break;

			case 'disconnect':
			case 'disconnect_on_refresh':
				$sql = 'UPDATE ' . CHAT_USERS_TABLE . '
					SET user_online = 0
					WHERE user_id = ' . $this->user->data['user_id'] . '
					AND user_key = ' . $this->user_key;
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
				
				// Delete previous guest sessions from the same user
				if($this->user->data['is_registered'])
				{
					$sql = 'DELETE FROM ' . CHAT_USERS_TABLE . '
						WHERE user_id = ' . ANONYMOUS . '
						AND user_key = ' . $this->cookie_user_key . "
						AND user_ip = '" . $this->user->ip . "'";
					$this->db->sql_query($sql);
				}
				
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
						
						$this->user_key = $this->user->data['user_id'];
					}
					else
					{
						$username 			= utf8_normalize_nfc($this->request->variable('username', '', true));
						$username_register	= utf8_normalize_nfc($this->request->variable('username_register', '', true));
						$password			= utf8_normalize_nfc($this->request->variable('password', '', true));
						
						$this->user_key	= time() - 1001;
						
						// If guests can enter without username, set it
						if($this->config['chat_anonymous_allowed'] && $this->auth('view'))
						{
							$username = $this->lang->lang('CHAT_GUEST', $this->user_key);
						}
						
						// Login dialog
						if(!$username && !$username_register)
						{
							$json['action'] = $action = 'login';
							
							$this->template->assign_vars(array(
								'S_LOGIN'	=> true,
								'S_TITLE'	=> $this->lang->lang('LOGIN'),
								
								'OVERFLOW_CTR'	=> 'style="overflow: auto!important;"',
								
								'ALLOW_GUESTS'	=> $this->auth('view'),
								'U_REGISTER'	=> append_sid($this->root_path . 'ucp.' . $this->php_ext, 'mode=register'),
							));
							
							break;
						}
						
						if($username)
						{
							if(!$this->config['chat_anonymous_allowed'])
							{
								// Check if username already exists
								$sql = 'SELECT u.user_id, uc.user_id, uc.user_ip
									FROM ' . USERS_TABLE . ' u,' . CHAT_USERS_TABLE . " uc
									WHERE u.username_clean = '" . $this->db->sql_escape(utf8_clean_string($username)) . "'
									OR LOWER(uc.username) = '" . $this->db->sql_escape(strtolower($username)) . "'";
								$result = $this->db->sql_query($sql);
								$user_row = $this->db->sql_fetchrow($result);
								$this->db->sql_freeresult($result);
								
								if($user_row && $user_row['user_ip'] != $this->user->ip)
								{
									$submit = false;
									$json['action'] = $action = 'login';
									
									$this->template->assign_vars(array(
										'S_LOGIN'	=> true,
										'S_TITLE'	=> $this->lang->lang('CHAT_USER_ALREADY_EXISTS')
									));
									
									break;
								}
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
										$row_avatar = phpbb_get_user_avatar(array(
											'avatar'		=> $this->user->data['user_avatar'],
											'avatar_type'	=> $this->user->data['user_avatar_type'],
											'avatar_width'	=> $this->user->data['user_avatar_width'], 
											'avatar_height'	=> $this->user->data['user_avatar_height'],
										));
										
										// Fix path error occurs in some cases
										if($row_avatar && strpos($row_avatar, 'src=".') !== false)
										{
											$row_avatar = preg_replace('#src\="(\.|\/)+#', 'src="' . $this->chat->web_path, $row_avatar);
										}
										
										$json['user_avatar'] = $row_avatar;
									}

									$this->user_key = $this->user->data['user_id'];
								break;
								
								case LOGIN_BREAK:
									$err = $this->lang->lang($result['error_msg']);
								break;
								
								case LOGIN_ERROR_ATTEMPTS:
									$redirect = $this->helper->route('canidev_chat_controller');
									$json['redirect'] = append_sid($this->root_path . 'ucp.' . $this->php_ext . '?mode=login&amp;redirect=' . urlencode($redirect));
								
									$err = $this->lang->lang($result['error_msg']);
								break;

								case LOGIN_ERROR_PASSWORD_CONVERT:
									$err = $this->lang->lang($result['error_msg'],
										($this->config['email_enable']) ? '<a href="' . append_sid($this->root_path . 'ucp' . $this->php_ext, 'mode=sendpassword') . '">' : '',
										($this->config['email_enable']) ? '</a>' : '',
										($this->config['board_contact']) ? '<a href="mailto:' . htmlspecialchars($this->config['board_contact']) . '">' : '',
										($this->config['board_contact']) ? '</a>' : ''
									);
								break;

								// Username, password, etc...
								default:
									$err = $this->lang->lang($result['error_msg']);

									// Assign admin contact to some error messages
									if ($result['error_msg'] == 'LOGIN_ERROR_USERNAME' || $result['error_msg'] == 'LOGIN_ERROR_PASSWORD')
									{
										$err = (!$this->config['board_contact']) ? $this->lang->lang($result['error_msg'], '', '') : $this->lang->lang($result['error_msg'], '<a href="mailto:' . htmlspecialchars($this->config['board_contact']) . '">', '</a>');
									}
								break;
							}
							
							if(!empty($err))
							{
								$submit = false;
								$json['action'] = $action = 'login';
								
								$this->template->assign_vars(array(
									'S_LOGIN'	=> true,
									'S_TITLE'	=> $this->lang->lang('LOGIN'),
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
							'user_groups'			=> implode(',', $this->core->get_user_groups()),
						);
						
						$sql = 'INSERT INTO ' . CHAT_USERS_TABLE . ' ' . $this->db->sql_build_array('INSERT', $this->user_data);
						$this->db->sql_query($sql);
						
						$cookie_expire = $this->user->time_now + (($this->user->data['user_id'] != ANONYMOUS) ? (($this->config['max_autologin_time']) ? 86400 * (int) $this->config['max_autologin_time'] : 31536000) : 86400);
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
				
				// Update old sessions of the same user (when guests can access without name and user login, two users are online)
				if($this->cookie_user_key && $this->user_key != $this->cookie_user_key)
				{
					$sql = 'UPDATE ' . CHAT_USERS_TABLE . '
						SET user_online = 0
						WHERE user_key = ' . $this->cookie_user_key . '
						AND user_ip = "' . $this->user->ip . '"';
					$this->db->sql_query($sql);
					
					$cookie_expire = $this->user->time_now + (($this->user->data['user_id'] != ANONYMOUS) ? (($this->config['max_autologin_time']) ? 86400 * (int) $this->config['max_autologin_time'] : 31536000) : 86400);
					$this->user->set_cookie('chat_key', $this->user_key, $cookie_expire);
					
					$this->cookie_user_key = $this->user_key;
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

				if($action == 'connect_on_post')
				{
					return true;
				}

			// no break;
			
			case 'refresh':
			case 'refresh_after_post':
			case 'refresh_after_status':
			case 'refresh_after_move':
			case 'refresh_after_name':
				$row_users = $row_data = $user_cache = array();
				$max_time 		= $last_update;

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
						'message'	=> ($this->user_data['exclude_time'] == 1) ? $this->lang->lang('CHAT_USER_BANNED_PERMANENT') : $this->lang->lang('CHAT_USER_BANNED_PERIOD', $this->user->format_date($this->user_data['exclude_time'])),
					));
					break;
				}

				// Delete inactive users (one time every 3 updates)
				if($action == 'connect' || ($action == 'refresh' && $this->request->variable('trace', false)))
				{
					$sql_ary = array(
						'user_trace_time < ' . (time() - ($this->config['chat_refresh'] * 3))
					);

					if($this->chat->time_limit !== false)
					{
						$sql_ary[] = 'user_lastjoin < ' . $this->chat->time_limit;
					}
					
					$sql = 'UPDATE ' . CHAT_USERS_TABLE . '
						SET user_online = 0
						WHERE ( ' . implode(' OR ', $sql_ary) . ')
						AND user_key <> ' . $this->user_key;
					$this->db->sql_query($sql);
				}
				
				/* 
				 * Get connected users and update global variables of current user
				 */
				$user_update_ary = array(
					'user_trace_time'	=> time()
				);

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
							$row['user_status'] = $user_update_ary['user_status'] = $this->user_data['user_status'] = CHAT_STATUS_AWAY;
							$json['auto_away'] = 1;
						}
					}
					
					$row_users[$row['user_key']] 	= $row;
					$user_cache[$row['user_key']] 	= $row['user_key'];
				}
				$this->db->sql_freeresult($result);

				// Update user trace time and status if required
				if($action == 'connect' || $action == 'refresh')
				{
					$sql = 'UPDATE ' . CHAT_USERS_TABLE . '
						SET ' . $this->db->sql_build_array('UPDATE', $user_update_ary) . '
						WHERE user_key = ' . $this->user_key;
					$this->db->sql_query($sql);
				}
				unset($user_update_ary);
				
				/*
				 * Get new messages and rooms
				 */
				$midnight = $this->user->create_datetime();
				$midnight->setTime(0, 0, 0);

				$midnight = $midnight->getTimestamp();
				
				$room_autopurge_ids = $room_update_ids = array();

				foreach($this->room_ary as $room_key => $row)
				{
					if($room_key != CHAT_GUEST_ROOM &&
						((!$this->core->group_auth($row['room_data']['groups']) && !isset($row['room_data']['users'][$this->user->data['user_id']]))
						|| !$row['room_enabled']))
					{
						continue;
					}
					
					$row_data[$room_key] = array();
					
					// Autopurge
					if($action == 'connect' && $row['room_autopurge_time'])
					{
						// First day, don't delete messages, only update the purge check to this midnight
						if(!$row['room_autopurge_check'])
						{
							$row['room_autopurge_check'] = $midnight;
							$room_update_ids[] = $room_key;
						}
						
						if(($midnight - (int)$row['room_autopurge_time']) >= (int)$row['room_autopurge_check'])
						{
							$room_autopurge_ids[] = $room_key;
							$room_update_ids[] = $room_key;
						}
					}
				}
				
				// Do the autopurge
				if(sizeof($room_autopurge_ids))
				{
					$sql = 'DELETE FROM ' . CHAT_MESSAGES_TABLE . '
						WHERE ' . $this->db->sql_in_set('dest_key', $room_autopurge_ids);
					$this->db->sql_query($sql);
				}
				
				if(sizeof($room_update_ids))
				{
					$sql = 'UPDATE ' . CHAT_ROOMS_TABLE . '
						SET room_autopurge_check = ' . $midnight . '
						WHERE ' . $this->db->sql_in_set('room_key', $room_update_ids);
					$this->db->sql_query($sql);
					
					$this->cache->destroy('_chat_options');
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
						FROM ' . CHAT_MESSAGES_TABLE . '
						WHERE message_time > ' . (int)$this->user_data['user_trace_time'] . '
						AND (dest_key = ' . $this->user_key . '
							OR (poster_key = ' . $this->user_key . ' AND ' . $this->db->sql_in_set('dest_key', array_keys($this->room_ary), true) . '))
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
				
				$vars = array('action', 'row_data', 'row_users', 'user_cache', 'max_time', 'last_update');
				extract($this->obtain_rooms_data(compact($vars)));
				
				// Get queued actions
				$time_mark		= $this->request->variable('time_mark', 0);
				$queue_actions	= array();

				if($action == 'refresh' && $time_mark && ($queue_cache = $this->cache->get('_chat_queue')) !== false)
				{
					foreach($queue_cache as $marktime => $data)
					{
						if($marktime > $time_mark && $data['trigger'] != $this->user_key)
						{
							$queue_actions[] = $data;
						}
					}
				}

				// Update the values in javascript
				$json = array_merge($json, array(
					'action'		=> 'update',
					'timeMark'		=> time(),
					'last_time'		=> $max_time,
					'msg_direction'	=> $this->config['chat_direction'],
					'floodTime'		=> ($this->config['chat_flood_time'] && !$this->auth->acl_get('u_chat_ignoreflood')) ? $this->config['chat_flood_time'] * 1000 : 0,
					'queueActions'	=> $queue_actions,
				));
			break;
			
			case 'clear':
				if($this->auth('-m_chat_delete'))
				{
					$room_key = $this->request->variable('room', CHAT_GUEST_ROOM);
					
					if(isset($this->room_ary[$room_key]))
					{
						if(confirm_box(true))
						{
							$sql = 'DELETE FROM ' . CHAT_MESSAGES_TABLE . '
								WHERE dest_key = ' . $room_key;
							$this->db->sql_query($sql);
							
							if($room_key == CHAT_GUEST_ROOM)
							{
								$this->config->set('chat_purge_mark', time());
							}
						}
						else
						{
							$room_title = $this->room_ary[$room_key]['room_title'];
							$room_title = $this->lang->lang($room_title);
						
							confirm_box(
								false,
								$this->lang->lang('CHAT_PURGE_CONFIRM', $room_title),
								'',
								'@canidev_core/confirmbox.html'
							);
						}
					}
				}
			break;
			
			case 'delete':
				$sql = 'SELECT *
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
					
					$this->add_to_queue(array(
						'action'	=> 'delete',
						'msgID'		=> $message_id,
					));
					
					// Add log
					$parse_flags	= ($row['bbcode_bitfield'] ? OPTION_FLAG_BBCODE : 0) | OPTION_FLAG_SMILIES;
					$message 		= generate_text_for_display($row['message_text'], $row['bbcode_uid'], $row['bbcode_bitfield'], $parse_flags, true);
					$method			= ($row['poster_key'] == $this->user_key) ? 'user' : 'mod';
					
					$this->log->add(
						$method,
						$this->user->data['user_id'],
						$this->user->ip,
						'LOG_CHAT_MESSAGE_REMOVED',
						time(),
						($method == 'user') ? array('reportee_id' => 0, $message) : array($message)
					);
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
						$message = $this->request->variable('ic_edit_message', '', true);

						// BBcode control
						$this->strip_bbcode($message);
						
						if($message)
						{
							$uid = $bitfield = $options = '';
							generate_text_for_storage($message, $uid, $bitfield, $options, $allow_bbcode, $allow_urls, $allow_smilies, $allow_bbcode, $allow_bbcode, $allow_bbcode, $allow_urls, 'chat');
							
							$sql_ary = array(
								'message_text'		=> $message,
								'bbcode_bitfield'	=> $bitfield,
								'bbcode_uid'		=> $uid,
							);
							
							$sql = 'UPDATE ' . CHAT_MESSAGES_TABLE . '
								SET ' . $this->db->sql_build_array('UPDATE', $sql_ary) . '
								WHERE message_id = ' . $message_id;
							$this->db->sql_query($sql);

							$json['text'] = generate_text_for_display($message, $uid, $bitfield, $options);
							
							$this->add_to_queue(array(
								'action'	=> 'edit',
								'msgID'		=> $message_id,
								'msgText'	=> $json['text'],
							));
						}

						break;
					}

					decode_message($row['message_text'], $row['bbcode_uid']);

					$editor = \canidev\core\editor::get_instance($this->container);

					$editor->build(array(
						'name'				=> 'ic_edit_message',
						'plugins'			=> 'chat',
						'rows'				=> 3,
						'type'				=> 'basic',
						'value'				=> $row['message_text'],
						'toolbarContainer'	=> '.ic-edit-toolbar',
						'toolbar'			=> array('b', 'i', 'u', 'quote', 'code', 'list', 'list=1', '*', 'img', 'url', 'color', 'size'),
						'toolbarExclude'	=> $this->chat->get_disallowed_bbcodes(),
					));

					$this->template->assign_vars(array(
						'S_EDIT'	=> true,
						'S_TITLE'	=> $this->lang->lang('EDIT'),
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

				if(!$this->user_data || !$this->auth('post') || !$message || !empty($this->user_data['exclude_time']) || (!isset($this->room_ary[$room_key]) && !$this->config['chat_allow_pm']))
				{
					break;
				}
				
				// If room is disabled, no post and close the room
				if(isset($this->room_ary[$room_key]) && !$this->room_ary[$room_key]['room_enabled'])
				{
					$json = array(
						'action'	=> 'close_room',
						'room_key'	=> $room_key,
						'success'	=> true,
					);

					break;
				}

				// Flood control
				if(!isset($this->room_ary[$room_key]) && $this->config['chat_pm_ignore_flood'])
				{
					// ¿Ignore flood time for PM?
					$json['ignoreFloodTime'] = true;
				}
				else if($this->config['chat_flood_time'] && !$this->auth('ignoreflood') && $this->user_data['session_start'] != $this->user_data['user_lastjoin'])
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
					generate_text_for_storage($message, $uid, $bitfield, $options, $allow_bbcode, $allow_urls, $allow_smilies, $allow_bbcode, $allow_bbcode, $allow_bbcode, $allow_urls, 'chat');
					
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
					return $this->run('refresh_after_post', $json);
				}
			break;
			
			case 'quote':
				if($this->auth('post') && $this->config['chat_allow_bbcode'] && !in_array('quote', $this->chat->get_disallowed_bbcodes()))
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
						$json['text'] = htmlspecialchars_decode($new_text);
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
					'S_TITLE'	=> $this->lang->lang('CHAT_RULES'),
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
							'OVERFLOW_CTR'		=> 'style="overflow: auto!important;"',
							'S_DIALOG_CONTENT'	=> (sizeof($ipwhois) ? preg_replace('#(^(<br />)*|<br />$)#', '', implode('<br />', $ipwhois)) : $this->lang->lang('CHAT_NO_INFORMATION')),
							'S_TITLE'			=> $this->lang->lang('WHOIS'),
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

					$sql = 'SELECT cu.*, u.username AS member_name, u.user_type, u.user_colour, g.group_name
						FROM ' . CHAT_USERS_TABLE . ' cu
							LEFT JOIN ' . USERS_TABLE . ' u ON(u.user_id = cu.user_id)
							LEFT JOIN ' . GROUPS_TABLE . " g ON(g.group_id = u.group_id)
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
									$exclude_time = $this->user->create_datetime()
										->setDate((int)$match[3], (int)$match[2], (int)$match[1])
										->setTime((int)$match[4], (int)$match[5], (int)$match[6])
										->getTimestamp();
									
									if($exclude_time <= time())
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
						
						// Add log
						$username = ($user_data['username']) ? $user_data['username'] : $user_data['member_name'];
						
						$this->log->add('mod',
							$this->user->data['user_id'],
							$this->user->ip,
							'LOG_CHAT_EXCLUSION_' . (($action == 'banuser') ? 'ADDED' : 'REMOVED'),
							time(),
							array($username)
						);
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
						$option_str .= '<option value="' . $value . '">' . $this->lang->lang($title) . '</option>';
					}

					$this->template->assign_vars(array(
						'S_BAN'				=> true,
						'S_PERIOD_OPTIONS'	=> $option_str,
						'S_TITLE'			=> $this->lang->lang('CHAT_BAN_USER'),
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
							'S_DIALOG_CONTENT'	=> $this->lang->lang('CHAT_PM_EXCEED'),
							'S_TITLE'			=> $this->lang->lang('INFORMATION'),
						));
						
						$json['dialog'] = true;
						break;
					}
				}
				
				$row_users		= $user_cache = array();
				$user_key		= $this->request->variable('uk', 0);
				$max_time 		= $last_update;
				$last_update	= 0;
				
				if(!$user_key)
				{
					break;
				}
				
				$row_data = array(
					$user_key	=> array(),
				);
				
				// Get conversation users
				$sql = 'SELECT *
					FROM ' . CHAT_USERS_TABLE . '
					WHERE ' . $this->db->sql_in_set('user_key', array($user_key, $this->user_key));
				$result = $this->db->sql_query($sql);
				while($row = $this->db->sql_fetchrow($result))
				{
					$row_users[$row['user_key']] = $row;
					$user_cache[$row['user_key']] = $row;
				}
				$this->db->sql_freeresult($result);
				
				$vars = array('action', 'row_data', 'row_users', 'user_cache', 'max_time', 'last_update');
				extract($this->obtain_rooms_data(compact($vars)));
				
				// Update the values in javascript
				$json = array_merge($json, array(
					'action'		=> 'update',
					'timeMark'		=> time(),
					'last_time'		=> $max_time,
					'msg_direction'	=> $this->config['chat_direction'],
					'floodTime'		=> ($this->config['chat_flood_time'] && !$this->auth->acl_get('u_chat_ignoreflood')) ? $this->config['chat_flood_time'] * 1000 : 0,
				));
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
				
				$sql_ary = array(
					'user_lastjoin'	=> time(),
					'user_status'	=> ($status_id === false) ? CHAT_STATUS_AVAILABLE : $status_id,
				);
				
				$sql = 'UPDATE ' . CHAT_USERS_TABLE . '
					SET ' . $this->db->sql_build_array('UPDATE', $sql_ary) . '
					WHERE user_key = ' . $user_key;
				$this->db->sql_query($sql);
				
				// Refresh the chat 
				return $this->run('refresh_after_status');
			break;

			case 'set_name':
				$user_key = $this->request->variable('uk', 0);

				if(!$this->get_current_user() || $user_key != $this->user_key || $this->user_data['user_id'] != ANONYMOUS)
				{
					break;
				}

				if($submit)
				{
					$username = $this->request->variable('username', '', true);

					$sql = 'UPDATE ' . CHAT_USERS_TABLE . "
						SET username = '" . $this->db->sql_escape($username) . "'
						WHERE user_key = " . $this->user_key;
					$this->db->sql_query($sql);

					// Refresh the chat 
					return $this->run('refresh_after_name');
				}

				$this->template->assign_vars(array(
					'S_SET_NAME'			=> true,
					'S_CURRENT_USERNAME'	=> $this->user_data['username'],
					'S_TITLE'				=> $this->lang->lang('CHAT_CHANGE_NAME'),
				));
			break;
			
			case 'move':
				$sql = 'SELECT *
					FROM ' . CHAT_MESSAGES_TABLE . "
					WHERE message_id = $message_id";
				$result = $this->db->sql_query($sql);
				$message_row = $this->db->sql_fetchrow($result);
				$this->db->sql_freeresult($result);
				
				if(!$message_row)
				{
					break;
				}

				if($this->get_current_user() && $this->auth('-m_chat_edit'))
				{
					if($submit)
					{
						$to_room = $this->request->variable('to_room', 0);

						if($to_room)
						{
							$sql = 'UPDATE ' . CHAT_MESSAGES_TABLE . '
								SET dest_key = ' . (int)$to_room . '
								WHERE message_id = ' . $message_id;
							$this->db->sql_query($sql);
						}
						
						$this->add_to_queue(array(
							'action'	=> 'move',
							'msgID'		=> $message_id,
							'destKey'	=> $to_room,
						));
						
						// Add log
						$parse_flags	= ($row['bbcode_bitfield'] ? OPTION_FLAG_BBCODE : 0) | OPTION_FLAG_SMILIES;
						$message 		= generate_text_for_display($message_row['message_text'], $message_row['bbcode_uid'], $message_row['bbcode_bitfield'], $parse_flags, true);
					
						$this->log->add(
							'mod',
							$this->user->data['user_id'],
							$this->user->ip,
							'LOG_CHAT_MESSAGE_MOVED',
							time(),
							array(
								$this->lang->lang($this->room_ary[$message_row['dest_key']]['room_title']),
								$this->lang->lang($this->room_ary[$to_room]['room_title']),
								$message
							)
						);

						// Refresh the chat 
						return $this->run('refresh_after_move');
					}

					$options_str = '';
					
					if(!isset($this->room_ary[CHAT_GUEST_ROOM]))
					{
						$this->room_ary[CHAT_GUEST_ROOM] = array();
					}
					
					foreach($this->room_ary as $room_key => $row)
					{
						if($room_key != CHAT_GUEST_ROOM &&
							((!$this->core->group_auth($row['room_data']['groups']) && !isset($row['room_data']['users'][$this->user->data['user_id']]))
							|| !$row['room_enabled'])
							|| $room_key == $message_row['dest_key'])
						{
							continue;
						}
						
						$options_str .= '<option value="' . $room_key . '">' . $this->lang->lang($row['room_title']) . '</option>';
					}

					$this->template->assign_vars(array(
						'S_MOVE'			=> true,
						'S_ROOM_OPTIONS'	=> $options_str,
						'S_TITLE'			=> $this->lang->lang('CHAT_MOVE'),
					));
				}
			break;
			
			case 'history':
				$room_key = $this->request->variable('room', 0);
				$max_time = $last_update;

				if(!$room_key)
				{
					break;
				}
				
				$row_data[$room_key] = array();
				
				$row_users = $user_cache = array();
				
				$vars = array('action', 'row_data', 'row_users', 'user_cache', 'max_time', 'last_update');
				extract($this->obtain_rooms_data(compact($vars), true));
			break;
			
			case 'smiley_pagination':
				$template_filename = '@canidev_chat/smiley_box.html';
				$start = $this->request->variable('start', 0);
				
				$this->chat->generate_smilies($start);
			break;
		}
		
		/**
		* @event chat.after_action_run
		* @var	string	action				Current action
		* @var	string	template_filename	Template to use
		* @var	array	json				Data to send to chat
		* @since 1.2.0
		*/
		$vars = array('action', 'template_filename', 'json');
		extract($this->dispatcher->trigger_event('chat.after_action_run', compact($vars)));
		
		if((in_array($action, array('login', 'edit', 'rules', 'whois', 'banuser', 'move', 'set_name')) || !empty($json['dialog'])) && !$submit)
		{
			$this->template->assign_var('S_DIALOG', true);
		}

		$this->template->set_filenames(array(
			'chat' => $template_filename
		));
		
		$response = \canidev\core\json_response::get_instance();

		$response
			->add($json)
			->add_html($this->template->assign_display('chat'))
			->send();
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
			if($room_key != CHAT_GUEST_ROOM && isset($row['user_groups']) && isset($this->room_ary[$room_key]) &&
				(!$this->core->group_auth($this->room_ary[$room_key]['room_data']['groups'], $row['user_groups']) && !isset($this->room_ary[$room_key]['room_data']['users'][$row['user_id']])))
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
					$u_action = '#';
					
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

								$u_action = append_sid($this->root_path . 'adm/index.' . $this->php_ext, 'i=users&amp;mode=overview&amp;u=' . $row['user_id'], true, $this->user->session_id);
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
								'S_ACTION'		=> $user_action,
								'S_ICON'		=> isset($action_data['icon']) ? $action_data['icon'] : '',
								'S_TITLE'		=> $this->lang->lang($action_data['lang']),
								'S_USER_KEY'	=> $user_key,
								'U_ACTION'		=> $u_action,
							);
						}
					}
				}
			}
			else
			{
				if($row['user_id'] == ANONYMOUS) // test falta opcion
				{
					$row_actions[] = array(
						'S_ACTION'		=> 'set_name',
						'S_ICON'		=> 'fa-pencil',
						'S_TITLE'		=> $this->lang->lang('CHAT_CHANGE_NAME'), // test
						'S_USER_KEY'	=> $user_key,
						'U_ACTION'		=> '#',
					);
				}

				foreach($this->status_ary as $status_id => $action)
				{
					if($status_id == CHAT_STATUS_HIDDEN && !$this->auth('-u_hideonline'))
					{
						continue;
					}

					$title = $this->lang->lang('CHAT_STATUS_' . strtoupper($action));
					
					if($row['user_status'] == $status_id)
					{
						$title = '<strong>' . $title . '</strong>';
					}

					$row_actions[] = array(
						'S_ACTION'		=> 'set_' . $action,
						'IS_STATUS'		=> true,
						'S_STATUS'		=> $action,
						'S_TITLE'		=> $title,
						'S_USER_KEY'	=> $user_key
					);
				}
			}
			
			$user_status	= $this->status_ary[$row['user_status']];
			$rkey			= 0;
			
			if($this->config['chat_group_users'])
			{
				switch($row['group_name'])
				{
					case 'ADMINISTRATORS':
						$rkey = 1;
					break;
					
					case 'GLOBAL_MODERATORS':
						$rkey = 2;
					break;
					
					case 'REGISTERED':
						$rkey = 3;
					break;
					
					case 'NEWLY_REGISTERED':
						$rkey = 4;
					break;
					
					case 'GUESTS':
						$rkey = 'zzz';
					break;
					
					default:
						$rkey = strtolower($row['group_name']);
					break;
				}
			}
			
			$rkey = $rkey . '.' . strtolower($row['username']);
			
			$user_row = array(
				'S_KEY'			=> $user_key,
				'S_STATUS'		=> $user_status,
				'S_USERNAME'	=> ($row['user_id'] == ANONYMOUS || $row['exclude_time']) ? $row['username'] : get_username_string('no_profile', $row['user_id'], $row['username'], $row['user_colour'], $row['username']),
				'IS_EXCLUDED'	=> ($row['exclude_time']) ? true : false,
				'U_ACTION'		=> ($row['user_id'] == ANONYMOUS) ? '#' : get_username_string('profile', $row['user_id'], $row['username'], $row['user_colour'], $row['username']),
				
				'S_HAS_SUBMENU'		=> (sizeof($row_actions) ? true : false),
				'contextmenu'		=> $row_actions,
			);
			
			/**
			* @event chat.modify_user_row
			* @var	array	row				Original user data
			* @var	array	$user_row		Output data
			* @since 1.2.0
			*/
			$vars = array('row', 'user_row');
			extract($this->dispatcher->trigger_event('chat.modify_user_row', compact($vars)));
			
			$rows[$rkey] = $user_row;
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
	
	public function get_current_user($only_online = false, $rtn_data = false)
	{
		if(empty($this->user_data))
		{
			$user_key = ($this->user->data['is_registered']) ? $this->user->data['user_id'] : $this->user_key;
			
			$sql = 'SELECT *
				FROM ' . CHAT_USERS_TABLE . '
				WHERE (user_id = ' . $this->user->data['user_id'] . '
					AND user_key = ' . $user_key . ')';

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
		
		return ($rtn_data) ? $this->user_data : true;
	}
	
	private function strip_bbcode(&$message)
	{
		$bbcode_preg = '';
		
		if(!$this->config['chat_allow_bbcode'])
		{
			$bbcode_preg = '#\[\/?([a-z0-9\*\+\-]+).*?\]#i';
		}
		else
		{
			$disallowed_ary = $this->chat->get_disallowed_bbcodes();

			if(sizeof($disallowed_ary))
			{
				$bbcode_preg = '#\[\/?(' . implode('|', array_map('preg_quote', $disallowed_ary)) . ').*?\]#i';
			}
		}
		
		if($bbcode_preg)
		{
			$message = preg_replace($bbcode_preg, '', $message);
		}
	}
	
	protected function post_to_room(&$row_data, $row, $timemark, $linked_forums)
	{
		$forum_id = (int)$row['forum_id'];
		$room_keys = isset($linked_forums[$forum_id]) ? $linked_forums[$forum_id] : array(CHAT_GUEST_ROOM);

		foreach($room_keys as $room_key)
		{
			if(isset($row_data[$room_key][$timemark]))
			{
				$timemark = $timemark . '-' . $row['topic_id'] . (isset($row['post_id']) ? '.' . $row['post_id'] : '');
			}
			
			$row_data[$room_key][$timemark] = $row;
		}
	}
	
	protected function add_to_queue($data)
	{
		$queue_cache 	= $this->cache->get('_chat_queue');
		$current_time	= time();
		$ttl			= 600; // 10 min
		
		if($queue_cache === false)
		{
			$queue_cache = array();
		}
		
		// First, remove old queue (after 10 min)
		foreach($queue_cache as $timemark => $null)
		{
			if($timemark < ($current_time - $ttl))
			{
				unset($queue_cache[$timemark]);
			}
		}
		
		// Add new action
		$data['trigger'] = $this->user_key;
		$queue_cache[$current_time] = $data;
		
		$this->cache->put('_chat_queue', $queue_cache, $ttl);
	}
	
	protected function obtain_rooms_data($event, $history = false)
	{
		$row_data		= $event['row_data'];
		$row_users		= $event['row_users'];
		$user_cache		= $event['user_cache'];
		$last_update	= $event['last_update'];
		$max_time		= $event['max_time'];
		$total_rooms	= 0;

		// Get messages for each room
		foreach($row_data as $dest_key => $null)
		{
			if(isset($this->room_ary[$dest_key]))
			{
				// is a room
				$sql_where = "dest_key = $dest_key";
				
				$total_rooms++;
			}
			else
			{
				// is a user
				$sql_where = '((dest_key = ' . $dest_key . ' AND poster_key = ' . $this->user_key . ')
					OR (poster_key = ' . $dest_key . ' AND dest_key = ' . $this->user_key . '))';
			}

			$sql_where .= ' AND message_time ' . (($history) ? "< $last_update" : "> $last_update");

			$sql = 'SELECT *
				FROM ' . CHAT_MESSAGES_TABLE . "
				WHERE $sql_where
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
				
				$max_time = max($max_time, $row['message_time']);
			}
			$this->db->sql_freeresult($result);
		}

		// Get the new topics of forums if allowed
		$load_forum_posts = ($event['action'] != 'pmuser' && $this->config['chat_forum_posts'] != CHAT_SHOW_NONE);
		
		if($load_forum_posts)
		{
			$linked_forums	= array();
			
			// Get forums linked to public rooms
			foreach($this->room_ary as $room_key => $row)
			{
				foreach($row['room_data']['linked_forums'] as $forum_id)
				{
					if(!isset($linked_forums[$forum_id]))
					{
						$linked_forums[$forum_id] = array();
					}
					
					$linked_forums[$forum_id][] = $room_key;
				}
			}
			
			// If history, only load forums posts if is a public room and have linked forums
			if($history)
			{
				$row_key = array_keys($row_data)[0];
				
				if(!isset($this->room_ary[$row_key]) || ($row_key != CHAT_GUEST_ROOM && empty($this->room_ary[$row_key]['room_data']['linked_forums'])))
				{
					$load_forum_posts = false;
				}
			}
		}
		
		if($load_forum_posts)
		{
			$mark_time = max($last_update, (int)$this->config['chat_purge_mark']);			
			$sql_where = '%1$s > ' . $mark_time;

			if($history)
			{
				$sql_where = '%1$s > ' . (int)$this->config['chat_purge_mark'] . '
					AND %1$s < ' . $last_update;
					
				if(!empty($this->room_ary[$row_key]['room_data']['linked_forums']))
				{
					$sql_where .= ' AND ' . $this->db->sql_in_set('forum_id', $this->room_ary[$row_key]['room_data']['linked_forums']);
				}
				else if($row_key == CHAT_GUEST_ROOM && !empty($linked_forums))
				{
					$sql_where .= ' AND ' . $this->db->sql_in_set('forum_id', array_keys($linked_forums), true);
				}
				else
				{
					$load_forum_posts = false;
				}
			}
			else if(!empty($this->room_ary[CHAT_GUEST_ROOM]['room_data']['linked_forums']))
			{
				// If guest room have forums assigned, not load topics and post on all forums
				$sql_where .= ' AND ' . $this->db->sql_in_set('forum_id', array_keys($linked_forums));
			}
		}

		if($load_forum_posts)
		{
			switch($this->config['chat_forum_posts'])
			{
				case CHAT_SHOW_TOPICS:
					$sql = 'SELECT topic_id, forum_id, topic_title, topic_time, topic_visibility, topic_first_post_id,
						topic_poster AS poster_id, topic_first_poster_name AS poster_username
						FROM ' . TOPICS_TABLE . '
						WHERE ' . sprintf($sql_where, 'topic_time') . '
						ORDER BY topic_time DESC';
					$result = $this->db->sql_query_limit($sql, $this->config['chat_max_rows']);
					while($row = $this->db->sql_fetchrow($result))
					{
						if(($this->auth->acl_get('m_approve', $row['forum_id']) || $row['topic_visibility'] == ITEM_APPROVED) && $this->auth->acl_get('f_read', $row['forum_id']))
						{
							$this->post_to_room($row_data, $row, $row['topic_time'], $linked_forums);

							$user_cache[$row['poster_id']] = $row['poster_id'];
							
							$max_time = max($max_time, $row['topic_time']);
						}
					}
					$this->db->sql_freeresult($result);
				break;
				
				case CHAT_SHOW_POSTS:
					$sql = 'SELECT post_id, topic_id, forum_id, post_subject, post_text, post_time, post_visibility,
						poster_id, post_username AS poster_username, bbcode_uid, bbcode_bitfield
						FROM ' . POSTS_TABLE . '
						WHERE ' . sprintf($sql_where, 'post_time') . '
						ORDER BY post_time DESC';
					$result = $this->db->sql_query_limit($sql, $this->config['chat_max_rows']);
					while($row = $this->db->sql_fetchrow($result))
					{
						if(($this->auth->acl_get('m_approve', $row['forum_id']) || $row['post_visibility'] == ITEM_APPROVED) && $this->auth->acl_get('f_read', $row['forum_id']))
						{
							$this->post_to_room($row_data, $row, $row['post_time'], $linked_forums);

							$user_cache[$row['poster_id']] = $row['poster_id'];

							$max_time = max($max_time, $row['post_time']);
						}
					}
					$this->db->sql_freeresult($result);
				break;
			}
			
			unset($mark_time);
			
			// Sort and limit messages in all rooms
			$room_keys = array_keys($row_data);
			
			foreach($room_keys as $room_key)
			{
				krsort($row_data[$room_key]);
				
				if(sizeof($row_data[$room_key]) > $this->config['chat_max_rows'])
				{
					$row_data[$room_key] = array_slice($row_data[$room_key], 0, $this->config['chat_max_rows'], true);
				}
			}
		}

		// Get the users data
		if(!empty($user_cache))
		{
			$sql = 'SELECT u.user_id, u.group_id, u.user_type, u.username, u.user_colour,
				u.user_avatar, u.user_avatar_type, u.user_avatar_width, u.user_avatar_height, g.group_name
				FROM ' . USERS_TABLE . ' u
					LEFT JOIN ' . GROUPS_TABLE . ' g ON(g.group_id = u.group_id)
				WHERE (u.user_id = ' . ANONYMOUS . '
					OR ' . $this->db->sql_in_set('u.user_id', array_keys($user_cache)) . ')';
			$result = $this->db->sql_query($sql);
			while($row = $this->db->sql_fetchrow($result))
			{
				$user_cache[$row['user_id']] = $row;
			}
			$this->db->sql_freeresult($result);
		}
		
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
				$room_title = $this->lang->lang($room_title);
			}
			else
			{
				$room_title = $user_cache[$room_key]['username'];
			}

			$this->template->assign_block_vars('room', array(
				'ID'			=> $room_key,
				'S_TITLE'		=> $room_title,
				'S_CLASS'		=> 'room' . (($is_public_room) ? ' js-public-room' : ''),
				'SHOW_HISTORY'	=> ($event['action'] != 'refresh' && $this->auth('-u_chat_archive') && sizeof($room_data) == $this->config['chat_max_rows']) ? true : false,
			));
			
			if($this->config['chat_direction'] != 'up')
			{
				ksort($room_data);
			}
			
			// Messages
			foreach($room_data as $null => $row)
			{
				$row_avatar = $message = '';
				$timestamp 		= 0;
				$parse_flags	= (!empty($row['bbcode_bitfield']) ? OPTION_FLAG_BBCODE : 0) | OPTION_FLAG_SMILIES;
				
				if(isset($row['post_id']))
				{
					$edit_allowed = ($this->user->data['is_registered'] && ($this->auth->acl_get('m_edit', $row['forum_id']) || (
						$this->user->data['user_id'] == $row['poster_id'] &&
						$this->auth->acl_get('f_edit', $row['forum_id']) &&
						($row['post_time'] > time() - ($this->config['edit_time'] * 60) || !$this->config['edit_time'])
					)));
					
					$row['poster_key'] = $row['poster_id'];
					
					// Parse the message
					$message = generate_text_for_display($row['post_text'], $row['bbcode_uid'], $row['bbcode_bitfield'], $parse_flags, true);
					
					$timestamp = $row['post_time'];
				}
				else if(isset($row['topic_id']))
				{
					$edit_allowed = ($this->user->data['is_registered'] && ($this->auth->acl_get('m_edit', $row['forum_id']) || (
						$this->user->data['user_id'] == $row['poster_id'] &&
						$this->auth->acl_get('f_edit', $row['forum_id']) &&
						($row['topic_time'] > time() - ($this->config['edit_time'] * 60) || !$this->config['edit_time'])
					)));
					
					$row['poster_key'] = $row['poster_id'];
					$timestamp = $row['topic_time'];
				}
				else
				{
					// Parse the message
					$message = generate_text_for_display($row['message_text'], $row['bbcode_uid'], $row['bbcode_bitfield'], $parse_flags, true);
					
					$timestamp = $row['message_time'];
				}
				
				if(is_array($user_cache[$row['poster_key']]))
				{
					$row += $user_cache[$row['poster_key']];
				}
				
				if($this->config['chat_show_avatars'] && $row['poster_id'] != ANONYMOUS)
				{
					$row_avatar = phpbb_get_user_avatar(array(
						'avatar'		=> $row['user_avatar'],
						'avatar_type'	=> $row['user_avatar_type'],
						'avatar_width'	=> $row['user_avatar_width'], 
						'avatar_height'	=> $row['user_avatar_height'],
					));

					// Fix path error occurs in some cases
					if($row_avatar && $this->chat->web_path != $this->root_path && strpos($row_avatar, 'src=".') !== false)
					{
						$row_avatar = preg_replace('#src\="(\.|\/)+#', 'src="' . $this->chat->web_path, $row_avatar);
					}
				}

				$ary = array(
					'S_AUTHOR_AVATAR'	=> $row_avatar,
					'S_AUTHOR_FULL'		=> ($row['poster_id'] == ANONYMOUS) ? $row['poster_username'] : get_username_string('full', $row['poster_key'], $row['username'], $row['user_colour']),
					'S_DATE'			=> $this->chat->format_date($timestamp),
					'S_SHOW_AVATAR'		=> (bool)$this->config['chat_show_avatars'],
					'S_TIMESTAMP'		=> $timestamp,
				);

				if(isset($row['post_id']))
				{
					$ary += array(
						'S_ID'				=> 'p' . $row['topic_id'],
						'IS_POST'			=> true,
						'POST_SUBJECT'		=> censor_text($row['post_subject']),
						'S_TEXT'			=> \canidev\core\tools::html_truncate($message, $this->config['chat_max_chars'], '...'),
						
						'U_POST'			=> append_sid($this->root_path . 'viewtopic.' . $this->php_ext . '?f=' . $row['forum_id'] . '&amp;p=' . $row['post_id'] . '#p' . $row['post_id']),
						'U_POST_EDIT'		=> ($edit_allowed) ? append_sid($this->root_path . 'posting.' . $this->php_ext, 'mode=edit&amp;f=' . $row['forum_id'] . '&amp;p=' . $row['post_id']) : '',
					);
				}
				else if(isset($row['topic_id']))
				{
					$ary += array(
						'S_ID'				=> 't' . $row['topic_id'],
						'IS_TOPIC'			=> true,
						'TOPIC_TITLE'		=> censor_text($row['topic_title']),
						
						'U_TOPIC'			=> append_sid($this->root_path . 'viewtopic.' . $this->php_ext . '?f=' . $row['forum_id'] . '&amp;t=' . $row['topic_id']),
						'U_TOPIC_EDIT'		=> ($edit_allowed) ? append_sid($this->root_path . 'posting.' . $this->php_ext, 'mode=edit&amp;f=' . $row['forum_id'] . '&amp;p=' . $row['topic_first_post_id']) : '',
					);
				}
				else
				{
					$ary += array(
						'S_ID'				=> $row['message_id'],
						'S_TEXT'			=> $message,
						
						'CAN_DELETE'		=> $this->auth('delete', $row),
						'CAN_EDIT'			=> $this->auth('edit', $row),
						'CAN_MOVE'			=> ($is_public_room && $total_rooms > 1 && $this->auth('-m_chat_edit')),
						'CAN_QUOTE'			=> (!in_array('quote', $this->chat->get_disallowed_bbcodes()) && $this->auth('post')) ? true : false,
						'CAN_VIEW_WHOIS'	=> $this->auth('-a_'),
					);
				}
				
				/**
				* @event chat.modify_message_row
				* @var	array	row			Array with original message and user data
				* @var	array	ary			Template block array of the post
				* @since 1.2.0
				*/
				$vars = array('row', 'ary');
				extract($this->dispatcher->trigger_event('chat.modify_message_row', compact($vars)));
					
				$this->template->assign_block_vars('room.message', $ary);
			}
			
			// Users
			$this->generate_userlist($row_users, $user_cache, $room_key);
		}
		
		$this->template->assign_vars(array(
			'S_CHAT_DIRECTION'	=> $this->config['chat_direction'],
		));

		$event['row_data']		= $row_data;
		$event['row_users']		= $row_users;
		$event['user_cache']	= $user_cache;
		$event['last_update']	= $last_update;
		$event['max_time']		= $max_time;
		
		return $event;
	}
}
