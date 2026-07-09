<?php

/**
 * AJAX Username Check
 * @copyright (c) 2020 WelshPaul. 2025 Leinad4Mind. All rights reserved.
 * @license   http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 */

namespace welshpaul\ajaxusernamecheck\controller;

use phpbb\db\driver\factory;
use phpbb\event\dispatcher;
use phpbb\json_response;
use phpbb\request\request;
use phpbb\user;

class controller
{
	/** @var request $request Request object */
	protected $request;

	/** @var factory $db Database object */
	protected $db;

	/** @var user $user User object */
	protected $user;

	/** @var dispatcher $dispatcher phpBB event dispatcher */
	protected $dispatcher;

	/**
	 * Controller constructor
	 *
	 * @access public
	 * @since  1.0.0
	 *
	 * @param request    $request    Request object
	 * @param factory    $db         Database object
	 * @param user       $user       User object
	 * @param dispatcher $dispatcher phpBB event dispatcher
	 */
	public function __construct(request $request, factory $db, user $user, dispatcher $dispatcher)
	{
		$this->request = $request;
		$this->db = $db;
		$this->user = $user;
		$this->dispatcher = $dispatcher;
	}

	/**
	 * Function that checks the user input
	 *
	 * @access public
	 * @since  1.0.0
	 *
	 * @param string $type The input type
	 */
	public function check($type)
	{
		// Load needed language data
		$this->user->add_lang_ext('welshpaul/ajaxusernamecheck', ['ajaxusernamecheck']);
		$response = new json_response();
		$response_text = ['INVALID QUERY', $this->user->lang('WELSHPAUL_AJAXUSERNAMECHECK_INVALID_QUERY')];
		if ($this->request->is_ajax()) {
			switch ($type) {
				case 'username':
					$username = $this->request->variable('search', '');
					if ($username !== '') {
						$clean_username = utf8_clean_string($username);
						$username_escaped = $this->db->sql_escape($clean_username);
						// Check if the name is already used
						$query = 'SELECT username FROM ' . USERS_TABLE . " WHERE username_clean = '" . $username_escaped . "'";
						$result = $this->db->sql_query($query);
						if ($this->db->sql_fetchrow($result)) {
							$response_text[0] = 'NOT OK';
							$response_text[1] = $this->user->lang('WELSHPAUL_AJAXUSERNAMECHECK_USERNAME_TAKEN');
						}
						$this->db->sql_freeresult($result);
						if ($response_text[0] !== 'NOT OK') {
							$query = 'SELECT disallow_username FROM ' . DISALLOW_TABLE;
							// Check if the username is blocked by the board admin
							$result = $this->db->sql_query($query);
							while ($disallowed_user = $this->db->sql_fetchrow($result)) {
								 // Check if the username matches the rule
								if (preg_match('/^(' . str_replace('%', '.*', preg_quote($disallowed_user['disallow_username'])) . ')$/i', $username)) {
									$response_text[0] = 'NOT OK';
									$response_text[1] = $this->user->lang('WELSHPAUL_AJAXUSERNAMECHECK_USERNAME_DISALLOWED');
									break;
								}
							}
							$this->db->sql_freeresult($result);
							if ($response_text[0] !== 'NOT OK') {
								// All checks passed - set status to OK
								$response_text[0] = 'OK';
								$response_text[1] = $this->user->lang('WELSHPAUL_AJAXUSERNAMECHECK_USERNAME_OK');
							}
						}
					}
					break;
			}
		}
		$response->send($response_text);
	}
}
