<?php
/*
* @name listener.php
* @package cBB Chat
* @version v1.1.1 01/07/2015
*
* @copyright (c) 2015 CaniDev
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/

namespace canidev\chat\event;

// @ignore
if(!defined('IN_PHPBB'))
{
	exit;
}

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class listener implements EventSubscriberInterface
{
	protected $config;
	protected $container;
	protected $helper;
	protected $request;
	protected $template;
	protected $user;
	
	/**
	* Constructor
	*
	* @param \phpbb\config\config 				$config			Config Object
	* @param ContainerInterface 				$container		Service container interface
	* @param \phpbb\controller\helper			$helper       	Controller helper object
	* @param \phpbb\request\request 			$request		Request object
	* @param \phpbb\template\template			$template     	Template object
	* @param \phpbb\user						$user			User object
	*
	* @access public
	*/
	public function __construct(\phpbb\config\config $config, ContainerInterface $container, \phpbb\controller\helper $helper, \phpbb\request\request $request, \phpbb\template\template $template, \phpbb\user $user)
	{
		$this->config		= $config;
		$this->container	= $container;
		$this->helper 		= $helper;
		$this->request		= $request;
		$this->template		= $template;
		$this->user			= $user;
	}

	static public function getSubscribedEvents()
	{
		$events = array();
		
		if(!defined('IN_INSTALL') && !defined('IN_JSCRIPT'))
		{
			global $phpbb_container;

			$events['core.common'] 				= 'initialize_chat';
			$events['core.user_setup']			= 'on_setup';
			$events['core.delete_user_after']	= 'on_user_delete';
			$events['core.permissions']			= 'add_permissions';

			if(!defined('ADMIN_START'))
			{
				$events['core.page_footer'] = 'on_footer';
			}
			
			$compatibility = $phpbb_container->get('canidev.chat.compatibility.manager');
			$compatibility->get_core_events();
		}

		return $events;
	}
	
	function initialize_chat()
	{
		if(empty($this->config['chat_version']))
		{
			return;
		}

		global $chat, $phpbb_hook;
		$chat = $this->container->get('canidev.chat.chat');
		
		$phpbb_hook->register('phpbb_user_session_handler', array($chat, 'parse_ajax'));
	}
	
	public function on_footer($event)
	{
		if(!empty($this->config['chat_version']))
		{
			global $chat;
			$chat->display();
		}
	}

	public function on_setup($event)
	{
		global $auth, $phpbb_root_path, $phpEx;
		global $chat;
		
		$chat->web_path = generate_board_url() . '/';
		
		// Fix problem in Windows Servers
		$chat->web_path = str_replace('\\/', '', $chat->web_path);
		
		if(empty($this->config['chat_version']))
		{
			return;
		}
		
		if($this->user->data['is_bot'] || !$auth->acl_get('u_chat_view') || defined('ADMIN_START'))
		{
			$chat->enabled = false;
		}

		if($chat->enabled || defined('ADMIN_START'))
		{
			$this->template->assign_vars(array(
				'S_CHAT_VERSION'	=> $this->config['chat_version'],
				'T_CHAT_PATH'		=> $chat->web_path . $chat->path,
				'U_CHAT'			=> ($chat->enabled && $this->config['chat_page_enabled']) ? $this->helper->route('canidev_chat_controller') : '',
			));
		}
		
		if(!$chat->enabled && !$this->request->is_set_post('icajx'))
		{
			return false;
		}

		$lang_set_ext = $event['lang_set_ext'];
		$lang_set_ext[] = array(
			'ext_name' => 'canidev/chat',
			'lang_set' => 'main',
		);
		$event['lang_set_ext'] = $lang_set_ext;
	}
	
	public function on_user_delete($event)
	{
		global $db;
		
		if(!empty($this->config['chat_version']))
		{
			foreach($event['user_ids'] as $user_id)
			{
				// Delete from chat users
				$sql = 'DELETE FROM ' . CHAT_USERS_TABLE . '
					WHERE ' . $db->sql_in_set('user_id', $event['user_ids']);
				$db->sql_query($sql);
				
				// Delete private messages
				$sql = 'DELETE FROM ' . CHAT_MESSAGES_TABLE . '
					WHERE ' . $db->sql_in_set('poster_id', $event['user_ids']);
				$db->sql_query($sql);
			}
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
