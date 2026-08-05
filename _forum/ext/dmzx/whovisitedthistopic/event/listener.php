<?php
/**
 *
 * @package phpBB Extension - Who Visited This Topic
 * @copyright (c) 2016 dmzx - https://www.dmzx-web.net
 * @copyright (c) 2026 Leinad4Mind
 * @license https://opensource.org/licenses/GPL-2.0 GNU General Public License v2
 *
 */

namespace dmzx\whovisitedthistopic\event;

use dmzx\whovisitedthistopic\core\profile_view;
use dmzx\whovisitedthistopic\core\visit_repository;
use phpbb\auth\auth;
use phpbb\config\config;
use phpbb\db\driver\driver_interface;
use phpbb\language\language;
use phpbb\template\template;
use phpbb\user;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class listener implements EventSubscriberInterface
{
	protected $config;
	protected $template;
	protected $db;
	protected $user;
	protected $table;
	protected $auth;
	protected $language;
	protected $visits;
	protected $profile_view;

	public function __construct(config $config, template $template, driver_interface $db, user $user, $table, auth $auth, language $language, visit_repository $visits, profile_view $profile_view)
	{
		$this->config = $config;
		$this->template = $template;
		$this->db = $db;
		$this->user = $user;
		$this->table = $table;
		$this->auth = $auth;
		$this->language = $language;
		$this->visits = $visits;
		$this->profile_view = $profile_view;
	}

	static public function getSubscribedEvents()
	{
		return [
			'core.permissions' => 'permissions',
			'core.viewtopic_get_post_data' => 'viewtopic_get_post_data',
			'core.memberlist_view_profile' => 'memberlist_view_profile',
			'core.delete_topics_before_query' => 'delete_topics_before_query',
			'core.delete_user_after' => 'delete_user_after',
		];
	}

	public function permissions($event)
	{
		$permissions = $event['permissions'];
		$permissions += [
			'u_whovisitedthistopic' => ['lang' => 'ACL_U_WHOVISITEDTHISTOPIC', 'cat' => 'whovisitedthistopic'],
			'u_whovisitedthistopic_count' => ['lang' => 'ACL_U_WHOVISITEDTHISTOPIC_COUNT', 'cat' => 'whovisitedthistopic'],
			'u_whovisitedthistopic_profile' => ['lang' => 'ACL_U_WHOVISITEDTHISTOPIC_PROFILE', 'cat' => 'whovisitedthistopic'],
			'u_whovisitedthistopic_show_avatar' => ['lang' => 'ACL_U_WHOVISITEDTHISTOPIC_SHOW_AVATAR', 'cat' => 'whovisitedthistopic'],
		];
		$event['permissions'] = $permissions;
		$categories = $event['categories'];
		$categories['whovisitedthistopic'] = 'WHOVISITEDTHISTOPIC_INDEX';
		$event['categories'] = $categories;
	}

	public function viewtopic_get_post_data($event)
	{
		$topic_id = (int) $event['topic_id'];
		$user_id = (int) $this->user->data['user_id'];
		$enabled = !empty($this->config['whovisitedthistopic_allow_topics']);
		if ($enabled && $user_id !== ANONYMOUS && empty($this->user->data['is_bot']))
		{
			$this->visits->record($user_id, $topic_id, time());
		}
		if (!$enabled || !$this->auth->acl_get('u_whovisitedthistopic'))
		{
			return;
		}

		$limit = $this->limit_config('whovisitedthistopic_value');
		$excluded = $this->excluded_ids('whovisitedthistopic_members');
		$can_count = $this->auth->acl_get('u_whovisitedthistopic_count') && !empty($this->config['whovisitedthistopic_allow_count']);
		$show_avatar = $this->auth->acl_get('u_whovisitedthistopic_show_avatar') && !empty($this->config['whovisitedthistopic_show_avatar']);
		$where = 'w.topic_id = ' . $topic_id;
		if ($excluded)
		{
			$where .= ' AND ' . $this->db->sql_in_set('w.user_id', $excluded, true);
		}
		if (!$this->auth->acl_get('u_viewonline'))
		{
			$where .= ' AND (u.user_allow_viewonline = 1 OR u.user_id = ' . $user_id . ')';
		}

		$sql = 'SELECT w.user_id, w.counter_user, w.date AS last_visit,
				u.username, u.user_colour, u.user_avatar, u.user_avatar_type,
				u.user_avatar_height, u.user_avatar_width
			FROM ' . $this->table . ' w
			INNER JOIN ' . USERS_TABLE . ' u ON u.user_id = w.user_id
			WHERE ' . $where . '
			ORDER BY w.date DESC';
		$result = $this->db->sql_query_limit($sql, $limit);
		while ($row = $this->db->sql_fetchrow($result))
		{
			$this->template->assign_block_vars('whovisitedthistopic', [
				'USERNAME_FULL' => get_username_string('full', $row['user_id'], $row['username'], $row['user_colour']),
				'VISITS' => $can_count ? (int) $row['counter_user'] : 0,
				'LAST_VISIT' => $this->user->format_date($row['last_visit']),
				'AVATAR' => $show_avatar ? phpbb_get_user_avatar($row) : '',
			]);
		}
		$this->db->sql_freeresult($result);

		$title = $this->language->lang('WHOVISITEDTHISTOPIC_TITLE_NO_COUNT', $limit);
		if ($can_count)
		{
			$sql = 'SELECT SUM(w.counter_user) AS counter
				FROM ' . $this->table . ' w
				INNER JOIN ' . USERS_TABLE . ' u ON u.user_id = w.user_id
				WHERE ' . $where;
			$result = $this->db->sql_query($sql);
			$count = (int) $this->db->sql_fetchfield('counter');
			$this->db->sql_freeresult($result);
			$title = $this->language->lang('WHOVISITEDTHISTOPIC_TITLE', $limit, $count);
		}

		$this->template->assign_vars([
			'WHOVISITEDTHISTOPIC_TITLE' => $title,
			'PERMISSION_COUNT' => $can_count,
			'PERMISSION_VIEW' => true,
			'PERMISSION_SHOW_AVATAR' => $show_avatar,
		]);
	}

	public function memberlist_view_profile($event)
	{
		$limit = $this->limit_config('whovisitedthistopic_visit_value');
		$this->template->assign_var('WHOVISITEDTHISTOPIC_VISIT_TITLE', $this->language->lang('WHOVISITEDTHISTOPIC_VISIT_TITLE', $limit));
		if ($this->auth->acl_get('u_whovisitedthistopic_profile') && !empty($this->config['whovisitedthistopic_allow_memberpage']))
		{
			$this->profile_view->assign($event['member'], $limit, $this->excluded_ids('whovisitedthistopic_members_profile'));
		}
	}

	public function delete_topics_before_query($event)
	{
		$tables = $event['table_ary'];
		if (!in_array($this->table, $tables, true))
		{
			$tables[] = $this->table;
		}
		$event['table_ary'] = $tables;
	}

	public function delete_user_after($event)
	{
		$this->visits->delete_users($event['user_ids']);
	}

	private function limit_config($key)
	{
		return max(2, min(255, (int) $this->config[$key]));
	}

	private function excluded_ids($key)
	{
		$ids = json_decode(isset($this->config[$key]) ? $this->config[$key] : '[]', true);
		if (!is_array($ids))
		{
			return [];
		}
		return array_values(array_filter(array_unique(array_map('intval', $ids)), function ($id) {
			return $id > 0;
		}));
	}
}
