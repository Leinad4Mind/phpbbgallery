<?php
/*
* @package cBB Chat
* @version v1.2.2 29/03/2021
*
* @copyright (c) 2021 CaniDev
* @license https://opensource.org/licenses/gpl-license.php GNU Public License
*/

namespace canidev\chat\libraries;

// @ignore
if(!defined('IN_PHPBB'))
{
	exit;
}

class chat
{
	public $enabled				= false;
	public $custom_page			= null;
	public $disallowed_bbcodes	= array();
	
	public $path			= 'ext/canidev/chat/';
	public $root_path		= '';
	public $time_limit		= 0;
	public $web_path		= '';
	public $phpbb_root_path;
	public $php_ext;
	
	protected $auth;
	protected $cache;
	protected $config;
	protected $container;
	protected $core;
	protected $dispatcher;
	protected $db;
	protected $lang;
	protected $request;
	protected $routing;
	protected $template;
	protected $user;
	
	protected $midnight = false;

	/**
	* Constructor
	*
	* @param \phpbb\auth\auth 						$auth				Authentication object
	* @param \phpbb\cache\driver\driver_interface 	$cache 				Cache instance
	* @param \phpbb\config\config 					$config				Config Object
	* @param ContainerInterface 					$container			Service container interface
	* @param \phpbb\event\dispatcher_interface		$dispatcher			Event dispatcher
	* @param \phpbb\db\driver\driver_interface		$db					DB Object
	* @param \phpbb\language\language 				$language			Language Object
	* @param \phpbb\request\request 				$request			Request object
	* @param \phpbb\routing\helper					$routing			Routing Helper
	* @param \phpbb\template\template				$template     		Template object
	* @param \phpbb\user							$user				User object
	* @param string									$root_path			phpBB root path
	* @param string									$php_ext			phpEx
	* @param string									$table_prefix		DB Table Prefix
	*
	* @access public
	*/
	public function __construct(
		\phpbb\auth\auth $auth,
		\phpbb\cache\driver\driver_interface $cache,
		\phpbb\config\config $config,
		\Symfony\Component\DependencyInjection\ContainerInterface $container,
		\phpbb\event\dispatcher_interface $dispatcher,
		\phpbb\db\driver\driver_interface $db,
		\phpbb\language\language $language,
		\phpbb\request\request $request,
		\phpbb\routing\helper $routing,
		\phpbb\template\template $template,
		\phpbb\user $user,
		$root_path,
		$php_ext,
		$table_prefix)
	{
		$this->auth			= $auth;
		$this->cache		= $cache;
		$this->config 		= $config;
		$this->container	= $container;
		$this->core			= \canidev\core\lib::get_instance($container);
		$this->dispatcher	= $dispatcher;
		$this->db			= $db;
		$this->lang			= $language;
		$this->request		= $request;
		$this->routing 		= $routing;
		$this->template		= \canidev\core\template::get_instance($container);
		$this->user			= $user;
		
		$this->phpbb_root_path	= $root_path;
		$this->php_ext			= $php_ext;
		$this->time_limit		= (!empty($this->config['chat_timeout']) ? (time() - (intval($this->config['chat_timeout']) * 60)) : false);

		$this->root_path	= $this->phpbb_root_path . $this->path;
		$this->web_path		= $this->phpbb_root_path;

		$this->enabled = true;
		
		include($this->root_path . 'libraries/constants.' . $this->php_ext);
	}
	
	public function load()
	{
		$this->web_path = generate_board_url() . '/';
		
		// Fix problem in Windows Servers
		$this->web_path = str_replace('\\/', '', $this->web_path);
		
		if($this->user->data['is_bot'] || !$this->auth->acl_get('u_chat_view') || defined('ADMIN_START'))
		{
			$this->enabled = false;
		}

		if($this->enabled && $this->config['chat_page_enabled'])
		{
			$this->template->assign_vars(array(
				'U_CHAT'	=> $this->routing->route('canidev_chat_controller'),
			));
		}
		
		if(!$this->enabled && !$this->request->is_ajax())
		{
			return false;
		}
		
		if($this->request->is_ajax() && $this->request->variable('ajaxModule', '') == 'chat' && !defined('IN_CHAT_AJAX'))
		{
			define('IN_CHAT_AJAX', true);
			$this->container->get('canidev.chat.action_manager')->run();
			exit_handler();
		}
	}

