<?php
/**
 * @package cBB QuickMod
 * @version 1.1.5 20/10/2023
 *
 * @copyright (c) 2023 CaniDev
 * @license https://creativecommons.org/licenses/by-nc/4.0/
 */

namespace canidev\quickmod\libraries\tasks;

class rename extends base
{
	public $permissions = 'm_';
	public $category 	= null;
	public $icon 		= 'fa-pencil-square-o';
	public $order 		= 0;
	public $title 		= 'RENAME_TOPIC';

	/**
	 * {@inheritDoc}
	 */
	public function run(array $topic_ids, $forum_id)
	{
		if(!$this->confirm(sizeof($topic_ids)))
		{
			return null;
		}

		if(sizeof($topic_ids) != 1)
		{
			return false;
		}

		$new_title = $this->request->variable('topic_title', '', true);

		// Get some data before changed
		$sql = 'SELECT t.forum_id, t.topic_id, t.topic_poster, t.topic_first_post_id, t.topic_first_poster_name, t.topic_moved_id,
			f.enable_indexing, p.post_text
			FROM ' . TOPICS_TABLE . ' t
				LEFT JOIN ' . FORUMS_TABLE . ' f ON(f.forum_id = t.forum_id)
				LEFT JOIN ' . POSTS_TABLE . ' p ON (p.post_id = t.topic_first_post_id)
			WHERE t.topic_id = ' . $topic_ids[0];
		$result = $this->db->sql_query($sql);
		$topic_data = $this->db->sql_fetchrow($result);
		$this->db->sql_freeresult($result);

		if(!$topic_data || !$new_title)
		{
			return false;
		}

		// Update the topic
		$sql = 'UPDATE ' . TOPICS_TABLE . "
			SET topic_title = '" . $this->db->sql_escape($new_title) . "'
			WHERE topic_id = " . $topic_data['topic_id'] .
			(($topic_data['topic_moved_id']) ? " OR topic_id = {$topic_data['topic_moved_id']} OR topic_moved_id = {$topic_data['topic_moved_id']}" : "");
		$this->db->sql_query($sql);

		// Update the first post
		$sql = 'UPDATE ' . POSTS_TABLE . "
			SET post_subject = '" . $this->db->sql_escape($new_title) . "'
			WHERE post_id = " . $topic_data['topic_first_post_id'];
		$this->db->sql_query($sql);
		
		// Update the last post subject in forums
		$sql = 'UPDATE ' . FORUMS_TABLE . "
			SET forum_last_post_subject = '" . $this->db->sql_escape($new_title) . "'
			WHERE forum_last_post_id = " . $topic_data['topic_first_post_id'];
		$this->db->sql_query($sql);
		
		// Index message contents
		if(!empty($topic_data['enable_indexing']))
		{
			// Select the search method and do some additional checks to ensure it can actually be utilised
			$search_type = $this->config['search_type'];

			if(class_exists($search_type))
			{
				$error	= false;
				$search	= new $search_type(
					$error,
					$this->phpbb_root_path,
					$this->php_ext,
					$this->auth,
					$this->config,
					$this->db,
					$this->user,
					$this->dispatcher
				);

				if(!$error)
				{
					$search->index('edit', $topic_data['topic_first_post_id'], $topic_data['post_text'], $new_title, $topic_data['topic_poster'], $topic_data['forum_id']);
				}
				
				unset($search);
			}
		}

		$this->log->add('mod', $this->user->data['user_id'], $this->user->ip, 'LOG_POST_EDITED', false, [
			'forum_id'	=> $topic_data['forum_id'],
			'topic_id'	=> $topic_data['topic_id'],
			$new_title,
			$topic_data['topic_first_poster_name'],
		]);

		$this->response->add([
			'message' 	=> htmlspecialchars_decode($new_title),
			'reload'	=> false,
		]);
	}
}
