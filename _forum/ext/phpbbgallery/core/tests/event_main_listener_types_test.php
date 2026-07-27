<?php
/**
 * phpBB Gallery - Main event listener tests
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\tests;

use phpbbgallery\core\event\main_listener;
use PHPUnit\Framework\TestCase;

final class event_main_listener_types_test extends TestCase
{
	public function test_main_listener_properties_and_methods_are_fully_typed(): void
	{
		$reflection = new \ReflectionClass(main_listener::class);

		foreach ($reflection->getProperties() as $property)
		{
			if ($property->getDeclaringClass()->getName() === main_listener::class)
			{
				$this->assertNotNull($property->getType(), main_listener::class . '::$' . $property->getName());
			}
		}

		foreach ($reflection->getMethods() as $method)
		{
			if ($method->getDeclaringClass()->getName() !== main_listener::class)
			{
				continue;
			}

			foreach ($method->getParameters() as $parameter)
			{
				$this->assertNotNull($parameter->getType(), main_listener::class . '::' . $method->getName() . '($' . $parameter->getName() . ')');
			}

			if (!$method->isConstructor())
			{
				$this->assertNotNull($method->getReturnType(), main_listener::class . '::' . $method->getName() . '()');
			}
		}
	}

	public function test_subscribed_event_map_remains_stable(): void
	{
		$this->assertSame([
			'core.permissions' => 'add_permissions',
			'core.user_setup' => 'load_language_on_setup',
			'core.page_header' => 'add_page_header_link',
			'core.memberlist_view_profile' => 'user_profile_galleries',
			'core.ucp_profile_info_modify_sql_ary' => 'preserve_personal_album_profile_field',
		], main_listener::getSubscribedEvents());
	}

	public function test_gallery_administrator_permissions_are_registered(): void
	{
		$event = new \phpbb\event\data(['permissions' => []]);

		$this->listener($this->createStub(\phpbb\db\driver\driver_interface::class))->add_permissions($event);

		$this->assertSame([
			'a_gallery_manage' => [
				'lang' => 'ACL_A_GALLERY_MANAGE',
				'cat' => 'settings',
			],
			'a_gallery_albums' => [
				'lang' => 'ACL_A_GALLERY_ALBUMS',
				'cat' => 'permissions',
			],
		], $event['permissions']);
	}

	public function test_page_header_exposes_the_configured_gallery_title_without_enabling_the_menu(): void
	{
		$template = $this->createMock(\phpbb\template\template::class);
		$template->expects($this->once())
			->method('assign_var')
			->with('GALLERY_TITLE', 'My Photos');
		$language = $this->createStub(\phpbb\language\language::class);
		$config = $this->createMock(\phpbbgallery\core\config::class);
		$config->expects($this->once())
			->method('get_title')
			->with($language)
			->willReturn('My Photos');
		$config->expects($this->once())
			->method('get')
			->with('disp_gallery_icon')
			->willReturn(false);
		$reflection = new \ReflectionClass(main_listener::class);
		$listener = $reflection->newInstanceWithoutConstructor();
		$this->set_property($listener, 'template', $template);
		$this->set_property($listener, 'language', $language);
		$this->set_property($listener, 'gallery_config', $config);

		$listener->add_page_header_link(new \phpbb\event\data([]));
	}

	public function test_profile_update_preserves_the_managed_personal_album(): void
	{
		$db = $this->createMock(\phpbb\db\driver\driver_interface::class);
		$db->expects($this->once())
			->method('sql_query')
			->with($this->stringContains('WHERE user_id = 9'))
			->willReturn('result');
		$db->expects($this->once())
			->method('sql_fetchrow')
			->with('result')
			->willReturn(['personal_album_id' => 31]);
		$db->expects($this->once())
			->method('sql_freeresult')
			->with('result');
		$user = new \phpbb\user();
		$user->data = ['user_id' => 9];
		$listener = $this->listener($db, $user);
		$event = new \phpbb\event\data([
			'cp_data' => ['pf_gallery_palbum' => '999'],
		]);

		$listener->preserve_personal_album_profile_field($event);

		$this->assertSame(31, $event['cp_data']['pf_gallery_palbum']);
	}

	public function test_profile_update_without_the_managed_field_avoids_a_query(): void
	{
		$db = $this->createMock(\phpbb\db\driver\driver_interface::class);
		$db->expects($this->never())->method('sql_query');
		$event = new \phpbb\event\data(['cp_data' => ['pf_location' => 'Lisbon']]);

		$this->listener($db)->preserve_personal_album_profile_field($event);

		$this->assertSame(['pf_location' => 'Lisbon'], $event['cp_data']);
	}

	private function listener(\phpbb\db\driver\driver_interface $db, ?\phpbb\user $user = null): main_listener
	{
		$user ??= new \phpbb\user();
		$reflection = new \ReflectionClass(main_listener::class);
		$listener = $reflection->newInstanceWithoutConstructor();
		$this->set_property($listener, 'user', $user);
		$this->set_property($listener, 'db', $db);
		$this->set_property($listener, 'users_table', 'phpbb_gallery_users');

		return $listener;
	}

	private function set_property(object $object, string $property, mixed $value): void
	{
		$reflection = new \ReflectionProperty($object, $property);
		$reflection->setValue($object, $value);
	}
}
