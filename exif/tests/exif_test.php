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

	public function test_listener_registers_the_complete_event_map(): void
	{
		$this->assertSame([
			'phpbbgallery.core.acp.config.get_display_vars' => 'acp_config_get_display_vars',
			'phpbbgallery.acpimport.update_image_before' => 'massimport_update_image_before',
			'phpbbgallery.acpimport.update_image' => 'massimport_update_image',
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
		$this->assertStringContainsString('@phpbbgallery.core.storage.workspace', $services);
	}

	public function test_template_events_cover_every_supported_style(): void
	{
		$events = [
			'phpbbgallery_core_ucp_settings_fieldset.html',
			'phpbbgallery_core_viewimage_details.html',
		];

		foreach (['prosilver', 'BBOOTS', 'FLATBOOTS'] as $style)
		{
			foreach ($events as $event)
			{
				$this->assertFileExists(dirname(__DIR__) . '/styles/' . $style . '/template/event/' . $event);
			}
		}
	}

	public function test_bootstrap_template_events_use_theme_markup(): void
	{
		foreach (['BBOOTS', 'FLATBOOTS'] as $style)
		{
			$root = dirname(__DIR__) . '/styles/' . $style . '/template/event/';
			$settings = (string) file_get_contents($root . 'phpbbgallery_core_ucp_settings_fieldset.html');
			$details = (string) file_get_contents($root . 'phpbbgallery_core_viewimage_details.html');

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
