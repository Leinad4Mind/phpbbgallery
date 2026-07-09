<?php
/**
 * @package cBB QuickMod
 * @version 1.1.6 01/11/2024
 *
 * @copyright (c) 2024 CaniDev
 * @license https://creativecommons.org/licenses/by-nc/4.0/
 */

namespace canidev\quickmod\libraries\tasks;

class lock extends base
{
	public $permissions = 'm_lock';
	public $category 	= 'OPTIONS_LOCK';
	public $icon 		= 'fa-lock';
	public $order 		= 10;
	public $title 		= 'LOCK_TOPIC';

	/**
	 * {@inheritDoc}
	 */
	public function available_on_row($topic_type, $topic_status, $topic_visibility)
	{
		return $topic_status != ITEM_LOCKED && $topic_status != ITEM_MOVED;
	}

	/**
	 * {@inheritDoc}
	 */
	public function run(array $ids, $forum_id)
	{
		$action = 'lock';

		if(!$this->confirm(count($ids)))
		{
			return null;
		}

		$orig_ids = $ids;

		if(!phpbb_check_ids($ids, TOPICS_TABLE, 'topic_id', ['m_lock']))
		{
			$ids = $orig_ids;

			if(!phpbb_check_ids($ids, TOPICS_TABLE, 'topic_id', ['f_user_lock']))
			{
				return false;
			}
		}
		unset($orig_ids);

		$sql = 'UPDATE ' . TOPICS_TABLE . '
			SET topic_status = ' . ITEM_LOCKED . '
			WHERE ' . $this->db->sql_in_set('topic_id', $ids) . '
			AND topic_moved_id = 0';
		$this->db->sql_query($sql);

		$data = phpbb_get_topic_data($ids);

		foreach($data as $id => $row)
		{
			if(!$row['topic_moved_id'])
			{
				$this->log->add('mod', $this->user->data['user_id'], $this->user->ip, 'LOG_LOCK', false, [
					'forum_id'	=> $row['forum_id'],
					'topic_id'	=> $row['topic_id'],
					$row['topic_title'],
				]);
			}
		}
		
		/**
		 * Perform additional actions after locking/unlocking topics
		 *
		 * @event core.mcp_lock_unlock_after
		 * @var	string	action				Variable containing the action we perform on the topics ('lock')
		 * @var	array	ids					Array containing the topic IDs that have been locked/unlocked
		 * @var	array	data				Array containing topics data
		 * @since 3.1.7-RC1
		 */
		$vars = ['action', 'ids', 'data'];
		extract($this->dispatcher->trigger_event('core.mcp_lock_unlock_after', compact($vars)));

		$this->response->add('message', $this->language->lang(((count($ids) == 1) ? 'TOPIC' : 'TOPICS') . '_LOCKED_SUCCESS'));
	}
}
