<?php

namespace devspace\autodbbackup\tests;

use devspace\autodbbackup\core\backup_registry;
use phpbb\config\db_text;
use phpbb\filesystem\filesystem;
use PHPUnit\Framework\TestCase;

class backup_registry_test extends TestCase
{
	/** @var string */
	private $directory;

	// phpcs:ignore PhpbbCodingStandard.NamingConventions.LowercaseUnderscoredFunctions.NotAllowed
	protected function setUp(): void
	{
		$this->directory = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'autodbbackup_' . bin2hex(random_bytes(8));
		mkdir($this->directory, 0700);
	}

	// phpcs:ignore PhpbbCodingStandard.NamingConventions.LowercaseUnderscoredFunctions.NotAllowed
	protected function tearDown(): void
	{
		foreach (glob($this->directory . DIRECTORY_SEPARATOR . '*') as $file)
		{
			if (is_file($file))
			{
				unlink($file);
			}
		}

		rmdir($this->directory);
	}

	public function test_prune_deletes_only_owned_manifest_entries(): void
	{
		$config_text = new db_text();
		$filesystem = new filesystem();
		$registry = new backup_registry($config_text, $filesystem);
		$location = $this->directory . DIRECTORY_SEPARATOR;
		$first = 'backup_1785580000_0123456789abcdef.sql';
		$second = 'backup_1785580001_1123456789abcdef.sql.gz';
		$third = 'backup_1785580002_2123456789abcdef.sql';
		$untracked = 'backup_1785580003_3123456789abcdef.sql';
		$unrelated = 'customer-export.sql';

		file_put_contents($location . $first, 'first');
		file_put_contents($location . $second, 'second');
		file_put_contents($location . $third, 'third');
		file_put_contents($location . $untracked, 'untracked');
		file_put_contents($location . $unrelated, 'unrelated');

		$registry->record($location, $first, 1);
		$registry->record($location, $second, 2);
		$registry->record($location, $third, 3);
		touch($location . $first, time());

		$this->assertSame(array($first), $registry->prune($location, 2));
		$this->assertFileDoesNotExist($location . $first);
		$this->assertFileExists($location . $second);
		$this->assertFileExists($location . $third);
		$this->assertFileExists($location . $untracked);
		$this->assertFileExists($location . $unrelated);
	}

	public function test_manifest_discards_unsafe_names(): void
	{
		$config_text = new db_text();
		$config_text->values[backup_registry::CONFIG_KEY] = json_encode(array(
			'../customer.sql' => array('created_at' => 99),
			'backup_1785580000_0123456789abcdef.sql' => array('created_at' => 1, 'size' => 10, 'sha256' => 'abc'),
		));
		$registry = new backup_registry($config_text, new filesystem());

		$this->assertSame(array('backup_1785580000_0123456789abcdef.sql'), array_keys($registry->load()));
	}
}
