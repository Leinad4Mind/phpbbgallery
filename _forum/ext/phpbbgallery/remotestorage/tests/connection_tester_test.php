<?php
/**
 * phpBB Gallery - Remote Storage connection tests
 *
 * @package   phpbbgallery/remotestorage
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\remotestorage\tests;

use phpbbgallery\core\storage\provider_interface;
use phpbbgallery\remotestorage\connection_tester;
use PHPUnit\Framework\TestCase;

final class connection_tester_test extends TestCase
{
	public function test_complete_connection_probe_succeeds_and_removes_the_object(): void
	{
		$stored = null;
		$provider = $this->createMock(provider_interface::class);
		$provider->expects($this->once())->method('prepare')->willReturn(true);
		$provider->expects($this->once())->method('list_objects')->willReturn(['keys' => [], 'cursor' => null]);
		$provider->expects($this->once())->method('write')->willReturnCallback(
			static function (string $variant, string $key, string $file) use (&$stored): bool
			{
				$stored = (string) file_get_contents($file);

				return true;
			}
		);
		$provider->expects($this->once())->method('size')->willReturnCallback(
			static function () use (&$stored): int
			{
				return strlen((string) $stored);
			}
		);
		$provider->expects($this->once())->method('checksum')->willReturnCallback(
			static function () use (&$stored): string
			{
				return hash('sha256', (string) $stored);
			}
		);
		$provider->expects($this->once())->method('open_stream')->willReturnCallback(
			static function () use (&$stored): mixed
			{
				$stream = fopen('php://temp', 'w+b');
				fwrite($stream, (string) $stored);
				rewind($stream);

				return $stream;
			}
		);
		$provider->expects($this->once())->method('delete')->willReturn(true);
		$provider->expects($this->once())->method('exists')->willReturn(false);

		(new connection_tester())->test($provider);
	}

	public function test_failed_verification_still_removes_the_test_object(): void
	{
		$provider = $this->createMock(provider_interface::class);
		$provider->method('prepare')->willReturn(true);
		$provider->method('list_objects')->willReturn(['keys' => [], 'cursor' => null]);
		$provider->method('write')->willReturn(true);
		$provider->method('size')->willReturn(0);
		$provider->expects($this->once())->method('delete')->willReturn(true);

		$this->expectException(\RuntimeException::class);
		$this->expectExceptionMessage('could not be verified');
		(new connection_tester())->test($provider);
	}
}
