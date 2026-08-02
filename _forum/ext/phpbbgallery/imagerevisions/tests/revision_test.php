<?php
// phpcs:disable Generic.Files.OneClassPerFile.MultipleFound, PSR1.Files.SideEffects.FoundWithSymbols -- Focused test doubles share this fixture.
/**
 * phpBB Gallery - Image Revisions domain tests
 *
 * @package   phpbbgallery/imagerevisions
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\imagerevisions\tests;

use phpbbgallery\imagerevisions\revision;
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/fake_db.php';

final class revision_test extends TestCase
{
	private string $source_root;
	private fake_db $db;
	private revision_test_file $file;
	private revision_test_log $log;
	private revision_test_cache $cache;
	private revision $revision;

	// phpcs:ignore PhpbbCodingStandard.NamingConventions.LowercaseUnderscoredFunctions.NotAllowed -- PHPUnit lifecycle API.
	protected function setUp(): void
	{
		$this->source_root = sys_get_temp_dir() . '/phpbbgallery-imagerevisions-' . bin2hex(random_bytes(6));
		mkdir($this->source_root, 0755, true);
		file_put_contents($this->source_root . '/current.jpg', 'current');
		file_put_contents($this->source_root . '/replacement.png', 'replacement');

		$this->db = new fake_db([
			10 => $this->image(10, 'current.jpg', \phpbbgallery\core\block::STATUS_APPROVED, 7, 7),
			11 => $this->image(11, 'replacement.png', \phpbbgallery\core\block::STATUS_ORPHAN, 7, 11),
		]);
		$user = new \phpbb\user();
		$user->data = ['user_id' => 7];
		$url = new revision_test_url($this->source_root);
		$this->file = new revision_test_file($this->source_root);
		$this->log = new revision_test_log();
		$this->cache = new revision_test_cache();
		$this->revision = new revision($this->db, $user, $url, $this->log, $this->cache, $this->file, 'images', 'revisions');
	}

	// phpcs:ignore PhpbbCodingStandard.NamingConventions.LowercaseUnderscoredFunctions.NotAllowed -- PHPUnit lifecycle API.
	protected function tearDown(): void
	{
		foreach (array_diff(scandir($this->source_root) ?: [], ['.', '..']) as $file)
		{
			@unlink($this->source_root . '/' . $file);
		}
		@rmdir($this->source_root);
	}

	public function test_replacement_preserves_the_image_record_and_stores_the_previous_file(): void
	{
		$this->assertTrue($this->revision->replace_file(10, 11, 5));

		$this->assertArrayNotHasKey(11, $this->db->images);
		$this->assertSame('replacement.png', $this->db->images[10]['image_filename']);
		$this->assertSame('Original title', $this->db->images[10]['image_name']);
		$this->assertSame(123, $this->db->images[10]['image_view_count']);
		$this->assertSame(7, $this->db->images[10]['image_user_id']);
		$this->assertCount(1, $this->db->revisions);
		$this->assertSame('current.jpg', $this->db->revisions[1]['revision_filename']);
		$this->assertSame(7, $this->db->revisions[1]['revision_user_id']);
		$this->assertFileExists($this->source_root . '/current.jpg');
		$this->assertFileExists($this->source_root . '/replacement.png');
		$this->assertSame(['begin', 'commit'], $this->db->transactions);
		$this->assertCount(1, $this->log->entries);
		$this->assertSame(1, $this->cache->destroy_calls);
	}

	public function test_intermediate_upload_must_be_an_orphan_owned_by_the_editor_in_the_same_album(): void
	{
		$this->db->images[11]['image_user_id'] = 8;
		$this->assertFalse($this->revision->replace_file(10, 11, 5));

		$this->db->images[11]['image_user_id'] = 7;
		$this->db->images[11]['image_album_id'] = 9;
		$this->assertFalse($this->revision->replace_file(10, 11, 5));

		$this->db->images[11]['image_album_id'] = 7;
		$this->db->images[11]['image_status'] = \phpbbgallery\core\block::STATUS_APPROVED;
		$this->assertFalse($this->revision->replace_file(10, 11, 5));
		$this->assertSame([], $this->db->transactions);
		$this->assertSame('current.jpg', $this->db->images[10]['image_filename']);
	}

	public function test_a_concurrent_file_change_rolls_back_the_revision_transaction(): void
	{
		$this->db->reject_updates = true;

		$this->assertFalse($this->revision->replace_file(10, 11, 5));
		$this->assertSame(['begin', 'rollback'], $this->db->transactions);
		$this->assertSame([], $this->db->revisions);
		$this->assertArrayHasKey(11, $this->db->images);
		$this->assertSame('current.jpg', $this->db->images[10]['image_filename']);
		$this->assertFileExists($this->source_root . '/current.jpg');
		$this->assertFileExists($this->source_root . '/replacement.png');
	}

	public function test_history_limit_prunes_the_oldest_file_and_restore_remains_reversible(): void
	{
		$this->assertTrue($this->revision->replace_file(10, 11, 1));
		file_put_contents($this->source_root . '/third.webp', 'third');
		$this->db->images[12] = $this->image(12, 'third.webp', \phpbbgallery\core\block::STATUS_ORPHAN, 7, 5);

		$this->assertTrue($this->revision->replace_file(10, 12, 1));
		$this->assertCount(1, $this->db->revisions);
		$this->assertSame('replacement.png', $this->db->revisions[2]['revision_filename']);
		$this->assertFileDoesNotExist($this->source_root . '/current.jpg');
		$this->assertSame('third.webp', $this->db->images[10]['image_filename']);

		$this->assertTrue($this->revision->restore(10, 2, 1));
		$this->assertSame('replacement.png', $this->db->images[10]['image_filename']);
		$this->assertCount(1, $this->db->revisions);
		$this->assertSame('third.webp', $this->db->revisions[3]['revision_filename']);
		$this->assertFileExists($this->source_root . '/third.webp');
	}

	public function test_deleting_an_image_deletes_its_revision_rows_and_owned_files(): void
	{
		$this->assertTrue($this->revision->replace_file(10, 11, 5));
		$this->assertSame(1, $this->revision->delete_for_images([10, 10, 0, -2]));

		$this->assertSame([], $this->db->revisions);
		$this->assertFileDoesNotExist($this->source_root . '/current.jpg');
		$this->assertFileExists($this->source_root . '/replacement.png');
	}

	public function test_reactivation_deletes_revision_files_for_missing_images(): void
	{
		$this->assertTrue($this->revision->replace_file(10, 11, 5));
		unset($this->db->images[10]);

		$this->assertSame(1, $this->revision->reconcile_orphans());
		$this->assertSame([], $this->db->revisions);
		$this->assertFileDoesNotExist($this->source_root . '/current.jpg');
	}

	public function test_revision_lookup_is_scoped_to_the_image(): void
	{
		$this->assertTrue($this->revision->replace_file(10, 11, 5));

		$this->assertIsArray($this->revision->get_revision(10, 1));
		$this->assertFalse($this->revision->get_revision(99, 1));
		$this->assertSame('Editor', $this->revision->get_revisions(10)[0]['username']);
	}

	public function test_source_path_resolution_rejects_absolute_traversal_and_missing_paths(): void
	{
		$this->assertSame(realpath($this->source_root . '/current.jpg'), $this->revision->resolve_source_file('current.jpg'));
		$this->assertFalse($this->revision->resolve_source_file('../current.jpg'));
		$this->assertFalse($this->revision->resolve_source_file($this->source_root . '/current.jpg'));
		$this->assertFalse($this->revision->resolve_source_file("bad\0name.jpg"));
		$this->assertFalse($this->revision->resolve_source_file('missing.jpg'));
	}

	private function image(int $image_id, string $filename, int $status, int $user_id, int $filesize): array
	{
		return [
			'image_id' => $image_id,
			'image_album_id' => 7,
			'image_user_id' => $user_id,
			'image_status' => $status,
			'image_filename' => $filename,
			'image_name' => 'Original title',
			'image_desc' => 'Original description',
			'image_view_count' => 123,
			'filesize_upload' => $filesize,
			'filesize_medium' => 3,
			'filesize_cache' => 2,
			'image_filemissing' => 0,
		];
	}
}

final class revision_test_url extends \phpbbgallery\core\url
{
	public function __construct(private string $source_root)
	{
	}

	public function path(string $directory = 'gallery'): string|false
	{
		return rtrim($this->source_root, '/\\') . DIRECTORY_SEPARATOR;
	}
}

final class revision_test_file extends \phpbbgallery\core\file\file
{
	public array $deleted = [];
	public array $cache_deleted = [];

	public function __construct(private string $source_root)
	{
	}

	public function delete(array|string $files, array $locations = ['thumbnail', 'medium', 'upload']): void
	{
		foreach ((array) $files as $filename)
		{
			$this->deleted[] = (string) $filename;
			@unlink($this->source_root . '/' . $filename);
		}
	}

	public function delete_cache(array|string $files, array $locations = ['thumbnail', 'medium']): void
	{
		$this->cache_deleted = array_merge($this->cache_deleted, array_values((array) $files));
	}
}

final class revision_test_log extends \phpbbgallery\core\log
{
	public array $entries = [];

	public function __construct()
	{
	}

	public function add_log(string $log_type, string $log_action, int $album = 0, int $image = 0, array|string $description = []): void
	{
		$this->entries[] = [$log_type, $log_action, $album, $image, $description];
	}
}

final class revision_test_cache extends \phpbbgallery\core\cache
{
	public int $destroy_calls = 0;

	public function __construct()
	{
	}

	public function destroy_images(): void
	{
		$this->destroy_calls++;
	}
}
