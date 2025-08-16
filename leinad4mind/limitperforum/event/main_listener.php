<?php

/**
 *
 * Limit Posts and Topics per Forum. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2019, Leinad4Mind, https://leinad4mind.top/forum
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace leinad4mind\limitperforum\event;

use phpbb\auth\auth;
use phpbb\db\driver\driver_interface;
use phpbb\event\data;
use phpbb\language\language;
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

	/** @var string */
	protected $post_topic_rest = '';

	/**
	 * @param user				$user
	 * @param auth				$auth
	 * @param language			$language
	 * @param driver_interface	$db
	 */
	public function __construct(
		user $user,
		auth $auth,
		language $language,
		driver_interface $db
	)
	{
		$this->user		= $user;
		$this->auth		= $auth;
		$this->language	= $language;
		$this->db		= $db;
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
			$is_topic_authed = $event['mode'] != 'post' || $this->auth->acl_get('f_topic_limit', $event['forum_id']) || !$event['post_data']['forum_topic_limit'];
			$is_post_authed = $this->auth->acl_get('f_post_limit', $event['forum_id']) || !$event['post_data']['forum_post_limit'];

			if ($is_post_authed && $is_topic_authed)
			{
				return;
			}

			$this->language->add_lang('common', 'leinad4mind/limitperforum');

			$posts_count = $is_post_authed ? 0 : $this->query_field('posts_count', [
				'SELECT'	=> 'COUNT(p.post_id) AS posts_count',
				'FROM'		=> [POSTS_TABLE => 'p'],
				'WHERE'		=> 'p.poster_id = ' . (int) $this->user->data['user_id'] . ' AND p.forum_id = ' . (int) $event['forum_id'],
			]);

			$topics_count = $is_topic_authed ? 0 : $this->query_field('topics_count', [
				'SELECT'	=> 'COUNT(t.topic_id) AS topics_count',
				'FROM'		=> [TOPICS_TABLE => 't'],
				'WHERE'		=> 't.topic_poster = ' . (int) $this->user->data['user_id'] . ' AND t.forum_id = ' . (int) $event['forum_id'],
			]);

			if ($event['post_data']['forum_topic_limit'] && $topics_count >= $event['post_data']['forum_topic_limit'])
			{
				$event['error'] = array_merge($event['error'], [
					$this->language->lang('ERROR_TOPIC_COUNT', $event['post_data']['forum_topic_limit'], $topics_count),
				]);
			}

			if ($event['post_data']['forum_post_limit'] && $posts_count >= $event['post_data']['forum_post_limit'])
			{
				$event['error'] = array_merge($event['error'], [
					$this->language->lang('ERROR_POST_COUNT', $event['post_data']['forum_post_limit'], $posts_count),
				]);
			}

			if (!$is_post_authed && !$is_topic_authed && $event['mode'] == 'post')
			{
				$post_rest = $event['post_data']['forum_post_limit'] - $posts_count;
				$topic_rest = $event['post_data']['forum_topic_limit'] - $topics_count;
				$lang_key = 'ERROR_POST' . ($post_rest > 1 ? 'S' : '') . '_TOPIC' . ($topic_rest > 1 ? 'S' : '') . '_REST';
				$this->post_topic_rest = $this->language->lang($lang_key, $topic_rest, $post_rest);
			}
			else if ($is_post_authed && !$is_topic_authed && $event['mode'] == 'post')
			{
				$topic_rest = $event['post_data']['forum_topic_limit'] - $topics_count;
				$this->post_topic_rest = $this->language->lang('ERROR_TOPIC_REST', $topic_rest);
			}
			else if (!$is_post_authed && $is_topic_authed)
			{
				$post_rest = $event['post_data']['forum_post_limit'] - $posts_count;
				$this->post_topic_rest = $this->language->lang('ERROR_POST_REST', $post_rest);
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
