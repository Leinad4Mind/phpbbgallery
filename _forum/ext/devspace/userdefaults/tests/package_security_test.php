<?php

namespace devspace\userdefaults\tests;

use PHPUnit\Framework\TestCase;

class package_security_test extends TestCase
{
	public function test_composer_identity_version_and_authors()
	{
		$composer = json_decode(file_get_contents($this->root() . '/composer.json'), true);
		$this->assertSame('devspace/userdefaults', $composer['name']);
		$this->assertSame('3.3.2', $composer['version']);
		$this->assertSame('Leinad4Mind', $composer['authors'][0]['name']);
		$this->assertSame('Developer', $composer['authors'][0]['role']);
		$this->assertSame('devspace', $composer['authors'][1]['name']);
		$this->assertSame('Maintainer', $composer['authors'][1]['role']);
		$this->assertSame('David Wood', $composer['authors'][2]['name']);
		$this->assertSame('Original Developer', $composer['authors'][2]['role']);
		$this->assertArrayNotHasKey('version-check', $composer['extra']);
	}

	public function test_obsolete_and_funding_files_are_absent()
	{
		foreach (array(
			'/adm/style/base.html',
			'/adm/style/js/' . 'don' . 'ate-collapse.js',
			'/adm/style/images/' . 'qr' . 'code.png',
			'/config/alias.yml',
			'/config/ud_constants.yml',
			'/core/functions.php',
		) as $file)
		{
			$this->assertFileDoesNotExist($this->root() . $file);
		}

		$funding_terms = '/pay' . 'pal|don' . 'at(?:e|ion|ivo)|qr' . 'code/i';
		foreach ($this->package_files() as $file)
		{
			if (strpos($file, DIRECTORY_SEPARATOR . 'tests' . DIRECTORY_SEPARATOR) === false)
			{
				$this->assertDoesNotMatchRegularExpression($funding_terms, file_get_contents($file), $file);
			}
		}

		$this->assertFileDoesNotExist($this->root() . '/migrations/version_2_1_0.php');
		$this->assertFileDoesNotExist($this->root() . '/migrations/version_3_2_0.php');
		$this->assertFileExists($this->root() . '/migrations/version_3_3_0.php');
		$this->assertFileExists($this->root() . '/migrations/version_3_3_1.php');
		$this->assertFileExists($this->root() . '/migrations/version_3_3_2.php');
	}

	public function test_form_and_configuration_writes_are_guarded()
	{
		$controller = file_get_contents($this->root() . '/controller/admin_controller.php');
		$this->assertStringContainsString("add_form_key('devspace_userdefaults')", $controller);
		$this->assertStringContainsString("check_form_key('devspace_userdefaults')", $controller);
		$this->assertStringContainsString("'USER_DEFAULTS_LOG'", $controller);
		$this->assertStringContainsString('persist_changed($settings)', $controller);
		$this->assertStringContainsString('normalise_submission(', $controller);
		$this->assertStringContainsString("is_set_post('sync_users')", $controller);
		$this->assertStringNotContainsString("variable('action'", $controller);

		$module = file_get_contents($this->root() . '/acp/userdefaults_module.php');
		$this->assertStringContainsString('set_page_url($this->u_action)', $module);
		$module_info = file_get_contents($this->root() . '/acp/userdefaults_info.php');
		$this->assertStringContainsString('devspace\\\\userdefaults\\\\acp\\\\userdefaults_module', $module_info);
	}

	public function test_conflicting_user_default_extensions_are_blocked()
	{
		$extension = file_get_contents($this->root() . '/ext.php');
		$listener = file_get_contents($this->root() . '/event/listener.php');
		foreach (array('david63/userdefaults', 'forumhulp/userdefault') as $conflict)
		{
			$this->assertStringContainsString($conflict, $extension);
			$this->assertStringContainsString($conflict, $listener);
		}
		$this->assertStringContainsString("- '@ext.manager'", file_get_contents($this->root() . '/config/services.yml'));
	}

