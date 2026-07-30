<?php
/**
 * phpBB Gallery - Fail-closed Gallery BBCode migration tests
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\migrations
{
	if (!function_exists(__NAMESPACE__ . '\\generate_board_url'))
	{
		function generate_board_url(bool $without_script_path = false): string
		{
			return 'https://example.test/forum';
		}
	}
}

namespace phpbbgallery\core\tests
{
	use phpbb\config\config;
	use phpbb\db\driver\driver_interface;
	use phpbb\db\migration\exception as migration_exception;
	use phpbb\db\migration\migration;
	use phpbbgallery\core\migrations\gallery_bbcodes;
	use phpbbgallery\core\migrations\release_1_2_0_add_bbcode;
	use PHPUnit\Framework\TestCase;

	if (!defined('NUM_CORE_BBCODES'))
	{
		define('NUM_CORE_BBCODES', 12);
	}
	if (!defined('BBCODE_LIMIT'))
	{
		define('BBCODE_LIMIT', 1511);
	}

	final class gallery_bbcodes_fail_closed_test extends TestCase
	{
		// phpcs:ignore PhpbbCodingStandard.NamingConventions.LowercaseUnderscoredFunctions.NotAllowed -- PHPUnit lifecycle API.
		protected function setUp(): void
		{
			$this->load_migrations();
		}

		public function test_ready_flag_is_only_scheduled_after_successful_bbcode_installation(): void
		{
			$migration = $this->gallery_migration($this->createMock(driver_interface::class));
			$steps = $migration->update_data();

			$this->assertCount(3, $steps);
			$this->assertSame([
				'config.add',
				['phpbb_gallery_bbcode_tag', 'image'],
			], $steps[0]);
			$this->assertSame('custom', $steps[1][0]);
			$this->assertSame([[$migration, 'ensure_gallery_bbcodes']], $steps[1][1]);
			$this->assertSame([
				'config.add',
				['phpbb_gallery_bbcode_ready', 1],
			], $steps[2]);
		}

		/**
		 * @dataProvider conflicting_tag_provider
		 */
		public function test_unrelated_bbcode_conflicts_fail_closed(string $conflicting_tag, array $rows): void
		{
			$queries = [];
			$db = $this->database($rows, $queries);
			$migration = $this->gallery_migration($db);

			try
			{
				$migration->ensure_gallery_bbcodes();
				$this->fail('An unrelated [' . $conflicting_tag . '] BBCode must stop the migration.');
			}
			catch (migration_exception $exception)
			{
				$this->assertSame('GALLERY_BBCODE_CONFLICT', $exception->getMessage());
				$this->assertSame(['[' . $conflicting_tag . ']'], $exception->getParameters());
			}

			$this->assertSame(0, $this->query_count($queries, 'UPDATE phpbb_bbcodes'));
			$this->assertSame(0, $this->query_count($queries, 'INSERT INTO phpbb_bbcodes'));
		}

		public static function conflicting_tag_provider(): array
		{
			return [
				'both image tags conflict' => ['galleryimage', [
					'image' => [[
						'bbcode_id'           => 77,
						'bbcode_match'        => '[image={TEXT}]{TEXT}[/image]',
						'bbcode_helpline'     => 'Third-party image BBCode',
						'second_pass_replace' => '/custom/image/${1}',
					]],
					'galleryimage' => [[
						'bbcode_id'           => 78,
						'bbcode_match'        => '[galleryimage={TEXT}]{TEXT}[/galleryimage]',
						'bbcode_helpline'     => 'Third-party Gallery image BBCode',
						'second_pass_replace' => '/custom/gallery/${1}',
					]],
					'album' => [],
					'max'   => [],
				]],
			];
		}

		/**
		 * @dataProvider exhausted_bbcode_provider
		 */
		public function test_exhausted_bbcode_capacity_fails_closed(string $limited_tag, array $rows): void
		{
			$queries = [];
			$db = $this->database($rows, $queries);
			$migration = $this->gallery_migration($db);

			try
			{
				$migration->ensure_gallery_bbcodes();
				$this->fail('BBCODE_LIMIT must stop installation of [' . $limited_tag . '].');
			}
			catch (migration_exception $exception)
			{
				$this->assertSame('GALLERY_BBCODE_LIMIT_REACHED', $exception->getMessage());
				$this->assertSame(['[' . $limited_tag . ']'], $exception->getParameters());
			}

			$this->assertSame(0, $this->query_count($queries, 'UPDATE phpbb_bbcodes'));
			$this->assertSame(0, $this->query_count($queries, 'INSERT INTO phpbb_bbcodes'));
		}

		public static function exhausted_bbcode_provider(): array
		{
			$gallery_image = [
				'bbcode_id'           => 31,
				'bbcode_match'        => '[image]{NUMBER}[/image]',
				'bbcode_helpline'     => 'GALLERY_HELPLINE_ALBUM',
				'second_pass_replace' => '/gallery/image/${1}/mini',
			];

			return [
				'image capacity' => ['image', [
					'image' => [false],
					'album' => [false],
					'max'   => [['max_bbcode_id' => BBCODE_LIMIT]],
				]],
				'album capacity' => ['album', [
					'image' => [$gallery_image],
					'album' => [false],
					'max'   => [['max_bbcode_id' => BBCODE_LIMIT]],
				]],
				'only one free ID for two tags' => ['album', [
					'image' => [false],
					'album' => [false],
					'max'   => [['max_bbcode_id' => BBCODE_LIMIT - 1]],
				]],
			];
		}

		public function test_historical_rollback_only_removes_the_gallery_signature(): void
		{
			$queries = [];
			$rows = [
				'image' => [],
				'album' => [],
				'max'   => [],
			];
			$db = $this->database($rows, $queries);
			$migration = $this->legacy_migration($db);

			$migration->remove_bbcode();

			$this->assertCount(1, $queries);
			$sql = preg_replace('/\s+/', ' ', trim($queries[0]));
			$this->assertIsString($sql);
			$this->assertStringContainsString("WHERE LOWER(bbcode_tag) = 'image'", $sql);
			$this->assertStringContainsString("bbcode_match = '[image]{NUMBER}[/image]'", $sql);
			$this->assertStringContainsString("bbcode_helpline = 'GALLERY_HELPLINE_ALBUM'", $sql);
			$this->assertStringContainsString("second_pass_replace LIKE '%/gallery/image/%'", $sql);
			$this->assertStringNotContainsString("WHERE bbcode_tag = 'image'", $sql);
		}

		private function gallery_migration(driver_interface $db): gallery_bbcodes
		{
			$reflection = new \ReflectionClass(gallery_bbcodes::class);
			$migration = $reflection->newInstanceWithoutConstructor();
			$this->set_migration_property($migration, 'db', $db);
			$this->set_migration_property($migration, 'config', new config([
				'enable_mod_rewrite'           => 1,
				'phpbb_gallery_link_thumbnail' => 'image_page',
			]));
			$this->set_migration_property($migration, 'table_prefix', 'phpbb_');

			return $migration;
		}

		private function legacy_migration(driver_interface $db): release_1_2_0_add_bbcode
		{
			$reflection = new \ReflectionClass(release_1_2_0_add_bbcode::class);
			$migration = $reflection->newInstanceWithoutConstructor();
			$this->set_migration_property($migration, 'db', $db);
			$this->set_migration_property($migration, 'table_prefix', 'phpbb_');

			return $migration;
		}

		private function database(array &$rows, array &$queries): driver_interface
		{
			$db = $this->createMock(driver_interface::class);
			$db->method('sql_escape')->willReturnCallback(
				static fn(string $value): string => $value
			);
			$db->method('sql_query')->willReturnCallback(
				static function (string $sql) use (&$queries): string
				{
					$queries[] = $sql;
					return $sql;
				}
			);
			$db->method('sql_fetchrow')->willReturnCallback(
				static function (string $result) use (&$rows): array|false
				{
					if (str_contains($result, "LOWER(bbcode_tag) = 'image'"))
					{
						return !empty($rows['image']) ? array_shift($rows['image']) : false;
					}
					if (str_contains($result, "LOWER(bbcode_tag) = 'galleryimage'"))
					{
						return !empty($rows['galleryimage']) ? array_shift($rows['galleryimage']) : false;
					}
					if (str_contains($result, "LOWER(bbcode_tag) = 'album'"))
					{
						return !empty($rows['album']) ? array_shift($rows['album']) : false;
					}
					if (str_contains($result, 'MAX(bbcode_id)'))
					{
						return !empty($rows['max']) ? array_shift($rows['max']) : false;
					}

					return false;
				}
			);
			$db->method('sql_build_array')->willReturn('BUILT_VALUES');

			return $db;
		}

		private function set_migration_property(object $migration, string $property, mixed $value): void
		{
			$reflection = new \ReflectionProperty(migration::class, $property);
			$reflection->setValue($migration, $value);
		}

		private function query_count(array $queries, string $needle): int
		{
			return count(array_filter(
				$queries,
				static fn(string $sql): bool => str_contains($sql, $needle)
			));
		}

		private function load_migrations(): void
		{
			$phpbb_root = dirname(__DIR__, 4);
			if (!class_exists(migration::class, false))
			{
				require_once $phpbb_root . '/phpbb/db/migration/migration_interface.php';
				require_once $phpbb_root . '/phpbb/db/migration/migration.php';
			}
			if (!class_exists(migration_exception::class, false))
			{
				require_once $phpbb_root . '/phpbb/db/migration/exception.php';
			}
			if (!class_exists(gallery_bbcodes::class, false))
			{
				require_once dirname(__DIR__) . '/migrations/gallery_bbcodes.php';
			}
			if (!class_exists(release_1_2_0_add_bbcode::class, false))
			{
				require_once dirname(__DIR__) . '/migrations/release_1_2_0_add_bbcode.php';
			}
		}
	}
}
