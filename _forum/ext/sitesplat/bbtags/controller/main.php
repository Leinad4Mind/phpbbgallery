<?php
/**
 * BBTags public controller.
 *
 * @copyright (c) 2015 SiteSplat All rights reserved
 * @license Proprietary
 */

namespace sitesplat\bbtags\controller;

use phpbb\auth\auth;
use phpbb\cache\service;
use phpbb\config\config;
use phpbb\content_visibility;
use phpbb\controller\helper;
use phpbb\db\driver\driver_interface;
use phpbb\event\dispatcher;
use phpbb\json_response;
use phpbb\pagination;
use phpbb\request\request;
use phpbb\template\template;
use phpbb\user;
use sitesplat\bbtags\tags\manager;
use sitesplat\bbtags\tags\search_query;
use sitesplat\bbtags\tags\filter_url;

class main
{
	protected $db;
	protected $config;
	protected $template;
	protected $helper;
	protected $request;
	protected $user;
	protected $auth;
	protected $cache;
	protected $pagination;
	protected $phpbb_dispatcher;
	protected $content_visibility;
	protected $php_ext;
	protected $phpbb_root_path;
	protected $manager;
	protected $search_query;
	protected $filter_url;
	protected $table_bbtags;
	protected $table_bbtags_topic;

	/**
	 * Constructor.
	 */
	public function __construct(driver_interface $db, config $config, template $template, helper $helper, request $request, user $user, auth $auth, service $cache, pagination $pagination, dispatcher $phpbb_dispatcher, content_visibility $content_visibility, $php_ext, $phpbb_root_path, manager $manager, search_query $search_query, filter_url $filter_url, $table_bbtags, $table_bbtags_topic)
	{
		$this->db = $db;
		$this->config = $config;
		$this->template = $template;
		$this->helper = $helper;
		$this->request = $request;
		$this->user = $user;
		$this->auth = $auth;
		$this->cache = $cache;
		$this->pagination = $pagination;
		$this->phpbb_dispatcher = $phpbb_dispatcher;
		$this->content_visibility = $content_visibility;
		$this->php_ext = $php_ext;
		$this->phpbb_root_path = $phpbb_root_path;
		$this->manager = $manager;
		$this->search_query = $search_query;
		$this->filter_url = $filter_url;
		$this->table_bbtags = $table_bbtags;
		$this->table_bbtags_topic = $table_bbtags_topic;
	}

	/**
	 * Suggest tags from the words used in a post.
	 */
	public function suggest_tags()
	{
		if (!$this->request->is_ajax() || !$this->auth->acl_get('u_bbtags'))
		{
			return $this->helper->error('NOT_AUTHORISED', 403);
		}

		$words = preg_split(
			'/\s+/u',
			$this->strip_bbcode($this->request->variable('message', '', true)),
			-1,
			PREG_SPLIT_NO_EMPTY
		);
		$counts = array_count_values($words ?: array());
		arsort($counts);

		$tags = array();
		foreach ($counts as $word => $count)
		{
			$tag = $this->manager->clean_tag($word);
			if ($tag === '' || utf8_strlen($tag) < (int) $this->config['bbtags_min_length'])
			{
				continue;
			}
			$tags[$tag] = $count;
		}

		$tags = array_slice($tags, 0, (int) $this->config['bbtags_max_tags'], true);
		$response = new json_response();
		$response->send(implode(', ', array_keys($tags)));
	}

	/**
	 * Return predefined tag names matching an autocomplete prefix.
	 */
	public function auto_complete()
	{
		if (!$this->request->is_ajax() || !$this->auth->acl_get('u_bbtags'))
		{
			return $this->helper->error('NOT_AUTHORISED', 403);
		}

		$term = $this->request->variable('term', '', true);
		$forum_id = max(0, $this->request->variable('forum_id', 0));
		$matches = $this->manager->get_predefined_tags($term, 20, $forum_id);

		$response = new json_response();
		$response->send($matches);
	}

	/**
	 * Display topics associated with a tag.
	 *
	 * @param string $tags Tag route
	 *
	 * @return mixed Symfony response
	 */
	public function show_topic($tags)
	{
		return $this->render_search(array($tags), 'and', true);
	}

