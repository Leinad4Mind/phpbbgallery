<?php
/*
* @name base.php
* @package Ext Common Core
* @version v1.0.1 05/02/2019
*
* @copyright (c) 2019 CaniDev
* @license https://opensource.org/licenses/gpl-license.php GNU Public License
*/

namespace canidev\core\compatibility;

// @ignore
if(!defined('IN_PHPBB'))
{
	exit;
}

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
	public function __construct($container)
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
