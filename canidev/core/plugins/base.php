<?php
/*
* @package Ext Common Core
* @version v1.0.16 22/04/2022
*
* @copyright (c) 2022 CaniDev
* @license https://creativecommons.org/licenses/by-nc/4.0/
*/

namespace canidev\core\plugins;

use Symfony\Component\DependencyInjection\ContainerInterface;

class base
{
	public $name = '';

	protected $container;

	/**
	* Constructor
	*
	* @param ContainerInterface 	$container		Service container interface
	*
	* @access public
	*/
	public function __construct(ContainerInterface $container)
	{
		$this->container = $container;
	}
	
	/**
	 * Define if plugin can be loaded
	 * @return bool
	 */
	public function is_runnable()
	{
		return true;
	}
	
	/**
	 * Obtain php events of the plugin
	 * @return array
	 */
	public function core_events()
	{
		return array();
	}

	/**
	 * Obtain main javascript events of the plugin
	 * @return array
	 */
	public function frontend_js_events()
	{
		return array();
	}
	
	/**
	 * Obtain admin javascript events of the plugin
	 * @return array
	 */
	public function admin_js_events()
	{
		return array();
	}
}
