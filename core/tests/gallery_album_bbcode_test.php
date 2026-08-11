<?php
/**
 * phpBB Gallery - Album BBCode migration tests
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\migrations
{
	if (!function_exists(__NAMESPACE__ . '\generate_board_url'))
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
	use phpbbgallery\core\migrations\gallery_album_bbcode;
	use PHPUnit\Framework\TestCase;

	if (!defined('NUM_CORE_BBCODES'))
	{
		define('NUM_CORE_BBCODES', 12);
	}
	if (!defined('BBCODE_LIMIT'))
	{
		define('BBCODE_LIMIT', 1511);
	}

	final class gallery_album_bbcode_test extends TestCase
	{
		// phpcs:ignore PhpbbCodingStandard.NamingConventions.LowercaseUnderscoredFunctions.NotAllowed -- PHPUnit lifecycle API.
		public static function setUpBeforeClass(): void
		{
			parent::setUpBeforeClass();
			$phpbb_root = dirname(__DIR__, 4);
			require_once $phpbb_root . '/phpbb/db/migration/migration_interface.php';
			require_once $phpbb_root . '/phpbb/db/migration/migration.php';
			require_once $phpbb_root . '/phpbb/db/migration/exception.php';
			require_once dirname(__DIR__) . '/migrations/gallery_album_bbcode.php';
		}

		public function test_clean_install_uses_album_and_builds_a_paginated_embed(): void
		{
			$rows = [
				'album' => [false],
				'galleryalbum' => [],
				'max' => [['max_bbcode_id' => NUM_CORE_BBCODES]],
			];
			$built = [];
			$queries = [];
			$migration = $this->migration($this->database($rows, $built, $queries), [
				'enable_mod_rewrite' => 1,
			]);

			$migration->ensure_album_bbcode();

			$this->assertSame('album', $this->configured_tag($migration));
			$this->assertCount(1, $built);
			$this->assertSame('INSERT', $built[0]['operation']);
			$this->assertSame('album', $built[0]['values']['bbcode_tag']);
			$this->assertSame(NUM_CORE_BBCODES + 1, $built[0]['values']['bbcode_id']);
			$this->assertSame('[album]{NUMBER}[/album]', $built[0]['values']['bbcode_match']);
			$this->assertSame('GALLERY_HELPLINE_ALBUM_EMBED', $built[0]['values']['bbcode_helpline']);
			$this->assertSame(1, $built[0]['values']['display_on_posting']);
			$this->assertStringContainsString(
				'https://example.test/forum/gallery/album/{NUMBER}/embed',
				$built[0]['values']['bbcode_tpl']
			);
			$this->assertStringContainsString('phpbbgallery-album-embed', $built[0]['values']['bbcode_tpl']);
			$this->assertStringNotContainsString('sid=', serialize($built));
		}

		public function test_legacy_album_image_alias_is_preserved_and_uses_galleryalbum(): void
		{
			$legacy = [
				'bbcode_id' => 47,
				'bbcode_match' => '[album]{NUMBER}[/album]',
				'bbcode_helpline' => 'GALLERY_HELPLINE_IMAGE_LEGACY',
				'second_pass_replace' => '/gallery/image/1/mini',
			];
			$rows = [
				'album' => [$legacy],
				'galleryalbum' => [false],
				'max' => [['max_bbcode_id' => 47]],
			];
			$built = [];
			$queries = [];
			$migration = $this->migration($this->database($rows, $built, $queries), [
				'enable_mod_rewrite' => 0,
			]);

			$migration->ensure_album_bbcode();

			$this->assertSame('galleryalbum', $this->configured_tag($migration));
			$this->assertCount(1, $built);
			$this->assertSame('galleryalbum', $built[0]['values']['bbcode_tag']);
			$this->assertSame('GALLERY_HELPLINE_GALLERYALBUM', $built[0]['values']['bbcode_helpline']);
			$this->assertStringContainsString(
				'https://example.test/forum/app.php/gallery/album/{NUMBER}/embed',
				$built[0]['values']['bbcode_tpl']
			);
			$this->assertSame(0, $this->query_count($queries, 'WHERE bbcode_id = 47'));
		}

		public function test_existing_gallery_album_embed_is_updated_idempotently(): void
		{
			$existing = [
				'bbcode_id' => 71,
				'bbcode_match' => '[album]{NUMBER}[/album]',
				'second_pass_replace' => '<div class="phpbbgallery-album-embed">/gallery/album/1</div>',
			];
			$rows = [
				'album' => [$existing, $existing],
				'galleryalbum' => [],
				'max' => [],
			];
			$built = [];
			$queries = [];
			$migration = $this->migration($this->database($rows, $built, $queries), [
				'enable_mod_rewrite' => 1,
			]);

			$migration->ensure_album_bbcode();
			$migration->ensure_album_bbcode();

			$this->assertCount(2, $built);
			$this->assertSame('UPDATE', $built[0]['operation']);
			$this->assertSame($built[0]['values'], $built[1]['values']);
			$this->assertSame(2, $this->query_count($queries, 'WHERE bbcode_id = 71'));
			$this->assertSame(0, $this->query_count($queries, 'INSERT INTO'));
			$this->assertSame(0, $this->query_count($queries, 'MAX(bbcode_id)'));
		}

		public function test_conflicting_fallback_is_rejected_without_overwriting_it(): void
		{
			$rows = [
				'album' => [[
					'bbcode_id' => 40,
					'bbcode_match' => '[album]{TEXT}[/album]',
					'second_pass_replace' => '/music/1',
				]],
				'galleryalbum' => [[
					'bbcode_id' => 41,
					'bbcode_match' => '[galleryalbum]{TEXT}[/galleryalbum]',
					'second_pass_replace' => '/custom/1',
				]],
				'max' => [],
			];
			$built = [];
			$queries = [];
			$migration = $this->migration($this->database($rows, $built, $queries), []);

			try
			{
				$migration->ensure_album_bbcode();
				$this->fail('Expected a fail-closed BBCode conflict.');
			}
			catch (migration_exception $exception)
			{
				$this->assertSame('GALLERY_BBCODE_CONFLICT', $exception->getMessage());
			}
			$this->assertSame([], $built);
		}

		/**
		 * @dataProvider exhausted_bbcode_provider
		 */
		public function test_exhausted_capacity_fails_closed(string $expected_tag, array $rows): void
		{
			$built = [];
			$queries = [];
			$migration = $this->migration($this->database($rows, $built, $queries), []);

			try
			{
				$migration->ensure_album_bbcode();
				$this->fail('BBCODE_LIMIT must stop installation of [' . $expected_tag . '].');
			}
			catch (migration_exception $exception)
			{
				$this->assertSame('GALLERY_BBCODE_LIMIT_REACHED', $exception->getMessage());
				$this->assertSame(['[' . $expected_tag . ']'], $exception->getParameters());
			}

			$this->assertSame([], $built);
			$this->assertSame(0, $this->query_count($queries, 'INSERT INTO'));
		}

		public static function exhausted_bbcode_provider(): array
		{
			return [
				'clean album tag' => ['album', [
					'album' => [false],
					'galleryalbum' => [],
					'max' => [['max_bbcode_id' => BBCODE_LIMIT]],
				]],
				'fallback galleryalbum tag' => ['galleryalbum', [
					'album' => [[
						'bbcode_id' => 47,
						'bbcode_match' => '[album]{NUMBER}[/album]',
						'second_pass_replace' => '/gallery/image/1/mini',
					]],
					'galleryalbum' => [false],
					'max' => [['max_bbcode_id' => BBCODE_LIMIT]],
				]],
			];
		}

		public function test_data_steps_and_revert_are_bounded_to_the_managed_definition(): void
		{
			$rows = ['album' => [], 'galleryalbum' => [], 'max' => []];
			$built = [];
			$queries = [];
			$migration = $this->migration($this->database($rows, $built, $queries), [
				'phpbb_gallery_album_bbcode_tag' => 'galleryalbum',
			]);

			$this->assertSame([
				['config.add', ['phpbb_gallery_album_bbcode_tag', 'album']],
				['custom', [[$migration, 'ensure_album_bbcode']]],
				['config.add', ['phpbb_gallery_album_bbcode_ready', 1]],
			], $migration->update_data());
			$this->assertSame([
				['config.remove', ['phpbb_gallery_album_bbcode_ready']],
				['custom', [[$migration, 'remove_album_bbcode']]],
				['config.remove', ['phpbb_gallery_album_bbcode_tag']],
			], $migration->revert_data());

			$migration->remove_album_bbcode();
			$this->assertStringContainsString("LOWER(bbcode_tag) = 'galleryalbum'", $queries[0]);
			$this->assertStringContainsString("bbcode_match = '[galleryalbum]{NUMBER}[/galleryalbum]'", $queries[0]);
			$this->assertStringContainsString("LIKE '%phpbbgallery-album-embed%'", $queries[0]);
		}

		private function migration(driver_interface $db, array $values): gallery_album_bbcode
		{
			$reflection = new \ReflectionClass(gallery_album_bbcode::class);
			$migration = $reflection->newInstanceWithoutConstructor();
			$this->set_migration_property($migration, 'db', $db);
			$this->set_migration_property($migration, 'config', new config($values));
			$this->set_migration_property($migration, 'table_prefix', 'phpbb_');

			return $migration;
		}

		private function database(array &$rows, array &$built, array &$queries): driver_interface
		{
			$db = $this->createMock(driver_interface::class);
			$db->method('sql_escape')->willReturnCallback(static fn(string $value): string => $value);
			$db->method('sql_query')->willReturnCallback(
				static function (string $sql) use (&$queries): string
				{
					$queries[] = $sql;
					return $sql;
				}
			);
			$db->method('sql_fetchrow')->willReturnCallback(
				function (string $result) use (&$rows): array|false
				{
					if (str_contains($result, "LOWER(bbcode_tag) = 'galleryalbum'"))
					{
						return array_shift($rows['galleryalbum']);
					}
					if (str_contains($result, "LOWER(bbcode_tag) = 'album'"))
					{
						return array_shift($rows['album']);
					}
					if (str_contains($result, 'MAX(bbcode_id)'))
					{
						return array_shift($rows['max']);
					}

					$this->fail('Unexpected BBCode migration result: ' . $result);
					return false;
				}
			);
			$db->method('sql_build_array')->willReturnCallback(
				static function (string $operation, array $values) use (&$built): string
				{
					$built[] = ['operation' => $operation, 'values' => $values];
					return 'BUILT_' . count($built);
				}
			);

			return $db;
		}

		private function set_migration_property(gallery_album_bbcode $migration, string $property, mixed $value): void
		{
			$reflection = new \ReflectionProperty(migration::class, $property);
			$reflection->setValue($migration, $value);
		}

		private function configured_tag(gallery_album_bbcode $migration): string
		{
			$reflection = new \ReflectionProperty(migration::class, 'config');
			$config = $reflection->getValue($migration);

			return (string) $config['phpbb_gallery_album_bbcode_tag'];
		}

		private function query_count(array $queries, string $needle): int
		{
			return count(array_filter(
				$queries,
				static fn(string $sql): bool => str_contains($sql, $needle)
			));
		}
	}
}
