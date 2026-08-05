<?php
/**
*
* @package PostsStatistics
* @copyright (c) 2014 ForumHulp.com
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace forumhulp\postsstats\event;

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
	* Register the Posts Statistics permission
	*
	* @param \phpbb\event\data $event The event object
	*
	* @return void
	* @access public
	*/
	public function add_permissions($event)
	{
		$event->update_subarray('permissions', 'a_postsstats', array('lang' => 'ACL_A_POSTSSTATS', 'cat' => 'misc'));
	}
}
