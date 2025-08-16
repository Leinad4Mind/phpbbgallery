<?php
/**
 * @package cBB Quickquote
 * @version 1.0.4 01/06/2024
 *
 * @copyright (c) 2024 CaniDev
 * @license https://creativecommons.org/licenses/by-nc/4.0/
 */

namespace canidev\quickquote\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

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
	 * @param \canidev\core\lib 			$core 			Canidev Core
	 * @param \phpbb\request\request 		$request		Request object
	 * @param \canidev\core\template 		$template 		Core Template Object
	 * @param string						$root_path		phpBB root path
	 * @param string						$php_ext		phpEx
	 *
	 * @access public
	 */
	public function __construct(
		\phpbb\auth\auth $auth,
		\phpbb\config\config $config,
		\canidev\core\lib $core,
		\phpbb\request\request $request,
		\canidev\core\template $template,
		$root_path,
		$php_ext)
	{
		$this->auth				= $auth;
		$this->config			= $config;
		$this->core 			= $core;
		$this->request			= $request;
		$this->template			= $template;
		$this->phpbb_root_path	= $root_path;
		$this->php_ext			= $php_ext;
	}

	/**
	 * {@inheritDoc}
	 */
	static public function getSubscribedEvents()
	{
		return [
			'core.user_setup'								=> 'on_setup',
			'core.page_footer'								=> 'on_footer',
			
			'core.viewforum_get_topic_data'					=> 'set_viewforum_reply',
			'core.viewtopic_modify_post_row'				=> 'modify_post_row',
			'core.viewtopic_assign_template_vars_before'	=> 'set_viewtopic_reply',
			'core.topic_review_modify_row'					=> 'modify_post_row',
			'core.ucp_pm_view_messsage'						=> 'modify_pm_row',
		];
	}
	
	/**
	 * core.user_setup
	 * @param \phpbb\event\data 	$event
	 */
	public function on_setup($event)
	{
		$lang_set_ext = $event['lang_set_ext'];
		$lang_set_ext[] = [
			'ext_name' => 'canidev/quickquote',
			'lang_set' => 'frontend',
		];
		$event['lang_set_ext'] = $lang_set_ext;
	}
	
	/**
	 * core.page_footer
	 */
	public function on_footer()
	{
		$forum_id = $this->request->variable('f', 0);

		$enabled = (
			$this->auth->acl_get('f_post', $forum_id) ||
			$this->auth->acl_get('f_reply', $forum_id) ||
			$this->auth->acl_get('u_sendpm')
		);

		$enabled = ($enabled && $this->core->group_auth($this->config['quickquote_groups']));
	
		if($enabled)
		{
			$this->template->assign_vars([
				'QQ_ENABLED'			=> true,
				'QQ_FLOAT_BTN'			=> (bool)$this->config['quickquote_floatbtn'],
				'QQ_REPLY_OVERWRITE'	=> (int)$this->config['quickquote_reply_overwrite'],
			]);
			
			$this->template->append_asset('css', '@canidev_quickquote/quickquote.css');
			$this->template->append_asset('js', '@canidev_quickquote/quickquote.min.js');
		}
	}
	
	/**
	 * core.viewtopic_modify_post_row
	 * core.topic_review_modify_row
	 * 
	 * @param \phpbb\event\data 	$event
	 */
	public function modify_post_row($event)
	{
		$postrow = $event['post_row'];
		
		$ary = [
			'user'		=> $event['row']['user_id'],
			'username'	=> $event['row']['username'],
			'post'		=> $event['row']['post_id'],
			'time'		=> $event['row']['post_time'],
		];
		
		$postrow['MESSAGE'] .= '<script class="js-qq-post-info" type="application/json">' . json_encode($ary) . '</script>';
		
		$event['post_row'] = $postrow;
	}
	
	/**
	 * core.viewforum_get_topic_data
	 * @param \phpbb\event\data 	$event
	 */
	public function set_viewforum_reply($event)
	{
		$u_reply = append_sid($this->phpbb_root_path . 'posting.' . $this->php_ext, [
			'mode'		=> 'post',
			'f'			=> $event['forum_id'],
		], false);
		
		$this->template->assign_var('U_QQ_REPLY', $u_reply);
	}
	
	/**
	 * core.viewtopic_assign_template_vars_before
	 * @param \phpbb\event\data 	$event
	 */
	public function set_viewtopic_reply($event)
	{
		$u_reply = append_sid($this->phpbb_root_path . 'posting.' . $this->php_ext, [
			'mode'		=> 'reply',
			'f'			=> $event['forum_id'],
			't'			=> $event['topic_id'],
		], false);
		
		$this->template->assign_var('U_QQ_REPLY', $u_reply);
	}
	
	/**
	 * core.ucp_pm_view_messsage
	 * @param \phpbb\event\data 	$event
	 */
	public function modify_pm_row($event)
	{
		$row = $event['msg_data'];
		
		$ary = [
			'user'		=> $event['user_info']['user_id'],
			'username'	=> $event['user_info']['username'],
			'time'		=> $event['message_row']['message_time'],
		];
		
		$row['MESSAGE'] .= '<script class="js-qq-post-info" type="application/json">' . json_encode($ary) . '</script>';
		
		$event['msg_data'] = $row;
		
		$u_reply = append_sid($this->phpbb_root_path . 'ucp.' . $this->php_ext, [
			'i'			=> 'pm',
			'mode'		=> 'compose',
			'action'	=> 'reply',
			'p'			=> $event['msg_id'],
		], false);
		
		$this->template->assign_var('U_QQ_REPLY', $u_reply);
	}
}