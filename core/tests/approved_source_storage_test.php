<?php
/**
 * phpBB Gallery - Core Extension tests
 *
 * @package   phpbbgallery/core
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\tests;

use phpbbgallery\core\image\image;
use phpbbgallery\core\storage\provider_interface;
use phpbbgallery\core\storage\workspace;
use PHPUnit\Framework\TestCase;

final class approved_source_storage_test extends TestCase
{
	private string $root;

	// phpcs:ignore PhpbbCodingStandard.NamingConventions.LowercaseUnderscoredFunctions.NotAllowed -- PHPUnit lifecycle API.
	protected function setUp(): void
	{
		$this->root = sys_get_temp_dir() . '/phpbbgallery-approved-source-' . bin2hex(random_bytes(6)) . '/';
	}

	// phpcs:ignore PhpbbCodingStandard.NamingConventions.LowercaseUnderscoredFunctions.NotAllowed -- PHPUnit lifecycle API.
	protected function tearDown(): void
	{
		if (!is_dir($this->root))
		{
			return;
		}
		foreach (array_diff((array) scandir($this->root), ['.', '..']) as $name)
		{
			@unlink($this->root . $name);
		}
		@rmdir($this->root);
	}

	public function test_approval_exposes_verified_remote_source_only_during_dispatch(): void
	{
		$contents = 'provider-backed original';
		$provider = $this->createMock(provider_interface::class);
		$provider->method('local_path')->willReturn(null);
		$provider->method('open_stream')->willReturnCallback(static function () use ($contents) {
			$stream = fopen('php://temp', 'w+b');
			fwrite($stream, $contents);
			rewind($stream);

			return $stream;
		});
		$provider->method('size')->willReturn(strlen($contents));
		$provider->method('checksum')->willReturn(hash('sha256', $contents));
		$workspace = new workspace($provider, $this->root);

		$dispatcher = $this->createMock(\phpbb\event\dispatcher_interface::class);
		$dispatcher->expects($this->once())
			->method('trigger_event')
			->with('phpbbgallery.core.image.approve_after', $this->callback(static function (array $event): bool {
				$path = $event['approved_images'][0]['source_path'] ?? '';

				return $event['album_id'] === 9 && is_file($path)
					&& file_get_contents($path) === 'provider-backed original';
			}))
			->willReturnArgument(1);

		$service = (new \ReflectionClass(image::class))->newInstanceWithoutConstructor();
		$reflection = new \ReflectionClass($service);
		$reflection->getProperty('storage_workspace')->setValue($service, $workspace);
		$reflection->getProperty('phpbb_dispatcher')->setValue($service, $dispatcher);
		$reflection->getMethod('notify_approved_images')->invoke($service, [[
			'image_id' => 3,
			'image_filename' => 'remote.jpg',
		]], 9);

		$this->assertSame([], array_diff((array) scandir($this->root), ['.', '..']));
	}
}
