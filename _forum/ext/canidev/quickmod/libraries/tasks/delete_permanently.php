<?php
/**
 * @package cBB QuickMod
 * @version 1.1.5 20/10/2023
 *
 * @copyright (c) 2023 CaniDev
 * @license https://creativecommons.org/licenses/by-nc/4.0/
 */

namespace canidev\quickmod\libraries\tasks;

class delete_permanently extends base
{
	public $permissions = 'm_delete';
	public $category 	= 'OPTIONS_BASIC';
	public $icon 		= 'fa-times';
	public $order 		= 4;
	public $title 		= 'DELETE_PERMANENTLY_TOPIC';

	/**
	 * {@inheritDoc}
	 */
	public function run(array $topic_ids, $forum_id)
	{
		if(!$this->confirm(sizeof($topic_ids), 'DELETE_TOPIC'))
		{
			return null;
		}
		
		if(!phpbb_check_ids($topic_ids, TOPICS_TABLE, 'topic_id', $this->permissions))
		{
			return false;
		}

		$data = phpbb_get_topic_data($topic_ids);

		foreach($data as $topic_id => $row)
		{
			if($row['topic_moved_id'])
			{
				$this->log->add('mod', $this->user->data['user_id'], $this->user->ip, 'LOG_DELETE_SHADOW_TOPIC', false, [
					'forum_id'	=> $row['forum_id'],
					'topic_id'	=> $topic_id,
					$row['topic_title'],
				]);
			}
			else
			{
				$this->log->add('mod', $this->user->data['user_id'], $this->user->ip, 'LOG_DELETE_TOPIC', false, [
					'forum_id'	=> $row['forum_id'],
					'topic_id'	=> $topic_id,
					$row['topic_title'],
					$row['topic_first_poster_name'],
					''
				]);
			}
		}

		delete_topics('topic_id', $topic_ids);

		$this->response->add([
			'message'	=> $this->language->lang(((sizeof($topic_ids) == 1) ? 'TOPIC' : 'TOPICS') . '_DELETED_SUCCESS'),
			'reload'	=> false,
		]);
	}
}
