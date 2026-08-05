<?php
/**
 *
 * @package phpBB Extension - Who Visited This Topic
 * @copyright (c) 2016 dmzx - https://www.dmzx-web.net
 * @copyright (c) 2026 Leinad4Mind
 * @license https://opensource.org/licenses/GPL-2.0 GNU General Public License v2
 *
 */

namespace dmzx\whovisitedthistopic\core;

use phpbb\auth\auth;
use phpbb\db\driver\driver_interface;

class forum_access
{
	/** @var auth */
	protected $auth;

	/** @var driver_interface */
	protected $db;

	public function __construct(auth $auth, driver_interface $db)
	{
		$this->auth = $auth;
		$this->db = $db;
	}

	/**
	 * Return forums whose topics the current viewer may list and read.
	 *
	 * @param int $user_id Current viewer ID
	 * @return array
	 */
	public function get_readable_forum_ids($user_id)
	{
		$readable = array_keys($this->auth->acl_getf('f_read', true));
		$listable = array_keys($this->auth->acl_getf('f_list_topics', true));
		$forum_ids = array_values(array_intersect($readable, $listable));
		$forum_ids = array_values(array_filter(array_unique(array_map('intval', $forum_ids))));

		if (!$forum_ids)
		{
			return [];
		}

		$sql = 'SELECT f.forum_id, f.forum_password, fa.user_id AS access_user_id
			FROM ' . FORUMS_TABLE . ' f
			LEFT JOIN ' . FORUMS_ACCESS_TABLE . ' fa
				ON fa.forum_id = f.forum_id
					AND fa.user_id = ' . (int) $user_id . '
			WHERE ' . $this->db->sql_in_set('f.forum_id', $forum_ids);
		$result = $this->db->sql_query($sql);

		$allowed = [];
		while ($row = $this->db->sql_fetchrow($result))
		{
			if ($row['forum_password'] === '' || (int) $row['access_user_id'] === (int) $user_id)
			{
				$allowed[] = (int) $row['forum_id'];
			}
		}
		$this->db->sql_freeresult($result);

		if ($allowed)
		{
			// Global announcements use forum_id 0.
			$allowed[] = 0;
		}

		return $allowed;
	}
}
