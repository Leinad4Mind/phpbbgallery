<?php
/**
 * @package cBB QuickMod
 * @version 1.1.6 01/11/2024
 *
 * @copyright (c) 2024 CaniDev
 * @license https://creativecommons.org/licenses/by-nc/4.0/
 */

namespace canidev\quickmod\libraries\tasks;

class make_global extends base
{
	public $permissions = 'f_announce';
	public $category 	= 'TOPIC_TYPE';
	public $icon 		= 'fa-globe';
	public $order 		= 40;
	public $title 		= 'MAKE_GLOBAL_TOPIC';

	/**
	 * {@inheritDoc}
	 */
	public function available_on_row($topic_type, $topic_status, $topic_visibility)
	{
		return $topic_type != POST_GLOBAL && $topic_status != ITEM_MOVED;
	}

	/**
	 * {@inheritDoc}
	 */
	public function run(array $topic_ids, $forum_id)
	{
		if(!$this->confirm(count($topic_ids), 'CHANGE_TOPIC'))
		{
			return null;
		}

		// Exclude shadow topics
		$data = phpbb_get_topic_data($topic_ids);

		foreach($data as $topic_id => $row)
		{
			if($row['topic_moved_id'])
			{
				if(($id = array_search($topic_id, $topic_ids, true)) !== false)
				{
					unset($topic_ids[$id]);
				}
			}
		}

		if(empty($topic_ids))
		{
			return false;
		}
		
		$sql = 'UPDATE ' . TOPICS_TABLE . '
			SET topic_type = ' . POST_GLOBAL . '
			WHERE ' . $this->db->sql_in_set('topic_id', $topic_ids);
		$this->db->sql_query($sql);

		// Delete topic shadows for global announcements
		$sql = 'DELETE FROM ' . TOPICS_TABLE . '
			WHERE ' . $this->db->sql_in_set('topic_moved_id', $topic_ids);
		$this->db->sql_query($sql);

		foreach($data as $topic_id => $row)
		{
			$this->log->add('mod', $this->user->data['user_id'], $this->user->ip, 'LOG_TOPIC_TYPE_CHANGED', false, [
				'forum_id'	=> $forum_id,
				'topic_id'	=> $topic_id,
				$row['topic_title'],
			]);
		}

		$this->response->add('message', $this->language->lang((count($topic_ids) == 1) ? 'TOPIC_TYPE_CHANGED' : 'TOPICS_TYPE_CHANGED'));
	}
}
