<?php
/**
 * @package cBB Blockgets
 * @version 2.0.6 20/09/2023
 *
 * @copyright (c) 2023 CaniDev
 * @license https://creativecommons.org/licenses/by-nc/4.0/
 */

namespace canidev\blockgets\blocks;

use \canidev\core\JsonResponse;

class contact_block extends base
{
	static $icon = 'fa-envelope-o';

	/**
	 * {@inheritDoc}
	 */
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
			$this->language->add_lang('memberlist');

			$error = $notice = [];

			$username	= $this->request->variable('username', $username, true);
			$user_email = $this->request->variable('email', $user_email);
			$subject	= $this->request->variable('subject', $subject, true);
			$message	= $this->request->variable('message', $message, true);

			if(!check_form_key('contact_block'))
			{
				$error[] = $this->language->lang('FORM_INVALID');
			}
			
			if(!$username)
			{
				$error[] = $this->language->lang('EMPTY_NAME_EMAIL');
			}
			
			if(preg_match('/^' . get_preg_expression('email') . '$/i', $user_email))
			{
				if($data['check_email'] && !$data['hide_user_fields'])
				{
					list(, $domain) = explode('@', $user_email);

					if(phpbb_checkdnsrr($domain, 'A') === false && phpbb_checkdnsrr($domain, 'MX') === false)
					{
						$error[] = $this->language->lang('EMAIL_INVALID');
					}
				}
			}
			else
			{
				$error[] = $this->language->lang('EMAIL_EMPTY');
			}
			
			if(!$subject)
			{
				$error[] = $this->language->lang('EMPTY_SUBJECT_EMAIL');
			}

			if(!$message)
			{
				$error[] = $this->language->lang('EMPTY_MESSAGE_EMAIL');
			}

			/**
			 * @event block.contact_submit_check
			 * @var array	error		Array with error codes
			 * @var	array	data		Block Configuration
			 * @since 2.0.0
			 */
			$vars = ['error', 'data'];
			extract($this->dispatcher->trigger_event('block.contact_submit_check', compact($vars)));

			if(!sizeof($error))
			{
				if(!class_exists('messenger', false))
				{
					include($this->phpbb_root_path . 'includes/functions_messenger.' . $this->php_ext);
				}
				
				$email_lang = ($this->user->data['is_registered']) ? $this->user->data['user_lang'] : $this->config['default_lang'];
				$email_path = $this->helper->get_ext_path() . "language/$email_lang/email";
				
				// If the path no exists, use English (default)
				if(!file_exists($email_path))
				{
					$email_path = $this->helper->get_ext_path() . "language/en/email";
				}

				$messenger = new \messenger(false);

				$messenger->template('contact_block', $email_lang, $email_path);
				$messenger->from($user_email);
				$messenger->replyto($user_email);
				$messenger->to($data['email'], $this->config['sitename']);
				$messenger->subject(htmlspecialchars_decode($subject));
				$messenger->anti_abuse_headers($this->config, $this->user);

				$messenger->assign_vars([
					'FROM_USERNAME'	=> htmlspecialchars_decode($username),
					'MESSAGE'		=> htmlspecialchars_decode($message)
				]);

				/**
				 * @event block.contact_submit
				 * @var object	messenger		Messenger Class
				 * @var	array	data			Block Configuration
				 * @since 2.0.0
				 */
				$vars = ['messenger', 'data'];
				extract($this->dispatcher->trigger_event('block.contact_submit', compact($vars)));

				if($messenger->send(NOTIFY_EMAIL))
				{
					$notice[] = $this->language->lang('EMAIL_SENT');
				}
				else
				{
					$error[] = $this->language->lang('AJAX_ERROR_TEXT');
				}
			}
			
			$this->helper->json->add([
				'message'		=> implode('<br />', (sizeof($error) ? $error : $notice)),
				'status'		=> (sizeof($error) ? JsonResponse::JSON_STATUS_ERROR : JsonResponse::JSON_STATUS_SUCCESS),
			]);
			
			return true;
		}
		
		$fields = [
			'username'	=> ['type' => 'text',		'title' => 'USERNAME',	'value' => $username],
			'email'		=> ['type' => 'text',		'title' => 'EMAIL',		'value' => $user_email],
			'subject'	=> ['type' => 'text',		'title' => 'SUBJECT',	'value' => $subject],
			'message'	=> ['type' => 'textarea',	'title' => 'MESSAGE',	'value' => $message],
		];

		add_form_key('contact_block');
		
		$s_hidden_fields = [
			'jblgm'	=> $this->data['block_id']
		];
		
		if($data['hide_user_fields'])
		{
			$s_hidden_fields = array_merge($s_hidden_fields, [
				'username'	=> $username,
				'email'		=> $user_email,
			]);
			
			unset($fields['username'], $fields['email']);
		}
		
		$this->template->assign_vars([
			'BLOCK_HIDDEN_FIELDS'	=> build_hidden_fields($s_hidden_fields),
		]);

		/**
		 * @event block.contact_fields
		 * @var array	fields		The fields to display
		 * @var	array	data		Block Configuration
		 * @since 2.0.0
		 */
		$vars = ['fields', 'data'];
		extract($this->dispatcher->trigger_event('block.contact_fields', compact($vars)));
		
		foreach($fields as $key => $vars)
		{
			$this->template->assign_block_vars('fieldrow', [
				'KEY'	=> $key,
				'TITLE'	=> $this->language->lang($vars['title']),
				'TYPE'	=> $vars['type'],
				'VALUE'	=> $vars['value'],
			]);
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
			'email'				=> ['lang' => 'CONTACT_EMAIL',			'validate' => 'string',	'type' => 'text:30:255',	'default' => $this->config['board_contact']],
			'hide_user_fields'	=> ['lang' => 'CONTACT_HIDE_FIELDS',	'validate' => 'bool',	'type' => 'radio:yes_no'],
			'check_email'		=> ['lang' => 'CONTACT_CHECK_EMAIL',	'validate' => 'bool',	'type' => 'radio:yes_no'],
		];

		return true;
	}
}
