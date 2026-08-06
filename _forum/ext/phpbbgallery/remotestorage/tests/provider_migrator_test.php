<?php
// phpcs:disable Generic.Files.OneClassPerFile.MultipleFound -- Focused migration test doubles share this fixture.
/**
 * phpBB Gallery - Remote Storage provider migration tests
 *
 * @package   phpbbgallery/remotestorage
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\remotestorage\tests;

use phpbb\config\config;
use phpbbgallery\core\storage\provider_interface;
use phpbbgallery\remotestorage\migration\provider_migrator;
use phpbbgallery\remotestorage\migration\provider_resolver_interface;
use phpbbgallery\remotestorage\migration\state_store_interface;
use PHPUnit\Framework\TestCase;

final class provider_migrator_test extends TestCase
{
	private string $workspace;

	// phpcs:ignore PhpbbCodingStandard.NamingConventions.LowercaseUnderscoredFunctions.NotAllowed -- PHPUnit lifecycle API.
	protected function setUp(): void
	{
		$this->workspace = sys_get_temp_dir() . '/phpbbgallery-remote-migration-' . bin2hex(random_bytes(6));
	}

	// phpcs:ignore PhpbbCodingStandard.NamingConventions.LowercaseUnderscoredFunctions.NotAllowed -- PHPUnit lifecycle API.
	protected function tearDown(): void
	{
		if (is_dir($this->workspace))
		{
			foreach (glob($this->workspace . '/*') ?: [] as $file)
			{
				unlink($file);
			}
			rmdir($this->workspace);
		}
	}

	public function test_complete_resumable_copy_activates_s3_and_retains_local_objects(): void
	{
		$local = new migration_memory_provider('local');
		$local->put(provider_interface::SOURCE, 'a.jpg', 'source-a');
		$local->put(provider_interface::SOURCE, 'b.jpg', 'source-b');
		$local->put(provider_interface::MEDIUM, 'a.jpg', 'medium-a');
		$local->put(provider_interface::MINI, 'a.jpg', 'mini-a');
		$s3 = new migration_memory_provider('s3');
		$config = $this->config('local');
		$migrator = $this->migrator($config, $local, $s3);

		$state = $migrator->start('s3');
		$this->assertSame('local', $state['source_provider']);
		$this->assertSame('s3', $config['phpbb_gallery_storage_migration_target']);
		for ($step = 0; $step < 10 && $state['status'] !== 'complete'; $step++)
		{
			$state = $migrator->process(1);
		}

		$this->assertSame('complete', $state['status']);
		$this->assertSame(4, $state['copied']);
		$this->assertSame('s3', $config['phpbb_gallery_storage_provider']);
		$this->assertSame('', $config['phpbb_gallery_storage_migration_source']);
		$this->assertSame('', $config['phpbb_gallery_storage_migration_target']);
		$this->assertSame('source-a', $s3->contents(provider_interface::SOURCE, 'a.jpg'));
		$this->assertSame('source-a', $local->contents(provider_interface::SOURCE, 'a.jpg'));
	}

	public function test_registered_non_s3_provider_can_become_active(): void
	{
		$local = new migration_memory_provider('local');
		$local->put(provider_interface::SOURCE, 'a.jpg', 'source-a');
		$dropbox = new migration_memory_provider('dropbox');
		$config = $this->config('local');
		$migrator = $this->migrator($config, $local, $dropbox);

		$state = $migrator->start('dropbox');
		for ($step = 0; $step < 5 && $state['status'] !== 'complete'; $step++)
		{
			$state = $migrator->process();
		}

		$this->assertSame('complete', $state['status']);
		$this->assertSame('dropbox', $config['phpbb_gallery_storage_provider']);
		$this->assertSame('source-a', $dropbox->contents(provider_interface::SOURCE, 'a.jpg'));
	}

	public function test_unregistered_provider_is_rejected(): void
	{
		$local = new migration_memory_provider('local');
		$s3 = new migration_memory_provider('s3');

		$this->expectException(\InvalidArgumentException::class);
		$this->migrator($this->config('local'), $local, $s3)->start('unregistered');
	}

	public function test_failed_batch_preserves_cursor_and_can_be_retried(): void
	{
		$local = new migration_memory_provider('local');
		$local->put(provider_interface::SOURCE, 'a.jpg', 'source-a');
		$s3 = new migration_memory_provider('s3');
		$s3->fail_writes = true;
		$config = $this->config('local');
		$migrator = $this->migrator($config, $local, $s3);
		$migrator->start('s3');

		$failed = $migrator->process(1);
		$this->assertSame('error', $failed['status']);
		$this->assertSame('', $failed['migration_cursor']);
		$this->assertSame(1, $failed['failed']);
		$this->assertSame('local', $config['phpbb_gallery_storage_provider']);

		$s3->fail_writes = false;
		$retried = $migrator->process(1);
		$this->assertSame('medium', $retried['variant']);
		$this->assertSame(1, $retried['copied']);
		$this->assertSame('source-a', $s3->contents(provider_interface::SOURCE, 'a.jpg'));
	}

	public function test_object_changed_during_copy_is_recopied_before_advancing(): void
	{
		$local = new migration_memory_provider('local');
		$local->put(provider_interface::SOURCE, 'a.jpg', 'original');
		$s3 = new migration_memory_provider('s3');
		$s3->after_write = static function () use ($local, $s3): void
		{
			$s3->after_write = null;
			$local->put(provider_interface::SOURCE, 'a.jpg', 'changed');
		};
		$migrator = $this->migrator($this->config('local'), $local, $s3);
		$migrator->start('s3');

		$state = $migrator->process(1);

		$this->assertSame('running', $state['status']);
		$this->assertSame('medium', $state['variant']);
		$this->assertSame('changed', $s3->contents(provider_interface::SOURCE, 'a.jpg'));
	}

	public function test_abort_keeps_source_active_and_disables_mirroring(): void
	{
		$local = new migration_memory_provider('local');
		$s3 = new migration_memory_provider('s3');
		$config = $this->config('local');
		$migrator = $this->migrator($config, $local, $s3);
		$migrator->start('s3');

		$state = $migrator->abort();

		$this->assertSame('aborted', $state['status']);
		$this->assertSame('local', $config['phpbb_gallery_storage_provider']);
		$this->assertSame('', $config['phpbb_gallery_storage_migration_source']);
		$this->assertSame('', $config['phpbb_gallery_storage_migration_target']);
	}

	public function test_interrupted_activation_is_completed_idempotently(): void
	{
		$local = new migration_memory_provider('local');
		$s3 = new migration_memory_provider('s3');
		$config = new config([
			'phpbb_gallery_storage_provider' => 's3',
			'phpbb_gallery_storage_migration_source' => 'local',
			'phpbb_gallery_storage_migration_target' => 's3',
		]);
		$states = new migration_memory_state_store();
		$states->save([
			'source_provider' => 'local', 'target_provider' => 's3', 'variant' => 'mini',
			'migration_cursor' => '', 'copied' => 4, 'skipped' => 0, 'failed' => 0,
			'status' => 'activating', 'started' => 1, 'updated' => 1, 'last_error' => '',
		]);
		$migrator = $this->migrator($config, $local, $s3, $states);

		$state = $migrator->process();

		$this->assertSame('complete', $state['status']);
		$this->assertSame('s3', $config['phpbb_gallery_storage_provider']);
		$this->assertSame('', $config['phpbb_gallery_storage_migration_source']);
		$this->assertSame('', $config['phpbb_gallery_storage_migration_target']);
	}

	private function config(string $active): config
	{
		return new config([
			'phpbb_gallery_storage_provider' => $active,
			'phpbb_gallery_storage_migration_source' => '',
			'phpbb_gallery_storage_migration_target' => '',
		]);
	}

	private function migrator(
		config $config,
		migration_memory_provider $local,
		migration_memory_provider $remote,
		?migration_memory_state_store $states = null
	): provider_migrator
	{
		return new provider_migrator(
			$config,
			new migration_provider_resolver(['local' => $local, $remote->get_id() => $remote]),
			$states ?? new migration_memory_state_store(),
			$this->workspace
		);
	}
}

final class migration_provider_resolver implements provider_resolver_interface
{
	/** @param array<string, provider_interface> $providers */
	public function __construct(private array $providers)
	{
	}

	public function resolve(string $provider_id): provider_interface
	{
		return $this->providers[$provider_id];
	}

	public function remote_provider_ids(): array
	{
		return array_values(array_filter(array_keys($this->providers), static fn (string $id): bool => $id !== 'local'));
	}
}

