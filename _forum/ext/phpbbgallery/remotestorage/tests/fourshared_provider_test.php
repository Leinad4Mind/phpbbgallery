<?php
/**
 * phpBB Gallery - 4shared provider tests
 *
 * @package   phpbbgallery/remotestorage
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\remotestorage\tests;

use PHPUnit\Framework\TestCase;
use phpbb\request\request_interface;
use phpbbgallery\core\storage\provider_interface;
use phpbbgallery\remotestorage\fourshared\api_client;
use phpbbgallery\remotestorage\fourshared\configuration;
use phpbbgallery\remotestorage\fourshared\configured_factory;
use phpbbgallery\remotestorage\fourshared\oauth_signer;
use phpbbgallery\remotestorage\fourshared\operation_lock;
use phpbbgallery\remotestorage\fourshared\provider;
use phpbbgallery\remotestorage\http\client_interface;
use phpbbgallery\remotestorage\http\response;

final class fourshared_provider_test extends TestCase
{
	private string $temporary_directory;

	// phpcs:ignore PhpbbCodingStandard.NamingConventions.LowercaseUnderscoredFunctions.NotAllowed -- PHPUnit lifecycle API.
	protected function setUp(): void
	{
		$this->temporary_directory = sys_get_temp_dir() . '/phpbbgallery-fourshared-' . bin2hex(random_bytes(6));
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

	public function test_configuration_uses_fixed_tls_hosts_and_round_trips_safe_names(): void
	{
		$configuration = $this->configuration();
		foreach (['image.jpg', 'nested/name.webp', 'Upper Case.png'] as $key)
		{
			$name = $configuration->object_name(provider_interface::SOURCE, $key);
			$this->assertMatchesRegularExpression('/^g_[a-f0-9]+$/D', $name);
			$this->assertSame($key, $configuration->relative_key(provider_interface::SOURCE, $name));
		}
		$this->assertSame('https://api.4shared.com/v1_2/user', $configuration->api_url('/user'));
		$this->assertSame('https://upload.4shared.com/v1_2/files', $configuration->upload_url('/files'));

		$this->expectException(\InvalidArgumentException::class);
		new configuration('consumer-key', 'consumer-secret', 'access-token', 'access-secret', '../shared');
	}

	public function test_oauth_signature_is_deterministic_and_secrets_are_not_exposed(): void
	{
		$signer = new oauth_signer(
			$this->configuration(),
			static fn (): string => '0123456789abcdef',
			static fn (): int => 1720000000
		);
		$authorization = $signer->authorization('GET', 'https://api.4shared.com/v1_2/user', ['limit' => 10]);

		$this->assertSame(
			'OAuth oauth_consumer_key=' . chr(34) . 'consumer-key' . chr(34)
			. ', oauth_nonce=' . chr(34) . '0123456789abcdef' . chr(34)
			. ', oauth_signature=' . chr(34) . 'puwDMBxYr0t1I98Tm%2FeveDCETTQ%3D' . chr(34)
			. ', oauth_signature_method=' . chr(34) . 'HMAC-SHA1' . chr(34)
			. ', oauth_timestamp=' . chr(34) . '1720000000' . chr(34)
			. ', oauth_token=' . chr(34) . 'access-token' . chr(34)
			. ', oauth_version=' . chr(34) . '1.0' . chr(34),
			$authorization
		);
		$this->assertStringNotContainsString('consumer-secret', $authorization);
		$this->assertStringNotContainsString('access-secret', $authorization);

		$this->expectException(\InvalidArgumentException::class);
		$signer->authorization('GET', 'https://attacker.example/v1_2/user');
	}

	public function test_api_signs_query_and_form_without_putting_credentials_in_url(): void
	{
		$client = new fourshared_fake_http_client();
		$client->responses[] = $this->json_response(['id' => 'upload-id']);
		$api = $this->api($client);

		$this->assertSame(['id' => 'upload-id'], $api->json(
			'POST', 'https://upload.4shared.com/v1_2/upload', ['mode' => 'safe'], ['name' => 'image']
		));
		$request = $client->requests[0];
		$this->assertSame('https://upload.4shared.com/v1_2/upload?mode=safe', $request['url']);
		$this->assertSame('name=image', $request['body']);
		$this->assertStringStartsWith('OAuth ', $request['headers']['Authorization']);
		$this->assertStringNotContainsString('consumer-secret', $request['url']);
		$this->assertStringNotContainsString('access-secret', $request['url']);
	}

	public function test_api_rejects_a_list_or_malformed_json_envelope(): void
	{
		$client = new fourshared_fake_http_client();
		$client->responses[] = new response(200, [], $this->stream('[]'));

		$this->expectException(\RuntimeException::class);
		$this->expectExceptionMessage('invalid API envelope');
		$this->api($client)->json('GET', 'https://api.4shared.com/v1_2/user');
	}

	public function test_configured_factory_keeps_oauth_values_secret_and_supports_environment(): void
	{
		$config = new \ArrayObject([
			'phpbb_gallery_fourshared_consumer_key' => 'configured-key',
			'phpbb_gallery_fourshared_consumer_secret' => 'configured-secret',
			'phpbb_gallery_fourshared_access_token' => 'configured-token',
			'phpbb_gallery_fourshared_access_token_secret' => 'configured-token-secret',
			'phpbb_gallery_fourshared_root_name' => 'configured-root',
		]);
		$request = $this->createMock(request_interface::class);
		$factory = new configured_factory(
			new fourshared_fake_http_client(), $config, $request,
			$this->temporary_directory . '/factory.lock', [
				'PHPBBGALLERY_FOURSHARED_ACCESS_TOKEN' => 'environment-token',
				'PHPBBGALLERY_FOURSHARED_ACCESS_TOKEN_SECRET' => 'environment-token-secret',
			]
		);

		$fields = $factory->field_definitions();
		$this->assertTrue($fields['consumer_secret']['secret']);
		$this->assertTrue($fields['access_token']['secret']);
		$this->assertTrue($fields['access_token_secret']['secret']);
		$this->assertSame(['access_token', 'access_token_secret'], $factory->environment_overrides());
		$this->assertSame('fourshared', $factory->create_from(['root_name' => 'submitted-root'])->get_id());
	}

	public function test_prepare_creates_private_exclusively_owned_folders(): void
	{
		$client = new fourshared_fake_http_client();
		$this->queue_prepare($client);

		$this->assertTrue($this->provider($client)->prepare(provider_interface::SOURCE, 'image.jpg'));
		$this->assertSame(['GET', 'GET', 'POST', 'PUT', 'GET', 'POST', 'PUT', 'GET'],
			array_column($client->requests, 'method'));
		$this->assertSame('access=private', $client->requests[3]['body']);
		$this->assertSame('access=private', $client->requests[6]['body']);
		$this->assertFileExists($this->temporary_directory . '/4shared.lock');
		foreach ($client->requests as $request)
		{
			$this->assertStringStartsWith('https://', $request['url']);
			$this->assertStringStartsWith('OAuth ', $request['headers']['Authorization']);
		}
	}

	public function test_prepare_rejects_a_shared_or_member_folder(): void
	{
		$client = new fourshared_fake_http_client();
		$client->responses[] = $this->json_response($this->user());
		$client->responses[] = $this->json_response(['folders' => []]);
		$client->responses[] = $this->json_response(['id' => 'gallery-root']);
		$client->responses[] = $this->json_response($this->folder(
			'gallery-root', 'user-root', 'phpbbgallery', ['access' => 'public', 'hasMembers' => true]
		));

		$this->expectException(\RuntimeException::class);
		$this->expectExceptionMessage('not private and exclusively owned');
		$this->provider($client)->prepare(provider_interface::SOURCE, 'image.jpg');
	}

	public function test_simple_write_uses_a_private_temporary_object_then_publishes_it(): void
	{
		$contents = '4shared-image';
		$local = $this->local_file($contents);
		$client = new fourshared_fake_http_client();
		$this->queue_prepare($client);
		$pending = '';
		$client->responses[] = function (array $request) use (&$pending): response
		{
			parse_str((string) parse_url($request['url'], PHP_URL_QUERY), $query);
			$pending = (string) ($query['fileName'] ?? '');
			$this->assertMatchesRegularExpression('/^p_[a-f0-9]{32}_g_[a-f0-9]+$/D', $pending);
			$this->assertSame('4shared-image', $request['body']);

			return $this->json_response(['id' => 'new-file']);
		};
		$client->responses[] = function () use (&$pending, $contents): response
		{
			return $this->json_response($this->file('new-file', $pending, $contents));
		};
		$client->responses[] = fn (): response => $this->json_response(
			$this->file('new-file', $this->configuration()->object_name(provider_interface::SOURCE, 'image.jpg'), $contents)
		);

		$this->assertTrue($this->provider($client)->write(provider_interface::SOURCE, 'image.jpg', $local));
		$this->assertSame('ownerOnly=true', $client->requests[9]['body']);
		$this->assertStringContainsString('name=g_', $client->requests[10]['body']);
	}

	public function test_create_and_replace_enforce_provider_interface_preconditions(): void
	{
		$local = $this->local_file('replacement');
		$name = $this->configuration()->object_name(provider_interface::SOURCE, 'image.jpg');
		$create_client = new fourshared_fake_http_client();
		$this->queue_prepare($create_client, [$this->file('old-file', $name, 'old')]);
		$this->assertFalse($this->provider($create_client)->write(
			provider_interface::SOURCE, 'image.jpg', $local
		));
		$this->assertCount(8, $create_client->requests);

		$replace_client = new fourshared_fake_http_client();
		$this->queue_prepare($replace_client);
		$this->assertFalse($this->provider($replace_client)->replace(
			provider_interface::SOURCE, 'image.jpg', $local
		));
		$this->assertCount(8, $replace_client->requests);
	}

	public function test_replace_keeps_a_recoverable_backup_until_new_object_is_published(): void
	{
		$old = 'old-image';
		$new = 'new-image';
		$local = $this->local_file($new);
		$name = $this->configuration()->object_name(provider_interface::SOURCE, 'image.jpg');
		$client = new fourshared_fake_http_client();
		$this->queue_prepare($client, [$this->file('old-file', $name, $old)]);
		$pending = '';
		$backup = '';
		$client->responses[] = function (array $request) use (&$pending): response
		{
			parse_str((string) parse_url($request['url'], PHP_URL_QUERY), $query);
			$pending = (string) $query['fileName'];

			return $this->json_response(['id' => 'new-file']);
		};
		$client->responses[] = function () use (&$pending, $new): response
		{
			return $this->json_response($this->file('new-file', $pending, $new));
		};
		$client->responses[] = function (array $request) use (&$backup, $old): response
		{
			parse_str($request['body'], $form);
			$backup = (string) $form['name'];
			$this->assertMatchesRegularExpression('/^b_[a-f0-9]{32}_g_[a-f0-9]+$/D', $backup);

			return $this->json_response($this->file('old-file', $backup, $old));
		};
		$client->responses[] = fn (): response => $this->json_response($this->file('new-file', $name, $new));
		$client->responses[] = new response(204);

		$this->assertTrue($this->provider($client)->replace(provider_interface::SOURCE, 'image.jpg', $local));
		$this->assertSame('DELETE', $client->requests[12]['method']);
		$this->assertStringEndsWith('/files/old-file', $client->requests[12]['url']);
	}

	public function test_failed_replacement_restores_the_backup_and_removes_the_pending_object(): void
	{
		$old = 'old-image';
		$new = 'new-image';
		$local = $this->local_file($new);
		$name = $this->configuration()->object_name(provider_interface::SOURCE, 'image.jpg');
		$client = new fourshared_fake_http_client();
		$this->queue_prepare($client, [$this->file('old-file', $name, $old)]);
		$pending = '';
		$backup = '';
		$client->responses[] = function (array $request) use (&$pending): response
		{
			parse_str((string) parse_url($request['url'], PHP_URL_QUERY), $query);
			$pending = (string) $query['fileName'];

			return $this->json_response(['id' => 'new-file']);
		};
		$client->responses[] = function () use (&$pending, $new): response
		{
			return $this->json_response($this->file('new-file', $pending, $new));
		};
		$client->responses[] = function (array $request) use (&$backup, $old): response
		{
			parse_str($request['body'], $form);
			$backup = (string) $form['name'];

			return $this->json_response($this->file('old-file', $backup, $old));
		};
		$client->responses[] = $this->json_response($this->file('new-file', 'wrong-name', $new));
		$client->responses[] = $this->json_response($this->file('old-file', $name, $old));
		$client->responses[] = new response(204);

		try
		{
			$this->provider($client)->replace(provider_interface::SOURCE, 'image.jpg', $local);
			$this->fail('The invalid publication metadata was accepted.');
		}
		catch (\RuntimeException $exception)
		{
			$this->assertStringContainsString('invalid or non-private', $exception->getMessage());
		}
		$this->assertSame('PUT', $client->requests[12]['method']);
		$this->assertSame('DELETE', $client->requests[13]['method']);
		$this->assertStringEndsWith('/files/new-file', $client->requests[13]['url']);
	}

	public function test_reconciliation_finishes_an_interrupted_replacement(): void
	{
		$name = $this->configuration()->object_name(provider_interface::SOURCE, 'image.jpg');
		$pending = 'p_' . str_repeat('a', 32) . '_' . $name;
		$backup = 'b_' . str_repeat('b', 32) . '_' . $name;
		$client = new fourshared_fake_http_client();
		$this->queue_prepare($client, [
			$this->file('new-file', $pending, 'new'),
			$this->file('old-file', $backup, 'old'),
		]);
		$client->responses[] = $this->json_response($this->file('new-file', $name, 'new'));
		$client->responses[] = new response(204);

		$this->assertTrue($this->provider($client)->exists(provider_interface::SOURCE, 'image.jpg'));
		$this->assertSame('PUT', $client->requests[8]['method']);
		$this->assertSame('DELETE', $client->requests[9]['method']);
	}

	public function test_large_write_uses_bounded_content_range_chunks(): void
	{
		$contents = 'abcdefgh';
		$local = $this->local_file($contents);
		$client = new fourshared_fake_http_client();
		$this->queue_prepare($client);
		$pending = '';
		$client->responses[] = function (array $request) use (&$pending): response
		{
			parse_str($request['body'], $form);
			$pending = (string) $form['name'];

			return $this->json_response(['id' => 'upload-id']);
		};
		$client->responses[] = new response(308);
		$client->responses[] = new response(308);
		$client->responses[] = new response(201);
		$client->responses[] = function () use (&$pending, $contents): response
		{
			return $this->json_response($this->file('upload-id', $pending, $contents));
		};
		$client->responses[] = function () use (&$pending, $contents): response
		{
			return $this->json_response($this->file('upload-id', $pending, $contents));
		};
		$name = $this->configuration()->object_name(provider_interface::SOURCE, 'large.bin');
		$client->responses[] = $this->json_response($this->file('upload-id', $name, $contents));

		$this->assertTrue($this->provider($client, 4, 3)->write(
			provider_interface::SOURCE, 'large.bin', $local
		));
		$this->assertSame('bytes 0-2/8', $client->requests[9]['headers']['Content-Range']);
		$this->assertSame('abc', $client->requests[9]['body']);
		$this->assertSame('bytes 3-5/8', $client->requests[10]['headers']['Content-Range']);
		$this->assertSame('def', $client->requests[10]['body']);
		$this->assertSame('bytes 6-7/8', $client->requests[11]['headers']['Content-Range']);
		$this->assertSame('gh', $client->requests[11]['body']);
	}

	public function test_reads_lists_checksums_and_deletes_private_objects(): void
	{
		$name_a = $this->configuration()->object_name(provider_interface::SOURCE, 'a.jpg');
		$name_z = $this->configuration()->object_name(provider_interface::SOURCE, 'z.jpg');
		$files = [$this->file('z-id', $name_z, 'zed'), $this->file('a-id', $name_a, 'alpha')];
		$client = new fourshared_fake_http_client();
		$this->queue_prepare($client, $files);
		$this->queue_file_listing($client, $files);
		$this->queue_file_listing($client, $files);
		$client->responses[] = new response(200, [], $this->stream('alpha'));
		$this->queue_file_listing($client, $files);
		$client->responses[] = new response(200, [], $this->stream('alpha'));
		$this->queue_file_listing($client, $files);
		$client->responses[] = new response(204);
		$provider = $this->provider($client);

		$first = $provider->list_objects(provider_interface::SOURCE, null, 1);
		$this->assertSame(['a.jpg'], $first['keys']);
		$this->assertSame('o:1', $first['cursor']);
		$this->assertSame(['z.jpg'], $provider->list_objects(
			provider_interface::SOURCE, $first['cursor'], 1
		)['keys']);
		$stream = $provider->open_stream(provider_interface::SOURCE, 'a.jpg');
		$this->assertIsResource($stream);
		$this->assertSame('alpha', stream_get_contents($stream));
		fclose($stream);
		$this->assertSame(hash('sha256', 'alpha'), $provider->checksum(provider_interface::SOURCE, 'a.jpg'));
		$this->assertTrue($provider->delete(provider_interface::SOURCE, 'a.jpg'));
	}

	public function test_rejects_non_private_or_infected_file_metadata(): void
	{
		$name = $this->configuration()->object_name(provider_interface::SOURCE, 'image.jpg');
		$client = new fourshared_fake_http_client();
		$this->queue_prepare($client, [$this->file('file-id', $name, 'image', [
			'ownerOnly' => false,
			'virusScanResult' => 'infected',
		])]);

		$this->expectException(\RuntimeException::class);
		$this->expectExceptionMessage('invalid or non-private');
		$this->provider($client)->exists(provider_interface::SOURCE, 'image.jpg');
	}

	/** @param list<array<string, mixed>> $files */
	private function queue_prepare(fourshared_fake_http_client $client, array $files = []): void
	{
		$client->responses[] = $this->json_response($this->user());
		$client->responses[] = $this->json_response(['folders' => []]);
		$client->responses[] = $this->json_response(['id' => 'gallery-root']);
		$client->responses[] = $this->json_response($this->folder('gallery-root', 'user-root', 'phpbbgallery'));
		$client->responses[] = $this->json_response(['folders' => []]);
		$client->responses[] = $this->json_response(['id' => 'source-folder']);
		$client->responses[] = $this->json_response($this->folder('source-folder', 'gallery-root', 'source'));
		$this->queue_file_listing($client, $files);
	}

	/** @param list<array<string, mixed>> $files */
	private function queue_file_listing(fourshared_fake_http_client $client, array $files): void
	{
		$client->responses[] = $this->json_response(['files' => $files]);
	}

	/** @return array<string, mixed> */
	private function user(): array
	{
		return [
			'id' => 'user-1',
			'verified' => true,
			'status' => 'active',
			'freeSpace' => 1000000000,
			'uploadSizeLimit' => 1000000000,
			'rootFolderId' => 'user-root',
		];
	}

	/** @param array<string, mixed> $overrides @return array<string, mixed> */
	private function folder(string $id, string $parent, string $name, array $overrides = []): array
	{
		return $overrides + [
			'id' => $id,
			'parentId' => $parent,
			'name' => $name,
			'ownerId' => 'user-1',
			'access' => 'private',
			'userPermissions' => 'owner',
			'hasMembers' => false,
			'status' => 'normal',
		];
	}

	/** @param array<string, mixed> $overrides @return array<string, mixed> */
	private function file(string $id, string $name, string $contents, array $overrides = []): array
	{
		return $overrides + [
			'id' => $id,
			'name' => $name,
			'size' => strlen($contents),
			'modified' => '2026-08-06T12:00:00.000Z',
			'parentId' => 'source-folder',
			'ownerId' => 'user-1',
			'md5' => md5($contents),
			'ownerOnly' => true,
			'status' => 'normal',
			'virusScanResult' => 'clean',
		];
	}

	private function configuration(): configuration
	{
		return new configuration(
			'consumer-key', 'consumer-secret', 'access-token', 'access-secret', 'phpbbgallery'
		);
	}

	private function api(fourshared_fake_http_client $client): api_client
	{
		return new api_client(new oauth_signer(
			$this->configuration(),
			static fn (): string => '0123456789abcdef',
			static fn (): int => 1720000000
		), $client);
	}

	private function provider(
		fourshared_fake_http_client $client,
		int $simple_upload_limit = 157286400,
		int $chunk_size = 8388608
	): provider
	{
		return new provider(
			$this->configuration(), $this->api($client),
			new operation_lock($this->temporary_directory . '/4shared.lock'),
			$simple_upload_limit, $chunk_size
		);
	}

	private function local_file(string $contents): string
	{
		$file = $this->temporary_directory . '/upload-' . bin2hex(random_bytes(4));
		file_put_contents($file, $contents);

		return $file;
	}

	/** @param array<string, mixed> $data */
	private function json_response(array $data, int $status = 200): response
	{
		return new response($status, [], $this->stream((string) json_encode($data, JSON_THROW_ON_ERROR)));
	}

	/** @return resource */
	private function stream(string $contents): mixed
	{
		$stream = fopen('php://temp', 'w+b');
		fwrite($stream, $contents);
		rewind($stream);

		return $stream;
	}
}

// phpcs:disable Generic.Files.OneClassPerFile.MultipleFound -- Isolated 4shared HTTP test double.
final class fourshared_fake_http_client implements client_interface
{
	/** @var list<response|callable(array<string, mixed>): response> */
	public array $responses = [];
	/** @var list<array{method: string, url: string, headers: array<string, string>, body: string}> */
	public array $requests = [];

	public function request(string $method, string $url, array $headers = [], mixed $body = null): response
	{
		$content = '';
		if (is_resource($body))
		{
			$content = (string) stream_get_contents($body);
		}
		$request = compact('method', 'url', 'headers') + ['body' => $content];
		$this->requests[] = $request;
		if ($this->responses === [])
		{
			throw new \RuntimeException('No fake 4shared response was queued.');
		}
		$response = array_shift($this->responses);

		return is_callable($response) ? $response($request) : $response;
	}
}
// phpcs:enable Generic.Files.OneClassPerFile.MultipleFound
