<?php
/*
* @package cBB Chat
* @version v1.2.0 02/03/2019
*
* @copyright (c) 2019 CaniDev
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
	protected $helper;
	protected $lang;
	protected $request;
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
	* @param \phpbb\controller\helper				$helper       		Controller helper object
	* @param \phpbb\language\language 				$language			Language Object
	* @param \phpbb\request\request 				$request			Request object
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
		\phpbb\controller\helper $helper,
		\phpbb\language\language $language,
		\phpbb\request\request $request,
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
		$this->helper		= $helper;
		$this->lang			= $language;
		$this->request		= $request;
		$this->template		= \canidev\core\template::get_instance($container);
		$this->user			= $user;
		
		$this->phpbb_root_path	= $root_path;
		$this->php_ext			= $php_ext;
		$this->time_limit		= (!empty($this->config['chat_timeout']) ? (time() - (intval($this->config['chat_timeout']) * 60)) : false);

		$this->root_path	= $this->phpbb_root_path . $this->path;
		$this->web_path		= $this->phpbb_root_path;

		$this->enabled = true;
		
		if($this->config['chat_disallowed_bbcode'])
		{
			$bitfield = new \bitfield($this->config['chat_disallowed_bbcode']);
			$this->disallowed_bbcodes = $bitfield->get_all_set();

			unset($bitfield);
		}
		
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
				'U_CHAT'	=> $this->helper->route('canidev_chat_controller'),
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
		if($this->enabled && !defined('IN_ERROR_HANDLER') && !defined('IN_CHAT_AJAX'))
		{
			$user_key		= $this->request->variable($this->config['cookie_name'] . '_chat_key', 0, false, \phpbb\request\request_interface::COOKIE);
			$lastcheck		= $this->request->variable($this->config['cookie_name'] . '_chat_lastcheck', 0, false, \phpbb\request\request_interface::COOKIE);
			$default_room	= CHAT_GUEST_ROOM;
			
			// Update session of user when navigate into forum with chat connected
			$time_limit = time() - ((int)$this->config['chat_refresh'] * 2);

			if($this->enabled && $this->custom_page === null && $user_key && $lastcheck && $time_limit < $lastcheck)
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
				$this->enabled	= (!empty($page_data) ? true : false);
				$forum_id 		= $this->request->variable('f', 0);
				
				if(!empty($page_data['page_data']['forum_ids']) && !in_array($forum_id, $page_data['page_data']['forum_ids']))
				{
					$this->enabled = false;
				}
				else
				{
					// Get default room
					$room_ary = $this->obtain_rooms();
					
					foreach($room_ary as $room_key => $row)
					{
						// If is set a linked forum, use it
						if(isset($row['room_data']['linked_forums']) && in_array($forum_id, $row['room_data']['linked_forums']))
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
				}
			}
			
			if($this->enabled && $this->custom_page != 'archive')
			{
				$this->user->add_lang('posting');

				$texts 			= $this->obtain_texts();
				$bbcode_status	= ($this->config['allow_bbcode'] && $this->config['chat_allow_bbcode']) ? true : false;
				$smilies_status	= ($this->config['allow_smilies']) ? true : false;

				// Assign to template
				$this->template->assign_vars(array(
					'S_CHAT_ENABLED'		=> true,
					'S_CHAT_RULES'			=> (!empty($texts[CHAT_TEXT_RULE]) ? true : false),

					'S_CHAT_ALLOW_PM'			=> $this->config['chat_allow_pm'],
					'S_CHAT_AUTOCONNECT'		=> $this->config['chat_autoconnect'],
					'S_CHAT_CAN_CLEAR'			=> $this->auth->acl_get('m_chat_delete'),
					'S_CHAT_CAN_POST'			=> $this->auth->acl_get('u_chat_post'),
					'S_CHAT_CURRENT_PAGE'		=> ($this->custom_page !== null) ? 'custom' : $page_data['page_alias'],
					'S_CHAT_DEBUG'				=> (defined('DEBUG') && $this->auth->acl_get('a_')) ? true : false,
					'S_CHAT_DEFAULT_ROOM'		=> $default_room,
					'S_CHAT_DIRECTION'			=> $this->config['chat_direction'],
					'S_CHAT_FLOOD_TIME'			=> ($this->config['chat_flood_time'] && !$this->auth->acl_get('u_chat_ignoreflood')) ? $this->config['chat_flood_time'] * 1000 : 0,
					'S_CHAT_GUEST_ROOM'			=> CHAT_GUEST_ROOM,
					'S_CHAT_HEIGHT'				=> ($this->custom_page === null && $page_data['chat_height']) ? $page_data['chat_height'] : $this->config['chat_height'],
					'S_CHAT_MAX_CHARS'			=> $this->config['chat_max_chars'],
					'S_CHAT_MAX_FONT_SIZE'		=> (int)$this->config['max_post_font_size'],
					'S_CHAT_MAX_ROWS'			=> $this->config['chat_max_rows'],
					'S_CHAT_PLAYER_PATH'		=> $this->web_path . $this->path . 'sounds/',
					'S_CHAT_POSITION'			=> (($this->custom_page !== null) ? '' : $page_data['chat_position']),
					'S_CHAT_REFRESH'			=> $this->config['chat_refresh'] * 1000,
					
					'S_CHAT_BBCODE_ALLOWED'		=> $bbcode_status,
					'S_CHAT_BBCODE_COLOR'		=> ($bbcode_status && !in_array(6, $this->disallowed_bbcodes)) ? true : false,
					'S_CHAT_BBCODE_INSELECT'	=> ($this->config['chat_bbcode_format'] == 'select') ? true : false,
					'S_CHAT_SMILIES_ALLOWED'	=> $smilies_status,
					'S_CHAT_SOUND_ENABLED'		=> $this->config['chat_sound'],

					'S_CHAT_HIDDEN_FIELDS'	=> build_hidden_fields(array(
						'last_update'	=> 0,
						'time_mark'		=> 0,
					)),

					'U_CHAT_ARCHIVE'	=> ($this->auth->acl_get('u_chat_archive') ? $this->helper->route('canidev_chat_controller', array('mode' => 'archive')) : ''),
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
				
				// Generate smilies
				if($smilies_status)
				{
					$this->generate_smilies();
				}
				
				// Generate bbcodes
				if($bbcode_status)
				{
					$this->generate_bbcodes();
				}
			}
		}
		
		if($this->enabled || $this->custom_page !== null)
		{
			// Assets
			$this->template->append_asset('css', '@canidev_chat/../theme/chat.css');
			
			$this->template->append_asset('js', array(
				'@canidev_chat/js/jchat-options.js',
				'@canidev_chat/js/jchat.min.js'
			));
		}
	}
	
	private function generate_bbcodes()
	{
		// Default BBcodes
		$default_bbcodes = array(
			'b'			=> array('bbcode_id'	=> BBCODE_ID_B,		'help' => 'BBCODE_B_HELP',			'name' => 'bold',			'icon' => 'fa-bold'),
			'i'			=> array('bbcode_id'	=> BBCODE_ID_I,		'help' => 'BBCODE_I_HELP',			'name' => 'italic',			'icon' => 'fa-italic'),
			'u'			=> array('bbcode_id'	=> BBCODE_ID_U,		'help' => 'BBCODE_U_HELP',			'name' => 'underline',		'icon' => 'fa-underline'),
			'quote'		=> array('bbcode_id'	=> BBCODE_ID_QUOTE,	'help' => 'BBCODE_Q_HELP',			'name' => 'quote',			'icon' => 'fa-quote-right'),
			'code'		=> array('bbcode_id'	=> BBCODE_ID_CODE,	'help' => 'BBCODE_C_HELP',			'name' => 'code',			'icon' => 'fa-code'),
			'list'		=> array('bbcode_id'	=> BBCODE_ID_LIST,	'help' => 'BBCODE_L_HELP',			'name' => 'list',			'icon' => 'fa-list-ul'),
			'list=1'	=> array('bbcode_id'	=> BBCODE_ID_LIST,	'help' => 'BBCODE_O_HELP',			'name' => 'list-numeric',	'icon' => 'fa-list-ol'),
			'*'			=> array('bbcode_id'	=> BBCODE_ID_LIST,	'help' => 'BBCODE_LISTITEM_HELP',	'name' => 'list-item',		'icon' => 'fa-asterisk'),
			'img'		=> array('bbcode_id'	=> BBCODE_ID_IMG,	'help' => 'BBCODE_P_HELP',			'name' => 'img',			'icon' => 'fa-image'),
			'url'		=> array('bbcode_id'	=> BBCODE_ID_URL,	'help' => 'BBCODE_W_HELP',			'name' => 'url',			'icon' => 'fa-link'),
			'flash'		=> array('bbcode_id'	=> BBCODE_ID_FLASH,	'help' => 'BBCODE_D_HELP',			'name' => 'flash',			'icon' => 'fa-film'),
			'size'		=> array('bbcode_id'	=> BBCODE_ID_SIZE,	'help' => '',						'name' => 'size'),
		);

		foreach($default_bbcodes as $bbcode_tag => $row)
		{
			if(!in_array($row['bbcode_id'], $this->disallowed_bbcodes))
			{
				// Compatibility for events
				$row['bbcode_tag']	= $bbcode_tag;
				$template_key		= 'chat_default_tags';

				$item_ary = array(
					'S_HELP'	=> ($row['help']) ? $this->lang->lang($row['help']) : '',
					'S_ICON'	=> $row['icon'],
					'S_TAG'		=> $bbcode_tag,
				);

				/**
				* @event chat.generate_bbcodes
				* @var	string	template_key	Key assigned to the block template
				* @var	array	row				Array with bbcode row
				* @var	array	item_ary		Array with items to push on template
				* @since 1.1.1
				*/
				$vars = array('template_key', 'row', 'item_ary');
				extract($this->dispatcher->trigger_event('chat.generate_bbcodes', compact($vars)));
				
				if(sizeof($item_ary))
				{
					$this->template->assign_block_vars($template_key, $item_ary);
				}
			}
		}
		
		// Custom BBcodes
		$sql_ary = array(
			'SELECT'	=> 'b.*',
			'FROM'		=> array(BBCODES_TABLE => 'b'),
			'WHERE'		=> 'b.display_on_posting = 1',
			'ORDER_BY'	=> 'b.bbcode_tag',
		);
		
		/**
		* @event chat.custom_bbcodes_modify_sql
		* @var	array	sql_ary		The SQL array to get the bbcode data
		* @since 1.1.1
		*/
		$vars = array('sql_ary');
		extract($this->dispatcher->trigger_event('chat.custom_bbcodes_modify_sql', compact($vars)));
		
		$result = $this->db->sql_query($this->db->sql_build_query('SELECT', $sql_ary), 3600);
		while($row = $this->db->sql_fetchrow($result))
		{
			if(in_array($row['bbcode_id'], $this->disallowed_bbcodes))
			{
				continue;
			}

			// If the helpline is defined within the language file, we will use the localised version, else just use the database entry...
			if($this->lang->is_set(strtoupper($row['bbcode_helpline'])))
			{
				$row['bbcode_helpline'] = $this->lang->lang(strtoupper($row['bbcode_helpline']));
			}
			
			$row['bbcode_tag']	= str_replace('=', '', $row['bbcode_tag']);
			$template_key		= 'chat_custom_tags';
			
			$item_ary = array(
				'S_HELP'	=> $row['bbcode_helpline'],
				'S_TAG'		=> $row['bbcode_tag'],
			);
			
			/**
			* @event chat.generate_bbcodes
			* @var	string	template_key	Key assigned to the block template
			* @var	array	row				Array with bbcode row
			* @var	array	item_ary		Array with items to push on template
			* @since 1.1.1
			*/
			$vars = array('template_key', 'row', 'item_ary');
			extract($this->dispatcher->trigger_event('chat.generate_bbcodes', compact($vars)));

			if(sizeof($item_ary))
			{
				$this->template->assign_block_vars($template_key, $item_ary);
			}
		}
		$this->db->sql_freeresult($result);
	}
	
	public function generate_smilies($start = 0)
	{
		$smilies	= array();
		$limit		= 200;

		$sql = 'SELECT *
			FROM ' . SMILIES_TABLE . '
			GROUP BY smiley_url
			ORDER BY smiley_order';
		$result = $this->db->sql_query_limit($sql, $limit, $start, 3600);
		while($row = $this->db->sql_fetchrow($result))
		{
			if(empty($smilies[$row['smiley_url']]))
			{
				$smilies[$row['smiley_url']] = $row;
			}
		}
		$this->db->sql_freeresult($result);

		foreach($smilies as $row)
		{
			$item_ary = array(
				'S_CODE'	=> $row['code'],
				'A_CODE'	=> addslashes($row['code']),
				'S_IMG'		=> $this->web_path . $this->config['smilies_path'] . '/' . $row['smiley_url'],
				'S_WIDTH'	=> $row['smiley_width'],
				'S_HEIGHT'	=> $row['smiley_height'],
				'S_DESC'	=> $row['emotion']
			);

			/**
			* Event to modify the smilies loaded in the chat
			*
			* @event chat.generate_smilies
			* @var	array	row			Array with bbcode row
			* @var	string	item_ary	Array with items to push on template
			* @since 1.1.1
			*/
			$vars = array('row', 'item_ary');
			extract($this->dispatcher->trigger_event('chat.generate_smilies', compact($vars)));

			$this->template->assign_block_vars('chat_smiley', $item_ary);
		}

		if(sizeof($smilies) == $limit)
		{
			$this->template->assign_var('S_SMILEY_PAGE_NEXT', $start + $limit);
		}
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
					}
					
					$row['text_content'] = bbcode_nl2br($row['text_content']);
					
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

				$text = smiley_text($text);
				
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
		
		return $this->user->format_date($timestamp, $this->lang->lang('default_dateformat'));
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
