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
use phpbbgallery\export\job_storage;
use phpbbgallery\export\runner;

require_once __DIR__ . '/fake_export.php';

class runner_test extends TestCase
{
	private string $root;
	private string $source;
	private string $exports;
	private job_storage $storage;

	protected function setUp(): void
	{
		if (!class_exists('ZipArchive'))
		{
			self::markTestSkipped('The Zip extension is required to write an archive.');
		}

		$this->root = sys_get_temp_dir() . '/phpbbgallery_runner_' . bin2hex(random_bytes(6));
		$this->source = $this->root . '/source';
		$this->exports = $this->root . '/export';
		mkdir($this->source, 0777, true);
		mkdir($this->exports, 0777, true);

		$this->storage = new job_storage($this->exports);
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

	private function config(array $overrides = []): \phpbb\config\config
	{
		return new \phpbb\config\config(array_merge([
			'phpbb_gallery_export_batch_size' => 2,
			'phpbb_gallery_export_max_images' => 5000,
			'phpbb_gallery_export_max_bytes' => 2147483648,
			'phpbb_gallery_export_ucp_max_images' => 500,
			'phpbb_gallery_export_ucp_enable' => 1,
			'phpbb_gallery_export_ttl' => 86400,
		], $overrides));
	}

	private function runner(fake_export $export, array $config_overrides = []): runner
	{
		return new runner(
			$this->config($config_overrides),
			new \phpbb\language\language(),
			$export,
			new archive($this->source),
			$this->storage
		);
	}

	private function row(int $image_id, string $filename, string $name): array
	{
		return [
			'image_id' => $image_id,
			'album_id' => 1,
			'album_name' => 'Album',
			'album_segments' => ['Album'],
			'image_name' => $name,
			'image_filename' => $filename,
			'uploader' => 'Leinad4Mind',
			'image_time' => 1785109307,
			'image_view_count' => 0,
			'filesize_upload' => 11,
			'description' => '',
		];
	}

	private function make_images(int $count): fake_export
	{
		$rows = [];
		for ($i = 1; $i <= $count; $i++)
		{
			file_put_contents($this->source . '/image' . $i . '.jpg', 'image-bytes');
			$rows[] = $this->row($i, 'image' . $i . '.jpg', 'Picture ' . $i);
		}

		return new fake_export($rows);
	}

	public function test_an_empty_selection_is_refused(): void
	{
		$result = $this->runner(new fake_export())->create(2, job_storage::SCOPE_ACP, job_storage::DELIVERY_DOWNLOAD, [], ['image_ids' => [], 'bytes' => 0]);

		self::assertSame('EXPORT_NO_IMAGES', $result['error']);
	}

	public function test_a_selection_beyond_the_image_limit_is_refused(): void
	{
		$result = $this->runner(new fake_export(), ['phpbb_gallery_export_max_images' => 2])
			->create(2, job_storage::SCOPE_ACP, job_storage::DELIVERY_DOWNLOAD, [], ['image_ids' => [1, 2, 3], 'bytes' => 10]);

		self::assertSame('EXPORT_TOO_MANY_IMAGES', $result['error']);
	}

	public function test_a_selection_beyond_the_size_limit_is_refused(): void
	{
		$result = $this->runner(new fake_export(), ['phpbb_gallery_export_max_bytes' => 100])
			->create(2, job_storage::SCOPE_ACP, job_storage::DELIVERY_DOWNLOAD, [], ['image_ids' => [1], 'bytes' => 101]);

		self::assertSame('EXPORT_SIZE_LIMIT_EXCEEDED', $result['error']);
	}

	public function test_the_member_limit_applies_to_a_member_export(): void
	{
		$runner = $this->runner(new fake_export(), ['phpbb_gallery_export_ucp_max_images' => 1]);

		self::assertSame(1, $runner->get_max_images(job_storage::SCOPE_UCP));
		self::assertSame(5000, $runner->get_max_images(job_storage::SCOPE_ACP));
	}

	public function test_a_member_export_is_always_a_download(): void
	{
		// Even asked for directly, a member job may not put a named file on the server.
		$result = $this->runner($this->make_images(1))
			->create(2, job_storage::SCOPE_UCP, job_storage::DELIVERY_SERVER, [], ['image_ids' => [1], 'bytes' => 11]);

		self::assertSame(job_storage::DELIVERY_DOWNLOAD, $result['state']['delivery']);
		self::assertSame($result['state']['job_id'] . '.zip', $result['state']['archive']);
	}

	public function test_a_server_export_gets_a_readable_dated_name(): void
	{
		$result = $this->runner($this->make_images(1))
			->create(2, job_storage::SCOPE_ACP, job_storage::DELIVERY_SERVER, [1], ['image_ids' => [1], 'bytes' => 11], 'Férias');

		self::assertMatchesRegularExpression('/^gallery-export-ferias-\d{4}-\d{2}-\d{2}-\d{4}\.zip$/', $result['state']['archive']);
	}

	public function test_a_job_runs_one_batch_per_step_until_it_is_ready(): void
	{
		$export = $this->make_images(5);
		$runner = $this->runner($export);

		$state = $runner->create(2, job_storage::SCOPE_ACP, job_storage::DELIVERY_DOWNLOAD, [], ['image_ids' => [1, 2, 3, 4, 5], 'bytes' => 55])['state'];
		self::assertSame(job_storage::STATUS_RUNNING, $state['status']);
		self::assertSame(0, $state['done']);

		$progress = [];
		for ($i = 0; $i < 3; $i++)
		{
			$state = $runner->step($state)['state'];
			$progress[] = $state['done'];
		}

		self::assertSame([2, 4, 5], $progress, 'the batch size is two');
		self::assertSame(job_storage::STATUS_READY, $state['status']);
		self::assertSame(55, $state['bytes']);

		// The finished state survives to the next request, which is what the
		// download controller reads before handing the archive over.
		self::assertSame($state, $this->storage->read_state($state['job_id']));
	}

	public function test_a_finished_job_carries_the_manifest(): void
	{
		$export = $this->make_images(2);
		$runner = $this->runner($export);

		$state = $runner->create(2, job_storage::SCOPE_ACP, job_storage::DELIVERY_DOWNLOAD, [], ['image_ids' => [1, 2], 'bytes' => 22])['state'];
		$state = $runner->step($state)['state'];

		self::assertSame(job_storage::STATUS_READY, $state['status']);

		$zip = new ZipArchive();
		$zip->open($this->storage->get_archive_path($state));
		$names = [];
		for ($i = 0; $i < $zip->numFiles; $i++)
		{
			$names[] = $zip->getNameIndex($i);
		}
		$zip->close();

		self::assertContains(archive::MANIFEST_CSV, $names);
		self::assertContains(archive::MANIFEST_JSON, $names);
		self::assertContains('Album/Picture 1_1.jpg', $names);
	}

	public function test_a_missing_file_is_recorded_without_stopping_the_job(): void
	{
		$export = $this->make_images(2);
		$export->rows[2]['image_filename'] = 'deleted-from-disk.jpg';

		$runner = $this->runner($export);
		$state = $runner->create(2, job_storage::SCOPE_ACP, job_storage::DELIVERY_DOWNLOAD, [], ['image_ids' => [1, 2], 'bytes' => 22])['state'];
		$state = $runner->step($state)['state'];

		self::assertSame(job_storage::STATUS_READY, $state['status']);
		self::assertSame(['EXPORT_ERROR_MISSING_FILE'], $state['errors']);
	}

	public function test_rows_that_disappeared_still_advance_the_cursor(): void
	{
		// The selection is resolved when the job starts; an image deleted while the
		// job runs must not leave the cursor stuck short of the total forever.
		$runner = $this->runner(new fake_export());

		$state = $runner->create(2, job_storage::SCOPE_ACP, job_storage::DELIVERY_DOWNLOAD, [], ['image_ids' => [1, 2, 3], 'bytes' => 33])['state'];
		$state = $runner->step($state)['state'];
		$state = $runner->step($state)['state'];

		self::assertSame(3, $state['done']);
		self::assertSame(job_storage::STATUS_READY, $state['status']);
		self::assertSame([], $state['errors'], 'a row that is simply gone is not an archive failure');

		// Nothing was retrievable, but the manifest still documents the attempt.
		self::assertFileExists($this->storage->get_archive_path($state));
	}

	public function test_stepping_a_finished_job_changes_nothing(): void
	{
		$runner = $this->runner($this->make_images(1));

		$state = $runner->create(2, job_storage::SCOPE_ACP, job_storage::DELIVERY_DOWNLOAD, [], ['image_ids' => [1], 'bytes' => 11])['state'];
		$state = $runner->step($state)['state'];
		$again = $runner->step($state)['state'];

		self::assertSame($state, $again);
	}
}
