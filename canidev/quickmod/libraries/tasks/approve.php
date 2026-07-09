<?php
/**
 * @package cBB QuickMod
 * @version 1.1.6 01/11/2024
 *
 * @copyright (c) 2024 CaniDev
 * @license https://creativecommons.org/licenses/by-nc/4.0/
 */

namespace canidev\quickmod\libraries\tasks;

class approve extends base
{
	public $permissions = 'm_approve';
	public $category 	= 'OPTIONS_APPROVE';
	public $icon 		= 'fa-check';
	public $order 		= 10;
	public $title 		= 'APPROVE_TOPIC';

	protected $notifications;
	protected $visibility;

	/**
	 * {@inheritDoc}
	 */
	public function __construct($container)
	{
		parent::__construct($container);

		$this->notifications 	= $container->get('notification_manager');
		$this->visibility 		= $container->get('content.visibility');
	}

	/**
	 * {@inheritDoc}
	 */
	public function available_on_row($topic_type, $topic_status, $topic_visibility)
	{
		return ($topic_visibility == ITEM_UNAPPROVED || $topic_visibility == ITEM_REAPPROVE) && $topic_status != ITEM_MOVED;
	}

	/**
	 * {@inheritDoc}
	 */
	public function run(array $topic_ids, $forum_id)
	{
		$action = 'approve';

		if($this->core->modal_dialog(true))
		{
			$notify_poster	= $this->request->is_set_post('send_notify');
			$topic_info		= phpbb_get_topic_data($topic_ids, $this->permissions);
			
			$first_post_ids = $approve_log = [];
	
			foreach($topic_info as $topic_id => $topic_data)
			{
				$this->visibility->set_topic_visibility(ITEM_APPROVED, $topic_id, $topic_data['forum_id'], $this->user->data['user_id'], time(), '');
				$first_post_ids[$topic_id] = (int)$topic_data['topic_first_post_id'];

				$approve_log[] = [
					'forum_id'		=> $topic_data['forum_id'],
					'topic_id'		=> $topic_data['topic_id'],
					'topic_title'	=> $topic_data['topic_title'],
				];
			}
			
			foreach($approve_log as $log_data)
			{
				$this->log->add('mod', $this->user->data['user_id'], $this->user->ip, 'LOG_TOPIC_APPROVED', false, [
					'forum_id'	=> $log_data['forum_id'],
					'topic_id'	=> $log_data['topic_id'],
					$log_data['topic_title'],
				]);
			}
			
			// Grab the first post text as it's needed for the quote notification.
			$sql = 'SELECT topic_id, post_text
				FROM ' . POSTS_TABLE . '
				WHERE ' . $this->db->sql_in_set('post_id', $first_post_ids);
			$result = $this->db->sql_query($sql);
			while($row = $this->db->sql_fetchrow($result))
			{
				$topic_info[$row['topic_id']]['post_text'] = $row['post_text'];
			}
			$this->db->sql_freeresult($result);
	
			// Handle notifications
			foreach($topic_info as $topic_id => $topic_data)
			{
				$topic_data = array_merge($topic_data, [
					'post_id'		=> $topic_data['topic_first_post_id'],
					'post_subject'	=> $topic_data['topic_title'],
					'post_time'		=> $topic_data['topic_time'],
					'poster_id'		=> $topic_data['topic_poster'],
					'post_username'	=> $topic_data['topic_first_poster_name'],
				]);
	
				$this->notifications->delete_notifications('notification.type.topic_in_queue', $topic_id);
	
				// Only add notifications, if we are not reapproving post
				// When the topic was already approved, but was edited and
				// now needs re-approval, we don't want to notify the users
				// again.
				if($topic_data['topic_visibility'] == ITEM_UNAPPROVED)
				{
					$this->notifications->add_notifications([
						'notification.type.quote',
						'notification.type.topic',
					], $topic_data);
				}
	
				$this->notifications->mark_notifications('notification.type.quote', $topic_data['post_id'], $this->user->data['user_id']);
				$this->notifications->mark_notifications('notification.type.topic', $topic_id, $this->user->data['user_id']);
	
				if($notify_poster)
				{
					$this->notifications->add_notifications('notification.type.approve_topic', $topic_data);
				}
			}
			
			$success_msg	= ((count($topic_ids) == 1) ? 'TOPIC' : 'TOPICS') . '_APPROVED_SUCCESS';
			$redirect		= '';
			
			/**
			 * Perform additional actions during topics(s) approval
			 *
			 * @event core.approve_topics_after
			 * @var	string	action				Variable containing the action we perform on the posts ('approve' or 'restore')
			 * @var	mixed	topic_info			Array containing info for all topics being approved
			 * @var	array	first_post_ids		Array containing ids of all first posts
			 * @var bool	notify_poster		Variable telling if the poster should be notified or not
			 * @var	string	success_msg			Variable containing the language key for the success message
			 * @var string	redirect			Variable containing the redirect url
			 * @since 3.1.4-RC1
			 */
			$vars = [
				'action',
				'topic_info',
				'first_post_ids',
				'notify_poster',
				'success_msg',
				'redirect',
			];
			extract($this->dispatcher->trigger_event('core.approve_topics_after', compact($vars)));

			$this->response->add('message', $this->language->lang($success_msg));
			return true;
		}

		$this->template->assign_vars([
			'DIALOG_CONTENT'	=> true,
			'S_APPROVE'			=> true,
		]);

		$this->core->modal_dialog(
			false,
			$this->title,
			[
				'action'		=> 'approve',
				'topic_id_list'	=> $topic_ids,
			],
			'@canidev_quickmod/quickmod_ajax.html'
		);
	}
}
