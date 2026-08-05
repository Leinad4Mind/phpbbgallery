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
use phpbbgallery\core\storage\workspace;
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

	public function test_distributed_key_must_fit_the_database_column(): void
	{
		$this->expectException(\InvalidArgumentException::class);
		$this->generator(key_generator::LAYOUT_DISTRIBUTED)->create(str_repeat('a', 247) . '.jpg');
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
		$this->assertIsInt($provider->modified_time(provider_interface::SOURCE, $key));
		$this->assertSame(hash('sha256', 'gallery source'), $provider->checksum(provider_interface::SOURCE, $key));
		$this->assertFalse($provider->write(provider_interface::SOURCE, $key, $input));

		$stream = $provider->open_stream(provider_interface::SOURCE, $key);
		$this->assertIsResource($stream);
		$this->assertSame('gallery source', stream_get_contents($stream));
		fclose($stream);

		$this->assertTrue($provider->delete(provider_interface::SOURCE, $key));
		$this->assertFalse($provider->exists(provider_interface::SOURCE, $key));
		$this->assertNull($provider->modified_time(provider_interface::SOURCE, $key));
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

	public function test_local_provider_replaces_an_existing_object_without_leftovers(): void
	{
		$provider = $this->provider();
		$key = 'a/ab/image.jpg';
		$old = $this->temporary_directory . '/old.jpg';
		$new = $this->temporary_directory . '/new.jpg';
		file_put_contents($old, 'old-image');
		file_put_contents($new, 'new-image');
		$this->assertTrue($provider->write(provider_interface::SOURCE, $key, $old));

		$this->assertTrue($provider->replace(provider_interface::SOURCE, $key, $new));
		$this->assertSame(hash('sha256', 'new-image'), $provider->checksum(provider_interface::SOURCE, $key));
		$this->assertSame([], glob($this->temporary_directory . '/source/a/ab/*.part-*') ?: []);
		$this->assertSame([], glob($this->temporary_directory . '/source/a/ab/*.backup-*') ?: []);
	}

	public function test_upload_flow_records_the_distributed_key_and_uses_opaque_staging(): void
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
		$this->assertMatchesRegularExpression(
			'#^files/phpbbgallery/core/source/staging/[a-f0-9]{32}$#D',
			$file->destination
		);
		$staged_key = (new \ReflectionProperty($upload, 'staged_source_key'))->getValue($upload);
		$this->assertMatchesRegularExpression(
			'#^staging/[a-f0-9]{32}/7127abfe9cf6b6d3eb0a523e6158e896[.]jpeg$#D',
			$staged_key
		);
		$this->assertDirectoryExists(dirname((string) $this->provider()->local_path(provider_interface::SOURCE, $staged_key)));
		$this->assertDirectoryDoesNotExist($this->temporary_directory . '/source/7/71');
		$this->assertDirectoryDoesNotExist($this->temporary_directory . '/medium/7/71');
		$this->assertDirectoryDoesNotExist($this->temporary_directory . '/mini/7/71');
	}

	public function test_upload_publishes_before_insert_and_removes_staging(): void
	{
		$provider = $this->provider();
		$staged_key = 'staging/' . str_repeat('a', 32) . '/image.jpg';
		$this->assertTrue($provider->prepare(provider_interface::SOURCE, $staged_key));
		$staged_path = (string) $provider->local_path(provider_interface::SOURCE, $staged_key);
		file_put_contents($staged_path, 'validated-image');

		$database = new storage_upload_database(false);
		$upload = $this->publication_upload($provider, $database, $staged_key, $staged_path);

		$this->assertSame(77, $upload->file_to_database([]));
		$this->assertTrue($provider->exists(provider_interface::SOURCE, '7/71/image.jpg'));
		$this->assertFalse($provider->exists(provider_interface::SOURCE, $staged_key));
		$this->assertStringContainsString('7/71/image.jpg', $database->query);
	}

	public function test_database_failure_rolls_back_published_and_staged_objects(): void
	{
		$provider = $this->provider();
		$staged_key = 'staging/' . str_repeat('b', 32) . '/image.jpg';
		$this->assertTrue($provider->prepare(provider_interface::SOURCE, $staged_key));
		$staged_path = (string) $provider->local_path(provider_interface::SOURCE, $staged_key);
		file_put_contents($staged_path, 'validated-image');

		$upload = $this->publication_upload(
			$provider,
			new storage_upload_database(true),
			$staged_key,
			$staged_path
		);

		$this->expectException(\RuntimeException::class);
		try
		{
			$upload->file_to_database([]);
		}
		finally
		{
			$this->assertFalse($provider->exists(provider_interface::SOURCE, '7/71/image.jpg'));
			$this->assertFalse($provider->exists(provider_interface::SOURCE, $staged_key));
		}
	}

	private function publication_upload(
		local_provider $provider,
		storage_upload_database $database,
		string $staged_key,
		string $staged_path
	): \phpbbgallery\core\upload
	{
		$upload = (new \ReflectionClass(\phpbbgallery\core\upload::class))->newInstanceWithoutConstructor();
		$this->set_upload_property($upload, 'file', new storage_upload_file('7/71/image.jpg', $staged_path));
		$this->set_upload_property($upload, 'staged_source_key', $staged_key);
		$this->set_upload_property($upload, 'local_storage', $provider);
		$this->set_upload_property($upload, 'storage_workspace', new workspace($provider, $this->temporary_directory . '/workspace'));
		$this->set_upload_property($upload, 'db', $database);
		$this->set_upload_property($upload, 'images_table', 'phpbb_gallery_images');
		$this->set_upload_property($upload, 'username', 'Uploader');
		$this->set_upload_property($upload, 'album_id', 4);
		$this->set_upload_property($upload, 'allow_comments', true);
		$this->set_upload_property($upload, 'user', (object) [
			'data' => ['user_id' => 2, 'user_colour' => 'ABCDEF', 'session_id' => 'session'],
			'ip' => '127.0.0.1',
		]);
		$this->set_upload_property($upload, 'block', new class
		{
			public function get_image_status_orphan(): int
			{
				return 3;
			}
		});

		return $upload;
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

	public function __construct(public string $realname, private string $destination_file = '')
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
			'destination_file' => $this->destination_file,
			'filesize' => $this->destination_file !== '' ? filesize($this->destination_file) : 0,
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

final class storage_upload_database
{
	public string $query = '';

	public function __construct(private bool $fail)
	{
	}

	public function sql_build_array(string $type, array $data): string
	{
		return var_export($data, true);
	}

	public function sql_query(string $query): void
	{
		$this->query = $query;
		if ($this->fail)
		{
			throw new \RuntimeException('database failure');
		}
	}

	public function sql_nextid(): int
	{
		return 77;
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
