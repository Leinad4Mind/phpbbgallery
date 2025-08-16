<?php

/**
 *
 * Limit Posts and Topics per Forum. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2019, Leinad4Mind, https://leinad4mind.top/forum
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace leinad4mind\limitperforum\manager;

use phpbb\db\driver\driver_interface;
use phpbb\group\helper;

class forum_groups_manager
{
	/** @var driver_interface */
	protected $db;

	/** @var helper */
	protected $group_helper;

	/** @var string */
	protected $table_forum_groups;

	/**
	 * @param driver_interface	$db
	 * @param helper			$group_helper
	 * @param string			$table_forum_groups
	 */
	public function __construct(
		driver_interface $db,
		helper $group_helper,
		$table_forum_groups
	)
	{
		$this->db					= $db;
		$this->group_helper			= $group_helper;
		$this->table_forum_groups	= $table_forum_groups;
	}

	/**
	 * @param int $forum_id
	 * @param int $user_id
	 * @return array
	 */
	public function get_limits($forum_id, $user_id = 0)
	{
		$sql_ary = [
			'SELECT'	=> 'g.group_id, g.group_name, lpfg.forum_id, lpfg.topics, lpfg.posts',
			'FROM'		=> [GROUPS_TABLE => 'g'],
			'LEFT_JOIN'	=> [
				[
					'FROM'	=> [$this->table_forum_groups => 'lpfg'],
					'ON'	=> implode(' AND ', [
						'g.group_id = lpfg.group_id',
						'lpfg.forum_id = ' . (int) $forum_id,
					]),
				],
			],
			'ORDER_BY'	=> 'g.group_name ASC',
		];

		if ($user_id)
		{
			$user_group_ids = $this->get_user_groups($user_id);
			$sql_ary['WHERE'] = $this->db->sql_in_set('lpfg.group_id', $user_group_ids[$user_id]);
		}

		$sql = $this->db->sql_build_query('SELECT', $sql_ary);
		$result = $this->db->sql_query($sql);
		$rows = $this->db->sql_fetchrowset($result);
		$this->db->sql_freeresult($result);

		foreach ($rows as $i => $row)
		{
			$rows[$i]['group_name'] = $this->group_helper->get_name($row['group_name']);
		}

		return $rows;
	}

	/**
	 * @param int $forum_id
	 * @param array $topics
	 * @param array $posts
	 */
	public function set_limits($forum_id, $topics, $posts)
	{
		$this->delete_limits($forum_id);

		$rows = [];

		foreach (array_keys($topics) as $group_id)
		{
			if ($topics[$group_id] || $posts[$group_id])
			{
				$rows[] = [
					'forum_id'	=> $forum_id,
					'group_id'	=> $group_id,
					'topics'	=> $topics[$group_id],
					'posts'		=> $posts[$group_id],
				];
			}
		}

		$this->db->sql_multi_insert($this->table_forum_groups, $rows);
	}

	/**
	 * @param int $forum_id
	 */
	public function delete_limits($forum_id)
	{
		$sql = 'DELETE FROM ' . $this->table_forum_groups . '
			WHERE forum_id = ' . (int) $forum_id;
		$this->db->sql_query($sql);
	}

	/**
	 * @param int|array $user_ids
	 * @return array
	 */
	protected function get_user_groups($user_ids)
	{
		if (!$user_ids)
		{
			return [];
		}

		if (!is_array($user_ids))
		{
			$user_ids = [$user_ids];
		}

		$sql_ary = [
			'SELECT'	=> 'ug.user_id, ug.group_id',
			'FROM'		=> [USER_GROUP_TABLE => 'ug'],
			'WHERE'		=> implode(' AND ', [
				'ug.user_pending = 0',
				$this->db->sql_in_set('ug.user_id', $user_ids),
			]),
		];

		$sql = $this->db->sql_build_query('SELECT', $sql_ary);
		$result = $this->db->sql_query($sql);
		$rows = $this->db->sql_fetchrowset($result);
		$this->db->sql_freeresult($result);

		$user_groups = array_fill_keys($user_ids, []);

		foreach ($rows as $row)
		{
			$user_groups[$row['user_id']][] = $row['group_id'];
		}

		return $user_groups;
	}
}
