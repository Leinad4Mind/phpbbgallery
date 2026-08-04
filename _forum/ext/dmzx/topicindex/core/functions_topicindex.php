<?php
/**
 *
 * @package phpBB Extension - Topic Index
 * @copyright (c) 2015 dmzx - https://www.dmzx-web.net
 * @copyright (c) 2026 Leinad4Mind
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 */

namespace dmzx\topicindex\core;

use phpbb\auth\auth;
use phpbb\config\config;
use phpbb\content_visibility;
use phpbb\db\driver\driver_interface as db_interface;
use phpbb\event\dispatcher_interface;
use phpbb\extension\manager;
use phpbb\language\language;
use phpbb\log\log_interface;
use phpbb\template\template;
use phpbb\user;

class functions_topicindex
{
	/** @var db_interface */
	protected $db;
	/** @var template */
	protected $template;
	/** @var config */
	protected $config;
	/** @var auth */
	protected $auth;
	/** @var dispatcher_interface */
	protected $dispatcher;
	/** @var manager */
	protected $extension_manager;
	/** @var content_visibility */
	protected $content_visibility;
	/** @var language */
	protected $language;
	/** @var log_interface */
	protected $log;
	/** @var user */
	protected $user;
	/** @var title_helper */
	protected $title_helper;
	/** @var array|null */
	protected $readable_forum_ids;
	/** @var array */
	protected $manage_permissions = [];

	public function __construct(
		db_interface $db,
		template $template,
		config $config,
		auth $auth,
		dispatcher_interface $dispatcher,
		manager $extension_manager,
		content_visibility $content_visibility,
		language $language,
		log_interface $log,
		user $user,
		title_helper $title_helper
	)
	{
		$this->db = $db;
		$this->template = $template;
		$this->config = $config;
		$this->auth = $auth;
		$this->dispatcher = $dispatcher;
		$this->extension_manager = $extension_manager;
		$this->content_visibility = $content_visibility;
		$this->language = $language;
		$this->log = $log;
		$this->user = $user;
		$this->title_helper = $title_helper;
	}

	/**
	 * Compatibility wrapper for the original single-forum API.
	 */
	public function get_topic_index($the_forum, $the_topic, $inlistvalue = 0, $tagfilter = 0)
	{
		return $this->get_topic_indexes([
			(int) $the_forum => [
				'inindex' => (int) $inlistvalue,
				'filter' => (int) $tagfilter,
			],
		], (int) $the_topic);
	}

	/**
	 * Fetch visible topics for all requested forums with one query.
	 *
	 * @param array $forum_settings Settings keyed by forum ID
	 * @param int $excluded_topic Topic to exclude
	 * @param int $poster_id Optional topic starter filter
	 * @return array
	 */
	public function get_topic_indexes(array $forum_settings, $excluded_topic = 0, $poster_id = 0)
	{
		$forum_settings = $this->normalise_forum_settings($forum_settings);
		$forum_ids = $this->get_readable_forum_ids(array_keys($forum_settings));
		if (empty($forum_ids))
		{
			return [];
		}

		$conditions = [];
		foreach ($forum_ids as $forum_id)
		{
			$conditions[] = '(t.forum_id = ' . $forum_id . '
				AND t.inindex_topic >= ' . $forum_settings[$forum_id]['inindex'] . '
				AND t.outindex_topic = 0)';
		}

		$select = 't.topic_id, t.topic_title, t.topic_poster, t.topic_first_poster_name,
			t.topic_first_poster_colour, t.forum_id, t.topic_posts_approved,
			t.topic_first_post_id, t.icon_id, t.inindex_topic, t.outindex_topic,
			t.topic_type';

		$where = '(' . implode(' OR ', $conditions) . ')
			AND t.topic_posts_approved >= 1
			AND t.topic_status <> ' . ITEM_MOVED . '
			AND ' . $this->content_visibility->get_forums_visibility_sql('topic', $forum_ids, 't.');
		if ($excluded_topic)
		{
			$where .= ' AND t.topic_id <> ' . (int) $excluded_topic;
		}
		if ($poster_id)
		{
			$where .= ' AND t.topic_poster = ' . (int) $poster_id;
		}

		$sql_array = [
			'SELECT' => $select,
			'FROM' => [TOPICS_TABLE => 't'],
			'LEFT_JOIN' => [],
			'WHERE' => $where,
			'ORDER_BY' => 't.topic_title ASC',
		];

		/**
		 * @event dmzx.topicindex.sql_fetch_topics_before
		 * @var array sql_array SQL query data
		 * @since 1.0.5
		 */
		$vars = ['sql_array'];
		extract($this->dispatcher->trigger_event('dmzx.topicindex.sql_fetch_topics_before', compact($vars)));

