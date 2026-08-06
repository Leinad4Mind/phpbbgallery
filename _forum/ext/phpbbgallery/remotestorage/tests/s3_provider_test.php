<?php
/**
 * phpBB Gallery - S3 provider tests
 *
 * @package   phpbbgallery/remotestorage
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\remotestorage\tests;

use phpbbgallery\core\storage\provider_interface;
use phpbbgallery\remotestorage\http\client_interface;
use phpbbgallery\remotestorage\http\response;
use phpbbgallery\remotestorage\providers\s3\configuration;
use phpbbgallery\remotestorage\providers\s3\configured_factory;
use phpbbgallery\remotestorage\providers\s3\factory;
use phpbbgallery\remotestorage\providers\s3\provider;
use phpbbgallery\remotestorage\providers\s3\signer;
use PHPUnit\Framework\TestCase;

final class s3_provider_test extends TestCase
{
	private string $temporary_directory;

	// phpcs:ignore PhpbbCodingStandard.NamingConventions.LowercaseUnderscoredFunctions.NotAllowed -- PHPUnit lifecycle API.
	protected function setUp(): void
	{
		$this->temporary_directory = sys_get_temp_dir() . '/phpbbgallery-s3-' . bin2hex(random_bytes(6));
		mkdir($this->temporary_directory, 0700, true);
	}

	// phpcs:ignore PhpbbCodingStandard.NamingConventions.LowercaseUnderscoredFunctions.NotAllowed -- PHPUnit lifecycle API.
	protected function tearDown(): void
	{
		foreach (glob($this->temporary_directory . '/*') ?: [] as $file)
		{
			unlink($file);
		}
		rmdir($this->temporary_directory);
	}

	public function test_creates_an_object_with_hash_metadata_and_no_overwrite_condition(): void
	{
		$client = new fake_http_client();
		$client->responses[] = new response(200);
		$file = $this->temporary_directory . '/image.jpg';
		file_put_contents($file, 'image-data');

		$this->assertTrue($this->provider($client)->write(provider_interface::SOURCE, '7/71/image.jpg', $file));
		$request = $client->requests[0];
		$this->assertSame('PUT', $request['method']);
		$this->assertSame('https://s3.example/gallery-bucket/board/source/7/71/image.jpg', $request['url']);
		$this->assertSame('*', $request['headers']['If-None-Match']);
		$this->assertSame(hash('sha256', 'image-data'), $request['headers']['X-Amz-Meta-Sha256']);
		$this->assertStringContainsString('SignedHeaders=', $request['headers']['Authorization']);
		$this->assertSame('image-data', $request['body']);
	}

	public function test_create_collision_and_invalid_local_file_fail_without_overwrite(): void
	{
		$client = new fake_http_client();
		$client->responses[] = new response(412);
		$file = $this->temporary_directory . '/image.jpg';
		file_put_contents($file, 'image-data');
		$provider = $this->provider($client);

		$this->assertFalse($provider->write(provider_interface::SOURCE, 'image.jpg', $file));
		$this->assertFalse($provider->write(provider_interface::SOURCE, 'missing.jpg', $file . '.missing'));
		$this->assertCount(1, $client->requests);
	}

	public function test_reads_an_object_as_a_caller_owned_stream(): void
	{
		$client = new fake_http_client();
		$client->responses[] = $this->body_response(200, 'remote-image');

		$stream = $this->provider($client)->open_stream(provider_interface::SOURCE, 'image.jpg');
		$this->assertIsResource($stream);
		$this->assertSame('remote-image', stream_get_contents($stream));
		fclose($stream);
	}

	public function test_missing_object_returns_contract_nulls_and_false(): void
	{
		$client = new fake_http_client();
		for ($i = 0; $i < 5; $i++)
		{
			$client->responses[] = new response(404);
		}
		$provider = $this->provider($client);

		$this->assertFalse($provider->exists(provider_interface::SOURCE, 'missing.jpg'));
		$this->assertNull($provider->size(provider_interface::SOURCE, 'missing.jpg'));
		$this->assertNull($provider->modified_time(provider_interface::SOURCE, 'missing.jpg'));
		$this->assertNull($provider->checksum(provider_interface::SOURCE, 'missing.jpg'));
		$this->assertFalse($provider->open_stream(provider_interface::SOURCE, 'missing.jpg'));
	}

	public function test_reads_verified_metadata_and_deletes_idempotently(): void
	{
		$client = new fake_http_client();
		$headers = [
			'Content-Length' => '12',
			'Last-Modified' => 'Wed, 05 Aug 2026 12:30:00 GMT',
			'X-Amz-Meta-Sha256' => str_repeat('a', 64),
		];
		$client->responses = [
			new response(200),
			new response(200, $headers),
			new response(200, $headers),
			new response(200, $headers),
			new response(204),
		];
		$provider = $this->provider($client);

		$this->assertTrue($provider->exists(provider_interface::SOURCE, 'image.jpg'));
		$this->assertSame(12, $provider->size(provider_interface::SOURCE, 'image.jpg'));
		$this->assertSame(1785933000, $provider->modified_time(provider_interface::SOURCE, 'image.jpg'));
		$this->assertSame(str_repeat('a', 64), $provider->checksum(provider_interface::SOURCE, 'image.jpg'));
		$this->assertNull($provider->checksum(provider_interface::SOURCE, 'image.jpg', 'md5'));
		$this->assertTrue($provider->delete(provider_interface::SOURCE, 'image.jpg'));
	}

	public function test_replaces_only_an_existing_object(): void
	{
		$client = new fake_http_client();
		$client->responses = [new response(200), new response(200)];
		$file = $this->temporary_directory . '/replacement.jpg';
		file_put_contents($file, 'replacement');

		$this->assertTrue($this->provider($client)->replace(provider_interface::SOURCE, 'image.jpg', $file));
		$this->assertSame('HEAD', $client->requests[0]['method']);
		$this->assertSame('PUT', $client->requests[1]['method']);
		$this->assertArrayNotHasKey('If-None-Match', $client->requests[1]['headers']);

		$missing = new fake_http_client();
		$missing->responses[] = new response(404);
		$this->assertFalse($this->provider($missing)->replace(provider_interface::SOURCE, 'image.jpg', $file));
		$this->assertCount(1, $missing->requests);
	}

	public function test_lists_objects_with_an_opaque_continuation_cursor(): void
	{
		$client = new fake_http_client();
		$xml = '<ListBucketResult>'
			. '<IsTruncated>true</IsTruncated>'
			. '<Contents><Key>board/source/7/71/first.jpg</Key></Contents>'
			. '<Contents><Key>board/source/second.png</Key></Contents>'
			. '<NextContinuationToken>opaque+/=</NextContinuationToken>'
			. '</ListBucketResult>';
		$client->responses[] = $this->body_response(200, $xml);

		$page = $this->provider($client)->list_objects(provider_interface::SOURCE, 'previous+/=', 2);

		$this->assertSame(['7/71/first.jpg', 'second.png'], $page['keys']);
		$this->assertSame('opaque+/=', $page['cursor']);
		$this->assertStringContainsString('continuation-token=previous%2B%2F%3D', $client->requests[0]['url']);
		$this->assertStringContainsString('prefix=board%2Fsource%2F', $client->requests[0]['url']);
	}

	/** @dataProvider invalid_list_provider */
	public function test_rejects_malformed_or_unsafe_list_responses(string $xml, string $message): void
	{
		$client = new fake_http_client();
		$client->responses[] = $this->body_response(200, $xml);

		$this->expectException(\RuntimeException::class);
		$this->expectExceptionMessage($message);
		$this->provider($client)->list_objects(provider_interface::SOURCE);
	}

	public static function invalid_list_provider(): array
	{
		return [
			'invalid XML' => ['not xml', 'list response is invalid'],
			'foreign key' => [
				'<ListBucketResult><IsTruncated>false</IsTruncated>'
				. '<Contents><Key>other/source/image.jpg</Key></Contents></ListBucketResult>',
				'invalid Gallery object key',
			],
			'missing cursor' => [
				'<ListBucketResult><IsTruncated>true</IsTruncated></ListBucketResult>',
				'omitted its continuation cursor',
			],
		];
	}

	public function test_unexpected_http_status_fails_closed(): void
	{
		$client = new fake_http_client();
		$client->responses[] = new response(500);

		$this->expectException(\RuntimeException::class);
		$this->expectExceptionMessage('HTTP status 500');
		$this->provider($client)->exists(provider_interface::SOURCE, 'image.jpg');
	}

	public function test_factory_requires_complete_external_configuration(): void
	{
		$environment = [
			'PHPBBGALLERY_S3_ENDPOINT' => 'https://minio.example:9000',
			'PHPBBGALLERY_S3_BUCKET' => 'gallery-bucket',
			'PHPBBGALLERY_S3_ACCESS_KEY' => 'access',
			'PHPBBGALLERY_S3_SECRET_KEY' => 'secret',
			'PHPBBGALLERY_S3_REGION' => 'eu-west-1',
			'PHPBBGALLERY_S3_PREFIX' => 'board',
		];
		$client = new fake_http_client();
		$client->responses[] = new response(404);
		$provider = (new factory($client, $environment))->create();

		$this->assertSame('s3', $provider->get_id());
		$this->assertFalse($provider->exists(provider_interface::SOURCE, 'image.jpg'));
		$this->assertSame(
			'https://minio.example:9000/gallery-bucket/board/source/image.jpg',
			$client->requests[0]['url']
		);

		$this->expectException(\InvalidArgumentException::class);
		(new factory(new fake_http_client(), []))->create();
	}

	public function test_configured_factory_can_test_submitted_values_without_persisting_them(): void
	{
		$config = new \ArrayObject([
			'phpbb_gallery_s3_endpoint' => '',
			'phpbb_gallery_s3_bucket' => '',
			'phpbb_gallery_s3_access_key' => '',
			'phpbb_gallery_s3_secret_key' => '',
			'phpbb_gallery_s3_region' => 'us-east-1',
			'phpbb_gallery_s3_prefix' => 'phpbbgallery',
		]);
		$client = new fake_http_client();
		$client->responses[] = new response(404);
		$request = $this->createMock(\phpbb\request\request_interface::class);
		$provider = (new configured_factory($client, $config, $request, []))->create_from([
			'endpoint' => 'https://submitted.example',
			'bucket' => 'submitted-bucket',
			'access_key' => 'access',
			'secret_key' => 'secret',
			'region' => 'eu-west-1',
			'prefix' => 'submitted',
		]);

		$this->assertFalse($provider->exists(provider_interface::SOURCE, 'image.jpg'));
		$this->assertSame(
			'https://submitted.example/submitted-bucket/submitted/source/image.jpg',
			$client->requests[0]['url']
		);
		$this->assertSame('', $config['phpbb_gallery_s3_endpoint']);
	}

	private function provider(fake_http_client $client): provider
	{
		return new provider(
			new configuration('https://s3.example', 'gallery-bucket', 'board'),
			new signer('access', 'secret', 'eu-west-1'),
			$client,
			static fn (): \DateTimeImmutable => new \DateTimeImmutable('2026-08-05 12:30:00 UTC')
		);
	}

	private function body_response(int $status, string $body, array $headers = []): response
	{
		$stream = fopen('php://temp', 'w+b');
		fwrite($stream, $body);
		rewind($stream);

		return new response($status, $headers, $stream);
	}
}

// phpcs:disable Generic.Files.OneClassPerFile.MultipleFound -- Isolated provider test double.
final class fake_http_client implements client_interface
{
	/** @var list<response> */
	public array $responses = [];
	/** @var list<array{method: string, url: string, headers: array, body: string|null}> */
	public array $requests = [];

	public function request(string $method, string $url, array $headers = [], mixed $body = null): response
	{
		$contents = is_resource($body) ? stream_get_contents($body) : null;
		$this->requests[] = compact('method', 'url', 'headers') + ['body' => $contents];
		if ($this->responses === [])
		{
			throw new \RuntimeException('The fake S3 response queue is empty.');
		}

		return array_shift($this->responses);
	}
}
