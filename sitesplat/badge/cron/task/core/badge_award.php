<?php
/**
*
* Badge Award extension for the phpBB Forum Software package.
*
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\badge\cron\task\core;

use phpbb\config\config;
use sitesplat\badge\conditions\manager;

/**
 * Badge Award cron task.
 */
class badge_award extends \phpbb\cron\task\base
{
	/** @var \phpbb\config\config */
	protected $config;

	/** @var \sitesplat\badge\conditions\manager */
	protected $manager;

	/**
	 * Constructor
	 *
	 * @param \phpbb\config\config                 $config  Config object
	 * @param \sitesplat\badge\conditions\manager $manager Badge Award condition manager object
	 * @access public
	 */
	public function __construct(config $config, manager $manager)
	{
		$this->config = $config;
		$this->manager = $manager;
	}

	/**
	 * Runs this cron task.
	 *
	 * @return null
	 */
	public function run()
	{
		$this->manager->check_conditions();
		$this->config->set('badgeaward_last_gc', time(), false);
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
		return $this->config['badgeaward_last_gc'] < time() - $this->config['badgeaward_gc'];
	}
}
