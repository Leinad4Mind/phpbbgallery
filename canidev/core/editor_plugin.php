<?php
/*
* @package Ext Common Core
* @version v1.0.4 01/02/2020
*
* @copyright (c) 2020 CaniDev
* @license https://opensource.org/licenses/gpl-license.php GNU Public License
*/

namespace canidev\core;

use Symfony\Component\DependencyInjection\ContainerInterface;

class editor_plugin
{
	protected $is_global = false;
	
	protected $wrapper;

	public function __construct($wrapper)
	{
		$this->wrapper = $wrapper;
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

	public function is_global($status = null)
	{
		if($status === null)
		{
			return $this->is_global;
		}

		$this->is_global = (bool)$status;
	}
}
