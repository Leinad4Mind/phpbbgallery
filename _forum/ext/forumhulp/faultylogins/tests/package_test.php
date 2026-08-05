<?php

namespace forumhulp\faultylogins\tests;

use PHPUnit\Framework\TestCase;

class package_test extends TestCase
{
	protected $root;

	protected function setUp(): void
	{
		$this->root = dirname(__DIR__);
	}

	public function test_metadata_and_runtime_do_not_contain_legacy_password_logging()
	{
		$metadata = json_decode(file_get_contents($this->root . '/composer.json'), true);
		self::assertSame('forumhulp/faultylogins', $metadata['name']);
		self::assertSame('GPL-2.0-only', $metadata['license']);
		self::assertArrayHasKey('ext-sodium', $metadata['require']);
		self::assertArrayNotHasKey('version-check', $metadata['extra']);

		$listener = file_get_contents($this->root . '/event/listener.php');
		self::assertStringNotContainsString('$' . "event['password'],", $listener);
		self::assertStringNotContainsString('LOG_FAULTY_LOGINS', $listener);
		self::assertStringContainsString('encrypt_password', $listener);
	}

	public function test_language_files_are_utf8_without_bom_and_have_matching_keys()
	{
		$expected = null;
		foreach (['en', 'es', 'pt', 'pt_br', 'pt_preao'] as $locale)
		{
			$file = $this->root . '/language/' . $locale . '/info_acp_faultylogins.php';
			$contents = file_get_contents($file);
			self::assertNotSame("\xEF\xBB\xBF", substr($contents, 0, 3), $locale . ' contains a BOM');
			self::assertSame(1, preg_match('//u', $contents), $locale . ' is not valid UTF-8');

			$lang = [];
			include $file;
			$keys = array_keys($lang);
			sort($keys);
			if ($expected === null)
			{
				$expected = $keys;
			}
			self::assertSame($expected, $keys, $locale . ' language keys differ');
		}
	}

	public function test_templates_use_twig_and_escape_sensitive_values()
	{
		$logs = file_get_contents($this->root . '/adm/style/acp_faultylogins_logs.html');
		self::assertStringContainsString('row.PASSWORD|e', $logs);
		self::assertStringContainsString('row.USERNAME|e', $logs);
		self::assertStringNotContainsString('<!-- IF', $logs);
		self::assertStringNotContainsString('{L_', $logs);
	}

	public function test_migration_does_not_store_a_version_config()
	{
		$migration = file_get_contents($this->root . '/migrations/install_faultylogins_3_2_0.php');
		self::assertStringNotContainsString('config.update', $migration);
		self::assertStringNotContainsString('faultylogins_version', $migration);
		self::assertStringContainsString('password_cipher', $migration);
	}
}
