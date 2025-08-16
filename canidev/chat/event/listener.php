<?php
/*
* @package cBB Chat
* @version v1.2.2 29/03/2021
*
* @copyright (c) 2021 CaniDev
* @license https://opensource.org/licenses/gpl-license.php GNU Public License
*/

namespace canidev\chat\event;

// @ignore
if(!defined('IN_PHPBB'))
{
	exit;
}

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class listener implements EventSubscriberInterface
{
	protected $chat;
	protected $config;
	protected $db;
	
	/**
	* Constructor
	*
	* @param \canidev\chat\libraries\chat 		$chat			Chat Object
	* @param \phpbb\config\config 				$config			Config Object
	* @param ContainerInterface 				$container		Service container interface
	* @param \phpbb\db\driver\driver_interface	$db				DB Object
	*
	* @access public
	*/
	public function __construct(
		\canidev\chat\libraries\chat $chat,
		\phpbb\config\config $config,
		\Symfony\Component\DependencyInjection\ContainerInterface $container,
		\phpbb\db\driver\driver_interface $db)
	{
		$this->chat			= $chat;
		$this->config		= $config;
		$this->db			= $db;
		
		\canidev\core\lib::get_instance($container);
	}

	static public function getSubscribedEvents()
	{
		$events = array();
		
		if(!defined('IN_INSTALL'))
		{
			$events = array(
				'core.user_setup'					=> 'load_language',
				'core.user_setup_after'				=> 'on_setup_after',
				'core.session_kill_after'			=> 'on_user_logout',
				'core.page_footer'					=> 'on_footer',
				'core.delete_user_after'			=> 'on_user_delete',
				'core.group_add_user_after'			=> 'user_group_add',
				'core.user_set_group_attributes'	=> 'user_group_change',
				'core.group_delete_user_after'		=> 'user_group_del',
				'core.permissions'					=> 'add_permissions',
			);
		}

		return $events;
	}
	
	public function load_language($event)
	{
		$lang_set_ext = $event['lang_set_ext'];
		$lang_set_ext[] = array(
			'ext_name' => 'canidev/chat',
			'lang_set' => 'main',
		);
		$event['lang_set_ext'] = $lang_set_ext;
	}
	
	public function on_setup_after()
	{
		$this->chat->load();
	}
	
	public function on_user_logout($event)
	{
		$sql = 'UPDATE ' . CHAT_USERS_TABLE . '
			SET user_online = 0
			WHERE user_key = ' . (int)$event['user_id'];
		$this->db->sql_query($sql);
	}
	
	public function on_footer()
	{
		$this->chat->display();
	}
	
	public function user_group_add($event)
	{
		if(!$event['pending'])
		{
			$this->chat->update_groups($event['user_id_ary']);
		}
	}
	
	public function user_group_del($event)
	{
		$this->chat->update_groups($event['user_id_ary']);
	}
	
	public function user_group_change($event)
	{
		if($event['action'] == 'approve')
		{
			$this->chat->update_groups($event['user_id_ary']);
		}
	}

	public function on_user_delete($event)
	{
		foreach($event['user_ids'] as $user_id)
		{
			// Delete from chat users
			$sql = 'DELETE FROM ' . CHAT_USERS_TABLE . '
				WHERE ' . $this->db->sql_in_set('user_id', $event['user_ids']);
			$this->db->sql_query($sql);
			
			// Delete private messages
			$sql = 'DELETE FROM ' . CHAT_MESSAGES_TABLE . '
				WHERE ' . $this->db->sql_in_set('poster_id', $event['user_ids']);
			$this->db->sql_query($sql);
		}
	}
	
	/**
	* Add administrative permissions to manage Chat
	*
	* @param object $event The event object
	* @access public
	*/
	public function add_permissions($event)
	{
		$event['categories'] = array_merge($event['categories'], array(
			'chat'	=> 'ACL_CAT_CHAT',
		));

		$event['permissions'] = array_merge($event['permissions'], array(
			'a_chat'				=> array('lang'	=> 'ACL_A_CHAT',				'cat'	=> 'misc'),

			'm_chat_delete'			=> array('lang'	=> 'ACL_M_CHAT_DELETE',			'cat'	=> 'chat'),
			'm_chat_edit'			=> array('lang'	=> 'ACL_M_CHAT_EDIT',			'cat'	=> 'chat'),

			'u_chat_archive'		=> array('lang'	=> 'ACL_U_CHAT_ARCHIVE',		'cat'	=> 'chat'),
			'u_chat_delete'			=> array('lang'	=> 'ACL_U_CHAT_DELETE',			'cat'	=> 'chat'),
			'u_chat_edit'			=> array('lang'	=> 'ACL_U_CHAT_EDIT',			'cat'	=> 'chat'),
			'u_chat_ignoreflood'	=> array('lang'	=> 'ACL_U_CHAT_IGNOREFLOOD',	'cat'	=> 'chat'),
			'u_chat_post'			=> array('lang'	=> 'ACL_U_CHAT_POST',			'cat'	=> 'chat'),
			'u_chat_sendpm'			=> array('lang'	=> 'ACL_U_CHAT_SENDPM',			'cat'	=> 'chat'),
			'u_chat_view'			=> array('lang'	=> 'ACL_U_CHAT_VIEW',			'cat'	=> 'chat'),
		));
	}
}
