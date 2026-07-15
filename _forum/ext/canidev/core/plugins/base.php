<?php
/*
* @package Ext Common Core
* @version v1.0.10 09/07/2021
*
* @copyright (c) 2021 CaniDev
* @license https://opensource.org/licenses/gpl-license.php GNU Public License
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
	
	public function is_runnable()
	{
		return true;
	}
	
	public function core_events()
	{
		return array();
	}

	public function frontend_js_events()
	{
		return array();
	}
	
	public function admin_js_events()
	{
		return array();
	}
}
