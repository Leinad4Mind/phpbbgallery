<?php
/**
 *
 * Best Answer extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2018, kinerity, https://www.layer-3.org/
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace kinerity\bestanswer\event;

/**
 * @ignore
 */
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Best Answer event listener
 */
class main_listener implements EventSubscriberInterface
{
	/* @var \phpbb\auth\auth */
	protected $auth;

	/* @var \phpbb\db\driver\driver_interface */
	protected $db;

	/* @var \phpbb\controller\helper */
	protected $helper;

	/* @var \phpbb\request\request */
	protected $request;

	/* @var \phpbb\template\template */
	protected $template;

	/* @var \phpbb\user */
	protected $user;

	/* @var string */
	protected $root_path;

	/* @var string */
	protected $php_ext;

	/* @var array */
	private $answer = array();

	/**
	 * Constructor
	 *
	 * @param \phpbb\auth\auth                    $auth
	 * @param \phpbb\db\driver\driver_interface   $db
	 * @param \phpbb\controller\helper            $helper
	 * @param \phpbb\request\request              $request
	 * @param \phpbb\template\template            $template
	 * @param \phpbb\user                         $user
	 * @param string                              $root_path
	 * @param string                              $php_ext
	 */
	public function __construct(\phpbb\auth\auth $auth, \phpbb\db\driver\driver_interface $db, \phpbb\controller\helper $helper, \phpbb\request\request $request, \phpbb\template\template $template, \phpbb\user $user, $root_path, $php_ext)
	{
		$this->auth = $auth;
		$this->db = $db;
		$this->helper = $helper;
		$this->request = $request;
		$this->template = $template;
		$this->user = $user;
		$this->root_path = $root_path;
		$this->php_ext = $php_ext;
	}

	static public function getSubscribedEvents()
	{
		return array(
			'core.acp_manage_forums_display_form'		=> 'acp_manage_forums_display_form',
			'core.acp_manage_forums_initialise_data'	=> 'acp_manage_forums_initialise_data',
			'core.acp_manage_forums_request_data'		=> 'acp_manage_forums_request_data',

			'core.delete_posts_in_transaction_before'	=> 'delete_posts_in_transaction_before',
			'core.delete_topics_before_query'			=> 'delete_topics_before_query',
			'core.display_forums_modify_forum_rows'		=> 'display_forums_modify_forum_rows',
			'core.display_forums_modify_sql'			=> 'display_forums_modify_sql',
			'core.display_forums_modify_template_vars'	=> 'display_forums_modify_template_vars',

			'core.mcp_change_poster_after'			=> 'mcp_change_poster_after',
			'core.mcp_topic_modify_post_data'		=> 'mcp_topic_modify_post_data',
			'core.mcp_topic_review_modify_row'		=> 'mcp_topic_review_modify_row',
			'core.mcp_view_forum_modify_topicrow'	=> 'mcp_view_forum_modify_topicrow',
			'core.memberlist_view_profile'			=> 'memberlist_view_profile',

			'core.permissions'	=> 'permissions',

			'core.search_modify_tpl_ary'		=> 'modify_topicrow_tpl_ary',
			'core.set_post_visibility_after'	=> 'set_post_visibility_after',
			'core.set_topic_visibility_after'	=> 'set_topic_visibility_after',

			'core.ucp_pm_view_message'	=> 'ucp_pm_view_message',
			'core.user_setup'			=> 'user_setup',

			'core.viewforum_modify_topicrow'				=> 'modify_topicrow_tpl_ary',
			'core.viewtopic_assign_template_vars_before'	=> 'viewtopic_assign_template_vars_before',
			'core.viewtopic_cache_user_data'				=> 'viewtopic_cache_user_data',
			'core.viewtopic_get_post_data'					=> 'viewtopic_get_post_data',
			'core.viewtopic_modify_post_row'				=> 'viewtopic_modify_post_row',
		);
	}

	public function acp_manage_forums_display_form($event)
	{
		$event->update_subarray('template_data', 'S_ENABLE_ANSWER', $event['forum_data']['enable_answer']);
	}

	public function acp_manage_forums_initialise_data($event)
	{
		if ($event['action'] == 'add')
		{
			$event->update_subarray('forum_data', 'enable_answer', false);
		}
	}

