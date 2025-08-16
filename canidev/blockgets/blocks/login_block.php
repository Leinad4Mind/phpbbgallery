<?php
/*
* @package cBB Blockgets
* @version v2.0.4 30/08/2021
*
* @copyright (c) 2021 CaniDev
* @license https://opensource.org/licenses/gpl-license.php GNU Public License
*/

namespace canidev\blockgets\blocks;

class login_block extends base
{
	static $icon = 'fa-user';

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
			
			$this->lang->add_lang('ucp');

			$username	= $this->request->variable('username', '', true);
			$password	= $this->request->untrimmed_variable('password', '', true);
			$autologin	= $this->request->variable('autologin', false);
			$viewonline = !$this->request->is_set_post('viewonline');
			
			// Check form key on phpBB > 3.2.5
			if($password && !check_form_key('login'))
			{
				$result = array(
					'status' 	=> false,
					'error_msg'	=> 'FORM_INVALID',
				);
			}
			else
			{
				// If authentication is successful we redirect user to previous page
				$result = $this->auth->login($username, $password, $autologin, $viewonline);
			}

			switch($result['status'])
			{
				case LOGIN_SUCCESS:
					$this->helper->json->add(array(
						'message'		=> $this->lang->lang('LOGIN_REDIRECT'),
						'return_url'	=> $this->helper->current_url(
							array(
								'sid' => $this->user->session_id
							),
							false
						)
					));
					return true;
				break;

				case LOGIN_ERROR_ATTEMPTS:
					$this->helper->json->add(array(
						'redirect'	=> $this->helper->url('ucp', 'mode=login')
					));
					
					return true;
				break;

				case LOGIN_ERROR_PASSWORD_CONVERT:
					$err = $this->lang->lang(
						$result['error_msg'],
						($config['email_enable']) ? '<a href="' . $this->helper->url('ucp', 'mode=sendpassword') . '">' : '',
						($config['email_enable']) ? '</a>' : '',
						'<a href="' . phpbb_get_board_contact_link($this->config, $this->phpbb_root_path, $this->php_ext) . '">',
						'</a>'
					);
				break;

				// Username, password, etc...
				case LOGIN_BREAK:
				default:
					$err = $this->lang->lang($result['error_msg']);

					// Assign admin contact to some error messages
					if ($result['error_msg'] == 'LOGIN_ERROR_USERNAME' || $result['error_msg'] == 'LOGIN_ERROR_PASSWORD')
					{
						$err = $this->lang->lang($result['error_msg'], '<a href="' . $this->helper->url('memberlist', 'mode=contactadmin') . '">', '</a>');
					}
				break;
			}
		}
		else if($method == 'logout')
		{
			if($this->user->data['user_id'] != ANONYMOUS && $this->request->variable('sid', '') === $this->user->session_id)
			{
				$this->user->session_kill();
				$this->helper->json->send(array(
					'redirect'	=> $this->helper->current_url(
						array(
							'sid' => $this->user->session_id
						),
						false,
						array('jblgm', 'm')
					)
				));
			}
			else if($this->user->data['user_id'] != ANONYMOUS)
			{
				$err = $this->lang->lang('LOGOUT_FAILED');
			}
		}
		
		if(isset($err))
		{
			$this->helper->json->send(array(
				'message'	=> $err,
				'status'	=> \canidev\core\json_response::JSON_STATUS_ERROR
			));
		}
	
		if($this->user->data['is_registered'])
		{
			$links = array(
				'SEARCH_NEW'	=> array('url' => 'U_SEARCH_NEW', 	'icon' => 'fa-file-o icon-red'),
				'SEARCH_SELF'	=> array('url' => 'U_SEARCH_SELF', 	'icon' => 'fa-file-o'),
				'MY_BOOKMARKS'	=> array('url' => $this->helper->url('ucp', 'i=main&amp;mode=bookmarks'), 	'icon' => 'fa-star-o'),
				'MY_SUBSCRIBED'	=> array('url' => $this->helper->url('ucp', 'i=main&amp;mode=subscribed'), 	'icon' => 'fa-bookmark-o'),
			);
			
			if($this->config['allow_privmsg'] && ($this->auth->acl_get('u_readpm') || $this->auth->acl_get('u_sendpm')))
			{
				$pm_title = $this->lang->lang('PRIVATE_MESSAGES') . (($this->user->data['user_unread_privmsg']) ? ' (' . $this->user->data['user_unread_privmsg'] . ')' : '');
				
				$links[$pm_title] = array(
					'url' => 'U_PRIVATEMSGS',
					'icon' => 'fa-inbox',
				);
			}

			/*
			* @event block.login_links
			* @var array	links		Array with visible links
			* @var	array	data		Block Configuration
			* @since 2.0.0
			*/
			$vars = array('links', 'data');
			extract($this->dispatcher->trigger_event('block.login_links', compact($vars)));
			
			foreach($links as $title => $link)
			{
				$this->template->assign_block_vars('userlink', array(
					'ICON'		=> $link['icon'],
					'TITLE'		=> $this->lang->lang($title),
					'URL'		=> (strpos($link['url'], 'U_') === 0) ? $this->template->get_var($link['url']) : $link['url'],
				));
			}
			unset($links);
			
			$break	= ($this->view_is_small()) ? '<br />' : '';

			if(!function_exists('phpbb_get_user_rank'))
			{
				include($this->phpbb_root_path . 'includes/functions_display.' . $this->php_ext);
			}
			
			$user_rank_data = phpbb_get_user_rank($this->user->data, $this->user->data['user_posts']);

			$user_avatar = phpbb_get_user_avatar(array(
				'avatar'		=> $this->user->data['user_avatar'],
				'avatar_type'	=> $this->user->data['user_avatar_type'],
				'avatar_width'	=> $this->user->data['user_avatar_width'], 
				'avatar_height'	=> $this->user->data['user_avatar_height'],
			));
			
			$this->template->assign_vars(array(
				'S_LAST_VISIT'		=> $this->lang->lang('YOU_LAST_VISIT', $break . $this->user->format_date($this->user->data['session_last_visit'])),
				'S_CURRENT_TIME'	=> $this->lang->lang('CURRENT_TIME', $break . $this->user->format_date(time(), false, true)),
		
				'USER_AVATAR'		=> $user_avatar,
				'USERNAME_FULL'     => get_username_string('full', $this->user->data['user_id'], $this->user->data['username'], $this->user->data['user_colour']),
				'USER_RANK_TITLE'	=> $user_rank_data['title'],
				'USER_RANK_IMG'		=> $user_rank_data['img'],
				
				'U_LOGOUT'		=> $this->helper->current_url(array(
					'jblgm'	=> $this->data['block_id'],
					'm'		=> 'logout',
					'sid'	=> $this->user->session_id,
				)),
			));
		}
		else
		{
			add_form_key('login', '_BLG_LOGIN');

			$this->template->assign_vars(array(
				'S_DISPLAY_FULL_LOGIN'		=> $data['full_login'],
				'S_DISPLAY_REGISTER'		=> $data['show_register'],
				'S_USERNAME'				=> $username,

				'S_BLG_LOGIN_FIELDS'		=> build_hidden_fields(array(
					'sid'		=> $this->user->session_id,
					'jblgm'		=> $this->data['block_id'],
				)),
				
				'U_SEND_PASSWORD' 		=> ($this->config['email_enable']) ? $this->helper->url('ucp', 'mode=sendpassword') : '',
				'U_RESEND_ACTIVATION'	=> ($this->config['require_activation'] == USER_ACTIVATION_SELF && $this->config['email_enable']) ? $this->helper->url('ucp', 'mode=resend_act') : '',
				'U_TERMS_USE'			=> $this->helper->url('ucp', 'mode=terms'),
				'U_PRIVACY'				=> $this->helper->url('ucp', 'mode=privacy'),
			));

			if($data['alt_login'])
			{
				/* @var $provider_collection \phpbb\auth\provider_collection */
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

	public function get_config()
	{
		$this->display_vars = array(
			'alt_login'		=> array('lang' => 'ALT_LOGIN',		'validate' => 'bool',	'type' => 'radio:yes_no',	'default' => 1),
			'full_login'	=> array('lang' => 'FULL_LOGIN',	'validate' => 'bool',	'type' => 'radio:yes_no',	'default' => 1),
			'show_register'	=> array('lang' => 'SHOW_REGISTER',	'validate' => 'bool',	'type' => 'radio:yes_no',	'default' => 1),
		);

		return true;
	}
}
