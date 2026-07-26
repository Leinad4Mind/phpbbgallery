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
			'gallery_auth' => 'phpbbgallery\\core\\auth\\auth',
			'gallery_url' => 'phpbbgallery\\core\\url',
			'gallery_user' => 'phpbbgallery\\core\\user',
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
		$handler->interpret(exif::DBSAVED, serialize($metadata));

		$this->assertSame($metadata, $handler->data);
		$this->assertSame(exif::DBSAVED, $handler->status);
		$this->assertSame(exif::DBSAVED, $handler->orig_status);
		$this->assertSame(42, $handler->image_id);
	}

	public function test_interpret_rejects_invalid_or_object_serialization(): void
	{
		$handler = new exif('/missing/image.jpg');

		$handler->interpret(exif::DBSAVED, 'not serialized data');
		$this->assertSame([], $handler->data);

		$handler->interpret(exif::DBSAVED, serialize(new \stdClass()));
		$this->assertSame([], $handler->data);
		$this->assertFalse($handler->set_status());
	}

	public function test_listener_registers_the_complete_event_map(): void
	{
		$this->assertSame([
			'phpbbgallery.core.acp.config.get_display_vars' => 'acp_config_get_display_vars',
			'phpbbgallery.core.config.load_config_sets' => 'config_load_config_sets',
			'phpbbgallery.acpimport.update_image_before' => 'massimport_update_image_before',
			'phpbbgallery.acpimport.update_image' => 'massimport_update_image',
			'phpbbgallery.core.posting.edit_before_rotate' => 'posting_edit_before_rotate',
			'phpbbgallery.core.ucp.set_settings_submit' => 'ucp_set_settings_submit',
			'phpbbgallery.core.ucp.set_settings_nosubmit' => 'ucp_set_settings_nosubmit',
			'phpbbgallery.core.upload.prepare_file_before' => 'upload_prepare_file_before',
			'phpbbgallery.core.upload.update_image_before' => 'upload_update_image_before',
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

	public function test_exif_output_uses_phpbb_utf8_escaping(): void
	{
		$source = (string) file_get_contents(dirname(__DIR__) . '/exif.php');

		$this->assertStringContainsString('utf8_htmlspecialchars($value)', $source);
		$this->assertSame(0, preg_match('/(?<![a-zA-Z0-9_])htmlspecialchars\s*\(/', $source));
	}
}
