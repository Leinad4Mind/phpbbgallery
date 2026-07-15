<?php
/*
* @package cBB Chat
* @version v1.2.1 01/02/2020
*
* @copyright (c) 2020 CaniDev
* @license https://opensource.org/licenses/gpl-license.php GNU Public License
*/

namespace canidev\chat\cron;

// @ignore
if(!defined('IN_PHPBB'))
{
	exit;
}

class prune extends \phpbb\cron\task\base
{
	protected $chat;
	protected $config;
	protected $db;
	protected $manager;

	/**
	 * Constructor
	 *
	 * @param \canidev\chat\libraries\chat 				$chat		Chat Object
	 * @param \phpbb\config\config						$config  	Config object
	 * @param \phpbb\db\driver\driver_interface			$db			DB Object
	 * @param \canidev\chat\libraries\action_manager	$manager	Action Manager Object
	 * @access public
	 */
	public function __construct(
		\canidev\chat\libraries\chat $chat,
		\phpbb\config\config $config,
		\phpbb\db\driver\driver_interface $db,
		\canidev\chat\libraries\action_manager $manager)
	{
		$this->chat			= $chat;
		$this->config		= $config;
		$this->db			= $db;
		$this->manager		= $manager;
	}

	/**
	 * Runs this cron task.
	 *
	 * @return void
	 */
	public function run()
	{
		$day_limit	= time() - 86400;
		$room_ary	= $this->chat->obtain_rooms();

		// Delete inactive guests (one day of inactivity)
		$sql = 'DELETE FROM ' . CHAT_USERS_TABLE . '
			WHERE user_id = ' . ANONYMOUS . '
			AND user_lastjoin < ' . $day_limit . '
			AND exclude_time = 0';
		$this->db->sql_query($sql);
		
		// Delete messages out of the limit
		$del_ary = $del_room_ary = array();
		
		foreach($room_ary as $row)
		{
			if($row['room_msg_limit'] > 0)
			{
				$del_room_ary[$row['room_id']] = $row['room_msg_limit'];
			}
		}
		
		if(sizeof($del_room_ary))
		{
			$sql = 'SELECT COUNT(cm.message_id) AS message_count, cm.dest_key
				FROM ' . CHAT_MESSAGES_TABLE . ' cm
				WHERE ' . $this->db->sql_in_set('cm.dest_key', array_keys($del_room_ary)) . '
				GROUP BY cm.dest_key';
			$result = $this->db->sql_query($sql);
			while($row = $this->db->sql_fetchrow($result))
			{
				if($row['message_count'] > $del_room_ary[$row['dest_key']])
				{
					$del_ary[$row['dest_key']] = $row['message_count'] - $del_room_ary[$row['dest_key']];
				}
			}
			$this->db->sql_freeresult($result);
			
			unset($del_room_ary);
		}
		
		foreach($del_ary as $dest_key => $num)
		{
			$sql = 'DELETE FROM ' . CHAT_MESSAGES_TABLE . '
				WHERE dest_key = ' . $dest_key . '
				ORDER BY message_time ASC';
			$this->db->sql_query_limit($sql, $num);
		}
		
		// Delete pm out of limit
		$pm_max_time = time() - ((int)$this->config['chat_pm_maxage'] * 86400);
		
		$sql = 'DELETE FROM ' . CHAT_MESSAGES_TABLE . '
			WHERE ' . $this->db->sql_in_set('dest_key', array_keys($room_ary), true) . '
			AND message_time < ' . $pm_max_time;
		$this->db->sql_query($sql);

		$this->config->set('chat_cron_lock', time());
	}

	/**
	 * Returns whether this cron task can run, given current board configuration.
	 *
	 * If warnings are set to never expire, this cron task will not run.
	 *
	 * @return bool
	 */
	public function is_runnable()
	{
		return true;
	}

	/**
	 * Returns whether this cron task should run now, because enough time
	 * has passed since it was last run (24 hours).
	 *
	 * @return bool
	 */
	public function should_run()
	{
		$day_limit	= time() - 86400; // yesterday (One day)

		return ($day_limit > (int)$this->config['chat_cron_lock']);
	}
}
