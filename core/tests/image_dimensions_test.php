<?php
/**
 * phpBB Gallery - persisted image dimension tests
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\tests;

use phpbbgallery\core\image\dimensions;
use phpbbgallery\core\image\format_registry;
use phpbbgallery\core\storage\local_provider;
use phpbbgallery\core\storage\workspace;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;

final class image_dimensions_test extends TestCase
{
	private string $root;
	private dimensions $dimensions;

	// phpcs:ignore PhpbbCodingStandard.NamingConventions.LowercaseUnderscoredFunctions.NotAllowed -- PHPUnit lifecycle API.
	protected function setUp(): void
	{
		$this->root = sys_get_temp_dir() . '/phpbbgallery-dimensions-' . bin2hex(random_bytes(6));
		mkdir($this->root . '/source', 0755, true);
		$dispatcher = $this->createMock(\phpbb\event\dispatcher_interface::class);
		$dispatcher->method('trigger_event')->willReturnCallback(static fn (string $event, array $data): array => $data);
		$registry = new format_registry($dispatcher, $this->createMock(ContainerInterface::class));
		$provider = new local_provider($this->root . '/source', $this->root . '/medium', $this->root . '/mini');
		$this->dimensions = new dimensions($registry, new workspace($provider, $this->root . '/workspace'));
	}

	// phpcs:ignore PhpbbCodingStandard.NamingConventions.LowercaseUnderscoredFunctions.NotAllowed -- PHPUnit lifecycle API.
	protected function tearDown(): void
	{
		$this->remove_directory($this->root);
	}

	public function test_reads_a_standard_image_from_file_and_storage(): void
	{
		$path = $this->root . '/source/sample.png';
		$image = imagecreatetruecolor(2, 3);
		imagepng($image, $path);
		$image = null;

		$this->assertSame(['width' => 2, 'height' => 3], $this->dimensions->inspect_file('sample.png', $path));
		$this->assertSame(['width' => 2, 'height' => 3], $this->dimensions->inspect_source('sample.png'));
	}

	public function test_missing_or_invalid_files_fail_closed(): void
	{
		$invalid = $this->root . '/invalid.jpg';
		file_put_contents($invalid, 'not an image');

		$this->assertNull($this->dimensions->inspect_file('missing.jpg', $this->root . '/missing.jpg'));
		$this->assertNull($this->dimensions->inspect_file('invalid.jpg', $invalid));
		$this->assertNull($this->dimensions->inspect_source('missing.jpg'));
	}

	private function remove_directory(string $directory): void
	{
		if (!is_dir($directory))
		{
			return;
		}
		foreach (array_diff(scandir($directory) ?: [], ['.', '..']) as $name)
		{
			$path = $directory . '/' . $name;
			is_dir($path) && !is_link($path) ? $this->remove_directory($path) : @unlink($path);
		}
		@rmdir($directory);
	}
}
