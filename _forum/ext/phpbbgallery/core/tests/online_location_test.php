<?php
/**
 * phpBB Gallery - Viewonline location tests
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\tests;

use phpbbgallery\core\online_location;
use PHPUnit\Framework\TestCase;

final class online_location_test extends TestCase
{
	public function test_service_and_listener_are_wired_with_the_required_boundaries(): void
	{
		$services = (string) file_get_contents(dirname(__DIR__) . '/config/services.yml');

		$this->assertStringContainsString('phpbbgallery.core.online_location:', $services);
		$this->assertStringContainsString('class: phpbbgallery\\core\\online_location', $services);
		$this->assertStringContainsString("- '@phpbbgallery.core.online_location'", $services);
		$this->assertStringContainsString("- '%phpbbgallery.tables.gallery_albums%'", $services);
		$this->assertStringContainsString("- '%phpbbgallery.tables.gallery_images%'", $services);
	}

	public function test_non_gallery_sessions_are_ignored_and_gallery_pages_have_no_sid(): void
	{
		$helper = $this->helper();
		$resolver = $this->resolver(
			$this->createStub(\phpbb\db\driver\driver_interface::class),
			$this->createStub(\phpbbgallery\core\auth\auth::class),
			$helper
		);

		$this->assertNull($resolver->resolve('viewtopic.php?t=42'));
		$this->assertSame([
			'location' => 'Viewing My Gallery',
			'location_url' => '/gallery',
		], $resolver->resolve('app.php/gallery?sid=private-session'));
		$this->assertSame([
			'location' => 'Searching My Gallery',
			'location_url' => '/gallery/search',
		], $resolver->resolve('gallery/search/recent/2'));
	}

	public function test_visible_album_and_upload_locations_reuse_the_album_query(): void
	{
		$db = $this->database([
			'album_id' => 31,
			'album_name' => 'Covers & Posters',
			'album_user_id' => 0,
			'album_auth_access' => 0,
		], 1);
		$resolver = $this->resolver($db, $this->gallery_auth(true), $this->helper());

		$this->assertSame([
			'location' => 'Viewing album Covers &amp; Posters',
			'location_url' => '/gallery/album/31',
		], $resolver->resolve('app.php/gallery/album/31/page/2'));
		$this->assertSame([
			'location' => 'Uploading images to album Covers &amp; Posters',
			'location_url' => '/gallery/album/31',
		], $resolver->resolve('app.php/gallery/album/31/upload'));
	}

	public function test_hidden_album_falls_back_without_exposing_its_name_or_url(): void
	{
		$db = $this->database([
			'album_id' => 41,
			'album_name' => 'Private staff album',
			'album_user_id' => 9,
			'album_auth_access' => 2,
		]);
		$resolver = $this->resolver($db, $this->gallery_auth(false), $this->helper());

		$location = $resolver->resolve('app.php/gallery/album/41');

		$this->assertSame('Viewing My Gallery', $location['location']);
		$this->assertSame('/gallery', $location['location_url']);
		$this->assertStringNotContainsString('Private', implode(' ', $location));
		$this->assertStringNotContainsString('41', implode(' ', $location));
	}

	public function test_visible_image_and_comment_locations_reuse_the_image_query(): void
	{
		$db = $this->database([
			'image_id' => 8960,
			'image_album_id' => 31,
			'image_status' => \phpbbgallery\core\block::STATUS_APPROVED,
			'image_user_id' => 12,
			'album_id' => 31,
			'album_name' => 'Public album',
			'album_user_id' => 0,
			'album_auth_access' => 0,
		], 1);
		$resolver = $this->resolver($db, $this->gallery_auth(true), $this->helper());

		$expected = [
			'location' => 'Viewing image in album Public album',
			'location_url' => '/gallery/image/8960',
		];
		$this->assertSame($expected, $resolver->resolve('app.php/gallery/image/8960/medium?sid=private'));
		$this->assertSame($expected, $resolver->resolve('app.php/gallery/comment/8960/edit/3'));
	}

	public function test_unapproved_image_is_visible_only_to_its_owner_or_status_moderator(): void
	{
		$row = [
			'image_id' => 90,
			'image_album_id' => 31,
			'image_status' => \phpbbgallery\core\block::STATUS_UNAPPROVED,
			'image_user_id' => 12,
			'album_id' => 31,
			'album_name' => 'Review album',
			'album_user_id' => 0,
			'album_auth_access' => 0,
		];

		$hidden = $this->resolver($this->database($row), $this->gallery_auth(true), $this->helper(), 7);
		$this->assertSame('/gallery', $hidden->resolve('app.php/gallery/image/90')['location_url']);

		$owner = $this->resolver($this->database($row), $this->gallery_auth(true), $this->helper(), 12);
		$this->assertSame('/gallery/image/90', $owner->resolve('app.php/gallery/image/90')['location_url']);

		$moderator = $this->resolver($this->database($row), $this->gallery_auth(true, true), $this->helper(), 7);
		$this->assertSame('/gallery/image/90', $moderator->resolve('app.php/gallery/image/90')['location_url']);
	}

	public function test_orphan_image_and_zebra_restriction_fail_closed(): void
	{
		$row = [
			'image_id' => 91,
			'image_album_id' => 32,
			'image_status' => \phpbbgallery\core\block::STATUS_ORPHAN,
			'image_user_id' => 7,
			'album_id' => 32,
			'album_name' => 'Draft album',
			'album_user_id' => 7,
			'album_auth_access' => 1,
		];

		$orphan = $this->resolver($this->database($row), $this->gallery_auth(true, false, 1), $this->helper(), 7);
		$this->assertSame('/gallery', $orphan->resolve('app.php/gallery/image/91')['location_url']);

		$row['image_status'] = \phpbbgallery\core\block::STATUS_APPROVED;
		$zebra = $this->resolver($this->database($row), $this->gallery_auth(true, false, 0), $this->helper(), 7);
		$this->assertSame('/gallery', $zebra->resolve('app.php/gallery/image/91')['location_url']);
	}

	private function resolver(
		\phpbb\db\driver\driver_interface $db,
		\phpbbgallery\core\auth\auth $gallery_auth,
		\phpbb\controller\helper $helper,
		int $user_id = 7
	): online_location
	{
		$user = new \phpbb\user();
		$user->data = ['user_id' => $user_id];
		$language = $this->createStub(\phpbb\language\language::class);
		$language->method('lang')->willReturnCallback(static function (string $key, mixed ...$arguments): string
		{
			return match ($key)
			{
				'VIEWING_GALLERY' => 'Viewing ' . $arguments[0],
				'SEARCHING_GALLERY' => 'Searching ' . $arguments[0],
				'VIEWING_ALBUM' => 'Viewing album ' . $arguments[0],
				'VIEWING_IMAGE' => 'Viewing image in album ' . $arguments[0],
				'UPLOADING_TO_ALBUM' => 'Uploading images to album ' . $arguments[0],
				default => $key,
			};
		});
		$config = $this->createStub(\phpbbgallery\core\config::class);
		$config->method('get_title')->willReturn('My Gallery');

		return new online_location(
			$db,
			$gallery_auth,
			$user,
			$language,
			$helper,
			$config,
			'gallery_albums',
			'gallery_images'
		);
	}

	private function helper(): \phpbb\controller\helper
	{
		$helper = $this->createStub(\phpbb\controller\helper::class);
		$helper->method('route')->willReturnCallback(function (string $route, array $parameters, bool $is_amp, string|bool $session_id): string
		{
			$this->assertTrue($is_amp);
			$this->assertSame('', $session_id, 'Viewonline links must never expose a session identifier.');

			return match ($route)
			{
				'phpbbgallery_core_album' => '/gallery/album/' . $parameters['album_id'],
				'phpbbgallery_core_image' => '/gallery/image/' . $parameters['image_id'],
				'phpbbgallery_core_search' => '/gallery/search',
				default => '/gallery',
			};
		});

		return $helper;
	}

	private function gallery_auth(bool $can_view, bool $can_moderate = false, int $zebra_level = 3): \phpbbgallery\core\auth\auth
	{
		$auth = $this->createStub(\phpbbgallery\core\auth\auth::class);
		$auth->method('acl_check')->willReturnCallback(static function (string $permission) use ($can_view, $can_moderate): bool
		{
			return $permission === 'i_view' ? $can_view : ($permission === 'm_status' && $can_moderate);
		});
		$auth->method('get_user_zebra')->willReturn([]);
		$auth->method('get_zebra_state')->willReturn($zebra_level);

		return $auth;
	}

	private function database(array $row, int $query_count = 1): \phpbb\db\driver\driver_interface
	{
		$db = $this->createMock(\phpbb\db\driver\driver_interface::class);
		$db->expects($this->exactly($query_count))->method('sql_query')->willReturn('result');
		$db->expects($this->exactly($query_count))->method('sql_fetchrow')->with('result')->willReturn($row);
		$db->expects($this->exactly($query_count))->method('sql_freeresult')->with('result');

		return $db;
	}
}
