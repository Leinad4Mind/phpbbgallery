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

	protected $groups = [];

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

		$this->get_special_groups();
	}

	public function getMatches()
	{
		$forum_id = $this->request->variable('f', 0);
		$topic_id = $this->request->variable('t', 0);
		$prefix  = $this->normalizeString($this->request->variable('str', '', true));

		$rows['user'] = [];
		$rows['group'] = $this->getMatchingGroups($prefix);

		if (($forum_id && $this->auth->acl_get('f_read', $forum_id)) || $this->canRead($topic_id))
		{
			$rows['user'] = $this->getMatchingUsers($topic_id, $prefix);
		}

		$response = new json_response;
		$response->send($this->formatRows($rows));
	}

	protected function canRead($topicId)
	{
		$sql      = 'SELECT forum_id FROM ' . $this->tables['topics'] . ' WHERE topic_id = ' . $topicId;
		$result   = $this->db->sql_query($sql);
		$forum_id = (int) $this->db->sql_fetchfield('forum_id');
		$this->db->sql_freeresult($result);

		return $forum_id ? $this->auth->acl_get('f_read', $forum_id) : false;
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
		$board_url = generate_board_url();
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

				// support for profile URLs in user list
//				if ($type == 'user') {
//					$url = append_sid("{$board_url}/memberlist.php", "mode=viewprofile&amp;u={$row['user_id']}", true, 'none');
//					$htmlName = '<a onmousedown="ss_ignore_mention(event)" href="' . $url . '">' . $htmlName . '</a>';
//				}

				$bbcode = '[' . $type . 'mention=' . $row[$type . '_id'] . ']' . $bbcodeName . '[/' . $type . 'mention]';
				$html = '<span class="nemtion">' . $this->getAvatar($type, $row) . ' ' . $htmlName . '</span>';

				$formattedRows[] = array($bbcode, $html);
			}
		}

		return $formattedRows;
	}

	protected function get_special_groups()
	{
		$sql = "SELECT group_id, group_name, group_avatar, group_avatar_type, group_avatar_width, group_avatar_height, group_colour
			FROM {$this->tables['groups']} WHERE group_name IN ('ADMINISTRATORS','GLOBAL_MODERATORS')";
		$result = $this->db->sql_query($sql, 86400 * 7);
		while ($row = $this->db->sql_fetchrow($result))
		{
			$this->groups[$row['group_name']] = $row;
		}

		$this->db->sql_freeresult($result);
	}

	protected function getMatchingGroups($prefix)
	{
		$rows = [];
		if ($prefix) {
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
					$this->groups[$groupName]['group_name'] = $this->user->lang('G_' . $groupName);
					$rows[] = $this->groups[$groupName];
				}
			}
		}

		return $rows;
	}

	protected function getMatchingUsers($topicId, $prefix)
	{
		$userIds = $rows = [];
		$predicate = '';
		if ($topicId) {
			if ($prefix)
			{
				$predicate = ' AND u.username_clean ' . $this->db->sql_like_expression($prefix . $this->db->get_any_char());
			}

			$sql = 'SELECT DISTINCT u.user_id, u.username, u.user_colour, u.user_avatar, u.user_avatar_type, u.user_avatar_width, u.user_avatar_height
				FROM ' . $this->tables['posts'] . ' p, ' . $this->tables['users'] . ' u
				WHERE p.topic_id = ' . $topicId . '
				AND u.user_type IN (' . USER_NORMAL . ', ' . USER_FOUNDER . ') AND u.user_id = p.poster_id'  . $predicate . '
				ORDER BY p.post_id DESC';
			$result = $this->db->sql_query_limit($sql, $this->matchesLimit);

			while ($row = $this->db->sql_fetchrow($result))
			{
				$rows[]    = $row;
				$userIds[] = $row['user_id'];
			}
			$this->db->sql_freeresult($result);
		}

		if (count($rows) < $this->matchesLimit && $prefix)
		{
			if (!empty($userIds))
			{
				$predicate .= ' AND u.user_id NOT IN (' . implode(', ', $userIds) . ')';
			}

			$predicate .= ' AND u.username_clean ' . $this->db->sql_like_expression($prefix . $this->db->get_any_char());
			$sql = 'SELECT u.user_id, u.username, u.user_colour, u.user_avatar, u.user_avatar_type, u.user_avatar_width, u.user_avatar_height
				FROM ' . $this->tables['users'] . ' u
				WHERE u.user_type IN (' . USER_NORMAL . ', ' . USER_FOUNDER . ')' . $predicate . '
				AND u.user_posts >= ' . $this->getMinPosts() . '
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
		return (isset($config['num_posts']) && $config['num_posts'] > 1000) ? 1 : 0;
	}

	protected function normalizeString($str)
	{
		return (preg_match('(\\W)', $str)) ? utf8_clean_string($str) : strtolower($str);
	}
}