	public function acp_manage_forums_request_data($event)
	{
		$event->update_subarray('forum_data', 'enable_answer', $this->request->variable('enable_answer', 0));
	}

	public function delete_posts_in_transaction_before($event)
	{
		$post_ids = $event['post_ids'];
		$topic_ids = $event['topic_ids'];
		$answer_post_ids = $answer_user_ids = array();

		// Only query topics with answers
		$sql = 'SELECT answer_post_id, answer_user_id
			FROM ' . TOPICS_TABLE . '
			WHERE ' . $this->db->sql_in_set('topic_id', $topic_ids) . '
				AND answer_post_id <> 0';
		$result = $this->db->sql_query($sql);
		while ($row = $this->db->sql_fetchrow($result))
		{
			if (in_array($row['answer_post_id'], $post_ids))
			{
				$answer_post_ids[] = $row['answer_post_id'];
				$answer_user_ids[] = $row['answer_user_id'];
			}
		}
		$this->db->sql_freeresult($result);

		$data = array(
			'answer_post_id'	=> 0,
			'answer_user_id'	=> 0,
		);

		if ($answer_post_ids)
		{
			$sql = 'UPDATE ' . TOPICS_TABLE . ' SET ' . $this->db->sql_build_array('UPDATE', $data) . ' WHERE ' . $this->db->sql_in_set('answer_post_id', $answer_post_ids);
			$this->db->sql_query($sql);

			$sql = 'UPDATE ' . USERS_TABLE . '
				SET user_answers = user_answers - 1
				WHERE ' . $this->db->sql_in_set('user_id', $answer_user_ids, false, true);
			$this->db->sql_query($sql);
		}
	}

	public function delete_topics_before_query($event)
	{
		$topic_ids = $event['topic_ids'];
		$answer_user_ids = array();

		$sql = 'SELECT answer_user_id
			FROM ' . TOPICS_TABLE . '
			WHERE ' . $this->db->sql_in_set('topic_id', $topic_ids);
		$result = $this->db->sql_query($sql);
		while ($row = $this->db->sql_fetchrow($result))
		{
			$answer_user_ids[] = $row['answer_user_id'];
		}
		$this->db->sql_freeresult($result);

		$sql = 'UPDATE ' . USERS_TABLE . '
			SET user_answers = user_answers - 1
			WHERE ' . $this->db->sql_in_set('user_id', $answer_user_ids, false, true);
		$this->db->sql_query($sql);
	}

	public function display_forums_modify_forum_rows($event)
	{
		$forum_rows = $event['forum_rows'];
		$parent_id = $event['parent_id'];
		$row = $event['row'];

		// Suggested by the core, equal post times should never happen. Check it just in case.
		if ($row['forum_last_post_time'] >= $forum_rows[$parent_id]['forum_last_post_time'])
		{
			$forum_rows[$parent_id]['answer_post_id'] = $row['answer_post_id'];

			// Is the extension enabled on the forum and related answer_post_id not null?
			if ($row['enable_answer'] && !($forum_rows[$parent_id]['answer_post_id'] === false))
			{
				$forum_rows[$parent_id]['answer_post_id'] = $row['answer_post_id'];
			}
		}

		$event['forum_rows'] = $forum_rows;
	}

	public function display_forums_modify_sql($event)
	{
		$sql_ary = $event['sql_ary'];

		$sql_ary['SELECT'] .= ', a_t.answer_post_id';

		$sql_ary['LEFT_JOIN'][] = array(
			'FROM'	=> array(POSTS_TABLE => 'a_p'),
			'ON'	=> 'f.forum_last_post_id = a_p.post_id',
		);

		$sql_ary['LEFT_JOIN'][] = array(
			'FROM'	=> array(TOPICS_TABLE => 'a_t'),
			'ON'	=> 'a_t.topic_id = a_p.topic_id',
		);

		$event['sql_ary'] = $sql_ary;
	}

	public function display_forums_modify_template_vars($event)
	{
		$row = $event['row'];

		// Add the template switch for viewforum
		$forum_row = array_merge($event['forum_row'], array(
			'S_ANSWERED'	=> $row['answer_post_id'] ? true : false,
		));

		$event['forum_row'] = $forum_row;
	}

