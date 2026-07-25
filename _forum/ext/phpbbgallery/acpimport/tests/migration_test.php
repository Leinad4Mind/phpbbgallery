<?php
// phpcs:disable Generic.Files.OneClassPerFile.MultipleFound -- Isolated migration stub and test case share this fixture.
/**
 * phpBB Gallery - ACP Import migration tests
 *
 * @package   phpbbgallery/acpimport
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbb\db\migration
{
	if (!class_exists(migration::class))
	{
		abstract class migration
		{
		}
	}
}

namespace phpbbgallery\acpimport\tests
{
	use phpbbgallery\acpimport\migrations\m1_init;
	use PHPUnit\Framework\TestCase;

	require_once dirname(__DIR__) . '/migrations/m1_init.php';

	final class migration_test extends TestCase
	{
		/** @var string[] */
		private array $temporary_directories = [];

		// phpcs:ignore PhpbbCodingStandard.NamingConventions.LowercaseUnderscoredFunctions.NotAllowed -- PHPUnit lifecycle API.
		protected function tearDown(): void
		{
			foreach ($this->temporary_directories as $directory)
			{
				$this->remove_directory($directory);
			}
		}

		public function test_revert_archives_import_files_instead_of_deleting_them(): void
		{
			$root = $this->create_import_tree();
			file_put_contents($root . '/files/phpbbgallery/import/pending.jpg', 'pending image');

			$migration = (new \ReflectionClass(m1_init::class))->newInstanceWithoutConstructor();
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

			$this->assertDirectoryDoesNotExist($root . '/files/phpbbgallery/import');
			$backups = glob($root . '/files/phpbbgallery/import_backup_*', GLOB_ONLYDIR);
			$this->assertCount(1, $backups);
			$this->assertSame('pending image', file_get_contents($backups[0] . '/pending.jpg'));
		}

		public function test_archive_is_idempotent_without_a_live_import_directory(): void
		{
			$root = $this->create_temporary_directory();
			mkdir($root . '/files', 0755, true);

			$migration = (new \ReflectionClass(m1_init::class))->newInstanceWithoutConstructor();
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

			$this->assertSame([], glob($root . '/files/phpbbgallery/import_backup_*', GLOB_ONLYDIR));
		}

		public function test_revert_uses_the_archive_callback_without_recursive_deletion(): void
		{
			$migration = (new \ReflectionClass(m1_init::class))->newInstanceWithoutConstructor();
			$this->assertSame(
				[['custom', [[$migration, 'archive_file_system']]]],
				$migration->revert_data()
			);

			$source = (string) file_get_contents(dirname(__DIR__) . '/migrations/m1_init.php');
			$this->assertStringContainsString('is_link($import_root)', $source);
			$this->assertStringContainsString('@rename($source, $backup)', $source);
			$this->assertStringNotContainsString('recursiveRemoveDirectory', $source);
			$this->assertStringNotContainsString('unlink(', $source);
			$this->assertStringNotContainsString('rmdir(', $source);
		}

		private function create_import_tree(): string
		{
			$root = $this->create_temporary_directory();
			mkdir($root . '/files/phpbbgallery/import', 0755, true);

			return $root;
		}

		private function create_temporary_directory(): string
		{
			$directory = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'phpbbgallery_import_migration_' . bin2hex(random_bytes(8));
			mkdir($directory, 0755, true);
			$this->temporary_directories[] = $directory;

			return $directory;
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
			foreach ($iterator as $file)
			{
				if ($file->isDir())
				{
					rmdir($file->getPathname());
				}
				else
				{
					unlink($file->getPathname());
				}
			}
			rmdir($directory);
		}
	}
}