	public function set_custom_page($id)
	{
		$this->custom_page = $id;
	}
	
	public function display()
	{
		if(defined('IN_ERROR_HANDLER') || defined('IN_CHAT_AJAX'))
		{
			$this->enabled = false;
		}

		if(!$this->enabled)
		{
			return;
		}

		$user_key	= $this->request->variable($this->config['cookie_name'] . '_chat_key', 0, false, \phpbb\request\request_interface::COOKIE);
		$lastcheck	= $this->request->variable($this->config['cookie_name'] . '_chat_lastcheck', 0, false, \phpbb\request\request_interface::COOKIE);
		
		// Update session of user when navigate into forum with chat connected
		$time_limit = time() - ((int)$this->config['chat_refresh'] * 2);

		$service_options = array(
			'maxChars' 	=> (int)$this->config['chat_max_chars'],
			'mode' 		=> $this->custom_page,
		);

		if($this->custom_page === null && $user_key && $lastcheck && $time_limit < $lastcheck)
		{
			$sql = 'UPDATE ' . CHAT_USERS_TABLE . '
				SET user_lastjoin = ' . time() . '
				WHERE user_id = ' . $this->user->data['user_id'] . '
				AND user_key = ' . $user_key . '
				AND user_online = 1';
			$this->db->sql_query($sql);
		}

		if($this->custom_page === null)
		{
			$current_page	= (($this->user->page['page_dir']) ? $this->user->page['page_dir'] . '/' : '') . $this->user->page['page_name'];
			
			if(strpos($current_page, 'app.' . $this->php_ext) === 0 && $this->config['enable_mod_rewrite'])
			{
				$current_page = str_replace('app.' . $this->php_ext . '/', '', $current_page);
			}
			
			$page_data 		= $this->obtain_pages($current_page);
			$forum_id 		= $this->request->variable('f', 0);
			$this->enabled	= (!empty($page_data) ? true : false);
			
			if(!empty($page_data['page_data']['forum_ids']) && !in_array($forum_id, $page_data['page_data']['forum_ids']))
			{
				$this->enabled = false;
			}
		}
		
		if($this->enabled && $this->custom_page != 'archive')
		{
			// Get default room
			$default_room	= CHAT_GUEST_ROOM;
			$room_ary 		= $this->obtain_rooms();
			
			foreach($room_ary as $room_key => $row)
			{
				// If is set a linked forum, use it
				if($this->custom_page === null && isset($row['room_data']['linked_forums']) && in_array($forum_id, $row['room_data']['linked_forums']))
				{
					$default_room = $room_key;
					break;
				}
				
				// Check for linked group and allow to continue search for linked forum
				if(isset($row['room_data']['linked_groups']) && $default_room == CHAT_GUEST_ROOM && $this->core->group_auth($row['room_data']['linked_groups']))
				{
					$default_room = $room_key;
				}
			}

			$texts 			= $this->obtain_texts();
			$bbcode_status	= ($this->config['allow_bbcode'] && $this->config['chat_allow_bbcode']) ? true : false;
			$smilies_status	= ($this->config['allow_smilies']) ? true : false;

			$service_options += array(
				'autoconnect'	=> (bool)$this->config['chat_autoconnect'],
				'defaultRoom' 	=> $default_room,
				'direction' 	=> $this->config['chat_direction'],
				'guestRoom' 	=> CHAT_GUEST_ROOM,
				'floodTime' 	=> ($this->config['chat_flood_time'] && !$this->auth->acl_get('u_chat_ignoreflood')) ? $this->config['chat_flood_time'] * 1000 : 0,
				'height' 		=> ($this->custom_page === null && $page_data['chat_height']) ? (int)$page_data['chat_height'] : (int)$this->config['chat_height'],
				'hidePopup'		=> (bool)$this->config['chat_hide_popup'],
				'maxRows' 		=> (int)$this->config['chat_max_rows'],
				'page' 			=> ($this->custom_page !== null) ? 'custom' : $page_data['page_alias'],
				'position' 		=> ($this->custom_page !== null) ? '' : $page_data['chat_position'],
				'refresh' 		=> $this->config['chat_refresh'] * 1000,
				'soundPath' 	=> $this->web_path . $this->path . 'sounds/',
			);

			if($this->auth->acl_get('u_chat_post'))
			{
				$editor = \canidev\core\editor::get_instance($this->container);

				$editor->do_actions();

				$editor_ary = $editor->build(
					array(
						'bbcodeMenu'			=> ($this->config['chat_bbcode_format'] == 'select'),
						'name'					=> 'ic_message',
						'emoticonContainer'		=> '.chat-smiley-box > div',
						'plugins'				=> 'chat',
						'rows'					=> 3,
						'type'					=> 'basic',
						'toolbarContainer' 		=> '.chat-bbcode-box',
						'toolbarExclude' 		=> array_merge($this->get_disallowed_bbcodes(), array(
							'color' // Don't put color inside bbcode toolbar
						)),
					),
					true
				);

				$editor->smilies_to_template();

				$this->template->assign_vars(array(
					'S_CHAT_CAN_POST' 	=> true,
					'S_CHAT_EDITOR'		=> $editor_ary['template'],
				));
			}

			$this->template->assign_vars(array(
				'S_CHAT_ENABLED'		=> true,
				'S_CHAT_RULES'			=> (!empty($texts[CHAT_TEXT_RULE]) ? true : false),

				'S_CHAT_ALLOW_PM'			=> $this->config['chat_allow_pm'],
				'S_CHAT_CAN_CLEAR'			=> $this->auth->acl_get('m_chat_delete'),
				'S_CHAT_DIRECTION'			=> $this->config['chat_direction'],
				'S_CHAT_MAX_FONT_SIZE'		=> (int)$this->config['max_post_font_size'],
				
				'S_CHAT_BBCODE_ALLOWED'		=> $bbcode_status,
				'S_CHAT_BBCODE_COLOR'		=> ($bbcode_status && !in_array('color', $this->get_disallowed_bbcodes())) ? true : false,
				'S_CHAT_SMILIES_ALLOWED'	=> $smilies_status,
				'S_CHAT_SOUND_ENABLED'		=> $this->config['chat_sound'],

				'S_CHAT_HIDDEN_FIELDS'	=> build_hidden_fields(array(
					'last_update'	=> 0,
					'time_mark'		=> 0,
				)),

				'U_CHAT_ARCHIVE'	=> ($this->auth->acl_get('u_chat_archive') ? $this->routing->route('canidev_chat_controller', array('mode' => 'archive')) : ''),
			));
			
			// Generate notices and tips
			foreach(array(CHAT_TEXT_NOTICE => 'notice',	CHAT_TEXT_TIP => 'tip') as $type => $id)
			{
				if(!empty($texts[$type]))
				{
					$tpl_id = 'S_' .strtoupper($id);

					foreach($texts[$type] as $text)
					{
						$this->template->assign_block_vars("chat_$id", array($tpl_id => $text));
					}
				}
			}
		}
		
		if($this->enabled || $this->custom_page !== null)
		{
			$this->template->assign_json_var('S_CHAT_OPTIONS', $service_options);

			\canidev\core\lib::get_instance($this->container)->set_js_lang(array(
				'CHAT_FLOOD_WAIT'
			));

			// Assets
			$this->template->append_asset('css', '@canidev_chat/../theme/chat.css');
			
			$this->template->append_asset('js', array(
				'@canidev_chat/js/jchat-options.js',
				'@canidev_chat/js/jchat.min.js'
			));
		}
	}