	public function mcp_change_poster_after($event)
	{
		$userdata = $event['userdata'];
		$post_info = $event['post_info'];

		// Query the topic table to update answer counts
		$sql = 'SELECT answer_post_id
			FROM ' . TOPICS_TABLE . '
			WHERE topic_id = ' . (int) $post_info['topic_id'];
		$result = $this->db->sql_query($sql);
		$answer_post_id = (int) $this->db->sql_fetchfield('answer_post_id');
		$this->db->sql_freeresult($result);

		// Update the answer counts
		if ($answer_post_id == $post_info['post_id'])
		{
			$sql = 'UPDATE ' . USERS_TABLE . '
				SET user_answers = user_answers - 1
				WHERE user_id = ' . (int) $post_info['user_id'];
			$this->db->sql_query($sql);

			$sql = 'UPDATE ' . USERS_TABLE . '
				SET user_answers = user_answers + 1
				WHERE user_id = ' . (int) $userdata['user_id'];
			$this->db->sql_query($sql);

			$sql = 'UPDATE ' . TOPICS_TABLE . '
				SET answer_user_id = ' . (int) $userdata['user_id'] . '
				WHERE answer_post_id = ' . (int) $answer_post_id;
			$this->db->sql_query($sql);
		}
	}

	public function mcp_topic_modify_post_data($event)
	{
		$topic_id = $event['topic_id'];

		$sql = 'SELECT answer_post_id
			FROM ' . TOPICS_TABLE . '
			WHERE topic_id = ' . (int) $topic_id;
		$result = $this->db->sql_query($sql);
		$answer_post_id = (int) $this->db->sql_fetchfield('answer_post_id');
		$this->db->sql_freeresult($result);

		// Only run this query if the topic has a best answer
		if (!empty($answer_post_id))
		{
			$sql = 'SELECT p.*, u.user_id, u.username, u.user_colour
				FROM ' . POSTS_TABLE . ' p, ' . USERS_TABLE . ' u
				WHERE p.post_id = ' . (int) $answer_post_id . '
					AND p.poster_id = u.user_id';
			$result = $this->db->sql_query($sql);
			while ($row = $this->db->sql_fetchrow($result))
			{
				$bbcode_options = (($row['enable_bbcode']) ? OPTION_FLAG_BBCODE : 0) +
					(($row['enable_smilies']) ? OPTION_FLAG_SMILIES : 0) +
					(($row['enable_magic_url']) ? OPTION_FLAG_LINKS : 0);
				$this->answer['POST_TEXT'] = generate_text_for_display($row['post_text'], $row['bbcode_uid'], $row['bbcode_bitfield'], $bbcode_options);
				$this->answer['USERNAME_FULL'] = get_username_string('full', $row['user_id'], $row['username'], $row['user_colour']);
				$this->answer['POST_TIME'] = $this->user->format_date($row['post_time']);
			}
			$this->db->sql_freeresult($result);
		}

		$this->template->assign_vars(array(
			'S_ANSWERED'	=> $answer_post_id ? true : false,
		));
	}

	public function mcp_topic_review_modify_row($event)
	{
		$row = $event['row'];
		$post_row = $event['post_row'];
		$topic_info = $event['topic_info'];

		// Does the topic have a best answer and is the post the first post in a topic
		if ($this->answer && ($topic_info['topic_first_post_id'] == $row['post_id']))
		{
			$post_row = array_merge($post_row, array(
				'U_ANSWER'	=> append_sid("{$this->root_path}viewtopic.{$this->php_ext}", 'p=' . (int) $topic_info['answer_post_id'] . '#p' . (int) $topic_info['answer_post_id']),

				'ANSWER_POST_TEXT'	=> $this->answer['POST_TEXT'],
				'ANSWER_USERNAME_FULL'	=> $this->answer['USERNAME_FULL'],
				'ANSWER_POST_TIME'	=> $this->answer['POST_TIME'],
			));
		}

		$post_row = array_merge($post_row, array(
			'ANSWER_POST_ID'	=> (int) $topic_info['answer_post_id'],

			'S_FIRST_POST'	=> $topic_info['topic_first_post_id'] == $row['post_id'] ? true : false,
		));

		$event['post_row'] = $post_row;
	}

