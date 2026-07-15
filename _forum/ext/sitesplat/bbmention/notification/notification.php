<?php

/**
* @package   BB@mention
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
*/
namespace sitesplat\bbmention\notification;

use parse_message;
use phpbb\notification\type\post;
use s9e\TextFormatter\Utils;

class notification extends post
{
	protected $language_key = 'NOTIFICATION_BBMENTION';
	public static $notification_option = array(
		'lang'  => 'NOTIFICATION_TYPE_BBMENTION',
		'group' => 'NOTIFICATION_GROUP_POSTING'
	);
	protected $tables = array();

	public function find_users_for_notification($post, $options = array())
	{
		return $this->get_authorised_recipients($this->getUserIdsFromPost($post), $post['forum_id'], $options, true);
	}

	public function get_email_template()
	{
		return false;
	}

	public function get_redirect_url()
	{
		return $this->get_url();
	}

	public function get_type()
	{
		return 'sitesplat.bbmention.notification';
	}

	public function is_available()
	{
		return true;
	}

	public function setBbmentionTables($groupsTable, $userGroupTable, $usersTable)
	{
		$this->tables['groups']     = $groupsTable;
		$this->tables['user_group'] = $userGroupTable;
		$this->tables['users']      = $usersTable;
	}

	protected function getGroupIds(array $names)
	{
		$sql = 'SELECT group_id
		          FROM ' . $this->tables['groups'] . '
		         WHERE group_type <> ' . GROUP_HIDDEN . '
		           AND ' . $this->db->sql_in_set('group_name', $names);
		$result = $this->db->sql_query($sql);

		$groupIds = array();
		while ($row = $this->db->sql_fetchrow($result))
		{
			$groupIds[] = $row['group_id'];
		}
		$this->db->sql_freeresult($result);

		return $groupIds;
	}

	protected function getGroupLeaders(array $groupIds)
	{
		$userIds = array();

		$sql = 'SELECT user_id
		          FROM ' . $this->tables['user_group'] . '
		         WHERE group_id IN (' . implode(', ', $groupIds) . ')
		           AND group_leader = 1';
		$result = $this->db->sql_query($sql);
		while ($row = $this->db->sql_fetchrow($result))
		{
			$userIds[] = $row['user_id'];
		}
		$this->db->sql_freeresult($result);

		return $userIds;
	}

	protected function getUserIds(array $names)
	{
		$sql = 'SELECT user_id
		          FROM ' . $this->tables['users'] . '
		         WHERE ' . $this->db->sql_in_set('username', $names);
		$result = $this->db->sql_query($sql);

		$userIds = array();
		while ($row = $this->db->sql_fetchrow($result))
		{
			$userIds[] = $row['user_id'];
		}
		$this->db->sql_freeresult($result);

		return $userIds;
	}

	protected function getUserIdsFromPost(array $post)
	{
		$bbcodeUid = $post['bbcode_uid'];
		$text      = $this->scrubText($post['message'], $bbcodeUid);

		$groupIds   = array();
		$userIds    = array();

		if ($this->isNewFormat($post['message']))
		{
			$regexp = '(<(?:GROUP|USER)MENTION (group|user)mention="(\\d+).*?</(?:GROUP|USER)MENTION>)';
		}
		else
		{
			$regexp = '(\\[(group|user)mention=(\\d+):' . $bbcodeUid . '\\][^[]*)i';
		}

		$text = preg_replace_callback(
			$regexp,
			function ($m) use (&$groupIds, &$userIds)
			{
				if ($m[1] === 'user')
				{
					$userIds[] = $m[2];
				}
				else
				{
					$groupIds[] = $m[2];
				}

				return '';
			},
			$text
		);

		$regexp = '(\\B@("[^"]+"|[-\\w]+))';
		if (preg_match_all($regexp, $text, $matches))
		{
			$names  = array();
			foreach ($matches[1] as $mention)
			{
				$names[] = trim($mention, '"');
			}

			$groupIds = array_merge($groupIds, $this->getGroupIds($names));
			$userIds  = array_merge($userIds,  $this->getUserIds($names));
		}

		if (!empty($groupIds))
		{
			$userIds = array_merge($userIds, $this->getGroupLeaders($groupIds));
		}

		return $userIds;
	}

	protected function isNewFormat($text)
	{
		return (bool) preg_match('(^<[rt][ />])', $text);
	}

	protected function scrubText($text, $bbcodeUid)
	{
		if ($this->isNewFormat($text))
		{
			$text = Utils::removeTag($text, 'CODE');
			$text = Utils::removeTag($text, 'QUOTE');
		}
		else
		{
			$regexp = '(\\[code(?:=\w*)?:' . $bbcodeUid . '\\].*?\\[/code:' . $bbcodeUid . '\\])is';
			$text   = preg_replace($regexp, '', $text);

			if (!class_exists('parse_message'))
			{
				include_once $phpbb_root_path . 'includes/message_parser.php';
			}

			$parser = new parse_message;
			$parser->bbcode_uid = $bbcodeUid;
			$parser->message    = $text;
			$parser->remove_nested_quotes($text, 0);

			$text = $parser->message;
		}


		return $text;
	}
}