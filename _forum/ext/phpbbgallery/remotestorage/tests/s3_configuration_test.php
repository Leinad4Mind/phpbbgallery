<?php
/**
 * phpBB Gallery - S3 configuration tests
 *
 * @package   phpbbgallery/remotestorage
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\remotestorage\tests;

use phpbbgallery\core\storage\provider_interface;
use phpbbgallery\remotestorage\providers\s3\configuration;
use PHPUnit\Framework\TestCase;

final class s3_configuration_test extends TestCase
{
	public function test_builds_encoded_path_style_urls_and_variant_prefixes(): void
	{
		$config = new configuration('https://nas.example:9000/storage/', 'gallery-bucket', 'boards/main');

		$this->assertSame(
			'https://nas.example:9000/storage/gallery-bucket/boards/main/source/7/71/a%20file.jpg',
			$config->object_url(provider_interface::SOURCE, '7/71/a file.jpg')
		);
		$this->assertSame('boards/main/mini/', $config->variant_prefix(provider_interface::MINI));
		$this->assertSame(
			'7/71/a file.jpg',
			$config->relative_key(provider_interface::SOURCE, 'boards/main/source/7/71/a file.jpg')
		);
		$this->assertNull($config->relative_key(provider_interface::SOURCE, 'other/source/image.jpg'));
	}

	/** @dataProvider invalid_configuration_provider */
	public function test_rejects_invalid_configuration(string $endpoint, string $bucket, string $prefix): void
	{
		$this->expectException(\InvalidArgumentException::class);
		new configuration($endpoint, $bucket, $prefix);
	}

	public static function invalid_configuration_provider(): array
	{
		return [
			'credentials in URL' => ['https://user:pass@s3.example', 'gallery-bucket', 'gallery'],
			'URL query' => ['https://s3.example?secret=yes', 'gallery-bucket', 'gallery'],
			'IP bucket' => ['https://s3.example', '127.0.0.1', 'gallery'],
			'unsafe prefix' => ['https://s3.example', 'gallery-bucket', '../gallery'],
		];
	}

	/** @dataProvider invalid_key_provider */
	public function test_rejects_invalid_object_keys(string $key): void
	{
		$config = new configuration('https://s3.example', 'gallery-bucket');

		$this->expectException(\InvalidArgumentException::class);
		$config->object_url(provider_interface::SOURCE, $key);
	}

	public static function invalid_key_provider(): array
	{
		return [
			'empty' => [''],
			'traversal' => ['../image.jpg'],
			'empty segment' => ['folder//image.jpg'],
			'backslash' => ['folder\\image.jpg'],
			'control' => ['image' . chr(10) . '.jpg'],
		];
	}
}