	public function mcp_view_forum_modify_topicrow($event)
	{
		$row = $event['row'];

		$topic_row = array_merge($event['topic_row'], array(
			'S_ANSWERED'	=> $row['answer_post_id'] ? true : false,
		));

		$event['topic_row'] = $topic_row;
	}

	public function memberlist_view_profile($event)
	{
		$this->template->assign_vars(array(
			'ANSWERS'	=> $event['member']['user_answers'],
		));
	}

	public function modify_topicrow_tpl_ary($event)
	{
		$block = $event['topic_row'] ? 'topic_row' : 'tpl_ary';
		$event[$block] = $this->modify_topicrow_tpl($event['row'], $event[$block]);
	}

	public function permissions($event)
	{
		$permissions = array_merge($event['permissions'], array(
			'f_mark_answer'	=> array('lang' => 'ACL_F_MARK_ANSWER', 'cat' => 'actions'),
			'm_mark_answer'	=> array('lang' => 'ACL_M_MARK_ANSWER', 'cat' => 'post_actions'),
		));

		$event['permissions'] = $permissions;
	}

	public function set_post_visibility_after($event)
	{
		$visibility = $event['visibility'];
		$post_id = $event['post_id'];
		$topic_id = $event['topic_id'];

		if ($visibility == ITEM_DELETED)
		{
			$sql = 'SELECT answer_post_id, answer_user_id
				FROM ' . TOPICS_TABLE . '
				WHERE topic_id = ' . (int) $topic_id;
			$result = $this->db->sql_query($sql);
			$row = $this->db->sql_fetchrow($result);
			$this->db->sql_freeresult($result);

			if ((is_array($post_id) && in_array((int) $row['answer_post_id'], $post_id)) || (int) $row['answer_post_id'] = $post_id)
			{
				$data = array(
					'answer_post_id'	=> 0,
					'answer_user_id'	=> 0,
				);

				$sql = 'UPDATE ' . TOPICS_TABLE . ' SET ' . $this->db->sql_build_array('UPDATE', $data) . ' WHERE topic_id = ' . (int) $topic_id;
				$this->db->sql_query($sql);

				$sql = 'UPDATE ' . USERS_TABLE . '
					SET user_answers = user_answers - 1
					WHERE user_id = ' . (int) $row['answer_user_id'];
				$this->db->sql_query($sql);
			}
		}
	}

	public function set_topic_visibility_after($event)
	{
		$visibility = $event['visibility'];
		$topic_id = $event['topic_id'];

		if ($visibility == ITEM_DELETED)
		{
			$sql = 'SELECT answer_user_id
				FROM ' . TOPICS_TABLE . '
				WHERE topic_id = ' . (int) $topic_id;
			$result = $this->db->sql_query($sql);
			$answer_user_id = (int) $this->db->sql_fetchfield('answer_user_id');
			$this->db->sql_freeresult($result);

			// Only update the tables if valid answer_user_id
			if (!empty($answer_user_id))
			{
				$data = array(
					'answer_post_id'	=> 0,
					'answer_user_id'	=> 0,
				);

				$sql = 'UPDATE ' . TOPICS_TABLE . ' SET ' . $this->db->sql_build_array('UPDATE', $data) . ' WHERE topic_id = ' . (int) $topic_id;
				$this->db->sql_query($sql);

				$sql = 'UPDATE ' . USERS_TABLE . '
					SET user_answers = user_answers - 1
					WHERE user_id = ' . (int) $answer_user_id;
				$this->db->sql_query($sql);
			}
		}
	}

	public function ucp_pm_view_message($event)
	{
		$msg_data = array_merge($event['msg_data'], array(
			'AUTHOR_ANSWERS'	=> (int) $event['user_info']['user_answers'],
		));

		$event['msg_data'] = $msg_data;
	}

	public function user_setup($event)
	{
		$lang_set_ext = $event['lang_set_ext'];
		$lang_set_ext[] = array(
			'ext_name' => 'kinerity/bestanswer',
			'lang_set' => 'common',
		);
		$event['lang_set_ext'] = $lang_set_ext;
	}

	public function viewtopic_assign_template_vars_before($event)
	{
		$topic_data = $event['topic_data'];

		$this->template->assign_vars(array(
			'S_ANSWERED'	=> $topic_data['answer_post_id'] ? true : false,
		));
	}

