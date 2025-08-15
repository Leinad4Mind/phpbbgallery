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
	protected $auth;
	protected $provider_collection;
	protected $users_table;
	private $oauth_service;
	public function __construct(\phpbb\db\driver\driver_interface $db, \phpbb\user $user, \phpbb\template\template $template, \phpbb\config\config $config, \phpbb\auth\auth $auth, \phpbb\auth\provider_collection $provider_collection, $users_table)
    
	{
		$this->db = $db;
		$this->user = $user;
		$this->template = $template;
		$this->config = $config;
		$this->auth = $auth;
		$this->provider_collection = $provider_collection;
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

			'core.index_modify_page_title'	=> 'display_oauth_options',

			'sitesplat.tfa.login_box_redirect'	=> 'set_login_type_common_tfa',
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

	public function set_login_type_common_tfa()
	{
		$sql = 'UPDATE ' . $this->users_table . "
				SET user_last_login_type = ''
				WHERE user_id = " . $this->user->data['user_id'];
		$this->db->sql_query($sql);
	}

	public function display_login_type()
	{
		$this->template->assign_var('LOGIN_TYPE', $this->user->data['user_last_login_type']);
	}

	public function add_to_oauth_group($event)
	{
		if ($this->config['sitesplat_bboauth_group'] && !$this->auth->acl_get('a_') && !$this->auth->acl_get('m_'))
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

	public function display_oauth_options()
	{
		if (!$this->user->data['is_registered'])
		{
			$auth_provider = $this->provider_collection->get_provider();
			$auth_provider_data = $auth_provider->get_login_data();
			if ($auth_provider_data)
			{
				if (isset($auth_provider_data['VARS']))
				{
					$this->template->assign_vars($auth_provider_data['VARS']);
				}

				if (isset($auth_provider_data['BLOCK_VAR_NAME']))
				{
					foreach ($auth_provider_data['BLOCK_VARS'] as $block_vars)
					{
						// we need to fix URL first
						$block_vars['REDIRECT_URL'] = str_replace(['index.', '?'], ['ucp.', '?mode=login'], $block_vars['REDIRECT_URL']);

						$this->template->assign_block_vars($auth_provider_data['BLOCK_VAR_NAME'], $block_vars);
					}
				}

				$this->template->assign_vars(array(
					'S_IS_INDEX'				=> true,
					'PROVIDER_TEMPLATE_FILE'	=> $auth_provider_data['TEMPLATE_FILE'],
				));
			}
		}
	}
}
