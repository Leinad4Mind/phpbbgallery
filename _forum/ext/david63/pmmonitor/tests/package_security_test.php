<?php

namespace david63\pmmonitor\tests;

use PHPUnit\Framework\TestCase;

class package_security_test extends TestCase
{
	public function test_composer_identity_version_and_authors()
	{
		$composer = json_decode(file_get_contents($this->root() . '/composer.json'), true);
		$this->assertSame('david63/pmmonitor', $composer['name']);
		$this->assertSame('3.3.0', $composer['version']);
		$this->assertSame('Leinad4Mind', $composer['authors'][0]['name']);
		$this->assertSame('Developer and Maintainer', $composer['authors'][0]['role']);
		$this->assertSame('David Wood', $composer['authors'][1]['name']);
		$this->assertSame('Original Developer', $composer['authors'][1]['role']);
	}

	public function test_version_exists_only_in_composer()
	{
		foreach ($this->php_files() as $file)
		{
			$contents = file_get_contents($file);
			$this->assertStringNotContainsString('PM_MONITOR_VERSION', $contents, $file);
			$this->assertStringNotContainsString('version_pmmonitor', $contents, $file);
			$this->assertStringNotContainsString('config.update', $contents, $file);
		}
	}

	public function test_obsolete_and_funding_assets_are_absent()
	{
		$this->assertFileDoesNotExist($this->root() . '/controller/admin_interface.php');
		$this->assertFileDoesNotExist($this->root() . '/differences.md');
		$this->assertFileDoesNotExist($this->root() . '/adm/style/dropdown.js');
		foreach ($this->package_files() as $file)
		{
			if (strpos($file, DIRECTORY_SEPARATOR . 'tests' . DIRECTORY_SEPARATOR) !== false)
			{
				continue;
			}
			$funding_terms = '/pay' . 'pal|don' . 'at(?:e|ion)|qr' . 'code/i';
			$this->assertDoesNotMatchRegularExpression($funding_terms, file_get_contents($file), $file);
		}
	}

	public function test_destructive_flow_has_defence_in_depth()
	{
		$controller = file_get_contents($this->root() . '/controller/admin_controller.php');
		$this->assertStringContainsString('add_form_key(self::FORM_KEY)', $controller);
		$this->assertStringContainsString('check_form_key(self::FORM_KEY)', $controller);
		$this->assertStringContainsString('confirm_box(true)', $controller);
		$this->assertStringContainsString('a_pmmonitor_delete', $controller);
		$this->assertStringContainsString('LOG_PM_MONITOR_VIEW', $controller);
		$this->assertStringContainsString('LOG_PM_MONITOR_MESSAGE_VIEW', $controller);
		$this->assertStringContainsString('LOG_PM_MONITOR_DELETE', $controller);
		$this->assertStringNotContainsString('delete_pm(', $controller);
		$this->assertStringNotContainsString('json_decode(', $controller);
	}

	public function test_template_and_services_use_static_vendor_namespace()
	{
		$template = file_get_contents($this->root() . '/adm/style/pmmonitor.html');
		$this->assertStringContainsString('@david63_pmmonitor/', $template);
		$this->assertStringNotContainsString('onclick=', $template);
		$this->assertStringNotContainsString('pm.PM_TEXT', $template);
		$this->assertDoesNotMatchRegularExpression('/\{[A-Z][A-Z0-9_.]+\}/', $template);
		$this->assertStringContainsString('{{ S_FORM_TOKEN }}', $template);

		$services = file_get_contents($this->root() . '/config/services.yml');
		$this->assertStringContainsString('david63.pmmonitor', $services);
		$this->assertStringNotContainsString('leinad4mind.pmmonitor', $services);
	}

	public function test_current_migration_continues_the_original_vendor_chain()
	{
		$migration = file_get_contents($this->root() . '/migrations/version_3_3_0.php');
		$this->assertStringContainsString('david63\\\\pmmonitor\\\\migrations\\\\version_2_1_0', $migration);
		$this->assertStringContainsString("'a_pmmonitor_view'", $migration);
		$this->assertStringContainsString("'a_pmmonitor_delete'", $migration);
		$this->assertStringNotContainsString('config.update', $migration);
	}

	protected function php_files()
	{
		return array_filter($this->package_files(), function ($file)
		{
			return substr($file, -4) === '.php'
				&& strpos($file, DIRECTORY_SEPARATOR . 'tests' . DIRECTORY_SEPARATOR) === false;
		});
	}

	protected function package_files()
	{
		$files = array();
		$iterator = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($this->root(), \FilesystemIterator::SKIP_DOTS));
		foreach ($iterator as $file)
		{
			if ($file->isFile())
			{
				$files[] = $file->getPathname();
			}
		}
		return $files;
	}

	protected function root()
	{
		return dirname(__DIR__);
	}
}
