<?php

/**
*
* @package PM Welcome
* @copyright 2019 (c) Leinad4Mind - https://leinad4mind.top/forum
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace leinad4mind\pmwelcome\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use phpbb\user;
use phpbb\config\config;
use phpbb\config\db_text;

class listener implements EventSubscriberInterface
{
	/** @var \phpbb\user */
	protected $user;

	/** @var \phpbb\config\config */
	protected $config;

	/** @var \phpbb\config\db_text */
	protected $config_text;

	/** @var string root_path */
	protected $root_path;

	/** @var string phpEx */
	protected $php_ext;

	public function __construct(
		user $user,
		config $config,
		db_text $config_text,
		$root_path, $php_ext
	)
	{
		$this->user				= $user;
		$this->config			= $config;
		$this->text				= $config_text;
		$this->root_path		= $root_path;
		$this->php_ext			= $php_ext;
	}

	static public function getSubscribedEvents()
	{
		return array(
			'core.user_add_after'		=> 'pm_welcome',
			'core.ucp_activate_after'	=> 'pm_activate_welcome',
		);
	}

	public function pm_welcome($event)
	{
		$user_row = $event['user_row'];
		if ($user_row['user_type'] == USER_NORMAL)
		{
			$pwm_user = $this->config['pmwelcome_user'];
			$pwm_subject = $this->config['pmwelcome_subject'];
			$pwm_text = $this->text->get('pmwelcome_post_text');
			if ($pwm_user && $pwm_subject && $pwm_text)
			{
				$user_to = array(
					'user_id'			=> $event['user_id'],
					'username'			=> $user_row['username'],
					'user_email'		=> $user_row['user_email'],
					'sitename'			=> $this->config['sitename'],
					'site_desc'			=> $this->config['site_desc'],
					'board_contact'		=> $this->config['board_contact'],
					'board_email'		=> $this->config['board_email'],
					'board_email_sig'	=> $this->config['board_email_sig'],
				);

				$this->user_welcome($user_to, $pwm_user, $pwm_subject, $pwm_text);
			}
		}
	}

	public function pm_activate_welcome($event)
	{
		$user_row = $event['user_row'];
		if (!$user_row['user_newpasswd'])
		{
			$pwm_user = $this->config['pmwelcome_user'];
			$pwm_subject = $this->config['pmwelcome_subject'];
			$pwm_text = $this->text->get('pmwelcome_post_text');
			if ($pwm_user && $pwm_subject && $pwm_text)
			{
				$user_to = array(
					'user_id'			=> $user_row['user_id'],
					'username'			=> $user_row['username'],
					'user_email'		=> $user_row['user_email'],
					'sitename'			=> $this->config['sitename'],
					'site_desc'			=> $this->config['site_desc'],
					'board_contact'		=> $this->config['board_contact'],
					'board_email'		=> $this->config['board_email'],
					'board_email_sig'	=> $this->config['board_email_sig'],
				);

				$this->user_welcome($user_to, $pwm_user, $pwm_subject, $pwm_text);
			}
		}
	}

	/** User PM Welcome Message */
	private function user_welcome($user_to, $user_id, $subject, $text)
	{
		$m_flags = 3; // 1 is bbcode, 2 is smiles, 4 is urls (add together to turn on more than one)
		$uid = $bitfield = '';
		$allow_bbcode = $allow_urls = $allow_smilies = true;

		$text = str_replace('{USERNAME}', 		$user_to['username'],		 $text);
		$text = str_replace('{USER_EMAIL}',		$user_to['user_email'],		 $text);
		$text = str_replace('{SITE_NAME}',		$user_to['sitename'],		 $text);
		$text = str_replace('{SITE_DESC}',		$user_to['site_desc'],		 $text);
		$text = str_replace('{BOARD_CONTACT}',	$user_to['board_contact'],	 $text);
		$text = str_replace('{BOARD_EMAIL}',	$user_to['board_email'],	 $text);
		$text = str_replace('{BOARD_SIG}',		$user_to['board_email_sig'], $text);

		generate_text_for_storage($text, $uid, $bitfield, $m_flags, $allow_bbcode, $allow_urls, $allow_smilies);

		include_once($this->root_path . 'includes/functions_privmsgs.' . $this->php_ext);

		$pm_data = array(
			'address_list'		=> array('u' => array($user_to['user_id'] => 'to')),
			'from_user_id'		=> $user_id,
			'from_user_ip'		=> $this->user->ip,
			'enable_sig'		=> false,
			'enable_bbcode'		=> $allow_bbcode,
			'enable_smilies'	=> $allow_smilies,
			'enable_urls'		=> $allow_urls,
			'icon_id'			=> 0,
			'bbcode_bitfield'	=> $bitfield,
			'bbcode_uid'		=> $uid,
			'message'			=> utf8_normalize_nfc($text),
		);

		submit_pm('post', utf8_normalize_nfc($subject), $pm_data, false);
	}
}
