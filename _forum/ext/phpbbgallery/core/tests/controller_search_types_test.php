<?php
/**
 * phpBB Gallery - Search controller tests
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\tests;

use phpbbgallery\core\controller\search;
use PHPUnit\Framework\TestCase;

final class controller_search_types_test extends TestCase
{
	public function test_search_controller_properties_and_methods_are_fully_typed(): void
	{
		$reflection = new \ReflectionClass(search::class);

		foreach ($reflection->getProperties() as $property)
		{
			if ($property->getDeclaringClass()->getName() === search::class)
			{
				$this->assertNotNull($property->getType(), search::class . '::$' . $property->getName());
			}
		}

		foreach ($reflection->getMethods() as $method)
		{
			if ($method->getDeclaringClass()->getName() !== search::class)
			{
				continue;
			}

			foreach ($method->getParameters() as $parameter)
			{
				$this->assertNotNull($parameter->getType(), search::class . '::' . $method->getName() . '($' . $parameter->getName() . ')');
			}

			if (!$method->isConstructor())
			{
				$this->assertNotNull($method->getReturnType(), search::class . '::' . $method->getName() . '()');
			}
		}
	}

	public function test_search_routes_return_responses_and_paged_routes_use_integers(): void
	{
		$reflection = new \ReflectionClass(search::class);
		foreach (['base', 'random', 'recent', 'recent_comments', 'ego_search', 'toprated'] as $method_name)
		{
			$method = $reflection->getMethod($method_name);
			$this->assertSame('Symfony\\Component\\HttpFoundation\\Response', (string) $method->getReturnType());
			if ($method_name !== 'random')
			{
				$this->assertSame('int', (string) $method->getParameters()[0]->getType());
			}
		}
	}

	public function test_page_numbers_are_clamped_to_the_first_page(): void
	{
		$reflection = new \ReflectionClass(search::class);
		$controller = $reflection->newInstanceWithoutConstructor();
		$normalizer = $reflection->getMethod('normalize_page');

		$this->assertSame(1, $normalizer->invoke($controller, -10));
		$this->assertSame(1, $normalizer->invoke($controller, 0));
		$this->assertSame(4, $normalizer->invoke($controller, 4));
	}

	public function test_optional_identifier_filters_drop_zero_invalid_and_duplicate_values(): void
	{
		$reflection = new \ReflectionClass(search::class);
		$controller = $reflection->newInstanceWithoutConstructor();
		$normalizer = $reflection->getMethod('normalize_id_filter');

		$this->assertSame([], $normalizer->invoke($controller, [0]));
		$this->assertSame([7, 12], $normalizer->invoke($controller, ['7', -3, 0, 12, 7, 'invalid']));
	}

	public function test_submitted_album_filters_are_intersected_with_view_permissions(): void
	{
		$gallery_auth = $this->getMockBuilder(\phpbbgallery\core\auth\auth::class)
			->disableOriginalConstructor()
			->onlyMethods(['acl_album_ids'])
			->getMock();
		$gallery_auth->expects($this->exactly(2))
			->method('acl_album_ids')
			->with('i_view')
			->willReturn([2, 4, 7]);

		$controller = (new \ReflectionClass(search::class))->newInstanceWithoutConstructor();
		$this->set_controller_property($controller, 'gallery_auth', $gallery_auth);
		$restrict = new \ReflectionMethod(search::class, 'get_search_album_ids');

		$this->assertSame([4, 7], $restrict->invoke($controller, [4, 6, 7]));
		$this->assertSame([2, 4, 7], $restrict->invoke($controller, []));
	}

	public function test_image_visibility_excludes_orphans_and_limits_unapproved_images(): void
	{
		$gallery_auth = $this->getMockBuilder(\phpbbgallery\core\auth\auth::class)
			->disableOriginalConstructor()
			->onlyMethods(['acl_album_ids'])
			->getMock();
		$gallery_auth->expects($this->once())
			->method('acl_album_ids')
			->with('m_status')
			->willReturn([9]);

		$db = $this->createMock(\phpbb\db\driver\driver_interface::class);
		$db->expects($this->once())
			->method('sql_in_set')
			->with('i.image_album_id', [9])
			->willReturn('i.image_album_id IN (9)');

		$user = new \phpbb\user();
		$user->data = ['user_id' => 42, 'is_registered' => true];

		$controller = (new \ReflectionClass(search::class))->newInstanceWithoutConstructor();
		$this->set_controller_property($controller, 'gallery_auth', $gallery_auth);
		$this->set_controller_property($controller, 'db', $db);
		$this->set_controller_property($controller, 'user', $user);

		$visibility = (new \ReflectionMethod(search::class, 'get_image_visibility_sql'))->invoke($controller);

		$this->assertSame(
			'i.image_status <> 3 AND (i.image_status <> 0 OR i.image_user_id = 42 OR i.image_album_id IN (9))',
			$visibility
		);
	}

	public function test_anonymous_search_does_not_claim_other_guest_uploads(): void
	{
		$gallery_auth = $this->getMockBuilder(\phpbbgallery\core\auth\auth::class)
			->disableOriginalConstructor()
			->onlyMethods(['acl_album_ids'])
			->getMock();
		$gallery_auth->method('acl_album_ids')->with('m_status')->willReturn([]);

		$user = new \phpbb\user();
		$user->data = ['user_id' => 1, 'is_registered' => false];

		$controller = (new \ReflectionClass(search::class))->newInstanceWithoutConstructor();
		$this->set_controller_property($controller, 'gallery_auth', $gallery_auth);
		$this->set_controller_property($controller, 'db', $this->createMock(\phpbb\db\driver\driver_interface::class));
		$this->set_controller_property($controller, 'user', $user);

		$visibility = (new \ReflectionMethod(search::class, 'get_image_visibility_sql'))->invoke($controller);

		$this->assertSame('i.image_status <> 3 AND (i.image_status <> 0)', $visibility);
	}

	public function test_search_permission_is_checked_before_queries_and_wildcards_are_escaped_once(): void
	{
		$source = (string) file_get_contents(dirname(__DIR__) . '/controller/search.php');
		$permission_check = strpos($source, '$this->auth->acl_get(\'u_search\')');
		$search_execution = strpos($source, 'if ($keywords || $username || $user_id || $search_id || $submit || $additional_search_active)');

		$this->assertNotFalse($permission_check);
		$this->assertNotFalse($search_execution);
		$this->assertLessThan($search_execution, $permission_check);
		$this->assertStringContainsString('sql_like_expression(str_replace(\'*\', $this->db->get_any_char(), utf8_clean_string($username)))', $source);
		$this->assertStringNotContainsString('utf8_clean_string($this->db->sql_escape($username))', $source);
	}

	public function test_search_pagination_and_toprated_breadcrumb_use_the_correct_targets(): void
	{
		$source = (string) file_get_contents(dirname(__DIR__) . '/controller/search.php');

		$this->assertStringContainsString("'page', \$search_count, \$this->gallery_config->get('items_per_page'), \$start", $source);
		$this->assertStringContainsString("'SEARCH_TOPRATED'),\n\t\t\t'U_VIEW_FORUM'\t=> \$this->helper->route('phpbbgallery_core_search_toprated')", $source);
		$this->assertStringNotContainsString('\$current_page - 1', $source);
	}

	private function set_controller_property(search $controller, string $property_name, object $value): void
	{
		$property = new \ReflectionProperty(search::class, $property_name);
		$property->setValue($controller, $value);
	}
}
