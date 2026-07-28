<?php
/**
 * BBPrefix tests.
 *
 * @package BBprefix
 * @copyright (c) 2015 SiteSplat All rights reserved
 * @license Proprietary
 */

namespace sitesplat\bbprefix\tests;

/**
 * Records what the manager sends to phpBB's logger, so a test can assert the
 * right key and arguments reached it - and, just as importantly, that nothing
 * ever falls back to writing a file of its own.
 */
class fake_log
{
	/** @var array Every add() call: mode, user_id, log_ip, log_operation, additional_data */
	public array $calls = [];

	/** @var \Throwable|null Thrown on the next add(), to model a broken logger */
	public ?\Throwable $throw_on_add = null;

	public function add($mode, $user_id, $log_ip, $log_operation, $log_time = false, $additional_data = [])
	{
		if ($this->throw_on_add !== null)
		{
			$error = $this->throw_on_add;
			$this->throw_on_add = null;

			throw $error;
		}

		$this->calls[] = [
			'mode'				=> $mode,
			'user_id'			=> $user_id,
			'log_ip'			=> $log_ip,
			'log_operation'		=> $log_operation,
			'additional_data'	=> $additional_data,
		];

		return true;
	}
}