final class migration_memory_state_store implements state_store_interface
{
	private ?array $state = null;

	public function load(): ?array
	{
		return $this->state;
	}

	public function save(array $state): void
	{
		$this->state = $state;
	}

	public function clear(): void
	{
		$this->state = null;
	}
}

final class migration_memory_provider implements provider_interface
{
	/** @var array<string, array<string, string>> */
	private array $objects = [self::SOURCE => [], self::MEDIUM => [], self::MINI => []];
	public bool $fail_writes = false;
	public ?\Closure $after_write = null;

	public function __construct(private string $id)
	{
	}

	public function put(string $variant, string $key, string $contents): void
	{
		$this->objects[$variant][$key] = $contents;
	}

	public function contents(string $variant, string $key): ?string
	{
		return $this->objects[$variant][$key] ?? null;
	}

	public function get_id(): string
	{
		return $this->id;
	}

	public function prepare(string $variant, string $key): bool
	{
		return true;
	}

	public function write(string $variant, string $key, string $local_file): bool
	{
		if ($this->fail_writes || isset($this->objects[$variant][$key]))
		{
			return false;
		}
		$contents = file_get_contents($local_file);
		if ($contents === false)
		{
			return false;
		}
		$this->objects[$variant][$key] = $contents;
		if ($this->after_write !== null)
		{
			($this->after_write)();
		}

		return true;
	}

