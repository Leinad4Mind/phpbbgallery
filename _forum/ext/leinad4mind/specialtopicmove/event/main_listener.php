<?php

/**
 *
 * Special Topic Move. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2019, Leinad4Mind, https://leinad4mind.top/forum
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace leinad4mind\specialtopicmove\event;

use leinad4mind\specialtopicmove\ext;
use phpbb\auth\auth;
use phpbb\config\config;
use phpbb\db\driver\driver_interface as db_interface;
use phpbb\event\data;
use phpbb\language\language;
use phpbb\notification\manager;
use phpbb\path_helper;
use phpbb\request\request_interface;
use phpbb\template\template;
use phpbb\user;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class main_listener implements EventSubscriberInterface
{
	/** @var user */
	protected $user;

	/* @var path_helper */
	protected $path_helper;

	/** @var config */
	protected $config;

	/** @var auth */
	protected $auth;

	/* @var template */
	protected $template;

	/** @var request_interface */
	protected $request;

	/** @var db_interface */
	protected $db;

	/* @var language */
	protected $language;

	/** @var manager */
	protected $notification_manager;

	/** @var array */
	protected $users = [];

	/** @var array */
	protected $forums = [];

	/** @var int */
	protected $forum_id = 0;

	/** @var string */
	protected $viewtopic_url = '';

	/**
	 * @param user				$user
	 * @param path_helper		$path_helper
	 * @param config			$config
	 * @param auth				$auth
	 * @param template			$template
	 * @param request_interface	$request
	 * @param db_interface		$db
	 * @param language			$language
	 * @param manager			$notification_manager
	 */
	public function __construct(
		user $user,
		path_helper $path_helper,
		config $config,
		auth $auth,
		template $template,
		request_interface $request,
		db_interface $db,
		language $language,
		manager $notification_manager
	)
	{
		$this->user					= $user;
		$this->path_helper			= $path_helper;
		$this->config				= $config;
		$this->auth					= $auth;
		$this->template				= $template;
		$this->request				= $request;
		$this->db					= $db;
		$this->language				= $language;
		$this->notification_manager	= $notification_manager;
	}

	/**
	 * @return array
	 */
	public static function getSubscribedEvents()
	{
		return [
			'core.user_setup'								=> 'load_language_on_setup',

			// Reason
			'core.mcp_main_before'							=> 'mcp_main_before',
			'core.move_topics_before_query'					=> 'move_topics_before_query',

			// MCP Viewforum
			'core.mcp_view_forum_modify_sql'				=> 'mcp_view_forum_modify_sql',
			'core.mcp_view_forum_modify_topicrow'			=> 'mcp_view_forum_modify_topicrow',

			// MCP Viewtopic
			'core.mcp_topic_review_modify_row'				=> 'mcp_topic_review_modify_row',

			// Viewforum
			'core.viewforum_modify_topics_data'				=> 'viewforum_modify_topics_data',
			'core.viewforum_modify_topicrow'				=> 'viewforum_modify_topicrow',

			// Viewtopic
			'core.viewtopic_assign_template_vars_before'	=> 'viewtopic_assign_template_vars_before',
			'core.viewtopic_modify_post_row'				=> 'viewtopic_modify_post_row',
		];
	}

	/**
	 * @param data $event
	 */
	public function load_language_on_setup(data $event)
	{
		$lang_set_ext = $event['lang_set_ext'];
		$lang_set_ext[] = [
			'ext_name' => 'leinad4mind/specialtopicmove',
			'lang_set' => 'common',
		];
		$event['lang_set_ext'] = $lang_set_ext;
	}

	/**
	 * @param data $event
	 */
	public function mcp_main_before(data $event)
	{
		$topic_ids = $event['quickmod'] ? [$this->request->variable('t', 0)] : $this->request->variable('topic_id_list', [0]);

		$this->template->assign_vars([
			'TOPIC_MOVED_MODE'				=> 'reason',
			'SPECIAL_TOPIC_MOVE_TOPIC_COUNT'	=> count($topic_ids),
		]);
	}

	/**
	 * @param data $event
	 */
	public function move_topics_before_query(data $event)
	{
		$sql = $this->db->sql_build_query('SELECT', [
			'SELECT'	=> 't.topic_id, t.topic_last_post_id, t.forum_id, t.topic_poster, u.*',
			'FROM'		=> [TOPICS_TABLE => 't'],
			'LEFT_JOIN'	=> [
				[
					'FROM'	=> [USERS_TABLE => 'u'],
					'ON'	=> 'u.user_id = t.topic_poster',
				],
			],
			'WHERE'		=> $this->db->sql_in_set('t.topic_id', $event['topic_ids']),
		]);

		$result = $this->db->sql_query($sql);
		$rows = $this->db->sql_fetchrowset($result);
		$this->db->sql_freeresult($result);

		$topic_data = array_combine(array_column($rows, 'topic_id'), $rows);

		$acl = [];

		foreach ($event['topic_ids'] as $topic_id)
		{
			$reason = $this->request->variable('moved_reason', '', true);

			$sql_array = [
				'topic_moved_from'			=> $topic_data[$topic_id]['forum_id'],
				'topic_moved_user'			=> $this->user->data['user_id'],
				'topic_moved_time'			=> time(),
				'topic_moved_last_post_id'	=> $topic_data[$topic_id]['topic_last_post_id'],
				'topic_moved_reason'		=> $reason,
			];

			$sql = 'UPDATE ' . TOPICS_TABLE . '
				SET ' . $this->db->sql_build_array('UPDATE', $sql_array) . '
				WHERE topic_id = ' . (int) $topic_id;

			$this->db->sql_query($sql);
			
			if ($this->user->data['user_id'] != $topic_data[$topic_id]['topic_poster'])
			{
				if (!isset($acl[$topic_data[$topic_id]['topic_poster']]))
				{
					$auth = new auth();
					$auth->acl($topic_data[$topic_id]);
					$acl[$topic_data[$topic_id]['topic_poster']] = $auth;
				}

				// if ($acl[$topic_data[$topic_id]['topic_poster']]->acl_get('f_list', $event['forum_id']))
				// {
					$this->notification_manager->add_notifications('leinad4mind.specialtopicmove.notification.type.topic_moved', [
						'topic_id'		=> $topic_id,
						'forum_id'		=> $event['forum_id'],
						'topic_poster'	=> $topic_data[$topic_id]['topic_poster'],
						'topic_mover'	=> $this->user->data['user_id'],
						'reason'		=> $reason,
					]);
				// }
			}
		}
	}

	/**
	 * @param data $event
	 */
	public function mcp_view_forum_modify_sql(data $event)
	{
		$this->forum_id = $event['forum_id'];
	}

	/**
	 * @param data $event
	 */
	public function mcp_view_forum_modify_topicrow(data $event)
	{
		if ($event['row']['topic_moved_id'])
		{
			$sql = 'SELECT t.*
				FROM ' . TOPICS_TABLE . ' t
				WHERE t.topic_id = ' . (int) $event['row']['topic_moved_id'];
			$result = $this->db->sql_query($sql);
			$original_topic_row = $this->db->sql_fetchrow($result);
			$this->db->sql_freeresult($result);

			if ($original_topic_row['topic_moved_from'] == $this->forum_id && ($this->config['topic_moved_display'] & ext::SPECIAL_TOPIC_MOVED_BIT_SHADOW))
			{
				$event['topic_row'] = array_merge($event['topic_row'], $this->get_topic_moved_template_data($original_topic_row));
			}
		}
	}

	/**
	 * @param data $event
	 */
	public function viewforum_modify_topics_data(data $event)
	{
		$this->forum_id = $event['forum_id'];
	}

	/**
	 * @param data $event
	 */
	public function viewforum_modify_topicrow(data $event)
	{
		if ($event['row']['topic_moved_from'] == $this->forum_id && ($this->config['topic_moved_display'] & ext::SPECIAL_TOPIC_MOVED_BIT_SHADOW))
		{
			$event['topic_row'] = array_merge($event['topic_row'], $this->get_topic_moved_template_data($event['row']));
		}
	}

	/**
	 * @param data $event
	 */
	public function mcp_topic_review_modify_row(data $event)
	{
		if ($event['topic_info']['topic_moved_user'] && $event['topic_info']['topic_moved_from'] && $event['topic_info']['topic_moved_time'])
		{
			$on_first_post = ($this->config['topic_moved_display'] & ext::SPECIAL_TOPIC_MOVED_BIT_FIRST) && $event['row']['post_id'] == $event['topic_info']['topic_first_post_id'];
			$on_final_post = ($this->config['topic_moved_display'] & ext::SPECIAL_TOPIC_MOVED_BIT_LAST) && $event['row']['post_id'] == $event['topic_info']['topic_last_post_id'];
			$on_moved_post = ($this->config['topic_moved_display'] & ext::SPECIAL_TOPIC_MOVED_BIT_MOVED) && $event['row']['post_id'] == $event['topic_info']['topic_moved_last_post_id'];

			if ($on_first_post || $on_final_post || $on_moved_post)
			{
				$this->viewtopic_url = append_sid($this->path_helper->get_phpbb_root_path() . 'viewtopic.' . $this->path_helper->get_php_ext(), ['f' => $event['forum_id'], 't' => $event['topic_id']]);
				$event['post_row'] = array_merge($event['post_row'], $this->get_topic_moved_template_data($event['topic_info']));
			}
		}
	}

	/**
	 * @param data $event
	 */
	public function viewtopic_assign_template_vars_before(data $event)
	{
		$this->viewtopic_url = $event['viewtopic_url'];
	}

	/**
	 * @param data $event
	 */
	public function viewtopic_modify_post_row(data $event)
	{
		if ($event['topic_data']['topic_moved_user'] && $event['topic_data']['topic_moved_from'] && $event['topic_data']['topic_moved_time'])
		{
			$on_first_post = ($this->config['topic_moved_display'] & ext::SPECIAL_TOPIC_MOVED_BIT_FIRST) && $event['row']['post_id'] == $event['topic_data']['topic_first_post_id'];
			$on_final_post = ($this->config['topic_moved_display'] & ext::SPECIAL_TOPIC_MOVED_BIT_LAST) && $event['row']['post_id'] == $event['topic_data']['topic_last_post_id'];
			$on_moved_post = ($this->config['topic_moved_display'] & ext::SPECIAL_TOPIC_MOVED_BIT_MOVED) && $event['row']['post_id'] == $event['topic_data']['topic_moved_last_post_id'];

			if ($on_first_post || $on_final_post || $on_moved_post)
			{
				$event['post_row'] = array_merge($event['post_row'], $this->get_topic_moved_template_data($event['topic_data']));
			}
		}
	}

	/**
	 * @param array $topic_row
	 * @return array
	 */
	protected function get_topic_moved_template_data($topic_row)
	{
		if (!$topic_row['topic_moved_user'] && !$topic_row['topic_moved_from'] && !$topic_row['topic_moved_time'])
		{
			return [];
		}

		$mode		= $this->viewtopic_url ? 'topic' : 'forum';
		$moved_from	= $topic_row['topic_moved_from'];
		$user_id	= $topic_row['topic_moved_user'];
		$forum_id	= $mode == 'forum' ? $topic_row['forum_id'] : $moved_from;
		$to_or_from	= $mode == 'forum' ? 'TOPIC_MOVED_TO' : 'TOPIC_MOVED_FROM';
		$can_undo	= $mode == 'topic' && $this->auth->acl_get('f_list', $moved_from) && $this->auth->acl_get('m_move', $topic_row['forum_id']) && $topic_row['topic_status'] != ITEM_MOVED;

		// We need information about the user who moved the post.
		if (!isset($this->users[$user_id]))
		{
			$sql = 'SELECT u.username, u.user_colour
				FROM ' . USERS_TABLE . ' u
				WHERE u.user_id = ' . (int) $user_id;
			$result = $this->db->sql_query($sql);
			$row = $this->db->sql_fetchrow($result);
			$this->db->sql_freeresult($result);

			$this->users[$user_id] = [
				'username'		=> $row['username'],
				'user_colour'	=> $row['user_colour'],
			];
		}

		// We need information about the forum that the post was moved from/to.
		if (!isset($this->forums[$forum_id]))
		{
			$sql = 'SELECT f.forum_name
				FROM ' . FORUMS_TABLE . ' f
				WHERE f.forum_id = ' . (int) $forum_id;
			$result = $this->db->sql_query($sql);
			$row = $this->db->sql_fetchrow($result);
			$this->db->sql_freeresult($result);

			$forum_name = '';
			if (!empty($row) && is_array($row) && isset($row['forum_name'])) {
				$forum_name = $row['forum_name'];
			}

			$this->forums[$forum_id] = [
				'forum_name'	=> $forum_name,
			];
		}

		$moved_info = $this->users[$user_id] + $this->forums[$forum_id];

		$forum_url = append_sid($this->path_helper->get_phpbb_root_path() . 'viewforum.' . $this->path_helper->get_php_ext(), ['f' => $forum_id], true);
		$unmove_url = append_sid($this->path_helper->get_phpbb_root_path() . 'mcp.' . $this->path_helper->get_php_ext(), [
			'f'				=> $topic_row['forum_id'],
			't'				=> $topic_row['topic_id'],
			'quickmod'		=> 1,
			'action'		=> 'move',
			'to_forum_id'	=> $forum_id,
			'redirect'		=> urlencode(str_replace('&amp;', '&', $this->viewtopic_url))
		], true, $this->user->session_id);

		$msg['moved']	= $this->language->lang('SPECIAL_TOPIC_MOVED_MESSAGE');
		$msg['forum']	= (empty($moved_info['forum_name']) || !$this->auth->acl_get('f_list', $forum_id)) ? '' : '<a href="' . $forum_url . '">' . $moved_info['forum_name'] . '</a>';
		$msg['forum']	= empty($msg['forum']) ? '' : $this->language->lang('SPECIAL_' . $to_or_from, $msg['forum']);
		$msg['by']		= empty($moved_info['username']) ? $this->language->lang('SPECIAL_TOPIC_MOVED_NO_USER') : get_username_string('full', $user_id, $moved_info['username'], $moved_info['user_colour']);
		$msg['by']		= empty($msg['by']) ? '' : $this->language->lang('SPECIAL_TOPIC_MOVED_BY', $msg['by']);
		$msg['on']		= empty($topic_row['topic_moved_time']) ? '' : $this->user->format_date($topic_row['topic_moved_time']);
		$msg['on']		= empty($msg['on']) ? '' : $this->language->lang('SPECIAL_TOPIC_MOVED_ON', $msg['on']);
		$msg['undo']	= $can_undo ? ' <a href="' . $unmove_url . '" class="post_unmove">' . $this->language->lang('SPECIAL_TOPIC_MOVED_UNDO') . '</a>' : '';

		return [
			'TOPIC_MOVED_MODE'		=> $mode,
			'TOPIC_MOVED_MESSAGE'	=> $msg['moved'],
			$to_or_from				=> $msg['forum'],
			'TOPIC_MOVED_BY' 		=> $msg['by'],
			'TOPIC_MOVED_ON'		=> $msg['on'],
			'TOPIC_MOVED_REASON'	=> $topic_row['topic_moved_reason'],
			'TOPIC_MOVED_UNDO'		=> $msg['undo'],
		];
	}
}