	public function get_disallowed_bbcodes()
	{
		if($this->config['chat_disallowed_bbcode'])
		{
			$data_cache = $this->cache->get('_chat_options');
		
			if($data_cache === false || !isset($data_cache['disallowed_bbcodes']))
			{
				$data_cache = ($data_cache === false) ? array() : $data_cache;
				$data_cache['disallowed_bbcodes'] = array();
				
				// Default BBcodes
				$bbcode_ary = array(
					'b'			=> BBCODE_ID_B,
					'i'			=> BBCODE_ID_I,
					'u'			=> BBCODE_ID_U,
					'quote'		=> BBCODE_ID_QUOTE,
					'code'		=> BBCODE_ID_CODE,
					'list'		=> BBCODE_ID_LIST,
					'list=1'	=> BBCODE_ID_LIST,
					'*'			=> BBCODE_ID_LIST,
					'img'		=> BBCODE_ID_IMG,
					'url'		=> BBCODE_ID_URL,
					'size'		=> BBCODE_ID_SIZE,
				);

				// Custom BBcodes
				$sql = 'SELECT bbcode_id, bbcode_tag
					FROM ' . BBCODES_TABLE . '
					WHERE display_on_posting = 1';
				$result = $this->db->sql_query($sql);
				while($row = $this->db->sql_fetchrow($result))
				{
					$bbcode_ary[$row['bbcode_tag']] = (int)$row['bbcode_id'];
				}
				$this->db->sql_freeresult($result);

				$bitfield = new \bitfield($this->config['chat_disallowed_bbcode']);
				$disallowed_ids = $bitfield->get_all_set();

				foreach($bbcode_ary as $tag => $id)
				{
					if(in_array($id, $disallowed_ids))
					{
						$data_cache['disallowed_bbcodes'][] = $tag;
					}
				}

				$this->cache->put('_chat_options', $data_cache);

				unset($bitfield);
			}

			return $data_cache['disallowed_bbcodes'];
		}

		return array();
	}
	
