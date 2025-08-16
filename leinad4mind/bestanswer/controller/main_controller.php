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

namespace leinad4mind\bestanswer\controller;

use phpbb\auth\auth;
use phpbb\db\driver\driver_interface;
use phpbb\language\language;
use phpbb\notification\manager;
use phpbb\log\log;
use phpbb\request\request;
use phpbb\user;

/**
 * Best Answer main controller.
 */
class main_controller
{
	/* @var \phpbb\auth\auth */
	protected $auth;

	/* @var \phpbb\db\driver\driver_interface */
	protected $db;

	/* @var \phpbb\language\language */
	protected $lang;

	/* @var \phpbb\log\log */
	protected $log;

	/* @var \phpbb\request\request */
	protected $request;

	/* @var \phpbb\user */
	protected $user;

	/* @var string phpbb_root_path */
	protected $root_path;

	/* @var string phpEx */
	protected $php_ext;

	/* @var manager */
	private $notification_manager;
	
	/* @var int bbpoints_table */
	protected $bbpoints_table;

	/**
	 * Constructor
	 *
	 * @param auth					$auth					Auth object
	 * @param driver_interface		$db						Database object
	 * @param language				$lang					Language object
	 * @param manager 				$notification_manager	Notification object
	 * @param log					$log					Log object
	 * @param request				$request				Request object
	 * @param user					$user					User object
	 * @param int					$bbpoints_table
	 * @param string				$root_path
	 * @param string				$php_ext
	 * @access public
	 */
	public function __construct(
		auth $auth, 
		driver_interface $db,
		language $lang,
		manager $notification_manager, 
		log $log, 
		request $request, 
		user $user,
		$bbpoints_table, 
		$root_path, 
		$php_ext
	)
	{
		$this->auth = $auth;
		$this->db = $db;
		$this->lang = $lang;
		$this->notification_manager = $notification_manager;
		$this->log = $log;
		$this->request = $request;
		$this->user = $user;
		$this->bbpoints_table = $bbpoints_table;
		$this->root_path = $root_path;
		$this->php_ext = $php_ext;
	}

