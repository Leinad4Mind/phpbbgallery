<?php
/**
*
* @package BBnewsletter
* @copyright (c) 2016 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\newsletter\cron\task\core;

/**
 * Who visited me cron task.
 */
class newsletter extends \phpbb\cron\task\base
{
	protected $config;
	protected $helper;

	/**
	 * Constructor
	 *
	 * @access public
	 */
	public function __construct(\phpbb\config\config $config, \sitesplat\newsletter\helper\helper $helper)
	{
		$this->config	= $config;
		$this->helper	= $helper;
	}

	/**
	 * Runs this cron task.
	 *
	 * @return null
	 */
	public function run()
	{
		$this->helper->send_letter(json_decode($this->config['newsletter_settings'], true));
		$this->config->set('newsletter_last_gc', time());
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
		$config_aray = json_decode($this->config['newsletter_settings'], true);
		return ($this->config['email_enable'] && $config_aray['period']);
	}

	/**
	 * Returns whether this cron task should run now, because enough time
	 * has passed since it was last run (1 week).
	 *
	 * @return bool
	 */
	public function should_run()
	{
		return $this->config['newsletter_last_gc'] < time() - $this->config['newsletter_gc'];
	}
}
