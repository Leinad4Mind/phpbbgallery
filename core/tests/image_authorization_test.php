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
use phpbbgallery\core\auth\image_authorization;
use phpbbgallery\core\controller\moderate as moderate_controller;

class image_authorization_test extends TestCase
{
	private image_authorization $authorization;

	// phpcs:ignore PhpbbCodingStandard.NamingConventions.LowercaseUnderscoredFunctions.NotAllowed -- PHPUnit lifecycle API.
	protected function setUp(): void
	{
		$this->authorization = new image_authorization();
	}

	public function test_helper_contract_is_fully_typed(): void
	{
		$reflection = new \ReflectionClass(image_authorization::class);

		foreach ($reflection->getMethods() as $method)
		{
			if ($method->getDeclaringClass()->getName() !== image_authorization::class)
			{
				continue;
			}

			foreach ($method->getParameters() as $parameter)
			{
				$this->assertNotNull($parameter->getType(), $method->getName() . '($' . $parameter->getName() . ')');
			}

			$this->assertNotNull($method->getReturnType(), $method->getName() . '()');
		}
	}

	public function test_image_permissions_only_apply_to_the_owner(): void
	{
		$image = ['image_user_id' => 10];

		$this->assertTrue($this->authorization->can_manage_image(10, $image, true, false, false));
		$this->assertFalse($this->authorization->can_manage_image(11, $image, true, false, false));
		$this->assertFalse($this->authorization->can_manage_image(10, $image, false, false, false));
		$this->assertFalse($this->authorization->can_manage_image(10, $image, true, false, true));
	}

	public function test_moderator_permission_can_manage_any_image_including_orphans(): void
	{
		$image = ['image_user_id' => 10];

		$this->assertTrue($this->authorization->can_manage_image(11, $image, false, true, false));
		$this->assertTrue($this->authorization->can_manage_image(11, $image, false, true, true));
	}

	public function test_normalizes_unique_positive_integer_image_ids(): void
	{
		$this->assertSame([3, 7], $this->authorization->normalize_image_ids([3, 7, 3]));

		foreach ([[], [0], [-1], ['3'], [3.0], [[3]]] as $invalid_ids)
		{
			$this->assertFalse($this->authorization->normalize_image_ids($invalid_ids));
		}
	}

	public function test_moderation_requires_the_real_image_album_and_permission(): void
	{
		$image = ['image_album_id' => 5];
		$album = ['album_id' => 5];

		$this->assertTrue($this->authorization->can_moderate_image($image, $album, 5, true));
		$this->assertTrue($this->authorization->can_moderate_image($image, $album, 0, true));
		$this->assertFalse($this->authorization->can_moderate_image($image, $album, 6, true));
		$this->assertFalse($this->authorization->can_moderate_image($image, ['album_id' => 6], 0, true));
		$this->assertFalse($this->authorization->can_moderate_image($image, $album, 5, false));
		$this->assertFalse($this->authorization->can_moderate_image([], $album, 5, true));
	}

	public function test_destination_album_requires_its_own_permission(): void
	{
		$album = ['album_id' => 8];

		$this->assertTrue($this->authorization->can_moderate_album($album, 8, true));
		$this->assertFalse($this->authorization->can_moderate_album($album, 8, false));
		$this->assertFalse($this->authorization->can_moderate_album($album, 9, true));
		$this->assertFalse($this->authorization->can_moderate_album([], 8, true));
	}

	public function test_batch_validation_loads_groups_and_authorizes_every_image(): void
	{
		$images = [
			11 => ['image_album_id' => 5],
			22 => ['image_album_id' => 6],
			44 => ['image_album_id' => 7],
		];
		$albums = [
			5 => ['album_id' => 5, 'album_user_id' => 0],
			6 => ['album_id' => 6, 'album_user_id' => 0],
		];

		$authorized = $this->authorize_batch([11, 22, 11], 0, $images, $albums, [5 => true, 6 => true]);
		$this->assertSame([11, 22], $authorized['image_ids']);
		$this->assertSame([5 => [11], 6 => [22]], $authorized['images_by_album']);

		$this->assertFalse($this->authorize_batch([11, 22], 5, $images, $albums, [5 => true, 6 => true]));
		$this->assertFalse($this->authorize_batch([11, 22], 0, $images, $albums, [5 => true, 6 => false]));
		$this->assertFalse($this->authorize_batch([11, 33], 0, $images, $albums, [5 => true, 6 => true]));
		$this->assertFalse($this->authorize_batch([11, 44], 0, $images, $albums, [5 => true, 6 => true]));
	}

