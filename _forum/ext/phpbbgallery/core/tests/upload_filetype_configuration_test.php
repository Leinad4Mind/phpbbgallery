<?php
// phpcs:disable Generic.Files.OneClassPerFile.MultipleFound -- Focused test doubles share this fixture.
/**
 * phpBB Gallery - Configured upload file type tests
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\tests;

use phpbbgallery\core\upload;
use PHPUnit\Framework\TestCase;

final class upload_filetype_configuration_test extends TestCase
{
	public function test_only_acp_enabled_extensions_are_returned_and_given_to_phpbb(): void
	{
		$config = new upload_filetype_test_config([
			'allow_jpg' => true,
			'allow_gif' => false,
			'allow_png' => true,
			'allow_webp' => true,
			'allow_zip' => true,
			'allow_resize' => false,
			'max_filesize' => 512000,
		]);
		$file_upload = new upload_filetype_test_handler();
		$upload = $this->new_upload($config, $file_upload);

		$this->assertSame(['jpg', 'jpeg', 'png', 'webp', 'zip'], $upload->get_allowed_types());
		$this->assertSame(['jpg', 'png', 'webp', 'zip'], $upload->get_allowed_types(true));

		$upload->set_up(4, 2);

		$this->assertSame(['jpg', 'jpeg', 'png', 'webp', 'zip'], $file_upload->allowed_extensions);
		$this->assertSame(512000, $file_upload->max_filesize);
	}

	public function test_disabling_every_type_leaves_the_backend_allowlist_empty(): void
	{
		$config = new upload_filetype_test_config([
			'allow_resize' => false,
			'max_filesize' => 512000,
		]);
		$file_upload = new upload_filetype_test_handler();
		$upload = $this->new_upload($config, $file_upload);

		$upload->set_up(4);

		$this->assertSame([], $upload->get_allowed_types());
		$this->assertSame([], $file_upload->allowed_extensions);
	}

	public function test_controller_builds_native_and_javascript_filters_from_raw_extensions(): void
	{
		$source = (string) file_get_contents(dirname(__DIR__) . '/controller/upload.php');

		$this->assertStringContainsString('$allowed_extensions = $process->get_allowed_types();', $source);
		$this->assertStringContainsString("'S_ALLOWED_FILETYPES_ACCEPT'", $source);
		$this->assertStringContainsString("'S_QUICK_FILE_TYPES'", $source);
		$this->assertStringContainsString("array_map('preg_quote', \$allowed_extensions)", $source);
		$this->assertStringNotContainsString("if (\$filetype == 'zip')", $source);
	}

	private function new_upload(upload_filetype_test_config $config, upload_filetype_test_handler $file_upload): upload
	{
		$upload = (new \ReflectionClass(upload::class))->newInstanceWithoutConstructor();
		$this->set_property($upload, 'gallery_config', $config);
		$this->set_property($upload, 'file_upload', $file_upload);
		$this->set_property($upload, 'language', new upload_filetype_test_language());
		$this->set_property($upload, 'user', (object) ['data' => ['username' => 'Uploader']]);

		return $upload;
	}

	private function set_property(object $object, string $property_name, mixed $value): void
	{
		$property = new \ReflectionProperty($object, $property_name);
		$property->setValue($object, $value);
	}
}

final class upload_filetype_test_config
{
	public function __construct(private array $values)
	{
	}

	public function get(string $key): mixed
	{
		return $this->values[$key] ?? false;
	}
}

final class upload_filetype_test_handler
{
	public array $allowed_extensions = [];
	public int $max_filesize = 0;

	public function set_allowed_extensions(array $extensions): void
	{
		$this->allowed_extensions = $extensions;
	}

	public function set_max_filesize(int $max_filesize): void
	{
		$this->max_filesize = $max_filesize;
	}
}

final class upload_filetype_test_language
{
	public function lang(string $key): string
	{
		return strtolower(substr($key, strlen('FILETYPES_')));
	}
}
