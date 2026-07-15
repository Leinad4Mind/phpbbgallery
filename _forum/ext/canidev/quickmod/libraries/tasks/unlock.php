<?php
/**
 * @package cBB QuickMod
 * @version 1.1.5 20/10/2023
 *
 * @copyright (c) 2023 CaniDev
 * @license https://creativecommons.org/licenses/by-nc/4.0/
 */

namespace canidev\quickmod\libraries\tasks;

class unlock extends base
{
	public $permissions = 'm_lock';
	public $category 	= 'OPTIONS_BASIC';
	public $icon 		= 'fa-unlock';
	public $order 		= 8;
	public $title 		= 'UNLOCK_TOPIC';

	/**
	 * {@inheritDoc}
	 */
	public function available_on_row($topic_type, $topic_status, $topic_visibility)
	{
		return $topic_status != ITEM_UNLOCKED && $topic_status != ITEM_MOVED;
	}

	/**
	 * {@inheritDoc}
	 */
	public function run(array $ids, $forum_id)
	{
		$action = 'unlock';

		if(!phpbb_check_ids($ids, TOPICS_TABLE, 'topic_id', ['m_lock']))
		{
			return false;
		}

		if(!$this->confirm(sizeof($ids)))
		{
			return null;
		}

		$sql = 'UPDATE ' . TOPICS_TABLE . '
			SET topic_status = ' . ITEM_UNLOCKED . '
			WHERE ' . $this->db->sql_in_set('topic_id', $ids) . '
			AND topic_moved_id = 0';
		$this->db->sql_query($sql);

		$data = phpbb_get_topic_data($ids);

		foreach($data as $id => $row)
		{
			if(!$row['topic_moved_id'])
			{
				$this->log->add('mod', $this->user->data['user_id'], $this->user->ip, 'LOG_UNLOCK', false, [
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
		 * @var	string	action				Variable containing the action we perform on the topics ('lock', 'unlock')
		 * @var	array	ids					Array containing the topic IDs that have been locked/unlocked
		 * @var	array	data				Array containing topics data
		 * @since 3.1.7-RC1
		 */
		$vars = ['action', 'ids', 'data'];
		extract($this->dispatcher->trigger_event('core.mcp_lock_unlock_after', compact($vars)));

		$this->response->add('message', $this->language->lang(((sizeof($ids) == 1) ? 'TOPIC' : 'TOPICS') . '_UNLOCKED_SUCCESS'));
	}
}
