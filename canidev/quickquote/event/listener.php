<?php
/*
* @name listener.php
* @package cBB QuickQuote
* @version 1.0.0 01/03/2018
*
* @copyright (c) 2018 CaniDev
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/

namespace canidev\quickquote\event;

// @ignore
if(!defined('IN_PHPBB'))
{
	exit;
}

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class listener implements EventSubscriberInterface
{
	protected $auth;
	protected $config;
	protected $core;
	protected $request;
	protected $template;
	protected $phpbb_root_path;
	protected $php_ext;

	/**
	* Constructor
	*
	* @param \phpbb\auth\auth 				$auth			Authentication object
	* @param \phpbb\config\config 			$config			Config Object
	* @param ContainerInterface 			$container		Service container interface
	* @param \phpbb\request\request 		$request		Request object
	* @param \phpbb\template\template		$template     	Template object
	* @param string							$root_path		phpBB root path
	* @param string							$php_ext		phpEx
	*
	* @access public
	*/
	public function __construct(\phpbb\auth\auth $auth, \phpbb\config\config $config, ContainerInterface $container, \phpbb\request\request $request, \phpbb\template\template $template, $root_path, $php_ext)
	{
		$this->auth				= $auth;
		$this->config			= $config;
		$this->request			= $request;
		$this->template			= $template;
		$this->phpbb_root_path	= $root_path;
		$this->php_ext			= $php_ext;
		
		$this->core = \canidev\core\lib::get_instance($container);
	}

	static public function getSubscribedEvents()
	{
		$events = array();

		if(!defined('IN_INSTALL'))
		{
			$events = array(
				'core.user_setup'								=> 'on_setup',
				'core.viewforum_get_topic_data'					=> 'set_viewforum_reply',
				'core.viewtopic_modify_post_row'				=> 'modify_post_row',
				'core.viewtopic_assign_template_vars_before'	=> 'set_viewtopic_reply',
				'core.topic_review_modify_row'					=> 'modify_post_row',
				'core.ucp_pm_view_messsage'						=> 'modify_pm_row',
			);
		}

		return $events;
	}
	
	public function on_setup($event)
	{
		$forum_id	= $this->request->variable('f', 0);

		$enabled = (
			$this->auth->acl_get('f_post', $forum_id) ||
			$this->auth->acl_get('f_reply', $forum_id) ||
			$this->auth->acl_get('u_sendpm')
		);
		
		if($this->config['quickquote_groups'] && $this->config['quickquote_groups'] != 'all')
		{
			$enabled = ($enabled && $this->core->group_auth($this->config['quickquote_groups']));
		}
	
		$this->template->assign_vars(array(
			'QQ_ENABLED'	=> $enabled,
			'QQ_FLOAT_BTN'	=> (bool)$this->config['quickquote_floatbtn'],
		));

		$lang_set_ext = $event['lang_set_ext'];
		$lang_set_ext[] = array(
			'ext_name' => 'canidev/quickquote',
			'lang_set' => 'frontend',
		);
		$event['lang_set_ext'] = $lang_set_ext;
	}
	
	public function modify_post_row($event)
	{
		$postrow = $event['post_row'];
		
		$ary = array(
			'user'		=> $event['row']['user_id'],
			'username'	=> $event['row']['username'],
			'post'		=> $event['row']['post_id'],
			'time'		=> $event['row']['post_time'],
		);
		
		$postrow['MESSAGE'] .= '<script class="js-qq-post-info" type="application/json">' . json_encode($ary) . '</script>';
		
		$event['post_row'] = $postrow;
	}
	
	public function set_viewforum_reply($event)
	{
		$u_reply = append_sid($this->phpbb_root_path . 'posting.' . $this->php_ext, array(
			'mode'		=> 'post',
			'f'			=> $event['forum_id'],
		), false);
		
		$this->template->assign_var('U_QQ_REPLY', $u_reply);
	}
	
	public function set_viewtopic_reply($event)
	{
		$u_reply = append_sid($this->phpbb_root_path . 'posting.' . $this->php_ext, array(
			'mode'		=> 'reply',
			'f'			=> $event['forum_id'],
			't'			=> $event['topic_id'],
		), false);
		
		$this->template->assign_var('U_QQ_REPLY', $u_reply);
	}
	
	public function modify_pm_row($event)
	{
		$row = $event['msg_data'];
		
		$ary = array(
			'user'		=> $event['user_info']['user_id'],
			'username'	=> $event['user_info']['username'],
			'time'		=> $event['message_row']['message_time'],
		);
		
		$row['MESSAGE'] .= '<script class="js-qq-post-info" type="application/json">' . json_encode($ary) . '</script>';
		
		$event['msg_data'] = $row;
		
		$u_reply = append_sid($this->phpbb_root_path . 'ucp.' . $this->php_ext, array(
			'i'			=> 'pm',
			'mode'		=> 'compose',
			'action'	=> 'reply',
			'p'			=> $event['msg_id'],
		), false);
		
		$this->template->assign_var('U_QQ_REPLY', $u_reply);
	}
}