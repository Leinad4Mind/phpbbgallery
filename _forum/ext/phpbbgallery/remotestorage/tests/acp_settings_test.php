<?php
/**
 * phpBB Gallery - Remote Storage ACP tests
 *
 * @package   phpbbgallery/remotestorage
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\remotestorage\tests;

use PHPUnit\Framework\TestCase;

final class acp_settings_test extends TestCase
{
	public function test_migration_registers_permission_module_and_connection_defaults(): void
	{
		$source = (string) file_get_contents(dirname(__DIR__) . '/migrations/m1_acp_settings.php');

		$this->assertStringContainsString('core\\migrations\\storage_provider', $source);
		$this->assertStringContainsString("['permission.add', ['a_gallery_remote_storage', true, 'a_board']]", $source);
		$this->assertStringContainsString("'module_mode' => 'settings'", $source);
		foreach (['endpoint', 'bucket', 'access_key', 'secret_key', 'region', 'prefix'] as $field)
		{
			$this->assertStringContainsString('phpbb_gallery_s3_' . $field, $source);
		}
	}

	public function test_provider_migration_has_server_side_text_cursor_and_imported_table_parameter(): void
	{
		$migration = (string) file_get_contents(dirname(__DIR__) . '/migrations/m2_provider_migration.php');
		$services = (string) file_get_contents(dirname(__DIR__) . '/config/services.yml');
		$tables = (string) file_get_contents(dirname(__DIR__) . '/config/tables.yml');

		$this->assertStringContainsString("'migration_cursor' => ['MTEXT', '']", $migration);
		$this->assertStringContainsString("'last_error' => ['MTEXT', '']", $migration);
		$this->assertStringContainsString('resource: tables.yml', $services);
		$this->assertStringContainsString('gallery_remote_migrations', $tables);
	}

	public function test_acp_tests_before_persisting_and_never_activates_s3_directly(): void
	{
		$source = (string) file_get_contents(dirname(__DIR__) . '/acp/main_module.php');

		$this->assertStringContainsString("add_form_key('acp_gallery_remote_storage')", $source);
		$this->assertStringContainsString("check_form_key('acp_gallery_remote_storage')", $source);
		$this->assertStringContainsString('->test($factory->create_from($settings))', $source);
		$this->assertMatchesRegularExpression(
			'/->test\(\$factory->create_from\(\$settings\)\);[\s\S]+?foreach \(\$settings as \$field => \$value\)/',
			$source
		);
		$this->assertStringNotContainsString("set('phpbb_gallery_storage_provider', 's3')", $source);
		$this->assertStringContainsString("is_set_post('start_migration')", $source);
		$this->assertStringContainsString("is_set_post('continue_migration')", $source);
		$this->assertStringContainsString("is_set_post('abort_migration')", $source);
		$this->assertStringContainsString('confirm_box(true)', $source);
	}

	public function test_secret_is_never_rendered_back_into_the_form(): void
	{
		$template = (string) file_get_contents(dirname(__DIR__) . '/adm/style/remotestorage_settings.html');
		$module = (string) file_get_contents(dirname(__DIR__) . '/acp/main_module.php');

		$this->assertStringContainsString('type="password"', $template);
		$this->assertStringContainsString('value=""', $template);
		$this->assertStringNotContainsString('{{ S3_SECRET_KEY }}', $template);
		$this->assertStringNotContainsString("'S3_SECRET_KEY' =>", $module);
	}

	public function test_all_gallery_language_catalogues_have_identical_keys_and_placeholders(): void
	{
		$english = $this->language(dirname(__DIR__) . '/language/en/info_acp_remotestorage.php');
		foreach (['bg', 'de', 'es', 'fr', 'it', 'nl', 'pt', 'pt_br', 'pt_preao', 'ru'] as $iso)
		{
			$file = dirname(__DIR__) . '/language/' . $iso . '/info_acp_remotestorage.php';
			$contents = (string) file_get_contents($file);
			$this->assertSame(1, preg_match('//u', $contents), $iso . ' is not valid UTF-8');
			$this->assertDoesNotMatchRegularExpression('/(?:Ã.|Â.|â†)/u', $contents, $iso);
			$catalogue = $this->language($file);
			$this->assertSame(array_keys($english), array_keys($catalogue), $iso);
			foreach ($english as $key => $value)
			{
				preg_match_all('/%(?:[0-9]+\$)?[sdu]/', (string) $value, $expected);
				preg_match_all('/%(?:[0-9]+\$)?[sdu]/', (string) $catalogue[$key], $actual);
				$this->assertSame($expected[0], $actual[0], $iso . ':' . $key);
			}
		}
	}

	private function language(string $file): array
	{
		$lang = [];
		include $file;
		ksort($lang);

		return $lang;
	}
}
