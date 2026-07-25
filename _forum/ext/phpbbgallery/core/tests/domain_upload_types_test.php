<?php
/**
 * phpBB Gallery - Core upload domain tests
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\tests;

use phpbbgallery\core\upload;
use PHPUnit\Framework\TestCase;

final class domain_upload_types_test extends TestCase
{
	public function test_upload_properties_parameters_and_returns_are_fully_typed(): void
	{
		$reflection = new \ReflectionClass(upload::class);

		foreach ($reflection->getProperties() as $property)
		{
			if ($property->getDeclaringClass()->getName() === upload::class)
			{
				$this->assertNotNull($property->getType(), upload::class . '::$' . $property->getName());
			}
		}

		foreach ($reflection->getMethods() as $method)
		{
			if ($method->getDeclaringClass()->getName() !== upload::class)
			{
				continue;
			}

			foreach ($method->getParameters() as $parameter)
			{
				$this->assertNotNull($parameter->getType(), upload::class . '::' . $method->getName() . '($' . $parameter->getName() . ')');
			}

			if (!$method->isConstructor())
			{
				$this->assertNotNull($method->getReturnType(), upload::class . '::' . $method->getName() . '()');
			}
		}
	}

	public function test_upload_contracts_expose_explicit_results(): void
	{
		$this->assertSame('bool', (string) (new \ReflectionMethod(upload::class, 'upload_file'))->getReturnType());
		$this->assertContains((string) (new \ReflectionMethod(upload::class, 'prepare_file'))->getReturnType(), ['int|false', 'false|int']);
		$this->assertSame('int', (string) (new \ReflectionMethod(upload::class, 'load_pending_images'))->getReturnType());
		$this->assertSame('int', (string) (new \ReflectionMethod(upload::class, 'discard_pending_images'))->getReturnType());
		$this->assertTrue((new \ReflectionClassConstant(upload::class, 'NUM_FILES_PER_DIR'))->isPublic());
	}

	public function test_empty_multiform_upload_has_an_explicit_success_result(): void
	{
		$upload = $this->new_upload();
		$this->set_property($upload, 'file_upload', new class
		{
			public function handle_upload(string $type, string $form_name): array
			{
				return [];
			}
		});

		$this->assertTrue($upload->upload_file(1));
	}

	public function test_optional_metadata_has_safe_defaults(): void
	{
		$upload = $this->new_upload();

		$this->assertSame('', $upload->get_name());
		$this->assertSame('', $upload->get_description());

		$upload->set_names(['Photo {NUM}', 'Photo {NUM}']);
		$upload->set_descriptions([]);
		$upload->set_image_num(4);
		$upload->use_same_name(true);

		$this->assertSame(['Photo 4', 'Photo 5'], $this->get_property($upload, 'file_names'));
		$this->assertSame(['', ''], $this->get_property($upload, 'file_descriptions'));
	}

	public function test_rotation_and_hidden_field_state_remain_stable(): void
	{
		$upload = $this->new_upload();
		$upload->set_rotating([90, 45]);

		$this->assertSame(90, $upload->get_rotating());
		$this->set_property($upload, 'file_count', 1);
		$this->assertSame(0, $upload->get_rotating());

		$upload->images = [7, 9];
		$upload->image_data = [
			7 => ['image_filename' => 'first.jpg'],
			9 => ['image_filename' => 'second.png'],
		];
		$this->assertSame(['7$first.jpg', '9$second.png'], $upload->generate_hidden_fields());
	}

	private function new_upload(): upload
	{
		return (new \ReflectionClass(upload::class))->newInstanceWithoutConstructor();
	}

	private function set_property(upload $upload, string $name, mixed $value): void
	{
		(new \ReflectionProperty(upload::class, $name))->setValue($upload, $value);
	}

	private function get_property(upload $upload, string $name): mixed
	{
		return (new \ReflectionProperty(upload::class, $name))->getValue($upload);
	}
}
