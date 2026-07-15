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

class oauth_reg_listener implements EventSubscriberInterface 
{
	protected $request;
	protected $config;
	protected $auth;
	protected $user;
	protected $language;
	protected $template;
	protected $db;
	protected $dispatcher;
	protected $oauth_facebook;
	protected $oauth_twitter;
	protected $oauth_google;
	protected $oauth_coinbase;
	protected $oauth_discord;
	protected $oauth_dropbox;
	protected $oauth_github;
	protected $oauth_razer;
	protected $oauth_tokens_table;
	protected $oauth_states_table;
	protected $root_path;
	protected $php_ext;

	private $now;
	private $token;
	private $password;
	private $login_link_data = [];
	private $oauth_reg = false;
	private $oauth_token = [];
	public function __construct(\phpbb\request\request $request, \phpbb\config\config $config, \phpbb\auth\auth $auth, \phpbb\user $user, \phpbb\language\language $language, \phpbb\template\template $template, \phpbb\db\driver\driver_interface $db, \phpbb\event\dispatcher_interface $dispatcher, \phpbb\auth\provider\oauth\service\facebook $oauth_facebook, \phpbb\auth\provider\oauth\service\twitter $oauth_twitter, \phpbb\auth\provider\oauth\service\google $oauth_google, \sitesplat\bboauth\auth\provider\oauth\service\coinbase $oauth_coinbase, \sitesplat\bboauth\auth\provider\oauth\service\discord $oauth_discord, \sitesplat\bboauth\auth\provider\oauth\service\dropbox $oauth_dropbox, \sitesplat\bboauth\auth\provider\oauth\service\github $oauth_github, \sitesplat\bboauth\auth\provider\oauth\service\razer $oauth_razer, $oauth_tokens_table, $oauth_states_table, $root_path, $php_ext)
	{
		$this->request = $request;
		$this->config = $config;
		$this->auth = $auth;
		$this->user = $user;
		$this->language = $language;
		$this->template = $template;
		$this->db = $db;
		$this->dispatcher = $dispatcher;
		$this->oauth_facebook = $oauth_facebook;
		$this->oauth_twitter = $oauth_twitter;
		$this->oauth_google = $oauth_google;
		$this->oauth_coinbase = $oauth_coinbase;
		$this->oauth_discord = $oauth_discord;
		$this->oauth_dropbox = $oauth_dropbox;
		$this->oauth_github = $oauth_github;
		$this->oauth_razer = $oauth_razer;
		$this->oauth_tokens_table = $oauth_tokens_table;
		$this->oauth_states_table = $oauth_states_table;
		$this->root_path = $root_path;
		$this->php_ext = $php_ext;
	}
	
	static public function getSubscribedEvents()
	{
		return [
			'core.ucp_login_link_template_after'		=> 'replace_registration_btn_and_skip_terms',

			'core.ucp_register_requests_after'			=> 'is_registration_oauth',
			'core.ucp_register_data_before'				=> [['preload_user_data'], ['skip_registration']],
			'core.add_form_key'							=> 'read_form_key',
			'core.ucp_register_data_after'				=> 'ignore_captcha_and_form_key',
			'core.ucp_register_welcome_email_before'	=> 'welcome_email_password',
			'core.ucp_register_register_after'			=> 'auto_login',
		];
	}

	public function replace_registration_btn_and_skip_terms($event)
	{
		$this->language->add_lang('registration', 'sitesplat/bboauth');

		$this->template->assign_var('L_REGISTER', $this->language->lang('AGREE_AND_REGISTER', ucfirst($this->request->variable('login_link_oauth_service', ''))));

		$event->update_subarray('tpl_ary', 'S_HIDDEN_FIELDS', $event['tpl_ary']['S_HIDDEN_FIELDS'] . build_hidden_fields(['agreed'	=> true]));

		/**
		 * Allows to execute code only when BBOAuth skips terms and attempts quick registration
		 *
		 * @event sitesplat.bboauth.ucp_login_link
		 * @var	\phpbb\event\data	event	Event data from core.ucp_register_data_before
		 * @since 1.2.0
		 */
		$this->dispatcher->trigger_event('sitesplat.bboauth.ucp_login_link');
	}

