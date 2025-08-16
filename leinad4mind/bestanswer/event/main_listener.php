<?php

/**
 *
 * Best Answer. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2017, kinerity, https://www.layer-3.org
 * @copyright (c) 2017, Leinad4Mind, https://leinad4mind.top/forum
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace leinad4mind\bestanswer\event;

use phpbb\config\config;
use phpbb\auth\auth;
use phpbb\db\driver\driver_interface;
use phpbb\controller\helper;
use phpbb\language\language;
use phpbb\request\request;
use phpbb\template\template;
use phpbb\user;
use phpbb\log\log;

/**
 * @ignore
 */
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Best Answer Event listener.
 */
class main_listener implements EventSubscriberInterface
{
	/* @var \phpbb\config\config */
	protected $config;

	/* @var \phpbb\auth\auth */
	protected $auth;

	/* @var \phpbb\db\driver\driver_interface */
	protected $db;

	/* @var \phpbb\controller\helper */
	protected $helper;

	/* @var \phpbb\language\language */
	protected $lang;

	/* @var \phpbb\request\request */
	protected $request;

	/* @var \phpbb\template\template */
	protected $template;

	/* @var \phpbb\user */
	protected $user;

	/* @var \phpbb\log\log */
	protected $log;

	/* @var int bbpoints */
	protected $bbpoints_table;

	/* @var string phpbb_root_path */
	protected $root_path;

	/* @var string phpEx */
	protected $php_ext;

	/* @var array answer */
	private $answer = array();

	/**
	* Constructor
	*
	* @param config					$config			Config object
	* @param auth					$auth			Auth object
	* @param driver_interface		$db				Database object
	* @param helper					$helper			Controller Helper object
	* @param language				$lang			Language object
	* @param request				$request		Request object
	* @param template				$template		Template object
	* @param user					$user			User object
	* @param log					$log			Log object
	* @param int					$bbpoints_table
	* @param string					$root_path
	* @param string					$php_ext
	* @access public
	*/
	public function __construct(
		config $config,
		auth $auth,
		driver_interface $db, 
		helper $helper,
		language $lang,
		request $request,
		template $template,
		user $user,
		log $log,
		$bbpoints_table,
		$root_path,
		$php_ext
	)
	{
		$this->config = $config;
		$this->auth = $auth;
		$this->db = $db;
		$this->helper = $helper;
		$this->lang = $lang;
		$this->request = $request;
		$this->template = $template;
		$this->user = $user;
		$this->log = $log;
		$this->bbpoints_table = $bbpoints_table;
		$this->root_path = $root_path;
		$this->php_ext = $php_ext;
	}

	/**
	 * Assign functions defined in this class to event listeners in the core
	 *
	 * @return array
	 * @static
	 * @access public
	 */
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

			'core.mcp_change_poster_after'				=> 'mcp_change_poster_after',
			'core.mcp_topic_modify_post_data'			=> 'mcp_topic_modify_post_data',
			'core.mcp_topic_review_modify_row'			=> 'mcp_topic_review_modify_row',
			'core.mcp_view_forum_modify_topicrow'		=> 'mcp_view_forum_modify_topicrow',
			'core.memberlist_view_profile'				=> 'memberlist_view_profile',

			'core.permissions'				=> 'permissions',

			'core.search_get_topic_data'	=> 'search_get_topic_data',
			'core.search_modify_tpl_ary'	=> 'modify_topicrow_tpl_ary',

			'core.user_setup'				=> 'user_setup',

