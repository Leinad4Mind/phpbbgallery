<?php
/**
 *
 * Best Answer extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2018, kinerity, https://www.layer-3.org/
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace kinerity\bestanswer\controller;

/**
 * Best Answer main controller
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

	/* @var \phpbb\notification\manager */
	private $notification_manager;

	/* @var string */
	protected $root_path;

	/* @var string */
	protected $php_ext;

	/**
	 * Constructor
	 *
	 * @param \phpbb\auth\auth                    $auth
	 * @param \phpbb\db\driver\driver_interface   $db
	 * @param \phpbb\language\language            $lang
	 * @param \phpbb\log\log                      $log
	 * @param \phpbb\request\request              $request
	 * @param \phpbb\user                         $user
	 * @param \phpbb\notification\manager         $notification_manager
	 * @param string                              $root_path
	 * @param string                              $php_ext
	 */
	public function __construct(\phpbb\auth\auth $auth, \phpbb\db\driver\driver_interface $db, \phpbb\language\language $lang, \phpbb\log\log $log, \phpbb\request\request $request, \phpbb\user $user, \phpbb\notification\manager $notification_manager, $root_path, $php_ext)
	{
		$this->auth = $auth;
		$this->db = $db;
		$this->lang = $lang;
		$this->log = $log;
		$this->request = $request;
		$this->user = $user;
		$this->notification_manager = $notification_manager;
		$this->root_path = $root_path;
		$this->php_ext = $php_ext;
	}

	/**
	 * Controller for route /answer/{action}
	 */
	public function change_post_status($action)
	{
		$post_id = $this->request->variable('p', 0);

		// Query necessary topic data
		$sql_arr = array(
			'SELECT'	=> 'f.forum_id, f.enable_answer, p.post_id, p.topic_id, p.poster_id, p.post_subject, t.topic_id, t.forum_id, t.topic_title, t.topic_poster, t.topic_status, t.topic_first_post_id, t.answer_post_id, t.answer_user_id, u.user_id, u.username, u.user_colour',

			'FROM'		=> array(
				FORUMS_TABLE	=> 'f',
				POSTS_TABLE		=> 'p',
				TOPICS_TABLE	=> 't',
				USERS_TABLE		=> 'u',
			),

			'WHERE'		=> 'p.post_id = ' . (int) $post_id . ' AND t.topic_id = p.topic_id AND p.poster_id = u.user_id AND f.forum_id = t.forum_id',
		);

		$sql = $this->db->sql_build_query('SELECT', $sql_arr);
		$result = $this->db->sql_query($sql);
		$topic_data = $this->db->sql_fetchrow($result);
		$this->db->sql_freeresult($result);

		// Error checking
		if (!$topic_data['enable_answer'])
		{
			throw new \phpbb\exception\http_exception(403, $this->lang->lang('NOT_AUTHORISED'));
		}

		if (!$this->auth->acl_get('m_mark_answer', (int) $topic_data['forum_id']) && (!$this->auth->acl_get('f_mark_answer', (int) $topic_data['forum_id']) && $topic_data['topic_poster'] != (int) $this->user->data['user_id']))
		{
			throw new \phpbb\exception\http_exception(403, $this->lang->lang('NOT_AUTHORISED'));
		}

		if ((int) $topic_data['topic_first_post_id'] == (int) $post_id)
		{
			throw new \phpbb\exception\http_exception(404, $this->lang->lang('NOT_AUTHORISED'));
		}

		if ((int) $topic_data['topic_status'] == ITEM_LOCKED && !$this->auth->acl_get('m_mark_answer', (int) $topic_data['forum_id']))
		{
			throw new \phpbb\exception\http_exception(403, $this->lang->lang('NOT_AUTHORISED'));
		}

		$log_var = $this->auth->acl_get('m_mark_answer', (int) $topic_data['forum_id']) ? 'mod' : 'user';

		// Mark or unmark answers
		if (confirm_box(true))
		{
			if ($action == 'unmark_answer')
			{
				$sql_arr = array(
					'answer_post_id'	=> 0,
					'answer_user_id'	=> 0,
				);

				$sql = 'UPDATE ' . TOPICS_TABLE . ' SET ' . $this->db->sql_build_array('UPDATE', $sql_arr) . ' WHERE topic_id = ' . (int) $topic_data['topic_id'];
				$this->db->sql_query($sql);

				$sql = 'UPDATE ' . USERS_TABLE . '
					SET user_answers = user_answers - 1
					WHERE user_id = ' . (int) $topic_data['user_id'];
				$this->db->sql_query($sql);

				$post_author = get_username_string('full', (int) $topic_data['user_id'], $topic_data['username'], $topic_data['user_colour']);
				$this->log->add($log_var, (int) $this->user->data['user_id'], $this->user->data['user_ip'], 'LOG_UNMARK_ANSWER', time(), array($topic_data['post_subject'], $post_author));

				$this->notification_manager->delete_notifications('kinerity.bestanswer.notification.type.unmarkanswer', $post_id, $post_id, $topic_data['user_id']);
				$this->notification_manager->add_notifications('kinerity.bestanswer.notification.type.unmarkanswer', [
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
				// If an answer is already set, update the user's answer count first
				if ((int) $topic_data['answer_post_id'])
				{
					$sql = 'SELECT p.poster_id, p.post_subject, u.user_id, u.username, u.user_colour
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

					$post_author = get_username_string('full', (int) $row['poster_id'], $row['username'], $row['user_colour']);
					$this->log->add($log_var, (int) $this->user->data['user_id'], $this->user->data['user_ip'], 'LOG_UNMARK_ANSWER', time(), array($topic_data['post_subject'], $post_author));
				}

				// Now update the topic with new data
				$sql_arr = array(
					'answer_post_id'	=> (int) $post_id,
					'answer_user_id'	=> (int) $topic_data['user_id'],
				);

				$sql = 'UPDATE ' . TOPICS_TABLE . ' SET ' . $this->db->sql_build_array('UPDATE', $sql_arr) . ' WHERE topic_id = ' . (int) $topic_data['topic_id'];
				$this->db->sql_query($sql);

				$sql = 'UPDATE ' . USERS_TABLE . '
					SET user_answers = user_answers + 1
					WHERE user_id = ' . (int) $topic_data['user_id'];
				$this->db->sql_query($sql);

				$post_author = get_username_string('full', (int) $topic_data['user_id'], $topic_data['username'], $topic_data['user_colour']);
				$this->log->add($log_var, (int) $this->user->data['user_id'], $this->user->data['user_ip'], 'LOG_MARK_ANSWER', time(), array($topic_data['post_subject'], $post_author));

				$this->notification_manager->delete_notifications('kinerity.bestanswer.notification.type.markanswer', $post_id, $post_id, $topic_data['user_id']);
				$this->notification_manager->add_notifications('kinerity.bestanswer.notification.type.markanswer', [
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
		$response = new \Symfony\Component\HttpFoundation\RedirectResponse($url, 302);
		$response->send();
	}
}
