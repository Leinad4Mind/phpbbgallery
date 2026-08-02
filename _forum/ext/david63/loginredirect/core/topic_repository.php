<?php
/**
 * @package User Login Redirect
 * @copyright (c) 2026 Leinad4Mind
 * @license GNU General Public License, version 2 (GPL-2.0)
 */

namespace david63\loginredirect\core;

use phpbb\auth\auth;
use phpbb\db\driver\driver_interface;

class topic_repository
{
	protected $db;
	protected $auth;
	protected $tables;
	protected $readable_forums;

	public function __construct(driver_interface $db, auth $auth, array $tables)
	{
		$this->db = $db;
		$this->auth = $auth;
		$this->tables = $tables;
	}

	public function find_topic($topic_id, $announcement_only = false)
	{
		$topic_id = (int) $topic_id;
		if ($topic_id <= 0)
		{
			return null;
		}
		$sql = 'SELECT topic_id, forum_id, topic_time, topic_type, topic_visibility
			FROM ' . $this->tables['topics'] . '
			WHERE topic_id = ' . (int) $topic_id . '
				AND topic_visibility = ' . ITEM_APPROVED;
		if ($announcement_only)
		{
			$sql .= ' AND ' . $this->db->sql_in_set('topic_type', array(POST_ANNOUNCE, POST_GLOBAL));
		}
		$result = $this->db->sql_query($sql);
		$row = $this->db->sql_fetchrow($result);
		$this->db->sql_freeresult($result);
		return $this->can_read($row) ? $this->normalize($row) : null;
	}

	public function topic_exists($topic_id, $announcement_only = false)
	{
		$topic_id = (int) $topic_id;
		if ($topic_id <= 0)
		{
			return false;
		}
		$sql = 'SELECT topic_id
			FROM ' . $this->tables['topics'] . '
			WHERE topic_id = ' . (int) $topic_id . '
				AND topic_visibility = ' . ITEM_APPROVED;
		if ($announcement_only)
		{
			$sql .= ' AND ' . $this->db->sql_in_set('topic_type', array(POST_ANNOUNCE, POST_GLOBAL));
		}
		$result = $this->db->sql_query($sql);
		$row = $this->db->sql_fetchrow($result);
		$this->db->sql_freeresult($result);
		return (bool) $row;
	}

	public function find_latest_announcement($global)
	{
		$type = $global ? POST_GLOBAL : POST_ANNOUNCE;
		$sql = 'SELECT topic_id, forum_id, topic_time, topic_type, topic_visibility
			FROM ' . $this->tables['topics'] . '
			WHERE topic_type = ' . (int) $type . '
				AND topic_visibility = ' . ITEM_APPROVED;
		if (!$global)
		{
			$forum_ids = $this->readable_forum_ids();
			if (empty($forum_ids))
			{
				return null;
			}
			$sql .= ' AND ' . $this->db->sql_in_set('forum_id', $forum_ids);
		}
		$sql .= ' ORDER BY topic_time DESC';
		$result = $this->db->sql_query_limit($sql, 1);
		$row = $this->db->sql_fetchrow($result);
		$this->db->sql_freeresult($result);
		return $this->can_read($row) ? $this->normalize($row) : null;
	}

	public function group_exists($group_id)
	{
		$sql = 'SELECT group_id
			FROM ' . $this->tables['groups'] . '
			WHERE group_id = ' . (int) $group_id;
		$result = $this->db->sql_query($sql);
		$row = $this->db->sql_fetchrow($result);
		$this->db->sql_freeresult($result);
		return (bool) $row;
	}

	public function user_in_group($user_id, $group_id)
	{
		$sql = 'SELECT group_id
			FROM ' . $this->tables['user_group'] . '
			WHERE group_id = ' . (int) $group_id . '
				AND user_id = ' . (int) $user_id . '
				AND user_pending = 0';
		$result = $this->db->sql_query($sql);
		$row = $this->db->sql_fetchrow($result);
		$this->db->sql_freeresult($result);
		return (bool) $row;
	}

	protected function can_read($row)
	{
		if (!is_array($row) || (int) $row['topic_visibility'] !== ITEM_APPROVED)
		{
			return false;
		}
		$forum_id = (int) $row['forum_id'];
		if ($forum_id === 0)
		{
			return !empty($this->readable_forum_ids());
		}
		return $this->auth->acl_get('f_list', $forum_id) && $this->auth->acl_get('f_read', $forum_id);
	}

	protected function readable_forum_ids()
	{
		if ($this->readable_forums === null)
		{
			$this->readable_forums = array();
			foreach (array_keys($this->auth->acl_getf('f_read', true)) as $forum_id)
			{
				if ((int) $forum_id > 0 && $this->auth->acl_get('f_list', (int) $forum_id))
				{
					$this->readable_forums[] = (int) $forum_id;
				}
			}
		}
		return $this->readable_forums;
	}

	protected function normalize(array $row)
	{
		foreach (array('topic_id', 'forum_id', 'topic_time', 'topic_type', 'topic_visibility') as $key)
		{
			$row[$key] = (int) $row[$key];
		}
		return $row;
	}
}
