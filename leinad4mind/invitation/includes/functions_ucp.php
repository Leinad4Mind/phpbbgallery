<?php

/**
 *
 * Invitation. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2010-2015, KillBill
 * @copyright (c) 2017, kasimi
 * @copyright (c) 2017-2021, Leinad4Mind, https://leinad4mind.top/forum
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace leinad4mind\invitation\includes;

use leinad4mind\invitation\includes\config as ext_config;
use phpbb\auth\auth;
use phpbb\config\config as phpbb_config;
use phpbb\db\driver\driver_interface as db_interface;
use phpbb\language\language;
use phpbb\user;

class functions_ucp
{
	/** @var user */
	protected $user;

	/** @var language */
	protected $language;

	/** @var auth */
	protected $auth;

	/** @var phpbb_config */
	protected $config;

	/** @var ext_config */
	protected $ext_config;

	/** @var functions */
	protected $functions;

	/** @var db_interface */
	protected $db;

	/** @var string */
	protected $table_users;

	/** @var string */
	protected $table_invite;

	/** @var string */
	protected $table_invite_users;

	/** @var string */
	protected $table_invite_claimed;

	/** @var string */
	protected $root_path;

	/** @var string */
	protected $php_ext;

	/**
	 * @param \phpbb\user                                $user
	 * @param \phpbb\language\language                   $language
	 * @param \phpbb\auth\auth                           $auth
	 * @param \phpbb\config\config                       $config
	 * @param \leinad4mind\invitation\includes\config    $ext_config
	 * @param \leinad4mind\invitation\includes\functions $functions
	 * @param \phpbb\db\driver\driver_interface          $db
	 * @param string                                     $table_users
	 * @param string                                     $table_invite
	 * @param string                                     $table_invite_users
	 * @param string                                     $table_invite_claimed
	 * @param string                                     $root_path
	 * @param string                                     $php_ext
	 */
	public function __construct(user $user, language $language, auth $auth, phpbb_config $config, ext_config $ext_config, functions $functions, db_interface $db, $table_users, $table_invite, $table_invite_users, $table_invite_claimed, $root_path, $php_ext)
	{
		$this->user = $user;
		$this->language = $language;
		$this->auth = $auth;
		$this->config = $config;
		$this->ext_config = $ext_config;
		$this->functions = $functions;
		$this->db = $db;
		$this->table_users = $table_users;
		$this->table_invite = $table_invite;
		$this->table_invite_users = $table_invite_users;
		$this->table_invite_claimed = $table_invite_claimed;
		$this->root_path = $root_path;
		$this->php_ext = $php_ext;
	}

	/**
	 * @param int $user_id
	 * @return array
	 */
	function meghivok($user_id)
	{
		$sql = 'SELECT id, meghivo_time, meghivo_email
				FROM ' . $this->table_invite . '
				WHERE user_id = ' . (int) $user_id;
		$result = $this->db->sql_query($sql);
		$rows = $this->db->sql_fetchrowset($result);
		$this->db->sql_freeresult($result);

		return $rows;
	}

	function find_invite_by_email($email)
	{
		$sql = 'SELECT *
				FROM ' . $this->table_invite . "
				WHERE meghivo_email = '" . $this->db->sql_escape(utf8_clean_string($email))  . "'";
		$result = $this->db->sql_query($sql);
		$rows = $this->db->sql_fetchrowset($result);
		$this->db->sql_freeresult($result);

		return $rows;
	}

	/**
	 * @param string $email
	 * @return array
	 */
	function find_user_by_email($email)
	{
		$sql = 'SELECT *
				FROM ' . $this->table_users . "
				WHERE user_email = '" . $this->db->sql_escape(utf8_clean_string($email))  . "'";
		$result = $this->db->sql_query($sql);
		$rows = $this->db->sql_fetchrowset($result);
		$this->db->sql_freeresult($result);

		return $rows;
	}

	/**
	 * @param string $email_template
	 * @param string $user_lang
	 * @return string
	 */
	public function get_lang_for_email($email_template, $user_lang)
	{
		$lang = $user_lang ?: $this->user->lang_name;

		$email_lang_path = $this->root_path . 'ext/leinad4mind/invitation/language/' . $user_lang . '/email/';

		if (!file_exists($email_lang_path . $email_template))
		{
			$lang = basename($this->config['default_lang']);
		}

		return $lang;
	}

	/**
	 * @param $template_file
	 * @param $subject
	 * @param $prior
	 * @param $ulang
	 * @return \messenger
	 */
	public function messenger($template_file, $subject, $prior, $ulang)
	{
		if (!class_exists('messenger'))
		{
			include($this->root_path . 'includes/functions_messenger.' . $this->php_ext);
		}

		$messenger = new \messenger(false);

		$messenger->template('@leinad4mind_invitation/' . $template_file, $ulang);
		$messenger->im($this->user->data['user_jabber'], $this->user->data['username']);
		$messenger->replyto($this->user->data['user_email']);
		$messenger->subject(htmlspecialchars_decode($subject));
		$messenger->set_mail_priority($prior);
		$messenger->anti_abuse_headers($this->config, $this->user);

		return $messenger;
	}

	/**
	 * @param $requsting_user_id
	 * @param $count
	 */
	function adm_send($requsting_user_id, $count)
	{
		$user_ids	= array();
		$keys		= array('a_meghivo_igeny', 'm_meghivo_igeny');
		$user_list	= $this->auth->acl_raw_data(false, $keys);

		foreach ($keys as $key)
		{
			foreach ($user_list as $user_id => $value)
			{
				if (!empty($user_list[$user_id][0][$key]))
				{
					if ($this->user->data['user_id'] == $user_id)
					{
						continue;
					}

					$user_ids[] = $user_id;
				}
			}
		}

		if ($user_ids)
		{
			$this->functions->send_notification('petition_request', array(
				'petition_request_user_id'		=> $requsting_user_id,
				'petition_request_count'		=> $count,
				'petition_request_notify_ids'	=> array_unique($user_ids),
			));
		}
	}

	/**
	 * @param        $email
	 * @param        $message
	 * @param \messenger $messenger
	 * @param        $friend
	 * @param string $ulang
	 * @param array  $emailreuse
	 */
	function send($email, $message, $messenger, $friend, $ulang = '', $emailreuse = array())
	{
		static $invite_tpl_replace;

		if (!empty($invite_tpl_replace) && !isset($emailreuse[$email]) && $ulang !== '')
		{
			$messenger->template('@leinad4mind_invitation/user_invite', $ulang);
			unset($invite_tpl_replace);
		}

		$server_url		= generate_board_url();
		$user_id		= (int) $this->user->data['user_id'];
		$user_actkey	= gen_rand_string(mt_rand(6, 10));

		$act_url		= "{$server_url}/ucp.{$this->php_ext}?mode=register&muid={$user_id}&mkey={USER_ACTKEY}";
		$activate_url	= str_replace('{USER_ACTKEY}', $user_actkey, $act_url);

		$this->ins_key($user_id, $email, $user_actkey, $friend);

		if (!empty($emailreuse[$email]) && $ulang !== '')
		{
			$user_actkeys = $user_actkey;
			for ($i=1; $i < $emailreuse[$email]; $i++)
			{
				$user_actkey = gen_rand_string(mt_rand(6, 10));
				$user_actkeys .= "|$user_actkey";
				$activate_url .= "\n" . str_replace('{USER_ACTKEY}', $user_actkey, $act_url);

				$this->ins_key($user_id, $email, $user_actkey, $friend);
			}

			$deactivate_url = "{$server_url}/ucp.{$this->php_ext}?mode=register&muid={$user_id}&mkey={$user_actkeys}&mdel=1";

			if (empty($invite_tpl_replace))
			{
				$messenger->template('@leinad4mind_invitation/user_invites', $ulang);

				$invite_tpl_replace = true;
			}
		}
		else
		{
			$deactivate_url = "{$activate_url}&mdel=1";
		}

		$messenger->to($email);

		$messenger->assign_vars(array(
			'U_BOARD'			=> $server_url,
			'U_ACTIVATE'		=> $activate_url,
			'U_DEACTIVATE'		=> $deactivate_url,
			'BOARD_CONTACT'		=> $this->config['board_contact'],
			'USERNAME'			=> htmlspecialchars_decode($this->user->data['username']),
			'MESSAGE'			=> htmlspecialchars_decode($message),
			'INVITE_TIME_END'	=> $this->user->format_date((time() + $this->ext_config['meghivo_ervenyessege']), 'Y.M.d. H:i')
		));

		$messenger->send(NOTIFY_EMAIL);
	}

	function ins_key($user_id, $email, $user_actkey, $friend)
	{
		$sql_ary = array(
			'user_id'			=> (int) $user_id,
			'meghivo_kod'		=> $user_actkey,
			'meghivo_time'		=> time(),
			'meghivo_time_end'	=> time() + $this->ext_config['meghivo_ervenyessege'],
			'meghivo_email'		=> $email,
			'friend'			=> $friend ? 1 : 0,
		);

		$this->db->sql_query('INSERT INTO ' . $this->table_invite . ' ' . $this->db->sql_build_array('INSERT', $sql_ary));

		$sql = 'UPDATE ' . USERS_TABLE . '
				SET ' . ($this->ext_config['meghivo_db'] || $this->auth->acl_get('u_meghivo_max') ? 'user_emailtime = ' . time() : 'user_meghivo = user_meghivo - 1, user_emailtime = ' . time()) . '
				WHERE user_id = ' . (int) $user_id;
		$this->db->sql_query($sql);
	}

	function cmt($mmu, $user_id)
	{
		$i = 0;

		$cmt = array(
			'username'	=> false,
			'ma_kuld'	=> 0,
			'fuggo'		=> 0
		);

		$sql = 'SELECT * FROM ' . $this->table_invite_users . '
				WHERE meghivo_uid = ' . (int) $user_id . '
				ORDER BY user_regdate ASC';
		$result = $this->db->sql_query($sql);
		while ($row = $this->db->sql_fetchrow($result))
		{
			if (date('d', $row['user_regdate']) == date('d'))
			{
				$i++;
			}

			$cmt['username'] = get_username_string('full', $row['user_id'], $row['user_name'], $row['user_colour']);
			$cmt['user_regdate'] = $row['user_regdate'];

		}
		$this->db->sql_freeresult($result);

		foreach ($mmu as $row)
		{
			$cmt['ma_kuld'] = date('d', $row['meghivo_time']) == date('d') ? ($cmt['ma_kuld'] + 1) : $cmt['ma_kuld'];
			$cmt['fuggo']++;
		}

		$cmt['ma_kuld'] = $cmt['ma_kuld'] + $i;

		return $cmt;
	}

	function keres($user_id)
	{
		$sql = 'SELECT user_id FROM ' . $this->table_invite_claimed . '
				WHERE user_id = ' . (int) $user_id;
		$result = $this->db->sql_query($sql);
		$uid = (int) $this->db->sql_fetchfield('user_id');
		$this->db->sql_freeresult($result);

		return  $uid;
	}

	/**
	 * @param string $email
	 * @return array
	 */
	function email_verify($email)
	{
		if (@preg_match('/^' . get_preg_expression('email') . '$/i', $email) !== 1)
		{
			return array($this->language->lang('UCP_MEGHIVO_NO_EMAIL') . ' -> ' . $email);
		}

		$langs = array();

		if (!$this->config['allow_emailreuse'])
		{
			if ($this->find_user_by_email($email))
			{
				$langs[] = $this->language->lang('EMAIL_TAKEN_EMAIL') . ' -> ' . $email;
			}

			if ($this->find_invite_by_email($email))
			{
				$langs[] = $this->language->lang('UCP_MEGHIVO_DUP', $email);
			}
		}

		return $langs;
	}

	function adm_message($message, $select)
	{
		$mess = array(
			'user_id'		=> (int) $this->user->data['user_id'],
			'message'		=> $message,
			'message_time'	=> time(),
			'db'			=> $select,
			'ip'			=> $this->user->ip
		);

		$this->db->sql_query('INSERT INTO ' . $this->table_invite_claimed . ' ' . $this->db->sql_build_array('INSERT', $mess));

		$this->ext_config->set('total_petition', ($this->ext_config['total_petition'] + 1));
	}

}
