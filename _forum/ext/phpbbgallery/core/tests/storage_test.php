<?php
/**
 * phpBB Gallery - Core storage tests
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\tests;

use phpbbgallery\core\config;
use phpbbgallery\core\storage\key_generator;
use phpbbgallery\core\storage\local_provider;
use phpbbgallery\core\storage\provider_interface;
use PHPUnit\Framework\TestCase;

final class storage_test extends TestCase
{
	private string $temporary_directory;

	// phpcs:ignore PhpbbCodingStandard.NamingConventions.LowercaseUnderscoredFunctions.NotAllowed -- PHPUnit lifecycle API.
	protected function setUp(): void
	{
		parent::setUp();
		$this->temporary_directory = sys_get_temp_dir() . '/phpbbgallery-storage-' . bin2hex(random_bytes(6));
		mkdir($this->temporary_directory);
	}

	// phpcs:ignore PhpbbCodingStandard.NamingConventions.LowercaseUnderscoredFunctions.NotAllowed -- PHPUnit lifecycle API.
	protected function tearDown(): void
	{
		$this->remove_directory($this->temporary_directory);
		parent::tearDown();
	}

	public function test_flat_layout_preserves_the_generated_basename(): void
	{
		$generator = $this->generator(key_generator::LAYOUT_FLAT);

		$this->assertSame('7127abfe9cf6b6d3eb0a523e6158e896.jpeg', $generator->create('7127abfe9cf6b6d3eb0a523e6158e896.jpeg'));
		$this->assertSame(key_generator::LAYOUT_FLAT, $generator->get_layout());
	}

	public function test_distributed_layout_uses_two_levels_from_the_stored_basename(): void
	{
		$generator = $this->generator(key_generator::LAYOUT_DISTRIBUTED);

		$this->assertSame(
			'7/71/7127abfe9cf6b6d3eb0a523e6158e896.jpeg',
			$generator->create('7127abfe9cf6b6d3eb0a523e6158e896.jpeg')
		);
		$this->assertSame(key_generator::LAYOUT_DISTRIBUTED, $generator->get_layout());
	}

	public function test_unknown_layout_fails_safely_to_flat(): void
	{
		$generator = $this->generator('remote-or-invalid');

		$this->assertSame('abcdef.jpg', $generator->create('abcdef.jpg'));
		$this->assertSame(key_generator::LAYOUT_FLAT, $generator->get_layout());
	}

	/**
	 * @dataProvider unsafe_basename_provider
	 */
	public function test_key_generator_rejects_unsafe_basenames(string $filename): void
	{
		$this->expectException(\InvalidArgumentException::class);
		$this->generator(key_generator::LAYOUT_DISTRIBUTED)->create($filename);
	}

	public static function unsafe_basename_provider(): array
	{
		return [
			'empty' => [''],
			'traversal' => ['../image.jpg'],
			'forward slash' => ['folder/image.jpg'],
			'backslash' => ['folder\\image.jpg'],
			'nul byte' => ["image.jpg\0.php"],
			'absolute Windows path' => ['C:\\image.jpg'],
		];
	}

	public function test_local_provider_writes_and_reads_distributed_objects(): void
	{
		$provider = $this->provider();
		$key = '7/71/7127abfe9cf6b6d3eb0a523e6158e896.jpeg';
		$input = $this->temporary_directory . '/input.bin';
		file_put_contents($input, 'gallery source');

		$this->assertSame('local', $provider->get_id());
		$this->assertTrue($provider->write(provider_interface::SOURCE, $key, $input));
		$this->assertTrue($provider->exists(provider_interface::SOURCE, $key));
		$this->assertSame(14, $provider->size(provider_interface::SOURCE, $key));
		$this->assertSame(hash('sha256', 'gallery source'), $provider->checksum(provider_interface::SOURCE, $key));
		$this->assertFalse($provider->write(provider_interface::SOURCE, $key, $input));

		$stream = $provider->open_stream(provider_interface::SOURCE, $key);
		$this->assertIsResource($stream);
		$this->assertSame('gallery source', stream_get_contents($stream));
		fclose($stream);

		$this->assertTrue($provider->delete(provider_interface::SOURCE, $key));
		$this->assertFalse($provider->exists(provider_interface::SOURCE, $key));
		$this->assertTrue($provider->delete(provider_interface::SOURCE, $key));
	}

	/**
	 * @dataProvider unsafe_key_provider
	 */
	public function test_local_provider_rejects_unsafe_keys(string $key): void
	{
		$provider = $this->provider();

		$this->assertFalse($provider->prepare(provider_interface::SOURCE, $key));
		$this->assertNull($provider->local_path(provider_interface::SOURCE, $key));
		$this->assertFalse($provider->exists(provider_interface::SOURCE, $key));
	}

	public static function unsafe_key_provider(): array
	{
		return [
			'parent traversal' => ['../outside.jpg'],
			'nested traversal' => ['7/../outside.jpg'],
			'absolute Unix path' => ['/outside.jpg'],
			'absolute Windows path' => ['C:/outside.jpg'],
			'backslash' => ['7\\71\\image.jpg'],
			'empty segment' => ['7//image.jpg'],
			'nul byte' => ["image.jpg\0.php"],
		];
	}

	public function test_local_provider_keeps_variants_in_separate_roots(): void
	{
		$provider = $this->provider();
		$key = 'a/ab/abcdef.png';

		$this->assertTrue($provider->prepare(provider_interface::SOURCE, $key));
		$this->assertTrue($provider->prepare(provider_interface::MEDIUM, $key));
		$this->assertTrue($provider->prepare(provider_interface::MINI, $key));
		$this->assertStringContainsString(DIRECTORY_SEPARATOR . 'source' . DIRECTORY_SEPARATOR, (string) $provider->local_path(provider_interface::SOURCE, $key));
		$this->assertStringContainsString(DIRECTORY_SEPARATOR . 'medium' . DIRECTORY_SEPARATOR, (string) $provider->local_path(provider_interface::MEDIUM, $key));
		$this->assertStringContainsString(DIRECTORY_SEPARATOR . 'mini' . DIRECTORY_SEPARATOR, (string) $provider->local_path(provider_interface::MINI, $key));
	}

	public function test_local_provider_refuses_a_file_in_the_directory_chain(): void
	{
		$provider = $this->provider();
		mkdir($this->temporary_directory . '/source');
		file_put_contents($this->temporary_directory . '/source/7', 'not a directory');

		$this->assertFalse($provider->prepare(provider_interface::SOURCE, '7/71/image.jpg'));
		$this->assertDirectoryDoesNotExist($this->temporary_directory . '/source/7/71');
	}

	public function test_failed_write_does_not_leave_a_partial_object(): void
	{
		$provider = $this->provider();
		$key = 'a/ab/image.jpg';

		$this->assertFalse($provider->write(provider_interface::SOURCE, $key, $this->temporary_directory . '/missing'));
		$this->assertFalse($provider->exists(provider_interface::SOURCE, $key));
		$this->assertSame([], glob($this->temporary_directory . '/source/a/ab/*.part-*') ?: []);
	}

	public function test_upload_flow_records_the_distributed_key_and_prepares_all_variants(): void
	{
		if (!defined('CHMOD_ALL'))
		{
			define('CHMOD_ALL', 7);
		}

		$upload = (new \ReflectionClass(\phpbbgallery\core\upload::class))->newInstanceWithoutConstructor();
		$file = new storage_upload_file('7127abfe9cf6b6d3eb0a523e6158e896.jpeg');
		$this->set_upload_property($upload, 'file', $file);
		$this->set_upload_property($upload, 'storage_keys', $this->generator(key_generator::LAYOUT_DISTRIBUTED));
		$this->set_upload_property($upload, 'local_storage', $this->provider());
		$this->set_upload_property($upload, 'gallery_url', new storage_upload_url());
		$this->set_upload_property($upload, 'language', new storage_upload_language());

		$result = (new \ReflectionMethod($upload, 'move_file_to_storage'))->invoke($upload);

		$this->assertTrue($result);
		$this->assertSame('7/71/7127abfe9cf6b6d3eb0a523e6158e896.jpeg', $file->realname);
		$this->assertSame('files/phpbbgallery/core/source/7/71', $file->destination);
		$this->assertDirectoryExists($this->temporary_directory . '/source/7/71');
		$this->assertDirectoryExists($this->temporary_directory . '/medium/7/71');
		$this->assertDirectoryExists($this->temporary_directory . '/mini/7/71');
	}

	private function generator(string $layout): key_generator
	{
		return new key_generator(new config(new \phpbb\config\config([
			'phpbb_gallery_storage_layout' => $layout,
		])));
	}

	private function provider(): local_provider
	{
		return new local_provider(
			$this->temporary_directory . '/source',
			$this->temporary_directory . '/medium',
			$this->temporary_directory . '/mini'
		);
	}

	private function set_upload_property(\phpbbgallery\core\upload $upload, string $name, mixed $value): void
	{
		(new \ReflectionProperty($upload, $name))->setValue($upload, $value);
	}

	private function remove_directory(string $directory): void
	{
		if (!is_dir($directory))
		{
			return;
		}

		$iterator = new \RecursiveIteratorIterator(
			new \RecursiveDirectoryIterator($directory, \FilesystemIterator::SKIP_DOTS),
			\RecursiveIteratorIterator::CHILD_FIRST
		);
		foreach ($iterator as $item)
		{
			$item->isDir() ? rmdir($item->getPathname()) : unlink($item->getPathname());
		}
		rmdir($directory);
	}
}

// phpcs:disable Generic.Files.OneClassPerFile.MultipleFound -- Upload doubles belong to this isolated storage test.
final class storage_upload_file
{
	public array $error = [];
	public string $destination = '';
	public bool $removed = false;

	public function __construct(public string $realname)
	{
	}

	public function clean_filename(string $mode, string $prefix = ''): void
	{
		if ($mode === 'real')
		{
			$this->realname = $prefix . basename($this->realname);
		}
	}

	public function get(string $property): mixed
	{
		return match ($property)
		{
			'realname' => $this->realname,
			'uploadname' => 'upload.jpeg',
			default => null,
		};
	}

	public function move_file(string $destination, bool $overwrite, bool $skip_image_check, int $chmod): void
	{
		$this->destination = $destination;
	}

	public function remove(): void
	{
		$this->removed = true;
	}
}

final class storage_upload_url
{
	public function path(string $directory): string
	{
		return $directory === 'upload_noroot' ? 'files/phpbbgallery/core/source/' : '';
	}
}

final class storage_upload_language
{
	public function lang(string $key, mixed ...$arguments): string
	{
		return $key;
	}
}
