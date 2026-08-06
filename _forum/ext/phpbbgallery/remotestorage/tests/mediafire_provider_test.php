<?php
/**
 * phpBB Gallery - MediaFire provider tests
 *
 * @package   phpbbgallery/remotestorage
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\remotestorage\tests;

use phpbbgallery\core\storage\provider_interface;
use phpbbgallery\remotestorage\http\client_interface;
use phpbbgallery\remotestorage\http\response;
use phpbbgallery\remotestorage\mediafire\api_client;
use phpbbgallery\remotestorage\mediafire\configuration;
use phpbbgallery\remotestorage\mediafire\config_session_store;
use phpbbgallery\remotestorage\mediafire\memory_session_store;
use phpbbgallery\remotestorage\mediafire\provider;
use PHPUnit\Framework\TestCase;

final class mediafire_provider_test extends TestCase
{
	private const ROOT_KEY = 'rootkey123';
	private const VARIANT_KEY = 'variantkey123';
	private const FILE_KEY = 'filekey123';
	private string $temporary_directory;

	// phpcs:ignore PhpbbCodingStandard.NamingConventions.LowercaseUnderscoredFunctions.NotAllowed -- PHPUnit lifecycle API.
	protected function setUp(): void
	{
		$this->temporary_directory = sys_get_temp_dir() . '/phpbbgallery-mediafire-' . bin2hex(random_bytes(6));
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

	public function test_configuration_encodes_case_safe_reversible_names(): void
	{
		$config = $this->configuration('Gallery Storage');
		$name = $config->object_name(provider_interface::SOURCE, '7/71/Image.JPG');

		$this->assertSame('g_' . bin2hex('7/71/Image.JPG'), $name);
		$this->assertSame('7/71/Image.JPG', $config->relative_key(provider_interface::SOURCE, $name));
		$this->assertNull($config->relative_key(provider_interface::SOURCE, 'unmanaged.jpg'));
		foreach (['../image.jpg', '/image.jpg', 'folder\\image.jpg', 'folder//image.jpg'] as $key)
		{
			try
			{
				$config->object_name(provider_interface::SOURCE, $key);
				$this->fail('An unsafe MediaFire key was accepted.');
			}
			catch (\InvalidArgumentException)
			{
				$this->addToAssertionCount(1);
			}
		}
		$this->expectException(\InvalidArgumentException::class);
		$this->expectExceptionMessage('name limit');
		$config->object_name(provider_interface::SOURCE, str_repeat('a', 127));
	}

	public function test_v2_authentication_hides_password_and_rotates_signature_state(): void
	{
		$client = new mediafire_fake_http_client();
		$client->responses[] = $this->api_response([
			'result' => 'Success',
			'session_token' => str_repeat('t', 64),
			'secret_key' => 9316931,
			'time' => '1359061000.8125',
			'new_key' => 'yes',
		]);
		$client->responses[] = $this->api_response(['result' => 'Success', 'new_key' => 'yes']);
		$store = new memory_session_store();
		$api = new api_client($this->configuration(), $store, $client, static fn (): int => 1000);

		$api->call('user/get_info', ['details' => 'yes']);

		$this->assertCount(2, $client->requests);
		$this->assertStringNotContainsString('password', $client->requests[0]['url']);
		$this->assertStringNotContainsString('account-password', $client->requests[0]['url']);
		$this->assertStringContainsString('password=account-password', $client->requests[0]['body']);
		$this->assertStringContainsString('signature=' . sha1('owner@example.comaccount-password12345api-secret'),
			$client->requests[0]['body']);
		$uri = '/api/1.5/user/get_info.php?session_token=' . str_repeat('t', 64)
			. '&details=yes&response_format=json';
		$signature = md5('67' . '1359061000.8125' . $uri);
		$this->assertSame('https://www.mediafire.com' . $uri . '&signature=' . $signature,
			$client->requests[1]['url']);
		$this->assertSame((9316931 * 16807) % 2147483647, $store->load()['secret_key']);
	}

	public function test_expired_or_desynchronized_remote_session_is_reauthenticated_once(): void
	{
		foreach ([105, 127] as $error)
		{
			$client = new mediafire_fake_http_client();
			$client->responses[] = $this->api_response(['result' => 'Error', 'error' => $error, 'new_key' => 'yes']);
			$client->responses[] = $this->api_response([
				'result' => 'Success',
				'session_token' => str_repeat('n', 64),
				'secret_key' => 321,
				'time' => '1700000000.25',
			]);
			$client->responses[] = $this->api_response(['result' => 'Success', 'new_key' => 'yes']);
			$store = $this->session_store();
			$api = new api_client($this->configuration(), $store, $client, static fn (): int => 1000);

			$this->assertSame('Success', $api->call('user/get_info')['result']);
			$this->assertCount(3, $client->requests);
			$this->assertStringEndsWith('/user/get_session_token.php', $client->requests[1]['url']);
			$this->assertSame((321 * 16807) % 2147483647, $store->load()['secret_key']);
		}
	}

	public function test_locked_store_reloads_current_database_state(): void
	{
		$config = new \phpbb\config\config([
			'phpbb_gallery_mediafire_session_token' => 'stale',
			'phpbb_gallery_mediafire_secret_key' => '1',
			'phpbb_gallery_mediafire_session_time' => '1',
			'phpbb_gallery_mediafire_session_issued_at' => '1',
		]);
		$db = $this->createMock(\phpbb\db\driver\driver_interface::class);
		$db->expects($this->once())->method('sql_in_set')->willReturn('config_name IN (safe)');
		$db->expects($this->once())->method('sql_query')->willReturn(7);
		$db->expects($this->exactly(5))->method('sql_fetchrow')->willReturnOnConsecutiveCalls(
			['config_name' => 'phpbb_gallery_mediafire_session_token', 'config_value' => str_repeat('d', 64)],
			['config_name' => 'phpbb_gallery_mediafire_secret_key', 'config_value' => '42'],
			['config_name' => 'phpbb_gallery_mediafire_session_time', 'config_value' => '1700000000.5'],
			['config_name' => 'phpbb_gallery_mediafire_session_issued_at', 'config_value' => '1000'],
			false
		);
		$db->expects($this->once())->method('sql_freeresult')->with(7);
		$store = new config_session_store(
			$config,
			$this->temporary_directory . '/session.lock',
			$db,
			'phpbb_config'
		);

		$state = $store->synchronized(static fn (): array => $store->load());
		$this->assertSame(str_repeat('d', 64), $state['session_token']);
		$this->assertSame(42, $state['secret_key']);
	}

	public function test_prepare_creates_private_root_and_variant_folders(): void
	{
		$client = new mediafire_fake_http_client();
		$this->folder_responses($client);
		$provider = $this->provider($client);

		$this->assertTrue($provider->prepare(provider_interface::SOURCE, 'image.jpg'));
		$this->assertTrue($provider->prepare(provider_interface::SOURCE, 'other.jpg'));
		$this->assertCount(4, $client->requests);
		$this->assertStringContainsString('foldername=phpbbgallery', $client->requests[0]['url']);
		$this->assertStringContainsString('privacy=private', $client->requests[1]['url']);
		$this->assertStringContainsString('privacy_recursive=yes', $client->requests[1]['url']);
		$this->assertStringContainsString('foldername=source', $client->requests[2]['url']);
	}

	public function test_instant_upload_is_made_private_and_integrity_checked(): void
	{
		$file = $this->temporary_directory . '/image.jpg';
		file_put_contents($file, 'mediafire-image');
		$client = new mediafire_fake_http_client();
		$this->folder_responses($client);
		$client->responses[] = $this->folder_page([]);
		$client->responses[] = $this->api_response([
			'result' => 'Success',
			'new_key' => 'yes',
			'hash_exists' => 'yes',
			'storage_limit_exceeded' => 'no',
		]);
		$client->responses[] = $this->api_response([
			'result' => 'Success',
			'new_key' => 'yes',
			'quickkey' => self::FILE_KEY,
		]);
		$client->responses[] = $this->api_response(['result' => 'Success', 'new_key' => 'yes']);

		$this->assertTrue($this->provider($client)->write(provider_interface::SOURCE, 'image.jpg', $file));
		$this->assertStringContainsString('hash=' . hash('sha256', 'mediafire-image'), $client->requests[5]['url']);
		$this->assertStringContainsString('upload%2Finstant', rawurlencode($client->requests[6]['url']));
		$this->assertStringContainsString('privacy=private', $client->requests[7]['url']);
	}

	public function test_resumable_upload_skips_completed_units_and_polls_completion(): void
	{
		$file = $this->temporary_directory . '/large.bin';
		file_put_contents($file, 'abcdef');
		$client = new mediafire_fake_http_client();
		$this->folder_responses($client);
		$client->responses[] = $this->folder_page([]);
		$client->responses[] = $this->api_response([
			'result' => 'Success',
			'new_key' => 'yes',
			'hash_exists' => 'no',
			'storage_limit_exceeded' => 'no',
			'resumable_upload' => [
				'number_of_units' => 2,
				'unit_size' => 3,
				'bitmap' => ['words' => [1]],
				'upload_key' => 'uploadkey123',
			],
		]);
		$client->responses[] = $this->api_response([
			'result' => 'Success',
			'new_key' => 'yes',
			'doupload' => ['result' => 0, 'key' => 'uploadkey123'],
		]);
		$client->responses[] = $this->api_response([
			'result' => 'Success',
			'doupload' => ['result' => 0, 'status' => 99, 'fileerror' => 0, 'quickkey' => self::FILE_KEY],
		]);
		$client->responses[] = $this->api_response(['result' => 'Success', 'new_key' => 'yes']);

		$this->assertTrue($this->provider($client)->write(provider_interface::SOURCE, 'large.bin', $file));
		$request = $client->requests[6];
		$this->assertSame('1', $request['headers']['x-unit-id']);
		$this->assertSame('def', $request['body']);
		$this->assertSame(hash('sha256', 'def'), $request['headers']['x-unit-hash']);
		$this->assertStringContainsString('upload/poll_upload.php', $client->requests[7]['url']);
		$this->assertStringNotContainsString('session_token', $client->requests[7]['url']);
	}

	public function test_list_metadata_and_permanent_delete_workflow(): void
	{
		$client = new mediafire_fake_http_client();
		$this->folder_responses($client);
		$first = $this->file('one.jpg', 10);
		$second = $this->file('two.jpg', 20);
		$third = $this->file('three.jpg', 30);
		$client->responses[] = $this->folder_page([$first, $second, $third]);
		$client->responses[] = $this->folder_page([$first, $second, $third]);
		$client->responses[] = $this->folder_page([$first]);
		$client->responses[] = $this->folder_page([$first]);
		$client->responses[] = $this->folder_page([$first]);
		$client->responses[] = $this->api_response(['result' => 'Success', 'new_key' => 'yes']);
		$provider = $this->provider($client);

		$page = $provider->list_objects(provider_interface::SOURCE, null, 2);
		$this->assertSame(['one.jpg', 'two.jpg'], $page['keys']);
		$this->assertSame('1:2', $page['cursor']);
		$this->assertSame(['three.jpg'], $provider->list_objects(
			provider_interface::SOURCE,
			$page['cursor'],
			2
		)['keys']);
		$this->assertSame(10, $provider->size(provider_interface::SOURCE, 'one.jpg'));
		$this->assertSame(hash('sha256', 'one.jpg'), $provider->checksum(provider_interface::SOURCE, 'one.jpg'));
		$this->assertTrue($provider->delete(provider_interface::SOURCE, 'one.jpg'));
		$this->assertStringContainsString('file/purge.php', $client->requests[9]['url']);
	}

	public function test_private_download_uses_https_without_forwarding_session_token(): void
	{
		$client = new mediafire_fake_http_client();
		$this->folder_responses($client);
		$client->responses[] = $this->folder_page([$this->file('image.jpg', 9)]);
		$client->responses[] = $this->api_response([
			'result' => 'Success',
			'new_key' => 'yes',
			'links' => [[
				'quickkey' => self::FILE_KEY,
				'direct_download' => 'http://download123.mediafire.com/signed/image.jpg',
			]],
		]);
		$client->responses[] = $this->body_response('mediafire-file');

		$stream = $this->provider($client)->open_stream(provider_interface::SOURCE, 'image.jpg');
		$this->assertIsResource($stream);
		$this->assertSame('mediafire-file', stream_get_contents($stream));
		fclose($stream);
		$this->assertSame('https://download123.mediafire.com/signed/image.jpg', $client->requests[6]['url']);
		$this->assertSame([], $client->requests[6]['headers']);
	}

	public function test_untrusted_private_download_host_is_rejected(): void
	{
		$client = new mediafire_fake_http_client();
		$this->folder_responses($client);
		$client->responses[] = $this->folder_page([$this->file('image.jpg', 9)]);
		$client->responses[] = $this->api_response([
			'result' => 'Success',
			'new_key' => 'yes',
			'links' => [[
				'quickkey' => self::FILE_KEY,
				'direct_download' => 'https://attacker.example/image.jpg',
			]],
		]);

		$this->expectException(\RuntimeException::class);
		$this->expectExceptionMessage('invalid private download URI');
		$this->provider($client)->open_stream(provider_interface::SOURCE, 'image.jpg');
	}

	public function test_encoded_control_in_private_download_uri_is_rejected(): void
	{
		$client = new mediafire_fake_http_client();
		$this->folder_responses($client);
		$client->responses[] = $this->folder_page([$this->file('image.jpg', 9)]);
		$client->responses[] = $this->api_response([
			'result' => 'Success',
			'new_key' => 'yes',
			'links' => [[
				'quickkey' => self::FILE_KEY,
				'direct_download' => 'https://download123.mediafire.com/signed/%0d%0aInjected',
			]],
		]);

		$this->expectException(\RuntimeException::class);
		$this->expectExceptionMessage('invalid private download URI');
		$this->provider($client)->open_stream(provider_interface::SOURCE, 'image.jpg');
	}

	private function configuration(string $root = 'phpbbgallery'): configuration
	{
		return new configuration('12345', 'api-secret', 'owner@example.com', 'account-password', $root);
	}

	private function session_store(): memory_session_store
	{
		return new memory_session_store(str_repeat('s', 64), 100, '1700000000.5', 1000);
	}

	private function provider(mediafire_fake_http_client $client): provider
	{
		$config = $this->configuration();
		$api = new api_client($config, $this->session_store(), $client, static fn (): int => 1000);

		return new provider($config, $api, $client, static function (int $seconds): void
		{
		});
	}

	private function folder_responses(mediafire_fake_http_client $client): void
	{
		$client->responses[] = $this->api_response([
			'result' => 'Success', 'new_key' => 'yes', 'folder_key' => self::ROOT_KEY,
		]);
		$client->responses[] = $this->api_response(['result' => 'Success', 'new_key' => 'yes']);
		$client->responses[] = $this->api_response([
			'result' => 'Success', 'new_key' => 'yes', 'folder_key' => self::VARIANT_KEY,
		]);
		$client->responses[] = $this->api_response(['result' => 'Success', 'new_key' => 'yes']);
	}

	/** @param list<array<string, mixed>> $files */
	private function folder_page(array $files, bool $more = false): response
	{
		return $this->api_response([
			'result' => 'Success',
			'new_key' => 'yes',
			'folder_content' => [
				'chunk_number' => 1,
				'files' => $files,
				'more_chunks' => $more ? 'yes' : 'no',
			],
		]);
	}

	/** @return array<string, mixed> */
	private function file(string $key, int $size): array
	{
		return [
			'quickkey' => self::FILE_KEY,
			'filename' => 'g_' . bin2hex($key),
			'hash' => hash('sha256', $key),
			'size' => (string) $size,
			'privacy' => 'private',
			'created_utc' => '2026-08-06T10:30:00Z',
		];
	}

	/** @param array<string, mixed> $data */
	private function api_response(array $data): response
	{
		$stream = fopen('php://temp', 'w+b');
		fwrite($stream, json_encode(['response' => $data], JSON_THROW_ON_ERROR));
		rewind($stream);

		return new response(200, ['Content-Type' => 'application/json'], $stream);
	}

	private function body_response(string $contents): response
	{
		$stream = fopen('php://temp', 'w+b');
		fwrite($stream, $contents);
		rewind($stream);

		return new response(200, [], $stream);
	}
}

// phpcs:disable Generic.Files.OneClassPerFile.MultipleFound -- Isolated MediaFire HTTP test double.
final class mediafire_fake_http_client implements client_interface
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
			throw new \RuntimeException('No fake MediaFire response was queued.');
		}

		return $response;
	}
}
