<?php
/**
*
* @package PM SPy
* @copyright (c) 2016 ForumHulp.com
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace forumhulp\pmspy\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class acp_listener implements EventSubscriberInterface
{
	static public function getSubscribedEvents()
	{
		return array(
			'core.permissions'	=> 'add_permissions',
		);
	}

	/**
	* Register the PM Spy permission
	*
	* @param \phpbb\event\data $event The event object
	*
	* @return void
	* @access public
	*/
	public function add_permissions($event)
	{
		$event->update_subarray('permissions', 'a_pmspy', array('lang' => 'ACL_A_PMSPY', 'cat' => 'misc'));
	}
}