	/**
	 * Controller for route /answer/{action}
	 *
	 * @param string $action
	 */
	public function change_post_status($action)
	{
		$post_id = $this->request->variable('p', 0);

		// Grab all the data necessary for error checking
		$sql_array = array(
			'SELECT'	=> 't.*, f.*, p.*, u.user_id, u.username, u.user_colour',

			'FROM'		=> array(
				FORUMS_TABLE	=> 'f',
				POSTS_TABLE		=> 'p',
				TOPICS_TABLE	=> 't',
				USERS_TABLE		=> 'u',
			),

			'WHERE'		=> "p.post_id = $post_id AND t.topic_id = p.topic_id AND p.poster_id = u.user_id AND f.forum_id = t.forum_id",
		);

		$sql = $this->db->sql_build_query('SELECT', $sql_array);
		$result = $this->db->sql_query($sql);
		$topic_data = $this->db->sql_fetchrow($result);
		$this->db->sql_freeresult($result);

		// Validate all checks and throw errors
		if (!$topic_data['enable_answer'])
		{
			throw new \phpbb\exception\http_exception(404, $this->lang->lang('EXTENSION_NOT_ENABLED'));
		}
		if ($topic_data['topic_first_post_id'] == (int) $post_id)
		{
			throw new \phpbb\exception\http_exception(404, $this->lang->lang('TOPIC_FIRST_POST'));
		}
		if (!$this->auth->acl_get('m_mark_answer', (int) $topic_data['forum_id']) && (!$this->auth->acl_get('f_mark_answer', (int) $topic_data['forum_id']) && $topic_data['topic_poster'] != $this->user->data['user_id']))
		{
			throw new \phpbb\exception\http_exception(403, $this->lang->lang('NOT_AUTHORISED'));
		}
		if ($topic_data['topic_status'] == ITEM_LOCKED && !$this->auth->acl_get('m_mark_answer', (int) $topic_data['forum_id']))
		{
			throw new \phpbb\exception\http_exception(403, $this->lang->lang('NOT_AUTHORISED'));
		}

		$log_var = $this->auth->acl_get('m_mark_answer', $topic_data['forum_id']) ? 'mod' : 'user';

		// Mark or unmark answers
		if (confirm_box(true))
		{
			if ($action == 'unmark_answer')
			{
				$data = array(
					'answer_post_id'	=> 0,
					'answer_user_id'	=> 0,
				);

				$sql = 'UPDATE ' . TOPICS_TABLE . ' SET ' . $this->db->sql_build_array('UPDATE', $data) . ' WHERE topic_id = ' . (int) $topic_data['topic_id'];
				$this->db->sql_query($sql);

				$sql = 'UPDATE ' . USERS_TABLE . '
					SET user_answers = user_answers - 1
					WHERE user_id = ' . (int) $topic_data['user_id'];
				$this->db->sql_query($sql);

				$post_author = get_username_string('full', $topic_data['user_id'], $topic_data['username'], $topic_data['user_colour']);
				$this->log->add($log_var, $this->user->data['user_id'], $this->user->data['user_ip'], 'LOG_UNMARK_ANSWER', time(), array($topic_data['post_subject'], $post_author));
			
				// remove bbpoints
				$sql = 'DELETE FROM ' . $this->bbpoints_table . ' WHERE
				to_id=' . $topic_data['user_id'] . ' AND reason="bestanswer-'.$post_id.'"';
				$this->db->sql_query($sql);
				$this->log->add($log_var, $topic_data['user_id'], $this->user->data['user_ip'], 'LOG_REMOVE_BBPOINTS_MARK_ANSWER', time(), array($topic_data['post_subject'], $post_author));				
							
				$this->notification_manager->delete_notifications('leinad4mind.bestanswer.notification.type.notbestanswer', $post_id, $post_id, $topic_data['user_id']);
				$this->notification_manager->add_notifications('leinad4mind.bestanswer.notification.type.notbestanswer', [
					'user_id'			=> $this->user->data['user_id'],
					'user_ids'			=> array($topic_data['user_id']),
					'username'			=> $this->user->data['username'],
					'notification_id'	=> $post_id,
					'poster_username'	=> $topic_data['username'],
					'poster_id'			=> $topic_data['user_id'],
					'post_id'			=> $post_id,
					'topic_id'			=> $topic_data['topic_id'],
					'topic_title'		=> $topic_data['topic_title'],
				],
				[
					'user_ids'			=> array($topic_data['user_id']),
				]);
			}

			if ($action == 'mark_answer')
			{
				// If an answer is already set, we need to update the user's answer count first
				if ($topic_data['answer_post_id'])
				{
					$sql = 'SELECT p.*, u.user_id, u.username, u.user_colour
						FROM ' . POSTS_TABLE . ' p, ' . USERS_TABLE . ' u
						WHERE p.post_id = ' . (int) $topic_data['answer_post_id'] . '
							AND p.poster_id = u.user_id';
					$result = $this->db->sql_query($sql);
					$row = $this->db->sql_fetchrow($result);
					$this->db->sql_freeresult($result);
								
					$sql = 'UPDATE ' . USERS_TABLE . '
						SET user_answers = user_answers - 1
						WHERE user_id = ' . (int) $row['poster_id'];
					$this->db->sql_query($sql);

					$post_author = get_username_string('full', $row['poster_id'], $row['username'], $row['user_colour']);
					$this->log->add($log_var, $this->user->data['user_id'], $this->user->data['user_ip'], 'LOG_UNMARK_ANSWER', time(), array($topic_data['post_subject'], $post_author));
				}

				// Now, update all data
				$data = array(
					'answer_post_id'	=> (int) $post_id,
					'answer_user_id'	=> (int) $topic_data['user_id'],
				);

				$sql = 'UPDATE ' . TOPICS_TABLE . ' SET ' . $this->db->sql_build_array('UPDATE', $data) . ' WHERE topic_id = ' . (int) $topic_data['topic_id'];
				$this->db->sql_query($sql);

				$sql = 'UPDATE ' . USERS_TABLE . '
					SET user_answers = user_answers + 1
					WHERE user_id = ' . (int) $topic_data['user_id'];
				$this->db->sql_query($sql);

				$post_author = get_username_string('full', $topic_data['user_id'], $topic_data['username'], $topic_data['user_colour']);
				$this->log->add($log_var, $this->user->data['user_id'], $this->user->data['user_ip'], 'LOG_MARK_ANSWER', time(), array($topic_data['post_subject'], $post_author));

				// add bbpoints
				if ($topic_data['bbpoints_answer'] > 0) {
					$sql = 'INSERT INTO ' . $this->bbpoints_table . ' (from_id, to_id, bbpoints, reason, timestamp) 
						VALUES(0, ' . $topic_data['user_id'] . ', ' . $topic_data['bbpoints_answer'] . ', "bestanswer-'.$post_id.'", ' . time() . ')';
					$this->db->sql_query($sql);
					$this->log->add($log_var, $topic_data['user_id'], $this->user->data['user_ip'], 'LOG_ADD_BBPOINTS_MARK_ANSWER', time(), array($topic_data['post_subject'], $post_author));				
				}

				$this->notification_manager->delete_notifications('leinad4mind.bestanswer.notification.type.bestanswer', $post_id, $post_id, $topic_data['user_id']);
				$this->notification_manager->add_notifications('leinad4mind.bestanswer.notification.type.bestanswer', [
					'user_id'			=> $this->user->data['user_id'],
					'user_ids'			=> array($topic_data['user_id']),
					'username'			=> $this->user->data['username'],
					'notification_id'	=> $post_id,
					'poster_username'	=> $topic_data['username'],
					'poster_id'			=> $topic_data['user_id'],
					'post_id'			=> $post_id,
					'topic_id'			=> $topic_data['topic_id'],
					'topic_title'		=> $topic_data['topic_title'],
				],
				[
					'user_ids'			=> array($topic_data['user_id']),
				]);
			}
		}
		else
		{
			confirm_box(false, $this->lang->lang(strtoupper($action) . '_CONFIRM'));
		}

		// Redirect back to the post
		$url = append_sid("{$this->root_path}viewtopic.{$this->php_ext}", 'p=' . (int) $post_id . '#p' . (int) $post_id);
		redirect($url);
	}
}
