<?php
/**
 * phpBB Gallery - Contest Add-on package tests.
 *
 * @package   phpbbgallery/contest
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\contest\tests;

use phpbbgallery\contest\migrations\m1_init;
use PHPUnit\Framework\TestCase;

final class package_test extends TestCase
{
	public function test_manifest_declares_the_supported_package(): void
	{
		$manifest = json_decode(
			(string) file_get_contents(dirname(__DIR__) . '/composer.json'),
			true,
			512,
			JSON_THROW_ON_ERROR
		);

		$this->assertSame('phpbbgallery/contest', $manifest['name']);
		$this->assertSame('phpbb-extension', $manifest['type']);
		$this->assertSame('1.0.0', $manifest['version']);
		$this->assertSame('>=8.1', $manifest['require']['php']);
		$this->assertSame('GPL-2.0-only', $manifest['license']);
	}

	public function test_initial_migration_adopts_the_core_4_0_storage(): void
	{
		$this->assertSame(
			['\phpbbgallery\core\migrations\release_4_0_0'],
			m1_init::depends_on()
		);
		$this->assertFalse((new \ReflectionClass(m1_init::class))->hasMethod('update_schema'));
	}

	public function test_extension_uses_the_standard_core_dependency_lifecycle(): void
	{
		$source = (string) file_get_contents(dirname(__DIR__) . '/ext.php');

		$this->assertStringContainsString('$manager->is_available($core_extension)', $source);
		$this->assertStringContainsString('$manager->enable($core_extension)', $source);
		$this->assertStringContainsString("add_lang_ext('phpbbgallery/contest', 'info_contest')", $source);
		$this->assertStringContainsString("lang('GALLERY_CORE_NOT_FOUND')", $source);
	}

	public function test_table_parameter_uses_the_historical_storage_name(): void
	{
		$tables = (string) file_get_contents(dirname(__DIR__) . '/config/tables.yml');

		$this->assertStringContainsString(
			"phpbbgallery.contest.tables.contests: '%core.table_prefix%gallery_contests'",
			$tables
		);
	}

	public function test_services_own_the_contest_domain_and_policy_provider(): void
	{
		$services = (string) file_get_contents(dirname(__DIR__) . '/config/services.yml');

		$this->assertStringContainsString('phpbbgallery.contest.manager:', $services);
		$this->assertStringContainsString('class: phpbbgallery\\contest\\manager', $services);
		$this->assertStringContainsString('%phpbbgallery.contest.tables.contests%', $services);
		$this->assertStringContainsString('phpbbgallery.contest.policy_listener:', $services);
		$this->assertStringContainsString('class: phpbbgallery\\contest\\event\\policy_listener', $services);
		$this->assertStringContainsString('phpbbgallery.contest.acp_listener:', $services);
		$this->assertStringContainsString('class: phpbbgallery\\contest\\event\\acp_listener', $services);
		$this->assertStringContainsString('- { name: event.listener }', $services);
	}

	public function test_every_gallery_language_has_the_dependency_messages(): void
	{
		$language_root = dirname(__DIR__) . '/language';
		$languages = ['bg', 'de', 'en', 'es', 'fr', 'it', 'nl', 'pt', 'pt_br', 'pt_preao', 'ru'];

		foreach ($languages as $language)
		{
			$messages = $this->load_language($language_root . '/' . $language . '/info_contest.php');
			$acp_messages = $this->load_language($language_root . '/' . $language . '/contest_acp.php');
			$this->assertArrayHasKey('GALLERY_CORE_NOT_FOUND', $messages, $language);
			$this->assertArrayHasKey('EXTENSION_ENABLE_SUCCESS', $messages, $language);
			$this->assertArrayHasKey('CONTEST_CREATION', $acp_messages, $language);
			$this->assertArrayHasKey('CONTEST_CREATION_EXPLAIN', $acp_messages, $language);
			$this->assertArrayHasKey('CONTEST_CREATION_DISABLED', $acp_messages, $language);
		}
	}

	public function test_acp_album_type_fragment_contains_contest_fields(): void
	{
		$template = (string) file_get_contents(
			dirname(__DIR__) . '/adm/style/event/phpbbgallery_core_adm_album_type_options.html'
		);

		$this->assertStringContainsString('id="album_contest_options"', $template);
		$this->assertStringContainsString('name="contest_start"', $template);
		$this->assertStringContainsString('name="contest_rating"', $template);
		$this->assertStringContainsString('name="contest_end"', $template);
	}

	private function load_language(string $path): array
	{
		$lang = [];
		include $path;

		return $lang;
	}
}
