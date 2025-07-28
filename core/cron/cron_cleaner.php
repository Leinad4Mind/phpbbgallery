<?php

/**
*
* @package phpBB Gallery Core
* @copyright (c) 2022 DreadDendy
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace phpbbgallery\core\cron;

/**
 * phpbbgallery cron task.
 */
class cron_cleaner extends \phpbb\cron\task\base
{
	/** @var \phpbbgallery\core\config  */
	protected $gallery_config;

	/** @var \phpbbgallery\core\upload  */
	protected $gallery_upload;

	/**
	 * Constructor
	 *
	 * @param \phpbbgallery\core\config $gallery_config
	 * @param \phpbbgallery\core\upload $gallery_upload
	 * @access public
	 */
	public function __construct(\phpbbgallery\core\config $gallery_config, \phpbbgallery\core\upload $gallery_upload)
	{
		$this->gallery_config = $gallery_config;
		$this->gallery_upload = $gallery_upload;
	}

	/**
	 * {@inheritDoc}
	 */
	public function run()
	{
		$this->gallery_upload->prune_orphan();
		$this->gallery_config->set('prune_orphan_time', time());
	}

	/**
	 * {@inheritDoc}
	 */
	public function should_run()
	{
		return $this->gallery_config->get('prune_orphan_time') < strtotime('24 hours ago');
	}

	/**
	 * {@inheritDoc}
	 */
	public function is_runnable()
	{
		return true;
	}
}
