<?php
/**
 * phpBB Gallery - Google Drive provider tests
 *
 * @package   phpbbgallery/remotestorage
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\remotestorage\tests;

use phpbbgallery\core\storage\provider_interface;
use phpbbgallery\remotestorage\providers\google_drive\configuration;
use phpbbgallery\remotestorage\providers\google_drive\configured_factory;
use phpbbgallery\remotestorage\providers\google_drive\provider;
use phpbbgallery\remotestorage\providers\google_drive\token_manager;
use phpbbgallery\remotestorage\http\client_interface;
use phpbbgallery\remotestorage\http\response;
use PHPUnit\Framework\TestCase;

final class google_drive_provider_test extends TestCase
{
	private const ROOT_ID = 'rootfolder01';
	private const VARIANT_ID = 'sourcefold01';
	private const FILE_ID = 'fileobject01';
	private string $temporary_directory;

	// phpcs:ignore PhpbbCodingStandard.NamingConventions.LowercaseUnderscoredFunctions.NotAllowed -- PHPUnit lifecycle API.
	protected function setUp(): void
	{
		$this->temporary_directory = sys_get_temp_dir() . '/phpbbgallery-google-' . bin2hex(random_bytes(6));
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

	public function test_configuration_validates_keys_and_escapes_queries(): void
	{
		$config = new configuration('client-id', 'client-secret', 'refresh-token', 'Gallery Storage');

		$this->assertSame('Gallery Storage', $config->root_name());
		$this->assertSame('7/71/image.jpg',
			$config->object_name(provider_interface::SOURCE, '7/71/image.jpg'));
		$this->assertSame(
			'a' . str_repeat('\\', 2) . 'b' . '\\' . chr(39) . 'c',
			$config->query_literal('a\\b' . chr(39) . 'c')
		);
		foreach ([
			'../image.jpg',
			'/image.jpg',
			'bad' . chr(0) . 'name.jpg',
			'folder\\image.jpg',
			'folder//image.jpg',
		] as $key)
		{
			try
			{
				$config->object_name(provider_interface::SOURCE, $key);
				$this->fail('An unsafe Google Drive key was accepted.');
			}
			catch (\InvalidArgumentException)
			{
				$this->addToAssertionCount(1);
			}
		}
	}

	public function test_oauth_refresh_token_is_cached_and_not_exposed_in_the_url(): void
	{
		$client = new google_drive_fake_http_client();
		$this->token($client);
		$manager = new token_manager(
			new configuration('client-id', 'client-secret', 'refresh-token'),
			$client,
			static fn (): int => 1000
		);

		$this->assertSame('short-lived-token', $manager->token());
		$this->assertSame('short-lived-token', $manager->token());
		$this->assertCount(1, $client->requests);
		$this->assertSame('https://oauth2.googleapis.com/token', $client->requests[0]['url']);
		$this->assertStringNotContainsString('client-secret', $client->requests[0]['url']);
		$this->assertStringNotContainsString('refresh-token', $client->requests[0]['url']);
		$this->assertStringContainsString('client_secret=client-secret', $client->requests[0]['body']);
		$this->assertStringContainsString('grant_type=refresh_token', $client->requests[0]['body']);
	}

	public function test_prepare_creates_a_dedicated_root_and_variant_folder(): void
	{
		$client = new google_drive_fake_http_client();
		$this->token($client);
		$client->responses[] = $this->files([]);
		$client->responses[] = $this->json_response(200, [
			'id' => self::ROOT_ID,
			'name' => 'phpbbgallery',
			'mimeType' => 'application/vnd.google-apps.folder',
		]);
		$client->responses[] = $this->files([]);
		$client->responses[] = $this->json_response(200, [
			'id' => self::VARIANT_ID,
			'name' => 'source',
			'mimeType' => 'application/vnd.google-apps.folder',
		]);
		$provider = $this->provider($client);

		$this->assertTrue($provider->prepare(provider_interface::SOURCE, 'image.jpg'));
		$this->assertTrue($provider->prepare(provider_interface::SOURCE, 'other.jpg'));
		$this->assertCount(5, $client->requests);
		$this->assertStringContainsString('appProperties%20has', $client->requests[1]['url']);
		$this->assertSame('POST', $client->requests[2]['method']);
		$this->assertSame('phpbbgallery', json_decode($client->requests[2]['body'], true)['name']);
		$this->assertSame('source', json_decode($client->requests[4]['body'], true)['name']);
	}

	public function test_resumable_create_uses_verified_chunk_offsets(): void
	{
		$file = $this->temporary_directory . '/large.bin';
		file_put_contents($file, str_repeat('a', 262145));
		$client = new google_drive_fake_http_client();
		$this->existing_folders($client);
		$client->responses[] = $this->files([]);
		$client->responses[] = new response(200, [
			'Location' => 'https://www.googleapis.com/upload/drive/v3/files?upload_id=safe-session',
		]);
		$client->responses[] = new response(308, ['Range' => 'bytes=0-262143']);
		$client->responses[] = $this->json_response(200, ['id' => self::FILE_ID]);
		$provider = $this->provider($client, 262144);

		$this->assertTrue($provider->write(provider_interface::SOURCE, 'large.bin', $file));
		$this->assertStringContainsString('uploadType=resumable', $client->requests[4]['url']);
		$this->assertSame('262145', $client->requests[4]['headers']['X-Upload-Content-Length']);
		$this->assertSame('bytes 0-262143/262145', $client->requests[5]['headers']['Content-Range']);
		$this->assertSame(262144, strlen((string) $client->requests[5]['body']));
		$this->assertSame('bytes 262144-262144/262145', $client->requests[6]['headers']['Content-Range']);
		$this->assertSame('a', $client->requests[6]['body']);
		$metadata = json_decode($client->requests[4]['body'], true);
		$this->assertSame(self::VARIANT_ID, $metadata['parents'][0]);
		$this->assertSame(hash_file('sha256', $file), $metadata['appProperties']['phpbbgallery_sha256']);
	}

	public function test_resumable_upload_queries_offset_and_retries_after_server_failure(): void
	{
		$file = $this->temporary_directory . '/retry.bin';
		file_put_contents($file, 'retry');
		$client = new google_drive_fake_http_client();
		$this->existing_folders($client);
		$client->responses[] = $this->files([]);
		$client->responses[] = new response(200, [
			'Location' => 'https://www.googleapis.com/upload/drive/v3/files?upload_id=retry-session',
		]);
		$client->responses[] = new response(503);
		$client->responses[] = new response(308);
		$client->responses[] = $this->json_response(200, ['id' => self::FILE_ID]);
		$provider = $this->provider($client, 262144);

		$this->assertTrue($provider->write(provider_interface::SOURCE, 'retry.bin', $file));
		$this->assertSame('bytes */5', $client->requests[6]['headers']['Content-Range']);
		$this->assertSame('retry', $client->requests[5]['body']);
		$this->assertSame('retry', $client->requests[7]['body']);
	}

	public function test_read_metadata_list_and_delete_workflow(): void
	{
		$hash = hash('sha256', 'drive-image');
		$client = new google_drive_fake_http_client();
		$this->existing_folders($client);
		$metadata = [
			'id' => self::FILE_ID,
			'name' => 'image.jpg',
			'mimeType' => 'application/octet-stream',
			'size' => '11',
			'modifiedTime' => '2026-08-06T10:30:00Z',
			'appProperties' => ['phpbbgallery_sha256' => $hash],
		];
		$client->responses[] = $this->files([$metadata]);
		$client->responses[] = $this->files([$metadata]);
		$client->responses[] = $this->files([$metadata]);
		$client->responses[] = $this->files([$metadata]);
		$client->responses[] = $this->files([$metadata]);
		$client->responses[] = $this->body_response(200, 'drive-image');
		$client->responses[] = $this->json_response(200, [
			'files' => [
				['id' => self::FILE_ID, 'name' => 'image.jpg', 'mimeType' => 'application/octet-stream'],
			],
			'nextPageToken' => 'next-page',
			'incompleteSearch' => false,
		]);
		$client->responses[] = $this->files([$metadata]);
		$client->responses[] = new response(204);
		$provider = $this->provider($client);

		$this->assertTrue($provider->exists(provider_interface::SOURCE, 'image.jpg'));
		$this->assertSame(11, $provider->size(provider_interface::SOURCE, 'image.jpg'));
		$this->assertSame(strtotime('2026-08-06T10:30:00Z'),
			$provider->modified_time(provider_interface::SOURCE, 'image.jpg'));
		$this->assertSame($hash, $provider->checksum(provider_interface::SOURCE, 'image.jpg'));
		$stream = $provider->open_stream(provider_interface::SOURCE, 'image.jpg');
		$this->assertIsResource($stream);
		$this->assertSame('drive-image', stream_get_contents($stream));
		fclose($stream);

		$page = $provider->list_objects(provider_interface::SOURCE, null, 10);
		$this->assertSame(['image.jpg'], $page['keys']);
		$this->assertSame('next-page', $page['cursor']);
		$this->assertTrue($provider->delete(provider_interface::SOURCE, 'image.jpg'));
		$this->assertSame('DELETE', $client->requests[array_key_last($client->requests)]['method']);
	}

	public function test_missing_conflict_and_untrusted_session_uri_fail_safely(): void
	{
		$file = $this->temporary_directory . '/image.jpg';
		file_put_contents($file, 'drive-image');
		$conflict = new google_drive_fake_http_client();
		$this->existing_folders($conflict);
		$conflict->responses[] = $this->files([[
			'id' => self::FILE_ID,
			'name' => 'image.jpg',
			'mimeType' => 'application/octet-stream',
		]]);
		$this->assertFalse($this->provider($conflict)->write(provider_interface::SOURCE, 'image.jpg', $file));

		$missing = new google_drive_fake_http_client();
		$this->existing_folders($missing);
		$missing->responses[] = $this->files([]);
		$this->assertFalse($this->provider($missing)->replace(provider_interface::SOURCE, 'image.jpg', $file));

		$untrusted = new google_drive_fake_http_client();
		$this->existing_folders($untrusted);
		$untrusted->responses[] = $this->files([]);
		$untrusted->responses[] = new response(200, [
			'Location' => 'https://attacker.example/upload/drive/session?secret=value',
		]);
		$this->expectException(\RuntimeException::class);
		$this->expectExceptionMessage('invalid resumable upload URI');
		$this->provider($untrusted)->write(provider_interface::SOURCE, 'image.jpg', $file);
	}

	public function test_ambiguous_names_are_rejected(): void
	{
		$client = new google_drive_fake_http_client();
		$this->existing_folders($client);
		$client->responses[] = $this->files([
			['id' => self::FILE_ID, 'name' => 'image.jpg', 'mimeType' => 'application/octet-stream'],
			['id' => 'fileobject02', 'name' => 'image.jpg', 'mimeType' => 'application/octet-stream'],
		]);

		$this->expectException(\RuntimeException::class);
		$this->expectExceptionMessage('ambiguous');
		$this->provider($client)->exists(provider_interface::SOURCE, 'image.jpg');
	}

	public function test_a_401_refreshes_the_google_access_token_once(): void
	{
		$client = new google_drive_fake_http_client();
		$this->token($client, 'expired-token');
		$client->responses[] = $this->json_response(401, ['error' => ['status' => 'UNAUTHENTICATED']]);
		$this->token($client, 'renewed-token');
		$client->responses[] = $this->files([[
			'id' => self::ROOT_ID,
			'name' => 'phpbbgallery',
			'mimeType' => 'application/vnd.google-apps.folder',
		]]);
		$client->responses[] = $this->files([[
			'id' => self::VARIANT_ID,
			'name' => 'source',
			'mimeType' => 'application/vnd.google-apps.folder',
		]]);
		$client->responses[] = $this->files([]);

		$this->assertFalse($this->provider($client)->exists(provider_interface::SOURCE, 'missing.jpg'));
		$this->assertSame('Bearer expired-token', $client->requests[1]['headers']['Authorization']);
		$this->assertSame('Bearer renewed-token', $client->requests[3]['headers']['Authorization']);
	}

	public function test_configured_factory_keeps_oauth_secrets_out_of_the_form(): void
	{
		$config = new \ArrayObject([
			'phpbb_gallery_google_drive_client_id' => '',
			'phpbb_gallery_google_drive_client_secret' => '',
			'phpbb_gallery_google_drive_refresh_token' => '',
			'phpbb_gallery_google_drive_root_name' => 'phpbbgallery',
		]);
		$request = $this->createMock(\phpbb\request\request_interface::class);
		$factory = new configured_factory(new google_drive_fake_http_client(), $config, $request, [
			'PHPBBGALLERY_GOOGLE_DRIVE_CLIENT_ID' => 'environment-id',
			'PHPBBGALLERY_GOOGLE_DRIVE_CLIENT_SECRET' => 'environment-secret',
			'PHPBBGALLERY_GOOGLE_DRIVE_REFRESH_TOKEN' => 'environment-refresh',
		]);

		$this->assertSame('google_drive', $factory->get_id());
		$this->assertSame(['client_id', 'client_secret', 'refresh_token'], $factory->environment_overrides());
		$this->assertFalse($factory->field_definitions()['client_id']['secret']);
		$this->assertTrue($factory->field_definitions()['client_secret']['secret']);
		$this->assertTrue($factory->field_definitions()['refresh_token']['secret']);
		$this->assertSame('', $config['phpbb_gallery_google_drive_client_secret']);
	}

	private function provider(google_drive_fake_http_client $client, int $chunk_size = 8388608): provider
	{
		$configuration = new configuration('client-id', 'client-secret', 'refresh-token');

		return new provider(
			$configuration,
			new token_manager($configuration, $client, static fn (): int => 1000),
			$client,
			$chunk_size
		);
	}

	private function existing_folders(google_drive_fake_http_client $client): void
	{
		$this->token($client);
		$client->responses[] = $this->files([[
			'id' => self::ROOT_ID,
			'name' => 'phpbbgallery',
			'mimeType' => 'application/vnd.google-apps.folder',
		]]);
		$client->responses[] = $this->files([[
			'id' => self::VARIANT_ID,
			'name' => 'source',
			'mimeType' => 'application/vnd.google-apps.folder',
		]]);
	}

	private function token(google_drive_fake_http_client $client, string $token = 'short-lived-token'): void
	{
		$client->responses[] = $this->json_response(200, [
			'access_token' => $token,
			'expires_in' => 14400,
		]);
	}

	/** @param list<array<string, mixed>> $files */
	private function files(array $files): response
	{
		return $this->json_response(200, [
			'files' => $files,
			'incompleteSearch' => false,
		]);
	}

	/** @param array<string, mixed> $data */
	private function json_response(int $status, array $data): response
	{
		return $this->body_response($status, json_encode($data, JSON_THROW_ON_ERROR));
	}

	private function body_response(int $status, string $body): response
	{
		$stream = fopen('php://temp', 'w+b');
		fwrite($stream, $body);
		rewind($stream);

		return new response($status, [], $stream);
	}
}

// phpcs:disable Generic.Files.OneClassPerFile.MultipleFound -- Isolated Google Drive HTTP test double.
final class google_drive_fake_http_client implements client_interface
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
			throw new \RuntimeException('No fake Google Drive HTTP response is available.');
		}

		return array_shift($this->responses);
	}
}
