<?php
/*
* @name base.php
* @package cBB Chat
* @version v1.1.3 10/03/2017
*
* @copyright (c) 2017 CaniDev
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/

namespace canidev\chat\compatibility;

// @ignore
if(!defined('IN_PHPBB'))
{
	exit;
}

class base
{
	public $name = '';

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
