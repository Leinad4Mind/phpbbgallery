<?php
/**
 *
 * BBajaxnews. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2018, SiteSplat
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace sitesplat\bbajaxnews\ajaxnews\type;

class users_online extends base
{
	protected $config;
	public function set_dependencies(\phpbb\config\config $config)
	{
		$this->config = $config;
	}

	public function get_type()
	{
		return 'sitesplat.bbajaxnews.ajaxnews.type.users_online';
	}

	public function get_lang_array($data)
	{
		$time = time() - (intval($this->config['load_online_time']) * 60);
		$sql = 'SELECT g.total_guests + r.total_registered as total_users
				FROM (
					SELECT COUNT(dummy1.session_id) as total_guests
					FROM (
						SELECT session_id
						FROM ' . $this->sessions_table . '
						WHERE session_user_id = ' . ANONYMOUS . '
							AND session_time >= ' . $time . '
						GROUP BY session_ip
					) dummy1
				) g, (
					SELECT COUNT(dummy2.session_id) as total_registered
					FROM (
						SELECT session_id
						FROM ' . $this->sessions_table . '
						WHERE session_user_id <> ' . ANONYMOUS . '
							AND session_time >= ' . $time . '
						GROUP BY session_user_id
					) dummy2
				) r';
		$this->db->sql_query($sql);

		return [
			(int) $this->db->sql_fetchfield('total_users'),
		];
	}

	public function is_special()
	{
		return false;
	}
}
