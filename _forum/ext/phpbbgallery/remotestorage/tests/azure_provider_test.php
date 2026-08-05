<?php
/**
 * phpBB Gallery - Azure Blob provider tests
 *
 * @package   phpbbgallery/remotestorage
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\remotestorage\tests;

use phpbbgallery\core\storage\provider_interface;
use phpbbgallery\remotestorage\azure\configuration;
use phpbbgallery\remotestorage\azure\configured_factory;
use phpbbgallery\remotestorage\azure\provider;
use phpbbgallery\remotestorage\azure\signer;
use phpbbgallery\remotestorage\http\client_interface;
use phpbbgallery\remotestorage\http\response;
use PHPUnit\Framework\TestCase;

final class azure_provider_test extends TestCase
{
	private string $temporary_directory;

	// phpcs:ignore PhpbbCodingStandard.NamingConventions.LowercaseUnderscoredFunctions.NotAllowed -- PHPUnit lifecycle API.
	protected function setUp(): void
	{
		$this->temporary_directory = sys_get_temp_dir() . '/phpbbgallery-azure-' . bin2hex(random_bytes(6));
		mkdir($this->temporary_directory, 0700, true);
	}

	// phpcs:ignore PhpbbCodingStandard.NamingConventions.LowercaseUnderscoredFunctions.NotAllowed -- PHPUnit lifecycle API.
	protected function tearDown(): void
	{
		foreach ((array) glob($this->temporary_directory . '/*') as $file)
		{
			unlink($file);
		}
		rmdir($this->temporary_directory);
	}

	public function test_configuration_builds_encoded_private_blob_paths(): void
	{
		$config = new configuration(
			'https://account.blob.core.windows.net/',
			'account',
			'gallery-files',
			'boards/main'
		);

		$this->assertSame('account', $config->account());
		$this->assertSame(
			'https://account.blob.core.windows.net/gallery-files/boards/main/source/7/71/a%20file.jpg',
			$config->object_url(provider_interface::SOURCE, '7/71/a file.jpg')
		);
		$this->assertSame('boards/main/mini/', $config->variant_prefix(provider_interface::MINI));
		$this->assertSame(
			'7/71/a file.jpg',
			$config->relative_key(provider_interface::SOURCE, 'boards/main/source/7/71/a file.jpg')
		);
		$this->assertNull($config->relative_key(provider_interface::SOURCE, 'unrelated/image.jpg'));
	}

	/** @dataProvider invalid_configuration_provider */
	public function test_configuration_rejects_unsafe_values(
		string $endpoint,
		string $account,
		string $container,
		string $prefix
	): void
	{
		$this->expectException(\InvalidArgumentException::class);
		new configuration($endpoint, $account, $container, $prefix);
	}

	public static function invalid_configuration_provider(): array
	{
		return [
			'credentials in endpoint' => ['https://user:pass@blob.example', 'account', 'gallery', 'board'],
			'endpoint query' => ['https://blob.example?secret=yes', 'account', 'gallery', 'board'],
			'uppercase account' => ['https://blob.example', 'Account', 'gallery', 'board'],
			'short container' => ['https://blob.example', 'account', 'ab', 'board'],
			'consecutive container hyphens' => ['https://blob.example', 'account', 'bad--name', 'board'],
			'unsafe prefix' => ['https://blob.example', 'account', 'gallery', '../board'],
		];
	}

	public function test_signer_canonicalizes_headers_and_query_deterministically(): void
	{
		$headers = (new signer('account', base64_encode(str_repeat('k', 64))))->sign(
			'GET',
			'https://account.blob.core.windows.net/gallery?restype=container&comp=list&marker=a%2Bb',
			['X-Ms-Meta-Test' => '  one   two  '],
			new \DateTimeImmutable('2026-08-05 12:30:00 UTC')
		);

		$this->assertSame('Wed, 05 Aug 2026 12:30:00 GMT', $headers['x-ms-date']);
		$this->assertSame('2023-11-03', $headers['x-ms-version']);
		$this->assertSame(
			'SharedKey account:UwosIE1S8HpDTLQjj0UwaeUCFne5O1LPC4H/tduI55s=',
			$headers['Authorization']
		);
	}

	public function test_write_stream_metadata_delete_and_list_workflow(): void
	{
		$file = $this->temporary_directory . '/image.jpg';
		file_put_contents($file, 'azure-image');
		$hash = hash('sha256', 'azure-image');
		$client = new azure_fake_http_client();
		$client->responses[] = new response(201);
		$client->responses[] = new response(200, [
			'Content-Length' => '11',
			'Last-Modified' => 'Wed, 05 Aug 2026 12:30:00 GMT',
			'x-ms-meta-sha256' => $hash,
		]);
		$client->responses[] = $this->body_response(200, 'azure-image');
		$client->responses[] = $this->body_response(200,
			'<EnumerationResults><Blobs><Blob><Name>board/source/image.jpg</Name></Blob></Blobs>'
			. '<NextMarker>next+page</NextMarker></EnumerationResults>'
		);
		$client->responses[] = new response(202);
		$provider = $this->provider($client);

		$this->assertTrue($provider->write(provider_interface::SOURCE, 'image.jpg', $file));
		$this->assertSame('PUT', $client->requests[0]['method']);
		$this->assertSame('*', $client->requests[0]['headers']['If-None-Match']);
		$this->assertSame('BlockBlob', $client->requests[0]['headers']['x-ms-blob-type']);
		$this->assertSame($hash, $client->requests[0]['headers']['x-ms-meta-sha256']);
		$this->assertSame('azure-image', $client->requests[0]['body']);

		$this->assertTrue($provider->exists(provider_interface::SOURCE, 'image.jpg'));
		$stream = $provider->open_stream(provider_interface::SOURCE, 'image.jpg');
		$this->assertIsResource($stream);
		$this->assertSame('azure-image', stream_get_contents($stream));
		fclose($stream);

		$page = $provider->list_objects(provider_interface::SOURCE, null, 2);
		$this->assertSame(['image.jpg'], $page['keys']);
		$this->assertSame('next+page', $page['cursor']);
		$this->assertStringContainsString('comp=list', $client->requests[3]['url']);
		$this->assertStringContainsString('maxresults=2', $client->requests[3]['url']);
		$this->assertTrue($provider->delete(provider_interface::SOURCE, 'image.jpg'));
	}

	public function test_prepare_creates_or_accepts_only_a_private_container(): void
	{
		$created = new azure_fake_http_client();
		$created->responses[] = new response(201);
		$created->responses[] = new response(200);
		$provider = $this->provider($created);

		$this->assertTrue($provider->prepare(provider_interface::SOURCE, 'image.jpg'));
		$this->assertTrue($provider->prepare(provider_interface::SOURCE, 'other.jpg'));
		$this->assertCount(2, $created->requests);
		$this->assertStringContainsString('restype=container', $created->requests[0]['url']);
		$this->assertStringContainsString('comp=acl', $created->requests[1]['url']);

		$public = new azure_fake_http_client();
		$public->responses[] = new response(409, ['x-ms-error-code' => 'ContainerAlreadyExists']);
		$public->responses[] = new response(200, ['x-ms-blob-public-access' => 'blob']);
		$provider = $this->provider($public);

		$this->expectException(\RuntimeException::class);
		$this->expectExceptionMessage('must not allow public access');
		$provider->prepare(provider_interface::SOURCE, 'image.jpg');
	}

	public function test_missing_objects_and_create_conflicts_fail_safely(): void
	{
		$file = $this->temporary_directory . '/image.jpg';
		file_put_contents($file, 'azure-image');
		$client = new azure_fake_http_client();
		$client->responses[] = new response(404);
		$client->responses[] = new response(404);
		$client->responses[] = new response(412);
		$provider = $this->provider($client);

		$this->assertFalse($provider->exists(provider_interface::SOURCE, 'missing.jpg'));
		$this->assertFalse($provider->open_stream(provider_interface::SOURCE, 'missing.jpg'));
		$this->assertFalse($provider->write(provider_interface::SOURCE, 'image.jpg', $file));
		$this->assertFalse($provider->write(provider_interface::SOURCE, 'missing.jpg', $file . '.missing'));
	}

	public function test_configured_factory_uses_submitted_values_without_persisting(): void
	{
		$config = new \ArrayObject([
			'phpbb_gallery_azure_endpoint' => '',
			'phpbb_gallery_azure_account' => '',
			'phpbb_gallery_azure_container' => '',
			'phpbb_gallery_azure_account_key' => '',
			'phpbb_gallery_azure_prefix' => 'phpbbgallery',
		]);
		$client = new azure_fake_http_client();
		$client->responses[] = new response(404);
		$request = $this->createMock(\phpbb\request\request_interface::class);
		$factory = new configured_factory($client, $config, $request, []);
		$provider = $factory->create_from([
			'endpoint' => 'https://account.blob.core.windows.net',
			'account' => 'account',
			'container' => 'gallery-files',
			'account_key' => base64_encode(str_repeat('k', 64)),
			'prefix' => 'submitted',
		]);

		$this->assertSame('azure', $factory->get_id());
		$this->assertFalse($provider->exists(provider_interface::SOURCE, 'image.jpg'));
		$this->assertStringContainsString('/gallery-files/submitted/source/image.jpg', $client->requests[0]['url']);
		$this->assertSame('', $config['phpbb_gallery_azure_endpoint']);
	}

	private function provider(azure_fake_http_client $client): provider
	{
		return new provider(
			new configuration('https://account.blob.core.windows.net', 'account', 'gallery-files', 'board'),
			new signer('account', base64_encode(str_repeat('k', 64))),
			$client,
			static fn (): \DateTimeImmutable => new \DateTimeImmutable('2026-08-05 12:30:00 UTC')
		);
	}

	private function body_response(int $status, string $body): response
	{
		$stream = fopen('php://temp', 'w+b');
		fwrite($stream, $body);
		rewind($stream);

		return new response($status, [], $stream);
	}
}

// phpcs:disable Generic.Files.OneClassPerFile.MultipleFound -- Isolated Azure HTTP test double.
final class azure_fake_http_client implements client_interface
{
	/** @var list<response> */
	public array $responses = [];
	/** @var list<array{method: string, url: string, headers: array, body: string|null}> */
	public array $requests = [];

	public function request(string $method, string $url, array $headers = [], mixed $body = null): response
	{
		$contents = null;
		if (is_resource($body))
		{
			$contents = (string) stream_get_contents($body);
		}
		$this->requests[] = compact('method', 'url', 'headers') + ['body' => $contents];
		if ($this->responses === [])
		{
			throw new \RuntimeException('No fake Azure HTTP response is available.');
		}

		return array_shift($this->responses);
	}
}
