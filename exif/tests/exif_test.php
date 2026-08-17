<?php
/**
 * phpBB Gallery - EXIF tests
 *
 * @package   phpbbgallery/exif
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\exif\tests;

use PHPUnit\Framework\TestCase;
use phpbbgallery\exif\event\exif_listener;
use phpbbgallery\exif\exif;

final class exif_test extends TestCase
{
	public function test_model_contract_uses_native_types(): void
	{
		$reflection = new \ReflectionClass(exif::class);
		$expected_properties = [
			'function_exists' => '?bool',
			'data' => 'array|false',
			'prepared_data' => 'array',
			'status' => 'int',
			'serialized' => 'string',
			'file' => 'string',
			'orig_status' => '?int',
			'image_id' => 'int|false',
			'allowed_groups' => 'array',
			'allowed_keys' => 'array',
		];

		foreach ($expected_properties as $property_name => $expected_type)
		{
			$this->assertSame($expected_type, (string) $reflection->getProperty($property_name)->getType());
		}

		$expected_returns = [
			'interpret' => 'void',
			'read' => 'void',
			'prepare_data' => 'void',
			'send_to_template' => 'void',
			'set_status' => '?bool',
		];
		foreach ($expected_returns as $method_name => $expected_type)
		{
			$this->assertSame($expected_type, (string) $reflection->getMethod($method_name)->getReturnType());
		}
	}

	public function test_listener_contract_uses_native_types(): void
	{
		$reflection = new \ReflectionClass(exif_listener::class);
		$expected_properties = [
			'user' => 'phpbb\\user',
			'gallery_config' => 'phpbbgallery\\core\\config',
			'gallery_user' => 'phpbbgallery\\core\\user',
			'storage_workspace' => 'phpbbgallery\\core\\storage\\workspace',
			'capture_index' => 'phpbbgallery\\exif\\capture_index',
			'capture_sync' => 'phpbbgallery\\exif\\capture_sync',
			'capture_table' => 'string',
		];

		foreach ($expected_properties as $property_name => $expected_type)
		{
			$this->assertSame($expected_type, (string) $reflection->getProperty($property_name)->getType());
		}

		foreach (array_values(exif_listener::getSubscribedEvents()) as $handler)
		{
			$method = $reflection->getMethod($handler);
			$this->assertSame('void', (string) $method->getReturnType());
			if ($handler !== 'ucp_set_settings_nosubmit')
			{
				$this->assertSame('phpbb\\event\\data', (string) $method->getParameters()[0]->getType());
			}
		}
	}

	public function test_interpret_restores_stored_array_metadata(): void
	{
		$metadata = ['EXIF' => ['FNumber' => '28/10']];
		$handler = new exif('/missing/image.jpg', 42);
		$stored = json_encode($metadata, JSON_THROW_ON_ERROR);
		$handler->interpret(exif::DBSAVED, $stored);

		$this->assertSame($metadata, $handler->data);
		$this->assertSame($stored, $handler->serialized);
		$this->assertSame(exif::DBSAVED, $handler->status);
		$this->assertSame(exif::DBSAVED, $handler->orig_status);
		$this->assertSame(42, $handler->image_id);
	}

	public function test_interpret_rejects_invalid_or_legacy_serialization(): void
	{
		$handler = new exif('/missing/image.jpg');

		$handler->interpret(exif::DBSAVED, 'not JSON data');
		$this->assertSame([], $handler->data);
		$this->assertSame(exif::UNKNOWN, $handler->status);

		$handler->interpret(exif::DBSAVED, 'a:1:{s:4:"EXIF";a:0:{}}');
		$this->assertSame([], $handler->data);
		$this->assertSame(exif::UNKNOWN, $handler->status);
		$this->assertFalse($handler->set_status());
		$this->assertSame(0, preg_match('/(?<![a-zA-Z0-9_])unserialize\s*\(/', (string) file_get_contents(dirname(__DIR__) . '/exif.php')));
	}

	public function test_interpret_rebuilds_an_empty_legacy_cache(): void
	{
		$handler = new exif('/missing/image.jpg');
		$handler->interpret(exif::DBSAVED, '{"IFD0":[],"EXIF":[]}');

		$this->assertSame([], $handler->data);
		$this->assertSame('', $handler->serialized);
		$this->assertSame(exif::UNKNOWN, $handler->status);
		$this->assertNull($handler->orig_status);
	}

	public function test_interpret_accepts_a_resolution_density_cache(): void
	{
		$metadata = [
			'IFD0' => [
				'XResolution' => '72/1',
				'YResolution' => '72/1',
				'ResolutionUnit' => 2,
			],
		];
		$stored = json_encode($metadata, JSON_THROW_ON_ERROR);
		$handler = new exif('/missing/image.jpg');
		$handler->interpret(exif::DBSAVED, $stored);

		$this->assertSame($metadata, $handler->data);
		$this->assertSame($stored, $handler->serialized);
		$this->assertSame(exif::DBSAVED, $handler->status);

		$reflection = new \ReflectionClass(exif::class);
		$allowed_keys = $reflection->getStaticPropertyValue('allowed_keys');
		$this->assertContains('XResolution', $allowed_keys);
		$this->assertContains('YResolution', $allowed_keys);
		$this->assertContains('ResolutionUnit', $allowed_keys);
	}

	public function test_listener_registers_the_complete_event_map(): void
	{
		$this->assertSame([
			'phpbbgallery.core.acp.config.get_display_vars' => 'acp_config_get_display_vars',
			'phpbbgallery.acpimport.update_image_before' => 'massimport_update_image_before',
			'phpbbgallery.acpimport.insert_image_after' => 'capture_after_import',
			'phpbbgallery.core.posting.edit_before_rotate' => 'posting_edit_before_rotate',
			'phpbbgallery.core.image.delete_images' => 'capture_deleted_images',
			'phpbbgallery.core.image.sort_labels' => 'sort_labels',
			'phpbbgallery.core.image.sort_options' => 'sort_options',
			'phpbbgallery.core.search.sort_options' => 'search_sort_options',
			'phpbbgallery.core.image_edit_after' => 'capture_after_edit',
			'phpbbgallery.core.ucp.set_settings_submit' => 'ucp_set_settings_submit',
			'phpbbgallery.core.ucp.set_settings_nosubmit' => 'ucp_set_settings_nosubmit',
			'phpbbgallery.core.upload.prepare_file_before' => 'upload_prepare_file_before',
			'phpbbgallery.core.upload.update_image_before' => 'upload_update_image_before',
			'phpbbgallery.core.upload.update_image_after' => 'capture_after_upload',
			'phpbbgallery.core.user.get_default_values' => 'user_get_default_values',
			'phpbbgallery.core.user.validate_data' => 'user_validate_data',
			'phpbbgallery.core.viewimage' => 'viewimage',
		], exif_listener::getSubscribedEvents());
	}

	public function test_listener_accepts_both_jpeg_filename_extensions(): void
	{
		$reflection = new \ReflectionClass(exif_listener::class);
		$listener = $reflection->newInstanceWithoutConstructor();
		$is_jpeg_filename = $reflection->getMethod('is_jpeg_filename');

		$this->assertTrue($is_jpeg_filename->invoke($listener, 'image.jpg'));
		$this->assertTrue($is_jpeg_filename->invoke($listener, 'image.JPEG'));
		$this->assertFalse($is_jpeg_filename->invoke($listener, 'image.png'));
	}

	public function test_private_metadata_visibility_comes_from_the_core_event_context(): void
	{
		$source = (string) file_get_contents(dirname(__DIR__) . '/event/exif_listener.php');

		$this->assertStringContainsString("!\$event['hide_private_data']", $source);
		$this->assertStringNotContainsString('image_contest', $source);
		$this->assertStringNotContainsString('can_view_contest_exif', $source);
		$this->assertStringNotContainsString('core\\block::IN_CONTEST', $source);

		$services = (string) file_get_contents(dirname(__DIR__) . '/config/services.yml');
		$this->assertStringNotContainsString('@phpbbgallery.core.auth', $services);
	}

	public function test_viewimage_materializes_and_releases_the_active_source(): void
	{
		$source = (string) file_get_contents(dirname(__DIR__) . '/event/exif_listener.php');
		$services = (string) file_get_contents(dirname(__DIR__) . '/config/services.yml');

		$this->assertStringContainsString('$this->storage_workspace->materialize(', $source);
		$this->assertStringContainsString('provider_interface::SOURCE', $source);
		$this->assertStringContainsString('$source->release()', $source);
		$this->assertStringNotContainsString('$this->gallery_url->path', $source);
		$this->assertStringContainsString('$exif->send_to_template(', $source);
		$this->assertStringNotContainsString("!empty(\$exif->data['EXIF'])", $source);
		$this->assertStringContainsString('@phpbbgallery.core.storage.workspace', $services);
	}

	public function test_acp_import_reads_original_exif_before_file_processing(): void
	{
		$listener = (string) file_get_contents(dirname(__DIR__) . '/event/exif_listener.php');
		$importer = (string) file_get_contents(dirname(__DIR__, 2) . '/acpimport/acp/main_module.php');
		$extract = strpos($importer, 'phpbbgallery.acpimport.update_image_before');
		$external = strpos($importer, '$external_processor->prepare_source(', (int) $extract);
		$resize = strpos($importer, '$image_tools->resize_image(', (int) $extract);
		$insert = strpos($importer, 'gallery_images ', (int) $resize);

		$this->assertIsInt($extract);
		$this->assertIsInt($external);
		$this->assertIsInt($resize);
		$this->assertIsInt($insert);
		$this->assertLessThan($external, $extract);
		$this->assertLessThan($resize, $extract);
		$this->assertLessThan($insert, $resize);
		$this->assertStringContainsString('massimport_update_image_before', $listener);
		$this->assertStringNotContainsString('massimport_update_image(', $listener);
		$this->assertStringNotContainsString('!$event[\'file_updated\']', $listener);
	}

	public function test_valid_database_cache_does_not_materialize_the_source(): void
	{
		$listener = (new \ReflectionClass(exif_listener::class))->newInstanceWithoutConstructor();
		$method = new \ReflectionMethod(exif_listener::class, 'load_display_exif');
		$stored = json_encode(['EXIF' => ['FNumber' => '28/10']], JSON_THROW_ON_ERROR);

		$handler = $method->invoke($listener, 42, exif::DBSAVED, $stored, 'remote-image.jpg');

		$this->assertSame(exif::DBSAVED, $handler->status);
		$this->assertSame(['EXIF' => ['FNumber' => '28/10']], $handler->data);
	}

	public function test_missing_reader_does_not_materialize_an_unknown_source(): void
	{
		$function_exists = exif::$function_exists;
		exif::$function_exists = false;
		try
		{
			$listener = (new \ReflectionClass(exif_listener::class))->newInstanceWithoutConstructor();
			$method = new \ReflectionMethod(exif_listener::class, 'load_display_exif');
			$handler = $method->invoke($listener, 42, exif::UNKNOWN, '', 'remote-image.jpg');

			$this->assertSame(exif::UNKNOWN, $handler->status);
			$this->assertSame([], $handler->data);
		}
		finally
		{
			exif::$function_exists = $function_exists;
		}
	}

	public function test_unknown_cache_materializes_and_releases_the_source_for_rebuild(): void
	{
		$source_path = tempnam(sys_get_temp_dir(), 'gallery_exif_source_');
		$this->assertNotFalse($source_path);
		file_put_contents($source_path, 'not a JPEG');
		$provider = new exif_tracking_provider($source_path);
		$workspace = new \phpbbgallery\core\storage\workspace($provider, sys_get_temp_dir() . '/gallery_exif_workspace');
		$listener = (new \ReflectionClass(exif_listener::class))->newInstanceWithoutConstructor();
		(new \ReflectionProperty(exif_listener::class, 'storage_workspace'))->setValue($listener, $workspace);
		$method = new \ReflectionMethod(exif_listener::class, 'load_display_exif');
		$function_exists = exif::$function_exists;
		exif::$function_exists = true;
		global $db, $table_prefix;
		$previous_db = $db ?? null;
		$previous_table_prefix = $table_prefix ?? null;
		$db = $this->createMock(\phpbb\db\driver\driver_interface::class);
		$db->expects($this->once())->method('sql_query')->willReturn(true);
		$table_prefix = 'phpbb_';

		try
		{
			$handler = $method->invoke($listener, 42, exif::UNKNOWN, '', 'remote-image.jpg');

			$this->assertSame(1, $provider->local_path_calls);
			$this->assertSame(exif::UNAVAILABLE, $handler->status);
			$this->assertFileExists($source_path);
		}
		finally
		{
			exif::$function_exists = $function_exists;
			$db = $previous_db;
			$table_prefix = $previous_table_prefix;
			@unlink($source_path);
		}
	}

	public function test_template_events_cover_every_supported_style(): void
	{
		$events = [
			'phpbbgallery_core_ucp_settings_fieldset.html',
			'phpbbgallery_core_viewimage_details_after.html',
		];

		foreach (\gallery_test_existing_styles(dirname(__DIR__)) as $style)
		{
			foreach ($events as $event)
			{
				$this->assertFileExists(dirname(__DIR__) . '/styles/' . $style . '/template/event/' . $event);
			}
		}
	}

	public function test_bootstrap_template_events_use_theme_markup(): void
	{
		foreach (\gallery_test_existing_styles(dirname(__DIR__), ['BBOOTS', 'FLATBOOTS'], $this) as $style)
		{
			$root = dirname(__DIR__) . '/styles/' . $style . '/template/event/';
			$settings = (string) file_get_contents($root . 'phpbbgallery_core_ucp_settings_fieldset.html');
			$details = (string) file_get_contents($root . 'phpbbgallery_core_viewimage_details_after.html');

			$this->assertStringContainsString('class="control-group"', $settings, $style);
			$this->assertStringContainsString('class="table-responsive"', $details, $style);
			$this->assertStringContainsString('<th scope="row">', $details, $style);
			$this->assertDoesNotMatchRegularExpression('/<\/?(?:dl|dt|dd)\b/i', $settings . $details, $style);
		}
	}

	public function test_exif_output_uses_phpbb_utf8_escaping(): void
	{
		$source = (string) file_get_contents(dirname(__DIR__) . '/exif.php');

		$this->assertStringContainsString('utf8_htmlspecialchars($value)', $source);
		$this->assertSame(0, preg_match('/(?<![a-zA-Z0-9_])htmlspecialchars\s*\(/', $source));
	}
}
