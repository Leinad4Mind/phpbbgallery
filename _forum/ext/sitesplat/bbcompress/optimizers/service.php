<?php
/**
*
* BBcompress
*
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\bbcompress\optimizers;

use Symfony\Component\DependencyInjection\ContainerInterface;

class service
{
	protected $container;
	protected $driver;
	protected $config;
	protected $db;
	protected $user;
	protected $table_prefix;

	public function __construct(ContainerInterface $container, \phpbb\config\config $config, \phpbb\db\driver\driver_interface $db, \phpbb\user $user, $table_prefix)
	{
		$this->container = $container;
		$this->config = $config;
		$this->db = $db;
		$this->user = $user;
		$this->table_prefix = $table_prefix;

		$this->set_driver($this->container->get('sitesplat.bbcompress.optimizers.driver.' . $this->config['bbcompress_driver']));
	}

	/**
	* Replaces the optimizer driver used by this optimizer service.
	*
	* @param \sitesplat\bbcompress\optimizers\driver\driver_interface $driver The optimizer driver
	*/
	public function set_driver(\sitesplat\bbcompress\optimizers\driver\driver_interface $driver)
	{
		$this->driver = $driver;
	}

	public function optimize_image($img_src)
	{
		$original_size = filesize($img_src);

		if ($this->driver->optimize_image($img_src))
		{
			// optimized? Nice! Count the saved storage
			clearstatcache();
			$optimized_size = filesize($img_src);
			$this->config->set('bbcompress_saved_storage', $this->config['bbcompress_saved_storage'] + $original_size - $optimized_size);
		}
	}
}
