<?php
/*
* @name base.php
* @package cBB Blockgets
* @version v2.0.0 30/05/2017
*
* @copyright (c) 2017 CaniDev
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/

namespace canidev\blockgets\compatibility;

// @ignore
if(!defined('IN_PHPBB'))
{
	exit;
}

class base
{
	public $name = '';

	protected $dispatcher;
	protected $ext_manager;
	protected $helper;

	/**
	* Constructor
	*
	* @param \phpbb\event\dispatcher_interface		$phpbb_dispatcher	Event dispatcher
	* @param \phpbb\extension\manager 				$extension_manager	extension manager
	* @param \canidev\blockgets\libraries\helper	$helper				Blockgets helper Object
	*
	* @access public
	*/
	public function __construct($phpbb_dispatcher, $phpbb_extension_manager, $helper)
	{
		$this->dispatcher	= $phpbb_dispatcher;
		$this->ext_manager	= $phpbb_extension_manager;
		$this->helper		= $helper;
	}
	
	public function is_runnable()
	{
		return true;
	}
	
	public function get_core_events()
	{
		return array();
	}

	public function get_js_events()
	{
		return array();
	}
}
