<?php
/**
 * phpBB Gallery - Gallery BBCode migration tests
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
	use phpbbgallery\core\migrations\forum_index_images;
	use PHPUnit\Framework\TestCase;

	final class gallery_bbcodes_test extends TestCase
	{
		// phpcs:ignore PhpbbCodingStandard.NamingConventions.LowercaseUnderscoredFunctions.NotAllowed -- PHPUnit lifecycle API.
		protected function setUp(): void
		{
			$this->load_migration();
		}

		public function test_clean_install_uses_distinct_ids_and_respects_rewrite_mode(): void
		{
			$this->assertSame(['\\' . forum_index_images::class], gallery_bbcodes::depends_on());

			foreach ([
				0 => 'https://example.test/forum/app.php/gallery/image/',
				1 => 'https://example.test/forum/gallery/image/',
			] as $rewrite => $expected_base_url)
			{
				$row_queues = [
					'image' => [false],
					'album' => [false],
					'max'   => [
						['max_bbcode_id' => NUM_CORE_BBCODES],
					],
				];
				$built_arrays = [];
				$queries = [];
				$db = $this->database($row_queues, $built_arrays, $queries);
				$migration = $this->migration($db, [
					'enable_mod_rewrite'           => $rewrite,
					'phpbb_gallery_link_thumbnail' => 'image',
				]);

				$migration->ensure_gallery_bbcodes();

				$inserts = array_values(array_filter(
					$built_arrays,
					static fn(array $entry): bool => $entry['operation'] === 'INSERT'
				));
				$this->assertCount(2, $inserts);
				$by_tag = [];
				foreach ($inserts as $insert)
				{
					$by_tag[$insert['values']['bbcode_tag']] = $insert['values'];
				}

				$this->assertSame(NUM_CORE_BBCODES + 1, $by_tag['image']['bbcode_id']);
				$this->assertSame(NUM_CORE_BBCODES + 2, $by_tag['album']['bbcode_id']);
				$this->assertNotSame($by_tag['image']['bbcode_id'], $by_tag['album']['bbcode_id']);
				$this->assertSame(1, $by_tag['image']['display_on_posting']);
				$this->assertSame(0, $by_tag['album']['display_on_posting']);
				$this->assertStringContainsString($expected_base_url . '{NUMBER}/source', $by_tag['image']['bbcode_tpl']);
				$this->assertStringContainsString($expected_base_url . '${1}/source', $by_tag['image']['second_pass_replace']);
				$this->assertStringNotContainsString('sid=', serialize($inserts));
				$this->assertSame(2, $this->query_count($queries, 'INSERT INTO phpbb_bbcodes'));
				$this->assertSame(1, $this->query_count($queries, 'MAX(bbcode_id)'));
			}
		}

		public function test_ready_flag_follows_successful_installation_and_precedes_alias_cleanup_on_revert(): void
		{
			$migration = $this->migration($this->createMock(driver_interface::class), []);

			$this->assertSame([
				['custom', [[$migration, 'ensure_gallery_bbcodes']]],
				['config.add', ['phpbb_gallery_bbcode_ready', 1]],
			], $migration->update_data());
			$this->assertSame([
				['config.remove', ['phpbb_gallery_bbcode_ready']],
				['custom', [[$migration, 'remove_legacy_alias']]],
			], $migration->revert_data());
		}

		public function test_existing_ids_and_legacy_alias_are_preserved_idempotently(): void
		{
			$image = [
				'bbcode_id'           => 31,
				'bbcode_match'        => '[image]{NUMBER}[/image]',
				'bbcode_helpline'     => 'GALLERY_HELPLINE_ALBUM',
				'second_pass_replace' => '/old/image/${1}',
			];
			$album = [
				'bbcode_id'           => 47,
				'bbcode_match'        => '[album]{NUMBER}[/album]',
				'bbcode_helpline'     => 'GALLERY_HELPLINE_ALBUM',
				'second_pass_replace' => '/gallery/image/${1}/mini',
			];
			$row_queues = [
				'image' => [$image, $image],
				'album' => [$album, $album],
				'max'   => [],
			];
			$built_arrays = [];
			$queries = [];
			$db = $this->database($row_queues, $built_arrays, $queries);
			$migration = $this->migration($db, [
				'enable_mod_rewrite'           => 1,
				'phpbb_gallery_link_thumbnail' => 'image_page',
			]);

			$migration->ensure_gallery_bbcodes();
			$migration->ensure_gallery_bbcodes();

			$updates = array_values(array_filter(
				$built_arrays,
				static fn(array $entry): bool => $entry['operation'] === 'UPDATE'
			));
			$this->assertCount(4, $updates);
			$this->assertSame($updates[0]['values'], $updates[2]['values']);
			$this->assertSame($updates[1]['values'], $updates[3]['values']);
			$this->assertSame('[image]{NUMBER}[/image]', $updates[0]['values']['bbcode_match']);
			$this->assertSame('[album]{NUMBER}[/album]', $updates[1]['values']['bbcode_match']);
			$this->assertArrayNotHasKey('bbcode_id', $updates[0]['values']);
			$this->assertArrayNotHasKey('bbcode_id', $updates[1]['values']);
			$this->assertSame(2, $this->query_count($queries, 'WHERE bbcode_id = 31'));
			$this->assertSame(2, $this->query_count($queries, 'WHERE bbcode_id = 47'));
			$this->assertSame(0, $this->query_count($queries, 'INSERT INTO'));
			$this->assertSame(0, $this->query_count($queries, 'MAX(bbcode_id)'));
			$this->assertStringNotContainsString('sid=', serialize($updates));
		}

		public function test_unrelated_image_and_album_bbcodes_fail_with_a_localised_conflict(): void
		{
			$gallery_image = [
				'bbcode_id'           => 31,
				'bbcode_match'        => '[image]{NUMBER}[/image]',
				'bbcode_helpline'     => 'GALLERY_HELPLINE_ALBUM',
				'second_pass_replace' => '/gallery/image/${1}/mini',
			];
			$conflicts = [
				'image' => [
					'image' => [[
						'bbcode_id'           => 77,
						'bbcode_match'        => '[image]{NUMBER}[/image]',
						'bbcode_helpline'     => 'Custom linked image BBCode',
						'second_pass_replace' => '/custom/image/${1}',
					]],
					'album' => [],
					'max'   => [],
				],
				'album' => [
					'image' => [$gallery_image],
					'album' => [[
						'bbcode_id'           => 88,
						'bbcode_match'        => '[album={TEXT}]{TEXT}[/album]',
						'bbcode_helpline'     => 'Custom music album BBCode',
						'second_pass_replace' => '/music/${1}',
					]],
					'max'   => [],
				],
			];

			foreach ($conflicts as $tag => $row_queues)
			{
				$built_arrays = [];
				$queries = [];
				$db = $this->database($row_queues, $built_arrays, $queries);
				$migration = $this->migration($db, [
					'enable_mod_rewrite'           => 1,
					'phpbb_gallery_link_thumbnail' => 'none',
				]);

				try
				{
					$migration->ensure_gallery_bbcodes();
					$this->fail('The unrelated [' . $tag . '] BBCode must stop the migration.');
				}
				catch (migration_exception $exception)
				{
					$this->assertSame('GALLERY_BBCODE_CONFLICT', $exception->getMessage());
					$this->assertSame(['[' . $tag . ']'], $exception->getParameters());
				}

				$conflicting_id = $tag === 'image' ? 77 : 88;
				$this->assertSame([], $built_arrays, 'Preflight must finish before writing [' . $tag . '].');
				$this->assertSame(0, $this->query_count($queries, 'WHERE bbcode_id = ' . $conflicting_id));
				$this->assertSame(0, $this->query_count($queries, 'INSERT INTO'));
			}
		}

		private function migration(driver_interface $db, array $values): gallery_bbcodes
		{
			$reflection = new \ReflectionClass(gallery_bbcodes::class);
			$migration = $reflection->newInstanceWithoutConstructor();
			$this->set_migration_property($migration, 'db', $db);
			$this->set_migration_property($migration, 'config', new config($values));
			$this->set_migration_property($migration, 'table_prefix', 'phpbb_');

			return $migration;
		}

		private function database(array &$row_queues, array &$built_arrays, array &$queries): driver_interface
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
				function (string $result) use (&$row_queues): array|false
				{
					if (str_contains($result, 'LOWER(bbcode_tag) = \'image\''))
					{
						return array_shift($row_queues['image']);
					}
					if (str_contains($result, 'LOWER(bbcode_tag) = \'album\''))
					{
						return array_shift($row_queues['album']);
					}
					if (str_contains($result, 'MAX(bbcode_id)'))
					{
						return array_shift($row_queues['max']);
					}

					$this->fail('Unexpected BBCode migration result: ' . $result);
					return false;
				}
			);
			$db->method('sql_build_array')->willReturnCallback(
				static function (string $operation, array $values) use (&$built_arrays): string
				{
					$built_arrays[] = [
						'operation' => $operation,
						'values'    => $values,
					];

					return 'BUILT_' . count($built_arrays);
				}
			);

			return $db;
		}

		private function set_migration_property(gallery_bbcodes $migration, string $property, mixed $value): void
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

		private function load_migration(): void
		{
			if (!defined('NUM_CORE_BBCODES'))
			{
				define('NUM_CORE_BBCODES', 12);
			}
			if (!defined('BBCODE_LIMIT'))
			{
				define('BBCODE_LIMIT', 1511);
			}

			$phpbb_root = dirname(__DIR__, 4);
			require_once $phpbb_root . '/phpbb/db/migration/migration_interface.php';
			require_once $phpbb_root . '/phpbb/db/migration/migration.php';
			require_once $phpbb_root . '/phpbb/db/migration/exception.php';
			require_once dirname(__DIR__) . '/migrations/forum_index_images.php';
			require_once dirname(__DIR__) . '/migrations/gallery_bbcodes.php';
		}
	}
}
