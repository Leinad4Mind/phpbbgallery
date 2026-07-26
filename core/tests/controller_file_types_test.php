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

	private function set_language(\ReflectionClass $reflection, file $controller): void
	{
		$language = $this->createMock(\phpbb\language\language::class);
		$language->method('lang')->willReturnCallback(static fn (string $key): string => $key);
		$reflection->getProperty('language')->setValue($controller, $language);
	}
}
