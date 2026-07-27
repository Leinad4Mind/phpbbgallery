<?php
/**
 * phpBB Gallery - Export Extension
 *
 * @package   phpbbgallery/export
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

use PHPUnit\Framework\TestCase;
use phpbbgallery\export\cron\prune_exports;
use phpbbgallery\export\job_storage;

class prune_test extends TestCase
{
	private string $directory;
	private job_storage $storage;

	protected function setUp(): void
	{
		$this->directory = sys_get_temp_dir() . '/phpbbgallery_prune_' . bin2hex(random_bytes(6));
		mkdir($this->directory, 0777, true);
		$this->storage = new job_storage($this->directory);
	}

	protected function tearDown(): void
	{
		if (!is_dir($this->directory))
		{
			return;
		}

		foreach (array_diff((array) scandir($this->directory), ['.', '..']) as $file)
		{
			@unlink($this->directory . '/' . $file);
		}
		@rmdir($this->directory);
	}

	private function write_job(string $letter, string $delivery, int $created, string $archive): void
	{
		$job_id = str_repeat($letter, 32);

		$this->storage->write_state($job_id, [
			'job_id' => $job_id,
			'owner_id' => 2,
			'scope' => job_storage::SCOPE_ACP,
			'delivery' => $delivery,
			'archive' => $archive,
			'created' => $created,
			'album_ids' => [],
			'image_ids' => [1],
			'done' => 1,
			'total' => 1,
			'bytes' => 10,
			'status' => job_storage::STATUS_READY,
			'errors' => [],
		]);

		file_put_contents($this->directory . '/' . $archive, 'zip');
	}

	public function test_the_task_waits_an_hour_between_runs(): void
	{
		$recent = new prune_exports(new \phpbb\config\config([
			'phpbb_gallery_export_prune_time' => time(),
			'phpbb_gallery_export_ttl' => 86400,
		]), $this->storage);

		$stale = new prune_exports(new \phpbb\config\config([
			'phpbb_gallery_export_prune_time' => time() - 7200,
			'phpbb_gallery_export_ttl' => 86400,
		]), $this->storage);

		self::assertFalse($recent->should_run());
		self::assertTrue($stale->should_run());
		self::assertTrue($stale->is_runnable());
	}

	public function test_only_expired_downloads_are_removed(): void
	{
		$now = time();

		$this->write_job('a', job_storage::DELIVERY_DOWNLOAD, $now - 90000, str_repeat('a', 32) . '.zip');
		$this->write_job('b', job_storage::DELIVERY_DOWNLOAD, $now - 60, str_repeat('b', 32) . '.zip');
		$this->write_job('c', job_storage::DELIVERY_SERVER, $now - 900000, 'gallery-export-2026-07-27-1430.zip');

		$config = new \phpbb\config\config([
			'phpbb_gallery_export_prune_time' => 0,
			'phpbb_gallery_export_ttl' => 86400,
		]);

		(new prune_exports($config, $this->storage))->run();

		self::assertFalse($this->storage->read_state(str_repeat('a', 32)), 'the expired download is gone');
		self::assertFileDoesNotExist($this->directory . '/' . str_repeat('a', 32) . '.zip');

		self::assertNotFalse($this->storage->read_state(str_repeat('b', 32)), 'a fresh download is kept');

		// The admin asked for this one to stay on the server so it could be picked
		// up over FTP; age is not a reason to throw it away.
		self::assertNotFalse($this->storage->read_state(str_repeat('c', 32)));
		self::assertFileExists($this->directory . '/gallery-export-2026-07-27-1430.zip');
	}

	public function test_the_run_records_when_it_last_happened(): void
	{
		$config = new \phpbb\config\config([
			'phpbb_gallery_export_prune_time' => 0,
			'phpbb_gallery_export_ttl' => 86400,
		]);

		(new prune_exports($config, $this->storage))->run();

		self::assertGreaterThan(0, (int) $config['phpbb_gallery_export_prune_time']);
	}
}
