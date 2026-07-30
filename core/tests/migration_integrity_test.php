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
use phpbbgallery\core\migrations\performance_indexes;
use phpbbgallery\core\migrations\protect_personal_album_profile_field;
use phpbbgallery\core\migrations\split_ucp_module_settings;
use phpbbgallery\core\migrations\total_views;
use phpbbgallery\core\migrations\gallery_title;
use phpbbgallery\core\migrations\own_image_move;
use phpbbgallery\core\migrations\create_gallery_icons_folder;
use phpbbgallery\core\migrations\disp_resolution;
use phpbbgallery\core\migrations\forum_index_images;
use phpbbgallery\core\migrations\gallery_bbcodes;
use phpbbgallery\core\migrations\viewtopic_profiles;
use phpbbgallery\core\migrations\ajax_image_navigation;

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
		performance_indexes::class,
		protect_personal_album_profile_field::class,
		total_views::class,
		gallery_title::class,
		own_image_move::class,
		create_gallery_icons_folder::class,
		disp_resolution::class,
		forum_index_images::class,
		gallery_bbcodes::class,
		viewtopic_profiles::class,
		ajax_image_navigation::class,
	];

	private array $temp_directories = [];

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
		$this->assertSame(
			['\phpbbgallery\core\migrations\resumable_uploads'],
			performance_indexes::depends_on()
		);
		$this->assertSame(
			['\phpbbgallery\core\migrations\performance_indexes'],
			protect_personal_album_profile_field::depends_on()
		);
		$this->assertSame(
			['\phpbbgallery\core\migrations\protect_personal_album_profile_field'],
			total_views::depends_on()
		);
		$this->assertSame(
			['\phpbbgallery\core\migrations\total_views'],
			gallery_title::depends_on()
		);
		$this->assertSame(
			['\phpbbgallery\core\migrations\gallery_title'],
			own_image_move::depends_on()
		);
		$this->assertSame(
			['\phpbbgallery\core\migrations\own_image_move'],
			create_gallery_icons_folder::depends_on()
		);
		$this->assertSame(
			['\phpbbgallery\core\migrations\create_gallery_icons_folder'],
			disp_resolution::depends_on()
		);
		$this->assertSame(
			['\phpbbgallery\core\migrations\disp_resolution'],
			forum_index_images::depends_on()
		);
		$this->assertSame(
			['\phpbbgallery\core\migrations\forum_index_images'],
			gallery_bbcodes::depends_on()
		);
		$this->assertSame(
			['\phpbbgallery\core\migrations\gallery_bbcodes'],
			viewtopic_profiles::depends_on()
		);
		$this->assertSame(
			['\phpbbgallery\core\migrations\viewtopic_profiles'],
			ajax_image_navigation::depends_on()
		);
	}

	public function test_ajax_image_navigation_migration_is_reversible_and_disabled_by_default(): void
	{
		$migration = (new \ReflectionClass(ajax_image_navigation::class))->newInstanceWithoutConstructor();

		$this->assertSame([
			['config.add', ['phpbb_gallery_ajax_navigation', 0]],
		], $migration->update_data());
		$this->assertSame([
			['config.remove', ['phpbb_gallery_ajax_navigation']],
		], $migration->revert_data());
		$this->assertStringContainsString("'ajax_navigation'", (string) file_get_contents(dirname(__DIR__) . '/config.php'));
	}

	public function test_viewtopic_profile_migration_restores_reversible_switches(): void
	{
		$migration = (new \ReflectionClass(viewtopic_profiles::class))->newInstanceWithoutConstructor();

		$this->assertSame([
			['config.add', ['phpbb_gallery_viewtopic_icon', 1]],
			['config.add', ['phpbb_gallery_viewtopic_images', 1]],
			['config.add', ['phpbb_gallery_viewtopic_link', 0]],
		], $migration->update_data());
		$this->assertSame([
			['config.remove', ['phpbb_gallery_viewtopic_icon']],
			['config.remove', ['phpbb_gallery_viewtopic_images']],
			['config.remove', ['phpbb_gallery_viewtopic_link']],
		], $migration->revert_data());
	}

	public function test_forum_index_images_migration_is_reversible_and_disabled_by_default(): void
	{
		$migration = (new \ReflectionClass(forum_index_images::class))->newInstanceWithoutConstructor();

		$this->assertSame([
			['config.add', ['phpbb_gallery_forum_index_display', 45]],
			['config.add', ['phpbb_gallery_forum_index_mode', 0]],
			['config.add', ['phpbb_gallery_forum_index_personal', 0]],
			['config.add', ['phpbb_gallery_forum_index_random_count', 4]],
			['config.add', ['phpbb_gallery_forum_index_recent_count', 4]],
		], $migration->update_data());
		$this->assertSame([
			['config.remove', ['phpbb_gallery_forum_index_display']],
			['config.remove', ['phpbb_gallery_forum_index_mode']],
			['config.remove', ['phpbb_gallery_forum_index_personal']],
			['config.remove', ['phpbb_gallery_forum_index_random_count']],
			['config.remove', ['phpbb_gallery_forum_index_recent_count']],
		], $migration->revert_data());
	}

	public function test_resolution_migration_adds_a_reversible_display_switch(): void
	{
		$migration = (new \ReflectionClass(disp_resolution::class))->newInstanceWithoutConstructor();

		// Shown by default, so an upgraded board gains the row without being configured.
		$this->assertSame([
			['config.add', ['phpbb_gallery_disp_resolution', 1]],
		], $migration->update_data());
		$this->assertSame([
			['config.remove', ['phpbb_gallery_disp_resolution']],
		], $migration->revert_data());
	}

	public function test_resolution_default_exists_in_the_core_config_fallback(): void
	{
		// gallery config falls back to this array when the row is absent, so a
		// missing entry would surface as an undefined-key warning.
		$source = (string) file_get_contents(dirname(__DIR__) . '/config.php');

		$this->assertStringContainsString("'disp_resolution'", $source);
	}

	public function test_own_image_move_migration_adds_permission_and_invalidates_cached_bits(): void
	{
		$migration = (new \ReflectionClass(own_image_move::class))->newInstanceWithoutConstructor();
		(new \ReflectionProperty(\phpbb\db\migration\migration::class, 'table_prefix'))->setValue($migration, 'phpbb_');

		$this->assertSame([
			'add_columns' => [
				'phpbb_gallery_roles' => [
					'i_move' => ['UINT:3', 0],
				],
			],
		], $migration->update_schema());
		$this->assertSame([
			'drop_columns' => [
				'phpbb_gallery_roles' => ['i_move'],
			],
		], $migration->revert_schema());

		$db = $this->createMock(\phpbb\db\driver\driver_interface::class);
		$db->expects($this->once())
			->method('sql_query')
			->with("UPDATE phpbb_gallery_users\n\t\t\tSET user_permissions = ''");
		(new \ReflectionProperty(\phpbb\db\migration\migration::class, 'db'))->setValue($migration, $db);

		$this->assertTrue($migration->clear_gallery_permission_cache());
		$this->assertSame([
			['custom', [[$migration, 'clear_gallery_permission_cache']]],
		], $migration->update_data());
		$this->assertSame($migration->update_data(), $migration->revert_data());
	}

	public function test_gallery_title_migration_adds_an_optional_configuration_value(): void
	{
		$migration = (new \ReflectionClass(gallery_title::class))->newInstanceWithoutConstructor();

		$this->assertSame([
			['config.add', ['phpbb_gallery_title', '']],
		], $migration->update_data());
		$this->assertSame([
			['config.remove', ['phpbb_gallery_title']],
		], $migration->revert_data());
	}

	public function test_total_views_migration_initializes_a_dynamic_counter(): void
	{
		global $config;

		$db = $this->createMock(\phpbb\db\driver\driver_interface::class);
		$db->expects($this->once())
			->method('sql_query')
			->with($this->stringContains('SUM(image_view_count) AS total_views'))
			->willReturn(1);
		$db->expects($this->once())
			->method('sql_fetchfield')
			->with('total_views')
			->willReturn('42');
		$db->expects($this->once())->method('sql_freeresult')->with(1);

		$config = $this->getMockBuilder(\phpbb\config\config::class)
			->setConstructorArgs([[]])
			->onlyMethods(['set'])
			->getMock();
		$config->expects($this->once())
			->method('set')
			->with('phpbb_gallery_num_views', 42, false);

		$reflection = new \ReflectionClass(total_views::class);
		$migration = $reflection->newInstanceWithoutConstructor();
		(new \ReflectionProperty(\phpbb\db\migration\migration::class, 'db'))->setValue($migration, $db);
		(new \ReflectionProperty(\phpbb\db\migration\migration::class, 'table_prefix'))->setValue($migration, 'phpbb_');

		$this->assertSame([
			['config.add', ['phpbb_gallery_num_views', 0, true]],
			['custom', [[$migration, 'resync_total_views']]],
		], $migration->update_data());
		$this->assertTrue($migration->resync_total_views());
		$this->assertSame([
			['config.remove', ['phpbb_gallery_num_views']],
		], $migration->revert_data());
	}

	public function test_personal_album_profile_field_is_not_user_editable(): void
	{
		$legacy_migration = (string) file_get_contents(dirname(__DIR__) . '/migrations/release_3_2_1_0.php');
		$new_migration = (string) file_get_contents(dirname(__DIR__) . '/migrations/protect_personal_album_profile_field.php');

		$this->assertStringContainsString("'field_show_profile'\t=> 0", $legacy_migration);
		$this->assertStringContainsString('SET field_show_profile = 0', $new_migration);
		$this->assertStringContainsString("sql_escape('gallery_palbum')", $new_migration);

		foreach (['all', 'BBOOTS', 'FLATBOOTS'] as $style)
		{
			$template = (string) file_get_contents(dirname(__DIR__) . '/styles/' . $style . '/template/event/overall_footer_after.html');
			$this->assertStringNotContainsString("prop('disabled', true)", $template, $style);
		}
	}

	public function test_core_migration_only_creates_core_administrator_permissions(): void
	{
		$migration = (new \ReflectionClass(release_1_2_0::class))->newInstanceWithoutConstructor();
		$permissions = array_values(array_filter($migration->update_data(), static function (array $step): bool
		{
			return $step[0] === 'permission.add';
		}));

		$this->assertSame([
			['permission.add', ['a_gallery_manage', true, 'a_board']],
			['permission.add', ['a_gallery_albums', true, 'a_board']],
		], $permissions);
	}

	public function test_core_migration_does_not_register_addon_ucp_modules(): void
	{
		$migration = (new \ReflectionClass(release_1_2_0::class))->newInstanceWithoutConstructor();
		$steps = var_export($migration->update_data(), true);

		$this->assertStringNotContainsString('UCP_GALLERY_FAVORITES', $steps);
		$this->assertStringNotContainsString('manage_favorites', $steps);
	}

	public function test_profile_contact_url_update_uses_dbal_escaping(): void
	{
		$source = (string) file_get_contents(dirname(__DIR__) . '/migrations/release_3_2_1_0.php');

		$this->assertStringContainsString('sql_build_array(\'UPDATE\', $sql_ary)', $source);
		$this->assertStringContainsString('sql_escape(\'gallery_palbum\')', $source);
	}

	public function test_migration_owned_contracts_are_typed_with_profilefield_exceptions(): void
	{
		$profilefield_properties = ['profilefield_name', 'profilefield_database_type', 'profilefield_data'];

		foreach (self::MIGRATIONS as $class_name)
		{
			$reflection = new \ReflectionClass($class_name);
			foreach ($reflection->getMethods() as $method)
			{
				if ($method->getDeclaringClass()->getName() !== $class_name)
				{
					continue;
				}

				foreach ($method->getParameters() as $parameter)
				{
					$this->assertNotNull($parameter->getType(), $class_name . '::' . $method->getName() . '($' . $parameter->getName() . ')');
				}

				$this->assertNotNull($method->getReturnType(), $class_name . '::' . $method->getName() . '()');
			}

			foreach ($reflection->getProperties() as $property)
			{
				if ($property->getDeclaringClass()->getName() !== $class_name)
				{
					continue;
				}

				if ($class_name === release_3_2_1_0::class && in_array($property->getName(), $profilefield_properties, true))
				{
					$this->assertNull($property->getType(), $class_name . '::$' . $property->getName() . ' must match phpBB\'s untyped parent property.');
					continue;
				}

				$this->assertNotNull($property->getType(), $class_name . '::$' . $property->getName());
			}
		}
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

	public function test_create_gallery_icons_folder_creates_a_web_accessible_directory(): void
	{
		$root = $this->create_temp_directory();
		mkdir($root . '/images', 0755, true);

		$migration = (new \ReflectionClass(create_gallery_icons_folder::class))->newInstanceWithoutConstructor();
		global $phpbb_root_path;
		$previous_root = isset($phpbb_root_path) ? $phpbb_root_path : null;
		$phpbb_root_path = $root . DIRECTORY_SEPARATOR;
		try
		{
			$migration->create_icons_folder();
		}
		finally
		{
			$phpbb_root_path = $previous_root;
		}

		$this->assertDirectoryExists($root . '/images/galleryicons');
		$this->assertFileExists($root . '/images/galleryicons/index.htm');
		// Unlike files/phpbbgallery/core, icons have to be reachable over HTTP.
		$this->assertFileDoesNotExist($root . '/images/galleryicons/.htaccess');
	}

	public function test_create_gallery_icons_folder_is_skipped_when_images_is_not_writable(): void
	{
		$root = $this->create_temp_directory();

		$migration = (new \ReflectionClass(create_gallery_icons_folder::class))->newInstanceWithoutConstructor();
		global $phpbb_root_path;
		$previous_root = isset($phpbb_root_path) ? $phpbb_root_path : null;
		$phpbb_root_path = $root . DIRECTORY_SEPARATOR;
		try
		{
			$migration->create_icons_folder();
		}
		finally
		{
			$phpbb_root_path = $previous_root;
		}

		$this->assertDirectoryDoesNotExist($root . '/images/galleryicons');
	}

	public function test_create_gallery_icons_folder_purge_archives_instead_of_deleting_icons(): void
	{
		$root = $this->create_temp_directory();
		mkdir($root . '/images/galleryicons', 0755, true);
		file_put_contents($root . '/images/galleryicons/bluray.svg', '<svg xmlns="http://www.w3.org/2000/svg"></svg>');

		$migration = (new \ReflectionClass(create_gallery_icons_folder::class))->newInstanceWithoutConstructor();
		global $phpbb_root_path;
		$previous_root = isset($phpbb_root_path) ? $phpbb_root_path : null;
		$phpbb_root_path = $root . DIRECTORY_SEPARATOR;
		try
		{
			$this->assertTrue($migration->archive_icons_folder());
		}
		finally
		{
			$phpbb_root_path = $previous_root;
		}

		$this->assertDirectoryDoesNotExist($root . '/images/galleryicons');
		$backups = glob($root . '/images/galleryicons_backup_*', GLOB_ONLYDIR);
		$this->assertCount(1, $backups);
		$this->assertSame('<svg xmlns="http://www.w3.org/2000/svg"></svg>', file_get_contents($backups[0] . '/bluray.svg'));
	}

	public function test_create_gallery_icons_folder_purge_is_idempotent_when_no_folder_exists(): void
	{
		$root = $this->create_temp_directory();
		mkdir($root . '/images', 0755, true);

		$migration = (new \ReflectionClass(create_gallery_icons_folder::class))->newInstanceWithoutConstructor();
		global $phpbb_root_path;
		$previous_root = isset($phpbb_root_path) ? $phpbb_root_path : null;
		$phpbb_root_path = $root . DIRECTORY_SEPARATOR;
		try
		{
			$this->assertTrue($migration->archive_icons_folder());
		}
		finally
		{
			$phpbb_root_path = $previous_root;
		}

		$this->assertSame([], glob($root . '/images/galleryicons_backup_*', GLOB_ONLYDIR));
	}

	public function test_create_gallery_icons_folder_revert_uses_the_archive_callback_without_recursive_deletion(): void
	{
		$migration = (new \ReflectionClass(create_gallery_icons_folder::class))->newInstanceWithoutConstructor();
		$this->assertSame(
			[['custom', [[$migration, 'archive_icons_folder']]]],
			$migration->revert_data()
		);
		$this->assertSame(
			[['custom', [[$migration, 'create_icons_folder']]]],
			$migration->update_data()
		);

		$source = file_get_contents(dirname(__DIR__) . '/migrations/create_gallery_icons_folder.php');
		$this->assertStringContainsString('is_link($icons_folder)', $source);
		$this->assertStringContainsString('@rename($source, $backup)', $source);
		$this->assertStringNotContainsString('recursiveRemoveDirectory', $source);
		$this->assertStringNotContainsString('unlink(', $source);
		$this->assertStringNotContainsString('rmdir(', $source);
	}

	/**
	 * @return array
	 */
	private function migration_graph(): array
	{
		$known = array_fill_keys(self::MIGRATIONS, true);
		$graph = [];
		foreach (self::MIGRATIONS as $migration)
		{
			$dependencies = array_map(function (string $dependency): string
			{
				return ltrim($dependency, '\\');
			}, $migration::depends_on());
			$graph[$migration] = array_values(array_intersect($dependencies, array_keys($known)));
		}

		return $graph;
	}

	private function depends_on(string $migration, string $target, array $graph): bool
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

	private function remove_temp_directory(string $directory): void
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
			'performance_indexes.php',
			'protect_personal_album_profile_field.php',
			'total_views.php',
			'gallery_title.php',
			'own_image_move.php',
			'create_gallery_icons_folder.php',
			'disp_resolution.php',
			'forum_index_images.php',
			'gallery_bbcodes.php',
			'viewtopic_profiles.php',
			'ajax_image_navigation.php',
		] as $migration)
		{
			require_once dirname(__DIR__) . '/migrations/' . $migration;
		}
	}
}
