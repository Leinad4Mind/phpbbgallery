<?php
// phpcs:disable Generic.Files.OneClassPerFile.MultipleFound -- Focused upload test double shares this fixture.
/**
 * phpBB Gallery - Programmatic local upload tests
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\tests;

use phpbbgallery\core\file\file;
use phpbbgallery\core\upload;
use PHPUnit\Framework\TestCase;

final class programmatic_upload_test extends TestCase
{
	public function test_local_file_uses_phpbb_validation_and_registers_the_created_orphan(): void
	{
		$source_path = tempnam(sys_get_temp_dir(), 'gallery-programmatic-');
		$this->assertNotFalse($source_path);
		file_put_contents($source_path, 'temporary image fixture');

		try
		{
			$handler = new programmatic_upload_handler();
			$tools = (new \ReflectionClass(file::class))->newInstanceWithoutConstructor();
			$upload = new programmatic_upload_service();
			$this->set_property($upload, 'file_upload', $handler);
			$this->set_property($upload, 'tools', $tools);

			$image_id = $upload->upload_local_file($source_path, '../provider/poster.jpg', 3);

			$this->assertSame(81, $image_id);
			$this->assertSame('files.types.local', $handler->upload_type);
			$this->assertSame($source_path, $handler->source_path);
			$this->assertSame('poster.jpg', $handler->file_info['realname']);
			$this->assertSame('image/jpeg', $handler->file_info['type']);
			$this->assertSame([81], $upload->images);
			$this->assertSame([81 => 3], $upload->array_id2row);
			$this->assertSame(1, $upload->uploaded_files);
		}
		finally
		{
			@unlink($source_path);
		}
	}

	public function test_reset_operation_clears_state_between_worker_imports(): void
	{
		$upload = new programmatic_upload_service();
		$upload->images = [1, 2];
		$upload->image_data = [1 => ['image_id' => 1]];
		$upload->array_id2row = [1 => 0];
		$upload->errors = ['failed'];
		$upload->loaded_files = 2;
		$upload->uploaded_files = 2;

		$upload->reset_operation();

		$this->assertSame([], $upload->images);
		$this->assertSame([], $upload->image_data);
		$this->assertSame([], $upload->array_id2row);
		$this->assertSame([], $upload->errors);
		$this->assertSame(0, $upload->loaded_files);
		$this->assertSame(0, $upload->uploaded_files);
	}

	private function set_property(object $object, string $property_name, mixed $value): void
	{
		$property = new \ReflectionProperty(upload::class, $property_name);
		$property->setValue($object, $value);
	}
}

final class programmatic_upload_service extends upload
{
	public function __construct()
	{
	}

	public function prepare_file(): int|false
	{
		return 81;
	}
}

final class programmatic_upload_handler
{
	public string $upload_type = '';
	public string $source_path = '';
	public array $file_info = [];

	public function handle_upload(string $upload_type, string $source_path, array $file_info): object
	{
		$this->upload_type = $upload_type;
		$this->source_path = $source_path;
		$this->file_info = $file_info;

		return new \stdClass();
	}
}
