<?php
/**
 * @package cBB Chat
 * @version 1.2.7 07/03/2025
 *
 * @copyright (c) 2025 CaniDev
 * @license https://creativecommons.org/licenses/by-nc/4.0/
 */

namespace canidev\chat\controller;

use Symfony\Component\DependencyInjection\ContainerInterface;
use canidev\chat\libraries\constants;

/**
 * Main controller
 */
class main_controller
{
	protected $auth;
	protected $chat;
	protected $config;
	protected $container;
	protected $core;
	protected $db;
	protected $helper;
	protected $language;
	protected $log;
	protected $request;
	protected $template;
	protected $user;
	
	protected $root_path;
	protected $php_ext;
	protected $tables;

	/**
	 * Constructor
	 *
	 * @param \phpbb\auth\auth 						$auth			Authentication object
	 * @param \canidev\chat\libraries\chat 			$chat			Chat Object
	 * @param \phpbb\config\config 					$config			Config Object
	 * @param ContainerInterface 					$container		Service container interface
	 * @param \canidev\core\lib 					$core 			Core Object
	 * @param \phpbb\db\driver\driver_interface		$db				DB Object
	 * @param \phpbb\controller\helper				$helper       	Controller helper object
	 * @param \phpbb\language\language 				$language		Language object
	 * @param \phpbb\log\log						$log			Log object
	 * @param \phpbb\request\request 				$request		Request object
	 * @param \phpbb\template\template				$template     	Template object
	 * @param \phpbb\user							$user			User object
	 * @param string								$root_path		phpBB root path
	 * @param string								$php_ext		phpEx
	 * @param array 								$tables 		Chat DB Tables
	 *
	 * @access public
	 */
	public function __construct(
		\phpbb\auth\auth $auth,
		\canidev\chat\libraries\chat $chat,
		\phpbb\config\config $config,
		ContainerInterface $container,
		\canidev\core\lib $core,
		\phpbb\db\driver\driver_interface $db,
		\phpbb\controller\helper $helper,
		\phpbb\language\language $language,
		\phpbb\log\log $log,
		\phpbb\request\request $request,
		\phpbb\template\template $template,
		\phpbb\user $user,
		$root_path,
		$php_ext,
		$tables)
	{
		$this->auth			= $auth;
		$this->chat			= $chat;
		$this->config		= $config;
		$this->container	= $container;
		$this->core			= $core;
		$this->db			= $db;
		$this->helper 		= $helper;
		$this->language		= $language;
		$this->log			= $log;
		$this->request		= $request;
		$this->template 	= $template;
		$this->user			= $user;
		
		$this->root_path	= $root_path;
		$this->php_ext		= $php_ext;
		$this->tables 		= $tables;
	}

