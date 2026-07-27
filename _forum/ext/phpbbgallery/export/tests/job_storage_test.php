<?php
/**
 * phpBB Gallery - Export Extension
 *
 * @package   phpbbgallery/export
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

use PHPUnit\Framework\TestCase;
use phpbbgallery\export\job_storage;

class job_storage_test extends TestCase
{
	private string $directory;
	private job_storage $storage;

	protected function setUp(): void
	{
		$this->directory = sys_get_temp_dir() . '/phpbbgallery_export_' . bin2hex(random_bytes(6));
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

	private function state(array $overrides = []): array
	{
		$job_id = $overrides['job_id'] ?? str_repeat('a', 32);

		return array_merge([
			'job_id' => $job_id,
			'owner_id' => 2,
			'scope' => job_storage::SCOPE_ACP,
			'delivery' => job_storage::DELIVERY_DOWNLOAD,
			'archive' => $job_id . '.zip',
			'created' => 1785109307,
			'album_ids' => [1, 2],
			'image_ids' => [10, 11, 12],
			'done' => 0,
			'total' => 3,
			'bytes' => 0,
			'status' => job_storage::STATUS_RUNNING,
			'errors' => [],
		], $overrides);
	}

	public function test_state_round_trips(): void
	{
		$state = $this->state();

		self::assertTrue($this->storage->write_state($state['job_id'], $state));
		self::assertSame($state, $this->storage->read_state($state['job_id']));
	}

	public function test_a_malformed_job_id_is_refused(): void
	{
		self::assertFalse($this->storage->get_state_path('nope'));
		self::assertFalse($this->storage->get_state_path('../../etc/passwd'));
		self::assertFalse($this->storage->read_state(str_repeat('A', 32)), 'uppercase is not the generated form');
	}

	public function test_a_state_whose_keys_do_not_match_is_refused(): void
	{
		$state = $this->state();
		unset($state['bytes']);

		self::assertFalse($this->storage->write_state($state['job_id'] ?? str_repeat('a', 32), $state));
	}

	public function test_a_state_with_the_wrong_types_is_refused(): void
	{
		self::assertFalse($this->storage->write_state(str_repeat('a', 32), $this->state(['owner_id' => 'two'])));
		self::assertFalse($this->storage->write_state(str_repeat('a', 32), $this->state(['image_ids' => [10, 'x']])));
		self::assertFalse($this->storage->write_state(str_repeat('a', 32), $this->state(['status' => 'paused'])));
		self::assertFalse($this->storage->write_state(str_repeat('a', 32), $this->state(['done' => 9])), 'the cursor may not pass the total');
		self::assertFalse($this->storage->write_state(str_repeat('a', 32), $this->state(['total' => 99])), 'the total must match the list');
	}

	public function test_a_state_may_not_name_an_archive_outside_the_directory(): void
	{
		self::assertFalse($this->storage->write_state(str_repeat('a', 32), $this->state(['archive' => '../evil.zip'])));
		self::assertFalse($this->storage->write_state(str_repeat('a', 32), $this->state(['archive' => 'sub/dir.zip'])));
		self::assertFalse($this->storage->write_state(str_repeat('a', 32), $this->state(['archive' => 'evil.php'])));
	}

	public function test_a_member_job_may_never_claim_a_server_archive(): void
	{
		// Members have no FTP access, so a named file in the shared directory is
		// not something a member-created job is allowed to produce.
		$state = $this->state([
			'scope' => job_storage::SCOPE_UCP,
			'delivery' => job_storage::DELIVERY_SERVER,
			'archive' => 'gallery-export-2026-07-27-1430.zip',
		]);

		self::assertFalse($this->storage->write_state($state['job_id'], $state));
	}

	public function test_a_state_written_under_another_id_is_refused(): void
	{
		self::assertFalse($this->storage->write_state(str_repeat('b', 32), $this->state()));
	}

	public function test_a_truncated_file_reads_back_as_missing(): void
	{
		$state = $this->state();
		$this->storage->write_state($state['job_id'], $state);

		$path = $this->storage->get_state_path($state['job_id']);
		file_put_contents($path, '{"job_id":');

		self::assertFalse($this->storage->read_state($state['job_id']));
	}

	public function test_jobs_are_listed_newest_first_and_filtered_by_owner(): void
	{
		$this->storage->write_state(str_repeat('a', 32), $this->state([
			'job_id' => str_repeat('a', 32), 'archive' => str_repeat('a', 32) . '.zip', 'owner_id' => 2, 'created' => 1000,
		]));
		$this->storage->write_state(str_repeat('b', 32), $this->state([
			'job_id' => str_repeat('b', 32), 'archive' => str_repeat('b', 32) . '.zip', 'owner_id' => 3, 'created' => 2000,
		]));
		$this->storage->write_state(str_repeat('c', 32), $this->state([
			'job_id' => str_repeat('c', 32), 'archive' => str_repeat('c', 32) . '.zip', 'owner_id' => 2, 'created' => 3000,
		]));

		self::assertSame(
			[str_repeat('c', 32), str_repeat('b', 32), str_repeat('a', 32)],
			array_keys($this->storage->all_jobs())
		);
		self::assertSame(
			[str_repeat('c', 32), str_repeat('a', 32)],
			array_keys($this->storage->list_for_owner(2))
		);
	}

	public function test_only_downloadable_jobs_ever_expire(): void
	{
		$now = 100000;

		$this->storage->write_state(str_repeat('a', 32), $this->state([
			'job_id' => str_repeat('a', 32), 'archive' => str_repeat('a', 32) . '.zip',
			'delivery' => job_storage::DELIVERY_DOWNLOAD, 'created' => $now - 90000,
		]));
		$this->storage->write_state(str_repeat('b', 32), $this->state([
			'job_id' => str_repeat('b', 32), 'archive' => 'gallery-export-2026-07-27-1430.zip',
			'delivery' => job_storage::DELIVERY_SERVER, 'created' => $now - 900000,
		]));
		$this->storage->write_state(str_repeat('c', 32), $this->state([
			'job_id' => str_repeat('c', 32), 'archive' => str_repeat('c', 32) . '.zip',
			'delivery' => job_storage::DELIVERY_DOWNLOAD, 'created' => $now - 10,
		]));

		// The server-side archive is older than everything else and still survives:
		// it exists so it can be collected over FTP whenever the admin gets to it.
		self::assertSame([str_repeat('a', 32)], array_keys($this->storage->expired(86400, $now)));
	}

	public function test_removing_a_job_takes_its_archive_with_it(): void
	{
		$state = $this->state();
		$this->storage->write_state($state['job_id'], $state);

		$archive = $this->storage->get_archive_path($state);
		file_put_contents($archive, 'zip');

		self::assertTrue($this->storage->remove_job($state));
		self::assertFileDoesNotExist($archive);
		self::assertFalse($this->storage->read_state($state['job_id']));
	}

	public function test_reserving_an_archive_name_appends_a_counter(): void
	{
		$first = $this->storage->reserve_archive_name('gallery-export-2026-07-27-1430.zip');
		$second = $this->storage->reserve_archive_name('gallery-export-2026-07-27-1430.zip');

		self::assertSame('gallery-export-2026-07-27-1430.zip', $first);
		self::assertSame('gallery-export-2026-07-27-1430_1.zip', $second);
	}

	public function test_an_unsafe_archive_name_is_never_reserved(): void
	{
		self::assertFalse($this->storage->reserve_archive_name('../escape.zip'));
		self::assertFalse($this->storage->reserve_archive_name('shell.php'));
		self::assertFalse($this->storage->reserve_archive_name('.hidden.zip'));
	}
}
