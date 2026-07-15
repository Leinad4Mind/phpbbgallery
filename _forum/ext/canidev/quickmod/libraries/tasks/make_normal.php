<?php
/**
 * @package cBB QuickMod
 * @version 1.1.5 20/10/2023
 *
 * @copyright (c) 2023 CaniDev
 * @license https://creativecommons.org/licenses/by-nc/4.0/
 */

namespace canidev\quickmod\libraries\tasks;

class make_normal extends base
{
	public $permissions = ['f_sticky', 'f_announce'];
	public $category 	= 'TOPIC_TYPE';
	public $icon 		= 'fa-file-o';
	public $order 		= 1;
	public $title 		= 'MAKE_NORMAL_TOPIC';

	/**
	 * {@inheritDoc}
	 */
	public function available_on_row($topic_type, $topic_status, $topic_visibility)
	{
		return $topic_type != POST_NORMAL && $topic_status != ITEM_MOVED;
	}

	/**
	 * {@inheritDoc}
	 */
	public function run(array $topic_ids, $forum_id)
	{
		// Global topic involved?
		$global_involved = false;

		$sql = 'SELECT topic_id
			FROM ' . TOPICS_TABLE . '
			WHERE ' . $this->db->sql_in_set('topic_id', $topic_ids) . '
				AND forum_id = 0';
		$result = $this->db->sql_query($sql);
		$global_involved = (int)$this->db->sql_fetchfield('topic_id') ? true : false;
		$this->db->sql_freeresult($result);

		if($global_involved && !$forum_id && !$this->core->modal_dialog(true))
		{
			$this->template->assign_vars([
				'DIALOG_CONTENT'	=> true,
			]);
	
			$this->core->modal_dialog(
				false,
				'FORUM_SELECT',
				[
					'action'		=> 'make_normal',
					'topic_id_list'	=> $topic_ids,
				],
				'@canidev_quickmod/quickmod_ajax.html'
			);

			return;
		}

	if(!$this->confirm(sizeof($topic_ids), 'CHANGE_TOPIC'))
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
			SET topic_type = ' . POST_NORMAL . '
			WHERE ' . $this->db->sql_in_set('topic_id', $topic_ids);
		$this->db->sql_query($sql);

		foreach($data as $topic_id => $row)
		{
			$this->log->add('mod', $this->user->data['user_id'], $this->user->ip, 'LOG_TOPIC_TYPE_CHANGED', false, [
				'forum_id'	=> $forum_id,
				'topic_id'	=> $topic_id,
				$row['topic_title'],
			]);
		}

		$this->response->add('message', $this->language->lang((sizeof($topic_ids) == 1) ? 'TOPIC_TYPE_CHANGED' : 'TOPICS_TYPE_CHANGED'));
	}
}
