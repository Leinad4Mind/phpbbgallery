<?php

namespace dmzx\forumicons\tests;

use dmzx\forumicons\migrations\forumicons_1_1_0;
use dmzx\forumicons\migrations\forumicons_install;
use phpbb\config\config;
use phpbb\db\driver\driver_interface;
use phpbb\db\tools\tools_interface;
use PHPUnit\Framework\TestCase;

class migration_test extends TestCase
{
	/** @var string */
	private $root;

	// phpcs:ignore PhpbbCodingStandard.NamingConventions.LowercaseUnderscoredFunctions.NotAllowed -- Required PHPUnit API.
	protected function setUp(): void
	{
		$this->root = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'forumicons-migration-' . bin2hex(random_bytes(8)) . DIRECTORY_SEPARATOR;
		mkdir($this->root, 0777, true);
	}

	// phpcs:ignore PhpbbCodingStandard.NamingConventions.LowercaseUnderscoredFunctions.NotAllowed -- Required PHPUnit API.
	protected function tearDown(): void
	{
		$expected_prefix = rtrim(sys_get_temp_dir(), '/\\') . DIRECTORY_SEPARATOR . 'forumicons-migration-';
		if (strpos($this->root, $expected_prefix) !== 0 || !is_dir($this->root))
		{
			return;
		}

		$iterator = new \RecursiveIteratorIterator(
			new \RecursiveDirectoryIterator($this->root, \FilesystemIterator::SKIP_DOTS),
			\RecursiveIteratorIterator::CHILD_FIRST
		);
		foreach ($iterator as $item)
		{
			$item->isDir() ? rmdir($item->getPathname()) : unlink($item->getPathname());
		}
		rmdir($this->root);
	}

	public function test_install_migration_creates_the_icon_directory()
	{
		$migration = $this->migration(forumicons_install::class);
		$migration->create_icon_directory();

		$this->assertDirectoryExists($this->root . 'images/forumicons');
		$this->assertTrue(is_readable($this->root . 'images/forumicons'));
	}

	public function test_upgrade_removes_the_legacy_version_and_rechecks_the_directory()
	{
		$migration = $this->migration(forumicons_1_1_0::class);

		$this->assertSame([
			['config.remove', ['forumicons_version']],
			['custom', [[$migration, 'create_icon_directory']]],
		], $migration->update_data());
	}

	/**
	 * @param string $class_name Migration class
	 * @return forumicons_install
	 */
	private function migration($class_name)
	{
		return new $class_name(
			new config([]),
			$this->createMock(driver_interface::class),
			$this->createMock(tools_interface::class),
			$this->root,
			'php',
			'phpbb_'
		);
	}
}
