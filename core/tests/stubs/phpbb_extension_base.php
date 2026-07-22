<?php
/**
 * Minimal phpBB extension base stub for isolated Gallery tests.
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbb\extension;

class base
{
	/** @var object */
	protected $container;

	public function enable_step($old_state)
	{
		return false;
	}

	public function disable_step($old_state)
	{
		return false;
	}

	public function purge_step($old_state)
	{
		return false;
	}
}
