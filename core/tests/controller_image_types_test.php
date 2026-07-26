<?php
/**
 * phpBB Gallery - Image controller tests
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\tests;

use phpbbgallery\core\controller\image;
use PHPUnit\Framework\TestCase;

final class controller_image_types_test extends TestCase
{
	public function test_image_controller_properties_and_methods_are_fully_typed(): void
	{
		$reflection = new \ReflectionClass(image::class);

		foreach ($reflection->getProperties() as $property)
		{
			if ($property->getDeclaringClass()->getName() === image::class)
			{
				$this->assertNotNull($property->getType(), image::class . '::$' . $property->getName());
			}
		}

		foreach ($reflection->getMethods() as $method)
		{
			if ($method->getDeclaringClass()->getName() !== image::class)
			{
				continue;
			}

			foreach ($method->getParameters() as $parameter)
			{
				$this->assertNotNull($parameter->getType(), image::class . '::' . $method->getName() . '($' . $parameter->getName() . ')');
			}

			if (!$method->isConstructor())
			{
				$this->assertNotNull($method->getReturnType(), image::class . '::' . $method->getName() . '()');
			}
		}
	}

	public function test_image_routes_use_integer_identifiers_and_explicit_responses(): void
	{
		$reflection = new \ReflectionClass(image::class);
		$base = $reflection->getMethod('base');

		$this->assertSame('int', (string) $base->getParameters()[0]->getType());
		$this->assertSame('int', (string) $base->getParameters()[1]->getType());
		$this->assertSame(1, $base->getParameters()[1]->getDefaultValue());
		$this->assertSame('Symfony\\Component\\HttpFoundation\\Response', (string) $base->getReturnType());

		foreach (['edit', 'delete'] as $method_name)
		{
			$method = $reflection->getMethod($method_name);
			$this->assertSame('int', (string) $method->getParameters()[0]->getType());
			$this->assertSame('?Symfony\\Component\\HttpFoundation\\Response', (string) $method->getReturnType());
		}

		$report = $reflection->getMethod('report');
		$this->assertSame('int', (string) $report->getParameters()[0]->getType());
		$this->assertSame('Symfony\\Component\\HttpFoundation\\Response', (string) $report->getReturnType());
	}

	public function test_request_local_state_is_reset_before_image_rendering(): void
	{
		$reflection = new \ReflectionClass(image::class);
		$controller = $reflection->newInstanceWithoutConstructor();
		foreach (['data', 'users_id_array', 'users_data_array', 'profile_fields_data', 'can_receive_pm_list'] as $property_name)
		{
			$reflection->getProperty($property_name)->setValue($controller, ['stale' => true]);
		}

		$reflection->getMethod('reset_request_state')->invoke($controller);

		foreach (['data', 'users_id_array', 'users_data_array', 'profile_fields_data', 'can_receive_pm_list'] as $property_name)
		{
			$this->assertSame([], $reflection->getProperty($property_name)->getValue($controller));
		}
	}

	public function test_invalid_sort_keys_fall_back_to_time(): void
	{
		$reflection = new \ReflectionClass(image::class);
		$controller = $reflection->newInstanceWithoutConstructor();
		$normalizer = $reflection->getMethod('normalize_sort_key');
		$sort_columns = ['t' => 'image_time', 'n' => 'image_name_clean'];

		$this->assertSame('t', $normalizer->invoke($controller, 'invalid', $sort_columns));
		$this->assertSame('n', $normalizer->invoke($controller, 'n', $sort_columns));
	}

	public function test_navigation_visibility_conditions_respect_moderation_access(): void
	{
		$reflection = new \ReflectionClass(image::class);
		$controller = $reflection->newInstanceWithoutConstructor();
		$gallery_auth = $this->createMock(\phpbbgallery\core\auth\auth::class);
		$gallery_auth->expects($this->exactly(2))
			->method('acl_check')
			->with('m_status', 7, 0)
			->willReturnOnConsecutiveCalls(true, false);
		$user = new \phpbb\user();
		$user->data = ['user_id' => 42];
		$reflection->getProperty('gallery_auth')->setValue($controller, $gallery_auth);
		$reflection->getProperty('user')->setValue($controller, $user);
		$conditions = $reflection->getMethod('get_image_visibility_conditions');

		$this->assertSame([
			'image_album_id = 7',
			'image_status <> ' . \phpbbgallery\core\block::STATUS_ORPHAN,
		], $conditions->invoke($controller, 7, 0));
		$this->assertSame([
			'image_album_id = 7',
			'image_status <> ' . \phpbbgallery\core\block::STATUS_ORPHAN,
			'(image_status = ' . \phpbbgallery\core\block::STATUS_APPROVED . ' OR image_user_id = 42)',
		], $conditions->invoke($controller, 7, 0));
	}

	public function test_view_counter_remains_page_owned_and_sort_order_has_no_duplicate_suffix(): void
	{
		$source = (string) file_get_contents(dirname(__DIR__) . '/controller/image.php');

		$this->assertStringContainsString('SET image_view_count = image_view_count + 1', $source);
		$this->assertStringContainsString("ORDER BY ' . \$sql_sort_order;", $source);
		$this->assertStringNotContainsString("ORDER BY ' . \$sql_sort_order . \$sql_help_sort", $source);
	}

	public function test_deleted_comment_users_keep_their_stored_identity_without_a_profile_link(): void
	{
		if (!defined('ANONYMOUS'))
		{
			define('ANONYMOUS', 1);
		}

		$reflection = new \ReflectionClass(image::class);
		$controller = $reflection->newInstanceWithoutConstructor();
		$prepare = $reflection->getMethod('prepare_comment_poster');
		$comment = [
			'comment_user_id' => 55,
			'comment_username' => 'Former member',
			'comment_user_colour' => 'abcdef',
		];

		$this->assertSame([
			'user_deleted' => true,
			'poster_id' => ANONYMOUS,
			'username' => 'Former member',
			'user_colour' => 'abcdef',
		], $prepare->invoke($controller, $comment, []));

		$this->assertSame([
			'user_deleted' => false,
			'poster_id' => 55,
			'username' => 'Current member',
			'user_colour' => '123456',
		], $prepare->invoke($controller, $comment, ['username' => 'Current member', 'user_colour' => '123456']));
	}

	public function test_comment_display_does_not_use_an_undefined_user_cache(): void
	{
		$source = (string) file_get_contents(dirname(__DIR__) . '/controller/image.php');

		$this->assertStringNotContainsString('$user_cache', $source);
		$this->assertStringContainsString('$can_receive_pm = !$user_deleted &&', $source);
		$this->assertStringContainsString('$user_data[\'email\'] ?? \'\'', $source);
	}
}