	/**
	 * Search for topics matching multiple tag names.
	 *
	 * @return mixed Symfony response
	 */
	public function search()
	{
		$operator = ($this->request->variable('operator', 'and') === 'or') ? 'or' : 'and';
		$routes = $this->filter_url->parse_routes($this->request->variable('routes', '', true));
		if (!empty($routes))
		{
			return $this->render_search($routes, $operator, true);
		}
		$tags = preg_split('/[,;]+/u', $this->request->variable('tags', '', true), -1, PREG_SPLIT_NO_EMPTY);

		return $this->render_search($tags ?: array(), $operator, false);
	}

	/**
	 * Resolve tags, apply scopes and display visible matching topics.
	 *
	 * @param array  $values       Tag names or routes
	 * @param string $operator     and or or
	 * @param bool   $values_routes Whether the values are route keys
	 *
	 * @return mixed Symfony response
	 */
	protected function render_search(array $values, $operator, $values_routes)
	{
		if (!$this->auth->acl_get('u_bbtags_read'))
		{
			return $this->helper->error('NOT_AUTHORISED', 403);
		}

		$this->user->add_lang('search');
		include_once $this->phpbb_root_path . 'includes/functions_display.' . $this->php_ext;

		$operator = ($operator === 'or') ? 'or' : 'and';
		$values = array_slice(array_values(array_unique(array_filter(array_map('trim', $values)))), 0, (int) $this->config['bbtags_max_tags']);
		$normalized_values = array();
		foreach ($values as $value)
		{
			$normalized_values[] = $values_routes
				? trim((string) $value)
				: $this->manager->canonical_tag($value);
		}
		$expected_tag_count = count(array_unique(array_filter($normalized_values)));
		$resolved_tags = $this->resolve_search_tags($values, $values_routes);
		$tag_ids = array_map('intval', array_column($resolved_tags, 'id'));

		$excluded_forums = $this->get_excluded_forum_ids();
		$visibility_sql = $this->content_visibility->get_global_visibility_sql('topic', $excluded_forums, 'topics.');
		$allowed_forums = $this->manager->get_allowed_forum_ids_by_tag($tag_ids);
		foreach ($allowed_forums as $tag_id => $forum_ids)
		{
			$allowed_forums[$tag_id] = array_values(array_diff($forum_ids, $excluded_forums));
		}
		$match_sql = (empty($resolved_tags) || ($operator === 'and' && count($resolved_tags) !== $expected_tag_count))
			? '1 = 0'
			: $this->search_query->build($this->table_bbtags_topic, $allowed_forums, $operator);
		$where_sql = $match_sql . '
			AND topics.topic_moved_id = 0
			AND ' . $visibility_sql;

		$sql = 'SELECT COUNT(DISTINCT topics.topic_id) AS total
			FROM ' . TOPICS_TABLE . ' topics
			WHERE ' . $where_sql;
		$result = $this->db->sql_query($sql);
		$topics_count = (int) $this->db->sql_fetchfield('total');
		$this->db->sql_freeresult($result);

		$start = max($this->request->variable('start', 0), 0);
		$start = $this->pagination->validate_start($start, $this->config['topics_per_page'], $topics_count);
		$tag_names = array_column($resolved_tags, 'tag');
		$active_routes = array_column($resolved_tags, 'route');
		$search_value = implode(', ', $tag_names ?: $values);
		$search_url = $this->filter_url->build($active_routes, $operator);
		$this->pagination->generate_template_pagination($search_url, 'pagination', 'start', $topics_count, $this->config['topics_per_page'], $start);

		if ($topics_count > 0)
		{
			$this->display_topics($where_sql, $start, $active_routes, $operator);
		}

		foreach ($resolved_tags as $tag)
		{
			$this->template->assign_block_vars('bbtags_filter', array(
				'TAG' => htmlspecialchars($tag['tag'], ENT_QUOTES, 'UTF-8'),
				'U_REMOVE' => $this->filter_url->toggle($active_routes, $tag['route'], $operator),
			));
		}

		$this->template->assign_vars(array(
			'S_BBTAGS_RESULTS' => true,
			'BBTAGS_TAG_NAME' => htmlspecialchars($search_value, ENT_QUOTES, 'UTF-8'),
			'BBTAGS_SEARCH_VALUE' => htmlspecialchars($search_value, ENT_QUOTES, 'UTF-8'),
			'S_BBTAGS_OPERATOR_AND' => $operator === 'and',
			'S_BBTAGS_OPERATOR_OR' => $operator === 'or',
			'S_SEARCH_ACTION' => $this->helper->route('sitesplat_bbtags_search_controller'),
			'U_BBTAGS_CLEAR' => $this->filter_url->build(array()),
			'SEARCH_MATCHES' => $this->user->lang('FOUND_SEARCH_MATCHES', $topics_count),
		));

		$page_tag = htmlspecialchars($search_value, ENT_QUOTES, 'UTF-8');
		return $this->helper->render('show_topics.html', $this->user->lang('SEARCH') . ' - ' . $page_tag);
	}