	public function is_registration_oauth()
	{
		$this->login_link_data = $this->get_login_link_data_array();
		if (empty($this->login_link_data['oauth_service']))
		{
			return;
		}

		$sql = 'SELECT oauth_token
				FROM ' . $this->oauth_tokens_table . "
				WHERE session_id = '" . $this->user->data['session_id'] . "'
					AND provider = 'auth.provider.oauth.service." . $this->db->sql_escape($this->login_link_data['oauth_service']) . "'";
		$result = $this->db->sql_query($sql);
		$oauth_token = $this->db->sql_fetchfield('oauth_token', false, $result);
		$this->db->sql_freeresult($result);

		if ($oauth_token)
		{
			$this->oauth_reg = true;
			$this->oauth_token = json_decode($oauth_token, true);
			$this->config['enable_confirm'] = false;
		}
	}

	public function preload_user_data($event)
	{
		if (!$this->oauth_reg)
		{
			return;
		}

		if (empty($data['username']) && empty($data['email']))
		{
			$data = $event['data'];

			$storage = new \phpbb\auth\provider\oauth\token_storage($this->db, $this->user, $this->oauth_tokens_table, $this->oauth_states_table);
			$service_factory = new \OAuth\ServiceFactory();

			$service_name = '';
			switch ($this->login_link_data['oauth_service'])
			{
				case 'facebook':
					// perform extra call to fetch user data
					$service_credentials = $this->oauth_facebook->get_service_credentials();
					$credentials = new \OAuth\Common\Consumer\Credentials($service_credentials['key'], $service_credentials['secret'], '');
					$facebook_service = $service_factory->createService('Facebook', $credentials, $storage, $this->oauth_facebook->get_auth_scope());

					$result = json_decode($facebook_service->request('me'), true);

					$service_name = $facebook_service->service();
					$data = array_merge($data, [
						'username'	=> $result['name'],
						'email'		=> !empty($result['email']) ? $result['email'] : '',
					]);
				break;

				// case 'twitter':
				// print_r($oauth_token);die;
				// 	// perform extra call to fetch user data
				// 	$service_credentials = $this->oauth_twitter->get_service_credentials();
				// 	$credentials = new \OAuth\Common\Consumer\Credentials($service_credentials['key'], $service_credentials['secret'], '');
				// 	$twitter_service = $service_factory->createService('Twitter', $credentials, $storage, $this->oauth_twitter->get_auth_scope());

				// 	$result = json_decode($twitter_service->request('me'), true);

				//	$service_name = $twitter_service->service();
				// 	$data = array_merge($data, [
				// 		'username'	=> $result['name'],
				// 		'email'		=> !empty($result['email']) ? $result['email'] : '',
				// 	]);
				// break;

				case 'google':
					// perform extra call to fetch user data
					$service_credentials = $this->oauth_google->get_service_credentials();
					$credentials = new \OAuth\Common\Consumer\Credentials($service_credentials['key'], $service_credentials['secret'], '');
					$google_service = $service_factory->createService('Google', $credentials, $storage, $this->oauth_google->get_auth_scope());

					$result = json_decode($google_service->request('userinfo'), true);

					$service_name = $google_service->service();
					$data = array_merge($data, [
						'username'	=> !empty($result['name']) ? $result['name'] : '',
						'email'		=> !empty($result['email']) ? $result['email'] : '',
					]);
				break;

				case 'coinbase':
					// perform extra call to fetch user data
					$service_credentials = $this->oauth_coinbase->get_service_credentials();
					$credentials = new \OAuth\Common\Consumer\Credentials($service_credentials['key'], $service_credentials['secret'], '');
					$coinbase_service = $service_factory->createService('Coinbase', $credentials, $storage, $this->oauth_coinbase->get_auth_scope());
					
					$result = json_decode($coinbase_service->request('user'), true);

					$service_name = $coinbase_service->service();
					$data = array_merge($data, [
						'username'	=> !empty($result['data']['username']) ? $result['data']['username'] : $result['data']['name'],
						'email'		=> $result['data']['email'],
					]);
				break;

				case 'discord':
					// perform extra call to fetch user data
					$service_credentials = $this->oauth_discord->get_service_credentials();
					$credentials = new \OAuth\Common\Consumer\Credentials($service_credentials['key'], $service_credentials['secret'], '');
					$dropbox_service = $service_factory->createService('Discord', $credentials, $storage, $this->oauth_discord->get_auth_scope());
					
					$result = json_decode($dropbox_service->request('/users/@me'), true);

					$service_name = $dropbox_service->service();
					$data = array_merge($data, [
						'username'	=> $result['username'],
						'email'		=> $result['email'],
					]);
				break;

				// case 'dropbox':
				// 	// perform extra call to fetch user data
				// 	$service_credentials = $this->oauth_dropbox->get_service_credentials();
				// 	$credentials = new \OAuth\Common\Consumer\Credentials($service_credentials['key'], $service_credentials['secret'], '');
				// 	$dropbox_service = $service_factory->createService('Dropbox', $credentials, $storage, $this->oauth_dropbox->get_auth_scope());
					
				// 	$result = json_decode($dropbox_service->request('/2/users/get_current_account'), true);

				//	$service_name = $dropbox_service->service();
				// 	$data = array_merge($data, [
				// 		'username'	=> $result['name']['display_name'],
				// 		'email'		=> $result['email'] ?: '',
				// 	]);
				// 	$this->oauth_reg = true;
				// break;

				case 'github':
					// perform extra call to fetch user data
					$service_credentials = $this->oauth_github->get_service_credentials();
					$credentials = new \OAuth\Common\Consumer\Credentials($service_credentials['key'], $service_credentials['secret'], '');
					$github_service = $service_factory->createService('Github', $credentials, $storage, $this->oauth_github->get_auth_scope());
					
					$result = json_decode($github_service->request('user'), true);

					$service_name = $github_service->service();
					$data = array_merge($data, [
						'username'	=> $result['login'],
						'email'		=> $result['email'] ?: '',
					]);
				break;

				case 'instagram':
					$service_name = 'instagram';
					$data = array_merge($data, [
						'username'	=> $this->oauth_token['extraParams']['user']['username'],
					]);
				break;

				case 'slack':
					$service_name = 'slack';
					$data = array_merge($data, [
						'username'	=> $this->oauth_token['extraParams']['user']['name'],
						'email'		=> $this->oauth_token['extraParams']['user']['email'],
					]);
				break;

				case 'razer':
					// perform extra call to fetch user data
					$service_credentials = $this->oauth_razer->get_service_credentials();
					$credentials = new \OAuth\Common\Consumer\Credentials($service_credentials['key'], $service_credentials['secret'], '');
					$razer_service = $service_factory->createService('Razer', $credentials, $storage, $this->oauth_razer->get_auth_scope());
					
					$result = json_decode($razer_service->request('/userinfo'), true);

					$service_name = $razer_service->service();
					$data = array_merge($data, [
						'username'	=> $result['razer_id'],
						'email'		=> isset($result['email']) ? $result['email'] : '',
					]);
				break;
			}

			// check whether email address exists...if it does,
			// associate the user instead of completing registration
			if (!empty($data['email']))
			{
				$email_where = (version_compare(PHPBB_VERSION, '3.2.99', '>')) ? ("user_email = '" . $this->db->sql_escape($data['email']) . "'") : 'user_email_hash = ' . phpbb_email_hash($data['email']);
				$result = $this->db->sql_query("SELECT user_id FROM " . USERS_TABLE . " WHERE $email_where");
				$user_id = (int) $this->db->sql_fetchfield('user_id');
				$this->db->sql_freeresult($result);

				if ($user_id) {
					if ($this->config['sitesplat_bboauth_group'])
					{
						group_user_add($this->config['sitesplat_bboauth_group'], [$user_id]);
					}

					$this->user->session_create($user_id, false, true);

					$sql = "UPDATE " . USERS_TABLE . "
						SET user_last_login_type = '" . $this->db->sql_escape($service_name) . "'
						WHERE user_id = $user_id";
					$this->db->sql_query($sql);

					garbage_collection();
					header('Location: ' . generate_board_url());
					exit;
				}
			}

			$data = array_merge($data, [
				'tz'	=> $this->config['board_timezone'],
				'lang'	=> $this->user->lang_name,
			]);

			$event['data'] = $data;
		}
	}

