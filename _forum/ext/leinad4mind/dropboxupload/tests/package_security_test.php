<?php

namespace leinad4mind\dropboxupload\tests;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Yaml\Yaml;

class package_security_test extends TestCase
{
	public function test_package_identity_and_version_are_composer_only()
	{
		$composer = json_decode(file_get_contents($this->root() . '/composer.json'), true);
		$this->assertSame('leinad4mind/dropboxupload', $composer['name']);
		$this->assertSame('3.3.0', $composer['version']);
		$this->assertContains('Leinad4Mind', array_column($composer['authors'], 'name'));
		$roles = array_column($composer['authors'], 'role', 'name');
		$this->assertSame('Developer and Maintainer', $roles['Leinad4Mind']);
		$this->assertSame('Original Developer', $roles['David Wood']);
		$migrations = implode('', $this->php_files($this->root() . '/migrations'));
		$this->assertStringNotContainsString('dropboxupload_version', $migrations);
		$this->assertStringNotContainsString('config.update', $migrations);
	}

	public function test_old_dependencies_and_donations_are_removed()
	{
		$this->assertDirectoryDoesNotExist($this->root() . '/vendor');
		$this->assertFileDoesNotExist($this->root() . '/composer.lock');
		$source = strtolower(implode('', $this->text_files($this->root())));
		$this->assertStringNotContainsString('paypal', $source);
		$this->assertStringNotContainsString('donat', $source);
	}

	public function test_services_use_transferred_namespace()
	{
		$services = Yaml::parseFile($this->root() . '/config/services.yml');
		$this->assertArrayHasKey('leinad4mind.dropboxupload.listener', $services['services']);
		$this->assertStringNotContainsString('david63.dropboxupload', file_get_contents($this->root() . '/config/services.yml'));
	}

	public function test_template_never_renders_stored_credentials()
	{
		$template = file_get_contents($this->root() . '/adm/style/dropboxupload_manage.html');
		$this->assertStringNotContainsString('DROPBOX_SECRET', $template);
		$this->assertStringNotContainsString('value=\'{{ DROPBOX_ACCESS_TOKEN', $template);
		$this->assertStringNotContainsString('value=\'{{ DROPBOX_APP_SECRET', $template);
		$this->assertStringNotContainsString('value=\'{{ DROPBOX_REFRESH_TOKEN', $template);
		$this->assertStringContainsString('autocomplete=\'new-password\'', $template);
	}

	protected function text_files($directory)
	{
		$contents = array();
		$iterator = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($directory, \FilesystemIterator::SKIP_DOTS));
		foreach ($iterator as $file)
		{
			$path = str_replace(chr(92), '/', $file->getPathname());
			if (strpos($path, '/tests/') !== false || !$file->isFile())
			{
				continue;
			}
			$contents[] = file_get_contents($file->getPathname());
		}
		return $contents;
	}

	protected function root()
	{
		return dirname(__DIR__);
	}

	protected function php_files($directory)
	{
		$contents = array();
		foreach (glob($directory . '/*.php') as $file)
		{
			$contents[] = file_get_contents($file);
		}
		return $contents;
	}
}