			'core.viewforum_modify_topicrow'				=> 'modify_topicrow_tpl_ary',
			'core.viewtopic_assign_template_vars_before'	=> 'viewtopic_assign_template_vars_before',
			'core.viewtopic_cache_user_data'				=> 'viewtopic_cache_user_data',
			'core.viewtopic_get_post_data'					=> 'viewtopic_get_post_data',
			'core.viewtopic_modify_post_row'				=> 'viewtopic_modify_post_row',
		);
	}

	public function acp_manage_forums_display_form($event)
	{
		$template_data = $event['template_data'];
		$template_data['S_BEST_ANSWER'] = $event['forum_data']['enable_answer'];
		$template_data['S_BBPOINTS_ANSWER'] = (int)$event['forum_data']['bbpoints_answer'];
		$event['template_data'] = $template_data;
	}

	public function acp_manage_forums_initialise_data($event)
	{
		if ($event['action'] == 'add')
		{
			$forum_data = $event['forum_data'];
			$forum_data = array_merge($forum_data, array(
				'enable_answer'	=> false,
				'bbpoints_answer' => 0
			));
			$event['forum_data'] = $forum_data;
		}
	}

	public function acp_manage_forums_request_data($event)
	{
		$forum_data = $event['forum_data'];
		$forum_data['enable_answer'] = $this->request->variable('enable_answer', 0);
		$forum_data['bbpoints_answer'] = $this->request->variable('bbpoints_answer', 0);
		$event['forum_data'] = $forum_data;
	}

	public function delete_posts_in_transaction_before($event)
	{
		$post_ids = $event['post_ids'];
		$topic_ids = $event['topic_ids'];

		$post_ary = $user_ary = $bbpoints_ary = array();

		$sql = 'SELECT answer_post_id, answer_user_id
			FROM ' . TOPICS_TABLE . '
			WHERE answer_post_id != 0
				AND ' . $this->db->sql_in_set('topic_id', $topic_ids);
		$result = $this->db->sql_query($sql);

		while ($row = $this->db->sql_fetchrow($result))
		{
			if (in_array($row['answer_post_id'], $post_ids))
			{
				$post_ary[] = $row['answer_post_id'];
				$user_ary[] = $row['answer_user_id'];
				$bbpoints_ary[] = 'bestanswer-'.$row['answer_post_id'];
			}
		}
		$this->db->sql_freeresult($result);

		$postdata = array(
			'answer_post_id'	=> 0,
			'answer_user_id'	=> 0,
		);

		if (sizeof($post_ary)) {
			// remove bbpoints
			$sql = 'DELETE FROM ' . $this->bbpoints_table . ' WHERE
			' . $this->db->sql_in_set('to_id', $user_ary) . ' AND '.$this->db->sql_in_set('reason', $bbpoints_ary);
			$this->db->sql_query($sql);
			$this->log->add($log_var, $topic_data['user_id'], $this->user->data['user_ip'], 'LOG_REMOVE_BBPOINTS_MARK_ANSWERS', time(), array(implode(",",$user_ary), implode(",",$post_ary)));

			$sql = 'UPDATE ' . TOPICS_TABLE . ' SET ' . $this->db->sql_build_array('UPDATE', $postdata) . ' WHERE ' . $this->db->sql_in_set('answer_post_id', $post_ary);
			$this->db->sql_query($sql);
			$sql = 'UPDATE ' . USERS_TABLE . ' SET user_answers = user_answers - 1 WHERE ' . $this->db->sql_in_set('user_id', $user_ary);
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

		foreach ($answer_user_ids as $answer_user_id)
		{
			$sql = 'UPDATE ' . USERS_TABLE . '
				SET user_answers = user_answers - 1
				WHERE user_id = ' . (int) $answer_user_id;
			$this->db->sql_query($sql);
		}
	}

	public function display_forums_modify_forum_rows($event)
	{
		$forum_rows = $event['forum_rows'];
		$parent_id = $event['parent_id'];
		$row = $event['row'];

		// Suggested by the core, equal post times should never happen. Check it just in case.
		if ($row['forum_last_post_time'] >= $forum_rows[$parent_id]['forum_last_post_time'])
		{
			// Is the extension enabled on the forum and related answer_post_id not null?
			if ($row['enable_answer'] && !($forum_rows[$parent_id]['answer_post_id'] === false))
			{
				$forum_rows[$parent_id]['answer_post_id'] = $row['answer_post_id'];
			}
		}

		$forum_rows[$parent_id]['answer_post_id'] = $row['answer_post_id'];

		$event['forum_rows'] = $forum_rows;
	}

	public function display_forums_modify_sql($event)
	{
		$sql_ary = $event['sql_ary'];

		if (!$this->has_join($sql_ary['LEFT_JOIN'], POSTS_TABLE))
		{
			$sql_ary['LEFT_JOIN'][] = array(
				'FROM'	=> array(POSTS_TABLE => 'bestanswer_p'),
				'ON'	=> 'f.forum_last_post_id = bestanswer_p.post_id',
			);
		}

		if (!$this->has_join($sql_ary['LEFT_JOIN'], TOPICS_TABLE))
		{
			$sql_ary['SELECT'] .= ', bestanswer_t.answer_post_id';
			$sql_ary['LEFT_JOIN'][] = array(
				'FROM'	=> array(TOPICS_TABLE => 'bestanswer_t'),
				'ON'	=> 'bestanswer_t.topic_id = bestanswer_p.topic_id',
			);
		} else {
			$sql_ary['SELECT'] .= ', t.answer_post_id';
		}

		$event['sql_ary'] = $sql_ary;
	}

	public function display_forums_modify_template_vars($event)
	{
		$forum_row = $event['forum_row'];
		$row = $event['row'];

		// Add the template switch for viewforum
		$forum_row['S_ANSWERED'] = $row['answer_post_id'] ? true : false;

		$event['forum_row'] = $forum_row;
	}

	public function mcp_change_poster_after($event)
	{
		$userdata = $event['userdata'];
		$post_info = $event['post_info'];

		// Query the topic table so we can update answer counts correctly
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

		$post_row = array_merge($post_row, array(
			'ANSWER_POST_ID'	=> (int) $topic_info['answer_post_id'],

			'U_ANSWER'			=> append_sid("{$this->root_path}viewtopic.{$this->php_ext}", 'p=' . (int) $topic_info['answer_post_id'] . '#p' . (int) $topic_info['answer_post_id']),

			'S_BEST_ANSWER'		=> $topic_info['enable_answer'] ? true : false,
			'S_FIRST_POST'		=> $topic_info['topic_first_post_id'] == $row['post_id'] ? true : false,
		));

		// Only pull answer post text if an answer_post_id is supplied and the post_id is the first post in a topic
		if (sizeof($this->answer) && ($topic_info['topic_first_post_id'] == $row['post_id']))
		{
			$post_row['ANSWER_POST_TEXT'] = $this->answer['POST_TEXT'];
			$post_row['ANSWER_USERNAME_FULL'] = $this->answer['USERNAME_FULL'];
			$post_row['ANSWER_POST_TIME'] =  $this->answer['POST_TIME'];
		}

		$event['post_row'] = $post_row;
	}

	public function mcp_view_forum_modify_topicrow($event)
	{
		$row = $event['row'];
		$topic_row = $event['topic_row'];

		$topic_row['S_ANSWERED'] = $row['answer_post_id'] ? true : false;

		$event['topic_row'] = $topic_row;
	}

	public function memberlist_view_profile($event)
	{
		$member = $event['member'];

		$this->template->assign_vars(array(
			'TOPICS_ANSWERED'	=> $member['user_answers'],

			'U_TOPICS_ANSWERED'	=> append_sid("{$this->root_path}search.{$this->php_ext}", 'author_id=' . (int) $member['user_id'] . '&amp;sr=topics&amp;filter=topicsanswered'),
		));
	}

	public function modify_topicrow_tpl_ary($event)
	{
		$block = $event['topic_row'] ? 'topic_row' : 'tpl_ary';
		$event[$block] = $this->display_topic_answered($event['row'], $event[$block]);
	}

	public function permissions($event)
	{
		$permissions = $event['permissions'];

		$permissions['f_mark_answer'] = array('lang' => 'ACL_F_MARK_ANSWER', 'cat' => 'actions');
		$permissions['m_mark_answer'] = array('lang' => 'ACL_M_MARK_ANSWER', 'cat' => 'post_actions');

		$event['permissions'] = $permissions;
	}

	public function search_get_topic_data($event)
	{
		$sql_select = $event['sql_select'];
		$sql_from = $event['sql_from'];
		$sql_where = $event['sql_where'];

		// Allow users to search topics a user has answered
		$filter = $this->request->variable('filter', '');
		$author_id = $this->request->variable('author_id', 0);

		if ($filter == 'topicsanswered')
		{
			$sql_select .= ', p.post_id, p.poster_id';
			$sql_from .= ' LEFT JOIN ' . POSTS_TABLE . ' p ON (p.post_id = t.answer_post_id)';
			$sql_where .= ' AND p.poster_id = ' . (int) $author_id;

			// Set $total_match_count to 0 - DO NOT modify
			// the $event['total_match_count'] variable - it
			// will be set at the end of this if block
			$total_match_count = 0;

			// Grab all necessary data to modify total_match_count
			$sql_array = array(
				'SELECT'	=> 'p.post_id, p.poster_id, t.topic_id, t.answer_post_id',

				'FROM'		=> array(
					POSTS_TABLE		=> 'p',
					TOPICS_TABLE	=> 't',
				),

				'WHERE'		=> 'p.post_id = t.answer_post_id
									AND p.poster_id = ' . (int) $author_id,
			);
			$sql = $this->db->sql_build_query('SELECT', $sql_array);

			// Run the built query
			$result = $this->db->sql_query($sql);
			while ($row = $this->db->sql_fetchrow($result))
			{
				$total_match_count++;
			}
			$this->db->sql_freeresult($result);

			$event['total_match_count'] = $total_match_count;
		}
		// $filter is only allowed to have topics_answered as a value, but
		// must also allow empty values so core searches are not affected
		else if ($filter != '')
		{
			trigger_error($this->lang->lang('INVALID_FILTER'));
		}

		$event['sql_select'] = $sql_select;
		$event['sql_from'] = $sql_from;
		$event['sql_where'] = $sql_where;
	}

	public function user_setup($event)
	{
		$lang_set_ext = $event['lang_set_ext'];
		$lang_set_ext[] = array(
			'ext_name' => 'leinad4mind/bestanswer',
			'lang_set' => 'common',
		);
		$event['lang_set_ext'] = $lang_set_ext;
		$cookie = $this->request->variable($this->config['cookie_name'] . '_nightstalker', 0, false, \phpbb\request\request_interface::COOKIE);
		$this->template->assign_vars(array(
			'S_NIGHTSTAKLER_ENABLED'	=> ($cookie == 1),
		));
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

		$user_cache_data['topics_answered'] = (int) $row['user_answers'];

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
		$poster_id = $event['poster_id'];
		$row = $event['row'];
		$user_poster_data = $event['user_poster_data'];
		$post_row = $event['post_row'];
		$topic_data = $event['topic_data'];

		$post_row = array_merge($post_row, array(
			'ANSWER_POST_ID'	=> (int) $topic_data['answer_post_id'],
			'TOPICS_ANSWERED'	=> $user_poster_data['topics_answered'],

			'U_ANSWER'			=> append_sid("{$this->root_path}viewtopic.{$this->php_ext}", 'p=' . (int) $topic_data['answer_post_id']. '#p' . (int) $topic_data['answer_post_id']),
			'U_MARK_ANSWER'		=> $topic_data['enable_answer'] ? $this->helper->route('leinad4mind_bestanswer_controller', array('action' => 'mark_answer', 'p' => (int) $row['post_id'])) : '',
			'U_UNMARK_ANSWER'	=> $topic_data['enable_answer'] ? $this->helper->route('leinad4mind_bestanswer_controller', array('action' => 'unmark_answer', 'p' => (int) $row['post_id'])) : '',
			'U_TOPICS_ANSWERED'	=> append_sid("{$this->root_path}search.{$this->php_ext}", 'author_id=' . (int) $poster_id . '&amp;sr=topics&amp;filter=topicsanswered'),

			'S_BEST_ANSWER'		=> $topic_data['enable_answer'] ? true : false,
			'S_AUTH'		=> $topic_data['topic_status'] == ITEM_LOCKED && !$this->auth->acl_get('m_mark_answer', (int) $topic_data['forum_id']) ? false : ($this->auth->acl_get('m_mark_answer', (int) $topic_data['forum_id']) || ($this->auth->acl_get('f_mark_answer', (int) $topic_data['forum_id']) && $topic_data['topic_poster'] == $this->user->data['user_id']) ? true : false),
			'S_FIRST_POST'	=> $topic_data['topic_first_post_id'] == $row['post_id'] ? true : false,
		));

		// Only pull answer post text if a answer_post_id is supplied and the post_id is the first post in a topic
		if (sizeof($this->answer) && ($topic_data['topic_first_post_id'] == $row['post_id']))
		{
			$post_row['ANSWER_POST_TEXT'] = $this->answer['POST_TEXT'];
			$post_row['ANSWER_USERNAME_FULL'] = $this->answer['USERNAME_FULL'];
			$post_row['ANSWER_POST_TIME'] =  $this->answer['POST_TIME'];
		}

		$event['post_row'] = $post_row;
	}

	private function display_topic_answered($row, $block)
	{
		$block = array_merge($block, array(
			'S_ANSWERED'	=> $row['answer_post_id'] ? true : false,
		));

		return $block;
	}

	private function has_join($join_ary, $table)
	{
		foreach ($join_ary as $join)
		{
			if (isset($join['FROM'][$table]))
			{
				return true;
			}
		}

		return false;
	}
}
