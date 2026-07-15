<?php

/**
 *
 * BBPoints extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2015-2022 SiteSplat All rights reserved
 * @license Proprietary
 *
 */

namespace sitesplat\bbpoints\cron\task\core;

/**
 * BB points cron task.
 */
class bbpoints extends \phpbb\cron\task\base
{
	protected $config;
	protected $user;
	protected $db;
	protected $bbpoints_table;

	public function __construct(\phpbb\config\config $config, \phpbb\user $user, \phpbb\db\driver\driver_interface $db, $bbpoints_table)
	{
		$this->config = $config;
		$this->user = $user;
		$this->db = $db;
		$this->bbpoints_table = $bbpoints_table;
		$this->bbpoints_config = json_decode($this->config['bbpoints_settings'], true);
	}

	/**
	 * Runs this cron task.
	 *
	 * @return null
	 */
	public function run()
	{
		$time = $this->user->create_datetime();
		$now = phpbb_gmgetdate($time->getTimestamp() + $time->getOffset());

		// Display birthdays of 29th february on 28th february in non-leap-years
		$leap_year_birthdays = '';
		if ($now['mday'] == 28 && $now['mon'] == 2 && !$time->format('L')) {
			$leap_year_birthdays = ' OR user_birthday LIKE "' . $this->db->sql_escape(sprintf("%2d-%2d-", 29, 2)) . '%"';
		}

		$sql = 'SELECT user_id FROM ' . USERS_TABLE . ' 
				WHERE user_birthday <> " 0- 0-   0" AND user_birthday <> "" AND 
				(user_birthday LIKE "' . $this->db->sql_escape(sprintf("%2d-%2d-", $now["mday"], $now["mon"])) . '%"' . $leap_year_birthdays . ') AND 
				bbpoints_birthday + 15778463 < UNIX_TIMESTAMP(now())';
		$result = $this->db->sql_query($sql);
		$user_ids = [];
		while ($row = $this->db->sql_fetchrow($result)) {
			$user_ids[] = $row['user_id'];
			$sql = 'INSERT INTO ' . $this->bbpoints_table . ' (from_id, to_id, bbpoints, reason, timestamp) 
					VALUES(0, ' . $row['user_id'] . ', ' . $this->bbpoints_config['per_birthday'] . ', "Happy birthday", ' . time() . ')';
			$this->db->sql_query($sql);
		}
		if (count($user_ids)) {
			$sql = 'UPDATE ' . USERS_TABLE . ' SET bbpoints_birthday = ' . time() . ' WHERE user_id IN (' . implode(',', $user_ids) . ')';
			$this->db->sql_query($sql);
		}
		$this->config->set('bbpoints_last_gc', time(), false);
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
		return $this->config['bbpoints_last_gc'] < time() - $this->config['bbpoints_gc'];
	}
}
