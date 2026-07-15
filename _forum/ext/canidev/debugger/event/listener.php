<?php
/*
* @package cBB Debugger
* @version v1.0.0 21/06/2021
*
* @copyright (c) 2021 CaniDev
* @license https://opensource.org/licenses/gpl-license.php GNU Public License
*/

namespace canidev\debugger\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class listener implements EventSubscriberInterface
{
	/**
	* Constructor
	*
	* @param ContainerInterface 		$container			Service container interface
	*
	* @access public
	*/
	public function __construct(\Symfony\Component\DependencyInjection\ContainerInterface $container)
	{
		\canidev\core\lib::get_instance($container);
	}

	static public function getSubscribedEvents()
	{
		return array(
			'core.user_setup'		=> 'force_load',
		);
	}

	public function force_load()
	{
		// Do nothing here, only make sure __construct will be called.
	}
}