	public function test_controllers_use_the_authorization_guard_at_every_mutation_boundary(): void
	{
		$image_controller = file_get_contents(dirname(__DIR__) . '/controller/image.php');
		$moderate_controller = file_get_contents(dirname(__DIR__) . '/controller/moderate.php');
		$core_services = file_get_contents(dirname(__DIR__) . '/config/services.yml');
		$controller_services = file_get_contents(dirname(__DIR__) . '/config/services_controller.yml');

		$this->assertSame(2, substr_count($image_controller, 'image_authorization->can_manage_image('));
		$this->assertStringContainsString("acl_check('i_edit'", $image_controller);
		$this->assertStringContainsString("acl_check('i_delete'", $image_controller);
		$this->assertSame(3, substr_count($moderate_controller, '$this->authorize_action_images('));
		$this->assertStringContainsString('authorize_action_images($selected_image_ids', $moderate_controller);
		$this->assertStringContainsString('authorize_action_images($report_ary', $moderate_controller);
		$this->assertStringContainsString('authorize_action_images($actions_array', $moderate_controller);
		$this->assertStringContainsString('image->get_image_data($image_id)', $moderate_controller);
		$this->assertStringContainsString('gallery_auth->acl_check($permission, $image_album_id', $moderate_controller);
		$this->assertStringContainsString('image_authorization->can_moderate_album($target_album', $moderate_controller);
		$this->assertStringNotContainsString('approve_images($actions_array, $album_id)', $moderate_controller);
		$this->assertStringNotContainsString('close_reports_by_image($this->request', $moderate_controller);
		$this->assertStringContainsString('phpbbgallery.core.auth.image_authorization:', $core_services);
		$this->assertSame(2, substr_count($controller_services, "'@phpbbgallery.core.auth.image_authorization'"));
		$this->assertStringContainsString("- '@phpbbgallery.core.auth'\n            - '@phpbbgallery.core.auth.image_authorization'\n            - '@phpbbgallery.core.user'", $controller_services);
		$this->assertStringContainsString("- '@phpbbgallery.core.auth'\n            - '@phpbbgallery.core.config'\n            - '@phpbbgallery.core.auth.image_authorization'\n            - '@phpbbgallery.core.misc'", $controller_services);
	}

	/**
	 * @return array|false
	 */
	private function authorize_batch(array $image_ids, int $route_album_id, array $images, array $albums, array $permissions): array|false
	{
		$controller = (new \ReflectionClass(moderate_controller::class))->newInstanceWithoutConstructor();
		$image_loader = $this->createMock(\phpbbgallery\core\image\image::class);
		$image_loader->method('get_image_data')->willReturnCallback(static fn (int $image_id): array|false => $images[$image_id] ?? false);
		$album_loader = $this->createMock(\phpbbgallery\core\album\album::class);
		$album_loader->method('get_info')->willReturnCallback(static fn (int $album_id): array => $albums[$album_id] ?? []);
		$gallery_auth = $this->createMock(\phpbbgallery\core\auth\auth::class);
		$gallery_auth->method('acl_check')->willReturnCallback(static fn (string $permission, int $album_id, int $album_user_id): bool => $permission === 'm_delete' && !empty($permissions[$album_id]));

		$set_dependencies = \Closure::bind(function (object $image_loader, object $album_loader, object $gallery_auth): void
		{
			$this->image = $image_loader;
			$this->album = $album_loader;
			$this->gallery_auth = $gallery_auth;
			$this->image_authorization = new image_authorization();
		}, $controller, moderate_controller::class);
		$set_dependencies($image_loader, $album_loader, $gallery_auth);

		$authorize = \Closure::bind(function (array $image_ids, int $route_album_id): array|false
		{
			return $this->authorize_action_images($image_ids, 'm_delete', $route_album_id);
		}, $controller, moderate_controller::class);

		return $authorize($image_ids, $route_album_id);
	}
}
