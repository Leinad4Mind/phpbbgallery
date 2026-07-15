<?php
/*
* @name chat.php
* @package cBB Chat
* @version v1.1.3 10/03/2017
*
* @copyright (c) 2017 CaniDev
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/

namespace canidev\chat;

// @ignore
if(!defined('IN_PHPBB'))
{
	exit;
}

use Symfony\Component\DependencyInjection\ContainerInterface;

class chat
{
	public $enabled				= false;
	public $in_custom_page		= false;
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
	protected $dispatcher;
	protected $db;
	protected $helper;
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
	* @param \phpbb\event\dispatcher_interface		$phpbb_dispatcher	Event dispatcher
	* @param \phpbb\db\driver\driver_interface		$db					DB Object
	* @param \phpbb\controller\helper				$helper       		Controller helper object
	* @param \phpbb\request\request 				$request			Request object
	* @param \phpbb\template\template				$template     		Template object
	* @param \phpbb\user							$user				User object
	* @param string									$root_path			phpBB root path
	* @param string									$php_ext			phpEx
	*
	* @access public
	*/
	public function __construct(\phpbb\auth\auth $auth, \phpbb\cache\driver\driver_interface $cache, \phpbb\config\config $config, ContainerInterface $container, $phpbb_dispatcher, \phpbb\db\driver\driver_interface $db, \phpbb\controller\helper $helper, \phpbb\request\request $request, \phpbb\template\template $template, \phpbb\user $user, $root_path, $php_ext)
	{
		global $table_prefix;
		
		$this->auth			= $auth;
		$this->cache		= $cache;
		$this->config 		= $config;
		$this->container	= $container;
		$this->dispatcher	= $phpbb_dispatcher;
		$this->db			= $db;
		$this->helper		= $helper;
		$this->request		= $request;
		$this->template		= $template;
		$this->user			= $user;
		
		$this->phpbb_root_path	= $root_path;
		$this->php_ext			= $php_ext;
		$this->time_limit		= (!empty($this->config['chat_timeout']) ? (time() - (intval($this->config['chat_timeout']) * 60)) : false);

		$this->root_path	= $this->phpbb_root_path . $this->path;
		$this->web_path		= $this->phpbb_root_path;
		
		if(!empty($this->config['chat_version']))
		{
			$this->enabled = (!empty($this->config['chat_enabled']) ? true : false);
			
			if($this->config['chat_disallowed_bbcode'])
			{
				$bitfield = new \bitfield($this->config['chat_disallowed_bbcode']);
				$this->disallowed_bbcodes = $bitfield->get_all_set();

				unset($bitfield);
			}
			
			include($this->root_path . 'constants.' . $this->php_ext);
		}
	}
	
	public function parse_ajax()
	{
		if($this->request->is_set_post('icajx') && !defined('ADMIN_START'))
		{
			if(!defined('IN_CHAT_AJAX'))
			{
				define('IN_CHAT_AJAX', true);
				$this->container->get('canidev.chat.chat_ajax')->run();
			}

			exit_handler();
		}
	}
	
	public function set_custom_page($state = true)
	{
		$this->in_custom_page = $state;
	}
	
	public function display()
	{
		if($this->enabled && !defined('IN_ERROR_HANDLER') && !defined('IN_CHAT_AJAX'))
		{
			$user_key	= $this->request->variable($this->config['cookie_name'] . '_chat_key', 0, false, \phpbb\request\request_interface::COOKIE);
			$lastcheck	= $this->request->variable($this->config['cookie_name'] . '_chat_lastcheck', 0, false, \phpbb\request\request_interface::COOKIE);
			
			// Update session of user when navigate into forum with chat connected
			$time_limit = time() - ((int)$this->config['chat_refresh'] * 2);

			if($this->enabled && !$this->in_custom_page && $user_key && $lastcheck && $time_limit < $lastcheck)
			{
				$sql = 'UPDATE ' . CHAT_USERS_TABLE . '
					SET user_lastjoin = ' . time() . '
					WHERE user_id = ' . $this->user->data['user_id'] . '
					AND user_key = ' . $user_key . '
					AND user_online = 1';
				$this->db->sql_query($sql);
			}

			if(!$this->in_custom_page)
			{
				$current_page	= (($this->user->page['page_dir']) ? $this->user->page['page_dir'] . '/' : '') . $this->user->page['page_name'];
				
				if(strpos($current_page, 'app.' . $this->php_ext) === 0 && $this->config['enable_mod_rewrite'])
				{
					$current_page = str_replace('app.' . $this->php_ext . '/', '', $current_page);
				}
				
				$page_data 		= $this->obtain_pages($current_page);
				$this->enabled	= (!empty($page_data) ? true : false);
				
				if(!empty($page_data['page_data']['forum_ids']) && !in_array($this->request->variable('f', 0), $page_data['page_data']['forum_ids']))
				{
					$this->enabled = false;
				}
			}
			
			if($this->enabled)
			{
				$this->user->add_lang('posting');

				$texts 			= $this->obtain_texts();
				$bbcode_status	= ($this->config['allow_bbcode'] && $this->config['chat_allow_bbcode']) ? true : false;
				$smilies_status	= ($this->config['allow_smilies']) ? true : false;

				$this->template->assign_vars(array(
					'S_CHAT_ENABLED'		=> true,
					'S_CHAT_RULES'			=> (!empty($texts[CHAT_TEXT_RULE]) ? true : false),
					
					'A_CHAT_COOKIE_SETTINGS'	=> addslashes('; path=' . $this->config['cookie_path'] . ((!$this->config['cookie_domain'] || $this->config['cookie_domain'] == 'localhost' || $this->config['cookie_domain'] == '127.0.0.1') ? '' : '; domain=' . $this->config['cookie_domain']) . ((!$this->config['cookie_secure']) ? '' : '; secure')),
					'S_CHAT_COOKIE_NAME'		=> $this->config['cookie_name'] . '_chat',

					'S_CHAT_ALLOW_PM'			=> $this->config['chat_allow_pm'],
					'S_CHAT_AUTOCONNECT'		=> $this->config['chat_autoconnect'],
					'S_CHAT_CAN_CLEAR'			=> $this->auth->acl_get('m_chat_delete'),
					'S_CHAT_CAN_POST'			=> $this->auth->acl_get('u_chat_post'),
					'S_CHAT_CURRENT_PAGE'		=> ($this->in_custom_page) ? 'custom' : $page_data['page_alias'],
					'S_CHAT_DEBUG'				=> (defined('DEBUG') && $this->auth->acl_get('a_')) ? true : false,
					'S_CHAT_DIRECTION'			=> $this->config['chat_direction'],
					'S_CHAT_FLOOD_TIME'			=> ($this->config['chat_flood_time'] && !$this->auth->acl_get('u_chat_ignoreflood')) ? $this->config['chat_flood_time'] * 1000 : 0,
					'S_CHAT_GUEST_ROOM'			=> CHAT_GUEST_ROOM,
					'S_CHAT_HEIGHT'				=> (!$this->in_custom_page && $page_data['chat_height']) ? $page_data['chat_height'] : $this->config['chat_height'],
					'S_CHAT_MAX_CHARS'			=> $this->config['chat_max_chars'],
					'S_CHAT_MAX_FONT_SIZE'		=> (int)$this->config['max_post_font_size'],
					'S_CHAT_MAX_ROWS'			=> $this->config['chat_max_rows'],
					'S_CHAT_PLAYER_PATH'		=> $this->web_path . $this->path . 'sounds/',
					'S_CHAT_POSITION'			=> (($this->in_custom_page) ? '' : $page_data['chat_position']),
					'S_CHAT_REFRESH'			=> $this->config['chat_refresh'] * 1000,
					
					'S_CHAT_BBCODE_ALLOWED'		=> $bbcode_status,
					'S_CHAT_BBCODE_COLOR'		=> ($bbcode_status && !in_array(6, $this->disallowed_bbcodes)) ? true : false,
					'S_CHAT_BBCODE_INSELECT'	=> ($this->config['chat_bbcode_format'] == 'select') ? true : false,
					'S_CHAT_SMILIES_ALLOWED'	=> $smilies_status,
					'S_CHAT_SOUND_ENABLED'		=> $this->config['chat_sound'],

					'S_CHAT_HIDDEN_FIELDS'	=> build_hidden_fields(array(
						'last_update'	=> 0,
					)),

					'U_CHAT_ACTION'		=> $this->helper->get_current_url(),
					'U_CHAT_ARCHIVE'	=> ($this->auth->acl_get('u_chat_archive') ? $this->helper->route('canidev_chat_controller', array('mode' => 'archive')) : ''),
					'U_CHAT_PLAYER'		=> $this->web_path . $this->path . 'player.swf?v=' . $this->config['chat_version'],
					
					'U_CHAT_JSCRIPT'	=> append_sid($this->web_path . $this->path . 'jchat_scripts.' . $this->php_ext, array(
						'v'					=> $this->config['chat_version'],
						'id'				=> $this->user->style['style_id'],
						'assets_version'	=> $this->config['assets_version']
					))
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
	}
	
	private function generate_bbcodes()
	{
		// Default BBcodes
		$default_bbcodes = array(
			'b'			=> array('bbcode_id'	=> 1,	'help' => 'BBCODE_B_HELP',			'name' => 'bold'),
			'i'			=> array('bbcode_id'	=> 2,	'help' => 'BBCODE_I_HELP',			'name' => 'italic'),
			'u'			=> array('bbcode_id'	=> 7,	'help' => 'BBCODE_U_HELP',			'name' => 'underline'),
			'quote'		=> array('bbcode_id'	=> 0,	'help' => 'BBCODE_Q_HELP',			'name' => 'quote'),
			'code'		=> array('bbcode_id'	=> 8,	'help' => 'BBCODE_C_HELP',			'name' => 'code'),
			'list'		=> array('bbcode_id'	=> 9,	'help' => 'BBCODE_L_HELP',			'name' => 'list'),
			'list=1'	=> array('bbcode_id'	=> 9,	'help' => 'BBCODE_O_HELP',			'name' => 'list-numeric'),
			'*'			=> array('bbcode_id'	=> 9,	'help' => 'BBCODE_LISTITEM_HELP',	'name' => 'list-item'),
			'img'		=> array('bbcode_id'	=> 4,	'help' => 'BBCODE_P_HELP',			'name' => 'img'),
			'url'		=> array('bbcode_id'	=> 3,	'help' => 'BBCODE_W_HELP',			'name' => 'url'),
			'flash'		=> array('bbcode_id'	=> 11,	'help' => 'BBCODE_D_HELP',			'name' => 'flash'),
			'size'		=> array('bbcode_id'	=> 5,	'help' => '',						'name' => 'size'),
		);

		foreach($default_bbcodes as $bbcode_tag => $row)
		{
			if(!in_array($row['bbcode_id'], $this->disallowed_bbcodes))
			{
				// Compatibility for events
				$row['bbcode_tag']	= $bbcode_tag;
				$bbcode_name		= $row['name'];
				$template_key		= 'chat_default_tags';

				$item_ary = array(
					'S_HELP'	=> ($row['help']) ? $this->user->lang[$row['help']] : '',
					'S_NAME'	=> $bbcode_name,
					'S_TAG'		=> $bbcode_tag,
				);

				/**
				* Event to modify the bbcodes loaded in the chat
				*
				* @event chat.generate_bbcodes
				* @var	string	bbcode_name		The name of the bbcode tag
				* @var	string	template_key	Key assigned to the block template
				* @var	array	row				Array with bbcode row
				* @var	array	item_ary		Array with items to push on template
				* @since 1.1.1
				*/
				$vars = array('bbcode_name', 'template_key', 'row', 'item_ary');
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
		* Event to modify the sql of custom chat bbcodes
		*
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
			if(isset($this->user->lang[strtoupper($row['bbcode_helpline'])]))
			{
				$row['bbcode_helpline'] = $this->user->lang[strtoupper($row['bbcode_helpline'])];
			}
			
			$bbcode_name	= trim(str_replace('=', '-', $row['bbcode_tag']), '-');
			$imagename		= 'icons/bbcode-' . $bbcode_name . '.png';
			$template_key	= 'chat_custom_tags';
			
			$item_ary = array(
				'S_HELP'	=> $row['bbcode_helpline'],
				'S_IMAGE'	=> (file_exists($this->root_path . $imagename) ? $this->web_path . $this->path . $imagename : ''),
				'S_NAME'	=> $bbcode_name,
				'S_TAG'		=> $row['bbcode_tag'],
			);
			
			/**
			* Event to modify the bbcodes loaded in the chat
			*
			* @event chat.generate_bbcodes
			* @var	string	bbcode_name		The name of the bbcode tag
			* @var	string	template_key	Key assigned to the block template
			* @var	array	row				Array with bbcode row
			* @var	array	item_ary		Array with items to push on template
			* @since 1.1.1
			*/
			$vars = array('bbcode_name', 'template_key', 'row', 'item_ary');
			extract($this->dispatcher->trigger_event('chat.generate_bbcodes', compact($vars)));

			if(sizeof($item_ary))
			{
				$this->template->assign_block_vars($template_key, $item_ary);
			}
		}
		$this->db->sql_freeresult($result);
	}
	
	private function generate_smilies()
	{
		$smilies = array();

		$sql = 'SELECT *
			FROM ' . SMILIES_TABLE . '
			WHERE display_on_posting = 1
			ORDER BY smiley_order';
		$result = $this->db->sql_query($sql, 3600);
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
	}
	
	public function obtain_pages($current_page = false)
	{
		if(($page_cache = $this->cache->get('_chat_pages')) === false)
		{
			$page_cache = array();

			$sql = 'SELECT *
				FROM ' . CHAT_PAGES_TABLE;
			$result = $this->db->sql_query($sql);
			while($row = $this->db->sql_fetchrow($result))
			{
				$row_id = $row['page_path'] . $row['page_filename'];
				
				$row['page_data'] = ($row['page_data']) ? @unserialize($row['page_data']) : array();
				
				$page_cache[$row_id] = $row;
			}
			$this->db->sql_freeresult($result);
			
			$this->cache->put('_chat_pages', $page_cache);
		}
		
		if($current_page)
		{
			return (isset($page_cache[$current_page]) ? $page_cache[$current_page] : array());
		}
		
		return $page_cache;
	}
	
	public function obtain_rooms()
	{
		if(($room_cache = $this->cache->get('_chat_rooms')) === false)
		{
			$room_cache = array();

			$sql = 'SELECT *
				FROM ' . CHAT_ROOMS_TABLE . '
				ORDER BY room_order';
			$result = $this->db->sql_query($sql);
			while($row = $this->db->sql_fetchrow($result))
			{
				$row['room_data'] = @unserialize($row['room_data']);
				
				if(!isset($row['room_data']['groups']))
				{
					$row['room_data']['groups'] = array();
				}
				
				if(!isset($row['room_data']['users']))
				{
					$row['room_data']['users'] = array();
				}
				
				$room_cache[$row['room_key']] = $row;
			}
			$this->db->sql_freeresult($result);
			
			$this->cache->put('_chat_rooms', $room_cache);
		}

		return $room_cache;
	}
	
	public function obtain_texts($output_type = false, $translate = true)
	{
		if(($text_cache = $this->cache->get('_chat_texts')) === false)
		{
			$text_cache = array();
			
			$sql = 'SELECT text_type, text_content, bbcode_uid, bbcode_bitfield
				FROM ' . CHAT_TEXTS_TABLE . '
				ORDER BY text_order ASC';
			$result = $this->db->sql_query($sql);
			while($row = $this->db->sql_fetchrow($result))
			{
				$text_type = (int)$row['text_type'];
				
				if(!isset($text_cache[$text_type]))
				{
					$text_cache[$text_type] = array();
				}
				
				$text_cache[$text_type][] = $row;
			}
			$this->db->sql_freeresult($result);
				
			foreach($text_cache as $text_type => $rows)
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
					$text_cache[$text_type][$row_id] = $row['text_content'];
				}
			}
			
			$this->cache->put('_chat_texts', $text_cache);
		}
		
		foreach($text_cache as $text_type => $rows)
		{
			foreach($rows as $row_id => $text)
			{
				if($translate && strpos($text, '{') !== false)
				{
					$this->parse_lang_variables($text);
				}

				$text = smiley_text($text);
				
				$text_cache[$text_type][$row_id] = $text;
			}
		}
		
		if($output_type)
		{
			return (isset($text_cache[$output_type]) ? $text_cache[$output_type] : array());
		}

		return $text_cache;
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
				return $this->user->lang['datetime'][$day] . ', ' . $this->user->format_date($timestamp, 'H:i');
			}
		}
		
		return $this->user->format_date($timestamp, $this->user->lang['default_dateformat']);
	}
	
	public function generate_text_for_storage(&$text, &$uid, &$bitfield, &$flags, $allow_bbcode = false, $allow_urls = false, $allow_smilies = false)
	{
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
		extract($this->dispatcher->trigger_event('core.modify_text_for_storage_before', compact($vars)));

		$uid = $bitfield = '';
		$flags = (($allow_bbcode) ? OPTION_FLAG_BBCODE : 0) + (($allow_smilies) ? OPTION_FLAG_SMILIES : 0) + (($allow_urls) ? OPTION_FLAG_LINKS : 0);

		if($text === '')
		{
			return;
		}

		if(!class_exists('parse_message', false))
		{
			include($this->phpbb_root_path . 'includes/message_parser.' . $this->php_ext);
		}

		$message_parser = new \parse_message($text);
		$message_parser->parse($allow_bbcode, $allow_urls, $allow_smilies, $allow_bbcode, $allow_bbcode, $allow_bbcode, $allow_urls, true, 'chat');

		$text	= $message_parser->message;
		$uid	= $message_parser->bbcode_uid;

		// If the bbcode_bitfield is empty, there is no need for the uid to be stored.
		if(!$message_parser->bbcode_bitfield)
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
		extract($this->dispatcher->trigger_event('core.modify_text_for_storage_after', compact($vars)));

		return $message_parser->warn_msg;
	}
	
	public function parse_lang_variables(&$text)
	{
		$text = preg_replace_callback('#\{L_([A-Z0-9_\-]+)\}#', function($matches)
		{
			return isset($this->user->lang[$matches[1]]) ? $this->user->lang[$matches[1]] : '';
		}, $text);
	}
}
