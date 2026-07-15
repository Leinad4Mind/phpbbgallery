<?php
/**
*
* Castle
*
* @copyright (c) 2018 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\castle\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class main_listener implements EventSubscriberInterface
{
	static public function getSubscribedEvents()
	{
		return array(
			'core.page_header_after'				=> 'assign_user_data',
			'core.auth_login_session_create_before'	=> 'successful_login',
			'core.login_box_failed'					=> 'failed_login',
			'core.ucp_profile_reg_details_sql_ary'	=> 'successful_password_email_change',
			'core.ucp_profile_reg_details_validate'	=> 'failed_password_email_change',
			'core.ucp_activate_after'				=> 'incident_mitigated',
		);
	}

	protected $template;
	protected $user;
	protected $request;
	protected $config;
	protected $captcha_factory;
	protected $castle_sdk_path;
	protected $castle_configured = false;
	public function __construct(\phpbb\template\template $template, \phpbb\user $user, \phpbb\request\request $request, \phpbb\config\config $config, \phpbb\captcha\factory $captcha_factory, $castle_sdk_path)
	{
		$this->template = $template;
		$this->user = $user;
		$this->request = $request;
		$this->config = $config;
		$this->captcha_factory = $captcha_factory;

		if (!empty($this->config['castle_app_id']) && !empty($this->config['castle_api_secret']))
		{
			require_once($castle_sdk_path . 'lib/Castle.php');
			\Castle::setApiKey($this->config['castle_api_secret']);
			$this->castle_configured = true;
		}
	}

	public function assign_user_data()
	{
		if ($this->castle_configured)
		{
			$this->template->assign_vars(array(
				'CASTLE_APP_ID'		=> $this->config['castle_app_id'],
				'CASTLE_SECURE'		=> hash_hmac('sha256', $this->user->data['user_id'], $this->config['castle_api_secret']),
				'CASTLE_USER_ID'	=> $this->user->data['user_id'],
				'CASTLE_USER_EMAIL'	=> $this->user->data['user_email'],
			));
		}
	}

	public function successful_login($event)
	{
		if ($this->castle_configured)
		{
			$challenge_cookie = $this->request->is_set($this->config['cookie_name'] . '_castle_challenge', \phpbb\request\request_interface::COOKIE);
			if ($event['login']['status'] == LOGIN_SUCCESS)
			{
				$this->request->enable_super_globals();
				if ($challenge_cookie)
				{
					$this->user->set_cookie('castle_challenge', '', 1);
					\Castle::track(array(
						'event'		=> '$challenge.succeeded',
						'user_id'	=> $this->user->data['user_id'],
					));
				}

				$verdict = \Castle::authenticate(array(
					'event'		=> '$login.succeeded',
					'user_id'	=> $this->user->data['user_id'],
					'traits'	=> array(
						'username'	=> $this->user->data['username'],
						'email'		=> $this->user->data['user_email'],
					),
				));

				// User can't be logged in, yet. We need to present him with captcha code
				if ($verdict->action == 'challenge')
				{
					$login = $event['login'];
					$login['status'] = LOGIN_ERROR_ATTEMPTS;
					$event['login'] = $login;

					$this->user->set_cookie('castle_challenge', '', 0);
					\Castle::track(array(
						'event'		=> '$challenge.requested',
						'user_id'	=> $this->user->data['user_id'],
					));
				}
				else if ($verdict->action == 'deny')
				{
					$login = $event['login'];
					$login['status'] = LOGIN_CONTINUE;
					$event['login'] = $login;
				}
				$this->request->disable_super_globals();
			}
			else if ($challenge_cookie && ($event['login']['status'] == LOGIN_ERROR_USERNAME || $event['login']['status'] == LOGIN_ERROR_PASSWORD))
			{
				\Castle::track(array(
					'event'		=> '$challenge.failed',
					'user_id'	=> $this->user->data['user_id'],
				));
			}
		}
	}

	public function failed_login($event)
	{
		if ($this->castle_configured)
		{
			$this->request->enable_super_globals();
			\Castle::track(array(
				'event' => '$login.failed',
				'properties' => array(
					'username' => $event['username'],
				)
			));
			$this->request->disable_super_globals();
		}
	}

	public function successful_password_email_change($event)
	{
		if ($this->castle_configured)
		{
			$this->request->enable_super_globals();
			if (!empty($event['data']['new_password']) && $event['data']['new_password'] != $event['data']['cur_password'])
			{
				\Castle::track(array(
					'event' => '$password_change.succeeded',
					'user_id' => $this->user->data['user_id'],
				));
			}
			if ($event['data']['email'] != $this->user->data['user_email'])
			{
				\Castle::track(array(
					'event' => '$email_change.succeeded',
					'user_id' => $this->user->data['user_id'],
				));
			}
			$this->request->disable_super_globals();
		}
	}

	public function failed_password_email_change($event)
	{
		if ($this->castle_configured)
		{
			$this->request->enable_super_globals();
			if (count($event['error']))
			{
				if (!empty($event['data']['new_password']))
				{
					\Castle::track(array(
						'event' => '$password_change.failed',
						'user_id' => $this->user->data['user_id'],
					));
				}
				if ($event['data']['email'] != $this->user->data['user_email'])
				{
					\Castle::track(array(
						'event' => '$email_change.failed',
						'user_id' => $this->user->data['user_id'],
					));
				}
			}
			$this->request->disable_super_globals();
		}
	}

	public function incident_mitigated($event)
	{
		if ($this->castle_configured)
		{
			if ($this->config['castle_hook_configured'] && $event['message'] == 'ACCOUNT_ACTIVE_PROFILE')
			{
				$this->request->enable_super_globals();
				\Castle::track(array(
					'event'		=> '$incident.mitigated',
					'user_id'	=> $event['user_row']['user_id'],
				));
				$this->request->disable_super_globals();
			}
		}
	}
}
