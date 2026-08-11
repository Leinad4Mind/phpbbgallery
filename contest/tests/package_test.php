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
use phpbbgallery\contest\migrations\m2_settings;
use phpbbgallery\contest\migrations\m3_album_storage;
use phpbbgallery\contest\migrations\m4_image_end_storage;
use phpbbgallery\contest\migrations\m5_image_rank_storage;
use phpbbgallery\contest\migrations\m6_contest_storage;
use phpbbgallery\contest\migrations\m7_winner_thumbnail;
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

	public function test_migrations_adopt_legacy_storage_and_own_new_installations(): void
	{
		$this->assertSame(
			['\phpbbgallery\core\migrations\release_4_0_0'],
			m1_init::depends_on()
		);
		$this->assertFalse((new \ReflectionClass(m1_init::class))->hasMethod('update_schema'));
		$this->assertSame(['\phpbbgallery\contest\migrations\m1_init'], m2_settings::depends_on());
		$this->assertSame(['\phpbbgallery\contest\migrations\m2_settings'], m3_album_storage::depends_on());
		$this->assertSame(['\phpbbgallery\contest\migrations\m3_album_storage'], m4_image_end_storage::depends_on());
		$this->assertSame(['\phpbbgallery\contest\migrations\m4_image_end_storage'], m5_image_rank_storage::depends_on());
		$this->assertSame(['\phpbbgallery\contest\migrations\m5_image_rank_storage'], m6_contest_storage::depends_on());
		$this->assertSame(['\phpbbgallery\contest\migrations\m6_contest_storage'], m7_winner_thumbnail::depends_on());

		$winner_thumbnail = (new \ReflectionClass(m7_winner_thumbnail::class))->newInstanceWithoutConstructor();
		(new \ReflectionProperty(\phpbb\db\migration\migration::class, 'table_prefix'))->setValue($winner_thumbnail, 'phpbb_');
		$this->assertSame([
			['config.add', ['phpbb_gallery_contest_winner_thumbnail', 0]],
		], $winner_thumbnail->update_data());
		$this->assertSame(
			['INT:11', -1],
			$winner_thumbnail->update_schema()['add_columns']['phpbb_gallery_contests']['contest_winner_thumbnail']
		);
		$this->assertSame([
			'drop_columns' => [
				'phpbb_gallery_contests' => ['contest_winner_thumbnail'],
			],
		], $winner_thumbnail->revert_schema());

		$settings = (new \ReflectionClass(m2_settings::class))->newInstanceWithoutConstructor();
		$this->assertSame([
			['config.add', ['phpbb_gallery_allow_contests', 1]],
			['config.add', ['phpbb_gallery_contests_ended', 0]],
		], $settings->update_data());

		$owned_storage = [
			m3_album_storage::class => [
				'drop_columns' => [
					'phpbb_gallery_albums' => ['album_contest'],
				],
			],
			m4_image_end_storage::class => [
				'drop_columns' => [
					'phpbb_gallery_images' => ['image_contest_end'],
				],
			],
			m5_image_rank_storage::class => [
				'drop_columns' => [
					'phpbb_gallery_images' => ['image_contest_rank'],
				],
			],
			m6_contest_storage::class => [
				'drop_tables' => ['phpbb_gallery_contests'],
			],
		];
		foreach ($owned_storage as $migration_class => $expected_revert)
		{
			$migration = (new \ReflectionClass($migration_class))->newInstanceWithoutConstructor();
			(new \ReflectionProperty(\phpbb\db\migration\migration::class, 'table_prefix'))->setValue($migration, 'phpbb_');
			$this->assertNotSame([], $migration->update_schema(), $migration_class);
			$this->assertSame($expected_revert, $migration->revert_schema(), $migration_class);
			$this->assertTrue((new \ReflectionClass($migration_class))->hasMethod('effectively_installed'));
		}
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
		$core_tables = (string) file_get_contents(dirname(__DIR__, 2) . '/core/config/tables.yml');

		$this->assertStringContainsString(
			"phpbbgallery.contest.tables.contests: '%core.table_prefix%gallery_contests'",
			$tables
		);
		$this->assertStringNotContainsString('gallery_contests', $core_tables);
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
		$this->assertStringContainsString('phpbbgallery.contest.album_lifecycle_listener:', $services);
		$this->assertStringContainsString('class: phpbbgallery\\contest\\event\\album_lifecycle_listener', $services);
		$this->assertStringContainsString("- '@dbal.tools'", $services);
		$this->assertStringContainsString('- { name: event.listener }', $services);

		$listener = (string) file_get_contents(dirname(__DIR__) . '/event/album_lifecycle_listener.php');
		$this->assertStringContainsString('phpbbgallery.core.album.manage.prepare_move_album_content', $listener);
		$this->assertStringContainsString('phpbbgallery.core.album.manage.move_album_content', $listener);
		$this->assertStringContainsString('phpbbgallery.core.album.manage.delete_album_content', $listener);
	}

	public function test_every_gallery_language_has_the_dependency_messages(): void
	{
		$language_root = dirname(__DIR__) . '/language';
		$languages = ['bg', 'de', 'en', 'es', 'fr', 'it', 'nl', 'pt', 'pt_br', 'pt_preao', 'ru'];

		foreach ($languages as $language)
		{
			$messages = $this->load_language($language_root . '/' . $language . '/info_contest.php');
			$frontend_messages = $this->load_language($language_root . '/' . $language . '/contest.php');
			$acp_messages = $this->load_language($language_root . '/' . $language . '/contest_acp.php');
			$this->assertArrayHasKey('GALLERY_CORE_NOT_FOUND', $messages, $language);
			$this->assertArrayHasKey('EXTENSION_ENABLE_SUCCESS', $messages, $language);
			foreach ([
				'CONTEST_COMMENTS_STARTS',
				'CONTEST_STATUS',
				'CONTEST_PHASE_UPCOMING',
				'CONTEST_PHASE_UPCOMING_EXPLAIN',
				'CONTEST_PHASE_UPLOAD',
				'CONTEST_PHASE_UPLOAD_EXPLAIN',
				'CONTEST_PHASE_RATING',
				'CONTEST_PHASE_RATING_EXPLAIN',
				'CONTEST_PHASE_FINISHED',
				'CONTEST_PHASE_FINISHED_EXPLAIN',
				'CONTEST_SCHEDULE_TIMEZONE',
				'CONTEST_ENDED',
				'CONTEST_ENDS',
				'CONTEST_IMAGE_DESC',
				'CONTEST_RATING_HIDDEN',
				'CONTEST_RATING_STARTED',
				'CONTEST_RATING_STARTS',
				'CONTEST_RESULT',
				'CONTEST_RESULT_1',
				'CONTEST_RESULT_2',
				'CONTEST_RESULT_3',
				'CONTEST_RESULT_HIDDEN',
				'CONTEST_STARTED',
				'CONTEST_STARTS',
				'CONTEST_USERNAME',
				'CONTEST_WINNERS_OF',
				'SEARCH_CONTEST',
				'VIEW_SEARCH_CONTESTS',
			] as $key)
			{
				$this->assertArrayHasKey($key, $frontend_messages, $language);
			}
			foreach ([
				'ALBUM_TYPE_CONTEST',
				'ALBUM_NO_TYPE_CHANGE_TO_CONTEST',
				'ALBUM_WITH_CONTEST_NO_TYPE_CHANGE',
				'CONTEST_CREATION',
				'CONTEST_CREATION_EXPLAIN',
				'CONTEST_CREATION_DISABLED',
				'CONTEST_SCHEMA_OUTDATED',
				'CONTEST_DATE_EXPLAIN',
				'CONTEST_END',
				'CONTEST_END_BEFORE_RATING',
				'CONTEST_END_BEFORE_START',
				'CONTEST_END_EXPLAIN',
				'CONTEST_END_INVALID',
				'CONTEST_RATING',
				'CONTEST_RATING_BEFORE_START',
				'CONTEST_RATING_EXPLAIN',
				'CONTEST_RATING_INVALID',
				'CONTEST_SETTINGS',
				'CONTEST_WINNER_THUMBNAIL',
				'CONTEST_WINNER_THUMBNAIL_EXPLAIN',
				'CONTEST_THUMBNAIL_POLICY',
				'CONTEST_THUMBNAIL_POLICY_EXPLAIN',
				'CONTEST_THUMBNAIL_INHERIT',
				'CONTEST_THUMBNAIL_LAST',
				'CONTEST_THUMBNAIL_WINNER',
				'CONTEST_START',
				'CONTEST_START_EXPLAIN',
				'CONTEST_START_INVALID',
			] as $key)
			{
				$this->assertArrayHasKey($key, $acp_messages, $language);
			}
		}
	}

	public function test_core_no_longer_owns_contest_frontend_messages(): void
	{
		$core_language_root = dirname(__DIR__, 2) . '/core/language';
		$languages = ['bg', 'de', 'en', 'es', 'fr', 'it', 'nl', 'pt', 'pt_br', 'pt_preao', 'ru'];

		foreach ($languages as $language)
		{
			$messages = $this->load_language($core_language_root . '/' . $language . '/gallery.php');
			foreach ([
				'CONTEST_COMMENTS_STARTS',
				'CONTEST_ENDED',
				'CONTEST_ENDS',
				'CONTEST_IMAGE_DESC',
				'CONTEST_RATING_ENDED',
				'CONTEST_RATING_STARTED',
				'CONTEST_RATING_STARTS',
				'CONTEST_RESULT',
				'CONTEST_RESULT_1',
				'CONTEST_RESULT_2',
				'CONTEST_RESULT_3',
				'CONTEST_STARTED',
				'CONTEST_STARTS',
				'CONTEST_USERNAME',
				'CONTEST_USERNAME_LONG',
				'CONTEST_WINNERS_OF',
				'SEARCH_CONTEST',
				'VIEW_SEARCH_CONTESTS',
			] as $key)
			{
				$this->assertArrayNotHasKey($key, $messages, $language);
			}

			$acp_messages = $this->load_language($core_language_root . '/' . $language . '/gallery_acp.php');
			$this->assertArrayNotHasKey('ALBUM_TYPE_CONTEST', $acp_messages, $language);
			$this->assertArrayNotHasKey('RRC_GINDEX_CONTESTS', $acp_messages, $language);
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
		$this->assertSame(3, substr_count($template, 'type="datetime-local"'));
		$this->assertSame(3, substr_count($template, 'step="60"'));
		$this->assertStringContainsString('name="contest_winner_thumbnail"', $template);

		$display = (string) file_get_contents(
			dirname(__DIR__) . '/adm/style/event/phpbbgallery_core_adm_album_display_options.html'
		);
		$warnings = (string) file_get_contents(
			dirname(__DIR__) . '/adm/style/event/phpbbgallery_core_adm_album_type_warnings.html'
		);
		$this->assertStringContainsString('contest_options.hidden', $display);
		$this->assertStringContainsString("dE('album_upload_options', 1)", $display);
		$this->assertStringContainsString('cat_to_contest_actions', $warnings);
		$this->assertStringContainsString('contest_change_type_actions', $warnings);
	}

	private function load_language(string $path): array
	{
		$lang = [];
		include $path;

		return $lang;
	}
}