	public function obtain_pages($current_page = false)
	{
		$data_cache = $this->cache->get('_chat_options');
		
		if($data_cache === false || !isset($data_cache['pages']))
		{
			$data_cache = ($data_cache === false) ? array() : $data_cache;
			$data_cache['pages'] = array();

			$sql = 'SELECT *
				FROM ' . CHAT_PAGES_TABLE;
			$result = $this->db->sql_query($sql);
			while($row = $this->db->sql_fetchrow($result))
			{
				$row_id = $row['page_path'] . $row['page_filename'];
				
				$row['page_data'] = ($row['page_data']) ? @unserialize($row['page_data']) : array();
				
				$data_cache['pages'][$row_id] = $row;
			}
			$this->db->sql_freeresult($result);
			
			$this->cache->put('_chat_options', $data_cache);
		}
		
		if($current_page)
		{
			return (isset($data_cache['pages'][$current_page]) ? $data_cache['pages'][$current_page] : array());
		}
		
		return $data_cache['pages'];
	}
	
	public function obtain_rooms()
	{
		$data_cache = $this->cache->get('_chat_options');
		
		if($data_cache === false || !isset($data_cache['rooms']))
		{
			$data_cache = ($data_cache === false) ? array() : $data_cache;
			$data_cache['rooms'] = array();

			$data_keys	= array('groups', 'users', 'linked_forums');

			$sql = 'SELECT *
				FROM ' . CHAT_ROOMS_TABLE . '
				ORDER BY room_order';
			$result = $this->db->sql_query($sql);
			while($row = $this->db->sql_fetchrow($result))
			{
				$row['room_data'] = @unserialize($row['room_data']);
				
				foreach($data_keys as $key)
				{
					if(!isset($row['room_data'][$key]))
					{
						$row['room_data'][$key] = array();
					}
				}
				
				$data_cache['rooms'][$row['room_key']] = $row;
			}
			$this->db->sql_freeresult($result);
			
			$this->cache->put('_chat_options', $data_cache);
		}

		return $data_cache['rooms'];
	}
	
