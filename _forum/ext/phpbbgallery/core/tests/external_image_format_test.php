<?php
// phpcs:disable Generic.Files.OneClassPerFile.MultipleFound -- Focused test doubles share this fixture.
/**
 * phpBB Gallery - external image format contract tests
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\tests;

use phpbbgallery\core\image\external_processor_interface;
use phpbbgallery\core\image\format_registry;
use phpbbgallery\core\storage\provider_interface;
use phpbbgallery\core\storage\variant_key;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;

final class external_image_format_test extends TestCase
{
	public function test_external_derivatives_use_a_stable_idempotent_webp_key(): void
	{
		$resolver = new variant_key();

		$this->assertSame('7/71/image.tiff', $resolver->resolve(provider_interface::SOURCE, '7/71/image.tiff'));
		$this->assertSame('7/71/image.tiff.webp', $resolver->resolve(provider_interface::MEDIUM, '7/71/image.tiff'));
		$this->assertSame('7/71/image.tiff.webp', $resolver->resolve(provider_interface::MINI, '7/71/image.tiff.webp'));
		$this->assertSame('7/71/image.jpg', $resolver->resolve(provider_interface::MINI, '7/71/image.jpg'));
	}

	public function test_unknown_storage_variant_is_rejected(): void
	{
		$this->expectException(\InvalidArgumentException::class);
		(new variant_key())->resolve('archive', 'image.tiff');
	}

	public function test_registry_exposes_only_valid_available_processors(): void
	{
		$processor = new external_format_test_processor();
		$dispatcher = new external_format_test_dispatcher([
			'tif' => ['service' => 'phpbbgallery.tiff.processor', 'mime' => 'image/tiff', 'label' => 'FILETYPES_TIFF'],
			'tiff' => ['service' => 'phpbbgallery.tiff.processor', 'mime' => 'image/tiff', 'label' => 'FILETYPES_TIFF'],
			'bad/ext' => ['service' => 'unsafe', 'mime' => 'text/plain', 'label' => 'bad'],
			'raw' => ['service' => 'missing.processor', 'mime' => 'image/raw', 'label' => 'FILETYPES_RAW'],
		]);
		$container = $this->createMock(ContainerInterface::class);
		$container->method('has')->willReturnCallback(
			static fn(string $id): bool => $id === 'phpbbgallery.tiff.processor'
		);
		$container->method('get')->willReturn($processor);
		$registry = new format_registry($dispatcher, $container);
		$language = $this->createMock(\phpbb\language\language::class);
		$language->method('lang')->willReturnCallback(static fn(string $key): string => $key === 'FILETYPES_TIFF' ? 'tif, tiff' : $key);

		$this->assertSame(['tif', 'tiff'], $registry->extensions());
		$this->assertSame(['tif, tiff'], $registry->labels($language));
		$this->assertSame($processor, $registry->processor_for_filename('scan.TIFF'));
		$this->assertNull($registry->processor_for_filename('photo.jpg'));
	}

	public function test_registry_rejects_spoofed_or_dangerously_large_metadata(): void
	{
		$processor = new external_format_test_processor();
		$container = $this->createMock(ContainerInterface::class);
		$container->method('has')->willReturn(true);
		$container->method('get')->willReturn($processor);
		$registry = new format_registry(new external_format_test_dispatcher([
			'tiff' => ['service' => 'phpbbgallery.tiff.processor', 'mime' => 'image/tiff', 'label' => 'FILETYPES_TIFF'],
		]), $container);

		$valid = ['extension' => 'tiff', 'mime' => 'image/tiff', 'width' => 2000, 'height' => 1000, 'filesize' => 2048];
		$this->assertTrue($registry->accepts_metadata('scan.tiff', $valid));
		$this->assertFalse($registry->accepts_metadata('scan.tiff', array_merge($valid, ['mime' => 'image/jpeg'])));
		$this->assertFalse($registry->accepts_metadata('scan.tiff', array_merge($valid, ['extension' => 'tif'])));
		$this->assertFalse($registry->accepts_metadata('scan.tiff', array_merge($valid, ['width' => 40000001])));
		$this->assertFalse($registry->accepts_metadata('scan.tiff', array_merge($valid, ['filesize' => 0])));
	}
}

final class external_format_test_dispatcher implements \phpbb\event\dispatcher_interface
{
	public function __construct(private array $formats)
	{
	}

	public function trigger_event($event_name, $data = [])
	{
		$data['formats'] = $this->formats;

		return $data;
	}
}

final class external_format_test_processor implements external_processor_interface
{
	public function inspect(string $source): ?array
	{
		return null;
	}

	public function prepare_source(string $source, array $options): ?array
	{
		return null;
	}

	public function create_derivative(string $source, string $destination, int $max_width, int $max_height, int $quality): ?array
	{
		return null;
	}
}
