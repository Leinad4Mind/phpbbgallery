<?php
/*
* @name v110.php
* @package cBB Chat
* @version v1.1.0 16/12/2014
*
* @copyright (c) 2014 CaniDev
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/

namespace canidev\chat\migrations;

class v110 extends \phpbb\db\migration\migration
{
	public function effectively_installed()
	{
		return $this->db_tools->sql_table_exists($this->table_prefix . 'chat_messages');
	}

	public function update_schema()
	{
		return array(
			'add_tables' => array(
				$this->table_prefix . 'chat_messages' => array(
					'COLUMNS' => array(
						'message_id'		=> array('UINT:8', NULL, 'auto_increment'),
						'poster_key'		=> array('UINT:11', 0),
						'dest_key'			=> array('UINT:11', 1),
						'poster_id'			=> array('UINT:8', ANONYMOUS),
						'poster_ip'			=> array('VCHAR:40', ''),
						'poster_username'	=> array('VCHAR', ''),
						'message_text'		=> array('TEXT', ''),
						'message_time'		=> array('UINT:11', 0),
						'bbcode_bitfield'	=> array('VCHAR', ''),
						'bbcode_uid'		=> array('VCHAR:8', ''),
					),
					'PRIMARY_KEY'	=> 'message_id',
				),

				$this->table_prefix . 'chat_pages' => array(
					'COLUMNS' => array(
						'page_id'			=> array('UINT:3', NULL, 'auto_increment'),
						'page_alias'		=> array('VCHAR:50', ''),
						'page_filename'		=> array('VCHAR', ''),
						'page_path'			=> array('VCHAR', ''),
						'page_data'			=> array('TEXT', ''),
						'chat_position'		=> array('VCHAR:10', ''),
						'chat_height'		=> array('UINT:4', 0),
					),
					'PRIMARY_KEY'	=> 'page_id',
				),
				
				$this->table_prefix . 'chat_rooms' => array(
					'COLUMNS' => array(
						'room_id'			=> array('UINT:3', NULL, 'auto_increment'),
						'room_key'			=> array('UINT:11', 0),
						'room_title'		=> array('VCHAR', ''),
						'room_data'			=> array('TEXT', ''),
						'room_enabled'		=> array('BOOL', 1),
						'room_order'		=> array('UINT:3', 0),
					),
					'PRIMARY_KEY'	=> 'room_id',
				),
				
				$this->table_prefix . 'chat_texts' => array(
					'COLUMNS' => array(
						'text_id'			=> array('UINT:3', NULL, 'auto_increment'),
						'text_content'		=> array('TEXT', ''),
						'text_order'		=> array('UINT:3', 1),
						'text_type'			=> array('UINT:1', 0),
						'bbcode_bitfield'	=> array('VCHAR', ''),
						'bbcode_uid'		=> array('VCHAR:8', ''),
					),
					'PRIMARY_KEY'	=> 'text_id',
				),
				
				$this->table_prefix . 'chat_users' => array(
					'COLUMNS' => array(
						'user_key'				=> array('UINT:11', 0),
						'user_id'				=> array('UINT:8', 0),
						'user_ip'				=> array('VCHAR:40', ''),
						'username'				=> array('VCHAR', ''),
						'session_start'			=> array('UINT:11', 0),
						'session_viewonline'	=> array('BOOL', 1),
						'user_lastjoin'			=> array('UINT:11', 0),
						'user_online'			=> array('BOOL', 0),
						'user_status'			=> array('UINT:3', 1),
						'exclude_time'			=> array('UINT:11', 0),
					),
					'PRIMARY_KEY'	=> 'user_key',
				),
			),
		);
	}

	public function revert_schema()
	{
		return array(
			'drop_tables'	=> array(
				$this->table_prefix . 'chat_messages',
				$this->table_prefix . 'chat_pages',
				$this->table_prefix . 'chat_rooms',
				$this->table_prefix . 'chat_texts',
				$this->table_prefix . 'chat_users',
			),
		);
	}

	public function update_data()
	{
		return array(
			array('config.add', array('chat_allow_bbcode', 1)),
			array('config.add', array('chat_allow_pm', 1)),
			array('config.add', array('chat_auto_away', 0)),
			array('config.add', array('chat_autoconnect', 1)),
			array('config.add', array('chat_bbcode_format', 'button')),
			array('config.add', array('chat_cron_lock', 0, 1)),
			array('config.add', array('chat_direction', 'down')),
			array('config.add', array('chat_disallowed_bbcode', '')),
			array('config.add', array('chat_enabled', 1)),
			array('config.add', array('chat_flood_time', 0)),
			array('config.add', array('chat_height', 240)),
			array('config.add', array('chat_max_chars', 500)),
			array('config.add', array('chat_max_pm', 0)),
			array('config.add', array('chat_max_rows', 15)),
			array('config.add', array('chat_page_enabled', 1)),
			array('config.add', array('chat_refresh', 10)),
			array('config.add', array('chat_remember_status', 1)),
			array('config.add', array('chat_show_avatars', 1)),
			array('config.add', array('chat_show_topics', 0)),
			array('config.add', array('chat_sound', 1)),
			array('config.add', array('chat_store_time', 31104000)), // One year
			array('config.add', array('chat_timeout', 5)),
			array('config.add', array('chat_version', '1.1.0')),
	
			array('module.add', array(
				'acp',
				'ACP_CAT_DOT_MODS',
				'ACP_CAT_CHAT'
			)),
			array('module.add', array(
				'acp',
				'ACP_CAT_CHAT',
				array(
					'module_basename'	=> '\canidev\chat\acp\main_module',
					'modes'				=> array('config', 'pages', 'rooms', 'texts'),
				),
			)),
			
			array('permission.add', array('a_chat', true)),

			array('permission.add', array('m_chat_delete', true)),
			array('permission.add', array('m_chat_edit', true)),
			
			array('permission.add', array('u_chat_archive', true)),
			array('permission.add', array('u_chat_delete', true)),
			array('permission.add', array('u_chat_edit', true)),
			array('permission.add', array('u_chat_ignoreflood', true)),
			array('permission.add', array('u_chat_post', true)),
			array('permission.add', array('u_chat_sendpm', true)),
			array('permission.add', array('u_chat_view', true)),

			array('permission.permission_set', array('ADMINISTRATORS', 'a_chat', 'group')),
			array('permission.permission_set', array('ADMINISTRATORS', 'u_chat_archive', 'group')),
			array('permission.permission_set', array('ADMINISTRATORS', 'u_chat_ignoreflood', 'group')),

			array('permission.permission_set', array('REGISTERED', 'u_chat_delete', 'group')),
			array('permission.permission_set', array('REGISTERED', 'u_chat_edit', 'group')),
			array('permission.permission_set', array('REGISTERED', 'u_chat_post', 'group')),
			array('permission.permission_set', array('REGISTERED', 'u_chat_sendpm', 'group')),
			array('permission.permission_set', array('REGISTERED', 'u_chat_view', 'group')),

			array('permission.permission_set', array('GLOBAL_MODERATORS', 'm_chat_delete', 'group')),
			array('permission.permission_set', array('GLOBAL_MODERATORS', 'm_chat_edit', 'group')),
			
			array('custom', array(array($this, 'add_table_data'))),
		);
	}
	
	public function add_table_data()
	{
		$sql_ary = array(
			$this->table_prefix . 'chat_pages'	=> array(
				array(
					'page_alias'		=> 'index',
					'page_filename'		=> 'index.' . $this->php_ext,
					'page_data'			=> '',
					'page_path'			=> '',
					'chat_position'		=> 'bottom',
				)
			),

			$this->table_prefix . 'chat_rooms'	=> array(
				array(
					'room_key'			=> 1,
					'room_title'		=> 'CHAT_GUEST_ROOM',
					'room_data'			=> '',
					'room_enabled'		=> 1,
					'room_order'		=> 1,
				)
			)
		);
		
		foreach($sql_ary as $table => $rows)
		{
			$this->db->sql_multi_insert($table, $rows);
		}
	}
}
