<?php
/**
 * @package PM Monitor
 * @copyright (c) 2026 Leinad4Mind
 * @license GNU General Public License, version 2 (GPL-2.0)
 */

namespace leinad4mind\pmmonitor\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class listener implements EventSubscriberInterface
{
	public static function getSubscribedEvents()
	{
		return array(
			'core.permissions' => 'add_permissions',
		);
	}

	public function add_permissions($event)
	{
		$permissions = $event['permissions'];
		$permissions['a_pmmonitor_view'] = array('lang' => 'ACL_A_PMMONITOR_VIEW', 'cat' => 'misc');
		$permissions['a_pmmonitor_delete'] = array('lang' => 'ACL_A_PMMONITOR_DELETE', 'cat' => 'misc');
		$event['permissions'] = $permissions;
	}
}
