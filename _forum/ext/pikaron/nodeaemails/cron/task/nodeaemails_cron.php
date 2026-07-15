<?php
/**
 *
 * No DEA Emails. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2019, Picaron, https://github.com/picaronin/
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace pikaron\nodeaemails\cron\task;

class nodeaemails_cron extends \phpbb\cron\task\base
{
	// /** @var functions */
	protected $functions_nodeaemails;

	/**
	 * Constructor
	 *
	 * @param \phpbb\config\config								 $config
	 * @param \pikaron\nodeaemails\core\functions_nodeaemails	 $functions_nodeaemails
	 */
	public function __construct(
		\pikaron\nodeaemails\core\functions_nodeaemails $functions_nodeaemails
	)
	{
		$this->functions_nodeaemails = $functions_nodeaemails;
	}

	/**
	 * Runs this cron task.
	 *
	 * @return void
	 */
	public function run()
	{
		$this->functions_nodeaemails->update_deas();
	}

	/**
	 * Returns whether this cron task can run, given current board configuration.
	 *
	 * For example, a cron task that prunes forums can only run when
	 * forum pruning is enabled.
	 *
	 * @return bool
	 */
	public function is_runnable()
	{
		return true;
	}

	/**
	 * Returns whether this cron task should run now, because enough time
	 * has passed since it was last run.
	 *
	 * @return bool
	 */
	public function should_run()
	{
		return $this->functions_nodeaemails->canrun_cron();
	}
}
