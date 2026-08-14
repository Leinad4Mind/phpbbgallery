<?php
/**
 * phpBB Gallery - storage layout migration tests
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\tests;

use phpbbgallery\core\config;
use phpbbgallery\core\storage\key_generator;
use phpbbgallery\core\storage\layout_migrator;
use phpbbgallery\core\storage\local_provider;
use phpbbgallery\core\storage\provider_interface;
use PHPUnit\Framework\TestCase;

final class storage_layout_migrator_test extends TestCase
{
	private string $temporary_directory;

	// phpcs:ignore PhpbbCodingStandard.NamingConventions.LowercaseUnderscoredFunctions.NotAllowed -- PHPUnit lifecycle API.
	protected function setUp(): void
	{
		parent::setUp();
		$this->temporary_directory = sys_get_temp_dir() . '/phpbbgallery-migration-' . bin2hex(random_bytes(6));
		mkdir($this->temporary_directory);
	}

	// phpcs:ignore PhpbbCodingStandard.NamingConventions.LowercaseUnderscoredFunctions.NotAllowed -- PHPUnit lifecycle API.
	protected function tearDown(): void
	{
		$this->remove_directory($this->temporary_directory);
		parent::tearDown();
	}

	public function test_status_distinguishes_pending_distributed_and_invalid_keys(): void
	{
		[$migrator, $storage] = $this->migrator([
			['image_id' => 1, 'image_filename' => '7127abfe.jpeg'],
			['image_id' => 2, 'image_filename' => '7/71/7127abfe.jpeg'],
			['image_id' => 3, 'image_filename' => 'unexpected/path.jpeg'],
			['image_id' => 4, 'image_filename' => 'abcdef12.jpg'],
		]);
		$this->put($storage, provider_interface::SOURCE, '7127abfe.jpeg', 'source');

		$this->assertSame([
			'total' => 4,
			'distributed' => 1,
			'migratable' => 1,
			'missing_source' => 1,
			'invalid' => 1,
		], $migrator->status());
	}

	public function test_status_becomes_migratable_after_the_source_is_restored(): void
	{
		[$migrator, $storage] = $this->migrator([
			['image_id' => 7, 'image_filename' => 'abcdef12.jpg'],
		]);

		$this->assertSame(1, $migrator->status()['missing_source']);
		$this->put($storage, provider_interface::SOURCE, 'abcdef12.jpg', 'restored');
		$status = $migrator->status();
		$this->assertSame(1, $status['migratable']);
		$this->assertSame(0, $status['missing_source']);
	}

	public function test_migration_verifies_and_moves_every_existing_variant(): void
	{
		$old_key = '7127abfe.jpeg';
		$new_key = '7/71/' . $old_key;
		[$migrator, $storage, $state] = $this->migrator([
			['image_id' => 12, 'image_filename' => $old_key],
		]);
		foreach ([provider_interface::SOURCE, provider_interface::MEDIUM, provider_interface::MINI] as $variant)
		{
			$this->put($storage, $variant, $old_key, $variant . '-plain');
			$this->put($storage, $variant, '7127abfe_wm.jpeg', $variant . '-watermark');
		}

		$result = $migrator->migrate_batch();

		$this->assertSame(1, $result['migrated']);
		$this->assertSame(0, $result['failed']);
		$this->assertStringContainsString($new_key, implode(' ', $state->queries));
		foreach ([provider_interface::SOURCE, provider_interface::MEDIUM, provider_interface::MINI] as $variant)
		{
			$this->assertFalse($storage->exists($variant, $old_key));
			$this->assertFalse($storage->exists($variant, '7127abfe_wm.jpeg'));
			$this->assertSame($variant . '-plain', $this->contents($storage, $variant, $new_key));
			$this->assertSame($variant . '-watermark', $this->contents($storage, $variant, '7/71/7127abfe_wm.jpeg'));
		}
	}

	public function test_missing_source_fails_without_updating_the_database(): void
	{
		[$migrator, $storage, $state] = $this->migrator([
			['image_id' => 7, 'image_filename' => 'abcdef12.jpg'],
		]);

		$result = $migrator->migrate_batch();

		$this->assertSame(1, $result['missing_source']);
		$this->assertSame(0, $result['failed']);
		$this->assertSame([], $state->queries);
		$this->assertFalse($storage->exists(provider_interface::SOURCE, 'a/ab/abcdef12.jpg'));
	}

	public function test_conflicting_destination_is_preserved_and_rejected(): void
	{
		$old_key = 'abcdef12.jpg';
		$new_key = 'a/ab/' . $old_key;
		[$migrator, $storage, $state] = $this->migrator([
			['image_id' => 8, 'image_filename' => $old_key],
		]);
		$this->put($storage, provider_interface::SOURCE, $old_key, 'original');
		$this->put($storage, provider_interface::SOURCE, $new_key, 'different');

		$result = $migrator->migrate_batch();

		$this->assertSame(1, $result['failed']);
		$this->assertSame([], $state->queries);
		$this->assertSame('original', $this->contents($storage, provider_interface::SOURCE, $old_key));
		$this->assertSame('different', $this->contents($storage, provider_interface::SOURCE, $new_key));
	}

	public function test_matching_destination_is_reused_safely(): void
	{
		$old_key = 'abcdef12.jpg';
		$new_key = 'a/ab/' . $old_key;
		[$migrator, $storage] = $this->migrator([
			['image_id' => 9, 'image_filename' => $old_key],
		]);
		$this->put($storage, provider_interface::SOURCE, $old_key, 'identical');
		$this->put($storage, provider_interface::SOURCE, $new_key, 'identical');

		$result = $migrator->migrate_batch();

		$this->assertSame(1, $result['migrated']);
		$this->assertFalse($storage->exists(provider_interface::SOURCE, $old_key));
		$this->assertSame('identical', $this->contents($storage, provider_interface::SOURCE, $new_key));
	}

	public function test_compare_and_swap_failure_rolls_back_new_objects(): void
	{
		$old_key = 'abcdef12.jpg';
		$new_key = 'a/ab/' . $old_key;
		[$migrator, $storage] = $this->migrator([
			['image_id' => 10, 'image_filename' => $old_key],
		], 0);
		$this->put($storage, provider_interface::SOURCE, $old_key, 'source');

		$result = $migrator->migrate_batch();

		$this->assertSame(1, $result['failed']);
		$this->assertTrue($storage->exists(provider_interface::SOURCE, $old_key));
		$this->assertFalse($storage->exists(provider_interface::SOURCE, $new_key));
	}

	public function test_batches_resume_after_the_last_processed_image(): void
	{
		$old_key = 'abcdef12.jpg';
		[$migrator, $storage] = $this->migrator([
			['image_id' => 1, 'image_filename' => '7/71/7127abfe.jpeg'],
			['image_id' => 2, 'image_filename' => $old_key],
		]);
		$this->put($storage, provider_interface::SOURCE, $old_key, 'source');

		$first = $migrator->migrate_batch(0, 1);
		$second = $migrator->migrate_batch($first['last_id'], 1);

		$this->assertSame(1, $first['skipped']);
		$this->assertTrue($first['has_more']);
		$this->assertSame(1, $second['migrated']);
		$this->assertSame(2, $second['last_id']);
	}

	/** @return array{layout_migrator, local_provider, object} */
	private function migrator(array $rows, int $affected_rows = 1): array
	{
		$state = (object) [
			'rows' => $rows,
			'cursors' => [],
			'queries' => [],
			'affected' => $affected_rows,
		];
		$db = $this->createMock(\phpbb\db\driver\driver_interface::class);
		$db->method('sql_query')->willReturnCallback(static function (string $sql) use ($state): string
		{
			if (str_starts_with(ltrim($sql), 'SELECT'))
			{
				$state->cursors['all'] = $state->rows;
				return 'all';
			}

			$state->queries[] = $sql;
			return 'update';
		});
		$db->method('sql_query_limit')->willReturnCallback(static function (string $sql, int $limit) use ($state): string
		{
			preg_match('/image_id > ([0-9]+)/', $sql, $matches);
			$after_id = (int) ($matches[1] ?? 0);
			$state->cursors['batch'] = array_slice(array_values(array_filter(
				$state->rows,
				static fn(array $row): bool => (int) $row['image_id'] > $after_id
			)), 0, $limit);
			return 'batch';
		});
		$db->method('sql_fetchrow')->willReturnCallback(static function (string $result) use ($state): array|false
		{
			$row = array_shift($state->cursors[$result]);

			return $row ?? false;
		});
		$db->method('sql_escape')->willReturnCallback(static fn(string $value): string => addslashes($value));
		$db->method('sql_build_array')->willReturnCallback(static function (string $query, array $values): string
		{
			$quote = chr(39);

			return 'image_filename = ' . $quote . addslashes($values['image_filename']) . $quote;
		});
		$db->method('sql_in_set')->willReturnCallback(static function (string $field, mixed $value): string
		{
			$quote = chr(39);

			return $field . ' = ' . $quote . addslashes((string) $value) . $quote;
		});
		$db->method('sql_affectedrows')->willReturnCallback(static fn(): int => $state->affected);

		$storage = new local_provider(
			$this->temporary_directory . '/source',
			$this->temporary_directory . '/medium',
			$this->temporary_directory . '/mini'
		);
		$keys = new key_generator(new config(new \phpbb\config\config([
			'phpbb_gallery_storage_layout' => key_generator::LAYOUT_DISTRIBUTED,
		])));

		return [new layout_migrator($db, $keys, $storage, 'gallery_images'), $storage, $state];
	}

	private function put(local_provider $storage, string $variant, string $key, string $contents): void
	{
		$input = $this->temporary_directory . '/input-' . bin2hex(random_bytes(5));
		file_put_contents($input, $contents);
		$this->assertTrue($storage->write($variant, $key, $input));
		unlink($input);
	}

	private function contents(local_provider $storage, string $variant, string $key): string
	{
		$stream = $storage->open_stream($variant, $key);
		$this->assertIsResource($stream);
		$contents = stream_get_contents($stream);
		fclose($stream);

		return $contents;
	}

	private function remove_directory(string $directory): void
	{
		if (!is_dir($directory))
		{
			return;
		}

		$iterator = new \RecursiveIteratorIterator(
			new \RecursiveDirectoryIterator($directory, \FilesystemIterator::SKIP_DOTS),
			\RecursiveIteratorIterator::CHILD_FIRST
		);
		foreach ($iterator as $item)
		{
			$item->isDir() ? rmdir($item->getPathname()) : unlink($item->getPathname());
		}
		rmdir($directory);
	}
}
