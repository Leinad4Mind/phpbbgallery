<?php
/**
*
* @package BBajaxnews
* @copyright (c) 2018 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\bbajaxnews\ajaxnews\type;

class users_online_24h extends base
{
	protected $config;
	public function set_dependencies(\phpbb\config\config $config)
	{
		$this->config = $config;
	}

	public function get_type()
	{
		return 'sitesplat.bbajaxnews.ajaxnews.type.users_online_24h';
	}

	public function get_lang_array($data)
	{
		$timespan = $this->config['session_length'] > 86400 ? 86400 : $this->config['session_length'];
		$sql = 'SELECT g.total_guests + r.total_registered as total_users
				FROM (
					SELECT COUNT(dummy1.session_id) as total_guests
					FROM (
						SELECT session_id
						FROM ' . $this->sessions_table . '
						WHERE session_user_id = ' . ANONYMOUS . '
							AND session_time >= ' . (time() - $timespan) . '
						GROUP BY session_ip
					) dummy1
				) g, (
					SELECT COUNT(dummy2.session_id) as total_registered
					FROM (
						SELECT session_id
						FROM ' . $this->sessions_table . '
						WHERE session_user_id <> ' . ANONYMOUS . '
							AND session_time >= ' . (time() - $timespan) . '
						GROUP BY session_user_id
					) dummy2
				) r';
		$this->db->sql_query($sql);

		return [
			(int) $this->db->sql_fetchfield('total_users'),
			floor($timespan / 3600), // timespan in hours
		];
	}

	public function is_special()
	{
		return false;
	}
}