	public function viewtopic_cache_user_data($event)
	{
		$user_cache_data = $event['user_cache_data'];
		$row = $event['row'];

		$user_cache_data['poster_answers'] = (int) $row['user_answers'];

		$event['user_cache_data'] = $user_cache_data;
	}

	public function viewtopic_get_post_data($event)
	{
		$topic_data = $event['topic_data'];

		// Only run this query if the topic has a best answer
		if (!empty($topic_data['answer_post_id']))
		{
			$sql = 'SELECT p.*, u.user_id, u.username, u.user_colour
				FROM ' . POSTS_TABLE . ' p, ' . USERS_TABLE . ' u
				WHERE p.post_id = ' . (int) $topic_data['answer_post_id'] . '
					AND p.poster_id = u.user_id';
			$result = $this->db->sql_query($sql);
			while ($row = $this->db->sql_fetchrow($result))
			{
				$bbcode_options = (($row['enable_bbcode']) ? OPTION_FLAG_BBCODE : 0) +
					(($row['enable_smilies']) ? OPTION_FLAG_SMILIES : 0) +
					(($row['enable_magic_url']) ? OPTION_FLAG_LINKS : 0);
				$this->answer['POST_TEXT'] = generate_text_for_display($row['post_text'], $row['bbcode_uid'], $row['bbcode_bitfield'], $bbcode_options);
				$this->answer['USERNAME_FULL'] = get_username_string('full', $row['user_id'], $row['username'], $row['user_colour']);
				$this->answer['POST_TIME'] = $this->user->format_date($row['post_time']);
			}
			$this->db->sql_freeresult($result);
		}
	}

	public function viewtopic_modify_post_row($event)
	{
		$row = $event['row'];
		$user_poster_data = $event['user_poster_data'];
		$post_row = $event['post_row'];
		$topic_data = $event['topic_data'];

		$post_row = array_merge($post_row, array(
			'ANSWER_POST_ID'	=> (int) $topic_data['answer_post_id'],
			'POSTER_ANSWERS'	=> $user_poster_data['poster_answers'],

			'U_ANSWER'			=> append_sid("{$this->root_path}viewtopic.{$this->php_ext}", 'p=' . (int) $topic_data['answer_post_id'] . '#p' . (int) $topic_data['answer_post_id']),
			'U_MARK_ANSWER'		=> $topic_data['enable_answer'] ? $this->helper->route('kinerity_bestanswer_controller', array('action' => 'mark_answer', 'p' => (int) $row['post_id'])) : '',
			'U_UNMARK_ANSWER'	=> $topic_data['enable_answer'] ? $this->helper->route('kinerity_bestanswer_controller', array('action' => 'unmark_answer', 'p' => (int) $row['post_id'])) : '',

			'S_ANSWER'		=> $topic_data['enable_answer'] ? true : false,
			'S_AUTH'		=> $topic_data['topic_status'] == ITEM_LOCKED && !$this->auth->acl_get('m_mark_answer', (int) $topic_data['forum_id']) ? false : ($this->auth->acl_get('m_mark_answer', (int) $topic_data['forum_id']) || ($this->auth->acl_get('f_mark_answer', (int) $topic_data['forum_id']) && $topic_data['topic_poster'] == $this->user->data['user_id']) ? true : false),
			'S_FIRST_POST'	=> $topic_data['topic_first_post_id'] == $row['post_id'] ? true : false,
		));

		// Only add to post_row array if an answer_post_id is supplied and the post_id is the first post in a topic
		if ($this->answer && ($topic_data['topic_first_post_id'] == $row['post_id']))
		{
			$post_row = array_merge($post_row, array(
				'ANSWER_POST_TEXT'		=> $this->answer['POST_TEXT'],
				'ANSWER_USERNAME_FULL'	=> $this->answer['USERNAME_FULL'],
				'ANSWER_POST_TIME'		=> $this->answer['POST_TIME'],
			));
		}

		$event['post_row'] = $post_row;
	}

	private function modify_topicrow_tpl($row, $block)
	{
		$block = array_merge($block, array(
			'S_ANSWERED'	=> $row['answer_post_id'] ? true : false,
		));

		return $block;
	}
}
