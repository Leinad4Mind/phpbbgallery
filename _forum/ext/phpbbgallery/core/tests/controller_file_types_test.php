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

		foreach (['source', 'medium', 'mini'] as $method_name)
		{
			$method = $reflection->getMethod($method_name);
			$this->assertSame('int', (string) $method->getParameters()[0]->getType());
			$this->assertSame('Symfony\\Component\\HttpFoundation\\BinaryFileResponse', (string) $method->getReturnType());
		}
	}

	public function test_original_source_has_an_extension_gate_and_forces_download_disposition(): void
	{
		$source = file_get_contents(dirname(__DIR__) . '/controller/file.php');
		$services = file_get_contents(dirname(__DIR__) . '/config/services_controller.yml');

		$this->assertStringContainsString('phpbbgallery.core.file.source_access', $source);
		$this->assertStringContainsString('return $this->display(true);', $source);
		$this->assertStringContainsString('if ($attachment || empty($this->user->browser)', $source);
		$this->assertStringContainsString('Original-source access may be user-specific', $source);
		$this->assertStringContainsString('$this->tool->disable_browser_cache();', $source);
		$file_service = strstr($services, 'phpbbgallery.core.controller.file:');
		$file_service = strstr($file_service, 'phpbbgallery.core.controller.image:', true);
		$this->assertStringContainsString("- '@dispatcher'", $file_service);
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
		$tool->method('write_image')->willReturnCallback(static function (string $path): void
		{
			file_put_contents($path, 'derived-image');
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