	public function read_form_key($event)
	{
		if ($event['form_name'] === 'ucp_register')
		{
			$this->now = $event['now'];
			$this->token = $event['token'];
		}
	}

	public function skip_registration($event)
	{
		if (!$this->oauth_reg || $this->disabled($event['data']))
		{
			return;
		}

		$this->password = gen_rand_string(mt_rand(6, 10));
		$event->update_subarray('data', 'new_password', $this->password);
		$event->update_subarray('data', 'password_confirm', $this->password);

		$event['submit'] = true;

		/**
		 * Autofill other data
		 *
		 * @event sitesplat.bboauth.skip_registration
		 * @var	\phpbb\event\data	event	Event data from core.ucp_register_data_before
		 * @since 1.2.0
		 */
		$vars = array(
			'event',
		);
		extract($this->dispatcher->trigger_event('sitesplat.bboauth.skip_registration', compact($vars)));

		$this->request->overwrite('creation_time', $this->now);
		$this->request->overwrite('form_token', $this->token);

		// the worst code of my life
		// this is needed because check_form_key() thinks you are a robot when you didn't take at least 1s to complete the form.
		sleep(1);
	}

	public function ignore_captcha_and_form_key($event)
	{
		if (!$this->oauth_reg)
		{
			return;
		}

		$error = $event['error'];

		$captcha_error = array_search($this->language->lang('CONFIRM_CODE_WRONG'), $error);
		if ($captcha_error !== false)
		{
			unset($error[$captcha_error]);
		}
		
		$form_key_error = array_search($this->language->lang('FORM_INVALID'), $error);
		if ($form_key_error !== false)
		{
			unset($error[$form_key_error]);
		}

		$event['error'] = $error;
	}

