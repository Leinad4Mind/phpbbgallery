<?php
/**
 * @package cBB QuickMod
 * @version 1.1.5 20/10/2023
 *
 * @copyright (c) 2023 CaniDev
 * @license https://creativecommons.org/licenses/by-nc/4.0/
 */

namespace canidev\quickmod\libraries\tasks;

class delete extends base
{
	public $permissions = 'm_softdelete';
	public $category 	= 'OPTIONS_BASIC';
	public $icon 		= 'fa-trash-o';
	public $order 		= 3;
	public $title 		= 'DELETE_TOPIC';

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
		return $topic_visibility != ITEM_DELETED && $topic_status != ITEM_MOVED;
	}

	/**
	 * {@inheritDoc}
	 */
	public function run(array $topic_ids, $forum_id)
	{
		if($this->core->modal_dialog(true))
		{
			if(!phpbb_check_ids($topic_ids, TOPICS_TABLE, 'topic_id', $this->permissions))
			{
				return false;
			}

			$data 	= phpbb_get_topic_data($topic_ids);
			$reason	= $this->request->variable('delete_reason', '', true);

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
					// Only soft delete non-shadow topics
					$return = $this->visibility->set_topic_visibility(ITEM_DELETED, $topic_id, $row['forum_id'], $this->user->data['user_id'], time(), $reason);
					
					if(!empty($return))
					{
						$this->log->add('mod', $this->user->data['user_id'], $this->user->ip, 'LOG_SOFTDELETE_TOPIC', false, [
							'forum_id'	=> $row['forum_id'],
							'topic_id'	=> $topic_id,
							$row['topic_title'],
							$row['topic_first_poster_name'],
							$reason,
						]);
					}
				}
			}

			$this->response->add('message', $this->language->lang(((sizeof($topic_ids) == 1) ? 'TOPIC' : 'TOPICS') . '_DELETED_SUCCESS'));
			return true;
		}

		$this->template->assign_vars([
			'DIALOG_CONTENT'	=> true,
			'S_DELETE'			=> true,
		]);

		$this->core->modal_dialog(
			false,
			'DELETE_TOPIC',
			[
				'action'		=> 'delete',
				'topic_id_list'	=> $topic_ids,
			],
			'@canidev_quickmod/quickmod_ajax.html'
		);
	}
}
