<?php
/**
 * phpBB Gallery - Core Extension tests
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\tests;

use PHPUnit\Framework\TestCase;
use phpbbgallery\core\controller\album as album_controller;
use phpbbgallery\core\controller\file as file_controller;

// phpcs:disable PSR1.Files.SideEffects.FoundWithSymbols -- Isolated controller tests load their subjects directly.
require_once dirname(__DIR__) . '/block.php';
require_once dirname(__DIR__) . '/controller/album.php';
require_once dirname(__DIR__) . '/controller/file.php';
// phpcs:enable PSR1.Files.SideEffects.FoundWithSymbols

class access_boundary_test extends TestCase
{
	public function test_descendant_count_applies_view_and_moderator_permissions_per_album(): void
	{
		$controller = (new \ReflectionClass(album_controller::class))->newInstanceWithoutConstructor();
		$query = '';
		$db = $this->createMock(\phpbb\db\driver\driver_interface::class);
		$db->method('sql_in_set')->willReturnCallback(static fn (string $field, array $values): string => $field . ' IN (' . implode(', ', array_map('intval', $values)) . ')');
		$db->expects($this->once())->method('sql_query')->willReturnCallback(static function (string $sql) use (&$query): bool
		{
			$query = $sql;

			return true;
		});
		$db->expects($this->once())->method('sql_fetchfield')->with('total_images')->willReturn(7);
		$db->expects($this->once())->method('sql_freeresult')->with(true);
		$auth = $this->createMock(\phpbbgallery\core\auth\auth::class);
		$auth->method('acl_check')->willReturnCallback(static function (string $permission, int $album_id, int $album_owner_id): bool
		{
			if ($permission === 'i_view')
			{
				return in_array($album_id, [10, 11], true);
			}

			return $permission === 'm_status' && $album_id === 11;
		});
		$user = $this->createMock(\phpbb\user::class);
		$user->data = ['user_id' => 99];

		$set_dependencies = \Closure::bind(function ($db, $auth, $user): void
		{
			$this->db = $db;
			$this->auth = $auth;
			$this->user = $user;
			$this->table_images = 'gallery_images';
		}, $controller, album_controller::class);
		$set_dependencies($db, $auth, $user);

		$count = \Closure::bind(function (array $album_ids)
		{
			return $this->get_descendant_image_count($album_ids, 42);
		}, $controller, album_controller::class);

		$this->assertSame(7, $count([10, 11, 12, 10, 0]));
		$this->assertStringContainsString('image_album_id IN (10)', $query);
		$this->assertStringContainsString('image_album_id IN (11)', $query);
		$this->assertStringNotContainsString('12', $query);
		$this->assertStringContainsString('OR image_user_id = 99', $query);
		$this->assertStringContainsString('AND image_status <> ' . \phpbbgallery\core\block::STATUS_ORPHAN, $query);
	}

	public function test_descendant_count_skips_database_when_no_album_is_viewable(): void
	{
		$controller = (new \ReflectionClass(album_controller::class))->newInstanceWithoutConstructor();
		$db = $this->createMock(\phpbb\db\driver\driver_interface::class);
		$db->expects($this->never())->method('sql_query');
		$auth = $this->createMock(\phpbbgallery\core\auth\auth::class);
		$auth->method('acl_check')->willReturn(false);

		$set_dependencies = \Closure::bind(function ($db, $auth): void
		{
			$this->db = $db;
			$this->auth = $auth;
		}, $controller, album_controller::class);
		$set_dependencies($db, $auth);

		$count = \Closure::bind(function ()
		{
			return $this->get_descendant_image_count([12], 42);
		}, $controller, album_controller::class);

		$this->assertSame(0, $count());
	}

	public function test_hotlink_referrer_requires_http_host_boundary(): void
	{
		$allowed = [' gallery.example.com ', 'https://media.example.net:8443/path'];

		foreach ([
			'https://gallery.example.com/image/1',
			'https://cdn.gallery.example.com/image/1',
			'HTTP://GALLERY.EXAMPLE.COM.:8080/image/1',
			'https://media.example.net/gallery',
		] as $referrer)
		{
			$this->assertTrue($this->is_allowed_referrer($referrer, $allowed), $referrer);
		}

		foreach ([
			'',
			'gallery.example.com/image/1',
			'javascript://gallery.example.com/image/1',
			'https://gallery.example.com.attacker.test/image/1',
			'https://attacker.test/gallery.example.com/image/1',
			'https://gallery.example.com@attacker.test/image/1',
			'https://other.example.net/image/1?next=gallery.example.com',
		] as $referrer)
		{
			$this->assertFalse($this->is_allowed_referrer($referrer, $allowed), $referrer);
		}
	}

	public function test_hotlink_ip_allowlist_does_not_accept_suffix_hosts(): void
	{
		$this->assertTrue($this->is_allowed_referrer('https://127.0.0.1/image', ['127.0.0.1']));
		$this->assertFalse($this->is_allowed_referrer('https://cdn.127.0.0.1/image', ['127.0.0.1']));
	}

	public function test_hotlink_guard_fails_closed_and_honours_disabled_protection(): void
	{
		$blocked = $this->run_hotlink_guard(false, '');
		$this->assertSame('no_hotlinking.jpg', $blocked['error']);
		$this->assertSame('no_hotlinking.jpg', $blocked['data']['image_filename']);

		$spoofed = $this->run_hotlink_guard(false, 'https://attacker.test/path/gallery.example.com');
		$this->assertSame('no_hotlinking.jpg', $spoofed['error']);

		$allowed = $this->run_hotlink_guard(false, 'https://gallery.example.com/image');
		$this->assertSame('', $allowed['error']);
		$this->assertSame('original.jpg', $allowed['data']['image_filename']);

		$protection_disabled = $this->run_hotlink_guard(true, '');
		$this->assertSame('', $protection_disabled['error']);
		$this->assertSame('original.jpg', $protection_disabled['data']['image_filename']);
	}

	public function test_album_branch_is_reused_before_individual_count_acl_checks(): void
	{
		$album_controller = file_get_contents(dirname(__DIR__) . '/controller/album.php');
		$album_display = file_get_contents(dirname(__DIR__) . '/album/display.php');
		$file_controller = file_get_contents(dirname(__DIR__) . '/controller/file.php');

		$this->assertStringContainsString('$album_display = $this->display->display_albums(', $album_controller);
		$this->assertStringContainsString('$album_display[0]', $album_controller);
		$this->assertStringNotContainsString('$this->display->get_branch(', $album_controller);
		$this->assertStringContainsString("acl_check('i_view', \$album_id, \$album_owner_id)", $album_controller);

		$zebra_check = strpos($album_display, 'get_zebra_state($zebra_array');
		$active_album = strpos($album_display, '$active_album_ary[]', $zebra_check);
		$this->assertNotFalse($zebra_check);
		$this->assertNotFalse($active_album);
		$this->assertGreaterThan($zebra_check, $active_album);

		$this->assertStringContainsString('parse_url($referrer, PHP_URL_HOST)', $file_controller);
		$this->assertStringNotContainsString('strpos($referrer, $var)', $file_controller);
	}

	public function test_empty_categories_remain_visible_in_every_album_style(): void
	{
		$album_display = (string) file_get_contents(dirname(__DIR__) . '/album/display.php');
		$this->assertStringNotContainsString("left_id'] + 1 == \$row['right_id']", $album_display);
		$this->assertStringContainsString("'S_IS_CAT'", $album_display);

		foreach (['prosilver', 'BBOOTS', 'FLATBOOTS'] as $style)
		{
			$template = (string) file_get_contents(dirname(__DIR__) . '/styles/' . $style . '/template/gallery/albumlist_body.html');
			$this->assertStringContainsString('albumrow.S_IS_CAT', $template, $style);
			$this->assertStringContainsString('albumrow.U_VIEWALBUM', $template, $style);
		}
	}

	/**
	 * @param string $referrer
	 * @param array  $allowed_domains
	 * @return bool
	 */
	private function is_allowed_referrer(string $referrer, array $allowed_domains): bool
	{
		$controller = (new \ReflectionClass(file_controller::class))->newInstanceWithoutConstructor();
		$check = \Closure::bind(function ($referrer, array $allowed_domains)
		{
			return $this->is_allowed_referrer($referrer, $allowed_domains);
		}, $controller, file_controller::class);

		return $check($referrer, $allowed_domains);
	}

	/**
	 * @param bool   $allow_hotlinking
	 * @param string $referrer
	 * @return array
	 */
	private function run_hotlink_guard(bool $allow_hotlinking, string $referrer): array
	{
		$controller = (new \ReflectionClass(file_controller::class))->newInstanceWithoutConstructor();
		$request = $this->createMock(\phpbb\request\request_interface::class);
		$request->method('server')->willReturnCallback(static fn (string $name, mixed $default): mixed => $name === 'HTTP_REFERER' ? $referrer : $default);
		$language = $this->createMock(\phpbb\language\language::class);
		$language->method('lang')->willReturnCallback(static fn (string $key): string => $key);

		$run = \Closure::bind(function ($allow_hotlinking, $request, $language): array
		{
			$this->config = new \phpbb\config\config([
				'phpbb_gallery_allow_hotlinking' => $allow_hotlinking,
				'phpbb_gallery_hotlinking_domains' => '',
				'server_name' => 'gallery.example.com',
			]);
			$this->request = $request;
			$this->language = $language;
			$this->data = ['image_filename' => 'original.jpg'];
			$this->error = '';
			$this->check_hot_link();

			return ['error' => $this->error, 'data' => $this->data];
		}, $controller, file_controller::class);

		return $run($allow_hotlinking, $request, $language);
	}
}
