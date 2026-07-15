<?php
/**
 * @package cBB Chat
 * @version 1.2.6 01/07/2024
 *
 * @copyright (c) 2024 CaniDev
 * @license https://creativecommons.org/licenses/by-nc/4.0/
 */

namespace canidev\chat\cron;

class prune extends \phpbb\cron\task\base
{
	protected $chat;
	protected $config;
	protected $db;
	protected $tables;

	/**
	 * Constructor
	 *
	 * @param \canidev\chat\libraries\chat 				$chat		Chat Object
	 * @param \phpbb\config\config						$config  	Config object
	 * @param \phpbb\db\driver\driver_interface			$db			DB Object
	 * @param array 									$tables 	Chat DB Tables
	 * 
	 * @access public
	 */
	public function __construct(
		\canidev\chat\libraries\chat $chat,
		\phpbb\config\config $config,
		\phpbb\db\driver\driver_interface $db,
		$tables)
	{
		$this->chat			= $chat;
		$this->config		= $config;
		$this->db			= $db;
		$this->tables 		= $tables;
	}

	/**
	 * {@inheritDoc}
	 */
	public function run()
	{
		$day_limit	= time() - 86400;
		$room_ary	= $this->chat->obtain_rooms();

		// Delete inactive guests (one day of inactivity)
		$sql = 'DELETE FROM ' . $this->tables['users'] . '
			WHERE user_id = ' . ANONYMOUS . '
			AND user_lastjoin < ' . $day_limit . '
			AND exclude_time = 0';
		$this->db->sql_query($sql);
		
		// Delete messages out of the limit
		$del_ary = $del_room_ary = [];
		
		foreach($room_ary as $row)
		{
			if($row['room_msg_limit'] > 0)
			{
				$del_room_ary[$row['room_key']] = $row['room_msg_limit'];
			}
		}

		if(sizeof($del_room_ary))
		{
			$sql = 'SELECT COUNT(cm.message_id) AS message_count, cm.dest_key
				FROM ' . $this->tables['messages'] . ' cm
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
			$sql = 'DELETE FROM ' . $this->tables['messages'] . '
				WHERE dest_key = ' . $dest_key . '
				ORDER BY message_time ASC';
			$this->db->sql_query_limit($sql, $num);
		}
		
		// Delete pm out of limit
		$pm_max_time = time() - ((int)$this->config['chat_pm_maxage'] * 86400);
		
		$sql = 'DELETE FROM ' . $this->tables['messages'] . '
			WHERE ' . $this->db->sql_in_set('dest_key', array_keys($room_ary), true) . '
			AND message_time < ' . $pm_max_time;
		$this->db->sql_query($sql);

		$this->config->set('chat_cron_lock', time());
	}

	/**
	 * {@inheritDoc}
	 */
	public function is_runnable()
	{
		return true;
	}

	/**
	 * {@inheritDoc}
	 */
	public function should_run()
	{
		$day_limit	= time() - 86400; // yesterday (One day)

		return ($day_limit > (int)$this->config['chat_cron_lock']);
	}
}