	/**
	 * Resolve submitted names or legacy route keys to canonical catalogue rows.
	 *
	 * @param array $values        Tag names or routes
	 * @param bool  $values_routes Whether values contain route keys
	 *
	 * @return array
	 */
	protected function resolve_search_tags(array $values, $values_routes)
	{
		if (empty($values))
		{
			return array();
		}

		$lookup = array();
		foreach ($values as $value)
		{
			$key = $values_routes
				? trim((string) $value)
				: $this->manager->canonical_tag($value);
			if ($key !== '')
			{
				$lookup[$key] = true;
			}
		}
		if (empty($lookup))
		{
			return array();
		}

		$field = $values_routes ? 'route' : 'tag_clean';
		$sql = 'SELECT id, tag, route, tag_clean
			FROM ' . $this->table_bbtags . '
			WHERE ' . $this->db->sql_in_set($field, array_keys($lookup));
		$result = $this->db->sql_query($sql);
		$rows = array();
		while ($row = $this->db->sql_fetchrow($result))
		{
			$key = $values_routes ? $row['route'] : $row['tag_clean'];
			$rows[$key] = $row;
		}
		$this->db->sql_freeresult($result);

		$resolved = array();
		foreach (array_keys($lookup) as $key)
		{
			if (isset($rows[$key]))
			{
				$resolved[] = $rows[$key];
			}
		}

		return $resolved;
	}

