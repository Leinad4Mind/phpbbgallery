<?php
/**
 * phpBB Gallery - S3 signer tests
 *
 * @package   phpbbgallery/remotestorage
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\remotestorage\tests;

use phpbbgallery\remotestorage\s3\signer;
use PHPUnit\Framework\TestCase;

final class signer_test extends TestCase
{
	private const EMPTY_HASH = 'e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855';

	public function test_signs_the_documented_aws_s3_get_request_deterministically(): void
	{
		$signer = new signer(
			'AKIAIOSFODNN7EXAMPLE',
			'wJalrXUtnFEMI/K7MDENG/bPxRfiCYEXAMPLEKEY',
			'us-east-1'
		);
		$headers = $signer->sign(
			'GET',
			'https://examplebucket.s3.amazonaws.com/test.txt',
			['Range' => 'bytes=0-9'],
			self::EMPTY_HASH,
			new \DateTimeImmutable('2013-05-24 00:00:00 UTC')
		);

		$this->assertSame('examplebucket.s3.amazonaws.com', $headers['Host']);
		$this->assertSame('20130524T000000Z', $headers['X-Amz-Date']);
		$this->assertSame(self::EMPTY_HASH, $headers['X-Amz-Content-Sha256']);
		$this->assertSame(
			'AWS4-HMAC-SHA256 Credential=AKIAIOSFODNN7EXAMPLE/20130524/us-east-1/s3/aws4_request, '
			. 'SignedHeaders=host;range;x-amz-content-sha256;x-amz-date, '
			. 'Signature=f0e8bdb87c964420e857bd35b5d6ed310bd44f0170aba48dd91039c6036bdb41',
			$headers['Authorization']
		);
	}

	public function test_query_order_and_path_encoding_do_not_change_the_signature(): void
	{
		$signer = new signer('access', 'secret', 'eu-west-1');
		$time = new \DateTimeImmutable('2026-08-05 12:30:00 UTC');
		$first = $signer->sign(
			'GET',
			'https://storage.example/bucket/a%20file.jpg?z=last&a=two&a=one',
			[],
			self::EMPTY_HASH,
			$time
		);
		$second = $signer->sign(
			'GET',
			'https://storage.example/bucket/a file.jpg?a=one&a=two&z=last',
			[],
			self::EMPTY_HASH,
			$time
		);

		$this->assertSame($first['Authorization'], $second['Authorization']);
	}

	/** @dataProvider invalid_input_provider */
	public function test_rejects_invalid_inputs(string $access, string $secret, string $region, string $url, string $hash): void
	{
		$this->expectException(\InvalidArgumentException::class);
		$signer = new signer($access, $secret, $region);
		$signer->sign('GET', $url, [], $hash, new \DateTimeImmutable('now', new \DateTimeZone('UTC')));
	}

	public static function invalid_input_provider(): array
	{
		return [
			'empty access key' => ['', 'secret', 'eu-west-1', 'https://s3.example/file', self::EMPTY_HASH],
			'empty secret key' => ['access', '', 'eu-west-1', 'https://s3.example/file', self::EMPTY_HASH],
			'invalid region' => ['access', 'secret', '../region', 'https://s3.example/file', self::EMPTY_HASH],
			'invalid URL' => ['access', 'secret', 'eu-west-1', 'file:///tmp/object', self::EMPTY_HASH],
			'invalid hash' => ['access', 'secret', 'eu-west-1', 'https://s3.example/file', 'nope'],
		];
	}

	public function test_rejects_header_injection(): void
	{
		$signer = new signer('access', 'secret', 'eu-west-1');

		$this->expectException(\InvalidArgumentException::class);
		$signer->sign(
			'GET',
			'https://storage.example/object',
			['X-Test' => 'safe' . chr(13) . chr(10) . 'X-Injected: yes'],
			self::EMPTY_HASH,
			new \DateTimeImmutable('2026-08-05 12:30:00 UTC')
		);
	}
}
