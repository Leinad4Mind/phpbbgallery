<?php
/**
 * @package cBB QuickMod
 * @version 1.1.6 01/11/2024
 *
 * @copyright (c) 2024 CaniDev
 * @license https://creativecommons.org/licenses/by-nc/4.0/
 */

namespace canidev\quickmod\libraries\tasks;

class resync extends base
{
	public $permissions 	= 'm_';
	public $category 		= 'OPTIONS_TOOLS';
	public $icon 			= 'fa-refresh';
	public $order 			= 60;
	public $title 			= 'RESYNC_TOPIC';

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
		if(!phpbb_check_ids($ids, TOPICS_TABLE, 'topic_id', ['m_']))
		{
			return;
		}
	
		// Sync everything and perform extra checks separately
		sync('topic_reported', 'topic_id', $ids, false, true);
		sync('topic_attachment', 'topic_id', $ids, false, true);
		sync('topic', 'topic_id', $ids, true, false);
	
		// Log this action
		$sql = 'SELECT topic_id, forum_id, topic_title
			FROM ' . TOPICS_TABLE . '
			WHERE ' . $this->db->sql_in_set('topic_id', $ids);
		$result = $this->db->sql_query($sql);
		while($row = $this->db->sql_fetchrow($result))
		{
			$this->log->add('mod', $this->user->data['user_id'], $this->user->ip, 'LOG_TOPIC_RESYNC', false, [
				'forum_id' => $row['forum_id'],
				'topic_id' => $row['topic_id'],
				$row['topic_title']
			]);
		}
		$this->db->sql_freeresult($result);

		$this->response->add('message', $this->language->lang(((count($ids) == 1) ? 'TOPIC' : 'TOPICS') . '_RESYNC_SUCCESS'));
		return true;
	}
}
