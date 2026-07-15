<?php
/**
 * @package cBB QuickMod
 * @version 1.1.6 01/11/2024
 *
 * @copyright (c) 2024 CaniDev
 * @license https://creativecommons.org/licenses/by-nc/4.0/
 */

namespace canidev\quickmod\libraries\tasks;

class fork extends base
{
	public $permissions 	= 'm_';
	public $category 		= 'OPTIONS_TOOLS';
	public $icon 			= 'fa-copy';
	public $order 			= 50;
	public $title 			= 'FORK_TOPIC';

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
		if($this->core->modal_dialog(true))
		{
			$to_forum_id 	= $this->request->variable('to_forum_id', 0);
			$forum_data 	= phpbb_get_forum_data($to_forum_id, 'f_post');

			if(!count($forum_data))
			{
				$this->response->error($this->language->lang('FORUM_NOT_EXIST'));
			}

			$forum_data = $forum_data[$to_forum_id];

			if($forum_data['forum_type'] != FORUM_POST)
			{
				$this->response->error($this->language->lang('FORUM_NOT_POSTABLE'));
			}
			else if(!$this->auth->acl_get('f_post', $to_forum_id))
			{
				$this->response->error($this->language->lang('USER_CANNOT_POST'));
			}

			$topic_data = phpbb_get_topic_data($ids, 'f_post');

			$total_topics = $total_topics_unapproved = $total_topics_softdeleted = 0;
			$total_posts = $total_posts_unapproved = $total_posts_softdeleted = 0;
			$new_topic_id_list = [];
			$counter = [];

			foreach($topic_data as $topic_id => $topic_row)
			{
				if(!isset($search_type) && $topic_row['enable_indexing'])
				{
					// Select the search method and do some additional checks to ensure it can actually be utilised
					$search_type = $this->config['search_type'];

					if(!class_exists($search_type))
					{
						$this->response->error($this->language->lang('NO_SUCH_SEARCH_MODULE'));
					}

					$error 			= false;
					$search_mode 	= 'post';
					
					$search = new $search_type(
						$error,
						$this->phpbb_root_path,
						$this->php_ext,
						$this->auth,
						$this->config,
						$this->db,
						$this->user,
						$this->dispatcher
					);

					if($error)
					{
						$this->response->error($error);
					}
				}
				else if(!isset($search_type) && !$topic_row['enable_indexing'])
				{
					$search_type = false;
				}

				$sql_ary = [
					'forum_id'					=> (int) $to_forum_id,
					'icon_id'					=> (int) $topic_row['icon_id'],
					'topic_attachment'			=> (int) $topic_row['topic_attachment'],
					'topic_visibility'			=> (int) $topic_row['topic_visibility'],
					'topic_reported'			=> 0,
					'topic_title'				=> $topic_row['topic_title'],
					'topic_poster'				=> (int) $topic_row['topic_poster'],
					'topic_time'				=> (int) $topic_row['topic_time'],
					'topic_posts_approved'		=> (int) $topic_row['topic_posts_approved'],
					'topic_posts_unapproved'	=> (int) $topic_row['topic_posts_unapproved'],
					'topic_posts_softdeleted'	=> (int) $topic_row['topic_posts_softdeleted'],
					'topic_status'				=> (int) $topic_row['topic_status'],
					'topic_type'				=> (int) $topic_row['topic_type'],
					'topic_first_poster_name'	=> $topic_row['topic_first_poster_name'],
					'topic_last_poster_id'		=> (int) $topic_row['topic_last_poster_id'],
					'topic_last_poster_name'	=> $topic_row['topic_last_poster_name'],
					'topic_last_post_time'		=> (int) $topic_row['topic_last_post_time'],
					'topic_last_view_time'		=> (int) $topic_row['topic_last_view_time'],
					'topic_bumped'				=> (int) $topic_row['topic_bumped'],
					'topic_bumper'				=> (int) $topic_row['topic_bumper'],
					'poll_title'				=> $topic_row['poll_title'],
					'poll_start'				=> (int) $topic_row['poll_start'],
					'poll_length'				=> (int) $topic_row['poll_length'],
					'poll_max_options'			=> (int) $topic_row['poll_max_options'],
					'poll_vote_change'			=> (int) $topic_row['poll_vote_change'],
				];

				/**
				* Perform actions before forked topic is created.
				*
				* @event core.mcp_main_modify_fork_sql
				* @var	array	sql_ary	SQL array
				* @since 3.1.11-RC1
				*/
				$vars = ['sql_ary', 'topic_row'];
				extract($this->dispatcher->trigger_event('core.mcp_main_modify_fork_sql', compact($vars)));

				$this->db->sql_query('INSERT INTO ' . TOPICS_TABLE . ' ' . $this->db->sql_build_array('INSERT', $sql_ary));
				$new_topic_id = $this->db->sql_nextid();
				$new_topic_id_list[$topic_id] = $new_topic_id;

				switch($topic_row['topic_visibility'])
				{
					case ITEM_APPROVED:
						$total_topics++;
					break;
					case ITEM_UNAPPROVED:
					case ITEM_REAPPROVE:
						$total_topics_unapproved++;
					break;
					case ITEM_DELETED:
						$total_topics_softdeleted++;
					break;
				}

				if($topic_row['poll_start'])
				{
					$sql = 'SELECT *
						FROM ' . POLL_OPTIONS_TABLE . "
						WHERE topic_id = $topic_id";
					$result = $this->db->sql_query($sql);
					while($row = $this->db->sql_fetchrow($result))
					{
						$sql_ary = [
							'poll_option_id'	=> (int) $row['poll_option_id'],
							'topic_id'			=> (int) $new_topic_id,
							'poll_option_text'	=> $row['poll_option_text'],
							'poll_option_total'	=> 0
						];

						$this->db->sql_query('INSERT INTO ' . POLL_OPTIONS_TABLE . ' ' . $this->db->sql_build_array('INSERT', $sql_ary));
					}
					$this->db->sql_freeresult($result);
				}

				$sql = 'SELECT *
					FROM ' . POSTS_TABLE . "
					WHERE topic_id = $topic_id
					ORDER BY post_time ASC, post_id ASC";
				$result = $this->db->sql_query($sql);
				$post_rows = [];
				while($row = $this->db->sql_fetchrow($result))
				{
					$post_rows[] = $row;
				}
				$this->db->sql_freeresult($result);

				if(!count($post_rows))
				{
					continue;
				}

				foreach($post_rows as $row)
				{
					$sql_ary = [
						'topic_id'			=> (int) $new_topic_id,
						'forum_id'			=> (int) $to_forum_id,
						'poster_id'			=> (int) $row['poster_id'],
						'icon_id'			=> (int) $row['icon_id'],
						'poster_ip'			=> $row['poster_ip'],
						'post_time'			=> (int) $row['post_time'],
						'post_visibility'	=> (int) $row['post_visibility'],
						'post_reported'		=> 0,
						'enable_bbcode'		=> (int) $row['enable_bbcode'],
						'enable_smilies'	=> (int) $row['enable_smilies'],
						'enable_magic_url'	=> (int) $row['enable_magic_url'],
						'enable_sig'		=> (int) $row['enable_sig'],
						'post_username'		=> $row['post_username'],
						'post_subject'		=> $row['post_subject'],
						'post_text'			=> $row['post_text'],
						'post_edit_reason'	=> $row['post_edit_reason'],
						'post_edit_user'	=> (int) $row['post_edit_user'],
						'post_checksum'		=> $row['post_checksum'],
						'post_attachment'	=> (int) $row['post_attachment'],
						'bbcode_bitfield'	=> $row['bbcode_bitfield'],
						'bbcode_uid'		=> $row['bbcode_uid'],
						'post_edit_time'	=> (int) $row['post_edit_time'],
						'post_edit_count'	=> (int) $row['post_edit_count'],
						'post_edit_locked'	=> (int) $row['post_edit_locked'],
						'post_postcount'	=> $row['post_postcount'],
					];

					// Adjust post count only if the post can be incremented to the user counter
					if($row['post_postcount'])
					{
						if(isset($counter[$row['poster_id']]))
						{
							++$counter[$row['poster_id']];
						}
						else
						{
							$counter[$row['poster_id']] = 1;
						}
					}

					/**
					 * Modify the forked post's sql array before it's inserted into the database.
					 *
					 * @event core.mcp_main_modify_fork_post_sql
					 * @var	int		new_topic_id	The newly created topic ID
					 * @var	int		to_forum_id		The forum ID where the forked topic has been moved to
					 * @var	array	sql_ary			SQL Array with the post's data
					 * @var	array	row				Post data
					 * @var	array	counter			Array with post counts
					 * @since 3.3.5-RC1
					 */
					$vars = [
						'new_topic_id',
						'to_forum_id',
						'sql_ary',
						'row',
						'counter',
					];
					extract($this->dispatcher->trigger_event('core.mcp_main_modify_fork_post_sql', compact($vars)));
					
					$this->db->sql_query('INSERT INTO ' . POSTS_TABLE . ' ' . $this->db->sql_build_array('INSERT', $sql_ary));
					$new_post_id = $this->db->sql_nextid();

					/**
					 * Perform actions after forked topic is created.
					 *
					 * @event core.mcp_main_fork_sql_after
					 * @var	int		new_topic_id	The newly created topic ID
					 * @var	int		to_forum_id		The forum ID where the forked topic has been moved to
					 * @var	int		new_post_id		The newly created post ID
					 * @var	array	row				Post data
					 * @since 3.2.4-RC1
					 */
					$vars = [
						'new_topic_id',
						'to_forum_id',
						'new_post_id',
						'row',
					];
					extract($this->dispatcher->trigger_event('core.mcp_main_fork_sql_after', compact($vars)));

					switch($row['post_visibility'])
					{
						case ITEM_APPROVED:
							$total_posts++;
						break;
						case ITEM_UNAPPROVED:
						case ITEM_REAPPROVE:
							$total_posts_unapproved++;
						break;
						case ITEM_DELETED:
							$total_posts_softdeleted++;
						break;
					}

					// Copy whether the topic is dotted
					markread('post', $to_forum_id, $new_topic_id, 0, $row['poster_id']);

					if(!empty($search_type))
					{
						$search->index($search_mode, $new_post_id, $sql_ary['post_text'], $sql_ary['post_subject'], $sql_ary['poster_id'], ($topic_row['topic_type'] == POST_GLOBAL) ? 0 : $to_forum_id);
						$search_mode = 'reply'; // After one we index replies
					}

					// Copy Attachments
					if($row['post_attachment'])
					{
						$sql_ary = [];

						$sql = 'SELECT * FROM ' . ATTACHMENTS_TABLE . '
							WHERE post_msg_id = ' . (int)$row['post_id'] . '
							AND topic_id = ' . (int)$topic_id . '
							AND in_message = 0
							ORDER BY attach_id ASC';
						$result = $this->db->sql_query($sql);
						while($attach_row = $this->db->sql_fetchrow($result))
						{
							$sql_ary[] = [
								'post_msg_id'		=> (int) $new_post_id,
								'topic_id'			=> (int) $new_topic_id,
								'in_message'		=> 0,
								'is_orphan'			=> (int) $attach_row['is_orphan'],
								'poster_id'			=> (int) $attach_row['poster_id'],
								'physical_filename'	=> utf8_basename($attach_row['physical_filename']),
								'real_filename'		=> utf8_basename($attach_row['real_filename']),
								'download_count'	=> (int) $attach_row['download_count'],
								'attach_comment'	=> $attach_row['attach_comment'],
								'extension'			=> $attach_row['extension'],
								'mimetype'			=> $attach_row['mimetype'],
								'filesize'			=> (int) $attach_row['filesize'],
								'filetime'			=> (int) $attach_row['filetime'],
								'thumbnail'			=> (int) $attach_row['thumbnail']
							];
						}
						$this->db->sql_freeresult($result);

						if(count($sql_ary))
						{
							$this->db->sql_multi_insert(ATTACHMENTS_TABLE, $sql_ary);
						}
					}
				}

				// Copy topic subscriptions to new topic
				$sql_ary = [];

				$sql = 'SELECT user_id, notify_status
					FROM ' . TOPICS_WATCH_TABLE . '
					WHERE topic_id = ' . $topic_id;
				$result = $this->db->sql_query($sql);
				while($row = $this->db->sql_fetchrow($result))
				{
					$sql_ary[] = [
						'topic_id'		=> (int) $new_topic_id,
						'user_id'		=> (int) $row['user_id'],
						'notify_status'	=> (int) $row['notify_status'],
					];
				}
				$this->db->sql_freeresult($result);

				if(count($sql_ary))
				{
					$this->db->sql_multi_insert(TOPICS_WATCH_TABLE, $sql_ary);
				}

				// Copy bookmarks to new topic
				$sql_ary = [];
				
				$sql = 'SELECT user_id
					FROM ' . BOOKMARKS_TABLE . '
					WHERE topic_id = ' . $topic_id;
				$result = $this->db->sql_query($sql);
				while($row = $this->db->sql_fetchrow($result))
				{
					$sql_ary[] = [
						'topic_id'		=> (int)$new_topic_id,
						'user_id'		=> (int)$row['user_id'],
					];
				}
				$this->db->sql_freeresult($result);

				if(count($sql_ary))
				{
					$this->db->sql_multi_insert(BOOKMARKS_TABLE, $sql_ary);
				}
			}

			// Sync new topics, parent forums and board stats
			$sql = 'UPDATE ' . FORUMS_TABLE . '
				SET forum_posts_approved = forum_posts_approved + ' . $total_posts . ',
					forum_posts_unapproved = forum_posts_unapproved + ' . $total_posts_unapproved . ',
					forum_posts_softdeleted = forum_posts_softdeleted + ' . $total_posts_softdeleted . ',
					forum_topics_approved = forum_topics_approved + ' . $total_topics . ',
					forum_topics_unapproved = forum_topics_unapproved + ' . $total_topics_unapproved . ',
					forum_topics_softdeleted = forum_topics_softdeleted + ' . $total_topics_softdeleted . '
				WHERE forum_id = ' . $to_forum_id;
			$this->db->sql_query($sql);

			if(!empty($counter))
			{
				// Do only one query per user and not a query per post.
				foreach($counter as $user_id => $count)
				{
					$sql = 'UPDATE ' . USERS_TABLE . '
						SET user_posts = user_posts + ' . (int)$count . '
						WHERE user_id = ' . (int)$user_id;
					$this->db->sql_query($sql);
				}
			}

			sync('topic', 'topic_id', $new_topic_id_list);
			sync('forum', 'forum_id', $to_forum_id);

			$this->config->increment('num_topics', count($new_topic_id_list), false);
			$this->config->increment('num_posts', $total_posts, false);

			foreach($new_topic_id_list as $topic_id => $new_topic_id)
			{
				$this->log->add('mod', $this->user->data['user_id'], $this->user->ip, 'LOG_FORK', false, [
					'forum_id' => $to_forum_id,
					'topic_id' => $new_topic_id,
					$topic_row['forum_name']
				]);
			}

			$this->response->add([
				'message'	=> $this->language->lang(((count($ids) == 1) ? 'TOPIC' : 'TOPICS') . '_FORKED_SUCCESS'),
				'reload'	=> false,
			]);
			
			return true;
		}

		$this->template->assign_vars([
			'DIALOG_CONTENT'	=> true,
			'S_FORUM_REQUEST'	=> true,
			'S_FORUM_SELECT'	=> make_forum_select(false, $forum_id, false, true, true, true),
		]);

		$this->core->modal_dialog(
			false,
			'FORK_TOPIC',
			[
				'action'		=> 'fork',
				'topic_id_list'	=> $ids,
			],
			'@canidev_quickmod/quickmod_ajax.html',
			[
				'dialogWidth' => 500
			]
		);
	}
}
