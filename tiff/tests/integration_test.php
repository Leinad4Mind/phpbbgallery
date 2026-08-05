<?php
// phpcs:disable Generic.Files.OneClassPerFile.MultipleFound -- Focused test doubles share this fixture.
/**
 * phpBB Gallery - TIFF integration contract tests
 *
 * @package   phpbbgallery/tiff
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\tiff\tests;

use phpbbgallery\acpimport\acp\import_storage;
use phpbbgallery\core\image\format_registry;
use phpbbgallery\core\zip\extractor;
use phpbbgallery\tiff\event\listener;
use phpbbgallery\tiff\migrations\m1_init;
use phpbbgallery\tiff\processor;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;

final class integration_test extends TestCase
{
	public function test_listener_registers_both_extensions_only_when_enabled(): void
	{
		$language = $this->createMock(\phpbb\language\language::class);
		$language->expects($this->once())->method('add_lang')->with('tiff', 'phpbbgallery/tiff');
		$event = new \phpbb\event\data(['formats' => []]);
		(new listener(new \phpbb\config\config(['phpbb_gallery_tiff_enabled' => 1]), $language))->register_formats($event);

		$this->assertSame(['tif', 'tiff'], array_keys($event['formats']));
		$this->assertSame('phpbbgallery.tiff.processor', $event['formats']['tiff']['service']);
		$this->assertSame('image/tiff', $event['formats']['tif']['mime']);
		$this->assertTrue($event['formats']['tif']['upload']);
	}

	public function test_disabled_upload_keeps_existing_tiff_images_readable(): void
	{
		$language = $this->createMock(\phpbb\language\language::class);
		$language->expects($this->never())->method('add_lang');
		$event = new \phpbb\event\data(['formats' => ['existing' => ['safe']]]);
		(new listener(new \phpbb\config\config(['phpbb_gallery_tiff_enabled' => 0]), $language))->register_formats($event);

		$this->assertArrayHasKey('existing', $event['formats']);
		$this->assertFalse($event['formats']['tif']['upload']);
		$this->assertFalse($event['formats']['tiff']['upload']);
	}

	public function test_migration_is_opt_in_and_reversible(): void
	{
		$migration = (new \ReflectionClass(m1_init::class))->newInstanceWithoutConstructor();

		$this->assertSame(['\phpbbgallery\core\migrations\avif_support'], m1_init::depends_on());
		$this->assertContains(['config.add', ['phpbb_gallery_tiff_enabled', 0]], $migration->update_data());
		$this->assertContains(['config.add', ['phpbb_gallery_tiff_webp_quality', 82]], $migration->update_data());
		$this->assertContains(['config.remove', ['phpbb_gallery_tiff_enabled']], $migration->revert_data());
	}

	public function test_package_declares_imagick_and_core_extension_contract(): void
	{
		$root = dirname(__DIR__);
		$composer = json_decode((string) file_get_contents($root . '/composer.json'), true, 512, JSON_THROW_ON_ERROR);
		$services = (string) file_get_contents($root . '/config/services.yml');
		$extension = (string) file_get_contents($root . '/ext.php');

		$this->assertSame('phpbbgallery/tiff', $composer['name']);
		$this->assertSame('*', $composer['require']['ext-imagick']);
		$this->assertStringContainsString('phpbbgallery.core.image_format.collect', (string) file_get_contents($root . '/event/listener.php'));
		$this->assertStringContainsString('phpbbgallery\\core\\image\\external_processor_interface', (string) file_get_contents($root . '/processor.php'));
		$this->assertStringContainsString('@config', $services);
		$this->assertStringContainsString("manager->enable('phpbbgallery/core')", $extension);
	}

	public function test_acp_form_has_csrf_token_and_bounded_quality_field(): void
	{
		$template = (string) file_get_contents(dirname(__DIR__) . '/adm/style/tiff_settings.html');

		$this->assertStringContainsString('{{ S_FORM_TOKEN }}', $template);
		$this->assertMatchesRegularExpression('/type="number"[^>]+min="1"[^>]+max="100"/', $template);
	}

	public function test_acp_import_inspects_tiff_through_the_shared_processor(): void
	{
		$directory = $this->temporary_directory();
		try
		{
			$this->write_tiff($directory . '/scan.tiff');
			$storage = new import_storage($directory, $this->registry(true));
			$image = $storage->resolve_image('scan.tiff', ['tiff']);

			$this->assertIsArray($image);
			$inspection = $storage->inspect_image($image);
			$this->assertSame('', $inspection['error']);
			$this->assertSame('.tiff', $inspection['target_extension']);
			$this->assertSame('image/tiff', $inspection['image_info']['mime']);
		}
		finally
		{
			$this->remove_directory($directory);
		}
	}

	public function test_zip_extractor_accepts_verified_tiff_and_rejects_spoofed_content(): void
	{
		if (!class_exists(\ZipArchive::class))
		{
			$this->markTestSkipped('The ZIP extension is not available.');
		}
		$directory = $this->temporary_directory();
		try
		{
			$source = $this->write_tiff($directory . '/source.tiff');
			$archive = $directory . '/valid.zip';
			$zip = new \ZipArchive();
			$this->assertTrue($zip->open($archive, \ZipArchive::CREATE | \ZipArchive::OVERWRITE));
			$this->assertTrue($zip->addFile($source, 'valid.tiff'));
			$this->assertTrue($zip->close());

			$language = $this->createMock(\phpbb\language\language::class);
			$language->method('lang')->willReturnCallback(static fn(string $key): string => $key);
			$target = $directory . '/out/';
			mkdir($target);
			$extractor = new extractor($language, $this->registry(true));

			$this->assertTrue($extractor->extract(
				$archive,
				$target,
				['tiff'],
				extractor::limits(10, 2097152),
				static fn(array $entry, int $index): string => $index . '.tiff'
			));
			$this->assertCount(1, glob($target . '*') ?: []);

			$spoofed_archive = $directory . '/spoofed.zip';
			$zip = new \ZipArchive();
			$this->assertTrue($zip->open($spoofed_archive, \ZipArchive::CREATE | \ZipArchive::OVERWRITE));
			$this->assertTrue($zip->addFromString('spoofed.tiff', 'not an image'));
			$this->assertTrue($zip->close());
			$this->assertFalse($extractor->extract(
				$spoofed_archive,
				$target,
				['tiff'],
				extractor::limits(10, 2097152),
				static fn(array $entry, int $index): string => 'spoofed-' . $index . '.tiff'
			));
			$this->assertFileDoesNotExist($target . 'spoofed-0.tiff');
		}
		finally
		{
			$this->remove_directory($directory);
		}
	}

	private function registry(bool $upload): format_registry
	{
		$processor = new processor(new \phpbb\config\config(['phpbb_gallery_tiff_webp_quality' => 82]));
		$dispatcher = new class($upload) implements \phpbb\event\dispatcher_interface {
			public function __construct(private bool $upload)
			{
			}

			public function trigger_event($event_name, $data = [])
			{
				$data['formats'] = [
					'tif' => [
						'service' => 'phpbbgallery.tiff.processor',
						'mime' => 'image/tiff',
						'label' => 'FILETYPES_TIFF',
						'upload' => $this->upload,
					],
					'tiff' => [
						'service' => 'phpbbgallery.tiff.processor',
						'mime' => 'image/tiff',
						'label' => 'FILETYPES_TIFF',
						'upload' => $this->upload,
					],
				];

				return $data;
			}
		};
		$container = $this->createMock(ContainerInterface::class);
		$container->method('has')->willReturnCallback(
			static fn(string $id): bool => $id === 'phpbbgallery.tiff.processor'
		);
		$container->method('get')->willReturn($processor);

		return new format_registry($dispatcher, $container);
	}

	private function temporary_directory(): string
	{
		$directory = sys_get_temp_dir() . '/phpbbgallery-tiff-integration-' . bin2hex(random_bytes(6));
		mkdir($directory);

		return $directory;
	}

	private function write_tiff(string $path): string
	{
		if ((new \ReflectionClass(\Imagick::class))->isInternal())
		{
			$image = new \Imagick();
			$image->newImage(16, 12, new \ImagickPixel('white'));
			$image->setImageFormat('TIFF');
			$image->writeImage($path);
			$image->clear();
		}
		else
		{
			file_put_contents($path, "FAKE:TIFF:16:12\n");
		}

		return $path;
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
