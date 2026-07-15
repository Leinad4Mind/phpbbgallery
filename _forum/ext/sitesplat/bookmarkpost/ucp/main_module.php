<?php
/**
*
* Bookmark Post
*
* @copyright (c) 2016 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\bookmarkpost\ucp;

class main_module
{
	var $u_action;

	function main($id, $mode)
	{
		global $db, $request, $template, $user, $cache, $phpbb_container, $config;
		global $table_prefix, $phpbb_root_path, $phpEx;

		$this->tpl_name = 'ucp_post_bookmarks';
		$this->page_title = $user->lang('UCP_POST_BOOKMARKS_TITLE');
		add_form_key('sitesplat/bookmarkpost');

		$user->add_lang('viewtopic');

		if ($request->is_set_post('unbookmark'))
		{
			$s_hidden_fields = array('unbookmark' => 1);
			$posts = ($request->is_set_post('p')) ? array_keys($request->variable('p', array(0 => 0))) : array();
			$url = $this->u_action;

			if (!sizeof($posts))
			{
				trigger_error('NO_BOOKMARKS_SELECTED');
			}

			foreach ($posts as $post_id)
			{
				$s_hidden_fields['p'][$post_id] = 1;
			}

			if (confirm_box(true))
			{
				$sql = 'DELETE FROM ' . $table_prefix . 'post_bookmarks
					WHERE user_id = ' . $user->data['user_id'] . '
						AND ' . $db->sql_in_set('post_id', $posts);
				$db->sql_query($sql);

				meta_refresh(3, $url);
				$message = $user->lang['BOOKMARKS_REMOVED'] . '<br /><br />' . sprintf($user->lang['RETURN_UCP'], '<a href="' . $url . '">', '</a>');
				trigger_error($message);
			}
			else
			{
				confirm_box(false, 'REMOVE_SELECTED_BOOKMARKS', build_hidden_fields($s_hidden_fields));
			}
		}

		$start	= $request->variable('start', 0);

		$icons = $cache->obtain_icons();

		$phpbb_content_visibility = $phpbb_container->get('content.visibility');
		$pagination = $phpbb_container->get('pagination');

		$sql = 'SELECT COUNT(pb.post_id) AS num_posts
				FROM ' . $table_prefix . 'post_bookmarks pb, ' . POSTS_TABLE . ' p
				WHERE user_id = ' . $user->data['user_id'] . '
					AND pb.post_id = p.post_id
					AND ' . $phpbb_content_visibility->get_visibility_sql('post', 0);
		$result = $db->sql_query($sql);
		$total_posts = (int) $db->sql_fetchfield('num_posts');
		$db->sql_freeresult($result);

		// Make sure $start is set to the last page if it exceeds the amount
		$start = $pagination->validate_start($start, $config['posts_per_page'], $total_posts);

		$sql = 'SELECT p.*, u.username, u.user_colour, u.user_avatar as avatar, u.user_avatar_width as avatar_width, u.user_avatar_height as avatar_height, u.user_avatar_type as avatar_type
				FROM ' . $table_prefix . 'post_bookmarks pb, ' . POSTS_TABLE . ' p, ' . USERS_TABLE . ' u
				WHERE pb.user_id = ' . $user->data['user_id'] . '
					AND pb.post_id = p.post_id
					AND p.poster_id = u.user_id
					AND ' . $phpbb_content_visibility->get_visibility_sql('post', 0);
		$result = $db->sql_query_limit($sql, $config['posts_per_page'], $start);
		while($row = $db->sql_fetchrow($result))
		{
			// make sure icon exists
			$row['icon_id'] = (isset($icons[$row['icon_id']]['img'], $icons[$row['icon_id']]['height'], $icons[$row['icon_id']]['width'])) ? $row['icon_id'] : 0;

			$template->assign_block_vars('postrow', array(
				'POST_ID'			=> $row['post_id'],
				'ICON_IMG'			=> ($row['icon_id']) ? $icons[$row['icon_id']]['img'] : '',
				'ICON_IMG_WIDTH'	=> ($row['icon_id']) ? $icons[$row['icon_id']]['width'] : '',
				'ICON_IMG_HEIGHT'	=> ($row['icon_id']) ? $icons[$row['icon_id']]['height'] : '',
				'SUBJECT'			=> $row['post_subject'],
				'POSTER_AVATAR'		=> phpbb_get_user_avatar($row),
				'U_POST_AUTHOR'		=> get_username_string('profile', $row['poster_id'], $row['username'], $row['user_colour'], $row['post_username']),
				'U_POST'			=> append_sid("{$phpbb_root_path}viewtopic.$phpEx", "f={$row['forum_id']}&amp;t={$row['topic_id']}&amp;p={$row['post_id']}#p{$row['post_id']}"),
				'AUTHOR'			=> get_username_string('full', $row['poster_id'], $row['username'], $row['user_colour'], $row['post_username']),
				'DATE'				=> $user->format_date($row['post_time']),
			));
		}
		$db->sql_freeresult($result);

		$pagination->generate_template_pagination($this->u_action, 'pagination', 'start', $total_posts, $config['posts_per_page'], $start);
		$template->assign_vars(array(
			'PAGE_NUMBER'	=> $pagination->on_page($total_posts, $config['posts_per_page'], $start),
			'TOTAL_POSTS'	=> $user->lang('VIEW_TOPIC_POSTS', (int) $total_posts),
		));
	}
}
