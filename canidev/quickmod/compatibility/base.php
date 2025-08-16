<?php
/*
* @name base.php
* @package cBB QuickMod
* @version 1.1.0 17/01/2017
*
* @copyright (c) 2017 CaniDev
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/

namespace canidev\quickmod\compatibility;

// @ignore
if(!defined('IN_PHPBB'))
{
	exit;
}

class base
{
	public $name		= '';
	public $sources		= array();

	protected $ext_manager;

	/**
	* Constructor
	*
	* @param \phpbb\extension\manager 		$extension_manager	extension manager
	*
	* @access public
	*/
	public function __construct($phpbb_extension_manager)
	{
		$this->ext_manager	= $phpbb_extension_manager;
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