	/**
	 * Assign the visible topic rows for the current tag.
	 *
	 * @param string $where_sql Visibility-aware SQL condition
	 * @param int    $start     Pagination offset
	 */
	protected function display_topics($where_sql, $start, array $active_routes, $operator)
	{
		$icons = $this->cache->obtain_icons();
		$sql = 'SELECT topics.*, forums.forum_name, topic_track.mark_time
			FROM ' . TOPICS_TABLE . ' topics
			LEFT JOIN ' . FORUMS_TABLE . ' forums ON forums.forum_id = topics.forum_id
			LEFT JOIN ' . TOPICS_TRACK_TABLE . ' topic_track
				ON topic_track.topic_id = topics.topic_id
				AND topic_track.user_id = ' . (int) $this->user->data['user_id'] . '
			WHERE ' . $where_sql . '
			ORDER BY topics.topic_last_post_time DESC';
		$result = $this->db->sql_query_limit($sql, $this->config['topics_per_page'], $start);
		$rows = array();
		$topic_forums = array();
		while ($row = $this->db->sql_fetchrow($result))
		{
			$rows[] = $row;
			$topic_forums[(int) $row['topic_id']] = (int) $row['forum_id'];
		}
		$this->db->sql_freeresult($result);
		$topic_tags = $this->manager->get_topic_tags($topic_forums);

		foreach ($rows as $row)
		{
			$topic_id = (int) $row['topic_id'];
			$forum_id = (int) $row['forum_id'];
			$replies = max(0, $this->content_visibility->get_count('topic_posts', $row, $forum_id) - 1);
			$mark_time = !empty($row['mark_time']) ? (int) $row['mark_time'] : (int) $this->user->data['user_lastmark'];
			$unread_topic = !empty($this->user->data['is_registered']) && (int) $row['topic_last_post_time'] > $mark_time;

			$folder_img = $folder_alt = $topic_type = '';
			topic_status($row, $replies, $unread_topic, $folder_img, $folder_alt, $topic_type);

			$topic_unapproved = in_array((int) $row['topic_visibility'], array(ITEM_UNAPPROVED, ITEM_REAPPROVE)) && $this->auth->acl_get('m_approve', $forum_id);
			$posts_unapproved = (int) $row['topic_visibility'] === ITEM_APPROVED && !empty($row['topic_posts_unapproved']) && $this->auth->acl_get('m_approve', $forum_id);
			$topic_deleted = (int) $row['topic_visibility'] === ITEM_DELETED;
			$moderation_url = ($topic_unapproved || $posts_unapproved)
				? append_sid($this->phpbb_root_path . 'mcp.' . $this->php_ext, 'i=queue&amp;mode=' . ($topic_unapproved ? 'approve_details' : 'unapproved_posts') . '&amp;t=' . $topic_id, true, $this->user->session_id)
				: '';
			if ($moderation_url === '' && $topic_deleted)
			{
				$moderation_url = append_sid($this->phpbb_root_path . 'mcp.' . $this->php_ext, 'i=queue&amp;mode=deleted_topics&amp;t=' . $topic_id, true, $this->user->session_id);
			}

			$view_topic_params = 'f=' . $forum_id . '&amp;t=' . $topic_id;
			$topic_row = array(
				'TOPIC_AUTHOR' => get_username_string('username', $row['topic_poster'], $row['topic_first_poster_name'], $row['topic_first_poster_colour']),
				'TOPIC_AUTHOR_COLOUR' => get_username_string('colour', $row['topic_poster'], $row['topic_first_poster_name'], $row['topic_first_poster_colour']),
				'TOPIC_AUTHOR_FULL' => get_username_string('full', $row['topic_poster'], $row['topic_first_poster_name'], $row['topic_first_poster_colour']),
				'FIRST_POST_TIME' => $this->user->format_date($row['topic_time']),
				'LAST_POST_SUBJECT' => censor_text($row['topic_last_post_subject']),
				'LAST_POST_TIME' => $this->user->format_date($row['topic_last_post_time']),
				'LAST_VIEW_TIME' => $this->user->format_date($row['topic_last_view_time']),
				'LAST_POST_AUTHOR' => get_username_string('username', $row['topic_last_poster_id'], $row['topic_last_poster_name'], $row['topic_last_poster_colour']),
				'LAST_POST_AUTHOR_COLOUR' => get_username_string('colour', $row['topic_last_poster_id'], $row['topic_last_poster_name'], $row['topic_last_poster_colour']),
				'LAST_POST_AUTHOR_FULL' => get_username_string('full', $row['topic_last_poster_id'], $row['topic_last_poster_name'], $row['topic_last_poster_colour']),
				'TOPIC_TYPE' => $topic_type,
				'TOPIC_IMG_STYLE' => $folder_img,
				'TOPIC_FOLDER_IMG' => $this->user->img($folder_img, $folder_alt),
				'TOPIC_FOLDER_IMG_ALT' => $this->user->lang($folder_alt),
				'TOPIC_ICON_IMG' => !empty($icons[$row['icon_id']]) ? $icons[$row['icon_id']]['img'] : '',
				'TOPIC_ICON_IMG_WIDTH' => !empty($icons[$row['icon_id']]) ? $icons[$row['icon_id']]['width'] : '',
				'TOPIC_ICON_IMG_HEIGHT' => !empty($icons[$row['icon_id']]) ? $icons[$row['icon_id']]['height'] : '',
				'TOPIC_ICON_IMG_ALT' => '',
				'ATTACH_ICON_IMG' => $this->auth->acl_get('u_download') && $this->auth->acl_get('f_download', $forum_id) && !empty($row['topic_attachment']) ? $this->user->img('icon_topic_attach', $this->user->lang('TOTAL_ATTACHMENTS')) : '',
				'UNAPPROVED_IMG' => ($topic_unapproved || $posts_unapproved) ? $this->user->img('icon_topic_unapproved', $topic_unapproved ? 'TOPIC_UNAPPROVED' : 'POSTS_UNAPPROVED') : '',
				'S_TOPIC_TYPE' => (int) $row['topic_type'],
				'S_USER_POSTED' => !empty($row['topic_posted']),
				'S_UNREAD_TOPIC' => $unread_topic,
				'S_TOPIC_REPORTED' => !empty($row['topic_reported']) && $this->auth->acl_get('m_report', $forum_id),
				'S_TOPIC_UNAPPROVED' => $topic_unapproved,
				'S_POSTS_UNAPPROVED' => $posts_unapproved,
				'S_TOPIC_DELETED' => $topic_deleted,
				'S_HAS_POLL' => !empty($row['poll_start']),
				'S_TOPIC_GLOBAL' => (int) $row['topic_type'] === POST_GLOBAL,
				'U_LAST_POST' => append_sid($this->phpbb_root_path . 'viewtopic.' . $this->php_ext, 'f=' . $forum_id . '&amp;p=' . (int) $row['topic_last_post_id']) . '#p' . (int) $row['topic_last_post_id'],
				'U_LAST_POST_AUTHOR' => get_username_string('profile', $row['topic_last_poster_id'], $row['topic_last_poster_name'], $row['topic_last_poster_colour']),
				'U_TOPIC_AUTHOR' => get_username_string('profile', $row['topic_poster'], $row['topic_first_poster_name'], $row['topic_first_poster_colour']),
				'U_NEWEST_POST' => append_sid($this->phpbb_root_path . 'viewtopic.' . $this->php_ext, $view_topic_params . '&amp;view=unread') . '#unread',
				'U_MCP_REPORT' => append_sid($this->phpbb_root_path . 'mcp.' . $this->php_ext, 'i=reports&amp;mode=reports&amp;t=' . $topic_id, true, $this->user->session_id),
				'U_MCP_QUEUE' => $moderation_url,
				'TOPIC_TITLE' => censor_text($row['topic_title']),
				'FORUM_ID' => $forum_id,
				'TOPIC_ID' => $topic_id,
				'POST_ID' => false,
				'FORUM_TITLE' => $forum_id > 0 ? $row['forum_name'] : $this->user->lang('GLOBAL'),
				'TOPIC_REPLIES' => $replies,
				'TOPIC_VIEWS' => (int) $row['topic_views'],
				'U_VIEW_TOPIC' => append_sid($this->phpbb_root_path . 'viewtopic.' . $this->php_ext, $view_topic_params),
				'U_VIEW_FORUM' => $forum_id > 0 ? append_sid($this->phpbb_root_path . 'viewforum.' . $this->php_ext, 'f=' . $forum_id) : '',
				'BBTAGS' => $this->build_tag_links(
					isset($topic_tags[$topic_id]) ? $topic_tags[$topic_id] : array(),
					$active_routes,
					$operator
				),
			);

			$vars = array('topic_row');
			extract($this->phpbb_dispatcher->trigger_event('sitesplat.bbtags.btpreview', compact($vars)));
			$this->template->assign_block_vars('topicrow', $topic_row);
		}
	}

