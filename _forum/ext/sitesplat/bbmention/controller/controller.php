<?php

/**
* @package   BB@mention
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
*/
namespace sitesplat\bbmention\controller;

use phpbb\auth\auth;
use phpbb\db\driver\driver_interface as db;
use phpbb\json_response;
use phpbb\request\request_interface;
use phpbb\user;

class controller
{
	protected $auth;
	protected $db;
	protected $matchesLimit = 10;
	protected $noAvatarUserImg;
	protected $noAvatarGroupImg;
	protected $request;
	protected $tables;
	protected $user;

	public function __construct(auth $auth, db $db, request_interface $request, user $user, $groupsTable, $postsTable, $topicsTable, $usersTable)
	{
		$this->auth    = $auth;
		$this->db      = $db;
		$this->request = $request;
		$this->tables  = array(
			'groups' => $groupsTable,
			'posts'  => $postsTable,
			'topics' => $topicsTable,
			'users'  => $usersTable
		);
		$this->user    = $user;

		$path = generate_board_url() . '/ext/sitesplat/bbmention/styles/all/theme/images/';
		$this->noAvatarUserImg  = '<img src="' . $path . 'no_user_avatar.svg">';
		$this->noAvatarGroupImg = '<img src="' . $path . 'no_group_avatar.svg">';
	}

	public function getMatches()
	{
		$topicId = $this->request->variable('t', 0);
		$prefix  = $this->normalizeString($this->request->variable('str', '', true));
		$rows    = array(
			'group' => array(),
			'user'  => array()
		);

		if ($prefix > '')
		{
			$rows['group'] = $this->getMatchingGroups($prefix);
		}
		// if ($this->canRead($topicId))
		// {
		$rows['user'] = $this->getMatchingUsers($topicId, $prefix);
		// }

		$response = new json_response;
		$response->send($this->formatRows($rows));
	}

	protected function canRead($topicId)
	{
		$sql      = 'SELECT forum_id FROM ' . $this->tables['topics'] . ' WHERE topic_id = ' . $topicId;
		$result   = $this->db->sql_query($sql);
		$forum_id = (int) $this->db->sql_fetchfield('forum_id');
		$this->db->sql_freeresult($result);

		return $this->auth->acl_get('f_read', $forum_id);
	}

	protected function getAvatar($type, array $row)
	{
		if (!defined('PHPBB_USE_BOARD_URL_PATH'))
		{
			define('PHPBB_USE_BOARD_URL_PATH', true);
		}

		$methodName = 'phpbb_get_' . $type . '_avatar';
		$html = $methodName($row);

		if (!$html)
		{
			$html = ($type === 'group') ? $this->noAvatarGroupImg : $this->noAvatarUserImg;
		}

		return $html;
	}

	protected function formatRows(array $rows)
	{
		$formattedRows = array();
		foreach ($rows as $type => $rows)
		{
			foreach ($rows as $row)
			{
				if (isset($row['username']))
				{
					$row['user_name'] = $row['username'];
				}

				$bbcodeName = $htmlName = '@' . $row[$type . '_name'];
				if ($row[$type . '_colour'])
				{
					$bbcodeName = '[color=#' . $row[$type . '_colour'] . ']' . $bbcodeName . '[/color]';
					$htmlName   = '<span style="color:#' . $row[$type . '_colour'] . '">' . $htmlName . '</span>';
				}

				$bbcode = '[' . $type . 'mention=' . $row[$type . '_id'] . ']' . $bbcodeName . '[/' . $type . 'mention]';
				$html   = '<span class="nemtion">' . $this->getAvatar($type, $row) . ' ' . $htmlName . '</span>';

				$formattedRows[] = array($bbcode, $html);
			}
		}

		return $formattedRows;
	}