	public function obtain_texts($output_type = false, $translate = true)
	{
		$data_cache = $this->cache->get('_chat_options');

		if($data_cache === false || !isset($data_cache['texts']))
		{
			$data_cache = ($data_cache === false) ? array() : $data_cache;
			$data_cache['texts'] = array();
			
			$sql = 'SELECT text_type, text_content, bbcode_uid, bbcode_bitfield
				FROM ' . CHAT_TEXTS_TABLE . '
				ORDER BY text_order ASC';
			$result = $this->db->sql_query($sql);
			while($row = $this->db->sql_fetchrow($result))
			{
				$text_type = (int)$row['text_type'];
				
				if(!isset($data_cache['texts'][$text_type]))
				{
					$data_cache['texts'][$text_type] = array();
				}
				
				$data_cache['texts'][$text_type][] = $row;
			}
			$this->db->sql_freeresult($result);
				
			foreach($data_cache['texts'] as $text_type => $rows)
			{
				foreach($rows as $row_id => $row)
				{
					/*
					 * bbcode_bitfield is empty in some cases in phpBB 3.2 so, check if the text have some [/ to detect the presence of bbcode.
					 * If no bbcode, we decode the text to allow HTML tags.
					*/
					if(strpos($row['text_content'], '[/') !== false)
					{
						$parse_flags = ($row['bbcode_bitfield'] ? OPTION_FLAG_BBCODE : 0) | OPTION_FLAG_SMILIES;
						$row['text_content'] = generate_text_for_display($row['text_content'], $row['bbcode_uid'], $row['bbcode_bitfield'], $parse_flags, true);
					}
					else
					{
						$row['text_content'] = htmlspecialchars_decode($row['text_content']);
						$row['text_content'] = censor_text($row['text_content']);
					}
					
					// Return and save simple html output
					$data_cache['texts'][$text_type][$row_id] = $row['text_content'];
				}
			}
			
			$this->cache->put('_chat_options', $data_cache);
		}
		
		foreach($data_cache['texts'] as $text_type => $rows)
		{
			foreach($rows as $row_id => $text)
			{
				if($translate && strpos($text, '{') !== false)
				{
					$this->parse_lang_variables($text);
				}

				//$text = smiley_text($text);
				
				$data_cache['texts'][$text_type][$row_id] = $text;
			}
		}
		
		if($output_type)
		{
			return (isset($data_cache['texts'][$output_type]) ? $data_cache['texts'][$output_type] : array());
		}

		return $data_cache['texts'];
	}
	
	public function format_date($timestamp)
	{
		if(!$this->midnight)
		{
			$this->midnight = $this->user->create_datetime();
			$this->midnight->setTime(0, 0, 0);

			$this->midnight = $this->midnight->getTimestamp();
		}
	
		if($timestamp <= $this->midnight + 2 * 86400)
		{
			$day = false;

			if($timestamp > $this->midnight + 86400)
			{
				$day = 'TOMORROW';
			}
			else if($timestamp > $this->midnight)
			{
				$day = 'TODAY';
			}
			else if($timestamp > $this->midnight - 86400)
			{
				$day = 'YESTERDAY';
			}

			if($day !== false)
			{
				return $this->lang->lang(array('datetime', $day)) . ', ' . $this->user->format_date($timestamp, 'H:i');
			}
		}
		
		return $this->user->format_date($timestamp, false, true);
	}
	
	public function parse_lang_variables(&$text)
	{
		$text = preg_replace_callback('#\{L_([A-Z0-9_\-]+)\}#', function($matches) {
			return $this->lang->is_set($matches[1]) ? $this->lang->lang($matches[1]) : '';
		}, $text);
	}
	
	public function update_groups($user_id_ary)
	{
		$user_id_ary 	= is_array($user_id_ary) ? $user_id_ary : array($user_id_ary);
		$users_ary		= array();
		
		$sql = 'SELECT user_id, group_id
			FROM ' . USER_GROUP_TABLE . '
			WHERE user_pending = 0
			AND ' . $this->db->sql_in_set('user_id', $user_id_ary);
		$result = $this->db->sql_query($sql);
		while($row = $this->db->sql_fetchrow($result))
		{
			$user_id = (int)$row['user_id'];
			
			if(!isset($users_ary[$user_id]))
			{
				$users_ary[$user_id] = array();
			}
			
			$users_ary[$user_id][] = (int)$row['group_id'];
		}
		$this->db->sql_freeresult($result);
		
		foreach($users_ary as $user_id => $group_ids_ary)
		{
			$sql = 'UPDATE ' . CHAT_USERS_TABLE . "
				SET user_groups = '" . implode(',', $group_ids_ary) . "'
				WHERE user_id = $user_id";
			$this->db->sql_query($sql);
		}
	}
}
