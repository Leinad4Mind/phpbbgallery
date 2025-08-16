<?php
/**
 * @package cBB QuickMod
 * @version 1.1.5 20/10/2023
 *
 * @copyright (c) 2023 CaniDev
 * @license https://creativecommons.org/licenses/by-nc/4.0/
 */

namespace canidev\quickmod\libraries\tasks;

class chgtime extends base
{
	public $permissions = 'm_';
	public $category 	= 'OPTIONS_ADVANCED';
	public $icon 		= 'fa-clock-o';
	public $order 		= 3;
	public $title 		= 'CHANGE_TIME_TOPIC';

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
	public function run(array $topic_ids, $forum_id)
	{
		if($this->core->modal_dialog(true))
		{
			$time	= $this->user->create_datetime();
			$now	= phpbb_gmgetdate($time->getTimestamp() + $time->getOffset());
			
			$new_day	= $this->request->variable('day', $now['mday']);
			$new_month	= $this->request->variable('month', $now['mon']);
			$new_year	= $this->request->variable('year', $now['year']);
			$new_hour	= array_map('intval', explode(':', $this->request->variable('hour', '00:00')));
			
			if(!$new_day || !$new_month || !$new_year || sizeof($new_hour) != 2)
			{
				return false;
			}
			
			$time
				->setDate((int)$new_year, (int)$new_month, (int)$new_day)
				->setTime((int)$new_hour[0], (int)$new_hour[1], 0);
				
			$new_time = $time->getTimestamp();
	
			$post_ids = $updated_forums = $last_post_ids = [];
			$last_topic_id = $timeadd = 0;
			
			// Get some neccessary data before continue
			$sql = 'SELECT p.post_id, p.topic_id, p.forum_id, p.poster_id, p.post_subject, p.post_time, p.post_visibility,
				u.username, u.user_colour
				FROM ' . POSTS_TABLE . ' p
					LEFT JOIN ' . USERS_TABLE . ' u ON(u.user_id = p.poster_id)
				WHERE ' . $this->db->sql_in_set('p.topic_id', $topic_ids) . '
				ORDER BY p.topic_id ASC, p.post_time ASC';
			$result = $this->db->sql_query($sql);
			while($row = $this->db->sql_fetchrow($result))
			{
				$topic_id = (int)$row['topic_id'];
				$forum_id = (int)$row['forum_id'];
	
				if($row['post_time'] < $new_time)
				{
					// Add 1 minute to the last time
					$timeadd += 60;
	
					if($last_topic_id != $topic_id)
					{
						$last_topic_id = $topic_id;
						$time_add = 0;
					}
					
					// Maintain a time difference to keep post order
					$row['post_time'] = $new_time + $timeadd;
					
					$post_ids[$row['post_id']] = $row['post_time'];
				}
				
				// Maintain the order for the last post if required update
				if($row['post_visibility'] == ITEM_APPROVED)
				{
					$updated_forums[] = $forum_id;
				}
			}
			$this->db->sql_freeresult($result);
	
			// Set the new time for the first posts
			$sql = 'SELECT topic_first_post_id, topic_last_post_id
				FROM ' . TOPICS_TABLE . '
				WHERE ' . $this->db->sql_in_set('topic_id', $topic_ids);
			$result = $this->db->sql_query($sql);
			while($row = $this->db->sql_fetchrow($result))
			{
				$post_ids[$row['topic_first_post_id']] = $new_time;
				$last_post_ids[] = $row['topic_last_post_id'];
			}
			$this->db->sql_freeresult($result);
			
			// Update the time of the posts and topics
			$sql = 'UPDATE ' . TOPICS_TABLE . "
				SET topic_time = $new_time
				WHERE " . $this->db->sql_in_set('topic_id', $topic_ids);
			$this->db->sql_query($sql);
	
			foreach($post_ids as $post_id => $post_time)
			{
				$sql = 'UPDATE ' . POSTS_TABLE . "
					SET post_time = $post_time
					WHERE post_id = $post_id";
				$this->db->sql_query($sql);
				
				// Update the time of last post in topic
				if(in_array($post_id, $last_post_ids))
				{
					$sql = 'UPDATE ' . TOPICS_TABLE . "
						SET topic_last_post_time = $post_time
						WHERE topic_last_post_id = $post_id";
					$this->db->sql_query($sql);
				}
			}
			
			// Obtain and update the time of the last posts on involved forums
			if(sizeof($updated_forums))
			{
				$updated_forums = array_unique($updated_forums);
	
				$sql = 'SELECT t.forum_id, t.topic_last_post_id, t.topic_last_poster_id, t.topic_last_post_subject, t.topic_last_post_time, 
					t.topic_last_poster_name, t.topic_last_poster_colour, f.forum_last_post_time
					FROM ' . TOPICS_TABLE . ' t
						LEFT JOIN ' . FORUMS_TABLE . ' f ON(f.forum_id = t.forum_id)
					WHERE t.topic_last_post_id = (
						SELECT p.post_id
							FROM ' . POSTS_TABLE . ' p
							WHERE p.forum_id = t.forum_id
							ORDER BY p.post_time DESC
							LIMIT 1
					)
					AND ' . $this->db->sql_in_set('t.forum_id', $updated_forums);
				$result = $this->db->sql_query($sql);
				
				$updated_forums = [];
				
				while($row = $this->db->sql_fetchrow($result))
				{
					if($row['forum_last_post_time'] != $row['topic_last_post_time'])
					{
						$updated_forums[$row['forum_id']] = $row;
					}
				}
				$this->db->sql_freeresult($result);
				
				foreach($updated_forums as $forum_id => $row)
				{
					$sql_ary = [
						'forum_last_post_id'		=> $row['topic_last_post_id'],
						'forum_last_poster_id'		=> $row['topic_last_poster_id'],
						'forum_last_post_subject'	=> $row['topic_last_post_subject'],
						'forum_last_post_time'		=> $row['topic_last_post_time'],
						'forum_last_poster_name'	=> $row['topic_last_poster_name'],
						'forum_last_poster_colour'	=> $row['topic_last_poster_colour'],
					];
					
					$sql = 'UPDATE ' . FORUMS_TABLE . '
						SET ' . $this->db->sql_build_array('UPDATE', $sql_ary) . '
						WHERE forum_id = ' . $forum_id;
					$this->db->sql_query($sql);
				}
			}

			$this->response->add('message', $this->language->lang('TIME_CHANGE_SUCCESS'));
				
			return true;
		}

		$month_names = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

		$s_day_options = $s_month_options = $s_year_options = '';

		$time = $this->user->create_datetime();
		$now = phpbb_gmgetdate($time->getTimestamp() + $time->getOffset());

		for ($i = 1; $i < 32; $i++)
		{
			$selected = ($i == $now['mday']) ? ' selected="selected"' : '';
			$s_day_options .= "<option value=\"$i\"$selected>$i</option>";
			
			if($i < 13)
			{
				$month_name = $this->language->lang(['datetime', $month_names[$i-1]]);

				$selected = ($i == $now['mon']) ? ' selected="selected"' : '';
				$s_month_options .= "<option value=\"$i\"$selected>$month_name</option>";
			}
		}

		for ($i = $now['year'] - 100; $i <= $now['year']; $i++)
		{
			$selected = ($i == $now['year']) ? ' selected="selected"' : '';
			$s_year_options .= "<option value=\"$i\"$selected>$i</option>";
		}

		$this->template->assign_vars([
			'DIALOG_CONTENT'	=> true,
			'S_CHGTIME'			=> true,
			'S_DAY_OPTIONS'		=> $s_day_options,
			'S_MONTH_OPTIONS'	=> $s_month_options,
			'S_YEAR_OPTIONS'	=> $s_year_options,
			'S_HOUR'			=> sprintf('%02d:%02d', $now['hours'], $now['minutes']),
		]);

		$this->core->modal_dialog(
			false,
			'CHANGE_TIME_TOPIC',
			[
				'action'		=> 'chgtime',
				'topic_id_list'	=> $topic_ids,
			],
			'@canidev_quickmod/quickmod_ajax.html'
		);
	}
}
