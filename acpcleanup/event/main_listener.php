<?php
/**
 * phpBB Gallery - ACP Cleanup Extension
 *
 * @package   phpbbgallery/acpcleanup
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\acpcleanup\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class main_listener implements EventSubscriberInterface
{
	public static function getSubscribedEvents(): array
	{
		return [
			'core.permissions' => 'add_permissions',
		];
	}

	/**
	 * Register the ACP Cleanup administrator permission.
	 *
	 * @param \phpbb\event\data $event phpBB permissions event
	 * @return void
	 */
	public function add_permissions(\phpbb\event\data $event): void
	{
		$event->update_subarray('permissions', 'a_gallery_cleanup', [
			'lang' => 'ACL_A_GALLERY_CLEANUP',
			'cat'  => 'misc',
		]);
	}
}
