<?php
/*
* @name login_block.php
* @package cBB Blockgets
* @version v2.0.0 30/05/2017
*
* @copyright (c) 2017 CaniDev
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/

namespace canidev\blockgets\blocks;

// @ignore
if(!defined('IN_PHPBB'))
{
	exit;
}

class login_block extends base
{
	static $icon = 'blg-icon-user';

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
			
			$this->lang->add('ucp');

			$username	= $this->request->variable('username', '', true);
			$password	= $this->request->untrimmed_variable('password', '', true);
			$autologin	= $this->request->variable('autologin', false);
			$viewonline = !$this->request->is_set_post('viewonline');

			$result = $this->auth->login($username, $password, $autologin, $viewonline);

			switch($result['status'])
			{
				case LOGIN_SUCCESS:
					$this->helper->trigger_error(array(
						'message'	=> 'LOGIN_REDIRECT'
					), false);
					return true;
				break;

				case LOGIN_BREAK:
					$err = $result['error_msg'];
				break;
				
				case LOGIN_ERROR_ATTEMPTS:
					$this->helper->trigger_error(array(
						'redirect'	=> $this->helper->url('ucp', 'mode=login')
					), false);
					return true;
				break;

				case LOGIN_ERROR_PASSWORD_CONVERT:
					$err = sprintf(
						$this->lang->get($result['error_msg']),
						($config['email_enable']) ? '<a href="' . $this->helper->url('ucp', 'mode=sendpassword') . '">' : '',
						($config['email_enable']) ? '</a>' : '',
						'<a href="' . phpbb_get_board_contact_link($this->config, $this->phpbb_root_path, $this->php_ext) . '">',
						'</a>'
					);
				break;

				// Username, password, etc...
				default:
					$err = $result['error_msg'];

					// Assign admin contact to some error messages
					if ($result['error_msg'] == 'LOGIN_ERROR_USERNAME' || $result['error_msg'] == 'LOGIN_ERROR_PASSWORD')
					{
						$err = $this->lang->get($result['error_msg'], '<a href="' . $this->helper->url('memberlist', 'mode=contactadmin') . '">', '</a>');
					}
				break;
			}
		}
		else if($method == 'logout')
		{
			if($this->user->data['user_id'] != ANONYMOUS && $this->request->variable('sid', '') === $this->user->session_id)
			{
				$this->user->session_kill();
				$this->helper->trigger_error();
			}
			else if($this->user->data['user_id'] != ANONYMOUS)
			{
				$err = 'LOGOUT_FAILED';
			}
		}
		
		if(isset($err))
		{
			$this->helper->trigger_error(array(
				'message'	=> $err,
				'status'	=> BLG_JSON_ERROR
			));
		}
	
		if($this->user->data['is_registered'])
		{
			$links = array(
				'SEARCH_NEW'	=> 'U_SEARCH_NEW',
				'SEARCH_SELF'	=> 'U_SEARCH_SELF',
				'MY_BOOKMARKS'	=> $this->helper->url('ucp', 'i=main&amp;mode=bookmarks'),
				'MY_SUBSCRIBED'	=> $this->helper->url('ucp', 'i=main&amp;mode=subscribed'),
			);
			
			if($this->config['allow_privmsg'] && ($this->auth->acl_get('u_readpm') || $this->auth->acl_get('u_sendpm')))
			{
				$pm_title = $this->lang->get('PRIVATE_MESSAGES') . (($this->user->data['user_unread_privmsg']) ? ' (' . $this->user->data['user_unread_privmsg'] . ')' : '');
				$links[$pm_title] = 'U_PRIVATEMSGS';
			}

			/**
			* @event block.login_links
			* @var array	links		Array with visible links
			* @since 2.0.0
			*/
			$vars = array('links');
			extract($this->dispatcher->trigger_event('block.login_links', compact($vars)));
			
			foreach($links as $title => $link)
			{
				$this->template->assign_block_vars('userlink', array(
					'TITLE'		=> $this->lang->get($title),
					'URL'		=> (strpos($link, 'U_') === 0) ? $this->template->get_var($link) : $link,
				));
			}
			unset($links);
			
			$break	= ($this->data['autofit']) ? '<br />' : '';

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
				'S_LAST_VISIT'		=> $this->lang->get('YOU_LAST_VISIT', $break . $this->user->format_date($this->user->data['session_last_visit'])),
				'S_CURRENT_TIME'	=> $this->lang->get('CURRENT_TIME', $break . $this->user->format_date(time(), false, true)),
		
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
			$this->template->assign_vars(array(
				'S_DISPLAY_FULL_LOGIN'	=> $data['full_login'],
				'S_DISPLAY_REGISTER'	=> $data['show_register'],
				'S_USERNAME'			=> $username,

				'S_BLG_LOGIN_FIELDS'	=> build_hidden_fields(array(
					'sid'		=> $this->user->session_id,
					'jblgm'		=> $this->data['block_id'],
				)),
				
				'U_SEND_PASSWORD' 		=> ($this->config['email_enable']) ? $this->helper->url('ucp', 'mode=sendpassword') : '',
				'U_RESEND_ACTIVATION'	=> ($this->config['require_activation'] == USER_ACTIVATION_SELF && $this->config['email_enable']) ? $this->helper->url('ucp', 'mode=resend_act') : '',
				'U_TERMS_USE'			=> $this->helper->url('ucp', 'mode=terms'),
				'U_PRIVACY'				=> $this->helper->url('ucp', 'mode=privacy'),
			));
		}

		unset($data);
		return true;
	}

	public function get_config()
	{
		$this->display_vars = array(
			'full_login'	=> array('lang' => 'FULL_LOGIN',	'validate' => 'bool',	'type' => 'radio:yes_no',	'default' => 1),
			'show_register'	=> array('lang' => 'SHOW_REGISTER',	'validate' => 'bool',	'type' => 'radio:yes_no',	'default' => 1),
		);

		return true;
	}
}
