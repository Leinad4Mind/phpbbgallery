<?php
/**
 * phpBB Gallery - File controller tests
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\tests;

use phpbbgallery\core\controller\file;
use phpbbgallery\core\storage\provider_interface;
use phpbbgallery\core\storage\workspace;
use PHPUnit\Framework\TestCase;

final class controller_file_types_test extends TestCase
{
	public function test_file_controller_properties_and_methods_are_fully_typed(): void
	{
		$reflection = new \ReflectionClass(file::class);

		foreach ($reflection->getProperties() as $property)
		{
			if ($property->getDeclaringClass()->getName() === file::class)
			{
				$this->assertNotNull($property->getType(), file::class . '::$' . $property->getName());
			}
		}

		foreach ($reflection->getMethods() as $method)
		{
			if ($method->getDeclaringClass()->getName() !== file::class)
			{
				continue;
			}

			foreach ($method->getParameters() as $parameter)
			{
				$this->assertNotNull($parameter->getType(), file::class . '::' . $method->getName() . '($' . $parameter->getName() . ')');
			}

			if (!$method->isConstructor())
			{
				$this->assertNotNull($method->getReturnType(), file::class . '::' . $method->getName() . '()');
			}
		}
	}

	public function test_binary_routes_use_integer_identifiers_and_binary_responses(): void
	{
		$reflection = new \ReflectionClass(file::class);

		foreach (['source', 'source_download', 'upload_preview', 'medium', 'mini'] as $method_name)
		{
			$method = $reflection->getMethod($method_name);
			$this->assertSame('int', (string) $method->getParameters()[0]->getType());
			$this->assertSame('Symfony\\Component\\HttpFoundation\\BinaryFileResponse', (string) $method->getReturnType());
		}
	}

	public function test_binary_routes_reset_shared_image_metadata_before_delivery(): void
	{
		$reflection = new \ReflectionClass(file::class);
		$source = file(dirname(__DIR__) . '/controller/file.php');
		$this->assertIsArray($source);

		foreach (['upload_preview', 'source_response', 'medium', 'mini'] as $method_name)
		{
			$method = $reflection->getMethod($method_name);
			$method_source = implode('', array_slice(
				$source,
				$method->getStartLine() - 1,
				$method->getEndLine() - $method->getStartLine() + 1
			));

			$this->assertStringContainsString('set_image_data', $method_source, $method_name);
			$this->assertStringContainsString(
				', 0, true);',
				$method_source,
				$method_name . ' must not reuse MIME metadata from an earlier response.'
			);
		}
	}

	public function test_original_source_has_an_extension_gate_and_addon_download_override(): void
	{
		$source = file_get_contents(dirname(__DIR__) . '/controller/file.php');
		$services = file_get_contents(dirname(__DIR__) . '/config/services_controller.yml');

		$this->assertStringContainsString('phpbbgallery.core.file.source_access', $source);
		$this->assertStringContainsString(
			'$vars = [\'image_data\', \'source_path\', \'force_download\', \'delivery_mode\'];',
			$source
		);
		$this->assertStringContainsString('$force_download || $this->source_requires_download', $source);
		$this->assertStringContainsString("source_response(\$image_id, false, 'source')", $source);
		$this->assertStringContainsString("source_response(\$image_id, true, 'download')", $source);
		$this->assertStringContainsString('public function authorize_source(int $image_id): array', $source);
		$this->assertStringContainsString('if ($attachment || empty($this->user->browser)', $source);
		$this->assertStringContainsString('Original-source access may be user-specific', $source);
		$this->assertStringContainsString('$this->tool->disable_browser_cache();', $source);
		$file_service = strstr($services, 'phpbbgallery.core.controller.file:');
		$file_service = strstr($file_service, 'phpbbgallery.core.controller.image:', true);
		$this->assertStringContainsString("- '@dispatcher'", $file_service);
	}

	public function test_browser_safe_sources_are_inline_and_other_formats_are_downloads(): void
	{
		$reflection = new \ReflectionClass(file::class);
		$controller = $reflection->newInstanceWithoutConstructor();
		$requires_download = $reflection->getMethod('source_requires_download');

		foreach (['image.gif', 'image.jpg', 'image.JPEG', 'image.png', 'image.webp', 'image.avif'] as $filename)
		{
			$this->assertFalse($requires_download->invoke($controller, $filename), $filename);
		}

		foreach (['image.bmp', 'image.tif', 'image.tiff', 'image.svg', 'image'] as $filename)
		{
			$this->assertTrue($requires_download->invoke($controller, $filename), $filename);
		}
	}

	public function test_zero_identifier_resets_stale_state_to_a_complete_error_image(): void
	{
		$reflection = new \ReflectionClass(file::class);
		$controller = $reflection->newInstanceWithoutConstructor();
		$reflection->getProperty('data')->setValue($controller, ['image_id' => 99, 'album_auth_access' => 5]);
		$reflection->getProperty('error')->setValue($controller, 'old-error.jpg');
		$reflection->getProperty('image_src')->setValue($controller, 'old-source.jpg');
		$reflection->getProperty('use_watermark')->setValue($controller, true);
		$this->set_language($reflection, $controller);

		$controller->load_data(0);

		$data = $reflection->getProperty('data')->getValue($controller);
		$this->assertSame('image_not_exist.jpg', $reflection->getProperty('error')->getValue($controller));
		$this->assertSame('', $reflection->getProperty('image_src')->getValue($controller));
		$this->assertFalse($reflection->getProperty('use_watermark')->getValue($controller));
		$this->assertSame(0, $data['image_id']);
		$this->assertSame(0, $data['album_id']);
		$this->assertSame(0, $data['album_auth_access']);
		$this->assertSame('image_not_exist.jpg', $data['image_filename']);
		$this->assertSame('IMAGE_NOT_EXIST', $data['image_name']);
	}

	public function test_missing_database_row_is_normalized_before_error_state_is_built(): void
	{
		$reflection = new \ReflectionClass(file::class);
		$controller = $reflection->newInstanceWithoutConstructor();
		$db = $this->createMock(\phpbb\db\driver\driver_interface::class);
		$db->expects($this->once())->method('sql_query')->willReturn('result');
		$db->expects($this->once())->method('sql_fetchrow')->with('result')->willReturn(false);
		$db->expects($this->once())->method('sql_freeresult')->with('result');
		$reflection->getProperty('db')->setValue($controller, $db);
		$reflection->getProperty('table_images')->setValue($controller, 'gallery_images');
		$reflection->getProperty('table_albums')->setValue($controller, 'gallery_albums');
		$this->set_language($reflection, $controller);

		$controller->load_data(27);

		$data = $reflection->getProperty('data')->getValue($controller);
		$this->assertSame('not_authorised.jpg', $reflection->getProperty('error')->getValue($controller));
		$this->assertSame(0, $data['image_id']);
		$this->assertSame(0, $data['album_auth_access']);
		$this->assertSame('NOT_AUTHORISED', $data['image_name']);
	}

	public function test_pending_deletion_files_require_delete_moderation_permission(): void
	{
		$reflection = new \ReflectionClass(file::class);
		$controller = $reflection->newInstanceWithoutConstructor();
		$reflection->getProperty('data')->setValue($controller, [
			'image_id' => 27,
			'image_user_id' => 8,
			'image_status' => \phpbbgallery\core\block::STATUS_DELETE_REQUESTED,
			'album_id' => 4,
			'album_user_id' => 2,
			'album_auth_access' => 0,
		]);
		$reflection->getProperty('error')->setValue($controller, '');
		$this->set_language($reflection, $controller);

		$user = new \phpbb\user();
		$user->data = ['user_id' => 8, 'user_lang' => 'en'];
		$reflection->getProperty('user')->setValue($controller, $user);

		$auth = $this->createMock(\phpbbgallery\core\auth\auth::class);
		$auth->method('get_user_zebra')->willReturn([]);
		$auth->method('get_zebra_state')->willReturn(0);
		$auth->method('acl_check')->willReturnCallback(static function (string $permission): bool
		{
			return $permission === 'i_view';
		});
		$reflection->getProperty('auth')->setValue($controller, $auth);

		$controller->check_auth();

		$this->assertSame('not_authorised.jpg', $reflection->getProperty('error')->getValue($controller));
	}

	public function test_gallery_storage_paths_are_anchored_to_the_phpbb_root(): void
	{
		$reflection = new \ReflectionClass(file::class);
		$controller = $reflection->newInstanceWithoutConstructor();
		$resolver = $reflection->getMethod('resolve_gallery_path');
		$expected_root = str_replace('\\', '/', dirname(__DIR__, 4));

		$this->assertSame(
			$expected_root . '/files/phpbbgallery/core/source/',
			$resolver->invoke($controller, './../files/phpbbgallery/core/source/')
		);
		$this->assertSame(
			$expected_root . '/ext/phpbbgallery/core/images/watermark.png',
			$resolver->invoke($controller, './../ext/phpbbgallery/core/images/watermark.png')
		);
	}

	public function test_existing_source_clears_a_stale_filemissing_flag(): void
	{
		$source_file = tempnam(sys_get_temp_dir(), 'gallery-source-');
		$this->assertNotFalse($source_file);
		file_put_contents($source_file, 'image');

		try
		{
			$reflection = new \ReflectionClass(file::class);
			$controller = $reflection->newInstanceWithoutConstructor();
			$filename = basename($source_file);
			$source_path = str_replace('\\', '/', dirname($source_file)) . '/';
			$reflection->getProperty('path_source')->setValue($controller, $source_path);
			$reflection->getProperty('path')->setValue($controller, $source_path);
			$reflection->getProperty('data')->setValue($controller, [
				'image_id' => 27,
				'image_filename' => $filename,
				'image_filemissing' => 1,
			]);
			$reflection->getProperty('error')->setValue($controller, '');
			$reflection->getProperty('table_images')->setValue($controller, 'gallery_images');

			$db = $this->createMock(\phpbb\db\driver\driver_interface::class);
			$db->expects($this->once())->method('sql_query')->with($this->callback(static function (string $sql): bool
			{
				return strpos($sql, 'SET image_filemissing = 0') !== false && strpos($sql, 'image_id = 27') !== false;
			}));
			$reflection->getProperty('db')->setValue($controller, $db);

			$config = new \phpbb\config\config(['phpbb_gallery_allow_hotlinking' => 1]);
			$reflection->getProperty('config')->setValue($controller, $config);

			$controller->generate_image_src();

			$data = $reflection->getProperty('data')->getValue($controller);
			$this->assertSame(0, $data['image_filemissing']);
			$this->assertSame($source_path . $filename, $reflection->getProperty('image_src')->getValue($controller));
		}
		finally
		{
			@unlink($source_file);
		}
	}

	public function test_error_images_are_loaded_from_the_packaged_error_directory(): void
	{
		$reflection = new \ReflectionClass(file::class);
		$controller = $reflection->newInstanceWithoutConstructor();
		$error_path = str_replace('\\', '/', dirname(__DIR__)) . '/images/upload/';
		$reflection->getProperty('path_error')->setValue($controller, $error_path);
		$reflection->getProperty('error')->setValue($controller, 'image_not_exist.jpg');
		$reflection->getProperty('data')->setValue($controller, ['image_filename' => 'image_not_exist.jpg']);
		$user = new \phpbb\user();
		$user->data['user_lang'] = 'en';
		$reflection->getProperty('user')->setValue($controller, $user);

		$controller->generate_image_src();

		$image_src = $reflection->getProperty('image_src')->getValue($controller);
		$this->assertSame($error_path . 'image_not_exist.jpg', $image_src);
		$this->assertFileExists($image_src);
	}

	public function test_remote_source_is_materialized_only_as_a_temporary_local_object(): void
	{
		$provider = new controller_storage_provider();
		$source = tempnam(sys_get_temp_dir(), 'gallery-remote-');
		$workspace_root = sys_get_temp_dir() . '/gallery-controller-' . bin2hex(random_bytes(6));
		file_put_contents($source, 'remote-image');
		$this->assertTrue($provider->write(provider_interface::SOURCE, 'image.jpg', $source));

		$reflection = new \ReflectionClass(file::class);
		$controller = $reflection->newInstanceWithoutConstructor();
		$reflection->getProperty('storage_workspace')->setValue($controller, new workspace($provider, $workspace_root));
		$reflection->getProperty('storage_variant')->setValue($controller, provider_interface::SOURCE);
		$reflection->getProperty('data')->setValue($controller, [
			'image_id' => 27,
			'image_filename' => 'image.jpg',
			'image_filemissing' => 0,
		]);
		$reflection->getProperty('error')->setValue($controller, '');
		$reflection->getProperty('config')->setValue($controller, new \phpbb\config\config([
			'phpbb_gallery_allow_hotlinking' => 1,
		]));

		try
		{
			$controller->generate_image_src();
			$object = $reflection->getProperty('image_object')->getValue($controller);
			$this->assertNotNull($object);
			$this->assertTrue($object->is_temporary());
			$this->assertSame('remote-image', file_get_contents($reflection->getProperty('image_src')->getValue($controller)));
			$object->release();
		}
		finally
		{
			@unlink($source);
			@rmdir($workspace_root);
		}
	}

	public function test_missing_derived_variant_is_generated_and_published(): void
	{
		$provider = new controller_storage_provider();
		$source = tempnam(sys_get_temp_dir(), 'gallery-source-');
		$workspace_root = sys_get_temp_dir() . '/gallery-controller-' . bin2hex(random_bytes(6));
		file_put_contents($source, 'source-image');
		$this->assertTrue($provider->write(provider_interface::SOURCE, 'image.jpg', $source));

		$tool = $this->createMock(\phpbbgallery\core\file\file::class);
		$tool->method('read_image')->willReturnCallback(function () use ($tool): bool
		{
			$tool->image_size = ['file' => 12, 'width' => 100, 'height' => 100];
			return true;
		});
		$tool->expects($this->once())->method('create_thumbnail');
		$tool->method('write_image')->willReturnCallback(static function (string $path): bool
		{
			file_put_contents($path, 'derived-image');
			return true;
		});

		$reflection = new \ReflectionClass(file::class);
		$controller = $reflection->newInstanceWithoutConstructor();
		$reflection->getProperty('storage_workspace')->setValue($controller, new workspace($provider, $workspace_root));
		$reflection->getProperty('storage_variant')->setValue($controller, provider_interface::MEDIUM);
		$reflection->getProperty('data')->setValue($controller, ['image_filename' => 'image.jpg']);
		$reflection->getProperty('image_src')->setValue($controller, '');
		$reflection->getProperty('tool')->setValue($controller, $tool);
		$reflection->getProperty('config')->setValue($controller, new \phpbb\config\config([
			'phpbb_gallery_jpg_quality' => 85,
		]));

		try
		{
			$reflection->getMethod('resize')->invoke($controller, 27, 50, 50);
			$this->assertTrue($provider->exists(provider_interface::MEDIUM, 'image.jpg'));
			$this->assertSame('derived-image', $provider->contents(provider_interface::MEDIUM, 'image.jpg'));
			$object = $reflection->getProperty('image_object')->getValue($controller);
			$this->assertNotNull($object);
			$object->release();
		}
		finally
		{
			@unlink($source);
			@rmdir($workspace_root);
		}
	}

	public function test_mini_derivative_uses_thumbnail_quality(): void
	{
		$provider = new controller_storage_provider();
		$source = tempnam(sys_get_temp_dir(), 'gallery-source-');
		$workspace_root = sys_get_temp_dir() . '/gallery-controller-' . bin2hex(random_bytes(6));
		file_put_contents($source, 'source-image');
		$this->assertTrue($provider->write(provider_interface::SOURCE, 'image.jpg', $source));

		$tool = $this->createMock(\phpbbgallery\core\file\file::class);
		$tool->method('read_image')->willReturnCallback(function () use ($tool): bool
		{
			$tool->image_size = ['file' => 12, 'width' => 100, 'height' => 100];
			return true;
		});
		$tool->expects($this->once())->method('create_thumbnail');
		$tool->expects($this->once())->method('write_image')
			->with($this->anything(), 45, false)
			->willReturnCallback(static function (string $path): bool
			{
				file_put_contents($path, 'mini-image');
				return true;
			});

		$reflection = new \ReflectionClass(file::class);
		$controller = $reflection->newInstanceWithoutConstructor();
		$reflection->getProperty('storage_workspace')->setValue($controller, new workspace($provider, $workspace_root));
		$reflection->getProperty('storage_variant')->setValue($controller, provider_interface::MINI);
		$reflection->getProperty('data')->setValue($controller, ['image_filename' => 'image.jpg']);
		$reflection->getProperty('image_src')->setValue($controller, '');
		$reflection->getProperty('tool')->setValue($controller, $tool);
		$reflection->getProperty('config')->setValue($controller, new \phpbb\config\config([
			'phpbb_gallery_jpg_quality' => 85,
			'phpbb_gallery_thumbnail_quality' => 45,
		]));

		try
		{
			$reflection->getMethod('resize')->invoke($controller, 28, 50, 50);
			$this->assertTrue($provider->exists(provider_interface::MINI, 'image.jpg'));
			$this->assertSame('mini-image', $provider->contents(provider_interface::MINI, 'image.jpg'));
			$object = $reflection->getProperty('image_object')->getValue($controller);
			$this->assertNotNull($object);
			$object->release();
		}
		finally
		{
			@unlink($source);
			@rmdir($workspace_root);
		}
	}
	public function test_external_source_is_converted_to_a_temporary_webp_before_watermarking(): void
	{
		$workspace_root = sys_get_temp_dir() . '/gallery-controller-' . bin2hex(random_bytes(6));
		$source = tempnam(sys_get_temp_dir(), 'gallery-external-');
		file_put_contents($source, 'external-image');

		$reflection = new \ReflectionClass(file::class);
		$controller = $reflection->newInstanceWithoutConstructor();
		$reflection->getProperty('storage_workspace')->setValue(
			$controller,
			new workspace(new controller_storage_provider(), $workspace_root)
		);
		$reflection->getProperty('data')->setValue($controller, [
			'image_filename' => 'image.tiff',
			'image_name' => 'External image',
		]);
		$reflection->getProperty('image_src')->setValue($controller, $source);
		$reflection->getProperty('config')->setValue($controller, new \phpbb\config\config([
			'phpbb_gallery_jpg_quality' => 85,
		]));
		$tool = (new \ReflectionClass(\phpbbgallery\core\file\file::class))->newInstanceWithoutConstructor();
		$reflection->getProperty('tool')->setValue($controller, $tool);

		try
		{
			$prepared = $reflection->getMethod('prepare_external_watermark_source')->invoke(
				$controller,
				new controller_external_processor(true),
				['extension' => 'tiff', 'mime' => 'image/tiff', 'width' => 320, 'height' => 240, 'filesize' => 14]
			);
			$object = $reflection->getProperty('response_object')->getValue($controller);

			$this->assertTrue($prepared);
			$this->assertNotNull($object);
			$this->assertTrue($object->is_temporary());
			$this->assertFileExists($object->get_path());
			$this->assertSame($object->get_path(), $tool->image_source);
			$this->assertSame('image/webp', $tool->image_content_type);
			$this->assertSame('webp', $tool->image_type);
			$object->release();
		}
		finally
		{
			@unlink($source);
			@rmdir($workspace_root);
		}
	}

	public function test_invalid_external_watermark_derivative_fails_closed_and_is_removed(): void
	{
		$workspace_root = sys_get_temp_dir() . '/gallery-controller-' . bin2hex(random_bytes(6));
		$source = tempnam(sys_get_temp_dir(), 'gallery-external-');
		file_put_contents($source, 'external-image');

		$reflection = new \ReflectionClass(file::class);
		$controller = $reflection->newInstanceWithoutConstructor();
		$reflection->getProperty('storage_workspace')->setValue(
			$controller,
			new workspace(new controller_storage_provider(), $workspace_root)
		);
		$reflection->getProperty('data')->setValue($controller, [
			'image_filename' => 'image.bmp',
			'image_name' => 'External image',
		]);
		$reflection->getProperty('image_src')->setValue($controller, $source);
		$reflection->getProperty('config')->setValue($controller, new \phpbb\config\config([
			'phpbb_gallery_jpg_quality' => 85,
		]));
		$reflection->getProperty('tool')->setValue(
			$controller,
			(new \ReflectionClass(\phpbbgallery\core\file\file::class))->newInstanceWithoutConstructor()
		);

		try
		{
			$this->assertFalse($reflection->getMethod('prepare_external_watermark_source')->invoke(
				$controller,
				new controller_external_processor(false),
				['extension' => 'bmp', 'mime' => 'image/bmp', 'width' => 320, 'height' => 240, 'filesize' => 14]
			));
			$this->assertNull($reflection->getProperty('response_object')->getValue($controller));
			$this->assertSame([], is_dir($workspace_root) ? array_values(array_diff(scandir($workspace_root), ['.', '..'])) : []);
		}
		finally
		{
			@unlink($source);
			@rmdir($workspace_root);
		}
	}

	public function test_response_cleanup_removes_inputs_and_defers_watermark_until_send(): void
	{
		$workspace_root = sys_get_temp_dir() . '/gallery-controller-' . bin2hex(random_bytes(6));
		$workspace = new workspace(new controller_storage_provider(), $workspace_root);
		$source_object = $workspace->create_temporary('source.bmp');
		$response_object = $workspace->create_temporary('converted.webp');
		file_put_contents($source_object->get_path(), 'source');
		file_put_contents($response_object->get_path(), 'converted');
		$dot = strrpos($response_object->get_path(), '.');
		$watermarked = substr_replace($response_object->get_path(), '_wm', $dot, 0);
		file_put_contents($watermarked, 'watermarked');

		$reflection = new \ReflectionClass(file::class);
		$controller = $reflection->newInstanceWithoutConstructor();
		$reflection->getProperty('image_object')->setValue($controller, $source_object);
		$reflection->getProperty('response_object')->setValue($controller, $response_object);
		$tool = (new \ReflectionClass(\phpbbgallery\core\file\file::class))->newInstanceWithoutConstructor();
		$tool->image_source = $watermarked;
		$reflection->getProperty('tool')->setValue($controller, $tool);
		$response = new \Symfony\Component\HttpFoundation\BinaryFileResponse($watermarked);

		try
		{
			$reflection->getMethod('release_response_objects')->invoke($controller, $response);
			$this->assertFileDoesNotExist($source_object->get_path());
			$this->assertFileDoesNotExist($response_object->get_path());
			$this->assertFileExists($watermarked);

			ob_start();
			$response->sendContent();
			ob_end_clean();
			$this->assertFileDoesNotExist($watermarked);
		}
		finally
		{
			@unlink($source_object->get_path());
			@unlink($response_object->get_path());
			@unlink($watermarked);
			@rmdir($workspace_root);
		}
	}

	public function test_inline_responses_always_disable_content_sniffing(): void
	{
		$image = tempnam(sys_get_temp_dir(), 'gallery-inline-');
		file_put_contents($image, 'image');
		$reflection = new \ReflectionClass(file::class);
		$controller = $reflection->newInstanceWithoutConstructor();
		$tool = (new \ReflectionClass(\phpbbgallery\core\file\file::class))->newInstanceWithoutConstructor();
		$tool->set_image_data($image, 'Browser image');
		$tool->image_content_type = 'image/png';
		$tool->image_type = 'png';
		$tool->disable_browser_cache();
		$tool_reflection = new \ReflectionClass($tool);
		$request = $this->createMock(\phpbb\request\request_interface::class);
		$request->method('server')->willReturn('');
		$tool_reflection->getProperty('request')->setValue($tool, $request);
		$reflection->getProperty('tool')->setValue($controller, $tool);
		$gallery_user = $this->createMock(\phpbbgallery\core\user::class);
		$gallery_user->method('get_data')->willReturn(0);
		$reflection->getProperty('gallery_user')->setValue($controller, $gallery_user);
		$reflection->getProperty('config')->setValue($controller, new \phpbb\config\config([
			'phpbb_gallery_watermark_changed' => 0,
		]));
		$user = new \phpbb\user();
		$user->browser = 'Mozilla/5.0';
		$reflection->getProperty('user')->setValue($controller, $user);
		$reflection->getProperty('storage_workspace')->setValue($controller, null);
		$reflection->getProperty('data')->setValue($controller, ['image_filename' => basename($image)]);
		$reflection->getProperty('error')->setValue($controller, '');
		$reflection->getProperty('use_watermark')->setValue($controller, false);

		try
		{
			$response = $controller->display();
			$this->assertSame('nosniff', $response->headers->get('X-Content-Type-Options'));
			$this->assertStringStartsWith('inline;', (string) $response->headers->get('Content-Disposition'));
		}
		finally
		{
			@unlink($image);
		}
	}

	private function set_language(\ReflectionClass $reflection, file $controller): void
	{
		$language = $this->createMock(\phpbb\language\language::class);
		$language->method('lang')->willReturnCallback(static fn (string $key): string => $key);
		$reflection->getProperty('language')->setValue($controller, $language);
	}
}

// phpcs:disable Generic.Files.OneClassPerFile.MultipleFound -- Provider double belongs to this controller test.
final class controller_storage_provider implements provider_interface
{
	private array $objects = [];

	public function get_id(): string
	{
		return 'remote-test';
	}

	public function prepare(string $variant, string $key): bool
	{
		return true;
	}

	public function write(string $variant, string $key, string $local_file): bool
	{
		if (isset($this->objects[$variant][$key]))
		{
			return false;
		}
		$contents = @file_get_contents($local_file);
		if ($contents === false)
		{
			return false;
		}
		$this->objects[$variant][$key] = $contents;
		return true;
	}

	public function replace(string $variant, string $key, string $local_file): bool
	{
		if (!isset($this->objects[$variant][$key]))
		{
			return false;
		}
		unset($this->objects[$variant][$key]);
		return $this->write($variant, $key, $local_file);
	}

	public function open_stream(string $variant, string $key): mixed
	{
		if (!isset($this->objects[$variant][$key]))
		{
			return false;
		}
		$stream = fopen('php://temp', 'w+b');
		fwrite($stream, $this->objects[$variant][$key]);
		rewind($stream);
		return $stream;
	}

	public function local_path(string $variant, string $key): ?string
	{
		return null;
	}

	public function exists(string $variant, string $key): bool
	{
		return isset($this->objects[$variant][$key]);
	}

	public function delete(string $variant, string $key): bool
	{
		unset($this->objects[$variant][$key]);
		return true;
	}

	public function size(string $variant, string $key): ?int
	{
		return isset($this->objects[$variant][$key]) ? strlen($this->objects[$variant][$key]) : null;
	}

	public function modified_time(string $variant, string $key): ?int
	{
		return $this->exists($variant, $key) ? 1785945600 : null;
	}

	public function list_objects(string $variant, ?string $cursor = null, int $limit = 500): array
	{
		return ['keys' => [], 'cursor' => null];
	}

	public function checksum(string $variant, string $key, string $algorithm = 'sha256'): ?string
	{
		return isset($this->objects[$variant][$key]) ? hash($algorithm, $this->objects[$variant][$key]) : null;
	}

	public function contents(string $variant, string $key): ?string
	{
		return $this->objects[$variant][$key] ?? null;
	}
}

final class controller_external_processor implements \phpbbgallery\core\image\external_processor_interface
{
	public function __construct(private bool $valid)
	{
	}

	public function inspect(string $source): ?array
	{
		return null;
	}

	public function prepare_source(string $source, array $options): ?array
	{
		return null;
	}

	public function create_derivative(string $source, string $destination, int $max_width, int $max_height, int $quality): ?array
	{
		if (!$this->valid)
		{
			return null;
		}

		file_put_contents($destination, 'webp');

		return ['extension' => 'webp', 'mime' => 'image/webp', 'width' => $max_width, 'height' => $max_height, 'filesize' => 4];
	}
}
