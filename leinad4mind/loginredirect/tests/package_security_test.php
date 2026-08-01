<?php

namespace leinad4mind\loginredirect\tests;

use PHPUnit\Framework\TestCase;

class package_security_test extends TestCase
{
	public function test_composer_identity_and_authors()
	{
		$composer = json_decode(file_get_contents($this->root() . '/composer.json'), true);
		$this->assertSame('leinad4mind/loginredirect', $composer['name']);
		$this->assertSame('3.3.0', $composer['version']);
		$this->assertSame('Leinad4Mind', $composer['authors'][0]['name']);
		$this->assertSame('Developer and Maintainer', $composer['authors'][0]['role']);
		$this->assertSame('David Wood', $composer['authors'][1]['name']);
		$this->assertSame('Original Extension Converter', $composer['authors'][1]['role']);
	}

	public function test_version_is_not_stored_in_phpbb_config()
	{
		foreach ($this->php_files() as $file)
		{
			$contents = file_get_contents($file);
			$this->assertStringNotContainsString('config.update', $contents, $file);
			$this->assertDoesNotMatchRegularExpression('/config\\.add[^\\n]+version_loginredirect/', $contents, $file);
		}
	}

	public function test_obsolete_and_donation_assets_are_absent()
	{
		$this->assertFileDoesNotExist($this->root() . '/config/alias.yml');
		$this->assertFileDoesNotExist($this->root() . '/controller/admin_interface.php');
		$this->assertFileDoesNotExist($this->root() . '/controller/main_interface.php');
		$this->assertFileDoesNotExist($this->root() . '/adm/style/donate.html');

		foreach ($this->package_files() as $file)
		{
			if (strpos($file, DIRECTORY_SEPARATOR . 'tests' . DIRECTORY_SEPARATOR) !== false)
			{
				continue;
			}
			$this->assertDoesNotMatchRegularExpression('/paypal|donat(?:e|ion)|qrcode/i', file_get_contents($file), $file);
		}
	}

	public function test_services_and_templates_use_static_new_namespace()
	{
		$services = file_get_contents($this->root() . '/config/services.yml');
		$this->assertStringContainsString('leinad4mind.loginredirect', $services);
		$this->assertStringNotContainsString('david63.loginredirect', $services);

		$template = file_get_contents($this->root() . '/adm/style/login_redirect_manage.html');
		$this->assertStringContainsString('@leinad4mind_loginredirect/', $template);
		$this->assertStringNotContainsString(' ~ ', $template);
	}

	public function test_login_listener_changes_event_redirect_instead_of_exiting()
	{
		$controller = file_get_contents($this->root() . '/controller/main_controller.php');
		$this->assertStringContainsString('$event[\'redirect\'] = $url', $controller);
		$this->assertStringContainsString('$event[\'admin\']', $controller);
		$this->assertDoesNotMatchRegularExpression('/\\bredirect\\s*\\(/', $controller);
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
