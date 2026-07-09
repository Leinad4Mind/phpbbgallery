<?php
/**
 *
* @package BBprefix
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
 *
 */

namespace sitesplat\bbprefix\core;

trait loadable
{
	/**
	 * Whether or not the object has been loaded
	 * @var bool
	 */
	protected $loaded = false;

	/**
	 * Whether or not the object exists in the database
	 * @var bool
	 */
	protected $exists = false;

	/**
	 * Load a loadable item
	 *
	 * The class that uses this should have $this->cache and $this->db defined
	 * properly.
	 *
	 * @param string $cache_name Name of the cache item to check for
	 * @param int $id The ID of the given item
	 * @param string $sql The query string to run
	 * @return array Data from either the cache or database
	 */
	public function load($cache_name, $id, $sql)
	{
		if ((false === $prefix = $this->cache->get($cache_name)) || empty($prefix[$id]))
		{
			$result = $this->db->sql_query($sql);
			$row = $this->db->sql_fetchrow($result);
			$this->db->sql_freeresult($result);

			$prefix[$id] = $row;
			$this->cache->put($cache_name, $prefix);
		}
		else
		{
			$row = $prefix[$id];
		}

		$this->exists = (bool) sizeof($row);
		$this->loaded = true;

		return $row ?: [];
	}

	/**
	 * Determine whether the item has been loaded
	 *
	 * @return bool
	 */
	public function loaded()
	{
		return $this->loaded;
	}

	/**
	 * Determine whether the item exists in the database
	 *
	 * @return bool
	 */
	public function exists()
	{
		return $this->exists;
	}
}
