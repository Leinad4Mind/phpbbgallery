<?php
/**
 * phpBB Gallery - Core search domain tests
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\tests;

use phpbbgallery\core\search;
use PHPUnit\Framework\TestCase;

final class domain_search_types_test extends TestCase
{
	public function test_search_properties_parameters_and_returns_are_fully_typed(): void
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

	public function test_zero_limit_searches_stop_before_accessing_dependencies(): void
	{
		$reflection = new \ReflectionClass(search::class);
		$search = $reflection->newInstanceWithoutConstructor();

		$this->assertNull($search->random(0));
		$this->assertNull($search->recent(0));
	}

	public function test_count_and_rendering_contracts_are_explicit(): void
	{
		$this->assertSame('int', (string) (new \ReflectionMethod(search::class, 'recent_count'))->getReturnType());
		$this->assertSame('int', (string) (new \ReflectionMethod(search::class, 'user_image_count'))->getReturnType());

		foreach (['random', 'recent_comments', 'recent', 'contest_winners', 'rating'] as $method_name)
		{
			$this->assertSame('void', (string) (new \ReflectionMethod(search::class, $method_name))->getReturnType());
		}
	}

	public function test_profile_image_count_applies_permissions_and_contest_identity_boundary(): void
	{
		$queries = [];
		$gallery_auth = $this->createMock(\phpbbgallery\core\auth\auth::class);
		$gallery_auth->expects($this->once())->method('load_user_permissions')->with(7);
		$gallery_auth->expects($this->once())->method('get_exclude_zebra')->willReturn([5]);
		$gallery_auth->expects($this->exactly(2))
			->method('acl_album_ids')
			->willReturnCallback(static fn(string $permission): array => $permission === 'i_view' ? [2, 5] : [9, 5]);
		$db = $this->createMock(\phpbb\db\driver\driver_interface::class);
		$db->expects($this->exactly(2))
			->method('sql_in_set')
			->willReturnCallback(static fn(string $field, array $ids): string => $field . ' IN (' . implode(', ', $ids) . ')');
		$db->expects($this->once())
			->method('sql_query')
			->willReturnCallback(static function (string $sql) use (&$queries): string
			{
				$queries[] = $sql;
				return 'result';
			});
		$db->expects($this->once())->method('sql_fetchrow')->with('result')->willReturn(['count' => 4]);
		$db->expects($this->once())->method('sql_freeresult')->with('result');
		$user = new \phpbb\user();
		$user->data = ['user_id' => 7];
		$reflection = new \ReflectionClass(search::class);
		$search = $reflection->newInstanceWithoutConstructor();
		$reflection->getProperty('gallery_auth')->setValue($search, $gallery_auth);
		$reflection->getProperty('db')->setValue($search, $db);
		$reflection->getProperty('user')->setValue($search, $user);
		$reflection->getProperty('images_table')->setValue($search, 'gallery_images');

		$this->assertSame(4, $search->user_image_count(12));
		$this->assertStringContainsString('image_user_id = 12', $queries[0]);
		$this->assertStringContainsString('(image_contest = 0 OR image_user_id = 7 OR image_album_id IN (9))', $queries[0]);
		$this->assertStringContainsString('image_album_id IN (2)', $queries[0]);
		$this->assertStringContainsString('image_album_id IN (9)', $queries[0]);
	}

	public function test_discovery_queries_apply_the_matching_contest_boundary(): void
	{
		$source = (string) file_get_contents(dirname(__DIR__) . '/search.php');

		$this->assertGreaterThanOrEqual(3, substr_count($source, 'contest::private_data_visibility_sql('));
		$this->assertGreaterThanOrEqual(3, substr_count($source, 'contest::results_visibility_sql('));
	}

	public function test_random_results_require_image_view_or_moderator_permission(): void
	{
		$source = (string) file_get_contents(dirname(__DIR__) . '/search.php');
		$start = strpos($source, 'public function random(');
		$end = strpos($source, 'public function recent_count(', $start ?: 0);
		$random = substr($source, $start, $end - $start);

		$this->assertStringContainsString("acl_album_ids('i_view')", $random);
		$this->assertStringContainsString("acl_album_ids('m_status')", $random);
		$this->assertStringNotContainsString("acl_album_ids('a_list')", $random);
		$this->assertStringContainsString('if (!$id_ary && !$show_empty)', $random);
	}

	public function test_image_result_filter_normalizes_ids_and_excludes_orphans(): void
	{
		$db = $this->createMock(\phpbb\db\driver\driver_interface::class);
		$db->expects($this->once())
			->method('sql_in_set')
			->with('i.image_id', [3, 7])
			->willReturn('i.image_id IN (3, 7)');
		$reflection = new \ReflectionClass(search::class);
		$search = $reflection->newInstanceWithoutConstructor();
		$reflection->getProperty('db')->setValue($search, $db);

		$this->assertSame(
			'i.image_status <> ' . \phpbbgallery\core\block::STATUS_ORPHAN . ' AND i.image_id IN (3, 7)',
			$reflection->getMethod('get_image_result_where')->invoke($search, ['3', 7])
		);
	}
}
