<?php
/**
*
* Bookmark Post
* @copyright (c) 2016 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\bookmarkpost\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

class main_listener implements EventSubscriberInterface
{
	static public function getSubscribedEvents()
	{
		return array(
			'core.user_setup'					=> 'load_language_on_setup',
			'core.delete_user_after'			=> 'delete_users',

			'core.viewtopic_get_post_data'		=> 'add_bookmark_post_info',
			'core.viewtopic_post_rowset_data'	=> 'add_bookmark_post_rowset',
			'core.viewtopic_modify_post_row'	=> 'add_bookmark_post_url',
			'core.viewtopic_modify_post_data'	=> 'add_bookmarked_posts_count',

			'core.display_forums_modify_sql'			=> 'bookmarked_post_index_sql',
			'core.display_forums_modify_forum_rows'		=> 'bookmarked_post_index_subforums',
			'core.display_forums_modify_template_vars'	=> 'bookmarked_post_index_template',

			'core.viewforum_get_topic_data'		=> 'bookmarked_post_viewforum_sql',
			'core.viewforum_modify_topicrow'	=> 'bookmarked_post_viewforum_template',
		);
	}

	protected $template;
	protected $user;
	protected $request;
	protected $db;
	protected $auth;
	protected $controller_helper;
	protected $posts_table;
	protected $post_bookmarks_table;
	protected $root_path;
	protected $php_ext;

	public function __construct(\phpbb\template\template $template, \phpbb\user $user, \phpbb\request\request $request, \phpbb\db\driver\driver_interface $db, \phpbb\auth\auth $auth, \phpbb\controller\helper $controller_helper, $posts_table, $post_bookmarks_table, $root_path, $php_ext)
	{
		$this->template = $template;
		$this->user = $user;
		$this->request = $request;
		$this->db = $db;
		$this->auth = $auth;
		$this->controller_helper = $controller_helper;
		$this->posts_table = $posts_table;
		$this->post_bookmarks_table = $post_bookmarks_table;
		$this->root_path = $root_path;
		$this->php_ext = $php_ext;
	}

	public function load_language_on_setup($event)
	{
		$lang_set_ext = $event['lang_set_ext'];
		$lang_set_ext[] = array(
			'ext_name' => 'sitesplat/bookmarkpost',
			'lang_set' => 'common',
		);
		$event['lang_set_ext'] = $lang_set_ext;
	}

	public function add_bookmark_post_info($event)
	{
		$sql_ary = $event['sql_ary'];

		$sql_ary['SELECT'] = $sql_ary['SELECT'] . ', pb.post_id as post_bookmark';
		$sql_ary['LEFT_JOIN'][] = array(
			'FROM'	=> array($this->post_bookmarks_table => 'pb'),
			'ON'	=> 'pb.post_id = p.post_id AND pb.user_id = ' . $this->user->data['user_id'],
		);

		$event['sql_ary'] = $sql_ary;
	}

	public function add_bookmark_post_rowset($event)
	{
		$rowset_data = $event['rowset_data'];
		$rowset_data['post_bookmark'] = $event['row']['post_bookmark'];
		$event['rowset_data'] = $rowset_data;
	}

	public function add_bookmark_post_url($event)
	{
		$post_row = $event['post_row'];

		$command = 'bookmark';
		if (!empty($event['row']['post_bookmark']))
		{
			$command = 'unbookmark';
		}

		$post_row['S_BOOKMARKED_POST'] = !empty($event['row']['post_bookmark']) ? true : false;
		$post_row['L_BOOKMARK_POST'] = ($command == 'bookmark') ? $this->user->lang('BOOKMARK_POST') : $this->user->lang('UNBOOKMARK_POST');
		$post_row['U_POST_BOOKMARK'] = $this->controller_helper->route('sitesplat_bookmarkpost_controller_' . $command, array('post_id' => $event['row']['post_id']));

		$event['post_row'] = $post_row;
	}

	public function add_bookmarked_posts_count($event)
	{
		$bookmarked_posts = 0;
		foreach($event['rowset'] as $post)
		{
			if (!empty($post['post_bookmark']))
			{
				$bookmarked_posts++;
			}
		}

		$this->template->assign_var('TOPIC_BOOKMARKED_POSTS', $bookmarked_posts);
	}

	public function bookmarked_post_index_sql($event)
	{
		$sql_ary = $event['sql_ary'];

		$sql_ary['SELECT'] .= ', (
			SELECT COUNT(p.post_id)
			FROM ' . $this->posts_table . ' p
			WHERE p.forum_id = f.forum_id
				AND p.post_id IN (
					SELECT pb.post_id
					FROM ' . $this->post_bookmarks_table . ' pb
					WHERE user_id = ' . $this->user->data['user_id'] . '
				)
		) as bookmarked_posts';

		$event['sql_ary'] = $sql_ary;
	}

	public function bookmarked_post_index_subforums($event)
	{
		$forum_rows = $event['forum_rows'];

		if ($event['row']['forum_id'] != $forum_rows[$event['parent_id']]['forum_id'])
		{
			$forum_rows[$event['parent_id']]['bookmarked_posts'] += $event['row']['bookmarked_posts'];
		}

		$event['forum_rows'] = $forum_rows;
	}

	public function bookmarked_post_index_template($event)
	{
		$forum_row = $event['forum_row'];
		$forum_row['BOOKMARKED_POSTS'] = $event['row']['bookmarked_posts'];
		$event['forum_row'] = $forum_row;
	}

	public function bookmarked_post_viewforum_sql($event)
	{
		$sql_array = $event['sql_array'];

		$sql_array['SELECT'] .= ', (
			SELECT COUNT(p.post_id)
			FROM ' . $this->posts_table . ' p
			WHERE p.topic_id = t.topic_id
				AND p.post_id IN (
					SELECT pb.post_id
					FROM ' . $this->post_bookmarks_table . ' pb
					WHERE user_id = ' . $this->user->data['user_id'] . '
				)
		) as bookmarked_posts';

		$event['sql_array'] = $sql_array;
	}

	public function bookmarked_post_viewforum_template($event)
	{
		$topic_row = $event['topic_row'];

		$topic_row['TOPIC_BOOKMARKED_POSTS'] = $event['row']['bookmarked_posts'];

		$event['topic_row'] = $topic_row;
	}

	public function delete_users($event)
	{
		if (!empty($event['user_ids'])) {
			$user_id_in = is_array($event['user_ids']) ? 'IN (' . implode(',', $event['user_ids']) . ')' : "= {$event['user_ids']}";

			$this->db->sql_query("DELETE FROM {$this->post_bookmarks_table } WHERE user_id $user_id_in");
		}
	}
}
