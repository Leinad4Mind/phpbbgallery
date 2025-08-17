<?php

/**
 *
 * Topic Statistics. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2019, Leinad4Mind, https://leinad4mind.top/forum
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace leinad4mind\topicstatistics\event;

use phpbb\auth\auth;
use phpbb\config\config;
use phpbb\db\driver\driver_interface;
use phpbb\event\data;
use phpbb\language\language;
use phpbb\request\request_interface;
use phpbb\template\template;
use phpbb\user;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class main_listener implements EventSubscriberInterface
{
	/** @var user */
	protected $user;

	/** @var auth */
	protected $auth;

	/** @var language */
	protected $language;

	/** @var driver_interface */
	protected $db;

	/** @var template */
	protected $template;

	/** @var config */
	protected $config;

	/** @var request_interface */
	protected $request;

	/**
	 * @param user				$user
	 * @param auth				$auth
	 * @param language			$language
	 * @param driver_interface	$db
	 * @param template			$template
	 * @param config			$config
	 * @param request_interface	$request
	 */
	public function __construct(
		user $user,
		auth $auth,
		language $language,
		driver_interface $db,
		template $template,
		config $config,
		request_interface $request
	)
	{
		$this->user		= $user;
		$this->auth		= $auth;
		$this->language	= $language;
		$this->db		= $db;
		$this->template	= $template;
		$this->config	= $config;
		$this->request	= $request;
	}

	/**
	 * @return array
	 */
	public static function getSubscribedEvents()
	{
		return [
			'core.viewforum_generate_page_after'	=> 'viewforum_generate_page_after',
			'core.viewtopic_modify_page_title'		=> 'viewtopic_modify_page_title',
			'core.acp_board_config_edit_add'		=> 'acp_board_config_edit_add',
		];
	}

	/**
	 * @param data $event
	 */
	public function viewforum_generate_page_after($event)
	{
		// get basic settings
		$config_statistics = $this->statistics_config();

		$forum_id = $event['forum_data']['forum_id'];

		// Do not continue if this option is disabled or we have no forum ID
		if (!$config_statistics['forums_display_statistics'])
		{
			return;
		}

		// Users who have visited the theme - Start
		if ($config_statistics['forums_display_visit'])
		{
			// Number of users who have visited the current topic
			$sql_visit = 'SELECT topic_views
				FROM ' . TOPICS_TABLE . '
				WHERE forum_id = ' . (int) $forum_id;
			$result_visit = $this->db->sql_query($sql_visit);
			while ($row_followers = $this->db->sql_fetchrow($result_visit))
			{
				$config_statistics['forums_num_visit'] += (int) $row_followers['topic_views'];
			}
			$this->db->sql_freeresult($result_visit);
		}
		// Users who have visited the theme - End

		// Subscriptions for the current topic - Start
		if ($config_statistics['forums_display_followers'])
		{
			// Get userrs and the number of subscriptions for the current topic
			if ($config_statistics['forums_display_followers_users'])
			{
				$sql_followers = 'SELECT w.user_id, u.username, u.user_id, u.user_type, u.user_colour, u.user_posts
					FROM ' . FORUMS_WATCH_TABLE . ' w, ' . USERS_TABLE . ' u 
					WHERE w.forum_id = ' . (int) $forum_id . '
						AND w.user_id = u.user_id';
				$result_followers = $this->db->sql_query_limit($sql_followers, $config_statistics['user_limit']);

				while ($row_followers = $this->db->sql_fetchrow($result_followers))
				{
					$config_statistics['forums_num_followers']++;

					$this->template->assign_block_vars('forum_followers', [
						'USER' => $this->get_username_string($row_followers['user_colour'], $row_followers['user_id'], $row_followers['username'], $config_statistics['user_viewprofile']),
					]);
				}
				$this->db->sql_freeresult($result_followers);
			}
			// Get the number of bookmarks for the current topic
			else
			{
				$sql_bookmark = 'SELECT COUNT(user_id) AS total_followers
					FROM ' . FORUMS_WATCH_TABLE . '
					WHERE forum_id = ' . (int) $forum_id;
				$result_bookmarks = $this->db->sql_query($sql_bookmark);
				$config_statistics['forums_num_followers'] = (int) $this->db->sql_fetchfield('total_followers');
				$this->db->sql_freeresult($result_bookmarks);
			}
		}
		// Subscriptions for the current topic - End

		// Send vars to template
		$this->template->assign_vars([
			'FORUM_STATISTICS'					=> true,
			'FORUM_STATISTICS_VISITS'			=> $config_statistics['forums_display_visit'],
			'FORUM_STATISTICS_VISITS_NUM'		=> $config_statistics['forums_num_visit'],
			'FORUM_STATISTICS_FOLLOWERS'		=> $config_statistics['forums_display_followers'],
			'FORUM_STATISTICS_FOLLOWERS_NUM'	=> $config_statistics['forums_num_followers'],
		]);
	}

	/**
	 * @param data $event
	 */
	public function viewtopic_modify_page_title($event)
	{
		// Some basic settings
		$config_statistics = $this->statistics_config();

		$topic_id = $event['topic_data']['topic_id'];

		// Do not continue if this option is disabled or we have no topic ID
		if (!$this->config['topics_display_statistics'])
		{
			return;
		}

		// Users who have visited the theme - Start
		if ($this->config['topics_display_visit'])
		{
			// Number of users who have visited the current topic
			$sql_visit = 'SELECT topic_views AS topic_views 
				FROM ' . TOPICS_TABLE . '
				WHERE topic_id = ' . (int) $topic_id;
			$result_visit = $this->db->sql_query($sql_visit);
			$config_statistics['topics_num_visit'] = (int) $this->db->sql_fetchfield('topic_views');
			$this->db->sql_freeresult($result_visit);
		}
		// Users who have visited the theme - End

		// Favorites for the current topic - Start
		if ($this->config['topics_display_bookmarks'])
		{
			// Get users and the number of bookmarks for the current topic
			if ($this->config['topics_display_bookmarks_users'])
			{
				$sql_bookmarks = 'SELECT b.user_id, u.username, u.user_id, u.user_type, u.user_colour, u.user_posts
					FROM ' . BOOKMARKS_TABLE . ' b, ' . USERS_TABLE . ' u 
					WHERE b.topic_id = ' . (int) $topic_id . '
						AND b.user_id = u.user_id';
				$result_bookmarks = $this->db->sql_query_limit($sql_bookmarks, $config_statistics['user_limit']);

				while ($row_bookmarks = $this->db->sql_fetchrow($result_bookmarks))
				{
					$config_statistics['topics_num_bookmarks']++;

					$this->template->assign_block_vars('topic_bookmark', [
						'USER' => $this->get_username_string($row_bookmarks['user_colour'], $row_bookmarks['user_id'], $row_bookmarks['username'], $config_statistics['user_viewprofile']),
					]);
				}
				$this->db->sql_freeresult($result_bookmarks);
			}
			// Get the number of bookmarks for the current topic
			else
			{
				$sql_bookmark = 'SELECT COUNT(user_id) AS total_bookmarks
					FROM ' . BOOKMARKS_TABLE . '
					WHERE topic_id = ' . (int) $topic_id;
				$result_bookmarks = $this->db->sql_query($sql_bookmark);
				$config_statistics['topics_num_bookmarks'] = (int) $this->db->sql_fetchfield('total_bookmarks');
				$this->db->sql_freeresult($result_bookmarks);
			}
		}
		// Favorites for the current topic - End

		// Subscriptions for the current topic - Start
		if ($this->config['topics_display_followers'])
		{
			// Get userrs and the number of subscriptions for the current topic
			if ($this->config['topics_display_followers_users'])
			{
				$sql_followers = 'SELECT w.user_id, u.username, u.user_id, u.user_type, u.user_colour, u.user_posts
					FROM ' . TOPICS_WATCH_TABLE . ' w, ' . USERS_TABLE . ' u 
					WHERE w.topic_id = ' . (int) $topic_id . '
						AND w.user_id = u.user_id';
				$result_followers = $this->db->sql_query_limit($sql_followers, $config_statistics['user_limit']);

				while ($row_followers = $this->db->sql_fetchrow($result_followers))
				{
					$config_statistics['topics_num_followers']++;

					$this->template->assign_block_vars('topic_followers', [
						'USER' => $this->get_username_string($row_followers['user_colour'], $row_followers['user_id'], $row_followers['username'], $config_statistics['user_viewprofile']),
					]);
				}
				$this->db->sql_freeresult($result_followers);
			}
			// Get the number of bookmarks for the current topic
			else
			{
				$sql_bookmark = 'SELECT COUNT(user_id) AS total_followers
					FROM ' . TOPICS_WATCH_TABLE . '
					WHERE topic_id = ' . (int) $topic_id;
				$result_bookmarks = $this->db->sql_query($sql_bookmark);
				$config_statistics['topics_num_followers'] = (int) $this->db->sql_fetchfield('total_followers');
				$this->db->sql_freeresult($result_bookmarks);
			}
		}
		// Subscriptions for the current topic - End

		// Send vars to template
		$this->template->assign_vars([
			'TOPIC_STATISTICS'				=> $this->config['topics_display_statistics'],
			'TOPIC_STATISTICS_VISITS'		=> $this->config['topics_display_visit'],
			'TOPIC_STATISTICS_VISITS_NUM'	=> $config_statistics['topics_num_visit'],
			'TOPIC_STATISTICS_BOOKMARK'		=> $this->config['topics_display_bookmarks'],
			'TOPIC_STATISTICS_BOOKMARK_NUM'	=> $config_statistics['topics_num_bookmarks'],
			'TOPIC_STATISTICS_FOLLOWERS'	=> $this->config['topics_display_followers'],
			'TOPIC_STATISTICS_FOLLOWERS_NUM'=> $config_statistics['topics_num_followers'],
		]);
	}

	/**
	 * @param string $colour
	 * @param string $user_id
	 * @param string $username
	 * @param string $viewprofile
	 * @return string
	 */
	protected function get_username_string($colour, $user_id, $username, $viewprofile)
	{
		return get_username_string($viewprofile ? 'full' : 'no_profile', $user_id, $username, $colour);
	}

	/**
	 * @return array
	 */
	protected function statistics_config()
	{
		$this->language->add_lang('common', 'leinad4mind/topicstatistics');

		$config_statistics = [
			// Maximun amount of users to display
			'user_limit'					=> 1000,
			// display user profile link ?
			'user_viewprofile'				=> true,
			// Options for viewforum - Start
			'forums_display_statistics'		=> true,
			// Enable the forum visit count
			'forums_display_visit'			=> true,
			// Initial amount of users that have visited forums
			'forums_num_visit'				=> 0,
			// Enable the followers count for forums
			'forums_display_followers'		=> true,
			// Initial amount of users that are following forums
			'forums_num_followers'			=> 0,
			// Display the subscribed users names
			'forums_display_followers_users'=> true,
			// Initial amount of users that have visited topics
			'topics_num_visit'				=> 0,
			// Initial amount of users that have bookmarked topics
			'topics_num_bookmarks'			=> 0,
			// Initial amount of users that are following topics
			'topics_num_followers'			=> 0,
		];

		// Verify some permissions
		if (!empty($this->user->data['is_bot']) || !$this->auth->acl_get('u_viewprofile'))
		{
			$config_statistics['user_viewprofile'] = false;
		}

		return $config_statistics;
	}

	/**
	 * @param data $event
	 */
	public function acp_board_config_edit_add(data $event)
	{
		if ($event['mode'] == 'features')
		{
			$this->language->add_lang('acp', 'leinad4mind/topicstatistics');

			$config = [
				'topics_display_statistics'			=> ['lang' => 'TS_ENABLED', 'validate' => 'bool', 'type' => 'radio:yes_no', 'explain' => false],
				'topics_display_visit'				=> ['lang' => 'TS_VISIT', 'validate' => 'bool', 'type' => 'radio:yes_no', 'explain' => true],
				'topics_display_bookmarks'			=> ['lang' => 'TS_BOOKMARK', 'validate' => 'bool', 'type' => 'radio:yes_no', 'explain' => true],
				'topics_display_bookmarks_users'	=> ['lang' => 'TS_BOOKMARK_USERS', 'validate' => 'bool', 'type' => 'radio:yes_no', 'explain' => true],
				'topics_display_followers'			=> ['lang' => 'TS_FOLLOWERS', 'validate' => 'bool', 'type' => 'radio:yes_no', 'explain' => true],
				'topics_display_followers_users'	=> ['lang' => 'TS_FOLLOWERS_USERS', 'validate' => 'bool', 'type' => 'radio:yes_no', 'explain' => true],
			];

			$display_vars = $event['display_vars'];
			$display_vars['vars'] = phpbb_insert_config_array($display_vars['vars'], $config, ['after' => 'allow_birthdays']);
			$event['display_vars'] = $display_vars;
		}
	}
}
