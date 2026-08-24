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
		$this->assertNull($search->featured(0, 'most_viewed'));
		$this->assertSame(0, $search->curated([1, 2], 'Featured', false, 0));
	}

	public function test_count_and_rendering_contracts_are_explicit(): void
	{
		$this->assertSame('int', (string) (new \ReflectionMethod(search::class, 'recent_count'))->getReturnType());
		$this->assertSame('int', (string) (new \ReflectionMethod(search::class, 'user_image_count'))->getReturnType());
		$this->assertSame('array', (string) (new \ReflectionMethod(search::class, 'user_image_counts'))->getReturnType());
		$this->assertSame('int', (string) (new \ReflectionMethod(search::class, 'curated'))->getReturnType());

		foreach (['random', 'recent_comments', 'recent', 'recent_personal', 'featured', 'rating'] as $method_name)
		{
			$this->assertSame('void', (string) (new \ReflectionMethod(search::class, $method_name))->getReturnType());
		}
	}

	public function test_image_blocks_are_enriched_once_before_each_card_is_assigned(): void
	{
		$images = [
			['image_id' => 7, 'image_album_id' => 2],
			['image_id' => 8, 'image_album_id' => 3],
		];
		$assignments = [];
		$image = $this->createMock(\phpbbgallery\core\image\image::class);
		$image->expects($this->once())
			->method('enrich_block_template_vars')
			->with($images, 5, '')
			->willReturn([7 => ['U_FAVORITE_IMAGE' => '/favorite/7']]);
		$image->expects($this->exactly(2))
			->method('assign_block')
			->willReturnCallback(static function (...$arguments) use (&$assignments): void
			{
				$assignments[] = $arguments;
			});

		$reflection = new \ReflectionClass(search::class);
		$search = $reflection->newInstanceWithoutConstructor();
		$reflection->getProperty('image')->setValue($search, $image);
		$reflection->getMethod('assign_image_rows')->invoke($search, $images, 5, 'image_page', 'image_page');

		$this->assertSame(['U_FAVORITE_IMAGE' => '/favorite/7'], $assignments[0][5]);
		$this->assertSame([], $assignments[1][5]);
	}

	public function test_image_rows_can_be_assigned_to_an_add_on_owned_block(): void
	{
		$images = [['image_id' => 7, 'image_album_id' => 2]];
		$image = $this->createMock(\phpbbgallery\core\image\image::class);
		$image->expects($this->once())
			->method('enrich_block_template_vars')
			->with($images, 5, '')
			->willReturn([]);
		$image->expects($this->once())
			->method('assign_block')
			->with('featuredslide.image', $images[0], 5, 'image_page', 'image_page', []);

		$reflection = new \ReflectionClass(search::class);
		$search = $reflection->newInstanceWithoutConstructor();
		$reflection->getProperty('image')->setValue($search, $image);
		$reflection->getMethod('assign_image_rows')->invoke(
			$search,
			$images,
			5,
			'image_page',
			'image_page',
			'featuredslide.image'
		);
	}

	public function test_image_service_exposes_the_neutral_bulk_enrichment_event(): void
	{
		$images = [['image_id' => 7, 'image_album_id' => 2]];
		$expected = [7 => ['U_FAVORITE_IMAGE' => '/favorite/7']];
		$dispatcher = $this->createMock(\phpbb\event\dispatcher_interface::class);
		$dispatcher->expects($this->once())
			->method('trigger_event')
			->with(
				'phpbbgallery.core.imageblock.image_template_vars',
				['images' => $images, 'image_template_vars' => [], 'display_options' => 5, 'context' => 'album_display']
			)
			->willReturn(['images' => $images, 'image_template_vars' => $expected, 'display_options' => 5, 'context' => 'album_display']);
		$reflection = new \ReflectionClass(\phpbbgallery\core\image\image::class);
		$image = $reflection->newInstanceWithoutConstructor();
		$reflection->getProperty('phpbb_dispatcher')->setValue($image, $dispatcher);

		$this->assertSame($expected, $image->enrich_block_template_vars($images, 5, 'album_display'));
	}

	public function test_featured_search_rejects_unknown_ordering_modes_before_querying(): void
	{
		$search = (new \ReflectionClass(search::class))->newInstanceWithoutConstructor();

		$this->expectException(\InvalidArgumentException::class);
		$search->featured(4, 'caller_supplied_sql');
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
		$db->expects($this->exactly(3))
			->method('sql_in_set')
			->willReturnCallback(static fn(string $field, array $ids): string => $field . ' IN (' . implode(', ', $ids) . ')');
		$db->expects($this->once())
			->method('sql_query')
			->willReturnCallback(static function (string $sql) use (&$queries): string
			{
				$queries[] = $sql;
				return 'result';
			});
		$db->expects($this->exactly(2))->method('sql_fetchrow')->with('result')->willReturnOnConsecutiveCalls(['image_user_id' => 12, 'count' => 4], false);
		$db->expects($this->once())->method('sql_freeresult')->with('result');
		$user = new \phpbb\user();
		$user->data = ['user_id' => 7];
		$image_visibility = $this->createMock(\phpbbgallery\core\policy\image_visibility::class);
		$image_visibility->expects($this->once())
			->method('get_visibility_sql_for_private_data')
			->with('', 7, [9])
			->willReturn('(image_contest = 0 OR image_user_id = 7 OR image_album_id IN (9))');
		$reflection = new \ReflectionClass(search::class);
		$search = $reflection->newInstanceWithoutConstructor();
		$reflection->getProperty('gallery_auth')->setValue($search, $gallery_auth);
		$reflection->getProperty('db')->setValue($search, $db);
		$reflection->getProperty('user')->setValue($search, $user);
		$reflection->getProperty('images_table')->setValue($search, 'gallery_images');
		$reflection->getProperty('image_visibility')->setValue($search, $image_visibility);

		$this->assertSame(4, $search->user_image_count(12));
		$this->assertStringContainsString('image_user_id IN (12)', $queries[0]);
		$this->assertStringContainsString('GROUP BY image_user_id', $queries[0]);
		$this->assertStringContainsString('(image_contest = 0 OR image_user_id = 7 OR image_album_id IN (9))', $queries[0]);
		$this->assertStringContainsString('image_album_id IN (2)', $queries[0]);
		$this->assertStringContainsString('image_album_id IN (9)', $queries[0]);
	}

	public function test_batch_profile_counts_return_zero_without_additional_queries(): void
	{
		$gallery_auth = $this->createMock(\phpbbgallery\core\auth\auth::class);
		$gallery_auth->expects($this->once())->method('load_user_permissions')->with(7);
		$gallery_auth->method('get_exclude_zebra')->willReturn([]);
		$gallery_auth->method('acl_album_ids')->willReturn([2]);
		$db = $this->createMock(\phpbb\db\driver\driver_interface::class);
		$db->method('sql_in_set')->willReturnCallback(static fn(string $field, array $ids): string => $field . ' IN (' . implode(', ', $ids) . ')');
		$db->expects($this->once())->method('sql_query')->willReturn('result');
		$db->expects($this->exactly(2))->method('sql_fetchrow')->with('result')->willReturnOnConsecutiveCalls(['image_user_id' => 12, 'count' => 4], false);
		$db->expects($this->once())->method('sql_freeresult')->with('result');
		$user = new \phpbb\user();
		$user->data = ['user_id' => 7];
		$image_visibility = $this->createMock(\phpbbgallery\core\policy\image_visibility::class);
		$image_visibility->expects($this->once())
			->method('get_visibility_sql_for_private_data')
			->with('', 7, [2])
			->willReturn('(image_contest = 0)');
		$reflection = new \ReflectionClass(search::class);
		$search = $reflection->newInstanceWithoutConstructor();
		$reflection->getProperty('gallery_auth')->setValue($search, $gallery_auth);
		$reflection->getProperty('db')->setValue($search, $db);
		$reflection->getProperty('user')->setValue($search, $user);
		$reflection->getProperty('images_table')->setValue($search, 'gallery_images');
		$reflection->getProperty('image_visibility')->setValue($search, $image_visibility);

		$this->assertSame([12 => 4, 13 => 0], $search->user_image_counts([12, 13, 12, ANONYMOUS]));
	}

	public function test_discovery_queries_apply_the_matching_visibility_boundary(): void
	{
		$source = (string) file_get_contents(dirname(__DIR__) . '/search.php');

		$this->assertGreaterThanOrEqual(3, substr_count($source, '$this->image_visibility->get_visibility_sql_for_private_data('));
		$this->assertGreaterThanOrEqual(3, substr_count($source, '$this->image_visibility->get_visibility_sql_for_results('));
		$this->assertStringNotContainsString('core\\contest::', $source);
	}

	public function test_curated_blocks_reapply_permissions_status_and_visibility(): void
	{
		$source = (string) file_get_contents(dirname(__DIR__) . '/search.php');
		$start = strpos($source, 'public function curated(');
		$end = strpos($source, 'private function assign_image_rows(', $start ?: 0);
		$curated = substr($source, $start, $end - $start);

		$this->assertStringContainsString("acl_album_ids('i_view')", $curated);
		$this->assertStringContainsString("acl_album_ids('m_status')", $curated);
		$this->assertStringContainsString('STATUS_APPROVED', $curated);
		$this->assertStringContainsString('get_exclude_zebra()', $curated);
		$this->assertStringContainsString('get_visibility_sql_for_results', $curated);
		$this->assertStringNotContainsString('FIELD(', $curated);
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

	public function test_personal_album_block_derives_its_scope_from_visible_acl_albums(): void
	{
		$source = (string) file_get_contents(dirname(__DIR__) . '/search.php');
		$start = strpos($source, 'public function recent(');
		$end = strpos($source, 'public function featured(', $start ?: 0);
		$recent = substr($source, $start, $end - $start);

		$this->assertStringContainsString('if ($personal_only)', $recent);
		$this->assertStringContainsString('acl_album_ids(' . chr(39) . 'i_view' . chr(39) . ', ' . chr(39) . 'array' . chr(39) . ', false, false)', $recent);
		$this->assertStringContainsString('acl_album_ids(' . chr(39) . 'm_status' . chr(39) . ', ' . chr(39) . 'array' . chr(39) . ', false, false)', $recent);
		$this->assertStringContainsString('get_exclude_zebra()', $recent);
		$this->assertStringNotContainsString('WHERE album_user_id > 0', $recent);
	}

	public function test_personal_album_query_keeps_only_visible_non_excluded_personal_albums(): void
	{
		$album_calls = [];
		$gallery_auth = $this->createMock(\phpbbgallery\core\auth\auth::class);
		$gallery_auth->expects($this->once())->method('load_user_permissions')->with(7);
		$gallery_auth->expects($this->exactly(4))
			->method('acl_album_ids')
			->willReturnCallback(static function (string $permission, string $return = 'array', bool $rrc = false, bool $personal = true) use (&$album_calls): array
			{
				$album_calls[] = [$permission, $return, $rrc, $personal];
				if ($permission === 'i_view')
				{
					return $personal ? [10, 20, 30] : [10];
				}

				return $personal ? [11, 21, 31] : [11];
			});
		$gallery_auth->expects($this->once())->method('get_exclude_zebra')->willReturn([30, 31]);
		$sets = [];
		$db = $this->createMock(\phpbb\db\driver\driver_interface::class);
		$db->expects($this->exactly(2))
			->method('sql_in_set')
			->willReturnCallback(static function (string $field, array $ids) use (&$sets): string
			{
				$sets[] = $ids;
				return $field . ' IN (' . implode(', ', $ids) . ')';
			});
		$db->expects($this->exactly(2))->method('sql_build_query')->willReturn('query');
		$db->expects($this->once())->method('sql_query')->with('query')->willReturn('count');
		$db->expects($this->once())->method('sql_query_limit')->with('query', 4, 0)->willReturn('images');
		$db->expects($this->exactly(2))->method('sql_fetchrow')->willReturnOnConsecutiveCalls(['count' => 0], false);
		$db->expects($this->exactly(2))->method('sql_freeresult');
		$config = $this->createMock(\phpbbgallery\core\config::class);
		$config->method('get')->willReturnMap([
			['default_sort_key', null, 't'],
			['default_sort_dir', null, 'd'],
		]);
		$user = new \phpbb\user();
		$user->data = ['user_id' => 7];
		$reflection = new \ReflectionClass(search::class);
		$search = $reflection->newInstanceWithoutConstructor();
		$reflection->getProperty('gallery_auth')->setValue($search, $gallery_auth);
		$reflection->getProperty('gallery_config')->setValue($search, $config);
		$reflection->getProperty('db')->setValue($search, $db);
		$reflection->getProperty('user')->setValue($search, $user);
		$reflection->getProperty('images_table')->setValue($search, 'gallery_images');

		$search->recent(4, -1, 0, 'forum_index_display', false, false, true, false, true);

		$this->assertSame([
			['i_view', 'array', false, true],
			['m_status', 'array', false, true],
			['i_view', 'array', false, false],
			['m_status', 'array', false, false],
		], $album_calls);
		$this->assertSame([[20], [21]], $sets);
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
			'i.image_status <> ' . \phpbbgallery\core\block::STATUS_ORPHAN .
				' AND i.image_status <> ' . \phpbbgallery\core\block::STATUS_DELETE_REQUESTED .
				' AND i.image_id IN (3, 7)',
			$reflection->getMethod('get_image_result_where')->invoke($search, ['3', 7])
		);
	}
}