	protected function getGroupRow($groupName)
	{
		$sql = 'SELECT group_id, group_name, group_avatar, group_avatar_type, group_avatar_width, group_avatar_height, group_colour
		          FROM ' . $this->tables['groups'] . "
		         WHERE group_name = '" . $groupName . "'";
		$result = $this->db->sql_query_limit($sql, $this->matchesLimit);
		$row    = $this->db->sql_fetchrow($result);
		$this->db->sql_freeresult($result);

		$row['group_name'] = $this->user->lang('G_' . $row['group_name']);

		return $row;
	}

	protected function getMatchingGroups($prefix)
	{
		$sql = 'SELECT group_id, group_name, group_avatar, group_avatar_type, group_avatar_width, group_avatar_height, group_colour
		          FROM ' . $this->tables['groups'] . '
		         WHERE group_type IN (' . GROUP_OPEN . ', ' . GROUP_CLOSED . ', ' . GROUP_FREE . ')
		           AND LOWER(group_name) ' . $this->db->sql_like_expression($prefix . $this->db->get_any_char());
		$result = $this->db->sql_query_limit($sql, $this->matchesLimit);
		$rows   = $this->db->sql_fetchrowset($result);
		$this->db->sql_freeresult($result);

		$specialGroups = array(
			'administrators'    => 'ADMINISTRATORS',
			'global moderators' => 'GLOBAL_MODERATORS',
			'moderators'        => 'GLOBAL_MODERATORS'
		);
		foreach ($specialGroups as $match => $groupName)
		{
			if (strpos($match, $prefix) === 0)
			{
				$rows[] = $this->getGroupRow($groupName);
			}
		}

		return $rows;
	}

	protected function getMatchingUsers($topicId, $prefix)
	{
		$predicate = '';
		if ($prefix > '')
		{
			$predicate = ' AND u.username_clean ' . $this->db->sql_like_expression($prefix . $this->db->get_any_char());
		}

		$sql = 'SELECT u.user_id, u.username, u.user_colour, u.user_avatar, u.user_avatar_type, u.user_avatar_width, u.user_avatar_height, MAX(p.post_time) AS max_time
		          FROM ' . $this->tables['posts'] . ' p
		          JOIN ' . $this->tables['users'] . ' u ON u.user_id = p.poster_id
		         WHERE p.topic_id = ' . $topicId . $predicate . '
		           AND u.user_type IN (' . USER_NORMAL . ', ' . USER_FOUNDER . ')
		      GROUP BY p.poster_id
		      ORDER BY max_time DESC';
		$result = $this->db->sql_query_limit($sql, $this->matchesLimit);

		$userIds = array();
		$rows    = array();
		while ($row = $this->db->sql_fetchrow($result))
		{
			$rows[]    = $row;
			$userIds[] = $row['user_id'];
		}
		$this->db->sql_freeresult($result);

		if (count($rows) < $this->matchesLimit && $prefix > '')
		{
			if (!empty($userIds))
			{
				$predicate .= ' AND u.user_id NOT IN (' . implode(', ', $userIds) . ')';
			}

			$sql = 'SELECT u.user_id, u.username, u.user_colour, u.user_avatar, u.user_avatar_type, u.user_avatar_width, u.user_avatar_height
					  FROM ' . $this->tables['users'] . ' u
					 WHERE u.user_type IN (' . USER_NORMAL . ', ' . USER_FOUNDER . ')
					   AND u.user_posts >= ' . $this->getMinPosts() . '
					  ' . $predicate . '
				  ORDER BY u.user_posts DESC';
			$result = $this->db->sql_query_limit($sql, $this->matchesLimit - count($rows));
			while ($row = $this->db->sql_fetchrow($result))
			{
				$rows[] = $row;
			}
			$this->db->sql_freeresult($result);
		}

		return $rows;
	}

	protected function getMinPosts()
	{
		global $config;
		if (isset($config['num_posts']) && $config['num_posts'] > 1000)
		{
			return strlen($config['num_posts']) - 3;
		}

		return 0;
	}

	protected function normalizeString($str)
	{
		return (preg_match('(\\W)', $str)) ? utf8_clean_string($str) : strtolower($str);
	}
}