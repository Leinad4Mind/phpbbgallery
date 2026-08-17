<?php
/**
 * phpBB Gallery statistics dashboard tests.
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\tests;

use phpbbgallery\core\statistics;
use PHPUnit\Framework\TestCase;

final class statistics_test extends TestCase
{
	public function test_legacy_summary_uses_an_explicit_integer_tracking_boundary(): void
	{
		$source = (string) file_get_contents(dirname(__DIR__) . '/statistics.php');

		$this->assertStringContainsString('$tracking_start = (int) $this->tracking_start();', $source);
		$this->assertStringContainsString('$legacy_where =', $source);
		$this->assertGreaterThanOrEqual(3, substr_count($source, '$tracking_start'));
	}

	public function test_views_and_downloads_are_aggregated_by_board_year(): void
	{
		[$db, $state] = $this->database();
		$config = new \phpbb\config\config(['board_timezone' => 'Europe/Lisbon']);
		$statistics = new statistics($db, $config, 'images', 'statistics', 'users');
		$timestamp = (new \DateTimeImmutable('2025-12-31 23:30:00', new \DateTimeZone('Europe/Lisbon')))->getTimestamp();

		$statistics->record_view(19, $timestamp);
		$statistics->record_view(19, $timestamp);
		$statistics->record_download(19, 7, $timestamp);
		$statistics->record_download(19, 7, $timestamp);
		$statistics->record_download(19, 1, $timestamp);

		$this->assertSame(3, $state->image_downloads[19]);
		$this->assertSame(2, $state->rows['1:2025:19:0']['stat_count']);
		$this->assertSame(2, $state->rows['2:2025:19:7']['stat_count']);
		$this->assertSame(1, $state->rows['2:2025:19:1']['stat_count']);
	}

	public function test_invalid_identifiers_are_ignored_and_deletion_removes_aggregates(): void
	{
		[$db, $state] = $this->database();
		$statistics = new statistics($db, new \phpbb\config\config([]), 'images', 'statistics', 'users');

		$statistics->record_view(0);
		$statistics->record_download(-1, 7);
		$this->assertSame([], $state->queries);

		$statistics->record_view(4, 1735689600);
		$statistics->record_download(4, 8, 1735689600);
		$statistics->remove_images([0, 4, 4, -2]);

		$this->assertSame([], $state->rows);
	}

	public function test_empty_permission_scope_returns_empty_dashboard_without_sql(): void
	{
		[$db, $state] = $this->database();
		$statistics = new statistics($db, new \phpbb\config\config([]), 'images', 'statistics', 'users');

		$data = $statistics->dashboard([], 2025);

		$this->assertSame(2025, $data['year']);
		$this->assertSame(['image_count' => 0, 'uploader_count' => 0, 'view_count' => 0, 'download_count' => 0], $data['summary']);
		$this->assertSame([], $state->queries);
	}

	public function test_legacy_period_preserves_historical_totals_without_assigning_them_to_old_years(): void
	{
		$tracking_start = (new \DateTimeImmutable('2026-08-11 12:00:00', new \DateTimeZone('Europe/Lisbon')))->getTimestamp();
		$first_image = (new \DateTimeImmutable('2007-03-04 09:00:00', new \DateTimeZone('Europe/Lisbon')))->getTimestamp();
		[$db, $state] = $this->dashboard_database($first_image, $tracking_start);
		$config = new \phpbb\config\config([
			'board_timezone' => 'Europe/Lisbon',
			'phpbb_gallery_statistics_tracking_start' => $tracking_start,
		]);
		$statistics = new statistics($db, $config, 'images', 'statistics', 'users');

		// Direct links to an untracked old year resolve to the single honest
		// historical period instead of showing an artificial annual result.
		$data = $statistics->dashboard([4], 2025);

		$this->assertSame(statistics::PERIOD_LEGACY, $data['year']);
		$this->assertSame($first_image, $data['legacy_start']);
		$this->assertContains(2026, $data['years']);
		$this->assertNotContains(2025, $data['years']);
		$this->assertSame([
			'image_count' => 2,
			'uploader_count' => 2,
			'view_count' => 96,
			'download_count' => 17,
		], $data['summary']);

		$sql = implode("\n", $state->queries);
		$this->assertStringContainsString('s.stat_year > 0', $sql);
		$this->assertStringContainsString('CASE WHEN i.image_view_count > COALESCE(SUM(s.stat_count), 0)', $sql);
		$this->assertStringContainsString('CASE WHEN i.image_download_count > COALESCE(SUM(s.stat_count), 0)', $sql);
		$this->assertStringContainsString('s.stat_year = 0', $sql);
		$this->assertStringContainsString('i.image_time < ' . $tracking_start, $sql);
	}

	public function test_tracking_year_starts_at_the_exact_migration_timestamp(): void
	{
		$tracking_start = (new \DateTimeImmutable('2026-08-11 12:00:00', new \DateTimeZone('Europe/Lisbon')))->getTimestamp();
		[$db, $state] = $this->dashboard_database($tracking_start - 1000, $tracking_start);
		$statistics = new statistics($db, new \phpbb\config\config([
			'board_timezone' => 'Europe/Lisbon',
			'phpbb_gallery_statistics_tracking_start' => $tracking_start,
		]), 'images', 'statistics', 'users');

		$data = $statistics->dashboard([4], 2026);

		$this->assertSame(2026, $data['year']);
		$this->assertStringContainsString('i.image_time >= ' . $tracking_start, implode("\n", $state->queries));
	}

	public function test_page_is_routed_permission_filtered_and_linked_from_all_styles(): void
	{
		$core = dirname(__DIR__);
		$routing = (string) file_get_contents($core . '/config/routing.yml');
		$controller = (string) file_get_contents($core . '/controller/statistics.php');
		$template = (string) file_get_contents($core . '/styles/all/template/gallery/statistics_body.html');

		$this->assertStringContainsString('phpbbgallery_core_statistics:', $routing);
		$this->assertStringContainsString("acl_album_ids('i_view')", $controller);
		$this->assertStringContainsString("acl_album_ids('i_statistics')", $controller);
		$this->assertStringContainsString('array_intersect(', $controller);
		$this->assertStringContainsString('get_exclude_zebra()', $controller);
		$this->assertStringContainsString('statistics_top_viewed', $template);
		$this->assertStringContainsString('statistics_top_downloaded', $template);
		$this->assertStringContainsString('statistics_top_uploaders', $template);
		$this->assertStringContainsString('statistics_top_downloaders', $template);
		$this->assertStringContainsString('class="selectpicker"', $template);
		$this->assertStringContainsString('class="button1 btn btn-default"', $template);
		$this->assertStringContainsString('S_STATISTICS_HIDDEN_FIELDS', $template);
		$this->assertStringContainsString('period.VALUE', $template);
		$this->assertStringContainsString('period.LABEL', $template);
		$this->assertStringContainsString('STATISTICS_LEGACY_TRACKING_NOTICE', $template);
		$this->assertStringContainsString('STATISTICS_LEGACY_PERIOD', $controller);
		$this->assertStringContainsString('STATISTICS_PARTIAL_YEAR', $controller);
		foreach (\gallery_test_existing_styles(dirname(__DIR__)) as $style)
		{
			$index = (string) file_get_contents($core . '/styles/' . $style . '/template/gallery/index_body.html');
			$this->assertStringContainsString('U_GALLERY_STATISTICS', $index, $style);
		}
	}

	public function test_get_filter_preserves_phpbb_session_and_style_query_fields(): void
	{
		require_once dirname(__DIR__) . '/controller/statistics.php';
		$reflection = new \ReflectionClass(\phpbbgallery\core\controller\statistics::class);
		$controller = $reflection->newInstanceWithoutConstructor();
		$fields = $reflection->getMethod('get_query_fields')->invoke(
			$controller,
			'/gallery/statistics?style=2&amp;sid=session123&amp;year=2025'
		);

		$this->assertSame(['style' => '2', 'sid' => 'session123'], $fields);
		$this->assertArrayNotHasKey('year', $fields);
		$this->assertSame([], $reflection->getMethod('get_query_fields')->invoke($controller, '/gallery/statistics'));
	}

	/** @return array{0: \phpbb\db\driver\driver_interface, 1: object} */
	private function database(): array
	{
		$state = (object) [
			'queries' => [],
			'rows' => [],
			'image_downloads' => [],
			'built' => [],
			'affected' => 0,
		];
		$db = $this->createMock(\phpbb\db\driver\driver_interface::class);
		$db->method('sql_query')->willReturnCallback(static function (string $sql) use ($state): string|false
		{
			$state->queries[] = $sql;
			$state->affected = 0;
			if (str_starts_with($sql, 'UPDATE images'))
			{
				preg_match('/image_id = (\d+)/', $sql, $matches);
				$image_id = (int) ($matches[1] ?? 0);
				$state->image_downloads[$image_id] = ($state->image_downloads[$image_id] ?? 0) + 1;
				$state->affected = 1;
			}
			else if (str_starts_with($sql, 'UPDATE statistics'))
			{
				preg_match('/stat_type = (\d+).*stat_year = (\d+).*image_id = (\d+).*user_id = (\d+)/s', $sql, $matches);
				$key = ($matches[1] ?? 0) . ':' . ($matches[2] ?? 0) . ':' . ($matches[3] ?? 0) . ':' . ($matches[4] ?? 0);
				if (isset($state->rows[$key]))
				{
					$state->rows[$key]['stat_count']++;
					$state->affected = 1;
				}
			}
			else if (str_starts_with($sql, 'INSERT INTO statistics'))
			{
				$key = $state->built['stat_type'] . ':' . $state->built['stat_year'] . ':' . $state->built['image_id'] . ':' . $state->built['user_id'];
				$state->rows[$key] = $state->built;
				$state->affected = 1;
			}
			else if (str_starts_with($sql, 'DELETE FROM statistics'))
			{
				preg_match('/IN \(([^)]+)\)/', $sql, $matches);
				$image_ids = array_map('intval', explode(',', $matches[1] ?? ''));
				foreach ($state->rows as $key => $row)
				{
					if (in_array((int) $row['image_id'], $image_ids, true))
					{
						unset($state->rows[$key]);
					}
				}
			}
			return 'result';
		});
		$db->method('sql_build_array')->willReturnCallback(static function (string $query, array $data) use ($state): string
		{
			$state->built = $data;
			return 'VALUES (test)';
		});
		$db->method('sql_in_set')->willReturnCallback(static fn (string $field, array $values): string => $field . ' IN (' . implode(',', array_map('intval', $values)) . ')');
		$db->method('sql_affectedrows')->willReturnCallback(static fn (): int => $state->affected);
		$db->method('get_sql_error_triggered')->willReturn(false);

		return [$db, $state];
	}

	/** @return array{0: \phpbb\db\driver\driver_interface, 1: object} */
	private function dashboard_database(int $first_image, int $tracking_start): array
	{
		$state = (object) [
			'queries' => [],
			'results' => [],
			'next_result' => 0,
		];
		$db = $this->createMock(\phpbb\db\driver\driver_interface::class);
		$make_result = static function (string $sql, array $rows) use ($state): string
		{
			$state->queries[] = $sql;
			$result = 'result_' . ++$state->next_result;
			$state->results[$result] = $rows;

			return $result;
		};
		$db->method('sql_query')->willReturnCallback(static function (string $sql) use ($make_result, $first_image, $tracking_start): string
		{
			if (str_contains($sql, 'MIN(i.image_time) AS first_time'))
			{
				return $make_result($sql, [['first_time' => $first_image, 'last_time' => $tracking_start + 1000]]);
			}
			if (str_contains($sql, 'SELECT DISTINCT s.stat_year'))
			{
				return $make_result($sql, [['stat_year' => 2026]]);
			}
			if (str_contains($sql, 'COUNT(i.image_id) AS image_count'))
			{
				return $make_result($sql, [[
					'image_count' => 2,
					'uploader_count' => 2,
					'lifetime_views' => 100,
					'lifetime_downloads' => 20,
				]]);
			}
			if (str_contains($sql, 'SELECT s.stat_type, SUM(s.stat_count) AS total'))
			{
				return $make_result($sql, [
					['stat_type' => statistics::TYPE_VIEW, 'total' => 4],
					['stat_type' => statistics::TYPE_DOWNLOAD, 'total' => 3],
				]);
			}

			return $make_result($sql, []);
		});
		$db->method('sql_query_limit')->willReturnCallback(static fn (string $sql): string => $make_result($sql, []));
		$db->method('sql_fetchrow')->willReturnCallback(static function (string $result) use ($state): array|false
		{
			if (empty($state->results[$result]))
			{
				return false;
			}

			return array_shift($state->results[$result]);
		});
		$db->method('sql_freeresult')->willReturnCallback(static function (string $result) use ($state): void
		{
			unset($state->results[$result]);
		});
		$db->method('sql_in_set')->willReturnCallback(static fn (string $field, array $values): string => $field . ' IN (' . implode(',', array_map('intval', $values)) . ')');

		return [$db, $state];
	}
}
