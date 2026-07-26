<?php
/**
 * phpBB Gallery - ACP Cleanup permission tests
 *
 * @package   phpbbgallery/acpcleanup
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\acpcleanup\tests;

use phpbbgallery\acpcleanup\event\main_listener;
use PHPUnit\Framework\TestCase;

final class permission_listener_test extends TestCase
{
	public function test_cleanup_permission_is_registered_in_the_miscellaneous_category(): void
	{
		$listener = new main_listener();
		$event = new \phpbb\event\data(['permissions' => []]);

		$listener->add_permissions($event);

		$this->assertSame([
			'a_gallery_cleanup' => [
				'lang' => 'ACL_A_GALLERY_CLEANUP',
				'cat' => 'misc',
			],
		], $event['permissions']);
		$this->assertSame(['core.permissions' => 'add_permissions'], main_listener::getSubscribedEvents());
	}

	public function test_cleanup_listener_is_registered_as_a_service(): void
	{
		$services = (string) file_get_contents(dirname(__DIR__) . '/config/services.yml');

		$this->assertStringContainsString('phpbbgallery.acpcleanup.listener:', $services);
		$this->assertStringContainsString('class: phpbbgallery\\acpcleanup\\event\\main_listener', $services);
		$this->assertStringContainsString('- { name: event.listener }', $services);
	}

	public function test_every_language_defines_the_cleanup_permission(): void
	{
		$directories = glob(dirname(__DIR__) . '/language/*', GLOB_ONLYDIR) ?: [];
		$this->assertCount(11, $directories);

		foreach ($directories as $directory)
		{
			$lang = [];
			include $directory . '/permissions_gallery.php';

			$this->assertSame(['ACL_A_GALLERY_CLEANUP'], array_keys($lang), basename($directory));
			$this->assertNotSame('', $lang['ACL_A_GALLERY_CLEANUP'], basename($directory));
			$this->assertSame(1, preg_match('//u', $lang['ACL_A_GALLERY_CLEANUP']), basename($directory));
		}
	}
}
