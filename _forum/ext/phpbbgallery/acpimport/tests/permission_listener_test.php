<?php
/**
 * phpBB Gallery - ACP Import permission tests
 *
 * @package   phpbbgallery/acpimport
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\acpimport\tests;

use phpbbgallery\acpimport\event\main_listener;
use PHPUnit\Framework\TestCase;

final class permission_listener_test extends TestCase
{
	public function test_import_permission_is_registered_in_the_miscellaneous_category(): void
	{
		$listener = new main_listener();
		$event = new \phpbb\event\data(['permissions' => []]);

		$listener->add_permissions($event);

		$this->assertSame([
			'a_gallery_import' => [
				'lang' => 'ACL_A_GALLERY_IMPORT',
				'cat' => 'misc',
			],
		], $event['permissions']);
		$this->assertSame(['core.permissions' => 'add_permissions'], main_listener::getSubscribedEvents());
	}

	public function test_import_listener_is_registered_as_a_service(): void
	{
		$services = (string) file_get_contents(dirname(__DIR__) . '/config/services.yml');

		$this->assertStringContainsString('phpbbgallery.acpimport.listener:', $services);
		$this->assertStringContainsString('class: phpbbgallery\\acpimport\\event\\main_listener', $services);
		$this->assertStringContainsString('- { name: event.listener }', $services);
	}

	public function test_every_language_defines_the_import_permission(): void
	{
		$directories = glob(dirname(__DIR__) . '/language/*', GLOB_ONLYDIR) ?: [];
		$this->assertCount(11, $directories);

		foreach ($directories as $directory)
		{
			$lang = [];
			include $directory . '/permissions_gallery.php';

			$this->assertSame(['ACL_A_GALLERY_IMPORT'], array_keys($lang), basename($directory));
			$this->assertNotSame('', $lang['ACL_A_GALLERY_IMPORT'], basename($directory));
			$this->assertSame(1, preg_match('//u', $lang['ACL_A_GALLERY_IMPORT']), basename($directory));
		}
	}
}
