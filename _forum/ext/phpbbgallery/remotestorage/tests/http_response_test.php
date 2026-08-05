<?php
/**
 * phpBB Gallery - remote HTTP response tests
 *
 * @package   phpbbgallery/remotestorage
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\remotestorage\tests;

use phpbbgallery\remotestorage\http\response;
use PHPUnit\Framework\TestCase;

final class http_response_test extends TestCase
{
	public function test_normalizes_headers_and_transfers_stream_ownership(): void
	{
		$body = fopen('php://temp', 'w+b');
		fwrite($body, 'object');
		rewind($body);
		$response = new response(200, ['Content-Length' => ['6'], 'X-Test' => ['one', 'two']], $body);

		$this->assertSame(200, $response->status());
		$this->assertSame('6', $response->header('content-length'));
		$this->assertSame('one,two', $response->header('X-Test'));
		$this->assertNull($response->header('missing'));
		$detached = $response->detach_body();
		unset($response);
		$this->assertIsResource($detached);
		$this->assertSame('object', stream_get_contents($detached));
		fclose($detached);
	}

	/** @dataProvider invalid_response_provider */
	public function test_rejects_invalid_responses(int $status, array $headers, mixed $body): void
	{
		$this->expectException(\InvalidArgumentException::class);
		new response($status, $headers, $body);
	}

	public static function invalid_response_provider(): array
	{
		return [
			'status' => [99, [], null],
			'header name' => [200, ['Bad Header' => 'value'], null],
			'body' => [200, [], 'not a stream'],
		];
	}
}