		$sql = $this->db->sql_build_query('SELECT', $sql_array);
		$limit = max(1, min(5000, (int) $this->config['topicindex_max_topics']));
		$result = $this->db->sql_query_limit($sql, $limit);
		$topiclist = [];
		while ($row = $this->db->sql_fetchrow($result))
		{
			$forum_id = (int) $row['forum_id'];
			if (!isset($forum_settings[$forum_id]))
			{
				continue;
			}

			$keys = $this->title_helper->get_keys($row['topic_title'], (bool) $forum_settings[$forum_id]['filter']);
			$array = [
				'id' => (int) $row['topic_id'],
				'forum_id' => $forum_id,
				'key' => $keys['group'],
				'keybig' => $keys['sort'],
				'title' => censor_text($row['topic_title']),
				'posts' => max(0, (int) $row['topic_posts_approved'] - 1),
				'posterid' => (int) $row['topic_poster'],
				'poster' => $row['topic_first_poster_name'],
				'postercol' => $row['topic_first_poster_colour'],
				'topic_first_post_id' => (int) $row['topic_first_post_id'],
				'icon_id' => (int) $row['icon_id'],
				'forum_name' => isset($row['forum_name']) ? $row['forum_name'] : '',
				'forum_image' => isset($row['forum_image']) ? $row['forum_image'] : '',
				'can_manage' => $this->can_manage($forum_id),
			];
			foreach (['topic_attr_id', 'topic_attr_user', 'topic_attr_time'] as $attribute_field)
			{
				if (isset($row[$attribute_field]))
				{
					$array[$attribute_field] = $row[$attribute_field];
				}
			}

			/**
			 * @event dmzx.topicindex.sql_fetch_topics_after
			 * @var array topiclist Topics already returned
			 * @var array array Current topic data
			 * @var array row Current SQL row
			 * @since 1.0.5
			 */
			$vars = ['topiclist', 'array', 'row'];
			extract($this->dispatcher->trigger_event('dmzx.topicindex.sql_fetch_topics_after', compact($vars)));
			$topiclist[] = $array;
		}
		$this->db->sql_freeresult($result);

		usort($topiclist, function ($left, $right)
		{
			$comparison = strnatcasecmp($left['keybig'], $right['keybig']);

			return $comparison ?: ((int) $left['id'] <=> (int) $right['id']);
		});

		/**
		 * Enrich the complete rowset in one operation.
		 *
		 * @event dmzx.topicindex.enrich_topiclist
		 * @var array topiclist Complete normalised topic list
		 * @var array forum_settings Settings keyed by forum ID
		 * @since 2.0.0
		 */
		$vars = ['topiclist', 'forum_settings'];
		extract($this->dispatcher->trigger_event('dmzx.topicindex.enrich_topiclist', compact($vars)));

