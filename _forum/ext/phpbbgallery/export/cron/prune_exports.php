<?php
/**
 * phpBB Gallery - Export Extension
 *
 * @package   phpbbgallery/export
 * @author    Leinad4Mind
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\export\cron;

use phpbbgallery\export\job_storage;

/**
 * Remove downloaded exports once they have had their chance to be collected.
 *
 * Only archives that were meant to be downloaded expire. One an administrator asked
 * to leave on the server exists precisely so it can be picked up over FTP days
 * later, and deleting that on a timer would throw away what they asked for; those
 * go only when they are deleted from the ACP.
 */
class prune_exports extends \phpbb\cron\task\base
{
	/** Look for expired archives at most once an hour. */
	private const PRUNE_INTERVAL = 3600;

	/** @var \phpbb\config\config */
	protected \phpbb\config\config $config;

	/** @var \phpbbgallery\export\job_storage */
	protected job_storage $storage;

	/**
	 * Constructor
	 *
	 * @param \phpbb\config\config             $config  Config object
	 * @param \phpbbgallery\export\job_storage $storage Job storage
	 */
	public function __construct(\phpbb\config\config $config, job_storage $storage)
	{
		$this->config = $config;
		$this->storage = $storage;
	}

	/**
	 * {@inheritDoc}
	 */
	public function run(): void
	{
		$ttl = max(60, (int) $this->config['phpbb_gallery_export_ttl']);

		foreach ($this->storage->expired($ttl) as $state)
		{
			$this->storage->remove_job($state);
		}

		$this->config->set('phpbb_gallery_export_prune_time', time());
	}

	/**
	 * {@inheritDoc}
	 */
	public function should_run(): bool
	{
		return (int) $this->config['phpbb_gallery_export_prune_time'] < (time() - self::PRUNE_INTERVAL);
	}

	/**
	 * {@inheritDoc}
	 */
	public function is_runnable(): bool
	{
		return true;
	}
}
