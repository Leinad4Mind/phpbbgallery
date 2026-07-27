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
use phpbb\config\db_text;
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

class main
{
	protected $db;
	protected $config;
	protected $config_text;
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
	protected $table_bbtags;
	protected $table_bbtags_topic;

	/**
	 * Constructor.
	 */
	public function __construct(driver_interface $db, config $config, db_text $config_text, template $template, helper $helper, request $request, user $user, auth $auth, service $cache, pagination $pagination, dispatcher $phpbb_dispatcher, content_visibility $content_visibility, $php_ext, $phpbb_root_path, manager $manager, $table_bbtags, $table_bbtags_topic)
	{
		$this->db = $db;
		$this->config = $config;
		$this->config_text = $config_text;
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

		$predefined_tags = json_decode($this->config_text->get('bbtags_pre_tags'), true);
		$predefined_tags = is_array($predefined_tags) ? $predefined_tags : array();
		$term = utf8_strtolower(trim($this->request->variable('term', '', true)));
		$matches = array();
		foreach ($predefined_tags as $tag)
		{
			$tag = (string) $tag;
			if ($term === '' || utf8_substr(utf8_strtolower($tag), 0, utf8_strlen($term)) === $term)
			{
				$matches[] = $tag;
			}
		}

		$response = new json_response();
		$response->send(array_slice(array_values($matches), 0, 20));
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
		if (!$this->auth->acl_get('u_bbtags_read'))
		{
			return $this->helper->error('NOT_AUTHORISED', 403);
		}

		$this->user->add_lang('search');
		include_once $this->phpbb_root_path . 'includes/functions_display.' . $this->php_ext;

		$route = $this->manager->slug(utf8_normalize_nfc($tags), array('transliterate' => true));
		$tag_id = 0;
		$tag_name = '';
		$sql = 'SELECT id, tag
			FROM ' . $this->table_bbtags . '
			WHERE ' . $this->db->sql_build_array('SELECT', array('route' => $route));
		$result = $this->db->sql_query_limit($sql, 1);
		if ($row = $this->db->sql_fetchrow($result))
		{
			$tag_id = (int) $row['id'];
			$tag_name = $row['tag'];
		}
		$this->db->sql_freeresult($result);

		$excluded_forums = $this->get_excluded_forum_ids();
		$visibility_sql = $this->content_visibility->get_global_visibility_sql('topic', $excluded_forums, 'topics.');
		$where_sql = '1 = 0';
		if ($tag_id > 0)
		{
			$where_sql = 'tt.tag_id = ' . $tag_id . '
				AND topics.topic_moved_id = 0
				AND ' . $visibility_sql;
		}

		$sql = 'SELECT COUNT(DISTINCT topics.topic_id) AS total
			FROM ' . $this->table_bbtags_topic . ' tt
			JOIN ' . TOPICS_TABLE . ' topics ON topics.topic_id = tt.topic_id
			WHERE ' . $where_sql;
		$result = $this->db->sql_query($sql);
		$topics_count = (int) $this->db->sql_fetchfield('total');
		$this->db->sql_freeresult($result);

		$start = max($this->request->variable('start', 0), 0);
		$start = $this->pagination->validate_start($start, $this->config['topics_per_page'], $topics_count);
		$search_url = $this->helper->route('sitesplat_bbtags_controller', array('tags' => $route));
		$this->pagination->generate_template_pagination($search_url, 'pagination', 'start', $topics_count, $this->config['topics_per_page'], $start);

		if ($topics_count > 0)
		{
			$this->display_topics($where_sql, $start);
		}

		$this->template->assign_vars(array(
			'S_BBTAGS_RESULTS' => true,
			'BBTAGS_TAG_NAME' => htmlspecialchars($tag_name, ENT_QUOTES, 'UTF-8'),
			'S_SEARCH_ACTION' => $search_url,
			'SEARCH_MATCHES' => $this->user->lang('FOUND_SEARCH_MATCHES', $topics_count),
		));

		$page_tag = htmlspecialchars(($tag_name !== '') ? $tag_name : $route, ENT_QUOTES, 'UTF-8');
		return $this->helper->render('show_topics.html', $this->user->lang('SEARCH') . ' - ' . $page_tag);
	}

	/**
	 * Assign the visible topic rows for the current tag.
	 *
	 * @param string $where_sql Visibility-aware SQL condition
	 * @param int    $start     Pagination offset
	 */
	protected function display_topics($where_sql, $start)
	{
		$icons = $this->cache->obtain_icons();
		$sql = 'SELECT DISTINCT topics.*, forums.forum_name, topic_track.mark_time
			FROM ' . $this->table_bbtags_topic . ' tt
			JOIN ' . TOPICS_TABLE . ' topics ON topics.topic_id = tt.topic_id
			LEFT JOIN ' . FORUMS_TABLE . ' forums ON forums.forum_id = topics.forum_id
			LEFT JOIN ' . TOPICS_TRACK_TABLE . ' topic_track
				ON topic_track.topic_id = topics.topic_id
				AND topic_track.user_id = ' . (int) $this->user->data['user_id'] . '
			WHERE ' . $where_sql . '
			ORDER BY topics.topic_last_post_time DESC';
		$result = $this->db->sql_query_limit($sql, $this->config['topics_per_page'], $start);
		while ($row = $this->db->sql_fetchrow($result))
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
			);

			$vars = array('topic_row');
			extract($this->phpbb_dispatcher->trigger_event('sitesplat.bbtags.btpreview', compact($vars)));
			$this->template->assign_block_vars('topicrow', $topic_row);
		}
		$this->db->sql_freeresult($result);
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
