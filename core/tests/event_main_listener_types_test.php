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
			'core.index_modify_page_title' => 'display_forum_index_images',
			'core.memberlist_view_profile' => 'user_profile_galleries',
			'core.ucp_profile_info_modify_sql_ary' => 'preserve_personal_album_profile_field',
			'core.viewonline_overwrite_location' => 'overwrite_viewonline_location',
			'phpbbgallery.core.viewimage' => 'mark_image_viewed',
			'phpbbgallery.core.image.delete_images' => 'remove_image_read_markers',
		], main_listener::getSubscribedEvents());
	}

	public function test_user_setup_exposes_the_active_image_bbcode_and_optional_id_control(): void
	{
		$template = $this->createMock(\phpbb\template\template::class);
		$template->expects($this->once())
			->method('assign_vars')
			->with([
				'GALLERY_BBCODE_TAG' => 'galleryimage',
				'S_GALLERY_IMAGE_ID_BBCODE' => true,
			]);
		$config = $this->createMock(\phpbbgallery\core\config::class);
		$config->expects($this->once())
			->method('get_bbcode_tag')
			->willReturn('galleryimage');
		$config->method('get')->willReturnMap([
			['disp_image_id', null, true],
			['disp_total_images', null, false],
		]);
		$listener = $this->listener($this->createStub(\phpbb\db\driver\driver_interface::class));
		$this->set_property($listener, 'template', $template);
		$this->set_property($listener, 'gallery_config', $config);
		$event = new \phpbb\event\data(['lang_set_ext' => []]);

		$listener->load_language_on_setup($event);

		$this->assertSame([[
			'ext_name' => 'phpbbgallery/core',
			'lang_set' => ['info_acp_gallery', 'gallery', 'gallery_notifications'],
		]], $event['lang_set_ext']);
	}

	public function test_viewonline_location_is_delegated_without_touching_unrelated_event_data(): void
	{
		$online_location = $this->createMock(\phpbbgallery\core\online_location::class);
		$online_location->expects($this->once())
			->method('resolve')
			->with('app.php/gallery')
			->willReturn([
				'location' => 'Viewing Gallery',
				'location_url' => '/gallery',
			]);
		$listener = $this->listener($this->createStub(\phpbb\db\driver\driver_interface::class));
		$this->set_property($listener, 'online_location', $online_location);
		$event = new \phpbb\event\data([
			'row' => ['session_page' => 'app.php/gallery'],
			'location' => 'Board index',
			'location_url' => '/index.php',
		]);

		$listener->overwrite_viewonline_location($event);

		$this->assertSame('Viewing Gallery', $event['location']);
		$this->assertSame('/gallery', $event['location_url']);
		$this->assertSame(['session_page' => 'app.php/gallery'], $event['row']);
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

	public function test_page_header_exposes_a_bounded_accessible_unread_badge(): void
	{
		$template = $this->createMock(\phpbb\template\template::class);
		$template->expects($this->once())->method('assign_var')->with('GALLERY_TITLE', 'Gallery');
		$template->expects($this->once())->method('assign_vars')->with([
			'U_GALLERY' => '/gallery',
			'S_GALLERY_NEW_IMAGES' => true,
			'GALLERY_NEW_IMAGES_DISPLAY' => '99+',
			'GALLERY_NEW_IMAGES_LABEL' => '100 new images',
		]);
		$language = $this->createMock(\phpbb\language\language::class);
		$language->expects($this->once())
			->method('lang')
			->with('GALLERY_NEW_IMAGES_COUNT', 100)
			->willReturn('100 new images');
		$config = $this->createMock(\phpbbgallery\core\config::class);
		$config->method('get')->willReturnMap([
			['disp_gallery_icon', null, 1],
			['disp_new_image_count', null, 1],
		]);
		$config->method('get_title')->with($language)->willReturn('Gallery');
		$helper = $this->createMock(\phpbb\controller\helper::class);
		$helper->expects($this->once())->method('route')->with('phpbbgallery_core_index')->willReturn('/gallery');
		$counter = $this->createMock(\phpbbgallery\core\unread_counter::class);
		$counter->expects($this->once())->method('count')->willReturn(100);
		$access = $this->createMock(\phpbbgallery\core\album_access::class);
		$access->expects($this->once())->method('has_any')->willReturn(true);
		$user = new \phpbb\user();
		$user->data = ['is_bot' => false];
		$reflection = new \ReflectionClass(main_listener::class);
		$listener = $reflection->newInstanceWithoutConstructor();
		$this->set_property($listener, 'template', $template);
		$this->set_property($listener, 'language', $language);
		$this->set_property($listener, 'gallery_config', $config);
		$this->set_property($listener, 'helper', $helper);
		$this->set_property($listener, 'user', $user);
		$this->set_property($listener, 'album_access', $access);
		$this->set_property($listener, 'unread_counter', $counter);

		$listener->add_page_header_link(new \phpbb\event\data([]));
	}

	public function test_page_header_badge_can_be_disabled_without_counting(): void
	{
		$template = $this->createMock(\phpbb\template\template::class);
		$template->expects($this->once())->method('assign_var')->with('GALLERY_TITLE', 'Gallery');
		$template->expects($this->once())->method('assign_vars')->with(['U_GALLERY' => '/gallery']);
		$language = $this->createStub(\phpbb\language\language::class);
		$config = $this->createMock(\phpbbgallery\core\config::class);
		$config->method('get')->willReturnMap([
			['disp_gallery_icon', null, 1],
			['disp_new_image_count', null, 0],
		]);
		$config->method('get_title')->with($language)->willReturn('Gallery');
		$helper = $this->createStub(\phpbb\controller\helper::class);
		$helper->method('route')->willReturn('/gallery');
		$counter = $this->createMock(\phpbbgallery\core\unread_counter::class);
		$counter->expects($this->never())->method('count');
		$access = $this->createMock(\phpbbgallery\core\album_access::class);
		$access->expects($this->once())->method('has_any')->willReturn(true);
		$user = new \phpbb\user();
		$user->data = ['is_bot' => false];
		$reflection = new \ReflectionClass(main_listener::class);
		$listener = $reflection->newInstanceWithoutConstructor();
		$this->set_property($listener, 'template', $template);
		$this->set_property($listener, 'language', $language);
		$this->set_property($listener, 'gallery_config', $config);
		$this->set_property($listener, 'helper', $helper);
		$this->set_property($listener, 'user', $user);
		$this->set_property($listener, 'album_access', $access);
		$this->set_property($listener, 'unread_counter', $counter);

		$listener->add_page_header_link(new \phpbb\event\data([]));
	}

	public function test_page_header_omits_an_empty_unread_badge(): void
	{
		$template = $this->createMock(\phpbb\template\template::class);
		$template->expects($this->once())->method('assign_var')->with('GALLERY_TITLE', 'Gallery');
		$template->expects($this->once())->method('assign_vars')->with(['U_GALLERY' => '/gallery']);
		$language = $this->createStub(\phpbb\language\language::class);
		$config = $this->createMock(\phpbbgallery\core\config::class);
		$config->method('get')->willReturnMap([
			['disp_gallery_icon', null, 1],
			['disp_new_image_count', null, 1],
		]);
		$config->method('get_title')->with($language)->willReturn('Gallery');
		$helper = $this->createStub(\phpbb\controller\helper::class);
		$helper->method('route')->willReturn('/gallery');
		$counter = $this->createMock(\phpbbgallery\core\unread_counter::class);
		$counter->expects($this->once())->method('count')->willReturn(0);
		$access = $this->createMock(\phpbbgallery\core\album_access::class);
		$access->expects($this->once())->method('has_any')->willReturn(true);
		$user = new \phpbb\user();
		$user->data = ['is_bot' => false];
		$reflection = new \ReflectionClass(main_listener::class);
		$listener = $reflection->newInstanceWithoutConstructor();
		$this->set_property($listener, 'template', $template);
		$this->set_property($listener, 'language', $language);
		$this->set_property($listener, 'gallery_config', $config);
		$this->set_property($listener, 'helper', $helper);
		$this->set_property($listener, 'user', $user);
		$this->set_property($listener, 'album_access', $access);
		$this->set_property($listener, 'unread_counter', $counter);

		$listener->add_page_header_link(new \phpbb\event\data([]));
	}

	public function test_page_header_hides_gallery_when_effective_identity_has_no_album_access(): void
	{
		$template = $this->createMock(\phpbb\template\template::class);
		$template->expects($this->once())->method('assign_var')->with('GALLERY_TITLE', 'Gallery');
		$template->expects($this->never())->method('assign_vars');
		$language = $this->createStub(\phpbb\language\language::class);
		$config = $this->createMock(\phpbbgallery\core\config::class);
		$config->method('get')->with('disp_gallery_icon')->willReturn(1);
		$config->method('get_title')->with($language)->willReturn('Gallery');
		$access = $this->createMock(\phpbbgallery\core\album_access::class);
		$access->expects($this->once())->method('has_any')->willReturn(false);
		$counter = $this->createMock(\phpbbgallery\core\unread_counter::class);
		$counter->expects($this->never())->method('count');
		$helper = $this->createMock(\phpbb\controller\helper::class);
		$helper->expects($this->never())->method('route');
		$user = new \phpbb\user();
		$user->data = ['user_id' => 2, 'user_perm_from' => 42, 'is_bot' => false];
		$listener = (new \ReflectionClass(main_listener::class))->newInstanceWithoutConstructor();
		$this->set_property($listener, 'template', $template);
		$this->set_property($listener, 'language', $language);
		$this->set_property($listener, 'gallery_config', $config);
		$this->set_property($listener, 'album_access', $access);
		$this->set_property($listener, 'unread_counter', $counter);
		$this->set_property($listener, 'helper', $helper);
		$this->set_property($listener, 'user', $user);

		$listener->add_page_header_link(new \phpbb\event\data([]));
	}

	public function test_forum_index_images_are_disabled_without_search_queries(): void
	{
		$gallery_search = $this->createMock(\phpbbgallery\core\search::class);
		$gallery_search->expects($this->never())->method('recent');
		$gallery_search->expects($this->never())->method('random');
		$gallery_search->expects($this->never())->method('recent_personal');
		$config = $this->createMock(\phpbbgallery\core\config::class);
		$config->expects($this->once())
			->method('get')
			->with('forum_index_mode')
			->willReturn(0);
		$listener = $this->listener($this->createStub(\phpbb\db\driver\driver_interface::class));
		$this->set_property($listener, 'gallery_search', $gallery_search);
		$this->set_property($listener, 'gallery_config', $config);

		$listener->display_forum_index_images(new \phpbb\event\data([]));
	}

	public function test_forum_index_images_use_bounded_independent_settings(): void
	{
		$gallery_search = $this->createMock(\phpbbgallery\core\search::class);
		$gallery_search->expects($this->once())
			->method('recent')
			->with(12, -1, 0, 'forum_index_display', false, false, false, false);
		$gallery_search->expects($this->once())
			->method('random')
			->with(1, 0, 'forum_index_display', false, false, false, false);
		$config = $this->createMock(\phpbbgallery\core\config::class);
		$config->method('get')->willReturnMap([
			['forum_index_mode', null, \phpbbgallery\core\block::MODE_RECENT | \phpbbgallery\core\block::MODE_RANDOM],
			['forum_index_personal', null, false],
			['forum_index_recent_count', null, 99],
			['forum_index_random_count', null, 0],
		]);
		$language = $this->createMock(\phpbb\language\language::class);
		$language->expects($this->once())
			->method('add_lang')
			->with(['gallery'], 'phpbbgallery/core');
		$template = $this->createMock(\phpbb\template\template::class);
		$template->expects($this->once())
			->method('assign_vars')
			->with([
				'PHPBBGALLERY_FORUM_INDEX_IMAGES' => true,
				'GALLERY_INDEX_ALBUM_LAYOUT' => '',
			]);
		$listener = $this->listener($this->createStub(\phpbb\db\driver\driver_interface::class));
		$this->set_property($listener, 'gallery_search', $gallery_search);
		$this->set_property($listener, 'gallery_config', $config);
		$this->set_property($listener, 'language', $language);
		$this->set_property($listener, 'template', $template);

		$listener->display_forum_index_images(new \phpbb\event\data([]));
	}

	public function test_forum_index_personal_images_use_an_independent_bounded_block(): void
	{
		$this->assertSame(32, \phpbbgallery\core\block::MODE_PERSONAL);
		$gallery_search = $this->createMock(\phpbbgallery\core\search::class);
		$gallery_search->expects($this->never())->method('recent');
		$gallery_search->expects($this->never())->method('random');
		$gallery_search->expects($this->once())
			->method('recent_personal')
			->with(12, 'forum_index_display', false);
		$config = $this->createMock(\phpbbgallery\core\config::class);
		$config->method('get')->willReturnMap([
			['forum_index_mode', null, \phpbbgallery\core\block::MODE_PERSONAL],
			['forum_index_personal', null, false],
			['forum_index_personal_count', null, 99],
		]);
		$language = $this->createMock(\phpbb\language\language::class);
		$language->expects($this->once())
			->method('add_lang')
			->with(['gallery'], 'phpbbgallery/core');
		$template = $this->createMock(\phpbb\template\template::class);
		$template->expects($this->once())
			->method('assign_vars')
			->with([
				'PHPBBGALLERY_FORUM_INDEX_IMAGES' => true,
				'GALLERY_INDEX_ALBUM_LAYOUT' => '',
			]);
		$listener = $this->listener($this->createStub(\phpbb\db\driver\driver_interface::class));
		$this->set_property($listener, 'gallery_search', $gallery_search);
		$this->set_property($listener, 'gallery_config', $config);
		$this->set_property($listener, 'language', $language);
		$this->set_property($listener, 'template', $template);

		$listener->display_forum_index_images(new \phpbb\event\data([]));
	}

	public function test_profile_image_stat_uses_the_permission_filtered_count(): void
	{
		$gallery_search = $this->createMock(\phpbbgallery\core\search::class);
		$gallery_search->expects($this->once())->method('user_image_count')->with(12)->willReturn(4);
		$gallery_search->expects($this->never())->method('recent');
		$gallery_search->expects($this->never())->method('random');
		$config = $this->createMock(\phpbbgallery\core\config::class);
		$config->method('get')->willReturnMap([
			['rrc_profile_mode', null, 0],
			['profile_user_images', null, 1],
		]);
		$template = $this->createMock(\phpbb\template\template::class);
		$template->expects($this->once())->method('assign_vars')->with([
			'U_GALLERY_IMAGES_ALLOW' => true,
			'U_GALLERY_IMAGES' => 4,
			'U_GALLERY_IMAGES_SEARCH' => '/gallery/search?user_id=12',
		]);
		$helper = $this->createMock(\phpbb\controller\helper::class);
		$helper->expects($this->once())
			->method('route')
			->with('phpbbgallery_core_search', ['user_id' => [12], 'submit' => 1])
			->willReturn('/gallery/search?user_id=12');
		$listener = $this->listener($this->createStub(\phpbb\db\driver\driver_interface::class));
		$this->set_property($listener, 'gallery_search', $gallery_search);
		$this->set_property($listener, 'gallery_config', $config);
		$this->set_property($listener, 'template', $template);
		$this->set_property($listener, 'language', $this->createStub(\phpbb\language\language::class));
		$this->set_property($listener, 'helper', $helper);

		$listener->user_profile_galleries(new \phpbb\event\data(['member' => ['user_id' => 12]]));
	}

	public function test_profile_image_stat_is_hidden_and_unlinked_when_no_images_are_visible(): void
	{
		$gallery_search = $this->createMock(\phpbbgallery\core\search::class);
		$gallery_search->expects($this->once())->method('user_image_count')->with(12)->willReturn(0);
		$config = $this->createMock(\phpbbgallery\core\config::class);
		$config->method('get')->willReturnMap([
			['rrc_profile_mode', null, 0],
			['profile_user_images', null, 1],
		]);
		$template = $this->createMock(\phpbb\template\template::class);
		$template->expects($this->once())->method('assign_vars')->with([
			'U_GALLERY_IMAGES_ALLOW' => false,
			'U_GALLERY_IMAGES' => 0,
			'U_GALLERY_IMAGES_SEARCH' => '',
		]);
		$helper = $this->createMock(\phpbb\controller\helper::class);
		$helper->expects($this->never())->method('route');
		$listener = $this->listener($this->createStub(\phpbb\db\driver\driver_interface::class));
		$this->set_property($listener, 'gallery_search', $gallery_search);
		$this->set_property($listener, 'gallery_config', $config);
		$this->set_property($listener, 'template', $template);
		$this->set_property($listener, 'language', $this->createStub(\phpbb\language\language::class));
		$this->set_property($listener, 'helper', $helper);

		$listener->user_profile_galleries(new \phpbb\event\data(['member' => ['user_id' => 12]]));
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
