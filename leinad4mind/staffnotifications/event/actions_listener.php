<?php

/**
 *
 * Staff Notifications. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2019-2020, Leinad4Mind
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace leinad4mind\staffnotifications\event;

use phpbb\event\data;
use phpbb\request\request_interface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use leinad4mind\staffnotifications\helper;

class actions_listener implements EventSubscriberInterface {

	/** @var request_interface */
	protected $request;

	/** @var helper */
	protected $helper;

	/** @var bool */
	protected $is_merging = false;

	/**
	 * @param helper $helper
	 */
	public function __construct(
		request_interface $request,
		helper $helper
	)
	{
		$this->request	= $request;
		$this->helper	= $helper;
	}

	/**
	 * @return array
	 */
	public static function getSubscribedEvents()
	{
		$priority = -1000;

		return [
			'core.user_setup'					=> 'load_language_on_setup',
			'core.mcp_main_before'				=> ['mcp_main_before', $priority],
			'core.delete_post_after'			=> ['soft_delete_post', $priority],
			'core.add_log'						=> ['soft_delete_topic', $priority],
			'core.delete_posts_before'			=> ['delete_posts', $priority],
			'core.delete_topics_before_query'	=> ['delete_topics', $priority],
			'core.acp_ban_after' 				=> ['ban_user', $priority],
			'core.mcp_ban_after' 				=> ['ban_user', $priority],
			'core.mcp_forum_merge_topics_after'	=> ['merge_topics', $priority],
			'core.mcp_topics_merge_posts_after'	=> ['merge_posts', $priority],
		];
	}

	/**
	 * @param data $event
	 */
	public function load_language_on_setup(data $event)
	{
		$lang_set_ext = $event['lang_set_ext'];
		$lang_set_ext[] = [
			'ext_name' => 'leinad4mind/staffnotifications',
			'lang_set' => 'common',
		];
		$event['lang_set_ext'] = $lang_set_ext;
	}

	/**
	 * @param data $event
	 */
	public function mcp_main_before(data $event)
	{
		$this->is_merging = in_array($event['action'], [
			'merge_select',
			'merge_topic',
			'merge_topics',
			'merge_posts',
		]);
	}

	/**
	 * @param data $event
	 */
	public function soft_delete_post(data $event)
	{
		if ($event['is_soft'])
		{
			$this->helper->add_notifications('leinad4mind.staffnotifications.notification.type.soft_delete_post', [
				'user_id'	=> $event['data']['poster_id'],
				'post_id'	=> $event['post_id'],
				'topic_id'	=> $event['topic_id'],
				'forum_id'	=> $event['forum_id'],
				'reference'	=> [
					'subject'	=> $this->helper->get_post_subject($event['post_id']),
					'reason'	=> $event['softdelete_reason'],
				],
			]);
		}
	}

	/**
	 * @param data $event
	 */
	public function soft_delete_topic(data $event)
	{
		if ($event['log_operation'] == 'LOG_SOFTDELETE_TOPIC')
		{
			$this->helper->add_notifications('leinad4mind.staffnotifications.notification.type.soft_delete_topic', [
				'sender_id'	=> $event['user_id'],
				'user_id'	=> $this->helper->get_topic_poster($event['sql_ary']['topic_id']),
				'topic_id'	=> $event['sql_ary']['topic_id'],
				'forum_id'	=> $event['sql_ary']['forum_id'],
				'reference'	=> [
					'title'		=> $event['additional_data'][0],
					'reason'	=> $event['additional_data'][2],
				],
			]);
		}
	}

	/**
	 * @param data $event
	 */
	public function delete_posts(data $event)
	{
		$post_ids = array_map('intval', is_array($event['where_ids']) ? $event['where_ids'] : [$event['where_ids']]);

		if ($post_ids && !$this->is_merging)
		{
			$post_data = $this->helper->get_post_data($post_ids);

			foreach ($post_data as $post_id => $post)
			{
				$this->helper->add_notifications('leinad4mind.staffnotifications.notification.type.delete_post', [
					'user_id'	=> $post['poster_id'],
					'post_id'	=> $post['post_id'],
					'topic_id'	=> $post['topic_id'],
					'forum_id'	=> $post['forum_id'],
					'reference'	=> [
						'subject'  	=> $post['post_subject'],
						'reason'	=> $this->request->variable('delete_reason', '', true),
					],
				]);
			}
		}
	}

	/**
	 * @param data $event
	 */
	public function delete_topics(data $event)
	{
		$topic_ids = array_map('intval', is_array($event['topic_ids']) ? $event['topic_ids'] : [$event['topic_ids']]);

		if ($topic_ids && !$this->is_merging)
		{
			$topic_data = $this->helper->get_topic_data($topic_ids);

			foreach ($topic_data as $topic_id => $topic)
			{
				$this->helper->add_notifications('leinad4mind.staffnotifications.notification.type.delete_topic', [
					'user_id'	=> $topic['topic_poster'],
					'topic_id'	=> $topic['topic_id'],
					'forum_id'	=> $topic['forum_id'],
					'reference'	=> [
						'title'		=> $topic['topic_title'],
						'reason'	=> $this->request->variable('delete_reason', '', true),
					],
				]);
			}
		}
	}

	/**
	 * @param data $event
	 */
	public function ban_user(data $event)
	{
		if ($event['mode'] == 'user')
		{
			$banned_usernames = is_array($event['ban']) ? $event['ban'] : [$event['ban']];

			foreach ($this->helper->get_user_ids($banned_usernames) as $user_id)
			{
				$this->helper->add_notifications('leinad4mind.staffnotifications.notification.type.ban_user', [
					'lang_key'	=> 'STAFFNOTIFICATIONS_TITLE_BAN_USER',
					'user_id'	=> $user_id,
					'reference'	=> [
						'reason'	=> $event['ban_reason'],
						'duration'	=> $this->helper->get_ban_reference($event['ban_length'], $event['ban_length_other']),
					],
				]);
			}
		}
	}

	/**
	 * @param data $event
	 */
	public function merge_topics(data $event)
	{
		if ($this->is_merging)
		{
			$to_topic_data = $this->helper->get_topic_data([$event['to_topic_id']]);
			$to_topic_data = reset($to_topic_data);

			$this->helper->add_notifications('leinad4mind.staffnotifications.notification.type.merge_topics', [
				'topic_id'	=> $event['to_topic_id'],
				'forum_id'	=> $to_topic_data['forum_id'],
				'reference'	=> [
					'title'  	=> $to_topic_data['topic_title'],
				],
			]);
		}
	}

	/**
	 * @param data $event
	 */
	public function merge_posts(data $event)
	{
		if ($this->is_merging)
		{
			$to_topic_data = $this->helper->get_topic_data([$event['to_topic_id']]);
			$to_topic_data = reset($to_topic_data);

			$this->helper->add_notifications('leinad4mind.staffnotifications.notification.type.merge_posts', [
				'topic_id'	=> $event['to_topic_id'],
				'forum_id'	=> $to_topic_data['forum_id'],
				'reference'	=> [
					'title'  	=> $to_topic_data['topic_title'],
				],
			]);
		}
	}
}

