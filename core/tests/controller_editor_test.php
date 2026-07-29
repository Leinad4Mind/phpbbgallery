<?php
/**
 * phpBB Gallery - Message editor JSON controller tests
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\tests;

use phpbbgallery\core\controller\editor;
use phpbbgallery\core\image\selector;
use PHPUnit\Framework\TestCase;

final class controller_editor_test extends TestCase
{
	// phpcs:ignore PhpbbCodingStandard.NamingConventions.LowercaseUnderscoredFunctions.NotAllowed -- PHPUnit lifecycle API.
	public static function setUpBeforeClass(): void
	{
		parent::setUpBeforeClass();
		$phpbb_root = dirname(__DIR__, 4);
		$http_foundation = $phpbb_root . '/vendor/symfony/http-foundation/';
		$error_level = error_reporting();
		error_reporting($error_level & ~E_DEPRECATED);
		foreach (['HeaderBag.php', 'ResponseHeaderBag.php', 'Response.php', 'JsonResponse.php'] as $http_file)
		{
			$class_name = 'Symfony\\Component\\HttpFoundation\\' . basename($http_file, '.php');
			if (!class_exists($class_name, false))
			{
				require_once $http_foundation . $http_file;
			}
		}
		error_reporting($error_level);
		if (!interface_exists(\Symfony\Component\Routing\RequestContextAwareInterface::class, false))
		{
			require_once $phpbb_root . '/vendor/symfony/routing/RequestContextAwareInterface.php';
		}
		if (!interface_exists(\Symfony\Component\Routing\Generator\UrlGeneratorInterface::class, false))
		{
			require_once $phpbb_root . '/vendor/symfony/routing/Generator/UrlGeneratorInterface.php';
		}
		if (!class_exists(\phpbb\controller\helper::class, false))
		{
			require_once $phpbb_root . '/phpbb/controller/helper.php';
		}
		if (!class_exists(selector::class, false))
		{
			require_once dirname(__DIR__) . '/image/selector.php';
		}
		if (!class_exists(editor::class, false))
		{
			require_once dirname(__DIR__) . '/controller/editor.php';
		}
	}

	/**
	 * @dataProvider unavailable_user_provider
	 */
	public function test_guests_and_bots_receive_private_non_cacheable_forbidden_json(bool $registered, bool $bot): void
	{
		$selector = $this->createMock(selector::class);
		$selector->expects($this->never())->method('get_page');
		$helper = $this->createMock(\phpbb\controller\helper::class);
		$helper->expects($this->never())->method('route');

		$user = new \phpbb\user();
		$user->data = [
			'user_id' => 7,
			'is_registered' => $registered,
			'is_bot' => $bot,
		];
		$response = $this->controller($user, $selector, $helper)->images();

		$this->assertSame(403, $response->getStatusCode());
		$this->assertSame(['error' => 'translated-NOT_AUTHORISED'], $this->decode($response));
		$this->assert_security_headers($response);
	}

	public static function unavailable_user_provider(): array
	{
		return [
			'guest' => [false, false],
			'bot' => [true, true],
		];
	}

	public function test_authorized_page_receives_safe_image_routes_and_normalized_request_values(): void
	{
		$selector_data = [
			'authorized' => true,
			'album_id' => 0,
			'albums' => [['album_id' => 30, 'album_name' => 'Album']],
			'images' => [
				['image_id' => 91, 'image_name' => 'First', 'album_id' => 30, 'album_name' => 'Album'],
				['image_id' => 87, 'image_name' => 'Second', 'album_id' => 30, 'album_name' => 'Album'],
			],
			'pagination' => ['page' => 1, 'pages' => 1, 'per_page' => 12, 'total' => 2],
		];
		$selector = $this->createMock(selector::class);
		$selector->expects($this->once())
			->method('get_page')
			->with(7, 0, 1)
			->willReturn($selector_data);

		$routes = [];
		$helper = $this->createMock(\phpbb\controller\helper::class);
		$helper->expects($this->exactly(4))
			->method('route')
			->willReturnCallback(static function (string $route, array $parameters, bool $is_amp) use (&$routes): string
			{
				TestCase::assertFalse($is_amp);
				$routes[] = [$route, $parameters];
				return '/' . ($route === 'phpbbgallery_core_image_file_mini' ? 'mini/' : 'image/') . $parameters['image_id'];
			});

		$user = new \phpbb\user();
		$user->data = ['user_id' => 7, 'is_registered' => true, 'is_bot' => false];
		$response = $this->controller($user, $selector, $helper, ['album_id' => -4, 'page' => 0])->images();
		$data = $this->decode($response);

		$this->assertSame(200, $response->getStatusCode());
		$this->assertSame('/mini/91', $data['images'][0]['thumbnail_url']);
		$this->assertSame('/image/91', $data['images'][0]['view_url']);
		$this->assertSame('/mini/87', $data['images'][1]['thumbnail_url']);
		$this->assertSame('/image/87', $data['images'][1]['view_url']);
		$this->assertSame([
			['phpbbgallery_core_image_file_mini', ['image_id' => 91]],
			['phpbbgallery_core_image', ['image_id' => 91]],
			['phpbbgallery_core_image_file_mini', ['image_id' => 87]],
			['phpbbgallery_core_image', ['image_id' => 87]],
		], $routes);
		$this->assert_security_headers($response);
	}

	public function test_selector_denial_is_returned_as_forbidden_without_exposing_routes(): void
	{
		$selector = $this->createMock(selector::class);
		$selector->expects($this->once())
			->method('get_page')
			->with(7, 99, 2)
			->willReturn([
				'authorized' => false,
				'album_id' => 99,
				'albums' => [],
				'images' => [],
				'pagination' => ['page' => 2, 'pages' => 1, 'per_page' => 12, 'total' => 0],
			]);
		$helper = $this->createMock(\phpbb\controller\helper::class);
		$helper->expects($this->never())->method('route');
		$user = new \phpbb\user();
		$user->data = ['user_id' => 7, 'is_registered' => true, 'is_bot' => false];

		$response = $this->controller($user, $selector, $helper, ['album_id' => 99, 'page' => 2])->images();

		$this->assertSame(403, $response->getStatusCode());
		$this->assertSame(['error' => 'translated-NOT_AUTHORISED'], $this->decode($response));
		$this->assert_security_headers($response);
	}

	public function test_controller_contract_is_fully_typed(): void
	{
		$reflection = new \ReflectionClass(editor::class);

		foreach ($reflection->getProperties() as $property)
		{
			$this->assertNotNull($property->getType(), editor::class . '::$' . $property->getName());
		}

		foreach ($reflection->getMethods() as $method)
		{
			if ($method->getDeclaringClass()->getName() !== editor::class)
			{
				continue;
			}

			foreach ($method->getParameters() as $parameter)
			{
				$this->assertNotNull($parameter->getType(), editor::class . '::' . $method->getName());
			}

			if (!$method->isConstructor())
			{
				$this->assertNotNull($method->getReturnType(), editor::class . '::' . $method->getName());
			}
		}
	}

	private function controller(\phpbb\user $user, selector $selector, \phpbb\controller\helper $helper,
		array $request_values = []): editor
	{
		$request = $this->createMock(\phpbb\request\request_interface::class);
		$request->method('variable')
			->willReturnCallback(static function (string $name, mixed $default) use ($request_values): mixed
			{
				return $request_values[$name] ?? $default;
			});
		$language = $this->createMock(\phpbb\language\language::class);
		$language->method('lang')
			->willReturnCallback(static fn (string $key): string => 'translated-' . $key);

		return new editor($request, $user, $language, $helper, $selector);
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