	public function test_template_and_services_use_static_vendor_namespace()
	{
		$template = file_get_contents($this->root() . '/adm/style/user_defaults.html');
		$this->assertStringContainsString('@devspace_userdefaults/css/admin_forms.css', $template);
		$this->assertStringContainsString('{{ S_FORM_TOKEN }}', $template);
		$this->assertStringContainsString('{% for option in DATE_FORMAT_OPTIONS %}', $template);
		$this->assertStringContainsString('{% for group in NOTIFICATION_GROUPS %}', $template);
		$this->assertStringContainsString('notification_defaults[{{ type.INDEX }}][{{ method.INDEX }}]', $template);
		$this->assertStringContainsString('userdefaults-sync', $template);
		$this->assertStringContainsString('@devspace_userdefaults/js/userdefaults_sync.js', $template);
		$this->assertStringNotContainsString('{{ USER_DATE_FORMAT }}', $template);
		$this->assertDoesNotMatchRegularExpression('/\{[A-Z][A-Z0-9_.]+\}/', $template);

		$services = file_get_contents($this->root() . '/config/services.yml');
		$this->assertStringContainsString('devspace.userdefaults', $services);
		$this->assertStringNotContainsString('leinad4mind.userdefaults', $services);
		$this->assertStringContainsString("- '@config'", $services);
		$this->assertStringContainsString('public: false', $services);
		$this->assertStringContainsString('devspace.userdefaults.notification_defaults', $services);
		$this->assertStringContainsString('devspace.userdefaults.user_sync', $services);
	}

	public function test_migrations_continue_the_original_vendor_chain()
	{
		$version_3_3_0 = file_get_contents($this->root() . '/migrations/version_3_3_0.php');
		$version_3_3_1 = file_get_contents($this->root() . '/migrations/version_3_3_1.php');
		$version_3_3_2 = file_get_contents($this->root() . '/migrations/version_3_3_2.php');
		$this->assertStringContainsString('devspace\\\\userdefaults\\\\migrations\\\\version_3_3_0', $version_3_3_1);
		$this->assertStringContainsString('devspace\\\\userdefaults\\\\migrations\\\\version_3_3_1', $version_3_3_2);
		$this->assertStringContainsString("config.remove', array('ud_allow_viewonline'", $version_3_3_1);
		$this->assertStringContainsString("config.remove', array('ud_notifications'", $version_3_3_1);
		$this->assertStringContainsString('migrate_notification_defaults', $version_3_3_2);
		$this->assertStringNotContainsString('config.update', $version_3_3_0 . $version_3_3_1 . $version_3_3_2);
	}

	public function test_sync_uses_post_csrf_cursor_and_matching_user_scope()
	{
		$controller = file_get_contents($this->root() . '/controller/admin_controller.php');
		$sync = file_get_contents($this->root() . '/core/user_sync.php');
		$this->assertStringContainsString("is_set_post('sync_users')", $controller);
		$this->assertStringContainsString("check_form_key('devspace_userdefaults')", $controller);
		$this->assertStringContainsString('user_id > ', $sync);
		$this->assertStringContainsString('USER_NORMAL', $sync);
		$this->assertStringContainsString('USER_FOUNDER', $sync);
		$this->assertStringNotContainsString("['num_users']", $sync);
		$this->assertStringContainsString('merge_user_options', file_get_contents($this->root() . '/core/settings_policy.php'));
	}

	public function test_copyright_history_and_current_developer_are_preserved()
	{
		foreach ($this->php_files() as $file)
		{
			$contents = file_get_contents($file);
			if (strpos($contents, '@copyright') !== false)
			{
				$this->assertStringContainsString('@copyright (c) 2022 devspace', $contents, $file);
				$this->assertStringContainsString('@copyright (c) 2026 Leinad4Mind', $contents, $file);
			}
		}
	}

	public function test_every_template_label_targets_an_existing_control()
	{
		$template = file_get_contents($this->root() . '/adm/style/user_defaults.html');
		preg_match_all('/\sid="([^"]+)"/', $template, $ids);
		preg_match_all('/<label\s+for="([^"]+)"/', $template, $targets);
		foreach ($targets[1] as $target)
		{
			$this->assertContains($target, $ids[1], $target);
		}
	}

	public function test_no_online_update_or_duplicate_config_version_state_remains()
	{
		foreach ($this->php_files() as $file)
		{
			$contents = file_get_contents($file);
			$this->assertStringNotContainsString('config.update', $contents, $file);
			$this->assertStringNotContainsString('fopen(', $contents, $file);
			$this->assertStringNotContainsString('userdefaults_version', $contents, $file);
		}
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
