<?php
/**
 * BBPoints event dispatcher test double.
 *
 * @package sitesplat/bbpoints
 * @copyright (c) 2015-2026 SiteSplat All rights reserved
 * @license Proprietary
 */

namespace sitesplat\bbpoints\tests;

final class fake_dispatcher implements \phpbb\event\dispatcher_interface
{
	public array $events = [];

	public function trigger_event($event_name, $data = [])
	{
		$this->events[] = [$event_name, $data];
		return $data;
	}
}
