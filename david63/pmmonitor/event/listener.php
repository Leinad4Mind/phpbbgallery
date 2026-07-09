<?php
/**
*
* @package PM Monitor Extension
* @copyright (c) 2015 david63
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace david63\pmmonitor\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
* Event listener
*/
class listener implements EventSubscriberInterface
{
	/**
	* Assign functions defined in this class to event listeners in the core
	*
	* @return array
	* @static
	* @access public
	*/
	static public function getSubscribedEvents()
	{
		return array(
			'core.permissions' => 'add_permission',
		);
	}

	/**
	* Add administrative permissions to Comms PM Monitor
	*
	* @param object $event The event object
	* @return null
	* @access public
	*/
	public function add_permission($event)
	{
		$permissions = $event['permissions'];
		$permissions['a_comms_pm_manage'] = array('lang' => 'ACL_A_COMMS_PM_MANAGE', 'cat' => 'misc');
		$event['permissions'] = $permissions;
	}
}
