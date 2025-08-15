<?php
/**
*
* @package BBajaxnews
* @copyright (c) 2018 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\bbajaxnews\ajaxnews\type;

abstract class base implements type_interface
{
	protected $language;
	protected $db;
	protected $auth;
	protected $sessions_table;
	protected $users_table;
	protected $root_path;
	protected $php_ext;
	public function __construct(\phpbb\language\language $language, \phpbb\db\driver\driver_interface $db, \phpbb\auth\auth $auth, $sessions_table, $users_table, $root_path, $php_ext)
	{
		$this->language = $language;
		$this->db = $db;
		$this->auth = $auth;
		$this->sessions_table = $sessions_table;
		$this->users_table = $users_table;
		$this->root_path = $root_path;
		$this->php_ext = $php_ext;
	}

	public function get_db_type()
	{
		$pieces = explode('.', $this->get_type());
		return $pieces[count($pieces) - 1];
	}

	public function get_content($data = [])
	{
		$lang_key = strtoupper(str_replace('.', '_', $this->get_type()));
		$lang_ary = $this->get_lang_array($data);
		return $this->language->lang_array($lang_key, $lang_ary);
	}

	/**
	 * Returns all currently logged in users
	 */
	public function get_receivers($data)
	{
		$sql_ary = $this->get_basic_query();
		return $this->query_receivers($sql_ary);
	}

	protected function get_basic_query()
	{
		return [
			'SELECT'	=> 's.session_id',
			'FROM'		=> [$this->sessions_table => 's'],
			'LEFT_JOIN'	=> [
				[
					'FROM'	=> [$this->users_table => 'u'],
					'ON'	=> 'u.user_id = s.session_user_id',
				]
			],
			'WHERE'		=> 'u.user_type <> ' . USER_INACTIVE . '
				AND u.user_type <> ' . USER_IGNORE . '
				AND s.session_time > ' . (time() - 600), // 10 minutes
		];
	}

	protected function query_receivers($sql_ary)
	{
		$sql = $this->db->sql_build_query('SELECT', $sql_ary);
		$result = $this->db->sql_query($sql);
		$receivers = $this->db->sql_fetchrowset($result);
		$this->db->sql_freeresult($result);

		return $receivers;
	}
}
