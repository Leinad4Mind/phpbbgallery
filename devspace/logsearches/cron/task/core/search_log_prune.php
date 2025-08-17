<?php
/**
 *
 * @package Log Searches Extension
 * @copyright (c) 2022 devspace
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace devspace\logsearches\cron\task\core;

/**
 * @ignore
 */
use phpbb\config\config;
use phpbb\db\driver\driver_interface;
use phpbb\log\log;
use phpbb\user;

class search_log_prune extends \phpbb\cron\task\base
{
	/** @var config */
	protected $config;

	/** @var driver_interface */
	protected $db;

	/** @var log */
	protected $log;

	/** @var user */
	protected $user;

	/** @var array phpBB tables */
	protected $tables;

	/**
	 * Constructor.
	 *
	 * @param phpbb_config       $config     The config
	 * @param phpbb_db_driver    $db         The db connection
	 * @param log                $log        Log object
	 * @param user               $user       User object
	 * @param array              $tables     phpBB db tables
	 */
	public function __construct(config $config, driver_interface $db, log $log, user $user, $tables)
	{
		$this->config = $config;
		$this->db     = $db;
		$this->log    = $log;
		$this->user   = $user;
		$this->tables = $tables;
	}

	/**
	 * Runs this cron task.
	 *
	 * @return null
	 */
	public function run()
	{
		if ($this->config['search_log_prune_days'] > 0)
		{
			$last_log = time() - ($this->config['search_log_prune_days'] * $this->config['search_log_prune_gc']);

			$and = ($this->config['search_log_prune_all']) ? '' : 'AND log_search_type <> 0';

			$sql = 'DELETE FROM ' . $this->tables['search_log'] . '
                WHERE log_time < ' . (int) $last_log . "
                $and";
			$this->db->sql_query($sql);

			$this->log->add('admin', $this->user->data['user_id'], $this->user->ip, 'SEARCH_LOG_PRUNE_LOG');

			$this->config->set('search_log_prune_last_gc', time(), true);
		}
	}

	/**
	 * Returns whether this cron task can run, given current board configuration.
	 *
	 * @return bool
	 */
	public function is_runnable()
	{
		return (bool) $this->config['search_log_prune_days'] > 0;
	}

	/**
	 * Returns whether this cron task should run now, because enough time
	 * has passed since it was last run.
	 *
	 * @return bool
	 */
	public function should_run()
	{
		return $this->config['search_log_prune_days'] > 0 && time() > ($this->config['search_log_prune_last_gc'] + $this->config['search_log_prune_gc']);
	}
}
