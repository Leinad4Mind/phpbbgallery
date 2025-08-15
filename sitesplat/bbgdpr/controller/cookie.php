<?php
/**
*
* @package BBgdpr
* @copyright (c) 2018 SiteSplat All rights reserved
* @license Proprietary
*/

namespace sitesplat\bbgdpr\controller;

use \sitesplat\bbgdpr\ext;

class cookie
{
	protected $user;
	protected $db;
	protected $users_table;
	protected $root_path;
	public function __construct(\phpbb\user $user, \phpbb\db\driver\driver_interface $db, $users_table, $root_path)
	{
		$this->user = $user;
		$this->db = $db;
		$this->users_table = $users_table;
		$this->root_path = $root_path;
	}

	public function handle($mode)
	{
		switch ($mode)
		{
			case 'accept':

				if ($this->user->data['user_id'] != ANONYMOUS)
				{
					$sql = 'UPDATE ' . $this->users_table . '
							SET user_cookie_accept = ' . ext::COOKIE_ACCEPTED . ', user_cookie_accept_date = ' . time() . '
							WHERE user_id = ' . $this->user->data['user_id'];
					$this->db->sql_query($sql);
				}
				else
				{
					$this->user->set_cookie('sitesplat_bbgdpr_cookie', ext::COOKIE_ACCEPTED, 0);
				}
			
			break;

			case 'reject':

				if ($this->user->data['user_id'] != ANONYMOUS)
				{
					$sql = 'UPDATE ' . $this->users_table . '
							SET user_cookie_accept = ' . ext::COOKIE_DENIED . ', user_cookie_accept_date = 0
							WHERE user_id = ' . $this->user->data['user_id'];
					$this->db->sql_query($sql);
				}
				else
				{
					$this->user->set_cookie('sitesplat_bbgdpr_cookie', ext::COOKIE_DENIED, 0);
				}

			break;
		}

		redirect($this->root_path . $this->user->data['session_page']);
	}
}
