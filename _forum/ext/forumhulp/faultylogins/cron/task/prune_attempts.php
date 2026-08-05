<?php
/**
 *
 * @package phpBB Extension - Faulty Logins
 * @copyright (c) 2014 John Peskens (http://ForumHulp.com)
 * @copyright (c) 2026 Leinad4Mind
 * @license https://opensource.org/licenses/GPL-2.0 GNU General Public License v2
 *
 */

namespace forumhulp\faultylogins\cron\task;

use forumhulp\faultylogins\core\attempt_repository;
use phpbb\config\config;
use phpbb\cron\task\base;

class prune_attempts extends base
{
	const INTERVAL = 86400;

	protected $config;
	protected $attempts;

	public function __construct(config $config, attempt_repository $attempts)
	{
		$this->config = $config;
		$this->attempts = $attempts;
	}

	public function run()
	{
		$days = max(1, (int) $this->config['faultylogins_retention_days']);
		$this->attempts->prune_before(time() - ($days * 86400));
		$this->config->set('faultylogins_prune_last_gc', time(), true);
	}

	public function is_runnable()
	{
		return !empty($this->config['faultylogins_initialized']);
	}

	public function should_run()
	{
		return (int) $this->config['faultylogins_prune_last_gc'] < time() - self::INTERVAL;
	}
}
