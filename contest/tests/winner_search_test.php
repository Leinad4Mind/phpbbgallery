<?php
/**
 * phpBB Gallery Contest winner search tests.
 *
 * @package   phpbbgallery/contest
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\contest\tests;

use phpbbgallery\contest\winner_search;
use PHPUnit\Framework\TestCase;

final class winner_search_test extends TestCase
{
	public function test_service_is_fully_typed_and_keeps_visibility_checks(): void
	{
		$reflection = new \ReflectionClass(winner_search::class);
		foreach ($reflection->getProperties() as $property)
		{
			$this->assertNotNull($property->getType());
		}
		foreach ($reflection->getMethods() as $method)
		{
			foreach ($method->getParameters() as $parameter)
			{
				$this->assertNotNull($parameter->getType());
			}
			if (!$method->isConstructor())
			{
				$this->assertNotNull($method->getReturnType());
			}
		}

		$source = (string) file_get_contents(dirname(__DIR__) . '/winner_search.php');
		$this->assertStringContainsString("acl_album_ids('i_view')", $source);
		$this->assertStringContainsString('get_exclude_zebra()', $source);
		$this->assertStringContainsString('image_contest_end = c.contest_start + c.contest_end', $source);
		$this->assertStringContainsString('image_status', $source);
	}

	public function test_winners_are_grouped_ranked_and_fail_closed(): void
	{
		$rows = [
			'albums' => [['album_id' => 10], false],
			'count' => [['count' => 1]],
			'contests' => [[
				'contest_id' => 7,
				'contest_album_id' => 10,
				'contest_start' => 100,
				'contest_end' => 100,
				'contest_first' => 101,
				'contest_second' => 102,
				'contest_third' => 103,
				'album_name' => 'Summer',
			], false],
			'winners' => [
				['image_id' => 101, 'image_album_id' => 10, 'image_contest_end' => 200],
				['image_id' => 102, 'image_album_id' => 10, 'image_contest_end' => 999],
				['image_id' => 103, 'image_album_id' => 10, 'image_contest_end' => 200],
				false,
			],
		];
		$built_queries = [];
		$db = $this->createMock(\phpbb\db\driver\driver_interface::class);
		$db->method('sql_in_set')
			->willReturnCallback(static fn(string $field, array $values): string =>
				$field . ' IN (' . implode(', ', array_map('intval', $values)) . ')');
		$db->method('sql_build_query')
			->willReturnCallback(static function(string $type, array $query) use (&$built_queries): string
			{
				$built_queries[] = $query;
				if (str_contains($query['SELECT'], 'COUNT('))
				{
					return 'count';
				}

				return str_contains($query['SELECT'], 'c.contest_id') ? 'contests' : 'winners';
			});
		$db->method('sql_query')
			->willReturnCallback(static fn(string $sql): string => str_contains($sql, 'SELECT album_id') ? 'albums' : $sql);
		$db->method('sql_query_limit')->willReturnCallback(static fn(string $sql): string => $sql);
		$db->method('sql_fetchrow')
			->willReturnCallback(static function(string $result) use (&$rows): array|false
			{
				return array_shift($rows[$result]);
			});

		$gallery_auth = $this->getMockBuilder(\phpbbgallery\core\auth\auth::class)
			->disableOriginalConstructor()
			->onlyMethods(['load_user_permissions', 'acl_album_ids', 'get_exclude_zebra'])
			->getMock();
		$gallery_auth->expects($this->once())->method('load_user_permissions')->with(5);
		$gallery_auth->expects($this->once())->method('acl_album_ids')->with('i_view')->willReturn([10, 11]);
		$gallery_auth->expects($this->once())->method('get_exclude_zebra')->willReturn([11]);

		$assigned_blocks = [];
		$assigned_vars = [];
		$template = $this->createMock(\phpbb\template\template::class);
		$template->method('assign_block_vars')
			->willReturnCallback(static function(string $block, array $vars) use (&$assigned_blocks): void
			{
				$assigned_blocks[] = [$block, $vars];
			});
		$template->method('assign_vars')
			->willReturnCallback(static function(array $vars) use (&$assigned_vars): void
			{
				$assigned_vars = $vars;
			});

		$assigned_ranks = [];
		$image = $this->getMockBuilder(\phpbbgallery\core\image\image::class)
			->disableOriginalConstructor()
			->onlyMethods(['assign_block'])
			->getMock();
		$image->method('assign_block')
			->willReturnCallback(static function(string $block, array $row) use (&$assigned_ranks): void
			{
				$assigned_ranks[] = (int) $row['image_contest_rank'];
			});

		$language = $this->createMock(\phpbb\language\language::class);
		$language->method('lang')
			->willReturnCallback(static fn(string $key, mixed ...$arguments): string =>
				$key === 'CONTEST_WINNERS_OF' ? 'Winners of ' . $arguments[0] : $key);
		$helper = $this->createMock(\phpbb\controller\helper::class);
		$helper->method('route')->willReturnCallback(static fn(string $route): string => '/' . $route);
		$gallery_config = $this->getMockBuilder(\phpbbgallery\core\config::class)
			->disableOriginalConstructor()
			->onlyMethods(['get'])
			->getMock();
		$gallery_config->method('get')->willReturnCallback(static fn(string $key): int|string =>
			$key === 'search_display' ? 0 : 'image_page');
		$pagination = $this->createMock(\phpbb\pagination::class);
		$pagination->expects($this->once())
			->method('generate_template_pagination')
			->with(
				$this->callback(static fn(array $data): bool =>
					$data['routes'] === ['phpbbgallery_contest_search', 'phpbbgallery_contest_search_page']),
				'pagination',
				'page',
				1,
				2,
				0
			);

		$user = new \phpbb\user();
		$user->data = ['user_id' => 5];
		$search = new winner_search(
			$db,
			$template,
			$user,
			$language,
			$helper,
			$gallery_config,
			$gallery_auth,
			$image,
			$pagination,
			'gallery_images',
			'gallery_albums',
			'gallery_contests'
		);

		$search->display(2);

		$this->assertSame([1, 3], $assigned_ranks);
		$placeholders = array_values(array_filter(
			$assigned_blocks,
			static fn(array $assignment): bool => $assignment[0] === 'imageblock.image'
				&& !empty($assignment[1]['S_IMAGE_AWARD_PLACEHOLDER'])
		));
		$this->assertCount(1, $placeholders);
		$this->assertSame(2, $placeholders[0][1]['S_IMAGE_AWARD_RANK']);
		$this->assertSame('SEARCH_CONTEST', $assigned_vars['SEARCH_TITLE']);

		$all_where = implode(' ', array_column($built_queries, 'WHERE'));
		$this->assertStringContainsString('cw.image_contest = 0', $all_where);
		$this->assertStringContainsString('cw.image_contest_end = c.contest_start + c.contest_end', $all_where);
		$this->assertStringContainsString('cw.image_status IN (1, 2)', $all_where);
		$this->assertStringContainsString('i.image_status IN (1, 2)', $all_where);
	}

	public function test_no_visible_album_avoids_database_queries(): void
	{
		$db = $this->createMock(\phpbb\db\driver\driver_interface::class);
		$db->expects($this->never())->method('sql_query');
		$auth = $this->createMock(\phpbbgallery\core\auth\auth::class);
		$auth->expects($this->once())->method('load_user_permissions')->with(7);
		$auth->expects($this->once())->method('acl_album_ids')->with('i_view')->willReturn([]);
		$auth->expects($this->once())->method('get_exclude_zebra')->willReturn([]);
		$user = $this->createStub(\phpbb\user::class);
		$user->data = ['user_id' => 7];

		$search = new winner_search(
			$db,
			$this->createStub(\phpbb\template\template::class),
			$user,
			$this->createStub(\phpbb\language\language::class),
			$this->createStub(\phpbb\controller\helper::class),
			$this->createStub(\phpbbgallery\core\config::class),
			$auth,
			$this->createStub(\phpbbgallery\core\image\image::class),
			$this->createStub(\phpbb\pagination::class),
			'gallery_images',
			'gallery_albums',
			'gallery_contests'
		);

		$this->assertFalse($search->has_visible_winners());
	}
}
