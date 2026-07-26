<?php
/**
 * phpBB Gallery - Core file service tests
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\tests;

use phpbbgallery\core\file\file;
use phpbbgallery\core\file\types\multiform;
use PHPUnit\Framework\TestCase;

final class domain_file_types_test extends TestCase
{
	public function test_file_service_properties_parameters_and_returns_are_fully_typed(): void
	{
		$this->assert_class_types(file::class);
	}

	public function test_multiform_declared_properties_parameters_and_returns_are_fully_typed(): void
	{
		$this->assert_class_types(multiform::class);
	}

	public function test_filename_type_detection_is_case_insensitive_and_fail_closed(): void
	{
		$this->assertSame('image/jpeg', file::mimetype_by_filename('Photo.JPEG'));
		$this->assertSame('jpg', file::extension_by_filename('Photo.JPEG'));
		$this->assertSame('image/webp', file::mimetype_by_filename('preview.WEBP'));
		$this->assertSame('', file::mimetype_by_filename('archive.zip'));
		$this->assertSame('', file::extension_by_filename('archive.zip'));
	}

	public function test_image_state_can_be_reset_before_reusing_the_service(): void
	{
		$reflection = new \ReflectionClass(file::class);
		$file = $reflection->newInstanceWithoutConstructor();
		$file->image = 'legacy-handle';
		$file->image_content_type = 'image/png';
		$file->image_size = ['file' => 99, 'width' => 10, 'height' => 10];
		$file->image_type = 'png';
		$file->resized = true;
		$file->rotated = true;
		$file->watermarked = true;

		$file->set_image_data('missing.jpg', 'Missing', 12, true);

		$this->assertNull($file->image);
		$this->assertSame('', $file->image_content_type);
		$this->assertSame(['file' => 12], $file->image_size);
		$this->assertSame('', $file->image_type);
		$this->assertFalse($file->resized);
		$this->assertFalse($file->rotated);
		$this->assertFalse($file->watermarked);
		$this->assertFalse($file->read_image());
	}

	public function test_multiform_without_a_form_name_returns_an_empty_upload_collection(): void
	{
		$multiform = (new \ReflectionClass(multiform::class))->newInstanceWithoutConstructor();

		$this->assertSame([], $multiform->upload());
	}

	private function assert_class_types(string $class_name): void
	{
		$reflection = new \ReflectionClass($class_name);

		foreach ($reflection->getProperties() as $property)
		{
			if ($property->getDeclaringClass()->getName() === $class_name)
			{
				$this->assertNotNull($property->getType(), $class_name . '::$' . $property->getName());
			}
		}

		foreach ($reflection->getMethods() as $method)
		{
			if ($method->getDeclaringClass()->getName() !== $class_name)
			{
				continue;
			}

			foreach ($method->getParameters() as $parameter)
			{
				$this->assertNotNull($parameter->getType(), $class_name . '::' . $method->getName() . '($' . $parameter->getName() . ')');
			}

			if (!$method->isConstructor())
			{
				$this->assertNotNull($method->getReturnType(), $class_name . '::' . $method->getName() . '()');
			}
		}
	}
}
