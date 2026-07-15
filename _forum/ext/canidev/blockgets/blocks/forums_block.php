<?php
/*
* @name forums_block.php
* @package cBB Blockgets
* @version v2.0.0 30/05/2017
*
* @copyright (c) 2017 CaniDev
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/

namespace canidev\blockgets\blocks;

// @ignore
if(!defined('IN_PHPBB'))
{
	exit;
}

class forums_block extends base
{
	static $icon = 'blg-icon-sitemap';

	public function init()
	{
		$this->tpl_name = 'forums_block';
		
		if(($data = $this->unserialize()) === false)
		{
			return false;
		}

		$forum_rows = $forum_ids = array();
		$parent_id = $visible_forums = 0;

		$sql_array = array(
			'SELECT'	=> 'f.*',
			'FROM'		=> array(
				FORUMS_TABLE	=> 'f'
			),
			'LEFT_JOIN'	=> array(),
			'ORDER_BY'	=> 'f.left_id',
		);

		if($this->config['load_db_lastread'] && $this->user->data['is_registered'])
		{
			$sql_array['LEFT_JOIN'][] = array('FROM' => array(FORUMS_TRACK_TABLE => 'ft'), 'ON' => 'ft.user_id = ' . $this->user->data['user_id'] . ' AND ft.forum_id = f.forum_id');
			$sql_array['SELECT'] .= ', ft.mark_time';
		}
		else if($this->config['load_anon_lastread'] || $this->user->data['is_registered'])
		{
			$tracking_topics = $this->request->variable($this->config['cookie_name'] . '_track', '', true, \phpbb\request\request_interface::COOKIE);
			$tracking_topics = ($tracking_topics) ? tracking_unserialize($tracking_topics) : array();

			if(!$this->user->data['is_registered'])
			{
				$this->user->data['user_lastmark'] = (isset($tracking_topics['l'])) ? (int) (base_convert($tracking_topics['l'], 36, 10) + $this->config['board_startdate']) : 0;
			}
		}

		/**
		* @event block.forums_query
		* @var array	sql_array		The SQL data
		* @since 2.0.0
		*/
		$vars = array('sql_ary');
		extract($this->dispatcher->trigger_event('block.forums_query', compact($vars)));

		$sql = $this->db->sql_build_query('SELECT', $sql_array);
		$result = $this->db->sql_query($sql);

		$forum_tracking_info = array();
		$branch_root_id = $data['forum_id'];
		
		$phpbb_content_visibility = $this->container->get('content.visibility');

		while($row = $this->db->sql_fetchrow($result))
		{
			$forum_id = $row['forum_id'];

			// Category with no members
			if($row['forum_type'] == FORUM_CAT && ($row['left_id'] + 1 == $row['right_id']))
			{
				continue;
			}

			// Skip branch
			if(isset($right_id))
			{
				if ($row['left_id'] < $right_id)
				{
					continue;
				}
				unset($right_id);
			}

			if(!$this->auth->acl_get('f_list', $forum_id))
			{
				// if the user does not have permissions to list this forum, skip everything until next branch
				$right_id = $row['right_id'];
				continue;
			}

			$forum_ids[] = $forum_id;

			if($this->config['load_db_lastread'] && $this->user->data['is_registered'])
			{
				$forum_tracking_info[$forum_id] = (!empty($row['mark_time'])) ? $row['mark_time'] : $this->user->data['user_lastmark'];
			}
			else if($this->config['load_anon_lastread'] || $this->user->data['is_registered'])
			{
				if(!$this->user->data['is_registered'])
				{
					$this->user->data['user_lastmark'] = (isset($tracking_topics['l'])) ? (int) (base_convert($tracking_topics['l'], 36, 10) + $this->config['board_startdate']) : 0;
				}
				$forum_tracking_info[$forum_id] = (isset($tracking_topics['f'][$forum_id])) ? (int) (base_convert($tracking_topics['f'][$forum_id], 36, 10) + $this->config['board_startdate']) : $this->user->data['user_lastmark'];
			}

			// Lets check whether there are unapproved topics/posts, so we can display an information to moderators
			$approve_auth = $this->auth->acl_get('m_approve', $forum_id);

			$row['forum_id_unapproved_topics']	= ($approve_auth && $row['forum_topics_unapproved']) ? $forum_id : 0;
			$row['forum_id_unapproved_posts']	= ($approve_auth && $row['forum_posts_unapproved']) ? $forum_id : 0;
			$row['forum_posts']		= $phpbb_content_visibility->get_count('forum_posts', $row, $forum_id);
			$row['forum_topics']	= $phpbb_content_visibility->get_count('forum_topics', $row, $forum_id);

			if($row['parent_id'] == $data['forum_id'] || $row['parent_id'] == $branch_root_id)
			{
				// Direct child of current branch
				$parent_id = $forum_id;
				$forum_rows[$forum_id] = $row;

				if ($row['forum_type'] == FORUM_CAT && $row['parent_id'] == $data['forum_id'])
				{
					$branch_root_id = $forum_id;
				}
				$forum_rows[$parent_id]['forum_id_last_post'] = $row['forum_id'];
				$forum_rows[$parent_id]['orig_forum_last_post_time'] = $row['forum_last_post_time'];
			}
			else if($row['forum_type'] != FORUM_CAT && isset($forum_rows[$parent_id]))
			{
				$subforums[$parent_id][$forum_id]['display'] = ($row['display_on_index']) ? true : false;
				$subforums[$parent_id][$forum_id]['name'] = $row['forum_name'];
				$subforums[$parent_id][$forum_id]['orig_forum_last_post_time'] = $row['forum_last_post_time'];
				$subforums[$parent_id][$forum_id]['children'] = array();

				if(isset($subforums[$parent_id][$row['parent_id']]) && !$row['display_on_index'])
				{
					$subforums[$parent_id][$row['parent_id']]['children'][] = $forum_id;
				}

				if(!$forum_rows[$parent_id]['forum_id_unapproved_topics'] && $row['forum_id_unapproved_topics'])
				{
					$forum_rows[$parent_id]['forum_id_unapproved_topics'] = $forum_id;
				}
				
				if(!$forum_rows[$parent_id]['forum_id_unapproved_posts'] && $row['forum_id_unapproved_posts'])
				{
					$forum_rows[$parent_id]['forum_id_unapproved_posts'] = $forum_id;
				}

				$forum_rows[$parent_id]['forum_topics'] += $row['forum_topics'];

				// Do not list redirects in LINK Forums as Posts.
				if($row['forum_type'] != FORUM_LINK)
				{
					$forum_rows[$parent_id]['forum_posts'] += $row['forum_posts'];
				}
			}
		}
		$this->db->sql_freeresult($result);

		// Delete the array in the template if exists, prevent errors between blocks
		$this->template->destroy_block_vars('forum_row');

		// Used to tell whatever we have to create a dummy category or not.
		$last_catless = true;
		foreach($forum_rows as $row)
		{
			// Empty category
			if($row['parent_id'] == $data['forum_id'] && $row['forum_type'] == FORUM_CAT)
			{
				$forum_row = array(
					'S_IS_CAT'			=> true,
					'FORUM_ID'			=> $row['forum_id'],
					'FORUM_NAME'		=> $row['forum_name'],
					'U_VIEWFORUM'		=> $this->helper->url('viewforum', 'f=' . $row['forum_id'])
				);

				/**
				* @event block.forums_row_category
				* @var array	forum_row		The output array
				* @var array	row				The original data
				* @since 2.0.0
				*/
				$vars = array('forum_row', 'row');
				extract($this->dispatcher->trigger_event('block.forums_row_category', compact($vars)));
				
				$this->template->assign_block_vars('forum_row', $forum_row);
				continue;
			}

			$visible_forums++;
			$forum_id = $row['forum_id'];

			$forum_unread = (isset($forum_tracking_info[$forum_id]) && $row['orig_forum_last_post_time'] > $forum_tracking_info[$forum_id]) ? true : false;

			$folder_alt = '';
			$subforums_list = array();

			$forum_icon		= ($forum_unread) ? 'blg-icon-folder' : 'blg-icon-folder-open';
			$folder_image	= '';
			$last_post_subject = $last_post_time = $last_post_url = '';

			// Generate list of subforums if we need to
			if(isset($subforums[$forum_id]))
			{
				foreach($subforums[$forum_id] as $subforum_id => $subforum_row)
				{
					$subforum_unread = (isset($forum_tracking_info[$subforum_id]) && $subforum_row['orig_forum_last_post_time'] > $forum_tracking_info[$subforum_id]) ? true : false;

					if(!$subforum_unread && !empty($subforum_row['children']))
					{
						foreach ($subforum_row['children'] as $child_id)
						{
							if(isset($forum_tracking_info[$child_id]) && $subforums[$forum_id][$child_id]['orig_forum_last_post_time'] > $forum_tracking_info[$child_id])
							{
								// Once we found an unread child forum, we can drop out of this loop
								$subforum_unread = true;
								break;
							}
						}
					}
					
					if($subforum_row['display'] && $subforum_row['name'])
					{
						$subforums_list[] = array(
							'link'		=> $this->helper->url('viewforum', 'f=' . $subforum_id),
							'name'		=> $subforum_row['name'],
							'unread'	=> $subforum_unread,
						);
					}
					else
					{
						unset($subforums[$forum_id][$subforum_id]);
					}

					// If one subforum is unread the forum gets unread too...
					if($subforum_unread)
					{
						$forum_unread = true;
					}
					
					$l_subforums = (sizeof($subforums[$forum_id]) == 1) ? $this->lang->get('SUBFORUM') . ': ' : $this->lang->get('SUBFORUMS') . ': ';
					$folder_image = ($forum_unread) ? 'forum_unread_subforum' : 'forum_read_subforum';
				}
			}
			else
			{
				switch($row['forum_type'])
				{
					case FORUM_POST:
						$folder_image = ($forum_unread) ? 'forum_unread' : 'forum_read';
					break;

					case FORUM_LINK:
						$folder_image	= 'forum_link';
						$forum_icon		= 'blg-icon-link';
					break;
				}
			}

			// Which folder should we display?
			if($row['forum_status'] == ITEM_LOCKED)
			{
				$folder_image = ($forum_unread) ? 'forum_unread_locked' : 'forum_read_locked';
				$folder_alt = 'FORUM_LOCKED';
			}
			else
			{
				$folder_alt = ($forum_unread) ? 'UNREAD_POSTS' : 'NO_UNREAD_POSTS';
			}
			
			// Create last post link information, if appropriate
			if($row['forum_last_post_id'])
			{
				$last_post_subject	= str_replace('Re: ', '', $row['forum_last_post_subject']);
				$last_post_time		= $this->user->format_date($row['forum_last_post_time']);
				$last_post_url		= $this->helper->url('viewtopic', array(
					'f'	=> $row['forum_id_last_post'],
					'p'	=> $row['forum_last_post_id'],
					'#'	=> 'p' . $row['forum_last_post_id'],
				));
			}
			
			$l_post_click_count	= ($row['forum_type'] == FORUM_LINK) ? 'CLICKS' : 'POSTS';
			$post_click_count	= ($row['forum_type'] != FORUM_LINK || $row['forum_flags'] & FORUM_FLAG_LINK_TRACK) ? $row['forum_posts'] : '';
			
			$s_subforums_list = array();
			foreach($subforums_list as $subforum)
			{
				$s_subforums_list[] = '<a href="' . $subforum['link'] . '" class="subforum ' . (($subforum['unread']) ? 'unread' : 'read') . '" title="' . (($subforum['unread']) ? $this->lang->get('UNREAD_POSTS') : $this->lang->get('NO_UNREAD_POSTS')) . '">' . $subforum['name'] . '</a>';
			}
			$s_subforums_list = (string) implode(', ', $s_subforums_list);

			$catless = ($row['parent_id'] == $data['forum_id']) ? true : false;

			if($row['forum_type'] != FORUM_LINK)
			{
				$u_viewforum = $this->helper->url('viewforum', 'f=' . $row['forum_id']);
			}
			else
			{
				// If the forum is a link and we count redirects we need to visit it
				// If the forum is having a password or no read access we do not expose the link, but instead handle it in viewforum
				if(($row['forum_flags'] & FORUM_FLAG_LINK_TRACK) || $row['forum_password'] || !$this->auth->acl_get('f_read', $forum_id))
				{
					$u_viewforum = $this->helper->url('viewforum', 'f=' . $row['forum_id']);
				}
				else
				{
					$u_viewforum = $row['forum_link'];
				}
			}

			$forum_row = array(
				'S_IS_CAT'			=> false,
				'S_NO_CAT'			=> $catless && !$last_catless,
				'S_IS_LINK'			=> ($row['forum_type'] == FORUM_LINK) ? true : false,
				'S_LIST_SUBFORUMS'	=> ($row['display_subforum_list']) ? true : false,
				'SUBFORUMS'			=> $s_subforums_list,

				'L_SUBFORUM_STR'	=> (!empty($l_subforums) ? $l_subforums : ''),
				
				'FORUM_DESC'			=> generate_text_for_display($row['forum_desc'], $row['forum_desc_uid'], $row['forum_desc_bitfield'], $row['forum_desc_options']),
				'FORUM_ID'				=> $row['forum_id'],
				'FORUM_NAME'			=> $row['forum_name'],
				'FORUM_ICON'			=> $forum_icon,
				'FORUM_IMG_STYLE'		=> $folder_image,
				'LAST_POST_SUBJECT'		=> censor_text($last_post_subject),
				'LAST_POST_TIME'		=> $last_post_time,
				'LAST_POSTER_FULL'		=> get_username_string('full', $row['forum_last_poster_id'], $row['forum_last_poster_name'], $row['forum_last_poster_colour']),

				$l_post_click_count		=> $post_click_count,
				'TOPICS'				=> $row['forum_topics'],
				
				'U_LAST_POST'		=> $last_post_url,
				'U_VIEWFORUM'		=> $u_viewforum,
			);

			/**
			* @event block.forums_row_item
			* @var array	forum_row		The output array
			* @var array	row				The original data
			* @since 2.0.0
			*/
			$vars = array('forum_row', 'row');
			extract($this->dispatcher->trigger_event('block.forums_row_item', compact($vars)));
			
			$this->template->assign_block_vars('forum_row', $forum_row);

			$last_catless = $catless;
		}

		return true;
	}

	public function get_config()
	{
		$this->display_vars = array(
			'forum_id'	=> array('lang' => 'FORUMS_FORUM',	'validate' => 'int',	'type' => 'select',	'function' => array($this, 'make_forum_select'),	'params' => array('{CONFIG_VALUE}'),	'default' => 0),
		);

		return true;
	}
	
	public function make_forum_select($select_id = false)
	{
		global $user;

		$result = '';
		
		$forum_ary = array(
			array(
				'padding'		=> '',
				'selected'		=> (empty($select_id) ? true : false),
				'forum_id'		=> 0,
				'forum_name'	=> $this->lang->get('ALL_FORUMS'),
				'forum_type'	=> 0,
			)
		);
		
		$forum_ary =  array_merge($forum_ary, make_forum_select($select_id, false, true, false, true, false, true));

		foreach($forum_ary as $row)
		{
			if($row['forum_type'] == FORUM_LINK)
			{
				continue;
			}

			$selected = ($row['selected']) ? ' selected="selected"' : '';
			$result .= '<option value="' . $row['forum_id'] . '"' . $selected . '>' . $row['padding'] . $row['forum_name'] . '</option>';
		}
		
		return $result;
	}
}
