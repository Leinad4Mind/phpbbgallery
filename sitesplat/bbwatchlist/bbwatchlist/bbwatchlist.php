<?php
/**
 *
 * BBwatchlist. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2018, SiteSplat
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace sitesplat\bbwatchlist\bbwatchlist;

use sitesplat\bbwatchlist\ext as type;

class bbwatchlist
{
	protected $db;
	protected $text_formatter_utils;
	protected $notifications;
	protected $user;
	protected $posts_table;
	protected $topics_table;
	protected $watch_keywords_table;

	protected $topic_subject;
	protected $post_content;
	public function __construct(\phpbb\db\driver\driver_interface $db, \phpbb\textformatter\utils_interface $text_formatter_utils, \phpbb\notification\manager $notifications, \phpbb\user $user, $posts_table, $topics_table, $watch_keywords_table)
	{
		$this->db = $db;
		$this->text_formatter_utils = $text_formatter_utils;
		$this->notifications = $notifications;
		$this->user = $user;
		$this->posts_table = $posts_table;
		$this->topics_table = $topics_table;
		$this->watch_keywords_table = $watch_keywords_table;
	}

	public function search_content($post_content)
	{
		// properly remove BBcodes WITHOUT replacing it with an empty space
		$post_content = preg_replace('/<s>.*<\/s>/U', '', $post_content);
		$post_content = preg_replace('/<e>.*<\/e>/U', '', $post_content);
		$post_content = strip_tags($post_content);

		$this->post_content = $post_content;
	}

	public function search_subject($topic_subject)
	{
		$this->topic_subject = $topic_subject;
	}

	public function search($post_id, $topic_id)
	{
		// fetch post data
		$sql_ary = [
			'SELECT'	=> 'p.post_id, p.topic_id, p.forum_id',
			'FROM'		=> [$this->posts_table => 'p'],
		];
		if ($post_id)
		{
			$sql_ary['WHERE'] = 'post_id = ' . (int) $post_id;
		}
		else
		{
			$sql_ary['LEFT_JOIN'] = [[
				'FROM'	=> [$this->topics_table => 't'],
				'ON'	=> 'p.topic_id = t.topic_id',
			]];
			$sql_ary['WHERE'] = 't.topic_id = ' . (int) $topic_id;
		}

		$result = $this->db->sql_query($this->db->sql_build_query('SELECT', $sql_ary));
		$post_data = $this->db->sql_fetchrow($result);
		$this->db->sql_freeresult($result);

		// fetch all watched keywords
		$sql = 'SELECT *
				FROM ' . $this->watch_keywords_table . '
				WHERE user_id <> ' . $this->user->data['user_id'];
		$result = $this->db->sql_query($sql);
		while ($row = $this->db->sql_fetchrow($result))
		{
			if ($row['search_type'] == type::SEARCH_TYPE_POST_CONTENT)
			{
				if (preg_match('/' . $row['keyword'] . '([^a-zA-Z0-9]+|$)/i', $this->post_content))
				{
					$this->notifications->add_notifications('sitesplat.bbwatchlist.notification.type.content_keyword', [
						'user_ids'	=> [$row['user_id']],
						'keyword'	=> $row['keyword'],
						'post_id'	=> $post_data['post_id'],
						'topic_id'	=> $post_data['topic_id'],
						'forum_id'	=> $post_data['forum_id'],
					]);
				}
			} elseif (!empty($this->topic_subject))
			{
				if (preg_match('/' . $row['keyword'] . '([^a-zA-Z0-9]+|$)/i', $this->topic_subject))
				{
					$this->notifications->add_notifications('sitesplat.bbwatchlist.notification.type.subject_keyword', [
						'user_ids'	=> [$row['user_id']],
						'keyword'	=> $row['keyword'],
						'post_id'	=> $post_data['post_id'],
						'topic_id'	=> $post_data['topic_id'],
						'forum_id'	=> $post_data['forum_id'],
					]);
				}
			}
		}
		$this->db->sql_freeresult($result);
	}

	// public function search($post_id, $topic_id)
	// {
	// 	$sql_ary = [
	// 		'SELECT'	=> 'p.post_id, p.topic_id, p.forum_id',
	// 		'FROM'		=> [$this->posts_table => 'p'],
	// 	];
	// 	if ($post_id)
	// 	{
	// 		$sql_ary['WHERE'] = 'post_id = ' . (int) $post_id;
	// 	}
	// 	else
	// 	{
	// 		$sql_ary['LEFT_JOIN'] = [[
	// 			'FROM'	=> [$this->topics_table => 't'],
	// 			'ON'	=> 'p.topic_id = t.topic_id',
	// 		]];
	// 		$sql_ary['WHERE'] = 't.topic_id = ' . (int) $topic_id;
	// 	}

	// 	$result = $this->db->sql_query($this->db->sql_build_query('SELECT', $sql_ary));
	// 	$post_data = $this->db->sql_fetchrow($result);
	// 	$this->db->sql_freeresult($result);

	// 	$sql = 'SELECT *
	// 			FROM ' . $this->watch_keywords_table . '
	// 			WHERE user_id <> ' . $this->user->data['user_id'] . '
	// 				AND (
	// 					(
	// 						search_type = ' . type::SEARCH_TYPE_POST_CONTENT . '
	// 						AND ' . $this->find_in_string($this->post_content) . '
	// 					)';
	// 	if (!empty($this->topic_subject))
	// 	{
	// 		$sql .= ' OR (
	// 			search_type = ' . type::SEARCH_TYPE_TOPIC_SUBJECT . '
	// 			AND ' . $this->find_in_string($this->topic_subject) . '
	// 		)';
	// 	}
	// 	$sql .= ')';
	// 	echo $sql;die;
	// 	$result = $this->db->sql_query($sql);
	// 	while ($row = $this->db->sql_fetchrow($result))
	// 	{
	// 		$notification_type = $row['search_type'] == type::SEARCH_TYPE_TOPIC_SUBJECT ? 'subject_keyword' : 'content_keyword';
	// 		$this->notifications->add_notifications('sitesplat.bbwatchlist.notification.type.' . $notification_type, [
	// 			'user_ids'	=> [$row['user_id']],
	// 			'keyword'	=> $row['keyword'],
	// 			'post_id'	=> $post_data['post_id'],
	// 			'topic_id'	=> $post_data['topic_id'],
	// 			'forum_id'	=> $post_data['forum_id'],
	// 		]);
	// 	}
	// 	$this->db->sql_freeresult($result);
	// }

	// protected function find_in_string($string)
	// {
	// 	switch ($this->db->get_sql_layer())
	// 	{
	// 		case 'mssql_odbc':
	// 		case 'mssqlnative':
	// 			return "CHARINDEX(LOWER(keyword), '" . $this->db->sql_escape(strtolower($string)) . "') <> 0";
	// 		case 'mysql':
	// 		case 'mysqli':
	// 		case 'oracle':
	// 			return "LOCATE(LOWER(keyword), '" . $this->db->sql_escape(strtolower($string)) . "') <> 0";
	// 		case 'postgres':
	// 			return "POSITION(LOWER(keyword) IN '" . $this->db->sql_escape(strtolower($string)) . "') <> 0";
	// 		case 'sqlite3':
	// 			return "INSTR('" . $this->db->sql_escape(strtolower($string)) . "', LOWER(keyword)) <> 0";
	// 	}
	// }
}
