<?php
/**
 * @package cBB QuickMod
 * @version 1.1.6 01/11/2024
 *
 * @copyright (c) 2024 CaniDev
 * @license https://creativecommons.org/licenses/by-nc/4.0/
 */

namespace canidev\quickmod\libraries\tasks;

class move extends base
{
	public $permissions 	= 'm_move';
	public $category 		= 'OPTIONS_TOOLS';
	public $icon 			= 'fa-random';
	public $order 			= 40;
	public $title 			= 'MOVE_TOPIC';

	/**
	 * {@inheritDoc}
	 */
	public function available_on_row($topic_type, $topic_status, $topic_visibility)
	{
		return $topic_status != ITEM_MOVED;
	}

	/**
	 * {@inheritDoc}
	 */
	public function run(array $ids, $forum_id)
	{
		if($this->core->modal_dialog(true))
		{
			$to_forum_id 	= $this->request->variable('to_forum_id', 0);
			$forum_data 	= phpbb_get_forum_data($to_forum_id, 'f_post');

			if(!count($forum_data))
			{
				$this->response->error($this->language->lang('FORUM_NOT_EXIST'));
			}

			$forum_data = $forum_data[$to_forum_id];

			if($forum_data['forum_type'] != FORUM_POST)
			{
				$this->response->error($this->language->lang('FORUM_NOT_POSTABLE'));
			}
			else if(!$this->auth->acl_get('f_post', $to_forum_id) || (!$this->auth->acl_get('m_approve', $to_forum_id) && !$this->auth->acl_get('f_noapprove', $to_forum_id)))
			{
				$this->response->error($this->language->lang('USER_CANNOT_POST'));
			}
			else if($forum_id == $to_forum_id)
			{
				$this->response->error($this->language->lang('CANNOT_MOVE_SAME_FORUM'));
			}
	
			$topic_data = phpbb_get_topic_data($ids);
			$leave_shadow = $this->request->is_set_post('move_leave_shadow');
	
			$forum_sync_data = [];
	
			$forum_sync_data[$forum_id] = current($topic_data);
			$forum_sync_data[$to_forum_id] = $forum_data;
	
			$topics_moved = $topics_moved_unapproved = $topics_moved_softdeleted = 0;
			$posts_moved = $posts_moved_unapproved = $posts_moved_softdeleted = 0;
	
			foreach($topic_data as $topic_id => $topic_info)
			{
				if($topic_info['topic_visibility'] == ITEM_APPROVED)
				{
					$topics_moved++;
				}
				else if($topic_info['topic_visibility'] == ITEM_UNAPPROVED || $topic_info['topic_visibility'] == ITEM_REAPPROVE)
				{
					$topics_moved_unapproved++;
				}
				else if($topic_info['topic_visibility'] == ITEM_DELETED)
				{
					$topics_moved_softdeleted++;
				}
	
				$posts_moved += $topic_info['topic_posts_approved'];
				$posts_moved_unapproved += $topic_info['topic_posts_unapproved'];
				$posts_moved_softdeleted += $topic_info['topic_posts_softdeleted'];
			}
	
			$this->db->sql_transaction('begin');
	
			// Move topics, but do not resync yet
			move_topics($ids, $to_forum_id, false);
	
			$shadow_topics = 0;
			$forum_ids = [$to_forum_id];
			foreach($topic_data as $topic_id => $row)
			{
				// Get the list of forums to resync, add a log entry
				$forum_ids[] = $row['forum_id'];
	
				// We add the $to_forum_id twice, because 'forum_id' is updated
				// when the topic is moved again later.
				$this->log->add('mod', $this->user->data['user_id'], $this->user->ip, 'LOG_MOVE', false, [
					'forum_id'		=> (int) $to_forum_id,
					'topic_id'		=> (int) $topic_id,
					$row['forum_name'],
					$forum_data['forum_name'],
					(int) $row['forum_id'],
					(int) $forum_data['forum_id'],
				]);
	
				// If we have moved a global announcement, we need to correct the topic type
				if($row['topic_type'] == POST_GLOBAL)
				{
					$sql = 'UPDATE ' . TOPICS_TABLE . '
						SET topic_type = ' . POST_ANNOUNCE . '
						WHERE topic_id = ' . (int) $row['topic_id'];
					$this->db->sql_query($sql);
				}
	
				// Leave a redirection if required and only if the topic is visible to users
				if($leave_shadow && $row['topic_visibility'] == ITEM_APPROVED && $row['topic_type'] != POST_GLOBAL)
				{
					$shadow = [
						'forum_id'					=> (int) $row['forum_id'],
						'icon_id'					=> (int) $row['icon_id'],
						'topic_attachment'			=> (int) $row['topic_attachment'],
						'topic_visibility'			=> ITEM_APPROVED, // a shadow topic is always approved
						'topic_reported'			=> 0, // a shadow topic is never reported
						'topic_title'				=> $row['topic_title'],
						'topic_poster'				=> (int) $row['topic_poster'],
						'topic_time'				=> (int) $row['topic_time'],
						'topic_time_limit'			=> (int) $row['topic_time_limit'],
						'topic_views'				=> (int) $row['topic_views'],
						'topic_posts_approved'		=> (int) $row['topic_posts_approved'],
						'topic_posts_unapproved'	=> (int) $row['topic_posts_unapproved'],
						'topic_posts_softdeleted'	=> (int) $row['topic_posts_softdeleted'],
						'topic_status'				=> ITEM_MOVED,
						'topic_type'				=> POST_NORMAL,
						'topic_first_post_id'		=> (int) $row['topic_first_post_id'],
						'topic_first_poster_colour'	=> $row['topic_first_poster_colour'],
						'topic_first_poster_name'	=> $row['topic_first_poster_name'],
						'topic_last_post_id'		=> (int) $row['topic_last_post_id'],
						'topic_last_poster_id'		=> (int) $row['topic_last_poster_id'],
						'topic_last_poster_colour'	=> $row['topic_last_poster_colour'],
						'topic_last_poster_name'	=> $row['topic_last_poster_name'],
						'topic_last_post_subject'	=> $row['topic_last_post_subject'],
						'topic_last_post_time'		=> (int) $row['topic_last_post_time'],
						'topic_last_view_time'		=> (int) $row['topic_last_view_time'],
						'topic_moved_id'			=> (int) $row['topic_id'],
						'topic_bumped'				=> (int) $row['topic_bumped'],
						'topic_bumper'				=> (int) $row['topic_bumper'],
						'poll_title'				=> $row['poll_title'],
						'poll_start'				=> (int) $row['poll_start'],
						'poll_length'				=> (int) $row['poll_length'],
						'poll_max_options'			=> (int) $row['poll_max_options'],
						'poll_last_vote'			=> (int) $row['poll_last_vote']
					];
					
					/**
					 * Perform actions before shadow topic is created.
					 *
					 * @event core.mcp_main_modify_shadow_sql
					 * @var	array	shadow	SQL array
					 * @var	array	row		Topic data
					 * @since 3.1.11-RC1
					 */
					$vars = ['shadow', 'row'];
					extract($this->dispatcher->trigger_event('core.mcp_main_modify_shadow_sql', compact($vars)));
	
					$this->db->sql_query('INSERT INTO ' . TOPICS_TABLE . $this->db->sql_build_array('INSERT', $shadow));
	
					// Shadow topics only count on new "topics" and not posts... a shadow topic alone has 0 posts
					$shadow_topics++;
				}
			}
			unset($topic_data);
	
			$sync_sql = [];
			if ($posts_moved)
			{
				$sync_sql[$to_forum_id][] = 'forum_posts_approved = forum_posts_approved + ' . (int) $posts_moved;
				$sync_sql[$forum_id][] = 'forum_posts_approved = forum_posts_approved - ' . (int) $posts_moved;
			}
			if ($posts_moved_unapproved)
			{
				$sync_sql[$to_forum_id][] = 'forum_posts_unapproved = forum_posts_unapproved + ' . (int) $posts_moved_unapproved;
				$sync_sql[$forum_id][] = 'forum_posts_unapproved = forum_posts_unapproved - ' . (int) $posts_moved_unapproved;
			}
			if ($posts_moved_softdeleted)
			{
				$sync_sql[$to_forum_id][] = 'forum_posts_softdeleted = forum_posts_softdeleted + ' . (int) $posts_moved_softdeleted;
				$sync_sql[$forum_id][] = 'forum_posts_softdeleted = forum_posts_softdeleted - ' . (int) $posts_moved_softdeleted;
			}
	
			if ($topics_moved)
			{
				$sync_sql[$to_forum_id][] = 'forum_topics_approved = forum_topics_approved + ' . (int) $topics_moved;
				if ($topics_moved - $shadow_topics > 0)
				{
					$sync_sql[$forum_id][] = 'forum_topics_approved = forum_topics_approved - ' . (int) ($topics_moved - $shadow_topics);
				}
			}
			if ($topics_moved_unapproved)
			{
				$sync_sql[$to_forum_id][] = 'forum_topics_unapproved = forum_topics_unapproved + ' . (int) $topics_moved_unapproved;
				$sync_sql[$forum_id][] = 'forum_topics_unapproved = forum_topics_unapproved - ' . (int) $topics_moved_unapproved;
			}
			if ($topics_moved_softdeleted)
			{
				$sync_sql[$to_forum_id][] = 'forum_topics_softdeleted = forum_topics_softdeleted + ' . (int) $topics_moved_softdeleted;
				$sync_sql[$forum_id][] = 'forum_topics_softdeleted = forum_topics_softdeleted - ' . (int) $topics_moved_softdeleted;
			}
	
			foreach($sync_sql as $forum_id_key => $array)
			{
				$sql = 'UPDATE ' . FORUMS_TABLE . '
					SET ' . implode(', ', $array) . '
					WHERE forum_id = ' . $forum_id_key;
				$this->db->sql_query($sql);
			}
	
			$this->db->sql_transaction('commit');
	
			sync('forum', 'forum_id', [$forum_id, $to_forum_id]);

			$this->response->add('message', $this->language->lang(((count($ids) == 1) ? 'TOPIC' : 'TOPICS') . '_MOVED_SUCCESS'));
			return true;
		}

		$this->template->assign_vars([
			'DIALOG_CONTENT'		=> true,
			'S_FORUM_REQUEST'	=> true,
			'S_CAN_LEAVE'		=> ($forum_id) ? true : false,
			'S_FORUM_SELECT'	=> make_forum_select(false, $forum_id, false, true, true, true),
		]);

		$this->core->modal_dialog(
			false,
			'MOVE_TOPIC',
			[
				'action'		=> 'move',
				'topic_id_list'	=> $ids,
			],
			'@canidev_quickmod/quickmod_ajax.html',
			[
				'dialogWidth' => 500
			]
		);
	}
}
