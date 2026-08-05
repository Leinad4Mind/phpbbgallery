<?php
/**
 * phpBB Gallery - active storage provider and workspace tests
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\tests;

use phpbbgallery\core\config;
use phpbbgallery\core\storage\active_provider;
use phpbbgallery\core\storage\local_provider;
use phpbbgallery\core\storage\provider_interface;
use phpbbgallery\core\storage\workspace;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;

final class storage_provider_test extends TestCase
{
	private string $temporary_directory;

	// phpcs:ignore PhpbbCodingStandard.NamingConventions.LowercaseUnderscoredFunctions.NotAllowed -- PHPUnit lifecycle API.
	protected function setUp(): void
	{
		parent::setUp();
		$this->temporary_directory = sys_get_temp_dir() . '/phpbbgallery-provider-' . bin2hex(random_bytes(6));
		mkdir($this->temporary_directory);
	}

	// phpcs:ignore PhpbbCodingStandard.NamingConventions.LowercaseUnderscoredFunctions.NotAllowed -- PHPUnit lifecycle API.
	protected function tearDown(): void
	{
		$this->remove_directory($this->temporary_directory);
		parent::tearDown();
	}

	public function test_local_is_the_explicit_default_without_container_lookup(): void
	{
		$container = $this->createMock(ContainerInterface::class);
		$container->expects($this->never())->method('has');
		$storage = $this->active('local', $container);

		$this->assertSame('local', $storage->get_id());
	}

	public function test_configured_provider_is_resolved_once_and_all_calls_are_delegated(): void
	{
		$remote = new memory_storage_provider('s3', ['image.jpg' => 'remote-image']);
		$container = $this->createMock(ContainerInterface::class);
		$container->expects($this->once())->method('has')->with('phpbbgallery.storage.provider.s3')->willReturn(true);
		$container->expects($this->once())->method('get')->with('phpbbgallery.storage.provider.s3')->willReturn($remote);
		$storage = $this->active('s3', $container);

		$this->assertSame('s3', $storage->get_id());
		$this->assertTrue($storage->exists(provider_interface::SOURCE, 'image.jpg'));
		$this->assertSame(12, $storage->size(provider_interface::SOURCE, 'image.jpg'));
		$this->assertSame(1785945600, $storage->modified_time(provider_interface::SOURCE, 'image.jpg'));
		$this->assertSame(hash('sha256', 'remote-image'), $storage->checksum(provider_interface::SOURCE, 'image.jpg'));
		$this->assertSame(['keys' => ['image.jpg'], 'cursor' => null], $storage->list_objects(provider_interface::SOURCE));
		$stream = $storage->open_stream(provider_interface::SOURCE, 'image.jpg');
		$this->assertIsResource($stream);
		$this->assertSame('remote-image', stream_get_contents($stream));
		fclose($stream);
	}

	public function test_external_format_derivatives_are_transparently_mapped_to_webp_keys(): void
	{
		$remote = new memory_storage_provider('s3');
		$container = $this->createMock(ContainerInterface::class);
		$container->method('has')->willReturn(true);
		$container->method('get')->willReturn($remote);
		$storage = $this->active('s3', $container);
		$source = $this->temporary_directory . '/derived.webp';
		file_put_contents($source, 'webp-derivative');

		$this->assertTrue($storage->prepare(provider_interface::MEDIUM, 'scan.tiff'));
		$this->assertTrue($storage->write(provider_interface::MEDIUM, 'scan.tiff', $source));
		$this->assertTrue($storage->exists(provider_interface::MEDIUM, 'scan.tiff'));
		$this->assertTrue($remote->exists(provider_interface::MEDIUM, 'scan.tiff.webp'));
		$this->assertFalse($remote->exists(provider_interface::MEDIUM, 'scan.tiff'));
	}

	public function test_missing_provider_never_falls_back_to_local(): void
	{
		$container = $this->createMock(ContainerInterface::class);
		$container->expects($this->once())->method('has')->with('phpbbgallery.storage.provider.s3')->willReturn(false);
		$container->expects($this->never())->method('get');

		$this->expectException(\RuntimeException::class);
		$this->expectExceptionMessage('not available');
		$this->active('s3', $container)->get_id();
	}

	public function test_incompatible_provider_service_is_rejected(): void
	{
		$container = $this->createMock(ContainerInterface::class);
		$container->method('has')->willReturn(true);
		$container->method('get')->willReturn(new memory_storage_provider('azure'));

		$this->expectException(\RuntimeException::class);
		$this->expectExceptionMessage('incompatible');
		$this->active('s3', $container)->get_id();
	}

	public function test_migration_mirrors_create_replace_and_delete_operations(): void
	{
		$remote = new memory_storage_provider('s3');
		$container = $this->createMock(ContainerInterface::class);
		$container->expects($this->once())->method('has')->with('phpbbgallery.storage.provider.s3')->willReturn(true);
		$container->expects($this->once())->method('get')->with('phpbbgallery.storage.provider.s3')->willReturn($remote);
		$storage = $this->active('local', $container, 'local', 's3');
		$source = $this->temporary_directory . '/migration-source.jpg';
		file_put_contents($source, 'first');

		$this->assertTrue($storage->prepare(provider_interface::SOURCE, 'image.jpg'));
		$this->assertTrue($storage->write(provider_interface::SOURCE, 'image.jpg', $source));
		$this->assertSame(hash('sha256', 'first'), $remote->checksum(provider_interface::SOURCE, 'image.jpg'));

		$this->assertTrue($remote->delete(provider_interface::SOURCE, 'image.jpg'));
		file_put_contents($source, 'second');
		$replaced = $storage->replace(provider_interface::SOURCE, 'image.jpg', $source);
		$this->assertSame(hash('sha256', 'second'), $remote->checksum(provider_interface::SOURCE, 'image.jpg'));
		$this->assertSame(hash('sha256', 'second'), $storage->checksum(provider_interface::SOURCE, 'image.jpg'));
		$this->assertTrue($replaced);

		file_put_contents($source, 'third');
		$this->assertTrue($storage->replace(provider_interface::SOURCE, 'image.jpg', $source));
		$this->assertSame(hash('sha256', 'third'), $remote->checksum(provider_interface::SOURCE, 'image.jpg'));

		$this->assertTrue($storage->delete(provider_interface::SOURCE, 'image.jpg'));
		$this->assertFalse($remote->exists(provider_interface::SOURCE, 'image.jpg'));
		$this->assertFalse($storage->exists(provider_interface::SOURCE, 'image.jpg'));
	}

	public function test_failed_mirror_creation_removes_the_new_primary_object(): void
	{
		$remote = new memory_storage_provider('s3');
		$remote->fail_writes = true;
		$container = $this->createMock(ContainerInterface::class);
		$container->method('has')->willReturn(true);
		$container->method('get')->willReturn($remote);
		$storage = $this->active('local', $container, 'local', 's3');
		$source = $this->temporary_directory . '/migration-failure.jpg';
		file_put_contents($source, 'image');

		$this->assertTrue($storage->prepare(provider_interface::SOURCE, 'image.jpg'));
		$this->assertFalse($storage->write(provider_interface::SOURCE, 'image.jpg', $source));
		$this->assertFalse($storage->exists(provider_interface::SOURCE, 'image.jpg'));
	}

	/** @dataProvider invalid_provider_id_provider */
	public function test_invalid_provider_identifiers_are_rejected_before_service_lookup(string $provider_id): void
	{
		$container = $this->createMock(ContainerInterface::class);
		$container->expects($this->never())->method('has');

		$this->expectException(\RuntimeException::class);
		$this->expectExceptionMessage('identifier is invalid');
		$this->active($provider_id, $container)->get_id();
	}

	public static function invalid_provider_id_provider(): array
	{
		return [
			'empty' => [''],
			'service traversal' => ['../s3'],
			'service syntax' => ['s3/service'],
			'too long' => ['a' . str_repeat('b', 64)],
		];
	}

	public function test_workspace_reuses_a_safe_local_path_without_owning_it(): void
	{
		$local = $this->local();
		$input = $this->temporary_directory . '/input.jpg';
		file_put_contents($input, 'local-image');
		$this->assertTrue($local->write(provider_interface::SOURCE, 'image.jpg', $input));
		$workspace = new workspace($local, $this->temporary_directory . '/workspace');

		$object = $workspace->materialize(provider_interface::SOURCE, 'image.jpg');

		$this->assertFalse($object->is_temporary());
		$this->assertSame('local-image', file_get_contents($object->get_path()));
		$object->release();
		$this->assertFileExists((string) $local->local_path(provider_interface::SOURCE, 'image.jpg'));
	}

	public function test_local_object_listing_is_recursive_deterministic_and_paginated(): void
	{
		$local = $this->local();
		$input = $this->temporary_directory . '/input.jpg';
		file_put_contents($input, 'image');
		foreach (['z.jpg', '7/71/a.jpg', 'a.jpg'] as $key)
		{
			$this->assertTrue($local->write(provider_interface::SOURCE, $key, $input));
		}

		$first = $local->list_objects(provider_interface::SOURCE, null, 2);
		$this->assertSame(['7/71/a.jpg', 'a.jpg'], $first['keys']);
		$this->assertSame('a.jpg', $first['cursor']);
		$this->assertSame(['keys' => ['z.jpg'], 'cursor' => null], $local->list_objects(provider_interface::SOURCE, $first['cursor'], 2));
	}

	public function test_local_object_listing_rejects_an_invalid_cursor(): void
	{
		$this->expectException(\InvalidArgumentException::class);
		$this->local()->list_objects(provider_interface::SOURCE, '../outside');
	}

	public function test_workspace_materializes_and_cleans_a_verified_remote_object(): void
	{
		$workspace_root = $this->temporary_directory . '/workspace';
		$workspace = new workspace(new memory_storage_provider('s3', ['folder/image.jpg' => 'remote-image']), $workspace_root);

		$object = $workspace->materialize(provider_interface::SOURCE, 'folder/image.jpg');
		$path = $object->get_path();
		$expected_root = rtrim(str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $workspace_root), DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;

		$this->assertTrue($object->is_temporary());
		$this->assertStringStartsWith($expected_root, $path);
		$this->assertStringEndsWith('.jpg', $path);
		$this->assertSame('remote-image', file_get_contents($path));
		$object->release();
		$this->assertFileDoesNotExist($path);
	}

	public function test_workspace_rejects_a_malformed_provider_listing(): void
	{
		$provider = $this->createMock(provider_interface::class);
		$provider->method('list_objects')->willReturn(['keys' => ['valid.jpg', 42], 'cursor' => null]);
		$workspace = new workspace($provider, $this->temporary_directory . '/workspace');

		$this->expectException(\RuntimeException::class);
		$this->expectExceptionMessage('invalid object key');
		$workspace->list_objects(provider_interface::SOURCE);
	}

	public function test_workspace_removes_partial_file_when_size_verification_fails(): void
	{
		$remote = new memory_storage_provider('s3', ['image.jpg' => 'remote-image']);
		$remote->reported_size = 999;
		$workspace_root = $this->temporary_directory . '/workspace';
		$workspace = new workspace($remote, $workspace_root);

		try
		{
			$workspace->materialize(provider_interface::SOURCE, 'image.jpg');
			$this->fail('Size mismatch should fail materialization.');
		}
		catch (\RuntimeException $exception)
		{
			$this->assertStringContainsString('failed local verification', $exception->getMessage());
		}

		$this->assertSame([], glob($workspace_root . '/*') ?: []);
	}

	public function test_workspace_removes_partial_file_when_checksum_verification_fails(): void
	{
		$remote = new memory_storage_provider('s3', ['image.jpg' => 'remote-image']);
		$remote->reported_checksum = str_repeat('0', 64);
		$workspace_root = $this->temporary_directory . '/workspace';
		$workspace = new workspace($remote, $workspace_root);

		$this->expectException(\RuntimeException::class);
		try
		{
			$workspace->materialize(provider_interface::SOURCE, 'image.jpg');
		}
		finally
		{
			$this->assertSame([], glob($workspace_root . '/*') ?: []);
		}
	}

	public function test_workspace_refuses_an_unsafe_root(): void
	{
		$root = $this->temporary_directory . '/workspace';
		file_put_contents($root, 'not-a-directory');
		$workspace = new workspace(new memory_storage_provider('s3', ['image.jpg' => 'remote-image']), $root);

		$this->expectException(\RuntimeException::class);
		$this->expectExceptionMessage('workspace is unavailable');
		$workspace->materialize(provider_interface::SOURCE, 'image.jpg');
	}

	public function test_workspace_publishes_and_verifies_a_new_object(): void
	{
		$provider = new memory_storage_provider('s3');
		$workspace = new workspace($provider, $this->temporary_directory . '/workspace');
		$source = $this->temporary_directory . '/new.jpg';
		file_put_contents($source, 'new-image');

		$workspace->publish(provider_interface::SOURCE, 'folder/new.jpg', $source);

		$this->assertTrue($provider->exists(provider_interface::SOURCE, 'folder/new.jpg'));
		$this->assertSame(hash('sha256', 'new-image'), $provider->checksum(provider_interface::SOURCE, 'folder/new.jpg'));
	}

	public function test_failed_publication_verification_removes_the_new_object(): void
	{
		$provider = new memory_storage_provider('s3');
		$provider->reported_checksum = str_repeat('0', 64);
		$workspace = new workspace($provider, $this->temporary_directory . '/workspace');
		$source = $this->temporary_directory . '/new.jpg';
		file_put_contents($source, 'new-image');

		$this->expectException(\RuntimeException::class);
		try
		{
			$workspace->publish(provider_interface::SOURCE, 'new.jpg', $source);
		}
		finally
		{
			$this->assertFalse($provider->exists(provider_interface::SOURCE, 'new.jpg'));
		}
	}

	public function test_workspace_replaces_and_verifies_an_existing_object(): void
	{
		$provider = new memory_storage_provider('s3', ['image.jpg' => 'old-image']);
		$workspace = new workspace($provider, $this->temporary_directory . '/workspace');
		$source = $this->temporary_directory . '/replacement.jpg';
		file_put_contents($source, 'replacement');

		$workspace->replace(provider_interface::SOURCE, 'image.jpg', $source);

		$this->assertSame(hash('sha256', 'replacement'), $provider->checksum(provider_interface::SOURCE, 'image.jpg'));
	}

	private function active(
		string $provider_id,
		ContainerInterface $container,
		string $migration_source = '',
		string $migration_target = ''
	): active_provider
	{
		$gallery_config = new config(new \phpbb\config\config([
			'phpbb_gallery_storage_provider' => $provider_id,
			'phpbb_gallery_storage_migration_source' => $migration_source,
			'phpbb_gallery_storage_migration_target' => $migration_target,
		]));

		return new active_provider($gallery_config, $container, $this->local());
	}

	private function local(): local_provider
	{
		return new local_provider(
			$this->temporary_directory . '/source',
			$this->temporary_directory . '/medium',
			$this->temporary_directory . '/mini'
		);
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

// phpcs:disable Generic.Files.OneClassPerFile.MultipleFound -- Provider double belongs to this isolated storage test.
final class memory_storage_provider implements provider_interface
{
	public ?int $reported_size = null;
	public ?string $reported_checksum = null;
	public bool $fail_writes = false;

	public function __construct(private string $id, private array $objects = [])
	{
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
		if ($this->fail_writes)
		{
			return false;
		}
		$contents = @file_get_contents($local_file);
		if ($contents === false)
		{
			return false;
		}
		$this->objects[$key] = $contents;

		return true;
	}

	public function replace(string $variant, string $key, string $local_file): bool
	{
		if (!isset($this->objects[$key]))
		{
			return false;
		}

		return $this->write($variant, $key, $local_file);
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
		unset($this->objects[$key]);

		return true;
	}

	public function size(string $variant, string $key): ?int
	{
		return $this->reported_size ?? (isset($this->objects[$key]) ? strlen($this->objects[$key]) : null);
	}

	public function modified_time(string $variant, string $key): ?int
	{
		return isset($this->objects[$key]) ? 1785945600 : null;
	}

	public function list_objects(string $variant, ?string $cursor = null, int $limit = 500): array
	{
		$keys = array_keys($this->objects);
		sort($keys, SORT_STRING);
		$keys = array_values(array_filter($keys, static fn (string $key): bool => $cursor === null || strcmp($key, $cursor) > 0));
		$has_more = count($keys) > $limit;
		$keys = array_slice($keys, 0, $limit);

		return ['keys' => $keys, 'cursor' => $has_more ? (string) end($keys) : null];
	}

	public function checksum(string $variant, string $key, string $algorithm = 'sha256'): ?string
	{
		return $this->reported_checksum ?? (isset($this->objects[$key]) ? hash($algorithm, $this->objects[$key]) : null);
	}
}
