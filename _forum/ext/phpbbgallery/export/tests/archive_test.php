<?php
/**
 * phpBB Gallery - Export Extension
 *
 * @package   phpbbgallery/export
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

use PHPUnit\Framework\TestCase;
use phpbbgallery\export\archive;

class archive_test extends TestCase
{
	private string $root;
	private string $source;
	private string $archive_path;
	private archive $archive;

	protected function setUp(): void
	{
		if (!class_exists('ZipArchive'))
		{
			self::markTestSkipped('The Zip extension is required to write an archive.');
		}

		$this->root = sys_get_temp_dir() . '/phpbbgallery_archive_' . bin2hex(random_bytes(6));
		$this->source = $this->root . '/source';
		mkdir($this->source, 0777, true);

		$this->archive_path = $this->root . '/export.zip';
		$provider = new \phpbbgallery\core\storage\local_provider(
			$this->source,
			$this->root . '/medium',
			$this->root . '/mini'
		);
		$this->archive = new archive(new \phpbbgallery\core\storage\workspace($provider, $this->root . '/workspace'));
	}

	protected function tearDown(): void
	{
		$this->remove($this->root);
	}

	private function remove(string $path): void
	{
		if (!is_dir($path))
		{
			return;
		}

		foreach (array_diff((array) scandir($path), ['.', '..']) as $entry)
		{
			$child = $path . '/' . $entry;
			is_dir($child) ? $this->remove($child) : @unlink($child);
		}
		@rmdir($path);
	}

	private function write_source(string $filename, string $contents = 'image-bytes'): void
	{
		$directory = dirname($this->source . '/' . $filename);
		if (!is_dir($directory))
		{
			mkdir($directory, 0777, true);
		}
		file_put_contents($this->source . '/' . $filename, $contents);
	}

	private function row(int $image_id, string $filename, string $name, array $segments = ['Album']): array
	{
		return [
			'image_id' => $image_id,
			'author_id' => 2,
			'album_id' => 1,
			'album_name' => 'Album',
			'album_segments' => $segments,
			'image_name' => $name,
			'image_filename' => $filename,
			'uploader' => 'Leinad4Mind',
			'image_time' => 1785109307,
			'image_view_count' => 4,
			'filesize_upload' => 11,
			'description' => '',
		];
	}

	private function entries(): array
	{
		$zip = new ZipArchive();
		self::assertTrue($zip->open($this->archive_path) === true);

		$entries = [];
		for ($i = 0; $i < $zip->numFiles; $i++)
		{
			$entries[] = $zip->getNameIndex($i);
		}
		$zip->close();

		sort($entries);
		return $entries;
	}

	public function test_images_land_under_their_album_with_readable_names(): void
	{
		$this->write_source('a3f0c9.jpg');
		$this->write_source('b41ee2.png');

		$result = $this->archive->append($this->archive_path, [
			$this->row(1042, 'a3f0c9.jpg', 'Akira poster', ['Capas de Animação Oriental']),
			$this->row(1051, 'b41ee2.png', 'Ghost in the Shell', ['Capas de Animação Oriental', 'Subalbum']),
		], true);

		self::assertSame(2, $result['added']);
		self::assertSame([], $result['errors']);
		self::assertSame([
			'Capas de Animação Oriental/1042_2_Akira poster.jpg',
			'Capas de Animação Oriental/Subalbum/1051_2_Ghost in the Shell.png',
		], $this->entries());
	}

	public function test_a_missing_source_is_recorded_and_the_batch_carries_on(): void
	{
		$this->write_source('present.jpg');

		$result = $this->archive->append($this->archive_path, [
			$this->row(1, 'gone.jpg', 'Deleted from disk'),
			$this->row(2, 'present.jpg', 'Still here'),
		], true);

		self::assertSame(1, $result['added'], 'one bad file does not abort an export of hundreds');
		self::assertCount(1, $result['errors']);
		self::assertSame('missing', $result['errors'][0]['type']);
		self::assertSame(1, $result['errors'][0]['image_id']);
		self::assertSame(['Album/2_2_Still here.jpg'], $this->entries());
	}

	public function test_a_filename_pointing_outside_the_source_directory_is_refused(): void
	{
		file_put_contents($this->root . '/secret.txt', 'secret');

		$result = $this->archive->append($this->archive_path, [
			$this->row(1, '../secret.txt', 'Escape'),
			$this->row(2, 'sub/nested.jpg', 'Escape too'),
		], true);

		self::assertSame(0, $result['added']);
		self::assertCount(2, $result['errors']);
	}

	public function test_later_batches_append_instead_of_starting_over(): void
	{
		$this->write_source('one.jpg');
		$this->write_source('two.jpg');

		$this->archive->append($this->archive_path, [$this->row(1, 'one.jpg', 'First')], true);
		$this->archive->append($this->archive_path, [$this->row(2, 'two.jpg', 'Second')], false);

		self::assertSame(['Album/1_2_First.jpg', 'Album/2_2_Second.jpg'], $this->entries());
	}

	public function test_the_first_batch_starts_a_fresh_archive(): void
	{
		$this->write_source('one.jpg');
		file_put_contents($this->archive_path, 'left over from an earlier run');

		$result = $this->archive->append($this->archive_path, [$this->row(1, 'one.jpg', 'First')], true);

		self::assertSame(1, $result['added']);
		self::assertSame(['Album/1_2_First.jpg'], $this->entries());
	}

	public function test_the_manifest_is_written_into_the_archive(): void
	{
		$this->write_source('one.jpg');
		$rows = [$this->row(1, 'one.jpg', 'First')];

		$this->archive->append($this->archive_path, $rows, true);
		self::assertTrue($this->archive->write_manifest($this->archive_path, $rows, ['scope' => 'acp']));

		self::assertSame([
			'Album/1_2_First.jpg',
			archive::MANIFEST_CSV,
			archive::MANIFEST_JSON,
		], $this->entries());
	}

	public function test_the_reported_size_is_the_bytes_actually_added(): void
	{
		$this->write_source('one.jpg', str_repeat('x', 100));
		$this->write_source('two.jpg', str_repeat('x', 50));

		$result = $this->archive->append($this->archive_path, [
			$this->row(1, 'one.jpg', 'First'),
			$this->row(2, 'two.jpg', 'Second'),
		], true);

		self::assertSame(150, $result['bytes']);
	}

	public function test_distributed_source_keys_are_exported(): void
	{
		$this->write_source('7/71/7127abfe.jpg', 'distributed');

		$result = $this->archive->append($this->archive_path, [
			$this->row(12, '7/71/7127abfe.jpg', 'Distributed'),
		], true);

		self::assertSame(1, $result['added']);
		self::assertSame([], $result['errors']);
		self::assertSame(['Album/12_2_Distributed.jpg'], $this->entries());
	}

	public function test_remote_source_is_materialized_only_until_the_archive_is_closed(): void
	{
		$workspace_root = $this->root . '/remote-workspace';
		$provider = new export_remote_provider(['7/71/remote.jpg' => 'remote-source']);
		$archive = new archive(new \phpbbgallery\core\storage\workspace($provider, $workspace_root));

		$result = $archive->append($this->archive_path, [
			$this->row(13, '7/71/remote.jpg', 'Remote'),
		], true);

		self::assertSame(1, $result['added']);
		self::assertSame([], $result['errors']);
		self::assertSame(['Album/13_2_Remote.jpg'], $this->entries());
		self::assertSame([], glob($workspace_root . '/*') ?: []);
	}
}

// phpcs:disable Generic.Files.OneClassPerFile.MultipleFound -- Remote provider double belongs to this archive test.
final class export_remote_provider implements \phpbbgallery\core\storage\provider_interface
{
	public function __construct(private array $objects)
	{
	}

	public function get_id(): string
	{
		return 'remote-test';
	}

	public function prepare(string $variant, string $key): bool
	{
		return true;
	}

	public function write(string $variant, string $key, string $local_file): bool
	{
		return false;
	}

	public function replace(string $variant, string $key, string $local_file): bool
	{
		return false;
	}

	public function open_stream(string $variant, string $key): mixed
	{
		if (!isset($this->objects[$key]))
		{
			return false;
		}
		$stream = fopen('php://temp', 'w+b');
		fwrite($stream, $this->objects[$key]);
		rewind($stream);

		return $stream;
	}

	public function local_path(string $variant, string $key): ?string
	{
		return null;
	}

	public function exists(string $variant, string $key): bool
	{
		return isset($this->objects[$key]);
	}

	public function delete(string $variant, string $key): bool
	{
		return false;
	}

	public function size(string $variant, string $key): ?int
	{
		return isset($this->objects[$key]) ? strlen($this->objects[$key]) : null;
	}

	public function modified_time(string $variant, string $key): ?int
	{
		return isset($this->objects[$key]) ? 1785945600 : null;
	}

	public function list_objects(string $variant, ?string $cursor = null, int $limit = 500): array
	{
		return ['keys' => [], 'cursor' => null];
	}

	public function checksum(string $variant, string $key, string $algorithm = 'sha256'): ?string
	{
		return isset($this->objects[$key]) ? hash($algorithm, $this->objects[$key]) : null;
	}
}
