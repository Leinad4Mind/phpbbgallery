<?php
/**
 * phpBB Gallery - Box provider tests
 *
 * @package   phpbbgallery/remotestorage
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\remotestorage\tests;

use phpbbgallery\core\storage\provider_interface;
use phpbbgallery\remotestorage\providers\box\configuration;
use phpbbgallery\remotestorage\providers\box\config_token_store;
use phpbbgallery\remotestorage\providers\box\configured_factory;
use phpbbgallery\remotestorage\providers\box\memory_token_store;
use phpbbgallery\remotestorage\providers\box\provider;
use phpbbgallery\remotestorage\providers\box\token_manager;
use phpbbgallery\remotestorage\http\client_interface;
use phpbbgallery\remotestorage\http\response;
use PHPUnit\Framework\TestCase;

final class box_provider_test extends TestCase
{
	private const ROOT_ID = '1001';
	private const VARIANT_ID = '1002';
	private const FILE_ID = '1003';
	private string $temporary_directory;

	// phpcs:ignore PhpbbCodingStandard.NamingConventions.LowercaseUnderscoredFunctions.NotAllowed -- PHPUnit lifecycle API.
	protected function setUp(): void
	{
		$this->temporary_directory = sys_get_temp_dir() . '/phpbbgallery-box-' . bin2hex(random_bytes(6));
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
		$config = new configuration('client-id', 'client-secret', 'Gallery Storage');
		$name = $config->object_name(provider_interface::SOURCE, '7/71/Image.JPG');

		$this->assertSame('g_' . bin2hex('7/71/Image.JPG'), $name);
		$this->assertSame('7/71/Image.JPG', $config->relative_key(provider_interface::SOURCE, $name));
		$this->assertNull($config->relative_key(provider_interface::SOURCE, 'unmanaged.jpg'));
		foreach (['../image.jpg', '/image.jpg', 'folder\\image.jpg', 'folder//image.jpg'] as $key)
		{
			try
			{
				$config->object_name(provider_interface::SOURCE, $key);
				$this->fail('An unsafe Box key was accepted.');
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

	public function test_single_use_refresh_token_is_rotated_and_cached(): void
	{
		$client = new box_fake_http_client();
		$client->responses[] = $this->json_response(200, [
			'access_token' => 'new-access',
			'refresh_token' => 'new-refresh',
			'expires_in' => 3600,
		]);
		$store = new memory_token_store('old-refresh');
		$manager = new token_manager(
			new configuration('client-id', 'client-secret'),
			$store,
			$client,
			static fn (): int => 1000
		);

		$this->assertSame('new-access', $manager->token());
		$this->assertSame('new-access', $manager->token());
		$this->assertCount(1, $client->requests);
		$this->assertStringContainsString('refresh_token=old-refresh', $client->requests[0]['body']);
		$this->assertStringNotContainsString('old-refresh', $client->requests[0]['url']);
		$this->assertSame('new-refresh', $store->load()['refresh_token']);
		$this->assertSame(4600, $store->load()['access_expires']);
	}

	public function test_config_store_lock_prevents_reusing_a_rotated_token(): void
	{
		$config = new \phpbb\config\config([
			'phpbb_gallery_box_access_token' => '',
			'phpbb_gallery_box_access_expires' => '0',
			'phpbb_gallery_box_refresh_token' => 'first-refresh',
		]);
		$lock = $this->temporary_directory . '/oauth.lock';
		$client = new box_fake_http_client();
		$client->responses[] = $this->json_response(200, [
			'access_token' => 'shared-access',
			'refresh_token' => 'second-refresh',
			'expires_in' => 3600,
		]);
		$configuration = new configuration('client-id', 'client-secret');
		$first = new token_manager($configuration, new config_token_store($config, $lock), $client,
			static fn (): int => 1000);
		$second = new token_manager($configuration, new config_token_store($config, $lock), $client,
			static fn (): int => 1000);

		$this->assertSame('shared-access', $first->token());
		$this->assertSame('shared-access', $second->token());
		$this->assertCount(1, $client->requests);
		$this->assertSame('second-refresh', $config['phpbb_gallery_box_refresh_token']);
	}

	public function test_locked_store_reloads_database_instead_of_stale_request_config(): void
	{
		$config = new \phpbb\config\config([
			'phpbb_gallery_box_access_token' => 'stale-access',
			'phpbb_gallery_box_access_expires' => '1',
			'phpbb_gallery_box_refresh_token' => 'spent-refresh',
		]);
		$db = $this->createMock(\phpbb\db\driver\driver_interface::class);
		$db->expects($this->once())->method('sql_in_set')->willReturn('config_name IN (safe)');
		$db->expects($this->once())->method('sql_query')->willReturn(7);
		$db->expects($this->exactly(4))->method('sql_fetchrow')->willReturnOnConsecutiveCalls(
			['config_name' => 'phpbb_gallery_box_access_token', 'config_value' => 'database-access'],
			['config_name' => 'phpbb_gallery_box_access_expires', 'config_value' => '5000'],
			['config_name' => 'phpbb_gallery_box_refresh_token', 'config_value' => 'database-refresh'],
			false
		);
		$db->expects($this->once())->method('sql_freeresult')->with(7);
		$client = new box_fake_http_client();
		$configuration = new configuration('client-id', 'client-secret');
		$manager = new token_manager(
			$configuration,
			new config_token_store($config, $this->temporary_directory . '/database.lock', $db, 'phpbb_config'),
			$client,
			static fn (): int => 1000
		);

		$this->assertSame('database-access', $manager->token());
		$this->assertCount(0, $client->requests);
	}

	public function test_prepare_creates_dedicated_root_and_variant_folders(): void
	{
		$client = new box_fake_http_client();
		$client->responses[] = $this->folder_page([]);
		$client->responses[] = $this->json_response(201, [
			'id' => self::ROOT_ID,
			'type' => 'folder',
			'name' => 'phpbbgallery',
		]);
		$client->responses[] = $this->folder_page([]);
		$client->responses[] = $this->json_response(201, [
			'id' => self::VARIANT_ID,
			'type' => 'folder',
			'name' => 'source',
		]);
		$provider = $this->provider($client);

		$this->assertTrue($provider->prepare(provider_interface::SOURCE, 'image.jpg'));
		$this->assertTrue($provider->prepare(provider_interface::SOURCE, 'other.jpg'));
		$this->assertCount(4, $client->requests);
		$this->assertSame('POST', $client->requests[1]['method']);
		$this->assertSame('phpbbgallery', json_decode($client->requests[1]['body'], true)['name']);
		$this->assertSame('source', json_decode($client->requests[3]['body'], true)['name']);
	}

	public function test_small_upload_places_attributes_before_file_content(): void
	{
		$file = $this->temporary_directory . '/image.jpg';
		file_put_contents($file, 'box-image');
		$client = new box_fake_http_client();
		$this->existing_folders($client);
		$client->responses[] = $this->folder_page([]);
		$client->responses[] = $this->json_response(201, ['entries' => [['id' => self::FILE_ID]]]);

		$this->assertTrue($this->provider($client)->write(provider_interface::SOURCE, 'image.jpg', $file));
		$request = $client->requests[3];
		$this->assertSame('POST', $request['method']);
		$this->assertSame('https://upload.box.com/api/2.0/files/content', $request['url']);
		$this->assertLessThan(
			strpos($request['body'], 'name=' . chr(34) . 'file' . chr(34)),
			strpos($request['body'], 'name=' . chr(34) . 'attributes' . chr(34))
		);
		$this->assertStringEndsWith('box-image' . chr(13) . chr(10)
			. '--' . substr(strrchr($request['headers']['Content-Type'], '='), 1) . '--' . chr(13) . chr(10), $request['body']);
		$this->assertSame(base64_encode(hash('sha1', 'box-image', true)), $request['headers']['Content-MD5']);
	}

	public function test_large_upload_uses_verified_parts_and_retries_commit(): void
	{
		$file = $this->temporary_directory . '/large.bin';
		file_put_contents($file, 'abcde');
		$client = new box_fake_http_client();
		$this->existing_folders($client);
		$client->responses[] = $this->folder_page([]);
		$base = 'https://upload.box.com/api/2.0/files/upload_sessions/SAFE123';
		$client->responses[] = $this->json_response(201, [
			'part_size' => 3,
			'total_parts' => 2,
			'session_endpoints' => [
				'upload_part' => $base,
				'commit' => $base . '/commit',
				'abort' => $base,
			],
		]);
		$client->responses[] = $this->part(0, 'abc', 'part-one');
		$client->responses[] = $this->part(3, 'de', 'part-two');
		$client->responses[] = new response(202, ['Retry-After' => '1']);
		$client->responses[] = new response(201);
		$delays = [];
		$provider = $this->provider($client, 1, static function (int $seconds) use (&$delays): void
		{
			$delays[] = $seconds;
		});

		$this->assertTrue($provider->write(provider_interface::SOURCE, 'large.bin', $file));
		$this->assertSame('bytes 0-2/5', $client->requests[4]['headers']['Content-Range']);
		$this->assertSame('bytes 3-4/5', $client->requests[5]['headers']['Content-Range']);
		$this->assertSame('sha=' . base64_encode(hash('sha1', 'abc', true)),
			$client->requests[4]['headers']['Digest']);
		$this->assertSame([1], $delays);
		$commit = json_decode($client->requests[6]['body'], true);
		$this->assertSame(['part-one', 'part-two'], array_column($commit['parts'], 'part_id'));
	}

	public function test_private_download_follows_only_boxcloud_without_forwarding_authorization(): void
	{
		$client = new box_fake_http_client();
		$this->existing_folders($client);
		$client->responses[] = $this->folder_page([$this->file('image.jpg', 9)]);
		$client->responses[] = new response(302, [
			'Location' => 'https://dl.boxcloud.com/d/1/signed/download',
		]);
		$client->responses[] = $this->body_response(200, 'box-file');
		$stream = $this->provider($client)->open_stream(provider_interface::SOURCE, 'image.jpg');

		$this->assertIsResource($stream);
		$this->assertSame('box-file', stream_get_contents($stream));
		fclose($stream);
		$this->assertSame([], $client->requests[4]['headers']);
		$this->assertSame('https://dl.boxcloud.com/d/1/signed/download', $client->requests[4]['url']);
	}

	public function test_metadata_checksum_replace_and_delete_workflow(): void
	{
		$file = $this->temporary_directory . '/replacement.jpg';
		file_put_contents($file, 'replacement');
		$client = new box_fake_http_client();
		$this->existing_folders($client);
		$metadata = $this->file('image.jpg', 8);
		$client->responses[] = $this->folder_page([$metadata]);
		$client->responses[] = $this->folder_page([$metadata]);
		$client->responses[] = $this->folder_page([$metadata]);
		$client->responses[] = new response(302, [
			'Location' => 'https://dl.boxcloud.com/d/1/checksum/download',
		]);
		$client->responses[] = $this->body_response(200, 'box-file');
		$client->responses[] = $this->folder_page([$metadata]);
		$client->responses[] = $this->json_response(201, ['entries' => [['id' => self::FILE_ID]]]);
		$client->responses[] = $this->folder_page([$metadata]);
		$client->responses[] = new response(204);
		$provider = $this->provider($client);

		$this->assertSame(8, $provider->size(provider_interface::SOURCE, 'image.jpg'));
		$this->assertSame(strtotime('2026-08-06T10:30:00Z'),
			$provider->modified_time(provider_interface::SOURCE, 'image.jpg'));
		$this->assertSame(hash('sha256', 'box-file'),
			$provider->checksum(provider_interface::SOURCE, 'image.jpg'));
		$this->assertTrue($provider->replace(provider_interface::SOURCE, 'image.jpg', $file));
		$this->assertStringEndsWith('/files/' . self::FILE_ID . '/content', $client->requests[8]['url']);
		$this->assertTrue($provider->delete(provider_interface::SOURCE, 'image.jpg'));
		$this->assertSame('DELETE', $client->requests[10]['method']);
	}

	public function test_untrusted_download_redirect_is_rejected(): void
	{
		$client = new box_fake_http_client();
		$this->existing_folders($client);
		$client->responses[] = $this->folder_page([$this->file('image.jpg', 9)]);
		$client->responses[] = new response(302, [
			'Location' => 'https://attacker.example/signed/download',
		]);

		$this->expectException(\RuntimeException::class);
		$this->expectExceptionMessage('invalid private download URI');
		$this->provider($client)->open_stream(provider_interface::SOURCE, 'image.jpg');
	}

	public function test_not_ready_download_honours_a_bounded_retry_delay(): void
	{
		$client = new box_fake_http_client();
		$this->existing_folders($client);
		$client->responses[] = $this->folder_page([$this->file('image.jpg', 9)]);
		$client->responses[] = new response(202, ['Retry-After' => '1']);
		$client->responses[] = new response(302, [
			'Location' => 'https://dl.boxcloud.com/d/1/retried/download',
		]);
		$client->responses[] = $this->body_response(200, 'available');
		$delays = [];
		$provider = $this->provider($client, 52428800,
			static function (int $seconds) use (&$delays): void
			{
				$delays[] = $seconds;
			});
		$stream = $provider->open_stream(provider_interface::SOURCE, 'image.jpg');

		$this->assertIsResource($stream);
		$this->assertSame('available', stream_get_contents($stream));
		fclose($stream);
		$this->assertSame([1], $delays);
	}

	public function test_listing_decodes_owned_names_and_preserves_marker(): void
	{
		$client = new box_fake_http_client();
		$this->existing_folders($client);
		$configuration = new configuration('client-id', 'client-secret');
		$client->responses[] = $this->json_response(200, [
			'entries' => [[
				'id' => self::FILE_ID,
				'type' => 'file',
				'name' => $configuration->object_name(provider_interface::SOURCE, '7/71/image.jpg'),
			]],
			'next_marker' => 'next-page',
		]);
		$page = $this->provider($client)->list_objects(provider_interface::SOURCE, null, 10);

		$this->assertSame(['7/71/image.jpg'], $page['keys']);
		$this->assertSame('next-page', $page['cursor']);
	}

	public function test_a_401_invalidates_only_the_issued_access_token_and_rotates_once(): void
	{
		$client = new box_fake_http_client();
		$client->responses[] = new response(401);
		$client->responses[] = $this->json_response(200, [
			'access_token' => 'renewed-access',
			'refresh_token' => 'renewed-refresh',
			'expires_in' => 3600,
		]);
		$client->responses[] = $this->folder_page([[
			'id' => self::ROOT_ID, 'type' => 'folder', 'name' => 'phpbbgallery',
		]]);
		$client->responses[] = $this->folder_page([[
			'id' => self::VARIANT_ID, 'type' => 'folder', 'name' => 'source',
		]]);
		$store = new memory_token_store('old-refresh', 'expired-access', 5000);
		$configuration = new configuration('client-id', 'client-secret');
		$provider = new provider($configuration,
			new token_manager($configuration, $store, $client, static fn (): int => 1000), $client);

		$this->assertTrue($provider->prepare(provider_interface::SOURCE, 'image.jpg'));
		$this->assertSame('Bearer expired-access', $client->requests[0]['headers']['Authorization']);
		$this->assertSame('Bearer renewed-access', $client->requests[2]['headers']['Authorization']);
		$this->assertSame('renewed-refresh', $store->load()['refresh_token']);
	}

	public function test_configured_factory_returns_rotated_credentials_after_connection_use(): void
	{
		$config = new \ArrayObject();
		$request = $this->createMock(\phpbb\request\request_interface::class);
		$request->method('server')->willReturn('');
		$client = new box_fake_http_client();
		$client->responses[] = $this->json_response(200, [
			'access_token' => 'tested-access',
			'refresh_token' => 'tested-refresh',
			'expires_in' => 3600,
		]);
		$client->responses[] = $this->folder_page([[
			'id' => self::ROOT_ID, 'type' => 'folder', 'name' => 'phpbbgallery',
		]]);
		$client->responses[] = $this->folder_page([[
			'id' => self::VARIANT_ID, 'type' => 'folder', 'name' => 'source',
		]]);
		$factory = new configured_factory($client, $config, $request,
			$this->createMock(\phpbb\db\driver\driver_interface::class), 'phpbb_config',
			$this->temporary_directory . '/oauth.lock');
		$settings = [
			'client_id' => 'client-id',
			'client_secret' => 'client-secret',
			'refresh_token' => 'submitted-refresh',
			'root_name' => 'phpbbgallery',
		];
		$factory->create_from($settings)->prepare(provider_interface::SOURCE, 'image.jpg');
		$final = $factory->finalize_tested_settings($settings);

		$this->assertSame('tested-refresh', $final['refresh_token']);
		$this->assertSame('tested-access', $final['access_token']);
		$this->assertGreaterThan(time() + 3000, (int) $final['access_expires']);
		$this->assertSame([], $factory->environment_overrides());
	}

	private function provider(
		box_fake_http_client $client,
		int $simple_limit = 52428800,
		?\Closure $sleeper = null
	): provider
	{
		$configuration = new configuration('client-id', 'client-secret');
		$store = new memory_token_store('refresh-token', 'access-token', 5000);

		return new provider(
			$configuration,
			new token_manager($configuration, $store, $client, static fn (): int => 1000),
			$client,
			$simple_limit,
			$sleeper
		);
	}

	private function existing_folders(box_fake_http_client $client): void
	{
		$client->responses[] = $this->folder_page([[
			'id' => self::ROOT_ID, 'type' => 'folder', 'name' => 'phpbbgallery',
		]]);
		$client->responses[] = $this->folder_page([[
			'id' => self::VARIANT_ID, 'type' => 'folder', 'name' => 'source',
		]]);
	}

	/** @return array<string, mixed> */
	private function file(string $key, int $size): array
	{
		$config = new configuration('client-id', 'client-secret');

		return [
			'id' => self::FILE_ID,
			'type' => 'file',
			'name' => $config->object_name(provider_interface::SOURCE, $key),
			'size' => $size,
			'modified_at' => '2026-08-06T10:30:00Z',
		];
	}

	private function part(int $offset, string $contents, string $part_id): response
	{
		return $this->json_response(200, ['part' => [
			'part_id' => $part_id,
			'offset' => $offset,
			'size' => strlen($contents),
			'sha1' => hash('sha1', $contents),
		]]);
	}

	/** @param list<array<string, mixed>> $entries */
	private function folder_page(array $entries): response
	{
		return $this->json_response(200, ['entries' => $entries]);
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

// phpcs:disable Generic.Files.OneClassPerFile.MultipleFound -- Isolated Box HTTP test double.
final class box_fake_http_client implements client_interface
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
			throw new \RuntimeException('No fake Box HTTP response is available.');
		}

		return array_shift($this->responses);
	}
}