	public function replace(string $variant, string $key, string $local_file): bool
	{
		if ($this->fail_writes || !isset($this->objects[$variant][$key]))
		{
			return false;
		}
		$contents = file_get_contents($local_file);
		if ($contents === false)
		{
			return false;
		}
		$this->objects[$variant][$key] = $contents;

		return true;
	}

	public function open_stream(string $variant, string $key): mixed
	{
		if (!isset($this->objects[$variant][$key]))
		{
			return false;
		}
		$stream = fopen('php://temp', 'w+b');
		fwrite($stream, $this->objects[$variant][$key]);
		rewind($stream);

		return $stream;
	}

	public function local_path(string $variant, string $key): ?string
	{
		return null;
	}

	public function exists(string $variant, string $key): bool
	{
		return isset($this->objects[$variant][$key]);
	}

	public function delete(string $variant, string $key): bool
	{
		unset($this->objects[$variant][$key]);

		return true;
	}

	public function size(string $variant, string $key): ?int
	{
		return isset($this->objects[$variant][$key]) ? strlen($this->objects[$variant][$key]) : null;
	}

	public function modified_time(string $variant, string $key): ?int
	{
		return isset($this->objects[$variant][$key]) ? 1 : null;
	}

	public function list_objects(string $variant, ?string $cursor = null, int $limit = 500): array
	{
		$keys = array_keys($this->objects[$variant]);
		sort($keys, SORT_STRING);
		$keys = array_values(array_filter($keys, static fn (string $key): bool => $cursor === null || strcmp($key, $cursor) > 0));
		$more = count($keys) > $limit;
		$keys = array_slice($keys, 0, $limit);

		return ['keys' => $keys, 'cursor' => $more ? (string) end($keys) : null];
	}

	public function checksum(string $variant, string $key, string $algorithm = 'sha256'): ?string
	{
		return isset($this->objects[$variant][$key]) ? hash($algorithm, $this->objects[$variant][$key]) : null;
	}
}
