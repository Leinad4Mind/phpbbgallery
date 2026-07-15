<?php
/**
*
* BBpostdated
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\futurepost\cron\task\core;

use phpbb\config\config;
use phpbb\db\driver\driver_interface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use phpbb\user;

/**
* @ignore
*/

class future_posts extends \phpbb\cron\task\base
{
	protected $phpbb_root_path;
	protected $php_ext;
	protected $config;
	protected $db;
	protected $container;
	protected $user;
	protected $now;
	public function __construct($phpbb_root_path, $php_ext, config $config, driver_interface $db, ContainerInterface $container, user $user)
	{
		$this->phpbb_root_path = $phpbb_root_path;
		$this->php_ext = $php_ext;
		$this->config = $config;
		$this->db = $db;
		$this->container = $container;
		$this->user = $user;
		$this->now = time();
	}

	public function run()
	{
		$post_id_list = array();

		$sql = 'SELECT post_id
			FROM ' . POSTS_TABLE . '
			WHERE (post_visibility = ' . ITEM_UNAPPROVED . ' OR post_visibility = ' . ITEM_REAPPROVE . ')
				AND post_future = 1
				AND post_time < ' . $this->now;
		$result = $this->db->sql_query($sql);
		while ($row = $this->db->sql_fetchrow($result)) {
			$post_id_list[] = $row['post_id'];
		}
		$this->db->sql_freeresult($result);

		if (empty($post_id_list)) {
			$this->config->set('future_posts_last_gc', $this->now, true);
			return;
		}

		include($this->phpbb_root_path . 'includes/functions_mcp.' . $this->php_ext);

		$approve_log = array();
		$num_topics = 0;
		$topic_info = array();

		// Ideally this should be combined into above query
		$post_info = phpbb_get_post_data($post_id_list);

		foreach ($post_info as $post_id => $post_data)
		{
			$topic_id = (int) $post_data['topic_id'];

			if (empty($topic_info[$topic_id]['posts'])) {
				$topic_info[$topic_id]['posts'] = array();
			}

			$topic_info[$topic_id]['posts'][] = (int) $post_id;
			$topic_info[$topic_id]['forum_id'] = (int) $post_data['forum_id'];

			// Refresh the first post, if the time or id is older then the current one
			if ($post_id <= $post_data['topic_first_post_id'] || $post_data['post_time'] <= $post_data['topic_time'])
			{
				$topic_info[$topic_id]['first_post'] = true;
			}

			// Refresh the last post, if the time or id is newer then the current one
			if ($post_id >= $post_data['topic_last_post_id'] || $post_data['post_time'] >= $post_data['topic_last_post_time'])
			{
				$topic_info[$topic_id]['last_post'] = true;
			}

//			$approve_log[] = array(
//				'forum_id'		=> $post_data['forum_id'],
//				'topic_id'		=> $post_data['topic_id'],
//				'post_id'		=> $post_id,
//				'post_subject'	=> $post_data['post_subject'],
//			);
		}

		$phpbb_content_visibility = $this->container->get('content.visibility');
		foreach ($topic_info as $topic_id => $topic_data)
		{
			$phpbb_content_visibility->set_post_visibility(ITEM_APPROVED, $topic_data['posts'], $topic_id, $topic_data['forum_id'], $this->user->data['user_id'], $this->now, '', isset($topic_data['first_post']), isset($topic_data['last_post']));
		}

//		$phpbb_log = $this->container->get('log');
//		foreach ($approve_log as $log_data)
//		{
//			$phpbb_log->add('mod', $this->user->data['user_id'], $this->user->ip, 'LOG_FUTURE_POST_APROVED', false, array(
//				'forum_id' => $log_data['forum_id'],
//				'topic_id' => $log_data['topic_id'],
//				'post_id'  => $log_data['post_id'],
//				$log_data['post_subject']
//			));
//		}

		$phpbb_notifications = $this->container->get('notification_manager');

		// Handle notifications
		foreach ($post_info as $post_id => $post_data)
		{
			// A single topic approval may also happen here, so handle deleting the respective notification.
			if (!$post_data['topic_posts_approved'])
			{
				$phpbb_notifications->delete_notifications('notification.type.topic_in_queue', $post_data['topic_id']);

				if ($post_data['post_visibility'] == ITEM_UNAPPROVED)
				{
					$phpbb_notifications->add_notifications(array('notification.type.topic'), $post_data);
				}
				if ($post_data['post_visibility'] != ITEM_APPROVED)
				{
					$num_topics++;
				}
			}
			else
			{
				// Only add notifications, if we are not reapproving post
				// When the topic was already approved, but was edited and
				// now needs re-approval, we don't want to notify the users
				// again.
				if ($post_data['post_visibility'] == ITEM_UNAPPROVED)
				{
					$phpbb_notifications->add_notifications(array(
						'notification.type.bookmark',
						'notification.type.post',
					), $post_data);
				}
			}
			$phpbb_notifications->add_notifications(array('notification.type.quote'), $post_data);
			$phpbb_notifications->delete_notifications('notification.type.post_in_queue', $post_id);

			$phpbb_notifications->mark_notifications(array(
				'notification.type.quote',
				'notification.type.bookmark',
				'notification.type.post',
			), $post_data['post_id'], $this->user->data['user_id']);
		}

		$this->config->set('future_posts_last_gc', $this->now, true);
	}

	public function is_runnable()
	{
		return true;
	}

	public function should_run()
	{
		return $this->config['future_posts_last_gc'] < $this->now - 60; // every minute
	}
}
