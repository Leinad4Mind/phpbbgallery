<?php

/**
 *
 * Staff Notifications. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2019-2020, Leinad4Mind
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace leinad4mind\staffnotifications;

use phpbb\db\driver\driver_interface as db_interface;
use phpbb\notification\manager as notification;
use phpbb\user;
use leinad4mind\staffnotifications\notification\type\ban_user;

class helper {

	/** @var \phpbb\user */
	protected $user;

	/** @var db_interface */
	protected $db;

	/** @var notification */
	protected $notification;

	/**
	 * @param user				$user
	 * @param db_interface		$db
	 * @param notification		$notification
	 */
	public function __construct(
		user $user,
		db_interface $db,
		notification $notification
	)
	{
		$this->user			= $user;
		$this->db			= $db;
		$this->notification	= $notification;
	}

	/**
	 * @param string $notification_type_name
	 * @param array $data
	 * @param array $options
	 * @return array
	 */
	public function add_notifications($notification_type_name, array $data, array $options = [])
	{
		$data = array_merge([
			'sender_id'	=> $this->user->data['user_id'],
		], $data);

		return $this->notification->add_notifications($notification_type_name, $data, $options);
	}

	/**
	 * @param int $ban_length Ban length in minutes
	 * @param string $ban_length_other Banned until date
	 * @return array Arguments for the STAFFNOTIFICATIONS_REFERENCE_DURATION language key
	 */
	public function get_ban_reference($ban_length, $ban_length_other)
	{
		if ($ban_length)
		{
			if ($ban_length != -1 || $ban_length_other)
			{
				return [
					'mode'		=> ban_user::DURATION_MINUTES,
					'duration'	=> $ban_length,
				];
			}

			return [
				'mode'		=> ban_user::DURATION_DATE,
				'duration'	=> $ban_length_other,
			];
		}

		return [
			'mode' => ban_user::DURATION_PERMANENTLY,
		];
	}

	/**
	 * @param array $usernames
	 * @return array
	 */
	public function get_user_ids($usernames)
	{
		return $this->query([
			'SELECT'	=> 'u.user_id',
			'FROM'		=> [USERS_TABLE => 'u'],
			'WHERE'		=> $this->db->sql_in_set('u.username_clean', array_map('utf8_clean_string', $usernames)),
		], 'user_id') ?: [];
	}

	/**
	 * @param int $topic_id
	 * @return string
	 */
	public function get_topic_poster($topic_id)
	{
		$topic_data = $this->get_topic_data([$topic_id], 'topic_poster');
		return reset($topic_data) ?: ANONYMOUS;
	}

	/**
	 * @param array $topic_ids
	 * @param bool|string $column
	 * @return array
	 */
	public function get_topic_data($topic_ids, $column = false)
	{
		return $this->query([
			'SELECT'	=> 't.topic_id, t.topic_poster, t.topic_title, t.forum_id',
			'FROM'		=> [TOPICS_TABLE => 't'],
			'WHERE'		=> $this->db->sql_in_set('t.topic_id', $topic_ids),
		], $column, 'topic_id');
	}

	/**
	 * @param int $post_id
	 * @return string
	 */
	public function get_post_subject($post_id)
	{
		$post_data = $this->get_post_data([$post_id], 'post_subject');
		return reset($post_data) ?: '';
	}

	/**
	 * @param array $post_ids
	 * @param bool|string $column
	 * @return array
	 */
	public function get_post_data($post_ids, $column = false)
	{
		return $this->query([
			'SELECT'	=> 'p.post_id, p.poster_id, p.post_subject, p.topic_id, p.forum_id',
			'FROM'		=> [POSTS_TABLE => 'p'],
			'WHERE'		=> $this->db->sql_in_set('p.post_id', $post_ids),
		], $column, 'post_id') ?: [];
	}

	/**
	 * @param array $sql_array
	 * @param array|string|bool $column
	 * @param string|bool $key
	 * @return array
	 */
	public function query(array $sql_array, $column = false, $key = false)
	{
		$sql = $this->db->sql_build_query('SELECT', $sql_array);
		$result = $this->db->sql_query($sql);
		$db_rows = $this->db->sql_fetchrowset($result);
		$this->db->sql_freeresult($result);

		$rows = [];

		foreach ($db_rows as $row)
		{
			$value = $column === false ? $row : $row[$column];

			if ($key === false)
			{
				$rows[] = $value;
			}
			else
			{
				$rows[$row[$key]] = $value;
			}
		}

		return $rows;
	}

	/**
	 * @param array $sql_array
	 * @return mixed
	 */
	public function query_one(array $sql_array)
	{
		$select = $sql_array['SELECT'];
		$column = strpos($select, '.') === false ? $select : explode('.', $select)[1];
		$rows = $this->query($sql_array, $column);
		return reset($rows);
	}
}

