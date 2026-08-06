<?php
/**
 * phpBB Gallery - pCloud provider tests
 *
 * @package   phpbbgallery/remotestorage
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\remotestorage\tests;

use PHPUnit\Framework\TestCase;
use phpbbgallery\core\storage\provider_interface;
use phpbbgallery\remotestorage\http\client_interface;
use phpbbgallery\remotestorage\http\response;
use phpbbgallery\remotestorage\pcloud\api_client;
use phpbbgallery\remotestorage\pcloud\configuration;
use phpbbgallery\remotestorage\pcloud\provider;

final class pcloud_provider_test extends TestCase
{
	private string $temporary_directory;

	// phpcs:ignore PhpbbCodingStandard.NamingConventions.LowercaseUnderscoredFunctions.NotAllowed -- PHPUnit lifecycle API.
	protected function setUp(): void
	{
		$this->temporary_directory = sys_get_temp_dir() . '/phpbbgallery-pcloud-' . bin2hex(random_bytes(6));
		mkdir($this->temporary_directory, 0700, true);
	}

	// phpcs:ignore PhpbbCodingStandard.NamingConventions.LowercaseUnderscoredFunctions.NotAllowed -- PHPUnit lifecycle API.
	protected function tearDown(): void
	{
		foreach (glob($this->temporary_directory . '/*') ?: [] as $file)
		{
			@unlink($file);
		}
		@rmdir($this->temporary_directory);
	}

	public function test_configuration_restricts_region_and_round_trips_safe_names(): void
	{
		$configuration = $this->configuration();
		foreach (['image.jpg', 'nested/name.webp', 'Upper Case.png'] as $key)
		{
			$name = $configuration->object_name(provider_interface::SOURCE, $key);
			$this->assertMatchesRegularExpression('/^g_[a-f0-9]+$/D', $name);
			$this->assertSame($key, $configuration->relative_key(provider_interface::SOURCE, $name));
		}

		$this->expectException(\InvalidArgumentException::class);
		new configuration('attacker.example', 'token-value', 'phpbbgallery');
	}

	public function test_api_uses_european_host_and_bearer_header_without_query_token(): void
	{
		$client = new pcloud_fake_http_client();
		$client->responses[] = $this->api_response(['result' => 0, 'userid' => 42]);
		$api = new api_client($this->configuration(), $client);

		$this->assertSame(0, $api->call('userinfo')['result']);
		$this->assertSame('https://eapi.pcloud.com/userinfo', $client->requests[0]['url']);
		$this->assertSame('Bearer token-value', $client->requests[0]['headers']['Authorization']);
		$this->assertStringNotContainsString('token-value', $client->requests[0]['url']);
	}

	public function test_prepare_creates_owned_private_folders_and_checks_public_links(): void
	{
		$client = new pcloud_fake_http_client();
		$this->folder_responses($client);

		$this->assertTrue($this->provider($client)->prepare(provider_interface::SOURCE, 'image.jpg'));
		$this->assertStringContainsString('createfolderifnotexists?', $client->requests[0]['url']);
		$this->assertStringContainsString('folderid=0', $client->requests[0]['url']);
		$this->assertStringContainsString('listpublinks', $client->requests[1]['url']);
		$this->assertStringContainsString('folderid=100', $client->requests[2]['url']);
	}

	public function test_public_root_folder_is_rejected(): void
	{
		$client = new pcloud_fake_http_client();
		$client->responses[] = $this->api_response([
			'result' => 0,
			'metadata' => $this->folder('phpbbgallery', 100, 0),
		]);
		$client->responses[] = $this->api_response([
			'result' => 0,
			'publinks' => [[
				'linkid' => 9,
				'metadata' => $this->folder('phpbbgallery', 100, 0),
			]],
		]);

		$this->expectException(\RuntimeException::class);
		$this->expectExceptionMessage('not private and exclusively owned');
		$this->provider($client)->prepare(provider_interface::SOURCE, 'image.jpg');
	}

	public function test_put_upload_streams_file_and_disables_partial_objects(): void
	{
		$file = $this->temporary_directory . '/upload.bin';
		file_put_contents($file, 'pcloud-image');
		$client = new pcloud_fake_http_client();
		$this->folder_responses($client);
		$client->responses[] = $this->folder_listing([]);
		$name = $this->configuration()->object_name(provider_interface::SOURCE, 'image.jpg');
		$client->responses[] = $this->api_response([
			'result' => 0,
			'fileids' => [300],
			'metadata' => [$this->file($name, 300, strlen('pcloud-image'))],
		]);

		$this->assertTrue($this->provider($client)->write(provider_interface::SOURCE, 'image.jpg', $file));
		$upload = $client->requests[4];
		$this->assertSame('PUT', $upload['method']);
		$this->assertStringContainsString('uploadfile?', $upload['url']);
		$this->assertStringContainsString('nopartial=1', $upload['url']);
		$this->assertStringContainsString('renameifexists=1', $upload['url']);
		$this->assertSame('pcloud-image', $upload['body']);
		$this->assertSame((string) strlen('pcloud-image'), $upload['headers']['Content-Length']);
	}

	public function test_create_race_removes_renamed_duplicate_and_returns_false(): void
	{
		$file = $this->temporary_directory . '/upload.bin';
		file_put_contents($file, 'pcloud-image');
		$client = new pcloud_fake_http_client();
		$this->folder_responses($client);
		$client->responses[] = $this->folder_listing([]);
		$name = $this->configuration()->object_name(provider_interface::SOURCE, 'image.jpg');
		$client->responses[] = $this->api_response([
			'result' => 0,
			'fileids' => [301],
			'metadata' => [$this->file($name . ' (1)', 301, strlen('pcloud-image'))],
		]);
		$client->responses[] = $this->api_response(['result' => 0]);

		$this->assertFalse($this->provider($client)->write(provider_interface::SOURCE, 'image.jpg', $file));
		$this->assertStringContainsString('deletefile?fileid=301', $client->requests[5]['url']);
	}

	public function test_replace_omits_rename_flag_and_preserves_existing_file_id(): void
	{
		$file = $this->temporary_directory . '/upload.bin';
		file_put_contents($file, 'replacement');
		$client = new pcloud_fake_http_client();
		$this->folder_responses($client);
		$name = $this->configuration()->object_name(provider_interface::SOURCE, 'image.jpg');
		$existing = $this->file($name, 300, 4);
		$client->responses[] = $this->folder_listing([$existing]);
		$client->responses[] = $this->api_response([
			'result' => 0,
			'fileids' => [300],
			'metadata' => [$this->file($name, 300, strlen('replacement'))],
		]);

		$this->assertTrue($this->provider($client)->replace(provider_interface::SOURCE, 'image.jpg', $file));
		$this->assertStringNotContainsString('renameifexists', $client->requests[4]['url']);
		$this->assertSame('replacement', $client->requests[4]['body']);
	}

	public function test_private_download_uses_validated_https_host_without_bearer_token(): void
	{
		$client = new pcloud_fake_http_client();
		$this->folder_responses($client);
		$name = $this->configuration()->object_name(provider_interface::SOURCE, 'image.jpg');
		$client->responses[] = $this->folder_listing([$this->file($name, 300, 11)]);
		$client->responses[] = $this->api_response([
			'result' => 0,
			'hosts' => ['c123.pcloud.com'],
			'path' => '/signed/image.jpg',
		]);
		$client->responses[] = $this->body_response('pcloud-file');

		$stream = $this->provider($client)->open_stream(provider_interface::SOURCE, 'image.jpg');
		$this->assertIsResource($stream);
		$this->assertSame('pcloud-file', stream_get_contents($stream));
		fclose($stream);
		$this->assertSame('https://c123.pcloud.com/signed/image.jpg', $client->requests[5]['url']);
		$this->assertSame([], $client->requests[5]['headers']);
	}

	public function test_untrusted_download_host_and_encoded_controls_are_rejected(): void
	{
		$client = new pcloud_fake_http_client();
		$this->folder_responses($client);
		$name = $this->configuration()->object_name(provider_interface::SOURCE, 'image.jpg');
		$client->responses[] = $this->folder_listing([$this->file($name, 300, 11)]);
		$client->responses[] = $this->api_response([
			'result' => 0,
			'hosts' => ['attacker.example'],
			'path' => '/signed/%0d%0aInjected',
		]);

		$this->expectException(\RuntimeException::class);
		$this->expectExceptionMessage('invalid private download host');
		$this->provider($client)->open_stream(provider_interface::SOURCE, 'image.jpg');
	}

	public function test_encoded_controls_on_trusted_download_host_are_rejected(): void
	{
		$client = new pcloud_fake_http_client();
		$this->folder_responses($client);
		$name = $this->configuration()->object_name(provider_interface::SOURCE, 'image.jpg');
		$client->responses[] = $this->folder_listing([$this->file($name, 300, 11)]);
		$client->responses[] = $this->api_response([
			'result' => 0,
			'hosts' => ['c123.pcloud.com'],
			'path' => '/signed/%0d%0aInjected',
		]);

		$this->expectException(\RuntimeException::class);
		$this->expectExceptionMessage('invalid private download path');
		$this->provider($client)->open_stream(provider_interface::SOURCE, 'image.jpg');
	}

	public function test_us_region_calculates_sha256_from_private_stream_when_api_omits_it(): void
	{
		$client = new pcloud_fake_http_client();
		$this->folder_responses($client);
		$configuration = new configuration('api.pcloud.com', 'token-value', 'phpbbgallery');
		$name = $configuration->object_name(provider_interface::SOURCE, 'image.jpg');
		$file = $this->file($name, 300, strlen('us-pcloud-file'));
		$client->responses[] = $this->folder_listing([$file]);
		$client->responses[] = $this->api_response([
			'result' => 0,
			'sha1' => hash('sha1', 'us-pcloud-file'),
			'md5' => hash('md5', 'us-pcloud-file'),
		]);
		$client->responses[] = $this->folder_listing([$file]);
		$client->responses[] = $this->api_response([
			'result' => 0,
			'hosts' => ['c123.pcloud.com'],
			'path' => '/signed/image.jpg',
		]);
		$client->responses[] = $this->body_response('us-pcloud-file');
		$provider = new provider($configuration, new api_client($configuration, $client), $client);

		$this->assertSame(
			hash('sha256', 'us-pcloud-file'),
			$provider->checksum(provider_interface::SOURCE, 'image.jpg')
		);
		$this->assertSame('https://api.pcloud.com/createfolderifnotexists?folderid=0&name=phpbbgallery&timeformat=timestamp',
			$client->requests[0]['url']);
	}

	public function test_list_metadata_checksum_and_delete_use_file_ids(): void
	{
		$client = new pcloud_fake_http_client();
		$this->folder_responses($client);
		$one = $this->file($this->configuration()->object_name(provider_interface::SOURCE, 'one.jpg'), 301, 10);
		$two = $this->file($this->configuration()->object_name(provider_interface::SOURCE, 'two.jpg'), 302, 20);
		$client->responses[] = $this->folder_listing([$two, $one]);
		$client->responses[] = $this->folder_listing([$two, $one]);
		$client->responses[] = $this->folder_listing([$two, $one]);
		$client->responses[] = $this->folder_listing([$two, $one]);
		$client->responses[] = $this->api_response(['result' => 0, 'sha256' => hash('sha256', 'one')]);
		$client->responses[] = $this->folder_listing([$two, $one]);
		$client->responses[] = $this->api_response(['result' => 0]);
		$provider = $this->provider($client);

		$page = $provider->list_objects(provider_interface::SOURCE, null, 1);
		$this->assertSame(['one.jpg'], $page['keys']);
		$this->assertSame('o:1', $page['cursor']);
		$this->assertSame(10, $provider->size(provider_interface::SOURCE, 'one.jpg'));
		$this->assertSame(1700000000, $provider->modified_time(provider_interface::SOURCE, 'one.jpg'));
		$this->assertSame(hash('sha256', 'one'), $provider->checksum(provider_interface::SOURCE, 'one.jpg'));
		$this->assertTrue($provider->delete(provider_interface::SOURCE, 'one.jpg'));
		$this->assertStringContainsString('deletefile?fileid=301', $client->requests[9]['url']);
	}

	private function configuration(): configuration
	{
		return new configuration('eapi.pcloud.com', 'token-value', 'phpbbgallery');
	}

	private function provider(pcloud_fake_http_client $client): provider
	{
		$configuration = $this->configuration();

		return new provider($configuration, new api_client($configuration, $client), $client);
	}

	private function folder_responses(pcloud_fake_http_client $client): void
	{
		$client->responses[] = $this->api_response([
			'result' => 0,
			'metadata' => $this->folder('phpbbgallery', 100, 0),
		]);
		$client->responses[] = $this->api_response(['result' => 0, 'publinks' => []]);
		$client->responses[] = $this->api_response([
			'result' => 0,
			'metadata' => $this->folder('source', 200, 100),
		]);
	}

	/** @param list<array<string, mixed>> $files */
	private function folder_listing(array $files): response
	{
		$folder = $this->folder('source', 200, 100);
		$folder['contents'] = $files;

		return $this->api_response(['result' => 0, 'metadata' => $folder]);
	}

	/** @return array<string, mixed> */
	private function folder(string $name, int $id, int $parent): array
	{
		return [
			'folderid' => $id,
			'isfolder' => true,
			'ismine' => true,
			'isshared' => false,
			'name' => $name,
			'parentfolderid' => $parent,
		];
	}

	/** @return array<string, mixed> */
	private function file(string $name, int $id, int $size): array
	{
		return [
			'fileid' => $id,
			'isfolder' => false,
			'ismine' => true,
			'isshared' => false,
			'modified' => 1700000000,
			'name' => $name,
			'parentfolderid' => 200,
			'size' => $size,
		];
	}

	/** @param array<string, mixed> $data */
	private function api_response(array $data): response
	{
		return $this->body_response((string) json_encode($data, JSON_THROW_ON_ERROR));
	}

	private function body_response(string $body, int $status = 200, array $headers = []): response
	{
		$stream = fopen('php://temp', 'w+b');
		fwrite($stream, $body);
		rewind($stream);

		return new response($status, $headers, $stream);
	}
}

// phpcs:disable Generic.Files.OneClassPerFile.MultipleFound -- Isolated pCloud HTTP test double.
final class pcloud_fake_http_client implements client_interface
{
	/** @var list<response> */
	public array $responses = [];
	/** @var list<array{method: string, url: string, headers: array<string, string>, body: string}> */
	public array $requests = [];

	public function request(string $method, string $url, array $headers = [], mixed $body = null): response
	{
		$contents = '';
		if (is_resource($body))
		{
			$contents = (string) stream_get_contents($body);
		}
		$this->requests[] = compact('method', 'url', 'headers') + ['body' => $contents];
		$response = array_shift($this->responses);
		if (!$response instanceof response)
		{
			throw new \RuntimeException('No fake pCloud response was queued.');
		}

		return $response;
	}
}
