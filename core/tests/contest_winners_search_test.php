<?php
/**
 * phpBB Gallery - Contest winner search tests
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\tests;

use phpbbgallery\core\search;
use PHPUnit\Framework\TestCase;

final class contest_winners_search_test extends TestCase
{
	// phpcs:ignore PhpbbCodingStandard.NamingConventions.LowercaseUnderscoredFunctions.NotAllowed -- PHPUnit lifecycle API.
	public static function setUpBeforeClass(): void
	{
		parent::setUpBeforeClass();
		$phpbb_root = dirname(__DIR__, 4);
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
		if (!class_exists(\phpbb\pagination::class, false))
		{
			require_once $phpbb_root . '/phpbb/pagination.php';
		}
	}

	public function test_contest_winners_are_grouped_ranked_and_fail_closed(): void
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
					$data['routes'] === ['phpbbgallery_core_search_contests', 'phpbbgallery_core_search_contests_page']),
				'pagination',
				'page',
				1,
				2,
				0
			);

		$user = new \phpbb\user();
		$user->data = ['user_id' => 5];
		$search = (new \ReflectionClass(search::class))->newInstanceWithoutConstructor();
		foreach ([
			'db' => $db,
			'template' => $template,
			'user' => $user,
			'language' => $language,
			'helper' => $helper,
			'gallery_config' => $gallery_config,
			'gallery_auth' => $gallery_auth,
			'image' => $image,
			'pagination' => $pagination,
		] as $property => $value)
		{
			$this->set_search_property($search, $property, $value);
		}
		$this->set_search_property($search, 'images_table', 'gallery_images');
		$this->set_search_property($search, 'albums_table', 'gallery_albums');
		$this->set_search_property($search, 'contests_table', 'gallery_contests');

		$search->contest_winners(2);

		$this->assertSame([1, 3], $assigned_ranks);
		$placeholders = array_values(array_filter(
			$assigned_blocks,
			static fn(array $assignment): bool => $assignment[0] === 'imageblock.image'
				&& !empty($assignment[1]['S_CONTEST_PLACEHOLDER'])
		));
		$this->assertCount(1, $placeholders);
		$this->assertSame(2, $placeholders[0][1]['S_CONTEST_RANK']);
		$this->assertSame('SEARCH_CONTEST', $assigned_vars['SEARCH_TITLE']);

		$all_where = implode(' ', array_column($built_queries, 'WHERE'));
		$this->assertStringContainsString('cw.image_contest = 0', $all_where);
		$this->assertStringContainsString('cw.image_contest_end = c.contest_start + c.contest_end', $all_where);
		$this->assertStringContainsString('cw.image_status IN (1, 2)', $all_where);
		$this->assertStringContainsString('i.image_status IN (1, 2)', $all_where);
	}

	public function test_routes_services_index_link_and_templates_are_wired(): void
	{
		$root = dirname(__DIR__);
		$routes = (string) file_get_contents($root . '/config/routing.yml');
		$services = (string) file_get_contents($root . '/config/services.yml');
		$controller = (string) file_get_contents($root . '/controller/search.php');
		$index = (string) file_get_contents($root . '/controller/index.php');
		$domain = (string) file_get_contents($root . '/search.php');
		$service_start = strpos($services, '    phpbbgallery.core.search:');
		$service_end = strpos($services, '    phpbbgallery.core.image.selector:', $service_start ?: 0);
		$search_service = substr($services, $service_start, $service_end - $service_start);

		$this->assertStringContainsString('path: /gallery/search/contests', $routes);
		$this->assertStringContainsString('path: /gallery/search/contests/{page}', $routes);
		$this->assertStringContainsString("'%phpbbgallery.tables.gallery_contests%'", $search_service);
		$this->assertSame(1, substr_count($search_service, "'%phpbbgallery.tables.gallery_contests%'"));
		$this->assertStringContainsString('public function contests(int $page)', $controller);
		$this->assertStringContainsString("acl_get('u_search')", $controller);
		$this->assertStringContainsString('has_visible_contest_winners()', $index);
		$this->assertStringNotContainsString('finalize_due(', $domain);

		foreach ([
			$root . '/styles/prosilver/template/gallery/search_results.html',
			$root . '/styles/BBOOTS/template/gallery/imageblock_polaroid.html',
			$root . '/styles/FLATBOOTS/template/gallery/imageblock_polaroid.html',
		] as $template)
		{
			$source = (string) file_get_contents($template);
			$this->assertStringContainsString('S_CONTEST_PLACEHOLDER', $source, $template);
			$this->assertStringContainsString('gallery-contest-placeholder', $source, $template);
		}
	}

	private function set_search_property(search $search, string $property_name, mixed $value): void
	{
		$property = new \ReflectionProperty(search::class, $property_name);
		$property->setValue($search, $value);
	}
}
