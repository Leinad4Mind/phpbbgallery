<?php
/**
 * @package cBB Blockgets
 * @version 2.0.7 01/07/2024
 *
 * @copyright (c) 2024 CaniDev
 * @license https://creativecommons.org/licenses/by-nc/4.0/
 */

namespace canidev\blockgets\blocks;

class login_block extends base
{
	static $icon = 'fa-user';

	/**
	 * {@inheritDoc}
	 */
	public function init($method = '')
	{
		$this->tpl_name = 'login_block';

		if(($data = $this->unserialize()) === false || $this->user->data['is_bot'])
		{
			return false;
		}
		
		// Delete the array in the template if exists, prevent errors between blocks
		$this->template->destroy_block_vars('userlink');
		
		$username = '';
		
		if($method == 'submit' && $this->request->is_set_post('login'))
		{
			if($this->user->data['is_registered'])
			{
				return true;
			}
			
			$this->language->add_lang('ucp');

			$username	= $this->request->variable('username', '', true);
			$password	= $this->request->untrimmed_variable('password', '', true);
			$autologin	= $this->request->variable('autologin', false);
			$viewonline = !$this->request->is_set_post('viewonline');
			
			// Check form key on phpBB > 3.2.5
			if($password && !check_form_key('login'))
			{
				$result = [
					'status' 	=> false,
					'error_msg'	=> 'FORM_INVALID',
				];
			}
			else
			{
				// If authentication is successful we redirect user to previous page
				$result = $this->auth->login($username, $password, $autologin, $viewonline);
			}

			switch($result['status'])
			{
				case LOGIN_SUCCESS:
					$this->helper->json->add([
						'message'		=> $this->language->lang('LOGIN_REDIRECT'),
						'returnUrl'		=> $this->helper->current_url(
							[
								'sid' => $this->user->session_id
							],
							false
						)
					]);
					
					return true;

				case LOGIN_ERROR_ATTEMPTS:
					$this->helper->json->add([
						'redirect'	=> $this->helper->url('ucp', 'mode=login')
					]);
					
					return true;

				case LOGIN_ERROR_PASSWORD_CONVERT:
					$err = $this->language->lang(
						$result['error_msg'],
						($this->config['email_enable']) ? '<a href="' . $this->helper->url('ucp', 'mode=sendpassword') . '">' : '',
						($this->config['email_enable']) ? '</a>' : '',
						'<a href="' . phpbb_get_board_contact_link($this->config, $this->phpbb_root_path, $this->php_ext) . '">',
						'</a>'
					);
				break;

				// Username, password, etc...
				case LOGIN_BREAK:
				default:
					$err = $this->language->lang($result['error_msg']);

					// Assign admin contact to some error messages
					if ($result['error_msg'] == 'LOGIN_ERROR_USERNAME' || $result['error_msg'] == 'LOGIN_ERROR_PASSWORD')
					{
						$err = $this->language->lang($result['error_msg'], '<a href="' . $this->helper->url('memberlist', 'mode=contactadmin') . '">', '</a>');
					}
				break;
			}
		}
		else if($method == 'logout')
		{
			if($this->user->data['user_id'] != ANONYMOUS && $this->request->variable('sid', '') === $this->user->session_id)
			{
				$this->user->session_kill();
				$this->helper->json->send([
					'redirect'	=> $this->helper->current_url(
						[
							'sid' => $this->user->session_id
						],
						false,
					 ['jblgm', 'm']
					)
				]);
			}
			else if($this->user->data['user_id'] != ANONYMOUS)
			{
				$err = $this->language->lang('LOGOUT_FAILED');
			}
		}
		
		if(isset($err))
		{
			$this->helper->json->send([
				'message'	=> $err,
				'status'	=> \canidev\core\JsonResponse::JSON_STATUS_ERROR
			]);
		}
	
		if($this->user->data['is_registered'])
		{
			$links = [
				'SEARCH_NEW'	=> ['url' => 'U_SEARCH_NEW', 	'icon' => 'fa-file-o icon-red'],
				'SEARCH_SELF'	=> ['url' => 'U_SEARCH_SELF', 	'icon' => 'fa-file-o'],
				'MY_BOOKMARKS'	=> ['url' => $this->helper->url('ucp', 'i=main&amp;mode=bookmarks'), 	'icon' => 'fa-star-o'],
				'MY_SUBSCRIBED'	=> ['url' => $this->helper->url('ucp', 'i=main&amp;mode=subscribed'), 	'icon' => 'fa-bookmark-o'],
			];
			
			if($this->config['allow_privmsg'] && ($this->auth->acl_get('u_readpm') || $this->auth->acl_get('u_sendpm')))
			{
				$pm_title = $this->language->lang('PRIVATE_MESSAGES') . (($this->user->data['user_unread_privmsg']) ? ' (' . $this->user->data['user_unread_privmsg'] . ')' : '');
				
				$links[$pm_title] = [
					'url' => 'U_PRIVATEMSGS',
					'icon' => 'fa-inbox',
				];
			}

			/**
			 * @event block.login_links
			 * @var array	links		Array with visible links
			 * @var	array	data		Block Configuration
			 * @since 2.0.0
			 */
			$vars = ['links', 'data'];
			extract($this->dispatcher->trigger_event('block.login_links', compact($vars)));
			
			foreach($links as $title => $link)
			{
				$this->template->assign_block_vars('userlink', [
					'ICON'		=> $link['icon'],
					'TITLE'		=> $this->language->lang($title),
					'URL'		=> (strpos($link['url'], 'U_') === 0) ? $this->template->get_var($link['url']) : $link['url'],
				]);
			}
			unset($links);
			
			$break	= ($this->view_is_small()) ? '<br />' : '';

			if(!function_exists('phpbb_get_user_rank'))
			{
				include($this->phpbb_root_path . 'includes/functions_display.' . $this->php_ext);
			}
			
			$user_rank_data = phpbb_get_user_rank($this->user->data, $this->user->data['user_posts']);

			$this->template->assign_vars([
				'S_LAST_VISIT'		=> $this->language->lang('YOU_LAST_VISIT', $break . $this->user->format_date($this->user->data['session_last_visit'])),
				'S_CURRENT_TIME'	=> $this->language->lang('CURRENT_TIME', $break . $this->user->format_date(time(), false, true)),
		
				'USER_AVATAR'		=> phpbb_get_user_avatar($this->user->data),
				'USERNAME_FULL'     => get_username_string('full', $this->user->data['user_id'], $this->user->data['username'], $this->user->data['user_colour']),
				'USER_RANK_TITLE'	=> $user_rank_data['title'],
				'USER_RANK_IMG'		=> $user_rank_data['img'],
				
				'U_LOGOUT'		=> $this->helper->current_url([
					'jblgm'	=> $this->data['block_id'],
					'm'		=> 'logout',
					'sid'	=> $this->user->session_id,
				]),
			]);
		}
		else
		{
			add_form_key('login', '_BLG_LOGIN');

			$this->template->assign_vars([
				'S_DISPLAY_FULL_LOGIN'		=> $data['full_login'],
				'S_DISPLAY_REGISTER'		=> $data['show_register'],
				'S_USERNAME'				=> $username,

				'S_BLG_LOGIN_FIELDS'		=> build_hidden_fields([
					'sid'		=> $this->user->session_id,
					'jblgm'		=> $this->data['block_id'],
				]),
				
				'U_SEND_PASSWORD' 		=> ($this->config['email_enable']) ? $this->helper->url('ucp', 'mode=sendpassword') : '',
				'U_RESEND_ACTIVATION'	=> ($this->config['require_activation'] == USER_ACTIVATION_SELF && $this->config['email_enable']) ? $this->helper->url('ucp', 'mode=resend_act') : '',
				'U_TERMS_USE'			=> $this->helper->url('ucp', 'mode=terms'),
				'U_PRIVACY'				=> $this->helper->url('ucp', 'mode=privacy'),
			]);

			if($data['alt_login'])
			{
				/** @var \phpbb\auth\provider_collection $provider_collection  */
				$provider_collection 	= $this->container->get('auth.provider_collection');
				$auth_provider 			= $provider_collection->get_provider();
				$auth_provider_data 	= $auth_provider->get_login_data();
				
				if($auth_provider_data)
				{
					if(isset($auth_provider_data['VARS']))
					{
						$this->template->assign_vars($auth_provider_data['VARS']);
					}

					if(isset($auth_provider_data['BLOCK_VAR_NAME']))
					{
						// Delete the array in the template if exists, prevent errors between blocks
						$this->template->destroy_block_vars($auth_provider_data['BLOCK_VAR_NAME']);

						foreach($auth_provider_data['BLOCK_VARS'] as $block_vars)
						{
							$this->template->assign_block_vars($auth_provider_data['BLOCK_VAR_NAME'], $block_vars);
						}
					}

					$this->template->assign_var('PROVIDER_TEMPLATE_FILE', $auth_provider_data['TEMPLATE_FILE']);
				}
			}
		}

		unset($data);
		return true;
	}

	/**
	 * {@inheritDoc}
	 */
	public function get_config()
	{
		$this->display_vars = [
			'alt_login'		=> ['lang' => 'ALT_LOGIN',		'validate' => 'bool',	'type' => 'radio:yes_no',	'default' => 1],
			'full_login'	=> ['lang' => 'FULL_LOGIN',		'validate' => 'bool',	'type' => 'radio:yes_no',	'default' => 1],
			'show_register'	=> ['lang' => 'SHOW_REGISTER',	'validate' => 'bool',	'type' => 'radio:yes_no',	'default' => 1],
		];

		return true;
	}
}
