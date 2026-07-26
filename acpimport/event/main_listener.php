<?php
/**
 * phpBB Gallery - ACP Import Extension
 *
 * @package   phpbbgallery/acpimport
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\acpimport\event;

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
	 * Register the ACP Import administrator permission.
	 *
	 * @param \phpbb\event\data $event phpBB permissions event
	 * @return void
	 */
	public function add_permissions(\phpbb\event\data $event): void
	{
		$event->update_subarray('permissions', 'a_gallery_import', [
			'lang' => 'ACL_A_GALLERY_IMPORT',
			'cat'  => 'misc',
		]);
	}
}
