<?php
/*
* @name main_controller.php
* @package cBB Chat
* @version v1.1.3 10/03/2017
*
* @copyright (c) 2017 CaniDev
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/

namespace canidev\chat\controller;

use Symfony\Component\DependencyInjection\ContainerInterface;

/**
* Main controller
*/
class main_controller implements main_interface
{
	protected $auth;
	protected $config;
	protected $container;
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
	* @param ContainerInterface 				$container		Service container interface
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
	public function __construct(\phpbb\auth\auth $auth, \phpbb\config\config $config, ContainerInterface $container, \phpbb\db\driver\driver_interface $db, \phpbb\controller\helper $helper, \phpbb\request\request $request, \phpbb\template\template $template, \phpbb\user $user, $root_path, $php_ext)
	{
		$this->auth			= $auth;
		$this->config		= $config;
		$this->container	= $container;
		$this->db			= $db;
		$this->helper 		= $helper;
		$this->request		= $request;
		$this->template 	= $template;
		$this->user			= $user;
		
		$this->root_path	= $root_path;
		$this->php_ext		= $php_ext;
	}

	/**
	* Display the chat
	* @access public
	*/
	public function display()
	{
		global $chat;
		
		$mode		= $this->request->variable('mode', '');
		$is_embed 	= $this->request->variable('embed', false);
		$no_title	= $this->request->variable('notitle', false);
		
		$messages_per_page = 50;
		
		if(empty($chat->enabled) && !$is_embed)
		{
			redirect(append_sid($this->root_path . 'index.' . $this->php_ext));
		}
		
		switch($mode)
		{
			case 'archive':
				if(!$this->auth->acl_get('u_chat_archive'))
				{
					trigger_error('NOT_AUTHORISED', E_USER_WARNING);
				}
				
				$default_sort_days	= 0;
				$default_sort_key	= 't';
				$default_sort_dir	= 'd';

				$sort_days		= $this->request->variable('st', $default_sort_days);
				$sort_key		= $this->request->variable('sk', $default_sort_key);
				$sort_dir		= $this->request->variable('sd', $default_sort_dir);
				$row_id_list	= $this->request->variable('row_id_list', array(0));
				
				$action 	= $this->request->variable('action', '');
				$start 		= $this->request->variable('start', 0);
				
				// Obtain rooms
				$room_ary		= $chat->obtain_rooms();
				$current_room	= $this->request->variable('room', CHAT_GUEST_ROOM);
				
				$u_archive	= $this->helper->route('canidev_chat_controller', array(
					'mode'	=> 'archive',
					'room'	=> $current_room
				));
				
				// Filter Rooms
				foreach($room_ary as $room_key => $row)
				{
					if($room_key != CHAT_GUEST_ROOM &&
						((!in_array($this->user->data['group_id'], $row['room_data']['groups']) && !isset($row['room_data']['users'][$this->user->data['user_id']]))
						|| !$row['room_enabled']))
					{
						unset($room_ary[$room_key]);
					}
				}

				if(!isset($room_ary[$current_room]))
				{
					redirect($u_archive);
				}
				
				$batch_actions = array(
					'delete_selected'	=> array('DELETE', 'm_chat_delete', true),
					'move_selected'		=> array('CHAT_MOVE', 'm_chat_edit', (sizeof($room_ary) > 1)),
				);
				
				switch($action)
				{
					case 'delete_selected':
						if(!$this->auth->acl_get('m_chat_delete'))
						{
							trigger_error('NOT_AUTHORISED', E_USER_WARNING);
						}
						
						if(sizeof($row_id_list))
						{
							$sql = 'DELETE FROM ' . CHAT_MESSAGES_TABLE . '
								WHERE ' . $this->db->sql_in_set('message_id', $row_id_list);
							$this->db->sql_query($sql);
						}
					break;
					
					case 'move_selected':
						if(!$this->auth->acl_get('m_chat_edit'))
						{
							trigger_error('NOT_AUTHORISED', E_USER_WARNING);
						}
						
						$to_room_id = $this->request->variable('to_room_id', 0);
						
						$s_hidden_fields = build_hidden_fields(array(
							'row_id_list'	=> $row_id_list,
							'room'			=> $current_room,
							'action'		=> 'move_selected',
						));
						
						if(confirm_box(true))
						{
							if($to_room_id && sizeof($row_id_list))
							{
								$sql = 'UPDATE ' . CHAT_MESSAGES_TABLE . '
									SET dest_key = ' . $to_room_id . '
									WHERE ' . $this->db->sql_in_set('message_id', $row_id_list);
								$this->db->sql_query($sql);
							}

							redirect($u_archive);
						}
						else
						{					
							$options_str = '';

							foreach($room_ary as $room_key => $row)
							{
								if($room_key == $current_room)
								{
									continue;
								}
								
								$room_title = $row['room_title'];
								$room_title = (isset($this->user->lang[$room_title]) ? $this->user->lang[$room_title] : $room_title);
								
								$options_str .= '<option value="' . $room_key . '">' . $room_title . '</option>';
							}

							$this->template->assign_vars(array(
								'S_ROOM_OPTIONS'	=> $options_str,
							));

							confirm_box(false, 'CHAT_MOVE', $s_hidden_fields, 'chat_move.html');
						}
					break;
				}
			
				if(!function_exists('get_user_avatar'))
				{
					include($this->root_path. 'includes/functions_display.' . $this->php_ext);
				}

				$chat_ajax 	= $this->container->get('canidev.chat.chat_ajax');
				$limit_days = array(0 => $this->user->lang['ALL_MESSAGES'], 1 => $this->user->lang['1_DAY'], 7 => $this->user->lang['7_DAYS'], 14 => $this->user->lang['2_WEEKS'], 30 => $this->user->lang['1_MONTH'], 90 => $this->user->lang['3_MONTHS'], 180 => $this->user->lang['6_MONTHS'], 365 => $this->user->lang['1_YEAR']);

				$sort_by_text	= array('t' => $this->user->lang['POST_TIME']);
				$sort_by_sql	= array('t' => 'cm.message_time');

				$s_limit_days = $s_sort_key = $s_sort_dir = $u_sort_param = '';
				gen_sort_selects($limit_days, $sort_by_text, $sort_days, $sort_key, $sort_dir, $s_limit_days, $s_sort_key, $s_sort_dir, $u_sort_param, $default_sort_days, $default_sort_key, $default_sort_dir);
				
				$sql_sort_order = 'ORDER BY ' . $sort_by_sql[$sort_key] . ' ' . (($sort_dir == 'd') ? 'DESC' : 'ASC');
				
				$min_post_time = ($sort_days) ? time() - ($sort_days * 86400) : 0;
				
				// Get total messages
				$sql = 'SELECT COUNT(message_id) AS total
					FROM ' . CHAT_MESSAGES_TABLE . '
					WHERE dest_key = ' . $current_room . "
					AND message_time >= $min_post_time";
				$result = $this->db->sql_query($sql);
				$total_messages = (int)$this->db->sql_fetchfield('total');
				$this->db->sql_freeresult($result);
			
				$sql = 'SELECT cm.*, u.username, u.user_colour,
						u.user_avatar, u.user_avatar_type, u.user_avatar_width, u.user_avatar_height
					FROM ' . CHAT_MESSAGES_TABLE . ' cm
						LEFT JOIN ' . USERS_TABLE . ' u ON(u.user_id = cm.poster_id)
					WHERE cm.dest_key = ' . $current_room . "
					AND message_time >= $min_post_time
					$sql_sort_order";
				$result = $this->db->sql_query_limit($sql, $messages_per_page, $start);
				while($row = $this->db->sql_fetchrow($result))
				{
					$row_avatar = '';
					
					$parse_flags = ($row['bbcode_bitfield'] ? OPTION_FLAG_BBCODE : 0) | OPTION_FLAG_SMILIES;
					$message = generate_text_for_display($row['message_text'], $row['bbcode_uid'], $row['bbcode_bitfield'], $parse_flags, true);
					
					if($this->config['chat_show_avatars'] && $row['poster_id'] != ANONYMOUS)
					{
						$row_avatar = get_user_avatar($row['user_avatar'], $row['user_avatar_type'], $row['user_avatar_width'], $row['user_avatar_height']);
					}

					$this->template->assign_block_vars('message', array(
						'S_ID'				=> $row['message_id'],
						'S_AUTHOR_AVATAR'	=> $row_avatar,
						'S_AUTHOR_FULL'		=> ($row['poster_id'] == ANONYMOUS) ? $row['poster_username'] : get_username_string('full', $row['poster_id'], $row['username'], $row['user_colour']),
						'S_TEXT'			=> $message,
						'S_DATE'			=> $chat->format_date($row['message_time']),
						'S_SHOW_AVATAR'		=> (bool)$this->config['chat_show_avatars'],
						
						'CAN_DELETE'		=> $chat_ajax->auth('delete', $row),
						'CAN_EDIT'			=> $chat_ajax->auth('edit', $row),
						'CAN_MOVE'			=> (sizeof($room_ary) > 1 && $chat_ajax->auth('-m_chat_edit')),
						'CAN_VIEW_WHOIS'	=> $this->auth->acl_get('a_'),
					));
				}
				$this->db->sql_freeresult($result);
				
				$pagination_params = array('mode' => 'archive');
				
				if($current_room != CHAT_GUEST_ROOM)
				{
					$pagination_params['room'] = $current_room;
				}
				
				if(strlen($u_sort_param))
				{
					$u_sort_param = explode('&', str_replace('&amp;', '&', $u_sort_param));
					
					foreach($u_sort_param as $param)
					{
						list($key, $value) = explode('=', $param);
						$pagination_params[$key] = $value;
					}
				}
				
				// Build batch options
				$batch_options = '';
				
				foreach($batch_actions as $key => $row)
				{
					if(!$this->auth->acl_get($row[1]) || empty($row[2]))
					{
						continue;
					}
					
					$batch_options .= '<option value="' . $key . '">' . $this->user->lang($row[0]) . '</option>';
				}

				// Build Pagination
				$u_pagination	= $this->helper->route('canidev_chat_controller', $pagination_params);
				$pagination 	= $this->container->get('pagination');
				
				// Make sure $start is set to the last page if it exceeds the amount
				$start = $pagination->validate_start($start, $messages_per_page, $total_messages);

				$pagination->generate_template_pagination($u_pagination, 'pagination', 'start', $total_messages, $messages_per_page, $start);
			
				// Output global variables to template
				$this->template->assign_vars(array(
					'S_BATCH_OPTIONS'		=> $batch_options,
					'S_CHAT_IN_ARCHIVE'		=> true,
					'S_CHAT_MAX_CHARS'		=> $this->config['chat_max_chars'],
					
					'S_SELECT_SORT_DIR'		=> str_replace('<select', '<select class="chat-inputbox"', $s_sort_dir),
					'S_SELECT_SORT_KEY'		=> str_replace('<select', '<select class="chat-inputbox"', $s_sort_key),
					'S_SELECT_SORT_DAYS'	=> str_replace('<select', '<select class="chat-inputbox"', $s_limit_days),
				
					'U_ACTION'			=> $u_archive,
					'U_CHAT_JSCRIPT'	=> append_sid($chat->web_path . $chat->path . 'jchat_scripts.' . $this->php_ext, array(
						'v'					=> $this->config['chat_version'],
						'assets_version'	=> $this->config['assets_version']
					))
				));
				
				// Only show the room tabs if exists more than one
				if(sizeof($room_ary) > 1)
				{
					foreach($room_ary as $room_key => $row)
					{
						$url_params = array('mode' => 'archive');
						
						if($room_key != CHAT_GUEST_ROOM)
						{
							$url_params['room'] = $room_key;
						}
						
						$this->template->assign_block_vars('roomtab', array(
							'S_ACTIVE'		=> ($room_key == $current_room) ? true : false,
							'S_TITLE'		=> (isset($this->user->lang[$row['room_title']]) ? $this->user->lang[$row['room_title']] : $row['room_title']),
							'U_ACTION'		=> $this->helper->route('canidev_chat_controller', $url_params),
						));
					}
				}
				
				$this->template->assign_block_vars('navlinks', array(
					'FORUM_NAME'	=> $this->user->lang['CHAT_ARCHIVE'],
					'U_VIEW_FORUM'	=> $u_archive,
				));	
				
				return $this->helper->render('archive_body.html', $this->user->lang['CHAT_ARCHIVE']);
			break;
			
			default:
				$chat->set_custom_page(true);
				
				if(!$this->config['chat_page_enabled'] && !$is_embed)
				{
					redirect(append_sid($this->root_path . 'index.' . $this->php_ext));
				}
				
				$this->template->assign_vars(array(
					'S_CHAT_EMBEDMODE'	=> $is_embed,
					'S_CHAT_NOTITLE'	=> ($is_embed && $no_title) ? true : false,
				));
				
				$this->template->assign_block_vars('navlinks', array(
					'FORUM_NAME'	=> $this->user->lang['CHAT'],
					'U_VIEW_FORUM'	=> $this->helper->route('canidev_chat_controller'),
				));	

				return $this->helper->render('chat_body.html', $this->user->lang['CHAT']);
			break;
		}
	}
}
