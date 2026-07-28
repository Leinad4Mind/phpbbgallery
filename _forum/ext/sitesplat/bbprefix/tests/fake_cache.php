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
 * Records what the manager asks of the cache, so a test can assert both what was
 * read and - just as importantly - what was never written.
 */
class fake_cache
{
	/** @var array Stored values, keyed the way the manager keys them */
	public array $store = [];

	/** @var array Every put() call: key => [value, ttl] */
	public array $writes = [];

	/** @var \Throwable|null Thrown on the next get(), to model a broken backend */
	public ?\Throwable $throw_on_get = null;

	public function get($var)
	{
		if ($this->throw_on_get !== null)
		{
			$error = $this->throw_on_get;
			$this->throw_on_get = null;

			throw $error;
		}

		// phpBB returns false for a miss, which is exactly the distinction the
		// manager used to get wrong.
		return array_key_exists($var, $this->store) ? $this->store[$var] : false;
	}

	public function put($var, $data, $ttl = 31536000)
	{
		$this->store[$var] = $data;
		$this->writes[$var] = ['data' => $data, 'ttl' => $ttl];
	}

	public function destroy($var, $table = '')
	{
		unset($this->store[$var], $this->writes[$var]);
	}
}
