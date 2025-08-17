<?php
/**
*
* @package Special Birthday
* @copyright (c) 2019 Leinad4Mind
* @license GNU General Public License, version 2 (GPL-2.0)
*
*/

namespace leinad4mind\specialbirthday\core;

use phpbb\extension\manager;

/**
* functions
*/
class functions
{
	/** @var \phpbb\extension\manager */
	protected $phpbb_extension_manager;

	/**
	* Constructor for functions
	*
	* @param \phpbb\extension\manager 	$phpbb_extension_manager	Extension manager
	*
	* @access public
	*/
	public function __construct(manager $phpbb_extension_manager)
	{
		$this->ext_manager	= $phpbb_extension_manager;

		$this->namespace	= __NAMESPACE__;
	}

	/**
	* Get the extension's namespace
	*
	* @return $extension_name
	* @access public
	*/
	public function get_ext_namespace($mode = 'php')
	{
		// Let's extract the extension name from the namespace
		$extension_name = substr($this->namespace, 0, -(strlen($this->namespace) - strrpos($this->namespace, '\\')));

		// Now format the extension name
		switch ($mode)
		{
			case 'php':
				$extension_name = str_replace('\\', '/', $extension_name);
			break;

			case 'twig':
				$extension_name = str_replace('\\', '_', $extension_name);
			break;
		}

		return $extension_name;
	}
}
