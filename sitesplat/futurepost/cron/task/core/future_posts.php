<?php
/**
*
* Future Posts
*
* @copyright (c) 2017 ForumHulp.com <http://forumhulp.com>
* @license Proprietary
*
*/

namespace forumhulp\futurepost\cron\task\core;

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

	/**
	* Constructor.
	*
	*/
	public function __construct($phpbb_root_path, $php_ext, config $config, driver_interface $db, ContainerInterface $container, user $user)
	{
		$this->phpbb_root_path = $phpbb_root_path;
		$this->php_ext = $php_ext;
		$this->config = $config;
		$this->db = $db;
		$this->container = $container;
		$this->user = $user;
	}

	/**
	* Runs this cron task.
	*
	* @return null
	*/
	public function run()
	{
		$future_ary = $post_id_list = $approve_log = $topic_info = array();
		for ($i = 0; $i < min(5, (strtotime(date('m/d/Y', time())) - strtotime(date('n/j/Y', $this->config['future_posts_last_gc'] - 86400))) / 86400); $i++)
		{
			$future_ary[] = strtotime(date('m/d/Y', time())) - ($i * 86400);
		}

		if (sizeof($future_ary))
		{
			$sql = 'SELECT post_id FROM ' . POSTS_TABLE . ' WHERE post_time IN (' . implode(',', $future_ary) . ') AND post_visibility = ' . ITEM_UNAPPROVED;
			$result = $this->db->sql_query($sql);	
			while ($row = $this->db->sql_fetchrow($result))
			{
				$post_id_list[] = $row['post_id'];
			}
		}
		if (sizeof($post_id_list))
		{
			include($this->phpbb_root_path . 'includes/functions_mcp.' . $this->php_ext);		
			
			$num_topics = 0;
			$post_info = phpbb_get_post_data($post_id_list, 'm_approve');
	
			// Group the posts by topic_id
			foreach ($post_info as $post_id => $post_data)
			{
				if ($post_data['post_visibility'] == ITEM_APPROVED)
				{
					continue;
				}
				$topic_id = (int) $post_data['topic_id'];
	
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
	
				$approve_log[] = array(
					'forum_id'		=> $post_data['forum_id'],
					'topic_id'		=> $post_data['topic_id'],
					'post_id'		=> $post_id,
					'post_subject'	=> $post_data['post_subject'],
				);
			}
			
			$phpbb_content_visibility = $this->container->get('content.visibility');
			foreach ($topic_info as $topic_id => $topic_data)
			{
				$phpbb_content_visibility->set_post_visibility(ITEM_APPROVED, $topic_data['posts'], $topic_id, $topic_data['forum_id'], $this->user->data['user_id'], time(), '', isset($topic_data['first_post']), isset($topic_data['last_post']));
			}
	
			$phpbb_log = $this->container->get('log');
			foreach ($approve_log as $log_data)
			{
				$phpbb_log->add('mod', $this->user->data['user_id'], $this->user->ip, 'LOG_FUTURE_POST_APROVED', false, array(
					'forum_id' => $log_data['forum_id'],
					'topic_id' => $log_data['topic_id'],
					'post_id'  => $log_data['post_id'],
					$log_data['post_subject']
				));
			}
	
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
				} else
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
		}
		$this->config->set('future_posts_last_gc', strtotime(date('m/d/Y', time())), true);
	}

	/**
	* Returns whether this cron task can run, given current board configuration.
	*
	* @return bool
	*/
	public function is_runnable()
	{
		return true;
	}

	/**
	* Returns whether this cron task should run now, because enough time
	* has passed since it was last run.
	*
	* @return bool
	*/
	public function should_run()
	{
		return $this->config['future_posts_last_gc'] < time() - $this->config['future_posts_gc'];
	}
}