		return $topiclist;
	}

	public function get_readable_forum_ids(array $requested_forums)
	{
		$requested_forums = array_values(array_unique(array_filter(array_map('intval', $requested_forums))));
		if ($this->readable_forum_ids === null)
		{
			$readable = array_keys($this->auth->acl_getf('f_read', true));
			$listable = array_keys($this->auth->acl_getf('f_list', true));
			$this->readable_forum_ids = array_values(array_intersect($readable, $listable));
		}

		return array_values(array_intersect($requested_forums, $this->readable_forum_ids));
	}

	public function get_forum_settings(array $forum_ids)
	{
		$forum_ids = $this->get_readable_forum_ids($forum_ids);
		if (empty($forum_ids))
		{
			return [];
		}

		$sql = 'SELECT forum_id, post_index, default_inindex, tag_filter, topicindex_display_mode
			FROM ' . FORUMS_TABLE . '
			WHERE ' . $this->db->sql_in_set('forum_id', $forum_ids);
		$result = $this->db->sql_query($sql);
		$settings = [];
		while ($row = $this->db->sql_fetchrow($result))
		{
			$settings[(int) $row['forum_id']] = [
				'post_index' => (int) $row['post_index'],
				'inindex' => (int) $row['default_inindex'],
				'filter' => (int) $row['tag_filter'],
				'display_mode' => $this->normalise_display_mode($row['topicindex_display_mode']),
			];
		}
		$this->db->sql_freeresult($result);

		return $settings;
	}

	public function get_forum_base_data($forum_id)
	{
		$settings = $this->get_forum_settings([(int) $forum_id]);

		return isset($settings[(int) $forum_id]) ? $settings[(int) $forum_id] : [
			'post_index' => 0,
			'inindex' => 0,
			'filter' => 0,
			'display_mode' => 'after',
		];
	}

	public function create_key_list(array $topicarray)
	{
		$keys = [];
		foreach ($topicarray as $indexdata)
		{
			$keys[$indexdata['key']] = true;
		}

		return array_keys($keys);
	}

	public function filter_topiclist(array $topicarray, $limiter = '')
	{
		if ($limiter === '')
		{
			return $topicarray;
		}

		return array_values(array_filter($topicarray, function ($topic) use ($limiter)
		{
			return $topic['key'] === $limiter;
		}));
	}

	public function can_manage($forum_id)
	{
		$forum_id = (int) $forum_id;
		if (!array_key_exists($forum_id, $this->manage_permissions))
		{
			$this->manage_permissions[$forum_id] = $this->auth->acl_get('a_board') || $this->auth->acl_get('m_edit', $forum_id);
		}

		return $this->manage_permissions[$forum_id];
	}

	public function set_topic_in_list($forum_id, $topic_id, $included)
	{
		$forum_id = (int) $forum_id;
		$topic_id = (int) $topic_id;
		if (!$topic_id || !$forum_id || !$this->can_manage($forum_id))
		{
			return false;
		}

		$sql_ary = $included ? [
			'inindex_topic' => 1,
			'outindex_topic' => 0,
		] : [
			'inindex_topic' => 0,
			'outindex_topic' => 1,
		];
		$sql = 'UPDATE ' . TOPICS_TABLE . '
			SET ' . $this->db->sql_build_array('UPDATE', $sql_ary) . '
			WHERE topic_id = ' . $topic_id . '
				AND forum_id = ' . $forum_id;
		$this->db->sql_query($sql);
		if (!$this->db->sql_affectedrows())
		{
			return false;
		}

		$this->log->add(
			'mod',
			$this->user->data['user_id'],
			$this->user->ip,
			$included ? 'LOG_TOPICINDEX_ADD_TOPIC' : 'LOG_TOPICINDEX_REMOVE_TOPIC',
			false,
			[$topic_id]
		);

		return true;
	}

	public function remove_from_ilist($the_forum, $whoremove = 0)
	{
		return $this->set_topic_in_list($the_forum, $whoremove, false);
	}

	public function add_to_ilist($the_forum, $whoadd = 0)
	{
		return $this->set_topic_in_list($the_forum, $whoadd, true);
	}

	public function checkif_inlist($listtype, $inindex, $outindex)
	{
		if ((int) $listtype === 1)
		{
			return (int) $inindex === 1 && (int) $outindex === 0;
		}

		return (int) $outindex === 0;
	}

	public function enrich_template_vars(array $indexdata, array $template_vars)
	{
		/**
		 * @event dmzx.topicindex.modify_block_topic_index_ary
		 * @var array indexdata Normalised topic data
		 * @var array template_vars Template block data
		 * @since 1.0.5
		 */
		$vars = ['indexdata', 'template_vars'];
		extract($this->dispatcher->trigger_event('dmzx.topicindex.modify_block_topic_index_ary', compact($vars)));

		return $template_vars;
	}

	public function assign_authors()
	{
		$metadata_manager = $this->extension_manager->create_extension_metadata_manager('dmzx/topicindex', $this->template);
		$metadata = $metadata_manager->get_metadata();
		foreach ($metadata['authors'] as $author)
		{
			$this->template->assign_block_vars('topicindex_authors', [
				'NAME' => $author['name'],
				'HOMEPAGE' => isset($author['homepage']) ? $author['homepage'] : '',
				'ROLE' => isset($author['role']) ? $author['role'] : '',
			]);
		}

		$this->template->assign_vars([
			'TOPICINDEX_DISPLAY_NAME' => $metadata['extra']['display-name'],
			'TOPICINDEX_VERSION' => $metadata['version'],
		]);
	}

	public function normalise_display_mode($mode)
	{
		return in_array($mode, ['before', 'after', 'replace'], true) ? $mode : 'after';
	}

	protected function normalise_forum_settings(array $forum_settings)
	{
		$normalised = [];
		foreach ($forum_settings as $forum_id => $settings)
		{
			$forum_id = (int) $forum_id;
			if (!$forum_id)
			{
				continue;
			}

			$normalised[$forum_id] = [
				'inindex' => !empty($settings['inindex']) ? 1 : 0,
				'filter' => !empty($settings['filter']) ? 1 : 0,
			];
		}

		return $normalised;
	}
}
