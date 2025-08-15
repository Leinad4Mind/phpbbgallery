<?php
/**
*
* BBOAuth
*
* @copyright (c) 2018 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\bboauth\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class listener implements EventSubscriberInterface 
{
	protected $db;
	protected $user;
	protected $template;
	protected $config;
	protected $users_table;

	private $oauth_service;
	public function __construct(\phpbb\db\driver\driver_interface $db, \phpbb\user $user, \phpbb\template\template $template, \phpbb\config\config $config, $users_table)
	{
		$this->db = $db;
		$this->user = $user;
		$this->template = $template;
		$this->config = $config;
		$this->users_table = $users_table;
	}
	
	static public function getSubscribedEvents()
	{
		return array(
			// login type
			'core.oauth_login_after_check_if_provider_id_has_match'	=> 'get_oauth_service',
			'core.auth_oauth_login_after'							=> [['set_login_type'], ['add_to_oauth_group']],
			'core.login_box_redirect'								=> 'set_login_type_common',
			'core.page_header_after'								=> 'display_login_type',
			'core.user_setup'                                       => 'onUserSetup',
		);
	}

	public function get_oauth_service($event)
	{
		$this->oauth_service = $event['service']->service();
	}

	public function set_login_type($event)
	{
		$sql = 'UPDATE ' . $this->users_table . "
				SET user_last_login_type = '" . $this->db->sql_escape($this->oauth_service) . "'
				WHERE user_id = " . $event['row']['user_id'];
		$this->db->sql_query($sql);
	}

	public function set_login_type_common($event)
	{
		if (empty($this->oauth_service))
		{
			$sql = 'UPDATE ' . $this->users_table . "
					SET user_last_login_type = ''
					WHERE user_id = " . $event['result']['user_row']['user_id'];
			$this->db->sql_query($sql);
		}
	}

	public function display_login_type()
	{
		$this->template->assign_var('LOGIN_TYPE', $this->user->data['user_last_login_type']);
	}

	public function add_to_oauth_group($event)
	{
		if ($this->config['sitesplat_bboauth_group'])
		{
			group_user_add($this->config['sitesplat_bboauth_group'], [$event['row']['user_id']]);
		}
	}
	
	public function onUserSetup($event)
	{
		$set = $event['lang_set_ext'];
		$set[] = array(
			'ext_name' => 'sitesplat/bboauth',
			'lang_set' => 'bboauth',
		);
		$event['lang_set_ext'] = $set;
	}
}
