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
use phpbb\cache\service;
use phpbb\config\config;
use phpbb\content_visibility;
use phpbb\db\driver\driver_interface;
use phpbb\language\language;
use phpbb\pagination;
use phpbb\template\template;
use phpbb\user;

class profile_view
{
	protected $config;
	protected $template;
	protected $db;
	protected $user;
	protected $content_visibility;
	protected $cache;
	protected $pagination;
	protected $root_path;
	protected $php_ext;
	protected $table;
	protected $auth;
	protected $language;
	protected $forum_access;

	public function __construct(config $config, template $template, driver_interface $db, user $user, content_visibility $content_visibility, service $cache, pagination $pagination, $root_path, $php_ext, $table, auth $auth, language $language, forum_access $forum_access)
	{
		$this->config = $config;
		$this->template = $template;
		$this->db = $db;
		$this->user = $user;
		$this->content_visibility = $content_visibility;
		$this->cache = $cache;
		$this->pagination = $pagination;
		$this->root_path = $root_path;
		$this->php_ext = $php_ext;
		$this->table = $table;
		$this->auth = $auth;
		$this->language = $language;
		$this->forum_access = $forum_access;
	}

	public function assign(array $member, $limit, array $excluded_ids)
	{
		$profile_user_id = (int) $member['user_id'];
		$viewer_id = (int) $this->user->data['user_id'];
		if (in_array($profile_user_id, $excluded_ids, true)
			|| (empty($member['user_allow_viewonline']) && !$this->auth->acl_get('u_viewonline') && $profile_user_id !== $viewer_id))
		{
			return;
		}

		$forum_ids = $this->forum_access->get_readable_forum_ids($viewer_id);
		if (!$forum_ids)
		{
			return;
		}

		$sql_array = [
			'SELECT' => 'ft.forum_name, tt.*, wt.date AS last_visit',
			'FROM' => [$this->table => 'wt'],
			'LEFT_JOIN' => [
				['FROM' => [TOPICS_TABLE => 'tt'], 'ON' => 'wt.topic_id = tt.topic_id'],
				['FROM' => [FORUMS_TABLE => 'ft'], 'ON' => 'ft.forum_id = tt.forum_id'],
			],
			'WHERE' => 'tt.topic_moved_id = 0
				AND wt.user_id = ' . $profile_user_id . '
				AND ' . $this->db->sql_in_set('tt.forum_id', $forum_ids) . '
				AND ' . $this->content_visibility->get_forums_visibility_sql('topic', $forum_ids, 'tt.'),
			'ORDER_BY' => 'wt.date DESC',
		];

		if (!empty($this->user->data['is_registered']) && !empty($this->config['load_db_lastread']))
		{
			$sql_array['LEFT_JOIN'][] = ['FROM' => [TOPICS_TRACK_TABLE => 'ttt'], 'ON' => 'ttt.topic_id = tt.topic_id AND ttt.user_id = ' . $viewer_id];
			$sql_array['LEFT_JOIN'][] = ['FROM' => [FORUMS_TRACK_TABLE => 'ftt'], 'ON' => 'ftt.forum_id = tt.forum_id AND ftt.user_id = ' . $viewer_id];
			$sql_array['SELECT'] .= ', ttt.mark_time, ftt.mark_time AS f_mark_time';
		}

		$result = $this->db->sql_query_limit($this->db->sql_build_query('SELECT', $sql_array), (int) $limit);
		$rowset = [];
		while ($row = $this->db->sql_fetchrow($result))
		{
			$rowset[(int) $row['topic_id']] = $row;
		}
		$this->db->sql_freeresult($result);

		$icons = $this->cache->obtain_icons();
		foreach ($rowset as $topic_id => $row)
		{
			$this->assign_topic($topic_id, $row, $rowset, $icons);
		}
		$this->template->assign_var('PERMISSION_PROFILE', true);
	}

