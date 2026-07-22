<?php
/**
 * phpBB Gallery - Core image domain tests
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\tests;

use phpbbgallery\core\image\image;
use PHPUnit\Framework\TestCase;

final class domain_image_types_test extends TestCase
{
	public function test_image_domain_properties_and_methods_are_fully_typed(): void
	{
		$reflection = new \ReflectionClass(image::class);

		foreach ($reflection->getProperties() as $property)
		{
			if ($property->getDeclaringClass()->getName() === image::class)
			{
				$this->assertNotNull($property->getType(), image::class . '::$' . $property->getName());
			}
		}

		foreach ($reflection->getMethods() as $method)
		{
			if ($method->getDeclaringClass()->getName() !== image::class)
			{
				continue;
			}

			foreach ($method->getParameters() as $parameter)
			{
				$this->assertNotNull($parameter->getType(), image::class . '::' . $method->getName() . '($' . $parameter->getName() . ')');
			}

			if (!$method->isConstructor())
			{
				$this->assertNotNull($method->getReturnType(), image::class . '::' . $method->getName() . '()');
			}
		}
	}

	public function test_image_domain_return_contracts_are_explicit(): void
	{
		$this->assertSame('array|false', (string) (new \ReflectionMethod(image::class, 'get_new_author_info'))->getReturnType());
		$this->assertSame('bool', (string) (new \ReflectionMethod(image::class, 'delete_images'))->getReturnType());
		$this->assertSame('array', (string) (new \ReflectionMethod(image::class, 'get_filenames'))->getReturnType());
		$this->assertSame('string', (string) (new \ReflectionMethod(image::class, 'generate_link'))->getReturnType());
		$this->assertSame('void', (string) (new \ReflectionMethod(image::class, 'handle_counter'))->getReturnType());
		$this->assertSame('array|false', (string) (new \ReflectionMethod(image::class, 'get_image_data'))->getReturnType());
		$this->assertSame('array|false', (string) (new \ReflectionMethod(image::class, 'get_last_image'))->getReturnType());
		$this->assertSame('void', (string) (new \ReflectionMethod(image::class, 'assign_block'))->getReturnType());
	}

	public function test_empty_image_operations_have_stable_results_without_dependencies(): void
	{
		$image = (new \ReflectionClass(image::class))->newInstanceWithoutConstructor();

		$this->assertFalse($image->get_new_author_info(''));
		$this->assertFalse($image->delete_images([]));
		$this->assertSame([], $image->get_filenames([]));
		$this->assertFalse($image->get_image_data(0));
		$this->assertNull($image->handle_counter([], true));
	}

	public function test_missing_image_database_row_returns_false(): void
	{
		$reflection = new \ReflectionClass(image::class);
		$image = $reflection->newInstanceWithoutConstructor();
		$db = $this->createMock(\phpbb\db\driver\driver_interface::class);
		$db->expects($this->once())
			->method('sql_query')
			->with('SELECT * FROM gallery_images WHERE image_id = 99')
			->willReturn('result');
		$db->expects($this->once())
			->method('sql_fetchrow')
			->with('result')
			->willReturn(false);
		$db->expects($this->once())
			->method('sql_freeresult')
			->with('result');

		$reflection->getProperty('db')->setValue($image, $db);
		$reflection->getProperty('table_images')->setValue($image, 'gallery_images');

		$this->assertFalse($image->get_image_data(99));
	}

	public function test_image_display_bitmask_values_remain_stable(): void
	{
		$this->assertSame(128, image::IMAGE_SHOW_IP);
		$this->assertSame(64, image::IMAGE_SHOW_RATINGS);
		$this->assertSame(32, image::IMAGE_SHOW_USERNAME);
		$this->assertSame(16, image::IMAGE_SHOW_VIEWS);
		$this->assertSame(8, image::IMAGE_SHOW_TIME);
		$this->assertSame(4, image::IMAGE_SHOW_IMAGENAME);
		$this->assertSame(2, image::IMAGE_SHOW_COMMENTS);
		$this->assertSame(1, image::IMAGE_SHOW_ALBUM);
	}
}
