<?php
/**
*
* Castle
*
* @copyright (c) 2018 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\castle\controller;

use \Firebase\JWT\JWT;

class main
{
	protected $config;
	protected $request;
	protected $db;
	protected $language;
	protected $helper;
	protected $user;
	protected $root_path;
	protected $php_ext;
	protected $users_table;
	public function __construct(\phpbb\config\config $config, \phpbb\request\request $request, \phpbb\db\driver\driver_interface $db, \phpbb\language\language $language, \phpbb\controller\helper $helper, \phpbb\user $user, $root_path, $php_ext, $users_table)
	{
		$this->config = $config;
		$this->request = $request;
		$this->db = $db;
		$this->language = $language;
		$this->helper = $helper;
		$this->user = $user;
		$this->root_path = $root_path;
		$this->php_ext = $php_ext;
		$this->users_table = $users_table;
	}

	public function hook()
	{
		$hmac_header = $this->request->server('HTTP_X_CASTLE_SIGNATURE', '');
		$data = @file_get_contents('php://input');
		if ($this->verify_webhook($data, $hmac_header))
		{
			$json = json_decode($data);
			if ($json->type == '$incident.confirmed')
			{
				$this->disable_user($json->data->user_id);
			}
		}

		return new \Symfony\Component\HttpFoundation\Response();
	}

	public function feedback()
	{
		$this->language->add_lang('feedback', 'sitesplat/castle');

		$token = $this->request->variable('token', '');
		$payload = JWT::decode($token, $this->config['castle_api_secret'], array('HS256'));
		
		if ($payload->label == 'approve')
		{
			return $this->helper->message('THANKS_FOR_CONFIRMING');
		}
		else
		{
			$this->disable_user((int) $payload->user_id);

			return $this->helper->message('ACCOUNT_DISABLED');
		}
	}

	protected function disable_user($user_id)
	{
		// Make sure user is logged-out
		$this->user->session_kill();

		// Deactivate user and force him to change password
		if (!function_exists('user_active_flip'))
		{
			include($this->root_path . 'includes/functions_user.' . $this->php_ext);
		}
		user_active_flip('deactivate', array($user_id), INACTIVE_PROFILE);

		// Send email to the disabled user
		if (!empty($this->config['email_enable']))
		{
			if (!function_exists('gen_rand_string'))
			{
				include($this->root_path . 'includes/functions.' . $this->php_ext);
			}
			if (!class_exists('messenger'))
			{
				include($this->root_path . 'includes/functions_messenger.' . $this->php_ext);
			}

			// Select disabled user data
			$sql = 'SELECT *
					FROM ' . $this->users_table . '
					WHERE user_id = ' . (int) $user_id;
			$result = $this->db->sql_query($sql);
			$row = $this->db->sql_fetchrow($result);
			$row['user_actkey'] = gen_rand_string(mt_rand(6, 10));

			// Mock user class for messenger::anti_abuse_headers
			$user = new \stdClass;
			$user->data = array(
				'user_id'	=> $row['user_id'],
				'username'	=> $row['username'],
			);
			$user->ip = $row['user_ip'];

			$messenger = new \messenger();
			$messenger->template('user_activate', $row['user_lang']);
			$messenger->set_addresses($row);
			$messenger->anti_abuse_headers($this->config, $user);
			$messenger->assign_vars(array(
				'USERNAME'		=> htmlspecialchars_decode($row['username']),
				'U_ACTIVATE'	=> generate_board_url() . "/ucp.{$this->php_ext}?mode=activate&u=" . $row['user_id'] . '&k=' . $row['user_actkey'])
			);
			$messenger->send($row['user_notify_type']);
			$messenger->save_queue();

			// Add the remind state and actkey to the database
			$sql = 'UPDATE ' . $this->users_table . '
				SET user_reminded = user_reminded + 1,
					user_reminded_time = ' . time() . ',
					user_actkey = "' . $row['user_actkey'] . '"
				WHERE user_id = ' . (int) $user_id;
			$this->db->sql_query($sql);
		}
	}

	private function verify_webhook($data, $hmac_header)
	{
		$calculated_hmac = base64_encode(hash_hmac('sha256', $data, $this->config['castle_api_secret'], true));
		return $hmac_header == $calculated_hmac;
	}
}
