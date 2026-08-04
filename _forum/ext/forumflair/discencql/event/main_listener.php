<?php

/*
* @package phpBB Extension - Discussion Encouragement With Quick Login
* @copyright (c) 2022, ForumFlair, https://forumflair.co.uk
* @license GNU General Public License, version 2 (GPL-2.0)
*/

namespace forumflair\discencql\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class main_listener implements EventSubscriberInterface
{
	protected $language;
	protected $config;
	protected $controller_helper;
	protected $template;

	public function __construct(\phpbb\language\language $language, \phpbb\config\config $config, \phpbb\controller\helper $controller_helper, \phpbb\template\template $template)
	{
		$this->language			= $language;
		$this->config			= $config;
		$this->controller_helper	= $controller_helper;
		$this->template			= $template;
	}

	public static function getSubscribedEvents()
	{
		return array(
			'core.user_setup'					=> 'load_lang',
			'core.viewtopic_modify_page_title'	=> 'set_login_vars',
		);
	}

	public function load_lang()
	{
		$this->language->add_lang('common', 'forumflair/discencql');
	}

	/**
	 * Assign the "forgot password" URL under our own variable name.
	 *
	 * phpBB's own U_SEND_PASSWORD is only ever assigned by login_box() and index.php,
	 * never by viewtopic.php, so this extension's quick-login form (which only renders
	 * on viewtopic) needs its own copy of the same check.
	 */
	public function set_login_vars()
	{
		$this->template->assign_var('DISCENCQL_U_SEND_PASSWORD', ($this->config['email_enable'] && $this->config['allow_password_reset']) ? $this->controller_helper->route('phpbb_ucp_forgot_password_controller') : '');
	}
}
