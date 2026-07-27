<?php
/**
 * Minimal phpBB event dispatcher stub for isolated BBTags tests.
 *
 * @copyright (c) 2015 SiteSplat All rights reserved
 * @license Proprietary
 */

namespace phpbb\event;

interface dispatcher_interface
{
	public function trigger_event(string $event_name, array $data = []): array;
}
