<?php

namespace forumhulp\uploadimage\tests;

use forumhulp\uploadimage\controller\admin_controller;
use PHPUnit\Framework\Attributes\IgnoreDeprecations;
use PHPUnit\Framework\TestCase;

class controller_security_test extends TestCase
{
	private admin_controller $controller;

	// phpcs:ignore PhpbbCodingStandard.NamingConventions.LowercaseUnderscoredFunctions.NotAllowed
	protected function setUp(): void
	{
		$this->controller = (new \ReflectionClass(admin_controller::class))->newInstanceWithoutConstructor();
	}

	public function test_filename_validation_rejects_traversal_and_non_images(): void
	{
		$this->assertSame('photo.jpg', $this->invoke('normalise_filename', ['photo.jpg']));
		$this->assertSame('férias 2026.PNG', $this->invoke('normalise_filename', ['férias 2026.PNG']));

		foreach (['../../config.php', '..\\..\\config.php', 'folder/photo.png', '.hidden.png', 'photo.svg', 'photo.png.php', ''] as $filename)
		{
			$this->assertNull($this->invoke('normalise_filename', [$filename]), $filename);
		}
	}

	public function test_folder_validation_accepts_only_a_direct_child_name(): void
	{
		foreach (['ui', 'images_2026', 'folder-name', 'A'] as $folder)
		{
			$this->assertTrue($this->invoke('valid_folder', [$folder]), $folder);
		}

		foreach (['../images', 'a/b', 'a\\b', '.hidden', 'with space', '', str_repeat('a', 65)] as $folder)
		{
			$this->assertFalse($this->invoke('valid_folder', [$folder]), $folder);
		}
	}

	public function test_image_content_must_match_the_filename_extension(): void
	{
		$path = tempnam(sys_get_temp_dir(), 'uploadimage_');
		$this->assertNotFalse($path);
		file_put_contents(
			$path,
			base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mNk+A8AAQUBAScY42YAAAAASUVORK5CYII=', true)
		);

		try
		{
			$this->assertTrue($this->invoke('valid_image_content', [$path, 'pixel.png']));
			$this->assertFalse($this->invoke('valid_image_content', [$path, 'pixel.jpg']));
		}
		finally
		{
			unlink($path);
		}
	}

	#[IgnoreDeprecations]
	public function test_attachment_state_is_rebuilt_from_files_on_disk(): void
	{
		$root = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'uploadimage_' . bin2hex(random_bytes(8));
		$directory = $root . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'ui';
		$this->assertTrue(mkdir($directory, 0777, true));
		$image = $directory . DIRECTORY_SEPARATOR . 'pixel.png';
		file_put_contents(
			$image,
			base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mNk+A8AAQUBAScY42YAAAAASUVORK5CYII=', true)
		);

		$config = new \phpbb\config\config(['uploadimage_folder' => 'ui']);
		$config_property = new \ReflectionProperty(admin_controller::class, 'config');
		$config_property->setValue($this->controller, $config);
		$root_property = new \ReflectionProperty(admin_controller::class, 'root_path');
		$root_property->setValue($this->controller, $root . DIRECTORY_SEPARATOR);

		try
		{
			$result = $this->controller->sanitise_attachment_data([
				5 => [
					'attach_id' => '123',
					'is_orphan' => '<script>',
					'real_filename' => 'pixel.png',
					'filesize' => 999999,
				],
				6 => ['attach_id' => '124', 'real_filename' => '../../config.php'],
				7 => ['attach_id' => '<script>', 'real_filename' => 'pixel.png'],
				8 => ['attach_id' => '125', 'real_filename' => 'missing.png'],
				9 => ['attach_id' => '126', 'real_filename' => 'pixel.png'],
			]);

			$this->assertSame([5], array_keys($result));
			$this->assertSame(123, $result[5]['attach_id']);
			$this->assertSame(1, $result[5]['is_orphan']);
			$this->assertSame('pixel.png', $result[5]['real_filename']);
			$this->assertSame(filesize($image), $result[5]['filesize']);
		}
		finally
		{
			unlink($image);
			rmdir($directory);
			rmdir(dirname($directory));
			rmdir($root);
		}
	}

	public function test_sorting_uses_image_records_and_both_directions(): void
	{
		$images = [
			['name' => 'Image 10', 'size' => 10, 'width' => 20, 'height' => 10],
			['name' => 'Image 2', 'size' => 30, 'width' => 10, 'height' => 30],
			['name' => 'Alpha', 'size' => 20, 'width' => 10, 'height' => 20],
		];

		$this->invoke_by_reference('sort_images', $images, 'n', 'a');
		$this->assertSame(['Alpha', 'Image 2', 'Image 10'], array_column($images, 'name'));

		$this->invoke_by_reference('sort_images', $images, 's', 'd');
		$this->assertSame([30, 20, 10], array_column($images, 'size'));
	}

	public function test_size_parser_handles_php_ini_units(): void
	{
		$this->assertSame(1024, $this->invoke('parse_size', ['1K']));
		$this->assertSame(2097152, $this->invoke('parse_size', ['2M']));
		$this->assertSame(3221225472, $this->invoke('parse_size', ['3G']));
		$this->assertSame(0, $this->invoke('parse_size', ['invalid']));
	}

	private function invoke(string $method, array $arguments = [])
	{
		$reflection = new \ReflectionMethod(admin_controller::class, $method);

		return $reflection->invokeArgs($this->controller, $arguments);
	}

	private function invoke_by_reference(
		string $method,
		array &$images,
		string $sort_key,
		string $sort_direction
	): void
	{
		$reflection = new \ReflectionMethod(admin_controller::class, $method);
		$arguments = [&$images, $sort_key, $sort_direction];
		$reflection->invokeArgs($this->controller, $arguments);
	}
}
