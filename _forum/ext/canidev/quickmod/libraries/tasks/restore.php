<?php
/**
* @package cBB QuickMod
* @version 1.1.4 01/06/2022
*
* @copyright (c) 2022 CaniDev
* @license https://creativecommons.org/licenses/by-nc/4.0/
*/

namespace canidev\quickmod\libraries\tasks;

class restore extends base
{
	public $permissions = 'm_approve';
	public $category 	= 'OPTIONS_BASIC';
	public $icon 		= 'fa-exchange';
	public $order 		= 5;
	public $title 		= 'RESTORE_TOPIC';

	protected $visibility;

	/**
	 * {@inheritDoc}
	 */
	public function __construct($container)
	{
		parent::__construct($container);

		$this->visibility 	= $container->get('content.visibility');
	}

	/**
	 * {@inheritDoc}
	 */
	public function available_on_row($topic_type, $topic_status, $topic_visibility)
	{
		return $topic_visibility == ITEM_DELETED && $topic_status != ITEM_MOVED;
	}

	/**
	 * {@inheritDoc}
	 */
	public function run(array $topic_ids, $forum_id)
	{
		if(!$this->confirm(sizeof($topic_ids)))
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
			$return = $this->visibility->set_topic_visibility(ITEM_APPROVED, $topic_id, $row['forum_id'], $this->user->data['user_id'], time(), '');
			
			if(!empty($return))
			{
				$this->log->add('mod', $this->user->data['user_id'], $this->user->ip, 'LOG_RESTORE_TOPIC', false, array(
					'forum_id'	=> $row['forum_id'],
					'topic_id'	=> $topic_id,
					$row['topic_title'],
					$row['topic_first_poster_name'],
				));
			}
		}

		$this->response->add('message', $this->language->lang(((sizeof($topic_ids) == 1) ? 'TOPIC' : 'TOPICS') . '_RESTORED_SUCCESS'));
	}
}
