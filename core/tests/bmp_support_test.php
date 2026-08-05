<?php
/**
 * phpBB Gallery BMP support tests.
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\tests;

use phpbbgallery\acpimport\acp\import_storage;
use phpbbgallery\core\event\image_format_listener;
use phpbbgallery\core\image\bmp_processor;
use phpbbgallery\core\image\format_registry;
use phpbbgallery\core\zip\extractor;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;

final class bmp_support_test extends TestCase
{
	private string $directory;

	// phpcs:ignore PhpbbCodingStandard.NamingConventions.LowercaseUnderscoredFunctions.NotAllowed -- PHPUnit lifecycle API.
	protected function setUp(): void
	{
		if (!bmp_processor::is_supported())
		{
			$this->markTestSkipped('BMP and WebP GD support is unavailable.');
		}
		$this->directory = sys_get_temp_dir() . '/phpbbgallery-bmp-' . bin2hex(random_bytes(6));
		mkdir($this->directory);
	}

	// phpcs:ignore PhpbbCodingStandard.NamingConventions.LowercaseUnderscoredFunctions.NotAllowed -- PHPUnit lifecycle API.
	protected function tearDown(): void
	{
		if (isset($this->directory))
		{
			$this->remove_directory($this->directory);
		}
	}

	public function test_processor_inspects_complete_bmp_and_rejects_spoofed_content(): void
	{
		$source = $this->write_bmp($this->directory . '/valid.bmp', 16, 12);
		$metadata = (new bmp_processor())->inspect($source);

		$this->assertSame('bmp', $metadata['extension']);
		$this->assertSame('image/bmp', $metadata['mime']);
		$this->assertSame(16, $metadata['width']);
		$this->assertSame(12, $metadata['height']);
		$this->assertGreaterThan(0, $metadata['filesize']);
		file_put_contents($this->directory . '/spoofed.bmp', $this->png_bytes());
		$this->assertNull((new bmp_processor())->inspect($this->directory . '/spoofed.bmp'));
		file_put_contents($this->directory . '/broken.bmp', 'BMtruncated');
		$this->assertNull((new bmp_processor())->inspect($this->directory . '/broken.bmp'));
	}

	public function test_processor_creates_bounded_webp_derivative(): void
	{
		$source = $this->write_bmp($this->directory . '/source.bmp', 16, 12);
		$destination = $this->directory . '/derived.webp';
		$metadata = (new bmp_processor())->create_derivative($source, $destination, 8, 8, 82);

		$this->assertSame([
			'extension' => 'webp',
			'mime' => 'image/webp',
			'width' => 8,
			'height' => 6,
			'filesize' => (int) filesize($destination),
		], $metadata);
		$this->assertSame(IMAGETYPE_WEBP, getimagesize($destination)[2]);
	}

	public function test_processor_resizes_and_rotates_source_atomically(): void
	{
		$source = $this->write_bmp($this->directory . '/rotate.bmp', 20, 10);
		$metadata = (new bmp_processor())->prepare_source($source, [
			'max_width' => 10,
			'max_height' => 10,
			'max_filesize' => 1048576,
			'allow_resize' => true,
			'rotation' => 90,
		]);

		$this->assertSame('bmp', $metadata['extension']);
		$this->assertSame(5, $metadata['width']);
		$this->assertSame(10, $metadata['height']);
		$this->assertSame(IMAGETYPE_BMP, getimagesize($source)[2]);
		$this->assertSame([], glob($source . '.tmp-*') ?: []);
	}

	public function test_processor_rejects_disallowed_transform_without_changing_source(): void
	{
		$source = $this->write_bmp($this->directory . '/unchanged.bmp', 20, 10);
		$checksum = hash_file('sha256', $source);

		$this->assertNull((new bmp_processor())->prepare_source($source, [
			'max_width' => 10,
			'max_height' => 10,
			'max_filesize' => 1048576,
			'allow_resize' => false,
			'rotation' => 0,
		]));
		$this->assertSame($checksum, hash_file('sha256', $source));
	}

	public function test_listener_keeps_existing_bmp_readable_when_upload_is_disabled(): void
	{
		$language = $this->createMock(\phpbb\language\language::class);
		$language->expects($this->never())->method('add_lang');
		$event = new \phpbb\event\data(['formats' => []]);
		(new image_format_listener(
			new \phpbbgallery\core\config(new \phpbb\config\config(['phpbb_gallery_allow_bmp' => 0])),
			$language
		))->register_formats($event);

		$this->assertFalse($event['formats']['bmp']['upload']);
		$this->assertSame('image/bmp', $event['formats']['bmp']['mime']);
		$this->assertSame('phpbbgallery.core.image.bmp_processor', $event['formats']['bmp']['service']);
	}

	public function test_enabled_listener_exposes_bmp_to_upload_and_loads_language(): void
	{
		$language = $this->createMock(\phpbb\language\language::class);
		$language->expects($this->once())->method('add_lang')->with('gallery', 'phpbbgallery/core');
		$event = new \phpbb\event\data(['formats' => []]);
		(new image_format_listener(
			new \phpbbgallery\core\config(new \phpbb\config\config(['phpbb_gallery_allow_bmp' => 1])),
			$language
		))->register_formats($event);

		$this->assertTrue($event['formats']['bmp']['upload']);
	}

	public function test_upload_allowlist_and_browser_filter_follow_bmp_setting(): void
	{
		$upload = (new \ReflectionClass(\phpbbgallery\core\upload::class))->newInstanceWithoutConstructor();
		$config = new \phpbbgallery\core\config(new \phpbb\config\config([
			'phpbb_gallery_allow_jpg' => 0,
			'phpbb_gallery_allow_gif' => 0,
			'phpbb_gallery_allow_png' => 0,
			'phpbb_gallery_allow_webp' => 0,
			'phpbb_gallery_allow_avif' => 0,
			'phpbb_gallery_allow_bmp' => 1,
			'phpbb_gallery_allow_zip' => 0,
		]));
		$language = $this->createMock(\phpbb\language\language::class);
		$language->method('lang')->willReturnCallback(static fn(string $key): string => $key === 'FILETYPES_BMP' ? 'bmp' : $key);
		$this->set_property($upload, 'gallery_config', $config);
		$this->set_property($upload, 'language', $language);
		$this->set_property($upload, 'format_registry', $this->registry(true));
		$this->set_property($upload, 'allow_zip', true);

		$this->assertSame(['bmp'], $upload->get_allowed_types());
		$this->assertSame(['bmp'], $upload->get_allowed_types(true));
	}

	public function test_acp_import_uses_verified_bmp_processor(): void
	{
		$this->write_bmp($this->directory . '/accented-name.bmp', 16, 12);
		$storage = new import_storage($this->directory, $this->registry(true));
		$image = $storage->resolve_image('accented-name.bmp', ['bmp']);

		$this->assertIsArray($image);
		$inspection = $storage->inspect_image($image);
		$this->assertSame('', $inspection['error']);
		$this->assertSame('.bmp', $inspection['target_extension']);
		$this->assertSame('image/bmp', $inspection['image_info']['mime']);
	}

	public function test_zip_extractor_accepts_verified_bmp_and_rejects_spoofed_content(): void
	{
		if (!class_exists(\ZipArchive::class))
		{
			$this->markTestSkipped('The ZIP extension is unavailable.');
		}
		$source = $this->write_bmp($this->directory . '/source.bmp', 16, 12);
		$archive = $this->directory . '/images.zip';
		$zip = new \ZipArchive();
		$this->assertTrue($zip->open($archive, \ZipArchive::CREATE | \ZipArchive::OVERWRITE));
		$this->assertTrue($zip->addFile($source, 'valid.bmp'));
		$this->assertTrue($zip->addFromString('spoofed.bmp', 'not an image'));
		$this->assertTrue($zip->close());
		$target = $this->directory . '/out/';
		mkdir($target);
		$language = $this->createMock(\phpbb\language\language::class);
		$language->method('lang')->willReturnCallback(static fn(string $key): string => $key);
		$extractor = new extractor($language, $this->registry(true));

		$this->assertFalse($extractor->extract(
			$archive,
			$target,
			['bmp'],
			extractor::limits(10, 2097152),
			static fn(array $entry, int $index): string => $index . '.bmp'
		));
		$this->assertFileExists($target . '0.bmp');
		$this->assertFileDoesNotExist($target . '1.bmp');
	}

	public function test_service_and_acp_configuration_are_wired(): void
	{
		$services = (string) file_get_contents(dirname(__DIR__) . '/config/services.yml');
		$config_module = (string) file_get_contents(dirname(__DIR__) . '/acp/config_module.php');

		$this->assertStringContainsString('phpbbgallery.core.image.bmp_processor:', $services);
		$this->assertStringContainsString('phpbbgallery.core.image_format_listener:', $services);
		$this->assertStringContainsString("'allow_bmp'", $config_module);
		$this->assertStringContainsString('BMP_NOT_SUPPORTED', $config_module);
	}

	private function registry(bool $upload): format_registry
	{
		$processor = new bmp_processor();
		$dispatcher = new class($upload) implements \phpbb\event\dispatcher_interface {
			public function __construct(private bool $upload)
			{
			}

			public function trigger_event($event_name, $data = [])
			{
				$data['formats']['bmp'] = [
					'service' => 'phpbbgallery.core.image.bmp_processor',
					'mime' => 'image/bmp',
					'label' => 'FILETYPES_BMP',
					'upload' => $this->upload,
				];

				return $data;
			}
		};
		$container = $this->createMock(ContainerInterface::class);
		$container->method('has')->with('phpbbgallery.core.image.bmp_processor')->willReturn(true);
		$container->method('get')->with('phpbbgallery.core.image.bmp_processor')->willReturn($processor);

		return new format_registry($dispatcher, $container);
	}

	private function write_bmp(string $path, int $width, int $height): string
	{
		$image = imagecreatetruecolor($width, $height);
		$colour = imagecolorallocate($image, 32, 96, 160);
		imagefilledrectangle($image, 0, 0, $width, $height, $colour);
		$this->assertTrue(imagebmp($image, $path, true));
		$image = null;

		return $path;
	}

	private function set_property(object $object, string $property, mixed $value): void
	{
		(new \ReflectionProperty($object, $property))->setValue($object, $value);
	}

	private function png_bytes(): string
	{
		$image = imagecreatetruecolor(2, 2);
		ob_start();
		imagepng($image);
		$contents = (string) ob_get_clean();
		$image = null;

		return $contents;
	}

	private function remove_directory(string $directory): void
	{
		if (!is_dir($directory))
		{
			return;
		}
		foreach (scandir($directory) ?: [] as $name)
		{
			if ($name === '.' || $name === '..')
			{
				continue;
			}
			$path = $directory . '/' . $name;
			if (is_dir($path) && !is_link($path))
			{
				$this->remove_directory($path);
			}
			else
			{
				unlink($path);
			}
		}
		rmdir($directory);
	}
}
