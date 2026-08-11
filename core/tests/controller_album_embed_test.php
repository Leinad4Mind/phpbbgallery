<?php
/**
 * phpBB Gallery - Embedded album controller tests
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\tests;

use phpbbgallery\core\album\loader;
use phpbbgallery\core\auth\auth;
use phpbbgallery\core\controller\album_embed;
use phpbbgallery\core\unread_counter;
use PHPUnit\Framework\TestCase;

final class controller_album_embed_test extends TestCase
{
	// phpcs:ignore PhpbbCodingStandard.NamingConventions.LowercaseUnderscoredFunctions.NotAllowed -- PHPUnit lifecycle API.
	public static function setUpBeforeClass(): void
	{
		parent::setUpBeforeClass();
		if (!class_exists(album_embed::class, false))
		{
			require_once dirname(__DIR__) . '/controller/album_embed.php';
		}
	}

	public function test_missing_album_returns_private_not_found_json(): void
	{
		$loader = $this->createMock(loader::class);
		$loader->method('load')->willThrowException(new \OutOfBoundsException());
		$db = $this->createMock(\phpbb\db\driver\driver_interface::class);
		$db->expects($this->never())->method('sql_query');

		$response = $this->controller($db, $loader, $this->createMock(auth::class))->page(404);

		$this->assertSame(404, $response->getStatusCode());
		$this->assertSame(['error' => 'translated-ALBUM_NOT_EXIST'], $this->decode($response));
		$this->assert_security_headers($response);
	}

	public function test_album_permission_and_zebra_denial_returns_forbidden_without_querying_images(): void
	{
		$loader = $this->album_loader(['album_auth_access' => 2]);
		$gallery_auth = $this->gallery_auth(true, 1);
		$db = $this->createMock(\phpbb\db\driver\driver_interface::class);
		$db->expects($this->never())->method('sql_query');

		$response = $this->controller($db, $loader, $gallery_auth)->page(31);

		$this->assertSame(403, $response->getStatusCode());
		$this->assertSame(['error' => 'translated-NOT_AUTHORISED'], $this->decode($response));
		$this->assert_security_headers($response);
	}

	public function test_authorized_page_is_bounded_sorted_and_marks_only_returned_images_seen(): void
	{
		$loader = $this->album_loader([
			'album_sort_key' => 'n',
			'album_sort_dir' => 'a',
		]);
		$gallery_auth = $this->gallery_auth(true, 0, false);
		$db = $this->createMock(\phpbb\db\driver\driver_interface::class);
		$db->expects($this->once())
			->method('sql_query')
			->with($this->stringContains('COUNT(*) AS total_images'))
			->willReturn('count-result');
		$db->expects($this->once())
			->method('sql_fetchfield')
			->with('total_images')
			->willReturn(10);
		$db->expects($this->once())
			->method('sql_query_limit')
			->with(
				$this->callback(static function (string $sql): bool
				{
					return str_contains($sql, 'ORDER BY image_name_clean ASC, image_id ASC')
						&& str_contains($sql, 'image_status <> 3')
						&& str_contains($sql, 'image_status <> 4')
						&& str_contains($sql, 'image_status <> 0 OR image_user_id = 7');
				}),
				album_embed::ITEMS_PER_PAGE,
				album_embed::ITEMS_PER_PAGE
			)
			->willReturn('image-result');
		$rows = [
			['image_id' => 91, 'image_name' => 'First'],
			['image_id' => 92, 'image_name' => 'Second'],
			false,
		];
		$db->method('sql_fetchrow')->willReturnCallback(
			static function (string $result) use (&$rows): array|false
			{
				return $result === 'image-result' ? array_shift($rows) : false;
			}
		);

		$unread = $this->createMock(unread_counter::class);
		$unread->expects($this->once())->method('mark_viewed_many')->with([91, 92]);
		$routes = [];
		$helper = $this->createMock(\phpbb\controller\helper::class);
		$helper->expects($this->exactly(5))
			->method('route')
			->willReturnCallback(static function (string $route, array $params, bool $is_amp) use (&$routes): string
			{
				TestCase::assertFalse($is_amp);
				$routes[] = [$route, $params];
				return '/' . $route . '/' . ($params['image_id'] ?? $params['album_id']);
			});

		$response = $this->controller(
			$db,
			$loader,
			$gallery_auth,
			$unread,
			$helper,
			['page' => 2]
		)->page(31);
		$data = $this->decode($response);

		$this->assertSame(200, $response->getStatusCode());
		$this->assertSame('Album 31', $data['album']['album_name']);
		$this->assertSame([91, 92], array_column($data['images'], 'image_id'));
		$this->assertSame(['page' => 2, 'pages' => 2, 'per_page' => 8, 'total' => 10], $data['pagination']);
		$this->assertSame('2 / 2', $data['labels']['page']);
		$this->assertSame('translated-NO_IMAGES_LONG', $data['labels']['empty']);
		$this->assertSame('translated-PREVIOUS', $data['labels']['previous']);
		$this->assertSame('translated-NEXT', $data['labels']['next']);
		$this->assertCount(5, $routes);
		$this->assert_security_headers($response);
	}

	public function test_moderator_query_may_include_unapproved_images_without_author_exception(): void
	{
		$loader = $this->album_loader();
		$gallery_auth = $this->gallery_auth(true, 0, true);
		$db = $this->createMock(\phpbb\db\driver\driver_interface::class);
		$db->method('sql_query')->willReturn('count-result');
		$db->method('sql_fetchfield')->willReturn(0);
		$db->expects($this->once())
			->method('sql_query_limit')
			->with(
				$this->callback(static function (string $sql): bool
				{
					return !str_contains($sql, 'image_status <> 0 OR image_user_id');
				}),
				album_embed::ITEMS_PER_PAGE,
				0
			)
			->willReturn('image-result');
		$db->method('sql_fetchrow')->willReturn(false);

		$response = $this->controller($db, $loader, $gallery_auth)->page(31);

		$this->assertSame(200, $response->getStatusCode());
		$this->assertSame([], $this->decode($response)['images']);
	}

	public function test_controller_and_route_assets_are_complete(): void
	{
		$reflection = new \ReflectionClass(album_embed::class);
		foreach ($reflection->getProperties() as $property)
		{
			$this->assertNotNull($property->getType(), $property->getName());
		}
		foreach ($reflection->getMethods() as $method)
		{
			if ($method->getDeclaringClass()->getName() !== album_embed::class)
			{
				continue;
			}
			foreach ($method->getParameters() as $parameter)
			{
				$this->assertNotNull($parameter->getType(), $method->getName() . '::$' . $parameter->getName());
			}
			if (!$method->isConstructor())
			{
				$this->assertNotNull($method->getReturnType(), $method->getName());
			}
		}

		$root = dirname(__DIR__);
		$routing = file_get_contents($root . '/config/routing.yml');
		$services = file_get_contents($root . '/config/services_controller.yml');
		$footer = file_get_contents($root . '/styles/all/template/event/overall_footer_after.html');
		$script = file_get_contents($root . '/styles/all/template/js/album_embed.js');
		$css = file_get_contents($root . '/styles/all/theme/gallery.css');
		$this->assertStringContainsString('phpbbgallery_core_album_embed:', $routing);
		$this->assertStringContainsString('phpbbgallery.core.controller.album_embed:page', $routing);
		$this->assertStringContainsString('phpbbgallery.core.controller.album_embed:', $services);
		$this->assertStringContainsString("INCLUDEJS '@phpbbgallery_core/js/album_embed.js'", $footer);
		$this->assertStringContainsString('IntersectionObserver', $script);
		$this->assertStringContainsString('.phpbbgallery-album-embed-grid', $css);
	}

	private function controller(\phpbb\db\driver\driver_interface $db, loader $loader,
		?auth $gallery_auth = null, ?unread_counter $unread = null, ?\phpbb\controller\helper $helper = null,
		array $request_values = []): album_embed
	{
		$request = $this->createMock(\phpbb\request\request_interface::class);
		$request->method('variable')->willReturnCallback(
			static fn(string $key, mixed $default): mixed => $request_values[$key] ?? $default
		);
		$user = new \phpbb\user();
		$user->data = ['user_id' => 7, 'is_registered' => true, 'is_bot' => false];
		$language = $this->createMock(\phpbb\language\language::class);
		$language->method('lang')->willReturnCallback(
			static fn(string $key): string => 'translated-' . $key
		);
		$gallery_config = new \phpbbgallery\core\config(new \phpbb\config\config([]));

		return new album_embed(
			$db,
			$request,
			$user,
			$language,
			$helper ?? $this->createMock(\phpbb\controller\helper::class),
			$loader,
			$gallery_auth ?? $this->gallery_auth(true, 0, false),
			$gallery_config,
			$unread ?? $this->createMock(unread_counter::class),
			'phpbb_gallery_images'
		);
	}

	private function album_loader(array $overrides = []): loader
	{
		$album = array_merge([
			'album_id' => 31,
			'album_name' => 'Album 31',
			'album_user_id' => 0,
			'album_auth_access' => 0,
			'album_sort_key' => 't',
			'album_sort_dir' => 'd',
		], $overrides);
		$loader = $this->createMock(loader::class);
		$loader->expects($this->once())->method('load')->with(31)->willReturn(true);
		$loader->expects($this->once())->method('get')->with(31)->willReturn($album);

		return $loader;
	}

	private function gallery_auth(bool $view, int $zebra_state, bool $moderator = false): auth
	{
		$gallery_auth = $this->createMock(auth::class);
		$gallery_auth->expects($this->once())->method('load_user_permissions')->with(7);
		$gallery_auth->expects($this->once())->method('get_user_zebra')->with(7)->willReturn([
			'foe' => [],
			'friend' => [],
			'bff' => [],
		]);
		$gallery_auth->method('acl_check')->willReturnCallback(
			static fn(string $permission): bool => $permission === 'i_view' ? $view : $moderator
		);
		$gallery_auth->expects($this->once())->method('get_zebra_state')->willReturn($zebra_state);

		return $gallery_auth;
	}

	private function decode(\Symfony\Component\HttpFoundation\JsonResponse $response): array
	{
		$data = json_decode((string) $response->getContent(), true);
		$this->assertIsArray($data);

		return $data;
	}

	private function assert_security_headers(\Symfony\Component\HttpFoundation\JsonResponse $response): void
	{
		$this->assertStringContainsString('private', (string) $response->headers->get('Cache-Control'));
		$this->assertStringContainsString('no-store', (string) $response->headers->get('Cache-Control'));
		$this->assertSame('nosniff', $response->headers->get('X-Content-Type-Options'));
		$this->assertSame('application/json', $response->headers->get('Content-Type'));
	}
}
