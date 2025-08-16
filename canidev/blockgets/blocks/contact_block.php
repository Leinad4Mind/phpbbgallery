<?php
/*
* @name contact_block.php
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

class contact_block extends base
{
	static $icon = 'blg-icon-envelope-o';

	public function init($method = '')
	{
		$this->tpl_name = 'contact_block';
		
		if(($data = $this->unserialize()) === false)
		{
			return false;
		}
		
		// Delete the array in the template if exists, prevent errors between blocks
		$this->template->destroy_block_vars('fieldrow');

		$username = $user_email = $subject = $message = '';
		
		if($this->user->data['user_type'] != USER_IGNORE)
		{
			$username	= $this->user->data['username'];
			$user_email = $this->user->data['user_email'];
		}
		else
		{
			$data['hide_user_fields'] = false;
		}
		
		if($method == 'submit')
		{
			$this->lang->add('memberlist');

			$error = $notice = array();

			$username	= utf8_normalize_nfc($this->request->variable('username', $username, true));
			$user_email = $this->request->variable('email', $user_email);
			$subject	= utf8_normalize_nfc($this->request->variable('subject', $subject, true));
			$message	= utf8_normalize_nfc($this->request->variable('message', $message, true));

			if(!check_form_key('contact_block'))
			{
				$error[] = $this->lang->get('FORM_INVALID');
			}
			
			if(!$username)
			{
				$error[] = $this->lang->get('EMPTY_NAME_EMAIL');
			}
			
			if(preg_match('/^' . get_preg_expression('email') . '$/i', $user_email))
			{
				if($data['check_email'] && !$data['hide_user_fields'])
				{
					list(, $domain) = explode('@', $user_email);

					if(phpbb_checkdnsrr($domain, 'A') === false && phpbb_checkdnsrr($domain, 'MX') === false)
					{
						$error[] = $this->lang->get('EMAIL_INVALID');
					}
				}
			}
			else
			{
				$error[] = $this->lang->get('EMAIL_EMPTY');
			}
			
			if(!$subject)
			{
				$error[] = $this->lang->get('EMPTY_SUBJECT_EMAIL');
			}

			if(!$message)
			{
				$error[] = $this->lang->get('EMPTY_MESSAGE_EMAIL');
			}

			/**
			* @event block.contact_submit_check
			* @var array	error		Array with error codes
			* @since 2.0.0
			*/
			$vars = array('error');
			extract($this->dispatcher->trigger_event('block.contact_submit_check', compact($vars)));

			if(!sizeof($error))
			{
				if(!class_exists('messenger', false))
				{
					include($this->phpbb_root_path . 'includes/functions_messenger.' . $this->php_ext);
				}
				
				$email_lang = ($this->user->data['is_registered']) ? $this->user->data['user_lang'] : $this->config['default_lang'];

				$messenger = new \messenger(false);

				$messenger->template('contact_block', $email_lang, $this->helper->get_ext_path() . "language/$email_lang/email");
				$messenger->from($user_email);
				$messenger->replyto($user_email);
				$messenger->to($data['email'], $this->config['sitename']);
				$messenger->subject(htmlspecialchars_decode($subject));

				$messenger->headers('X-AntiAbuse: Board servername - ' . $this->config['server_name']);
				$messenger->headers('X-AntiAbuse: User_id - ' . $this->user->data['user_id']);
				$messenger->headers('X-AntiAbuse: Username - ' . $username);
				$messenger->headers('X-AntiAbuse: User IP - ' . $this->user->ip);

				$messenger->assign_vars(array(
					'FROM_USERNAME'	=> htmlspecialchars_decode($username),
					'MESSAGE'		=> htmlspecialchars_decode($message))
				);

				/**
				* @event block.contact_submit
				* @var object	messenger		Messenger Class
				* @since 2.0.0
				*/
				$vars = array('messenger');
				extract($this->dispatcher->trigger_event('block.contact_submit', compact($vars)));

				if($messenger->send(NOTIFY_EMAIL))
				{
					$notice[] = $this->lang->get('EMAIL_SENT');
				}
				else
				{
					$error[] = $this->lang->get('CONTACT_ERROR');
				}
			}
			
			$this->helper->trigger_error(array(
				'message'		=> implode('<br />', (sizeof($error) ? $error : $notice)),
				'status'		=> (sizeof($error) ? BLG_JSON_ERROR : BLG_JSON_SUCCESS),
			), false);
			
			return true;
		}
		
		$fields = array(
			'username'	=> array('type' => 'text',		'title' => 'USERNAME',	'value' => $username),
			'email'		=> array('type' => 'text',		'title' => 'EMAIL',		'value' => $user_email),
			'subject'	=> array('type' => 'text',		'title' => 'SUBJECT',	'value' => $subject),
			'message'	=> array('type' => 'textarea',	'title' => 'MESSAGE',	'value' => $message),
		);

		add_form_key('contact_block');
		
		$s_hidden_fields = array(
			'jblgm'	=> $this->data['block_id']
		);
		
		if($data['hide_user_fields'])
		{
			$s_hidden_fields = array_merge($s_hidden_fields, array(
				'username'	=> $username,
				'email'		=> $user_email,
			));
			
			unset($fields['username'], $fields['email']);
		}
		
		$this->template->assign_vars(array(
			'BLOCK_HIDDEN_FIELDS'	=> build_hidden_fields($s_hidden_fields),
		));

		/**
		* @event block.contact_fields
		* @var array	fields		The fields to display
		* @var array	data		The block data
		* @since 2.0.0
		*/
		$vars = array('fields', 'data');
		extract($this->dispatcher->trigger_event('block.contact_fields', compact($vars)));
		
		foreach($fields as $key => $vars)
		{
			$this->template->assign_block_vars('fieldrow', array(
				'KEY'	=> $key,
				'TITLE'	=> $this->lang->get($vars['title']),
				'TYPE'	=> $vars['type'],
				'VALUE'	=> $vars['value'],
			));
		}

		unset($data);
		return true;
	}

	public function get_config()
	{
		$this->display_vars = array(
			'email'				=> array('lang' => 'CONTACT_EMAIL',			'validate' => 'string',	'type' => 'text:30:255',	'default' => $this->config['board_contact']),
			'hide_user_fields'	=> array('lang' => 'CONTACT_HIDE_FIELDS',	'validate' => 'bool',	'type' => 'radio:yes_no'),
			'check_email'		=> array('lang' => 'CONTACT_CHECK_EMAIL',	'validate' => 'bool',	'type' => 'radio:yes_no'),
		);

		return true;
	}
}