	/**
	 * Display the chat
	 * @access public
	 */
	public function display()
	{
		$mode		= $this->request->variable('mode', 'chat');
		$is_embed 	= $this->request->variable('embed', false);
		$no_title	= $this->request->variable('notitle', false);
		
		$messages_per_page = 50;
		
		if(empty($this->chat->enabled) && !$is_embed)
		{
			redirect(append_sid($this->root_path . 'index.' . $this->php_ext));
		}

		$this->chat->set_custom_page($mode);
		
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
				$row_id_list	= $this->request->variable('row_id_list', [0]);
				
				$action 	= $this->request->variable('action', '');
				$start 		= $this->request->variable('start', 0);
				
				// Obtain rooms
				$room_ary		= $this->chat->obtain_rooms();
				$current_room	= $this->request->variable('room', constants::GUEST_ROOM);
				
				$u_archive	= $this->helper->route('canidev_chat_controller', [
					'mode'	=> 'archive',
					'room'	=> $current_room
				]);
				
				// Filter Rooms
				foreach($room_ary as $room_key => $row)
				{
					if($room_key != constants::GUEST_ROOM &&
						((!$this->core->group_auth($row['room_data']['groups']) && !isset($row['room_data']['users'][$this->user->data['user_id']]))
						|| !$row['room_enabled']))
					{
						unset($room_ary[$room_key]);
					}
				}

				if(!isset($room_ary[$current_room]))
				{
					redirect($u_archive);
				}
				
				$batch_actions = [
					'delete_selected'	=> ['DELETE', 'm_chat_delete', true],
					'move_selected'		=> ['CHAT_MOVE', 'm_chat_edit', (sizeof($room_ary) > 1)],
				];
				
				switch($action)
				{
					case 'delete_selected':
						if(!$this->auth->acl_get('m_chat_delete'))
						{
							trigger_error('NOT_AUTHORISED', E_USER_WARNING);
						}
						
						if(sizeof($row_id_list))
						{
							$sql = 'DELETE FROM ' . $this->tables['messages'] . '
								WHERE ' . $this->db->sql_in_set('message_id', $row_id_list);
							$this->db->sql_query($sql);
							
							$this->log->add(
								'mod',
								$this->user->data['user_id'],
								$this->user->ip,
								'LOG_CHAT_MESSAGES_REMOVED',
								time(),
								[
									$this->language->lang($room_ary[$current_room]['room_title']),
									sizeof($row_id_list),
								]
							);
						}
					break;
					
					case 'move_selected':
						if(!$this->auth->acl_get('m_chat_edit'))
						{
							trigger_error('NOT_AUTHORISED', E_USER_WARNING);
						}
						
						$to_room_id = $this->request->variable('to_room_id', 0);
						
						$s_hidden_fields = build_hidden_fields([
							'row_id_list'	=> $row_id_list,
							'room'			=> $current_room,
							'action'		=> 'move_selected',
						]);
						
						if(confirm_box(true))
						{
							if($to_room_id && sizeof($row_id_list))
							{
								$sql = 'UPDATE ' . $this->tables['messages'] . '
									SET dest_key = ' . $to_room_id . '
									WHERE ' . $this->db->sql_in_set('message_id', $row_id_list);
								$this->db->sql_query($sql);
								
								$this->log->add(
									'mod',
									$this->user->data['user_id'],
									$this->user->ip,
									'LOG_CHAT_MESSAGES_MOVED',
									time(),
									[
										$this->language->lang($room_ary[$current_room]['room_title']),
										$this->language->lang($room_ary[$to_room_id]['room_title']),
										sizeof($row_id_list),
									]
								);
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
								$room_title = $this->language->lang($room_title);
								
								$options_str .= '<option value="' . $room_key . '">' . $room_title . '</option>';
							}

							$this->template->assign_vars([
								'S_ROOM_OPTIONS'	=> $options_str,
							]);

							confirm_box(false, 'CHAT_MOVE', $s_hidden_fields, 'chat_move.html');
						}
					break;
				}

				$action_manager = $this->container->get('canidev.chat.action_manager');
				$limit_days 	= [0 => $this->language->lang('ALL_MESSAGES'), 1 => $this->language->lang('1_DAY'), 7 => $this->language->lang('7_DAYS'), 14 => $this->language->lang('2_WEEKS'), 30 => $this->language->lang('1_MONTH'), 90 => $this->language->lang('3_MONTHS'), 180 => $this->language->lang('6_MONTHS'), 365 => $this->language->lang('1_YEAR')];

				$sort_by_text	= ['t' => $this->language->lang('POST_TIME')];
				$sort_by_sql	= ['t' => 'cm.message_time'];

				$s_limit_days = $s_sort_key = $s_sort_dir = $u_sort_param = '';
				gen_sort_selects($limit_days, $sort_by_text, $sort_days, $sort_key, $sort_dir, $s_limit_days, $s_sort_key, $s_sort_dir, $u_sort_param, $default_sort_days, $default_sort_key, $default_sort_dir);
				
				$sql_sort_order = 'ORDER BY ' . $sort_by_sql[$sort_key] . ' ' . (($sort_dir == 'd') ? 'DESC' : 'ASC');
				
				$min_post_time = ($sort_days) ? time() - ($sort_days * 86400) : 0;
				
				// Get total messages
				$sql = 'SELECT COUNT(message_id) AS total
					FROM ' . $this->tables['messages'] . '
					WHERE dest_key = ' . $current_room . "
					AND message_time >= $min_post_time";
				$result = $this->db->sql_query($sql);
				$total_messages = (int)$this->db->sql_fetchfield('total');
				$this->db->sql_freeresult($result);
			
				$sql = 'SELECT cm.*, u.username, u.user_colour,
						u.user_avatar, u.user_avatar_type, u.user_avatar_width, u.user_avatar_height
					FROM ' . $this->tables['messages'] . ' cm
						LEFT JOIN ' . USERS_TABLE . ' u ON(u.user_id = cm.poster_id)
					WHERE cm.dest_key = ' . $current_room . "
					AND message_time >= $min_post_time
					$sql_sort_order";
				$result = $this->db->sql_query_limit($sql, $messages_per_page, $start);
				while($row = $this->db->sql_fetchrow($result))
				{
					$parse_flags 	= OPTION_FLAG_BBCODE | OPTION_FLAG_SMILIES;
					$row_avatar 	= '';

					$message_row = [
						'S_CLASS'			=> 'chat-row',
						'S_ID'				=> $row['message_id'],
						'S_AUTHOR_FULL'		=> ($row['poster_id'] == ANONYMOUS) ? $row['poster_username'] : get_username_string('full', $row['poster_id'], $row['username'], $row['user_colour']),
						'S_TEXT'			=> generate_text_for_display($row['message_text'], $row['bbcode_uid'], $row['bbcode_bitfield'], $parse_flags, true),
						'S_DATE'			=> $this->chat->format_date($row['message_time']),
						
						'CAN_DELETE'		=> $action_manager->auth('delete', $row),
						'CAN_EDIT'			=> $action_manager->auth('edit', $row),
						'CAN_MOVE'			=> (sizeof($room_ary) > 1 && $action_manager->auth('-m_chat_edit')),
						'CAN_VIEW_WHOIS'	=> $this->auth->acl_get('a_'),
					];
					
					if($this->config['chat_show_avatars'])
					{
						if($row['poster_id'] != ANONYMOUS)
						{
							$row_avatar = phpbb_get_user_avatar($row);
						}

						$message_row += [
							'S_AUTHOR_AVATAR'	=> $row_avatar,
							'S_SHOW_AVATAR' 	=> true,
						];
					}

					switch($this->config['chat_row_align'])
					{
						case 'left':
						case 'right':
						case 'zigzag':
							$message_row['S_CLASS'] .= ' chat-align-' . $this->config['chat_row_align'];
						break;

						case 'meother':
							$message_row['S_CLASS'] .= ($row['poster_key'] == $action_manager->get_user_key()) ? ' chat-align-right' : ' chat-align-left';
						break;
					}

					if($this->config['chat_row_format'] == 'bubble')
					{
						$message_row['S_CLASS'] .= ' chat-format-bubble';
					}

					$this->template->assign_block_vars('message', $message_row);
				}
				$this->db->sql_freeresult($result);
				
				$pagination_params = ['mode' => 'archive'];
				
				if($current_room != constants::GUEST_ROOM)
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
					
					$batch_options .= '<option value="' . $key . '">' . $this->language->lang($row[0]) . '</option>';
				}