	public function welcome_email_password($event)
	{
		if (!$this->oauth_reg)
		{
			return;
		}

		$event['messenger']->template('@sitesplat_bboauth/user_welcome_password', $event['data']['lang']);
		$event['messenger']->assign_vars([
			'PASSWORD'		=> $this->password,
			'S_ACTIVATE'	=> $this->config['require_activation'] == USER_ACTIVATION_SELF,
		]);
	}

	public function auto_login($event)
	{
		if (!$this->oauth_reg || $this->config['require_activation'] != USER_ACTIVATION_NONE)
		{
			return;
		}

		$this->language->add_lang('registration', 'sitesplat/bboauth');

		$event['message'] = $this->language->lang('OAUTH_ACCOUNT_ADDED');
		$this->auth->login($event['data']['username'], $this->password);
	}

	protected function disabled($data)
	{
		if (!$this->config['sitesplat_bboauth_autoregistration'])
		{
			return true;
		}

		// display registration page when we don't have enough information
		if (empty($data['username']) || empty($data['email']))
		{
			return true;
		}

		return false;
	}

	/**
	* !!! COPIED FROM ucp_register.php !!!
	*
	* Creates the login_link data array
	*
	* @return	array	Returns an array of all POST paramaters whose names
	*					begin with 'login_link_'
	*/
	protected function get_login_link_data_array()
	{
		$var_names = $this->request->variable_names(\phpbb\request\request_interface::POST);
		$login_link_data = array();
		$string_start_length = strlen('login_link_');

		foreach ($var_names as $var_name)
		{
			if (strpos($var_name, 'login_link_') === 0)
			{
				$key_name = substr($var_name, $string_start_length);
				$login_link_data[$key_name] = $this->request->variable($var_name, '', false, \phpbb\request\request_interface::POST);
			}
		}

		return $login_link_data;
	}
}
