<?php
/**
 * @package cBB Chat
 * @version 1.2.6 01/07/2024
 *
 * @copyright (c) 2024 CaniDev
 * @license https://creativecommons.org/licenses/by-nc/4.0/
 */

namespace canidev\chat\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class listener implements EventSubscriberInterface
{
	protected $chat;
	protected $config;
	protected $db;
	protected $tables;
	
	/**
	 * Constructor
	 *
	 * @param \canidev\chat\libraries\chat 			$chat			Chat Object
	 * @param \phpbb\config\config 					$config			Config Object
	 * @param \phpbb\db\driver\driver_interface		$db				DB Object
	 * @param array 								$tables 		Chat DB Tables
	 *
	 * @access public
	 */
	public function __construct(
		\canidev\chat\libraries\chat $chat,
		\phpbb\config\config $config,
		\phpbb\db\driver\driver_interface $db,
		$tables)
	{
		$this->chat			= $chat;
		$this->config		= $config;
		$this->db			= $db;
		$this->tables 		= $tables;
	}

	/**
	 * {@inheritDoc}
	 */
	static public function getSubscribedEvents()
	{
		return [
			'core.user_setup'					=> 'load_language',
			'core.user_setup_after'				=> 'on_setup_after',
			'core.session_kill_after'			=> 'on_user_logout',
			'core.page_footer'					=> 'on_footer',
			'core.delete_user_after'			=> 'on_user_delete',
			'core.group_add_user_after'			=> 'user_group_add',
			'core.user_set_group_attributes'	=> 'user_group_change',
			'core.group_delete_user_after'		=> 'user_group_del',
			'core.permissions'					=> 'add_permissions',
		];
	}
	
	/**
	 * Load chat language
	 * 
	 * @param \phpbb\event\data 	$event
	 */
	public function load_language($event)
	{
		$lang_set_ext = $event['lang_set_ext'];
		$lang_set_ext[] = [
			'ext_name' => 'canidev/chat',
			'lang_set' => 'main',
		];
		$event['lang_set_ext'] = $lang_set_ext;
	}
	
	/**
	 * Load chat
	 */
	public function on_setup_after()
	{
		$this->chat->load();
	}
	
	/**
	 * Actions on user logout
	 * 
	 * @param \phpbb\event\data 	$event
	 */
	public function on_user_logout($event)
	{
		$sql = 'UPDATE ' . $this->tables['users'] . '
			SET user_online = 0
			WHERE user_key = ' . (int)$event['user_id'];
		$this->db->sql_query($sql);
	}
	
	/**
	 * Display chat
	 */
	public function on_footer()
	{
		$this->chat->display();
	}
	
	/**
	 * Actions on add user to group
	 * 
	 * @param \phpbb\event\data 	$event
	 */
	public function user_group_add($event)
	{
		if(!$event['pending'])
		{
			$this->chat->update_groups($event['user_id_ary']);
		}
	}
	
	/**
	 * Actions on delete user fron group
	 * 
	 * @param \phpbb\event\data 	$event
	 */
	public function user_group_del($event)
	{
		$this->chat->update_groups($event['user_id_ary']);
	}
	
	/**
	 * Actions on change user group
	 * 
	 * @param \phpbb\event\data 	$event
	 */
	public function user_group_change($event)
	{
		if($event['action'] == 'approve')
		{
			$this->chat->update_groups($event['user_id_ary']);
		}
	}

	/**
	 * Actions on user delete
	 * 
	 * @param \phpbb\event\data 	$event
	 */
	public function on_user_delete($event)
	{
		foreach($event['user_ids'] as $user_id)
		{
			// Delete from chat users
			$sql = 'DELETE FROM ' . $this->tables['users'] . '
				WHERE ' . $this->db->sql_in_set('user_id', $event['user_ids']);
			$this->db->sql_query($sql);
			
			// Delete private messages
			$sql = 'DELETE FROM ' . $this->tables['messages'] . '
				WHERE ' . $this->db->sql_in_set('poster_id', $event['user_ids']);
			$this->db->sql_query($sql);
		}
	}
	
	/**
	 * Add administrative permissions to manage Chat
	 *
	 * @param \phpbb\event\data 	$event
	*/
	public function add_permissions($event)
	{
		$event['categories'] = array_merge($event['categories'], [
			'chat'	=> 'ACL_CAT_CHAT',
		]);

		$event['permissions'] = array_merge($event['permissions'], [
			'a_chat'				=> ['lang'	=> 'ACL_A_CHAT',				'cat'	=> 'misc'],

			'm_chat_delete'			=> ['lang'	=> 'ACL_M_CHAT_DELETE',			'cat'	=> 'chat'],
			'm_chat_edit'			=> ['lang'	=> 'ACL_M_CHAT_EDIT',			'cat'	=> 'chat'],

			'u_chat_archive'		=> ['lang'	=> 'ACL_U_CHAT_ARCHIVE',		'cat'	=> 'chat'],
			'u_chat_delete'			=> ['lang'	=> 'ACL_U_CHAT_DELETE',			'cat'	=> 'chat'],
			'u_chat_edit'			=> ['lang'	=> 'ACL_U_CHAT_EDIT',			'cat'	=> 'chat'],
			'u_chat_ignoreflood'	=> ['lang'	=> 'ACL_U_CHAT_IGNOREFLOOD',	'cat'	=> 'chat'],
			'u_chat_post'			=> ['lang'	=> 'ACL_U_CHAT_POST',			'cat'	=> 'chat'],
			'u_chat_sendpm'			=> ['lang'	=> 'ACL_U_CHAT_SENDPM',			'cat'	=> 'chat'],
			'u_chat_view'			=> ['lang'	=> 'ACL_U_CHAT_VIEW',			'cat'	=> 'chat'],
		]);
	}
}
