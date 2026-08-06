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

	public function test_provider_catalogue_uses_validated_factory_services(): void
	{
		$services = (string) file_get_contents(dirname(__DIR__) . '/config/services.yml');
		$module = (string) file_get_contents(dirname(__DIR__) . '/acp/main_module.php');

		$this->assertStringContainsString('phpbbgallery.remotestorage.provider_ids:', $services);
		$this->assertStringContainsString('phpbbgallery.remotestorage.provider_factory.s3:', $services);
		$this->assertStringContainsString('factory($save_provider)', $module);
		$this->assertStringContainsString('factory($target_provider)', $module);
		$this->assertStringNotContainsString('phpbbgallery.remotestorage.s3.builder', $services . $module);
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
		$this->assertStringContainsString('REMOTE_STORAGE_MIGRATION_START_CONFIRM', $source);
		$this->assertStringContainsString('REMOTE_STORAGE_MIGRATION_ABORT_CONFIRM', $source);
	}

	public function test_secret_is_never_rendered_back_into_the_form(): void
	{
		$template = (string) file_get_contents(dirname(__DIR__) . '/adm/style/remotestorage_settings.html');
		$module = (string) file_get_contents(dirname(__DIR__) . '/acp/main_module.php');

		$this->assertStringContainsString('type="{{ field.TYPE }}"', $template);
		$this->assertStringContainsString('value="{{ field.VALUE }}"', $template);
		$this->assertStringContainsString('$definition[', $module);
		$this->assertStringNotContainsString('{{ S3_SECRET_KEY }}', $template);
		$this->assertStringNotContainsString("'S3_SECRET_KEY' =>", $module);
	}

	public function test_azure_migration_registers_private_provider_configuration(): void
	{
		$migration = (string) file_get_contents(dirname(__DIR__) . '/migrations/m3_azure_blob.php');
		$services = (string) file_get_contents(dirname(__DIR__) . '/config/services.yml');

		$this->assertStringContainsString('m2_provider_migration', $migration);
		foreach (['endpoint', 'account', 'container', 'account_key', 'prefix'] as $field)
		{
			$this->assertStringContainsString('phpbb_gallery_azure_' . $field, $migration);
		}
		$this->assertStringContainsString('phpbbgallery.remotestorage.provider_factory.azure:', $services);
		$this->assertStringContainsString('phpbbgallery.remotestorage.provider_factory.azure:', $services);
		$this->assertStringContainsString('{ name: phpbbgallery.storage.provider_factory }', $services);
	}

	public function test_sftp_migration_registers_optional_pinned_host_configuration(): void
	{
		$migration = (string) file_get_contents(dirname(__DIR__) . '/migrations/m4_sftp.php');
		$services = (string) file_get_contents(dirname(__DIR__) . '/config/services.yml');
		$composer = json_decode((string) file_get_contents(dirname(__DIR__) . '/composer.json'), true, 512, JSON_THROW_ON_ERROR);

		$this->assertStringContainsString('m3_azure_blob', $migration);
		foreach (['host', 'port', 'username', 'password', 'host_fingerprint', 'root'] as $field)
		{
			$this->assertStringContainsString('phpbb_gallery_sftp_' . $field, $migration);
		}
		$this->assertStringContainsString('phpbbgallery.remotestorage.provider_factory.sftp:', $services);
		$this->assertSame('Required only when the SFTP provider is selected', $composer['suggest']['ext-ssh2']);
	}

	public function test_dropbox_migration_registers_private_oauth_configuration(): void
	{
		$migration = (string) file_get_contents(dirname(__DIR__) . '/migrations/m5_dropbox.php');
		$services = (string) file_get_contents(dirname(__DIR__) . '/config/services.yml');

		$this->assertStringContainsString('m4_sftp', $migration);
		foreach (['app_key', 'app_secret', 'refresh_token', 'root'] as $field)
		{
			$this->assertStringContainsString('phpbb_gallery_dropbox_' . $field, $migration);
		}
		$this->assertStringContainsString('phpbbgallery.remotestorage.provider_factory.dropbox:', $services);
		$this->assertStringContainsString('- dropbox', $services);
	}

	public function test_google_drive_migration_registers_least_privilege_oauth_configuration(): void
	{
		$migration = (string) file_get_contents(dirname(__DIR__) . '/migrations/m6_google_drive.php');
		$services = (string) file_get_contents(dirname(__DIR__) . '/config/services.yml');
		$language = (string) file_get_contents(dirname(__DIR__) . '/language/en/info_acp_remotestorage.php');

		$this->assertStringContainsString('m5_dropbox', $migration);
		foreach (['client_id', 'client_secret', 'refresh_token', 'root_name'] as $field)
		{
			$this->assertStringContainsString('phpbb_gallery_google_drive_' . $field, $migration);
		}
		$this->assertStringContainsString('phpbbgallery.remotestorage.provider_factory.google_drive:', $services);
		$this->assertStringContainsString('- google_drive', $services);
		$this->assertStringContainsString('drive.file', $language);
	}

	public function test_box_migration_registers_rotating_oauth_configuration(): void
	{
		$migration = (string) file_get_contents(dirname(__DIR__) . '/migrations/m7_box.php');
		$services = (string) file_get_contents(dirname(__DIR__) . '/config/services.yml');
		$module = (string) file_get_contents(dirname(__DIR__) . '/acp/main_module.php');

		$this->assertStringContainsString('m6_google_drive', $migration);
		foreach (['client_id', 'client_secret', 'refresh_token', 'access_token', 'access_expires', 'root_name'] as $field)
		{
			$this->assertStringContainsString('phpbb_gallery_box_' . $field, $migration);
		}
		$this->assertStringContainsString('phpbbgallery.remotestorage.provider_factory.box:', $services);
		$this->assertStringContainsString('- box', $services);
		$this->assertStringContainsString('box-oauth.lock', $services);
		$this->assertStringContainsString('rotating_credentials_factory_interface', $module);
		$this->assertStringContainsString('finalize_tested_settings($settings)', $module);
		$this->assertStringContainsString('REMOTE_STORAGE_ROTATED_CREDENTIALS_PRESERVED', $module);
		$failure_handler = strpos($module, '$rotated_credentials_preserved = false;');
		$finalization = strpos($module, 'finalize_tested_settings($settings)', (int) $failure_handler);
		$error = strpos($module, 'trigger_error(', (int) $finalization);
		$this->assertIsInt($failure_handler);
		$this->assertIsInt($finalization);
		$this->assertIsInt($error);
		$this->assertLessThan($finalization, $failure_handler);
		$this->assertLessThan($error, $finalization);
	}

	public function test_mediafire_migration_registers_serialized_v2_session_configuration(): void
	{
		$migration = (string) file_get_contents(dirname(__DIR__) . '/migrations/m8_mediafire.php');
		$services = (string) file_get_contents(dirname(__DIR__) . '/config/services.yml');

		$this->assertStringContainsString('m7_box', $migration);
		foreach ([
			'application_id', 'api_key', 'email', 'password', 'root_name',
			'session_token', 'secret_key', 'session_time', 'session_issued_at',
		] as $field)
		{
			$this->assertStringContainsString('phpbb_gallery_mediafire_' . $field, $migration);
		}
		$this->assertStringContainsString('phpbbgallery.remotestorage.provider_factory.mediafire:', $services);
		$this->assertStringContainsString('- mediafire', $services);
		$this->assertStringContainsString('mediafire-session.lock', $services);
	}

	public function test_pcloud_migration_registers_region_bound_oauth_configuration(): void
	{
		$migration = (string) file_get_contents(dirname(__DIR__) . '/migrations/m9_pcloud.php');
		$services = (string) file_get_contents(dirname(__DIR__) . '/config/services.yml');

		$this->assertStringContainsString('m8_mediafire', $migration);
		foreach (['api_host', 'access_token', 'root_name'] as $field)
		{
			$this->assertStringContainsString('phpbb_gallery_pcloud_' . $field, $migration);
		}
		$this->assertStringContainsString('phpbbgallery.remotestorage.provider_factory.pcloud:', $services);
		$this->assertStringContainsString('- pcloud', $services);
	}

	public function test_koofr_migration_registers_fixed_tls_webdav_configuration(): void
	{
		$migration = (string) file_get_contents(dirname(__DIR__) . '/migrations/m10_koofr.php');
		$services = (string) file_get_contents(dirname(__DIR__) . '/config/services.yml');

		$this->assertStringContainsString('m9_pcloud', $migration);
		foreach (['email', 'app_password', 'root_name'] as $field)
		{
			$this->assertStringContainsString('phpbb_gallery_koofr_' . $field, $migration);
		}
		$this->assertStringContainsString('phpbbgallery.remotestorage.provider_factory.koofr:', $services);
		$this->assertStringContainsString('- koofr', $services);
	}

	public function test_fourshared_migration_registers_oauth_configuration_and_mutation_lock(): void
	{
		$migration = (string) file_get_contents(dirname(__DIR__) . '/migrations/m11_fourshared.php');
		$services = (string) file_get_contents(dirname(__DIR__) . '/config/services.yml');

		$this->assertStringContainsString('m10_koofr', $migration);
		foreach (['consumer_key', 'consumer_secret', 'access_token', 'access_token_secret', 'root_name'] as $field)
		{
			$this->assertStringContainsString('phpbb_gallery_fourshared_' . $field, $migration);
		}
		$this->assertStringContainsString('phpbbgallery.remotestorage.provider_factory.fourshared:', $services);
		$this->assertStringContainsString('- fourshared', $services);
		$this->assertStringContainsString('4shared-storage.lock', $services);
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

	public function test_provider_guide_documents_every_registered_provider_and_installation_flow(): void
	{
		$guide = (string) file_get_contents(dirname(__DIR__) . '/PROVIDERS.md');

		foreach ([
			'S3 and S3-compatible storage', 'Azure Blob Storage', 'SFTP', 'Dropbox',
			'Google Drive', 'Box', 'MediaFire', 'pCloud', 'Koofr', '4shared',
		] as $provider)
		{
			$this->assertStringContainsString('## ' . $provider, $guide);
		}
		foreach ([
			'https://docs.aws.amazon.com/',
			'https://learn.microsoft.com/',
			'https://developers.dropbox.com/',
			'https://developers.google.com/',
			'https://developer.box.com/',
			'https://www.mediafire.com/developers/',
			'https://docs.pcloud.com/',
			'https://koofr.eu/help/',
			'https://www.rfc-editor.org/info/rfc4918/',
			'https://www.4shared.com/developer/docs/',
		] as $official_documentation)
		{
			$this->assertStringContainsString($official_documentation, $guide);
		}
		$this->assertStringContainsString('## Installation example: Koofr', $guide);
		$this->assertStringContainsString('Test connection and save', $guide);
		$this->assertStringContainsString('Provider migration', $guide);
	}

	private function language(string $file): array
	{
		$lang = [];
		include $file;
		ksort($lang);

		return $lang;
	}
}