	/**
	 * Build add/remove links for tags displayed inside one result row.
	 */
	protected function build_tag_links(array $tags, array $active_routes, $operator)
	{
		$links = array();
		foreach ($tags as $tag)
		{
			$is_active = in_array($tag['route'], $active_routes, true);
			$links[] = array(
				'TAG' => htmlspecialchars($tag['tag'], ENT_QUOTES, 'UTF-8'),
				'URL' => $this->filter_url->toggle($active_routes, $tag['route'], $operator),
				'S_ACTIVE' => $is_active,
				'TITLE' => $this->user->lang($is_active ? 'BBTAGS_REMOVE_FILTER' : 'BBTAGS_ADD_FILTER'),
			);
		}

		return $links;
	}

	/**
	 * Return forums that must not contribute topic or tag data.
	 *
	 * @return array Excluded forum identifiers
	 */
	protected function get_excluded_forum_ids()
	{
		$excluded = array_unique(array_merge(
			array_keys($this->auth->acl_getf('!f_read', true)),
			array_keys($this->auth->acl_getf('!f_search', true))
		));

		$sql = 'SELECT forums.forum_id, forums.forum_password, forum_access.user_id
			FROM ' . FORUMS_TABLE . ' forums
			LEFT JOIN ' . FORUMS_ACCESS_TABLE . " forum_access
				ON forum_access.forum_id = forums.forum_id
				AND forum_access.session_id = '" . $this->db->sql_escape($this->user->session_id) . "'";
		$result = $this->db->sql_query($sql);
		while ($row = $this->db->sql_fetchrow($result))
		{
			if ($row['forum_password'] !== '' && (int) $row['user_id'] !== (int) $this->user->data['user_id'])
			{
				$excluded[] = (int) $row['forum_id'];
			}
		}
		$this->db->sql_freeresult($result);

		$excluded = array_values(array_unique(array_map('intval', $excluded)));
		sort($excluded);
		return $excluded;
	}

	/**
	 * Strip BBCode and punctuation while retaining Unicode words.
	 *
	 * @param string $text Text to inspect
	 *
	 * @return string Plain words
	 */
	protected function strip_bbcode($text)
	{
		$text = preg_replace('#\[[^\]]*\]#u', ' ', $text);
		return trim(preg_replace('/[^\p{L}\p{N}_-]+/u', ' ', html_entity_decode($text, ENT_QUOTES, 'UTF-8')));
	}
}
