<?php
/**
 * phpBB Gallery - SFTP provider tests
 *
 * @package   phpbbgallery/remotestorage
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\remotestorage\tests;

use phpbbgallery\core\storage\provider_interface;
use phpbbgallery\remotestorage\sftp\client_interface;
use phpbbgallery\remotestorage\sftp\configuration;
use phpbbgallery\remotestorage\sftp\provider;
use PHPUnit\Framework\TestCase;

final class sftp_provider_test extends TestCase
{
	private string $file;

	// phpcs:ignore PhpbbCodingStandard.NamingConventions.LowercaseUnderscoredFunctions.NotAllowed -- PHPUnit lifecycle API.
	protected function setUp(): void
	{
		$this->file = tempnam(sys_get_temp_dir(), 'gallery-sftp-');
		file_put_contents($this->file, 'gallery-image');
	}

	// phpcs:ignore PhpbbCodingStandard.NamingConventions.LowercaseUnderscoredFunctions.NotAllowed -- PHPUnit lifecycle API.
	protected function tearDown(): void
	{
		is_file($this->file) && unlink($this->file);
	}

	public function test_complete_object_lifecycle_and_checksum(): void
	{
		$client = new fake_sftp_client();
		$provider = $this->provider($client);

		$this->assertTrue($provider->prepare(provider_interface::SOURCE, '7/71/image.jpg'));
		$this->assertTrue($provider->write(provider_interface::SOURCE, '7/71/image.jpg', $this->file));
		$this->assertFalse($provider->write(provider_interface::SOURCE, '7/71/image.jpg', $this->file));
		$this->assertTrue($provider->exists(provider_interface::SOURCE, '7/71/image.jpg'));
		$this->assertSame(13, $provider->size(provider_interface::SOURCE, '7/71/image.jpg'));
		$this->assertSame(hash('sha256', 'gallery-image'), $provider->checksum(provider_interface::SOURCE, '7/71/image.jpg'));

		file_put_contents($this->file, 'replacement');
		$this->assertTrue($provider->replace(provider_interface::SOURCE, '7/71/image.jpg', $this->file));
		$this->assertSame(hash('sha256', 'replacement'), $provider->checksum(provider_interface::SOURCE, '7/71/image.jpg'));
		$this->assertTrue($provider->delete(provider_interface::SOURCE, '7/71/image.jpg'));
		$this->assertFalse($provider->exists(provider_interface::SOURCE, '7/71/image.jpg'));
	}

	public function test_listing_is_deterministic_and_cursor_paginated(): void
	{
		$client = new fake_sftp_client([
			'/private/gallery/source/z.jpg' => 'z',
			'/private/gallery/source/a.jpg' => 'a',
			'/private/gallery/source/7/71/image.jpg' => 'i',
		]);
		$provider = $this->provider($client);

		$first = $provider->list_objects(provider_interface::SOURCE, null, 2);
		$this->assertSame(['7/71/image.jpg', 'a.jpg'], $first['keys']);
		$this->assertSame('a.jpg', $first['cursor']);
		$this->assertSame(['keys' => ['z.jpg'], 'cursor' => null], $provider->list_objects(provider_interface::SOURCE, 'a.jpg', 2));
	}

	/** @dataProvider invalid_configuration_provider */
	public function test_configuration_rejects_unsafe_values(array $arguments): void
	{
		$this->expectException(\InvalidArgumentException::class);
		new configuration(...$arguments);
	}

	public static function invalid_configuration_provider(): array
	{
		$valid = ['sftp.example.test', 22, 'gallery', 'secret', str_repeat('a', 40), '/private/gallery'];

		return [
			'host injection' => [['host' . chr(10) . 'invalid', ...array_slice($valid, 1)]],
			'invalid port' => [[$valid[0], 0, ...array_slice($valid, 2)]],
			'unpinned host' => [[...array_slice($valid, 0, 4), '', $valid[5]]],
			'root traversal' => [[...array_slice($valid, 0, 5), '/private/../outside']],
		];
	}

	public function test_native_client_fails_closed_without_ssh2_extension(): void
	{
		if (function_exists('ssh2_connect'))
		{
			$this->markTestSkipped('The local PHP runtime has PECL SSH2 enabled.');
		}
		$client = new \phpbbgallery\remotestorage\sftp\native_client($this->configuration());

		$this->expectException(\RuntimeException::class);
		$this->expectExceptionMessage('PECL SSH2');
		$client->stat('/private/gallery/source/image.jpg');
	}

	private function provider(fake_sftp_client $client): provider
	{
		return new provider($this->configuration(), $client);
	}

	private function configuration(): configuration
	{
		return new configuration('sftp.example.test', 22, 'gallery', 'secret', str_repeat('a', 40), '/private/gallery');
	}
}

// phpcs:disable Generic.Files.OneClassPerFile.MultipleFound -- Test double belongs to this provider suite.
final class fake_sftp_client implements client_interface
{
	/** @param array<string, string> $files */
	public function __construct(private array $files = [])
	{
	}

	public function ensure_directory(string $path): bool
 {
 return str_starts_with($path, '/private/gallery/'); }

	public function upload(string $remote_path, string $local_file, bool $create_only): bool
	{
		if ($create_only && isset($this->files[$remote_path]))
		{
			return false;
		}
		$data = file_get_contents($local_file);
		if (!is_string($data))
		{
			return false;
		}
		$this->files[$remote_path] = $data;

		return true;
	}

	public function open_read(string $path): mixed
	{
		if (!isset($this->files[$path]))
		{
			return false;
		}
		$stream = fopen('php://temp', 'w+b');
		fwrite($stream, $this->files[$path]);
		rewind($stream);

		return $stream;
	}

	public function stat(string $path): ?array
	{
		return isset($this->files[$path]) ? ['size' => strlen($this->files[$path]), 'mtime' => 1785945600] : null;
	}

	public function delete(string $path): bool
	{
		unset($this->files[$path]);

		return true;
	}

	public function list_files(string $root): iterable
	{
		$prefix = rtrim($root, '/') . '/';
		$keys = [];
		foreach (array_keys($this->files) as $path)
		{
			if (str_starts_with($path, $prefix))
			{
				$keys[] = substr($path, strlen($prefix));
			}
		}
		sort($keys, SORT_STRING);

		yield from $keys;
	}
}
