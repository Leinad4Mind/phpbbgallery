<?php
/**
 * phpBB Gallery - Core Extension tests
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\tests;

use PHPUnit\Framework\TestCase;
use phpbbgallery\core\migrations\release_1_2_0;
use phpbbgallery\core\migrations\release_1_2_0_add_bbcode;
use phpbbgallery\core\migrations\release_1_2_0_create_filesystem;
use phpbbgallery\core\migrations\release_1_2_0_db_create;
use phpbbgallery\core\migrations\release_3_2_1_0;
use phpbbgallery\core\migrations\release_3_2_1_1;
use phpbbgallery\core\migrations\release_3_3_0;
use phpbbgallery\core\migrations\release_3_4_0;
use phpbbgallery\core\migrations\resumable_uploads;
use phpbbgallery\core\migrations\split_ucp_module_settings;

class migration_integrity_test extends TestCase
{
	private const MIGRATIONS = [
		release_1_2_0::class,
		release_1_2_0_db_create::class,
		release_1_2_0_add_bbcode::class,
		release_1_2_0_create_filesystem::class,
		split_ucp_module_settings::class,
		release_3_2_1_0::class,
		release_3_2_1_1::class,
		release_3_3_0::class,
		release_3_4_0::class,
		resumable_uploads::class,
	];

	/** @var array */
	private $temp_directories = [];

	// phpcs:ignore PhpbbCodingStandard.NamingConventions.LowercaseUnderscoredFunctions.NotAllowed -- PHPUnit lifecycle API.
	protected function setUp(): void
	{
		$this->load_migrations();
	}

	// phpcs:ignore PhpbbCodingStandard.NamingConventions.LowercaseUnderscoredFunctions.NotAllowed -- PHPUnit lifecycle API.
	protected function tearDown(): void
	{
		foreach ($this->temp_directories as $directory)
		{
			$this->remove_temp_directory($directory);
		}
	}

	public function test_migration_branches_are_serialized_after_table_creation(): void
	{
		$this->assertSame(
			['\phpbbgallery\core\migrations\release_1_2_0_db_create'],
			release_1_2_0_add_bbcode::depends_on()
		);
		$this->assertSame(
			['\phpbbgallery\core\migrations\release_1_2_0_add_bbcode'],
			release_1_2_0_create_filesystem::depends_on()
		);
		$this->assertSame(
			['\phpbbgallery\core\migrations\release_1_2_0_create_filesystem'],
			split_ucp_module_settings::depends_on()
		);
		$this->assertSame(
			['\phpbbgallery\core\migrations\split_ucp_module_settings'],
			release_3_2_1_0::depends_on()
		);
		$this->assertSame(
			['\phpbbgallery\core\migrations\release_3_2_1_0'],
			release_3_2_1_1::depends_on()
		);
	}

	public function test_every_later_migration_depends_transitively_on_table_creation(): void
	{
		$graph = $this->migration_graph();
		foreach (array_slice(self::MIGRATIONS, 1) as $migration)
		{
			$this->assertTrue(
				$this->depends_on($migration, release_1_2_0_db_create::class, $graph),
				$migration
			);
		}
	}

	public function test_migration_graph_has_no_cycles(): void
	{
		$remaining = $this->migration_graph();
		while (!empty($remaining))
		{
			$removed = false;
			foreach ($remaining as $migration => $dependencies)
			{
				if (empty(array_intersect($dependencies, array_keys($remaining))))
				{
					unset($remaining[$migration]);
					$removed = true;
				}
			}

			$this->assertTrue($removed, 'Migration dependency cycle detected.');
		}

		$this->assertSame([], $remaining);
	}

	public function test_purge_archives_gallery_files_instead_of_deleting_them(): void
	{
		$root = $this->create_gallery_tree();
		$source_file = $root . '/files/phpbbgallery/core/source/uploaded.jpg';
		$mini_file = $root . '/files/phpbbgallery/core/mini/uploaded.jpg';
		file_put_contents($source_file, 'original');
		file_put_contents($mini_file, 'thumbnail');

		$migration = (new \ReflectionClass(release_1_2_0_create_filesystem::class))->newInstanceWithoutConstructor();
		global $phpbb_root_path;
		$previous_root = isset($phpbb_root_path) ? $phpbb_root_path : null;
		$phpbb_root_path = $root . DIRECTORY_SEPARATOR;
		try
		{
			$this->assertTrue($migration->archive_file_system());
		}
		finally
		{
			$phpbb_root_path = $previous_root;
		}

		$this->assertDirectoryDoesNotExist($root . '/files/phpbbgallery/core');
		$backups = glob($root . '/files/phpbbgallery/core_backup_*', GLOB_ONLYDIR);
		$this->assertCount(1, $backups);
		$this->assertSame('original', file_get_contents($backups[0] . '/source/uploaded.jpg'));
		$this->assertSame('thumbnail', file_get_contents($backups[0] . '/mini/uploaded.jpg'));
	}

	public function test_purge_archive_is_idempotent_when_no_live_tree_exists(): void
	{
		$root = $this->create_temp_directory();
		mkdir($root . '/files', 0755, true);

		$migration = (new \ReflectionClass(release_1_2_0_create_filesystem::class))->newInstanceWithoutConstructor();
		global $phpbb_root_path;
		$previous_root = isset($phpbb_root_path) ? $phpbb_root_path : null;
		$phpbb_root_path = $root . DIRECTORY_SEPARATOR;
		try
		{
			$this->assertTrue($migration->archive_file_system());
		}
		finally
		{
			$phpbb_root_path = $previous_root;
		}

		$this->assertSame([], glob($root . '/files/phpbbgallery/core_backup_*', GLOB_ONLYDIR));
	}

	public function test_filesystem_revert_uses_the_archive_callback_without_recursive_deletion(): void
	{
		$migration = (new \ReflectionClass(release_1_2_0_create_filesystem::class))->newInstanceWithoutConstructor();
		$this->assertSame(
			[['custom', [[$migration, 'archive_file_system']]]],
			$migration->revert_data()
		);

		$source = file_get_contents(dirname(__DIR__) . '/migrations/release_1_2_0_create_filesystem.php');
		$this->assertStringContainsString('is_link($gallery_root)', $source);
		$this->assertStringContainsString('@rename($source, $backup)', $source);
		$this->assertStringNotContainsString('recursiveRemoveDirectory', $source);
		$this->assertStringNotContainsString('unlink(', $source);
		$this->assertStringNotContainsString('rmdir(', $source);
	}

	/**
	 * @return array
	 */
	private function migration_graph()
	{
		$known = array_fill_keys(self::MIGRATIONS, true);
		$graph = [];
		foreach (self::MIGRATIONS as $migration)
		{
			$dependencies = array_map(function ($dependency)
			{
				return ltrim($dependency, '\\');
			}, $migration::depends_on());
			$graph[$migration] = array_values(array_intersect($dependencies, array_keys($known)));
		}

		return $graph;
	}

	private function depends_on($migration, $target, array $graph): bool
	{
		if ($migration === $target)
		{
			return true;
		}

		foreach ($graph[$migration] as $dependency)
		{
			if ($this->depends_on($dependency, $target, $graph))
			{
				return true;
			}
		}

		return false;
	}

	private function create_gallery_tree(): string
	{
		$root = $this->create_temp_directory();
		mkdir($root . '/files/phpbbgallery/core/source', 0755, true);
		mkdir($root . '/files/phpbbgallery/core/medium', 0755, true);
		mkdir($root . '/files/phpbbgallery/core/mini', 0755, true);

		return $root;
	}

	private function create_temp_directory(): string
	{
		$directory = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'phpbbgallery_migration_' . bin2hex(random_bytes(8));
		if (!mkdir($directory, 0755))
		{
			throw new \RuntimeException('Unable to create migration test directory.');
		}
		$this->temp_directories[] = $directory;

		return $directory;
	}

	private function remove_temp_directory($directory): void
	{
		$real_directory = realpath($directory);
		$temp_root = realpath(sys_get_temp_dir());
		if ($real_directory === false)
		{
			return;
		}
		if ($temp_root === false || strpos($real_directory, $temp_root . DIRECTORY_SEPARATOR) !== 0)
		{
			throw new \RuntimeException('Refusing to remove an unexpected migration test directory.');
		}

		$iterator = new \RecursiveIteratorIterator(
			new \RecursiveDirectoryIterator($real_directory, \FilesystemIterator::SKIP_DOTS),
			\RecursiveIteratorIterator::CHILD_FIRST
		);
		foreach ($iterator as $entry)
		{
			if ($entry->isLink() || $entry->isFile())
			{
				unlink($entry->getPathname());
			}
			else
			{
				rmdir($entry->getPathname());
			}
		}
		rmdir($real_directory);
	}

	private function load_migrations(): void
	{
		if (class_exists(release_1_2_0_create_filesystem::class))
		{
			return;
		}

		$phpbb_root = dirname(__DIR__, 4);
		require_once $phpbb_root . '/phpbb/db/migration/migration_interface.php';
		require_once $phpbb_root . '/phpbb/db/migration/migration.php';
		require_once __DIR__ . '/stubs/phpbb_profilefield_base_migration.php';

		foreach ([
			'release_1_2_0.php',
			'release_1_2_0_db_create.php',
			'release_1_2_0_add_bbcode.php',
			'release_1_2_0_create_filesystem.php',
			'split_ucp_module_settings.php',
			'release_3_2_1_0.php',
			'release_3_2_1_1.php',
			'release_3_3_0.php',
			'release_3_4_0.php',
			'resumable_uploads.php',
		] as $migration)
		{
			require_once dirname(__DIR__) . '/migrations/' . $migration;
		}
	}
}
