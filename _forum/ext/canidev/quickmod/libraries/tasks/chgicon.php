<?php
/**
 * @package cBB QuickMod
 * @version 1.1.5 20/10/2023
 *
 * @copyright (c) 2023 CaniDev
 * @license https://creativecommons.org/licenses/by-nc/4.0/
 */

namespace canidev\quickmod\libraries\tasks;

class chgicon extends base
{
	public $permissions = 'f_icons';
	public $category 	= 'OPTIONS_ADVANCED';
	public $icon 		= 'fa-picture-o';
	public $order 		= 2;
	public $title 		= 'CHANGE_ICON_TOPIC';

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
			$post_ids	= [];
			$icon_id	= $this->request->variable('icon', 0);
			
			// Get the posts ids
			$sql = 'SELECT topic_first_post_id
				FROM ' . TOPICS_TABLE . '
				WHERE ' . $this->db->sql_in_set('topic_id', $topic_ids);
			$result = $this->db->sql_query($sql);
			while($row = $this->db->sql_fetchrow($result))
			{
				$post_ids[] = $row['topic_first_post_id'];
			}
			$this->db->sql_freeresult($result);

			if(sizeof($post_ids))
			{
				// Update the topic's icons
				$sql = 'UPDATE ' . TOPICS_TABLE . '
					SET icon_id = ' . $icon_id . '
					WHERE ' . $this->db->sql_in_set('topic_id', $topic_ids);
				$this->db->sql_query($sql);
	
				// Update the first post's icons
				$sql = 'UPDATE ' . POSTS_TABLE . '
					SET icon_id = ' . $icon_id . '
					WHERE ' . $this->db->sql_in_set('post_id', $post_ids);
				$this->db->sql_query($sql);
			}

			$this->response->add('message', $this->language->lang('ICON_CHANGE_SUCCESS'));
				
			return true;
		}

		if(!function_exists('posting_gen_topic_icons'))
		{
			include($this->phpbb_root_path . 'includes/functions_posting.' . $this->php_ext);
		}

		$this->template->assign_vars([
			'DIALOG_CONTENT'	=> true,
			'S_CHGICON'			=> true,
		]);

		posting_gen_topic_icons('edit', 0);

		$this->core->modal_dialog(
			false,
			'CHANGE_ICON',
			[
				'action'		=> 'chgicon',
				'topic_id_list'	=> $topic_ids,
			],
			'@canidev_quickmod/quickmod_ajax.html'
		);
	}
}
