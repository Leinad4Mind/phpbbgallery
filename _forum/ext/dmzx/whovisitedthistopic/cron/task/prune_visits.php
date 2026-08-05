<?php
/**
 *
 * @package phpBB Extension - Who Visited This Topic
 * @copyright (c) 2016 dmzx - https://www.dmzx-web.net
 * @copyright (c) 2026 Leinad4Mind
 * @license https://opensource.org/licenses/GPL-2.0 GNU General Public License v2
 *
 */

namespace dmzx\whovisitedthistopic\cron\task;

use dmzx\whovisitedthistopic\core\visit_repository;
use phpbb\config\config;
use phpbb\cron\task\base;

class prune_visits extends base
{
	const INTERVAL = 86400;

	/** @var config */
	protected $config;

	/** @var visit_repository */
	protected $visits;

	public function __construct(config $config, visit_repository $visits)
	{
		$this->config = $config;
		$this->visits = $visits;
	}

	public function run()
	{
		$days = max(0, (int) $this->config['whovisitedthistopic_retention_days']);
		if ($days > 0)
		{
			$this->visits->prune_before(time() - ($days * 86400));
		}

		$this->config->set('whovisitedthistopic_prune_last_gc', time(), true);
	}

	public function is_runnable()
	{
		return (int) $this->config['whovisitedthistopic_retention_days'] > 0;
	}

	public function should_run()
	{
		return (int) $this->config['whovisitedthistopic_prune_last_gc'] < time() - self::INTERVAL;
	}
}
