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

use phpbb\db\driver\driver_interface;

class user_repository
{
	/** @var driver_interface */
	protected $db;

	public function __construct(driver_interface $db)
	{
		$this->db = $db;
	}

	/**
	 * Resolve usernames to IDs and report names that do not exist.
	 *
	 * @param array $usernames Usernames
	 * @return array Array containing ids and missing names
	 */
	public function resolve_names(array $usernames)
	{
		$clean_to_name = [];
		foreach ($usernames as $username)
		{
			$username = trim((string) $username);
			if ($username !== '')
			{
				$clean_to_name[utf8_clean_string($username)] = $username;
			}
		}

		if (!$clean_to_name)
		{
			return ['ids' => [], 'missing' => []];
		}

		$sql = 'SELECT user_id, username_clean
			FROM ' . USERS_TABLE . '
			WHERE ' . $this->db->sql_in_set('username_clean', array_keys($clean_to_name));
		$result = $this->db->sql_query($sql);

		$ids = [];
		while ($row = $this->db->sql_fetchrow($result))
		{
			$ids[] = (int) $row['user_id'];
			unset($clean_to_name[$row['username_clean']]);
		}
		$this->db->sql_freeresult($result);

		sort($ids);

		return [
			'ids' => $ids,
			'missing' => array_values($clean_to_name),
		];
	}

	/**
	 * Resolve IDs to display names.
	 *
	 * @param array $user_ids User IDs
	 * @return array
	 */
	public function get_names(array $user_ids)
	{
		$user_ids = array_values(array_filter(array_unique(array_map('intval', $user_ids))));
		if (!$user_ids)
		{
			return [];
		}

		$sql = 'SELECT username
			FROM ' . USERS_TABLE . '
			WHERE ' . $this->db->sql_in_set('user_id', $user_ids);
		$result = $this->db->sql_query($sql);

		$usernames = [];
		while ($row = $this->db->sql_fetchrow($result))
		{
			$usernames[] = $row['username'];
		}
		$this->db->sql_freeresult($result);
		sort($usernames);

		return $usernames;
	}
}
