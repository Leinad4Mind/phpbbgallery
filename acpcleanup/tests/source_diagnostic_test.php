<?php
/**
 * phpBB Gallery - ACP Cleanup source diagnostic tests
 *
 * @package   phpbbgallery/acpcleanup
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\acpcleanup\tests;

use phpbbgallery\acpcleanup\source_diagnostic;
use phpbbgallery\core\storage\local_provider;
use phpbbgallery\core\storage\provider_interface;
use phpbbgallery\core\storage\workspace;
use PHPUnit\Framework\TestCase;

final class source_diagnostic_test extends TestCase
{
	private string $root;
	private local_provider $provider;
	private source_diagnostic_db $db;
	private source_diagnostic $diagnostic;

	// phpcs:ignore PhpbbCodingStandard.NamingConventions.LowercaseUnderscoredFunctions.NotAllowed -- PHPUnit lifecycle API.
	protected function setUp(): void
	{
		parent::setUp();
		$this->root = sys_get_temp_dir() . '/phpbbgallery-source-diagnostic-' . bin2hex(random_bytes(6));
		mkdir($this->root, 0700, true);
		$this->provider = new local_provider(
			$this->root . '/source',
			$this->root . '/medium',
			$this->root . '/mini'
		);
		$this->db = new source_diagnostic_db(
			[
				1 => $this->image(1, 'present.jpg', 1),
				2 => $this->image(2, 'missing.jpg', 0),
				3 => $this->image(3, 'another.jpg', 0),
			],
			[7 => 'Public album']
		);
		$this->diagnostic = new source_diagnostic(
			$this->db,
			new workspace($this->provider, $this->root . '/workspace'),
			'gallery_images',
			'gallery_albums'
		);

		$this->publish(provider_interface::SOURCE, 'present.jpg');
		$this->publish(provider_interface::SOURCE, 'another.jpg');
		$this->publish(provider_interface::MEDIUM, 'missing.jpg');
	}

	// phpcs:ignore PhpbbCodingStandard.NamingConventions.LowercaseUnderscoredFunctions.NotAllowed -- PHPUnit lifecycle API.
	protected function tearDown(): void
	{
		$this->remove_directory($this->root);
		parent::tearDown();
	}

	public function test_scan_is_bounded_and_reconciles_missing_flags(): void
	{
		$this->assertSame(3, $this->diagnostic->count_all());

		$result = $this->diagnostic->scan_batch(0, 2);

		$this->assertSame([
			'checked' => 2,
			'missing' => 1,
			'last_id' => 2,
			'has_more' => true,
		], $result);
		$this->assertSame(0, $this->db->images[1]['image_filemissing']);
		$this->assertSame(1, $this->db->images[2]['image_filemissing']);
		$this->assertSame(1, $this->diagnostic->count_missing());

		$missing = $this->diagnostic->missing_page(0, 500);
		$this->assertSame(100, $this->db->last_limit);
		$this->assertCount(1, $missing);
		$this->assertSame(2, $missing[0]['image_id']);
		$this->assertSame('Public album', $missing[0]['album_name']);
		$this->assertTrue($missing[0]['medium_exists']);
		$this->assertFalse($missing[0]['mini_exists']);
	}

	public function test_restored_source_is_cleared_on_the_next_scan(): void
	{
		$this->diagnostic->scan_batch(0, 2);
		$this->publish(provider_interface::SOURCE, 'missing.jpg');

		$result = $this->diagnostic->scan_batch(1, 2);

		$this->assertSame(2, $result['checked']);
		$this->assertSame(0, $result['missing']);
		$this->assertFalse($result['has_more']);
		$this->assertSame(0, $this->db->images[2]['image_filemissing']);
		$this->assertSame(0, $this->diagnostic->count_missing());
		$this->assertSame([], $this->diagnostic->missing_page());
	}

	/** @return array<string, int|string> */
	private function image(int $id, string $filename, int $missing): array
	{
		return [
			'image_id' => $id,
			'image_name' => 'Image ' . $id,
			'image_filename' => $filename,
			'image_username' => 'Author',
			'image_status' => 1,
			'image_album_id' => 7,
			'image_filemissing' => $missing,
		];
	}

	private function publish(string $variant, string $key): void
	{
		$input = $this->root . '/input-' . md5($variant . $key) . '.jpg';
		file_put_contents($input, 'image');
		$this->assertTrue($this->provider->write($variant, $key, $input));
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

/** @internal Minimal stateful DBAL double for the source diagnostic service. */
// phpcs:disable Generic.Files.OneClassPerFile.MultipleFound -- Database double belongs to this isolated service test.
final class source_diagnostic_db implements \phpbb\db\driver\driver_interface
{
	/** @var array<int, array<string, int|string>> */
	public array $images;
	public int $last_limit = 0;
	/** @var array<int, string> */
	private array $albums;
	/** @var list<array<string, mixed>> */
	private array $rows = [];
	private int $cursor = 0;
	private int $field = 0;

	/**
	 * @param array<int, array<string, int|string>> $images
	 * @param array<int, string>                    $albums
	 */
	public function __construct(array $images, array $albums)
	{
		$this->images = $images;
		$this->albums = $albums;
	}

	public function sql_query(string $sql): int
	{
		$this->rows = [];
		$this->cursor = 0;
		if (str_starts_with(trim($sql), 'SELECT COUNT'))
		{
			$this->field = str_contains($sql, 'image_filemissing = 1')
				? count(array_filter($this->images, static fn (array $row): bool => (int) $row['image_filemissing'] === 1))
				: count($this->images);
			return 1;
		}

		if (preg_match('/SET image_filemissing = ([01]).*WHERE image_id IN \\(([^)]+)\\)/s', $sql, $matches))
		{
			$value = (int) $matches[1];
			foreach (array_map('intval', explode(',', $matches[2])) as $image_id)
			{
				if (isset($this->images[$image_id]))
				{
					$this->images[$image_id]['image_filemissing'] = $value;
				}
			}
		}

		return 1;
	}

	public function sql_query_limit(string $sql, int $limit, int $offset = 0): int
	{
		$this->last_limit = $limit;
		$this->cursor = 0;
		if ($sql === 'MISSING_SOURCE_PAGE')
		{
			$rows = array_values(array_filter(
				$this->images,
				static fn (array $row): bool => (int) $row['image_filemissing'] === 1
			));
			foreach ($rows as &$row)
			{
				$row['album_name'] = $this->albums[(int) $row['image_album_id']] ?? '';
			}
			unset($row);
			$this->rows = array_slice($rows, $offset, $limit);
			return 1;
		}

		preg_match('/image_id > ([0-9]+)/', $sql, $matches);
		$after_id = (int) ($matches[1] ?? 0);
		$rows = array_values(array_filter(
			$this->images,
			static fn (array $row): bool => (int) $row['image_id'] > $after_id
		));
		usort($rows, static fn (array $left, array $right): int => (int) $left['image_id'] <=> (int) $right['image_id']);
		$this->rows = array_map(
			static fn (array $row): array => [
				'image_id' => $row['image_id'],
				'image_filename' => $row['image_filename'],
			],
			array_slice($rows, $offset, $limit)
		);

		return 1;
	}

	public function sql_fetchrow(int $result): array|false
	{
		return $this->rows[$this->cursor++] ?? false;
	}

	public function sql_fetchfield(string $field): int
	{
		return $this->field;
	}

	public function sql_freeresult(int $result): void
	{
	}

	/** @param list<int> $values */
	public function sql_in_set(string $field, array $values): string
	{
		return $field . ' IN (' . implode(',', array_map('intval', $values)) . ')';
	}

	/** @param array<string, mixed> $sql_array */
	public function sql_build_query(string $query, array $sql_array): string
	{
		return 'MISSING_SOURCE_PAGE';
	}
}