	private function assign_topic($topic_id, array $row, array &$rowset, array $icons)
	{
		$forum_id = (int) $row['forum_id'];
		$tracking = [];
		if (!empty($this->user->data['is_registered']) && !empty($this->config['load_db_lastread']))
		{
			$tracking = get_topic_tracking($forum_id, $topic_id, $rowset, [$forum_id => $row['f_mark_time']]);
		}
		else if (!empty($this->config['load_anon_lastread']) || !empty($this->user->data['is_registered']))
		{
			$tracking = get_complete_topic_tracking($forum_id, $topic_id);
		}

		$replies = $this->content_visibility->get_count('topic_posts', $row, $forum_id) - 1;
		$folder_img = $folder_alt = $topic_type = '';
		$unread = isset($tracking[$topic_id]) && (int) $row['topic_last_post_time'] > (int) $tracking[$topic_id];
		topic_status($row, $replies, $unread, $folder_img, $folder_alt, $topic_type);
		$topic_unapproved = (int) $row['topic_visibility'] === ITEM_UNAPPROVED;
		$posts_unapproved = (int) $row['topic_visibility'] === ITEM_APPROVED && !empty($row['topic_posts_unapproved']);
		$u_mcp_queue = ($topic_unapproved || $posts_unapproved) ? append_sid("{$this->root_path}mcp.{$this->php_ext}", 'i=queue&amp;mode=' . ($topic_unapproved ? 'approve_details' : 'unapproved_posts') . '&amp;t=' . $topic_id, true, $this->user->session_id) : '';
		$base_url = append_sid("{$this->root_path}viewtopic.{$this->php_ext}", 'f=' . $forum_id . '&amp;t=' . $topic_id);
		$forum_url = $forum_id ? append_sid("{$this->root_path}viewforum.{$this->php_ext}", 'f=' . $forum_id) : append_sid("{$this->root_path}index.{$this->php_ext}");
		$icon = !empty($icons[$row['icon_id']]) ? $icons[$row['icon_id']] : [];

		$this->template->assign_block_vars('whovisitedthistopic', [
			'TOPIC_ID' => $topic_id,
			'FORUM_ID' => $forum_id,
			'TOPIC_REPLIES' => $replies,
			'TOPIC_VIEWS' => (int) $row['topic_views'],
			'TOPIC_TITLE' => censor_text($row['topic_title']),
			'FORUM_TITLE' => $row['forum_name'] ?: $this->language->lang('ALL_FORUMS'),
			'LAST_VISIT' => $this->user->format_date($row['last_visit']),
			'TOPIC_AUTHOR_FULL' => get_username_string('full', $row['topic_poster'], $row['topic_first_poster_name'], $row['topic_first_poster_colour']),
			'FIRST_POST_TIME' => $this->user->format_date($row['topic_time']),
			'LAST_POST_TIME' => $this->user->format_date($row['topic_last_post_time']),
			'LAST_POST_AUTHOR_FULL' => get_username_string('full', $row['topic_last_poster_id'], $row['topic_last_poster_name'], $row['topic_last_poster_colour']),
			'S_HAS_POLL' => (bool) $row['poll_start'],
			'S_TOPIC_REPORTED' => !empty($row['topic_reported']) && $this->auth->acl_get('m_report', $forum_id),
			'S_TOPIC_UNAPPROVED' => $topic_unapproved,
			'S_POSTS_UNAPPROVED' => $posts_unapproved,
			'S_UNREAD_TOPIC' => $unread,
			'TOPIC_ICON_IMG' => isset($icon['img']) ? $icon['img'] : '',
			'TOPIC_ICON_IMG_WIDTH' => isset($icon['width']) ? $icon['width'] : '',
			'TOPIC_ICON_IMG_HEIGHT' => isset($icon['height']) ? $icon['height'] : '',
			'ATTACH_ICON_IMG' => ($this->auth->acl_get('u_download') && $this->auth->acl_get('f_download', $forum_id) && !empty($row['topic_attachment'])) ? $this->user->img('icon_topic_attach', $this->language->lang('TOTAL_ATTACHMENTS')) : '',
			'TOPIC_IMG_STYLE' => $folder_img,
			'TOPIC_FOLDER_IMG' => $this->user->img($folder_img, $folder_alt),
			'TOPIC_FOLDER_IMG_ALT' => $this->language->lang($folder_alt),
			'U_NEWEST_POST' => append_sid("{$this->root_path}viewtopic.{$this->php_ext}", 'f=' . $forum_id . '&amp;t=' . $topic_id . '&amp;view=unread') . '#unread',
			'U_LAST_POST' => append_sid("{$this->root_path}viewtopic.{$this->php_ext}", 'f=' . $forum_id . '&amp;t=' . $topic_id . '&amp;p=' . (int) $row['topic_last_post_id']) . '#p' . (int) $row['topic_last_post_id'],
			'U_VIEW_TOPIC' => $base_url,
			'U_VIEW_FORUM' => $forum_url,
			'U_MCP_REPORT' => append_sid("{$this->root_path}mcp.{$this->php_ext}", 'i=reports&amp;mode=reports&amp;f=' . $forum_id . '&amp;t=' . $topic_id, true, $this->user->session_id),
			'U_MCP_QUEUE' => $u_mcp_queue,
		]);
		$this->pagination->generate_template_pagination($base_url, 'whovisitedthistopic.pagination', 'start', $replies + 1, (int) $this->config['posts_per_page'], 1, true, true);
	}
}
