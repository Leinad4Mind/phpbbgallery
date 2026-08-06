<?php
/**
 *
 * Advanced Polls Cron Task
 *
 * @copyright (c) 2015 javiexin ( www.exincastillos.es )
 * @copyright (c) 2026 Leinad4Mind
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 * @author Javier Lopez (javiexin)
 */

namespace wolfsblvt\advancedpolls\cron\task;

class pollend extends \phpbb\cron\task\base
{
	protected $config;
	protected $db;
	protected $log;
	protected $user;
	protected $notification_manager;

	/**
	* Constructor.
	*/
	public function __construct(\phpbb\config\config $config, \phpbb\db\driver\driver_interface $db, \phpbb\log\log $log, \phpbb\user $user, \phpbb\notification\manager $notification_manager)
	{
		$this->set_name('wolfsblvt.advancedpolls.pollend');

		$this->config = $config;
		$this->db = $db;
		$this->log = $log;
		$this->user = $user;
		$this->notification_manager = $notification_manager;
	}

	/**
	* Runs this cron task.
	*
	* @return null
	*/
	public function run()
	{
		$now = time();

		// Process every due poll once. The persisted marker makes the task
		// recoverable after cache purges, poll edits and interrupted cron runs.
		$sql = 'SELECT topic_id, forum_id, topic_poster, topic_title, poll_title, poll_start + poll_length as poll_end
			FROM ' . TOPICS_TABLE . '
			WHERE poll_start > 0 AND poll_length > 0
			AND (wolfsblvt_poll_visibility IN (2, 3) OR wolfsblvt_poll_votes_hide = 1)
			AND wolfsblvt_poll_notified = 0
			AND poll_start + poll_length <= ' . $now . '
			ORDER BY poll_start + poll_length ASC';
		$result = $this->db->sql_query($sql);

		$polls = array();
		while ($row = $this->db->sql_fetchrow($result))
		{
			$polls[] = $row;
		}
		$this->db->sql_freeresult($result);

		foreach ($polls as $row)
		{
			$this->notification_manager->add_notifications('wolfsblvt.advancedpolls.notification.type.pollended', $row);

			$sql = 'UPDATE ' . TOPICS_TABLE . '
				SET wolfsblvt_poll_notified = 1
				WHERE topic_id = ' . (int) $row['topic_id'];
			$this->db->sql_query($sql);
		}

		$this->config->set('wolfsblvt.advancedpolls.pollend_last_gc', $now, false);
	}

	/**
	* Returns whether this cron task can run, given current board configuration.
	*
	* @return bool
	*/
	public function is_runnable()
	{
		return !empty($this->config['wolfsblvt.advancedpolls.activate_notifications']);
	}

	/**
	* Returns whether this cron task should run now, because enough time
	* has passed since it was last run.
	*
	* @return bool
	*/
	public function should_run()
	{
		$interval = max(60, (int) $this->config['wolfsblvt.advancedpolls.pollend_gc']);
		return (int) $this->config['wolfsblvt.advancedpolls.pollend_last_gc'] < time() - $interval;
	}
}