				// Build Pagination
				$u_pagination	= $this->helper->route('canidev_chat_controller', $pagination_params);
				$pagination 	= $this->container->get('pagination');
				
				// Make sure $start is set to the last page if it exceeds the amount
				$start = $pagination->validate_start($start, $messages_per_page, $total_messages);

				$pagination->generate_template_pagination($u_pagination, 'pagination', 'start', $total_messages, $messages_per_page, $start);
			
				// Output global variables to template
				$this->template->assign_vars([
					'S_BATCH_OPTIONS'		=> $batch_options,
					'S_CHAT_IN_ARCHIVE'		=> true,
					
					'S_SELECT_SORT_DIR'		=> str_replace('<select', '<select class="cbb-inputbox"', $s_sort_dir),
					'S_SELECT_SORT_KEY'		=> str_replace('<select', '<select class="cbb-inputbox"', $s_sort_key),
					'S_SELECT_SORT_DAYS'	=> str_replace('<select', '<select class="cbb-inputbox"', $s_limit_days),
				
					'U_ACTION'			=> $u_archive,
				]);
				
				// Only show the room tabs if exists more than one
				if(sizeof($room_ary) > 1)
				{
					foreach($room_ary as $room_key => $row)
					{
						$url_params = ['mode' => 'archive'];
						
						if($room_key != constants::GUEST_ROOM)
						{
							$url_params['room'] = $room_key;
						}
						
						$this->template->assign_block_vars('roomtab', [
							'S_ACTIVE'		=> ($room_key == $current_room) ? true : false,
							'S_TITLE'		=> $this->language->lang($row['room_title']),
							'U_ACTION'		=> $this->helper->route('canidev_chat_controller', $url_params),
						]);
					}
				}
				
				$this->template->assign_block_vars('navlinks', [
					'FORUM_NAME'	=> $this->language->lang('CHAT_ARCHIVE'),
					'U_VIEW_FORUM'	=> $u_archive,
				]);	
				
				return $this->helper->render('archive_body.html', $this->language->lang('CHAT_ARCHIVE'));
			
			case 'chat':
			default:
				if(!$this->config['chat_page_enabled'] && !$is_embed)
				{
					redirect(append_sid($this->root_path . 'index.' . $this->php_ext));
				}
				
				$this->template->assign_vars([
					'S_CHAT_EMBEDMODE'	=> $is_embed,
					'S_CHAT_NOTITLE'	=> ($is_embed && $no_title) ? true : false,
				]);
				
				$this->template->assign_block_vars('navlinks', [
					'FORUM_NAME'	=> $this->language->lang('CHAT'),
					'U_VIEW_FORUM'	=> $this->helper->route('canidev_chat_controller'),
				]);

				return $this->helper->render('chat_body.html', $this->language->lang('CHAT'));
		}
	}
}
