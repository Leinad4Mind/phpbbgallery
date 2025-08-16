<?php
/*
* @package Ext Common Core
* @version v1.0.15 28/03/2022
*
* @copyright (c) 2022 CaniDev
* @license https://creativecommons.org/licenses/by-nc/4.0/
*/

namespace canidev\core;

class editor_plugin
{
	protected $is_global 	= false;
	protected $is_enabled 	= false;
	
	protected $container;
	protected $wrapper;

	public function __construct($wrapper, $container = null)
	{
		$this->container 	= $container;
		$this->wrapper 		= $wrapper;
	}

	public function get_filename()
	{
		return '';
	}

	public function get_lang()
	{
		return false;
	}

	public function get_name()
	{
		return '';
	}

	public function is_enabled($status = null)
	{
		if($status === null)
		{
			return $this->is_enabled;
		}

		$this->is_enabled = (bool)$status;
	}

	public function is_global($status = null)
	{
		if($status === null)
		{
			return $this->is_global;
		}

		$this->is_global = (bool)$status;
	}
}
