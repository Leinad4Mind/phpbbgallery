<?php

/**
 *
 * Limit Posts and Topics per Forum. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2019-2020, Leinad4Mind, https://leinad4mind.top/forum
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace leinad4mind\limitperforum\event;

use leinad4mind\limitperforum\manager\forum_groups_manager;
use phpbb\auth\auth;
use phpbb\db\driver\driver_interface;
use phpbb\event\data;
use phpbb\language\language;
use phpbb\path_helper;
use phpbb\user;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class main_listener implements EventSubscriberInterface
{
	/** @var user */
	protected $user;

	/** @var auth */
	protected $auth;

	/** @var language */
	protected $language;

	/** @var driver_interface */
	protected $db;

	/** @var path_helper */
	protected $path_helper;

	/** @var forum_groups_manager */
	protected $manager;

	/** @var string */
	protected $post_topic_rest = '';

	/**
	 * @param user					$user
	 * @param auth					$auth
	 * @param language				$language
	 * @param driver_interface		$db
	 * @param path_helper			$path_helper
	 * @param forum_groups_manager	$manager
	 */
	public function __construct(
		user $user,
		auth $auth,
		language $language,
		driver_interface $db,
		path_helper $path_helper,
		forum_groups_manager $manager
	)
	{
		$this->user			= $user;
		$this->auth			= $auth;
		$this->language		= $language;
		$this->db			= $db;
		$this->path_helper	= $path_helper;
		$this->manager		= $manager;
	}

	/**
	 * @return array
	 */
	public static function getSubscribedEvents()
	{
		return [
			'core.modify_posting_auth'			=> 'modify_posting_auth',
			'core.posting_modify_template_vars'	=> 'posting_modify_template_vars',
		];
	}

	/**
	 * @param data $event
	 */
	public function modify_posting_auth(data $event)
	{
		if (in_array($event['mode'], ['post', 'reply', 'quote']))
		{
			$topic_limit = 0;
			$topic_time_limit = 0;
			$post_limit = 0;
			$post_time_limit = 0;

			$topic_forum_ids = [$event['forum_id']];
			$post_forum_ids = [$event['forum_id']];
			$forum_data = $event['post_data'];

			if (!function_exists('phpbb_get_forum_data'))
			{
				include($this->path_helper->get_phpbb_root_path() . 'includes/functions_mcp.' . $this->path_helper->get_php_ext());
			}

			$forum_parents = get_forum_parents($forum_data);

			if ($forum_parents)
			{
				end($forum_parents);
				$immediate_parent_forum_id = key($forum_parents);
				$immediate_parent_data = phpbb_get_forum_data($immediate_parent_forum_id);

				if ($immediate_parent_data[$immediate_parent_forum_id]['forum_type'] == FORUM_CAT)
				{
					$group_limits = $this->manager->get_limits($immediate_parent_forum_id, $this->user->data['user_id']);

					if ($group_limits)
					{
						list($topic_limit, $topic_time_limit) = $this->extract_limits($group_limits, 'topics', 'topic_time_limit');
						list($post_limit, $post_time_limit) = $this->extract_limits($group_limits, 'posts', 'post_time_limit');
					}
					else
					{
						if ($immediate_parent_data[$immediate_parent_forum_id]['forum_topic_limit'] > $topic_limit)
						{
							$topic_forum_ids = $this->get_immediate_subforum_ids($immediate_parent_forum_id);
							$topic_limit = $immediate_parent_data[$immediate_parent_forum_id]['forum_topic_limit'];
							$topic_time_limit = $immediate_parent_data[$immediate_parent_forum_id]['forum_topic_time_limit'];
						}

						if ($immediate_parent_data[$immediate_parent_forum_id]['forum_post_limit'] > $post_limit)
						{
							$post_forum_ids = $this->get_immediate_subforum_ids($immediate_parent_forum_id);
							$post_limit = $immediate_parent_data[$immediate_parent_forum_id]['forum_post_limit'];
							$post_time_limit = $immediate_parent_data[$immediate_parent_forum_id]['forum_post_time_limit'];
						}
					}
				}
			}

			if (!$topic_limit && !$post_limit)
			{
				$topic_limit = $event['post_data']['forum_topic_limit'];
				$topic_time_limit = $event['post_data']['forum_topic_time_limit'];
				$post_limit = $event['post_data']['forum_post_limit'];
				$post_time_limit = $event['post_data']['forum_post_time_limit'];

				$group_limits = $this->manager->get_limits($event['forum_id'], $this->user->data['user_id']);

				if ($group_limits)
				{
					list($topic_limit, $topic_time_limit) = $this->extract_limits($group_limits, 'topics', 'topic_time_limit');
					list($post_limit, $post_time_limit) = $this->extract_limits($group_limits, 'posts', 'post_time_limit');
				}
			}

			$is_topic_authed = $event['mode'] != 'post' || $this->auth->acl_get('f_topic_limit', $event['forum_id']) || !$topic_limit;
			$is_post_authed = $this->auth->acl_get('f_post_limit', $event['forum_id']) || !$post_limit;

			if ($is_post_authed && $is_topic_authed)
			{
				return;
			}

			$this->language->add_lang('common', 'leinad4mind/limitperforum');

			// Topic count

			$sql_ary = [
				'SELECT'	=> 'COUNT(t.topic_id) AS topics_count',
				'FROM'		=> [TOPICS_TABLE => 't'],
				'WHERE'		=> 't.topic_poster = ' . (int) $this->user->data['user_id'] . ' AND ' . $this->db->sql_in_set('t.forum_id', $topic_forum_ids),
			];

			if ($topic_time_limit)
			{
				$sql_ary['WHERE'] .= ' AND t.topic_time > ' . (time() - ($topic_time_limit * 60 * 60));
			}

			$topics_count = $this->query_field('topics_count', $sql_ary);

			if (!$is_topic_authed && $topic_limit && $topics_count >= $topic_limit)
			{
				$event['error'] = array_merge($event['error'], [
					$this->language->lang($topic_time_limit ? 'ERROR_TOPIC_COUNT_TIME' : 'ERROR_TOPIC_COUNT', (int) $topic_limit, $topic_time_limit),
				]);
			}

			// Post count

			$sql_ary = [
				'SELECT'	=> 'COUNT(p.post_id) AS posts_count',
				'FROM'		=> [POSTS_TABLE => 'p'],
				'WHERE'		=> 'p.poster_id = ' . (int) $this->user->data['user_id'] . ' AND ' . $this->db->sql_in_set('p.forum_id', $post_forum_ids),
			];

			if ($post_time_limit)
			{
				$sql_ary['WHERE'] .= ' AND p.post_time > ' . (time() - ($post_time_limit * 60 * 60));
			}

			$posts_count = $is_post_authed ? 0 : ($this->query_field('posts_count', $sql_ary) - $topics_count);

			if ($post_limit && $posts_count >= $post_limit)
			{
				$event['error'] = array_merge($event['error'], [
					$this->language->lang($post_time_limit ? 'ERROR_POST_COUNT_TIME' : 'ERROR_POST_COUNT', (int) $post_limit, $post_time_limit),
				]);
			}

			if (!$is_post_authed && !$is_topic_authed && $event['mode'] == 'post')
			{
				$post_rest = $post_limit - $posts_count;
				$topic_rest = $topic_limit - $topics_count;
				$lang_key = 'ERROR_POST' . ($post_rest > 1 ? 'S' : '') . '_TOPIC' . ($topic_rest > 1 ? 'S' : '') . '_REST';
				$this->post_topic_rest = $this->language->lang($lang_key, (int) $topic_rest, $post_rest);
			}
			else if ($is_post_authed && !$is_topic_authed && $event['mode'] == 'post')
			{
				$topic_rest = $topic_limit - $topics_count;
				$this->post_topic_rest = $this->language->lang('ERROR_TOPIC_REST', (int) $topic_rest);
			}
			else if (!$is_post_authed && $is_topic_authed)
			{
				$post_rest = $post_limit - $posts_count;
				$this->post_topic_rest = $this->language->lang('ERROR_POST_REST', (int) $post_rest);
			}
		}
	}

	/**
	 * @param data $event
	 */
	public function posting_modify_template_vars(data $event)
	{
		if ($this->post_topic_rest)
		{
			$error = $event['error'];
			$error[] = $this->post_topic_rest;
			$event['error'] = $error;

			$event->update_subarray('page_data', 'ERROR', implode('<br>', $error));
		}
	}

	/**
	 * @param array $group_limits
	 * @param string $limit_key
	 * @param string $time_limit_key
	 * @return array
	 */
	protected function extract_limits($group_limits, $limit_key, $time_limit_key)
	{
		$counts = array_column($group_limits, $limit_key);
		$max_key = array_keys($counts, max($counts))[0];
		$limit = $counts[$max_key];
		$time_limit = $group_limits[$max_key][$time_limit_key];
		return [$limit, $time_limit];
	}

	/**
	 * @param int $forum_id
	 * @return array
	 */
	protected function get_immediate_subforum_ids($forum_id)
	{
		$subforum_ids = [];

		if (!function_exists('get_forum_branch'))
		{
			include($this->path_helper->get_phpbb_root_path() . 'includes/functions_admin.' . $this->path_helper->get_php_ext());
		}

		foreach (get_forum_branch((int) $forum_id, 'children') as $subforum)
		{
			if ($subforum['parent_id'] == $forum_id)
			{
				$subforum_ids[] = $subforum['forum_id'];
			}
		}

		return $subforum_ids;
	}

	/**
	 * @param array $sql_array
	 * @param string $field
	 * @return string
	 */
	public function query_field($field, array $sql_array)
	{
		$sql = $this->db->sql_build_query('SELECT', $sql_array);
		$result = $this->db->sql_query($sql);
		$value = $this->db->sql_fetchfield($field, false, $result);
		$this->db->sql_freeresult($result);
		return $value;
	}
}
