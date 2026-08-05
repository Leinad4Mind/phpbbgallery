<?php
/**
 * phpBB Gallery - Dropbox provider tests
 *
 * @package   phpbbgallery/remotestorage
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\remotestorage\tests;

use phpbbgallery\core\storage\provider_interface;
use phpbbgallery\remotestorage\dropbox\configuration;
use phpbbgallery\remotestorage\dropbox\configured_factory;
use phpbbgallery\remotestorage\dropbox\provider;
use phpbbgallery\remotestorage\dropbox\token_manager;
use phpbbgallery\remotestorage\http\client_interface;
use phpbbgallery\remotestorage\http\response;
use PHPUnit\Framework\TestCase;

final class dropbox_provider_test extends TestCase
{
	private string $temporary_directory;

	// phpcs:ignore PhpbbCodingStandard.NamingConventions.LowercaseUnderscoredFunctions.NotAllowed -- PHPUnit lifecycle API.
	protected function setUp(): void
	{
		$this->temporary_directory = sys_get_temp_dir() . '/phpbbgallery-dropbox-' . bin2hex(random_bytes(6));
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

	public function test_configuration_builds_and_validates_private_paths(): void
	{
		$config = new configuration('app-key', 'app-secret', 'refresh-token', '/boards/main/');

		$this->assertSame('/boards/main/source/7/71/image.jpg',
			$config->object_path(provider_interface::SOURCE, '7/71/image.jpg'));
		$this->assertSame('/boards/main/mini', $config->variant_path(provider_interface::MINI));
		$this->assertSame('7/71/Image.jpg',
			$config->relative_key(provider_interface::SOURCE, '/BOARDS/MAIN/SOURCE/7/71/Image.jpg'));
		$this->assertSame(
			['/boards', '/boards/main', '/boards/main/source', '/boards/main/source/7', '/boards/main/source/7/71'],
			$config->parent_paths(provider_interface::SOURCE, '7/71/image.jpg')
		);

		foreach ([
			'../image.jpg',
			'/image.jpg',
			'bad' . chr(0) . 'name.jpg',
			'folder\\image.jpg',
			'folder//image.jpg',
			'folder/./image.jpg',
		] as $key)
		{
			try
			{
				$config->object_path(provider_interface::SOURCE, $key);
				$this->fail('An unsafe Dropbox key was accepted.');
			}
			catch (\InvalidArgumentException)
			{
				$this->addToAssertionCount(1);
			}
		}
	}

	public function test_oauth_refresh_token_is_cached_and_secrets_are_not_in_the_url(): void
	{
		$client = new dropbox_fake_http_client();
		$client->responses[] = $this->json_response(200, [
			'access_token' => 'short-lived-token',
			'expires_in' => 14400,
		]);
		$manager = new token_manager(
			new configuration('app-key', 'app-secret', 'refresh-token'),
			$client,
			static fn (): int => 1000
		);

		$this->assertSame('short-lived-token', $manager->token());
		$this->assertSame('short-lived-token', $manager->token());
		$this->assertCount(1, $client->requests);
		$this->assertSame('https://api.dropboxapi.com/oauth2/token', $client->requests[0]['url']);
		$this->assertStringNotContainsString('app-secret', $client->requests[0]['url']);
		$this->assertStringNotContainsString('refresh-token', $client->requests[0]['url']);
		$this->assertSame('Basic ' . base64_encode('app-key:app-secret'),
			$client->requests[0]['headers']['Authorization']);
		$this->assertSame('grant_type=refresh_token&refresh_token=refresh-token', $client->requests[0]['body']);
	}

	public function test_simple_storage_workflow_and_paginated_listing(): void
	{
		$file = $this->temporary_directory . '/image.jpg';
		file_put_contents($file, 'dropbox-image');
		$client = new dropbox_fake_http_client();
		$this->token($client);
		$client->responses[] = $this->json_response(200, ['.tag' => 'file']);
		$client->responses[] = $this->json_response(200, [
			'.tag' => 'file',
			'size' => 13,
			'server_modified' => '2026-08-05T12:30:00Z',
		]);
		$client->responses[] = $this->json_response(200, [
			'.tag' => 'file',
			'size' => 13,
			'server_modified' => '2026-08-05T12:30:00Z',
		]);
		$client->responses[] = $this->json_response(200, [
			'.tag' => 'file',
			'size' => 13,
			'server_modified' => '2026-08-05T12:30:00Z',
		]);
		$client->responses[] = $this->body_response(200, 'dropbox-image');
		$client->responses[] = $this->body_response(200, 'dropbox-image');
		$client->responses[] = $this->json_response(200, [
			'entries' => [
				['.tag' => 'folder', 'path_display' => '/phpbbgallery/source/folder'],
				['.tag' => 'file', 'path_display' => '/phpbbgallery/source/Image.jpg'],
			],
			'cursor' => 'next-page',
			'has_more' => true,
		]);
		$client->responses[] = $this->json_response(200, [
			'entries' => [['.tag' => 'file', 'path_display' => '/phpbbgallery/source/folder/two.jpg']],
			'cursor' => 'complete',
			'has_more' => false,
		]);
		$client->responses[] = $this->json_response(200, ['metadata' => ['.tag' => 'file']]);
		$provider = $this->provider($client);

		$this->assertTrue($provider->write(provider_interface::SOURCE, 'image.jpg', $file));
		$upload = $client->requests[1];
		$this->assertStringEndsWith('/files/upload', $upload['url']);
		$this->assertSame('dropbox-image', $upload['body']);
		$this->assertSame('Bearer short-lived-token', $upload['headers']['Authorization']);
		$this->assertSame('add', json_decode($upload['headers']['Dropbox-API-Arg'], true)['mode']);

		$this->assertTrue($provider->exists(provider_interface::SOURCE, 'image.jpg'));
		$this->assertSame(13, $provider->size(provider_interface::SOURCE, 'image.jpg'));
		$this->assertSame(strtotime('2026-08-05T12:30:00Z'),
			$provider->modified_time(provider_interface::SOURCE, 'image.jpg'));
		$stream = $provider->open_stream(provider_interface::SOURCE, 'image.jpg');
		$this->assertIsResource($stream);
		$this->assertSame('dropbox-image', stream_get_contents($stream));
		fclose($stream);
		$this->assertSame(hash('sha256', 'dropbox-image'),
			$provider->checksum(provider_interface::SOURCE, 'image.jpg'));

		$page = $provider->list_objects(provider_interface::SOURCE, null, 2);
		$this->assertSame(['Image.jpg'], $page['keys']);
		$this->assertSame('next-page', $page['cursor']);
		$page = $provider->list_objects(provider_interface::SOURCE, $page['cursor'], 2);
		$this->assertSame(['folder/two.jpg'], $page['keys']);
		$this->assertNull($page['cursor']);
		$this->assertTrue($provider->delete(provider_interface::SOURCE, 'image.jpg'));
	}

	public function test_prepare_accepts_existing_folders_but_rejects_a_file(): void
	{
		$client = new dropbox_fake_http_client();
		$this->token($client);
		$client->responses[] = $this->error_response('path/conflict/folder/');
		$client->responses[] = $this->json_response(200, ['.tag' => 'folder']);
		$client->responses[] = $this->json_response(200, ['metadata' => ['.tag' => 'folder']]);
		$client->responses[] = $this->error_response('path/conflict/file/');
		$client->responses[] = $this->json_response(200, ['.tag' => 'file']);
		$provider = $this->provider($client);

		$this->expectException(\RuntimeException::class);
		$this->expectExceptionMessage('occupied by a file');
		$provider->prepare(provider_interface::SOURCE, 'blocked/image.jpg');
	}

	public function test_create_conflict_and_missing_object_are_safe_results(): void
	{
		$file = $this->temporary_directory . '/image.jpg';
		file_put_contents($file, 'dropbox-image');
		$client = new dropbox_fake_http_client();
		$this->token($client);
		$client->responses[] = $this->error_response('path/conflict/file/');
		$client->responses[] = $this->error_response('path/not_found/');
		$client->responses[] = $this->error_response('path_lookup/not_found/');
		$provider = $this->provider($client);

		$this->assertFalse($provider->write(provider_interface::SOURCE, 'image.jpg', $file));
		$this->assertFalse($provider->exists(provider_interface::SOURCE, 'missing.jpg'));
		$this->assertFalse($provider->open_stream(provider_interface::SOURCE, 'missing.jpg'));
		$this->assertFalse($provider->write(provider_interface::SOURCE, 'missing.jpg', $file . '.missing'));
	}

	public function test_replace_requires_an_existing_object_and_uses_overwrite_mode(): void
	{
		$file = $this->temporary_directory . '/image.jpg';
		file_put_contents($file, 'replacement');
		$client = new dropbox_fake_http_client();
		$this->token($client);
		$client->responses[] = $this->json_response(200, ['.tag' => 'file', 'size' => 3]);
		$client->responses[] = $this->json_response(200, ['.tag' => 'file', 'size' => 11]);
		$provider = $this->provider($client);

		$this->assertTrue($provider->replace(provider_interface::SOURCE, 'image.jpg', $file));
		$arguments = json_decode($client->requests[2]['headers']['Dropbox-API-Arg'], true);
		$this->assertSame('overwrite', $arguments['mode']);
		$this->assertFalse($arguments['autorename']);

		$missing = new dropbox_fake_http_client();
		$this->token($missing);
		$missing->responses[] = $this->error_response('path/not_found/');
		$this->assertFalse($this->provider($missing)->replace(provider_interface::SOURCE, 'missing.jpg', $file));
		$this->assertCount(2, $missing->requests);
	}

	public function test_large_upload_uses_a_sequential_session(): void
	{
		$file = $this->temporary_directory . '/large.bin';
		file_put_contents($file, '1234567');
		$client = new dropbox_fake_http_client();
		$this->token($client);
		$client->responses[] = $this->json_response(200, ['session_id' => 'session-1']);
		$client->responses[] = $this->json_response(200, []);
		$client->responses[] = $this->json_response(200, []);
		$client->responses[] = $this->json_response(200, ['.tag' => 'file']);
		$provider = $this->provider($client, 4, 3);

		$this->assertTrue($provider->write(provider_interface::SOURCE, 'large.bin', $file));
		$this->assertStringEndsWith('/upload_session/start', $client->requests[1]['url']);
		$this->assertSame('', $client->requests[1]['body']);
		$this->assertStringEndsWith('/upload_session/append_v2', $client->requests[2]['url']);
		$this->assertSame('123', $client->requests[2]['body']);
		$this->assertSame('456', $client->requests[3]['body']);
		$this->assertStringEndsWith('/upload_session/finish', $client->requests[4]['url']);
		$this->assertSame('7', $client->requests[4]['body']);
		$finish = json_decode($client->requests[4]['headers']['Dropbox-API-Arg'], true);
		$this->assertSame(6, $finish['cursor']['offset']);
		$this->assertSame('add', $finish['commit']['mode']);
	}

	public function test_a_401_refreshes_the_token_once(): void
	{
		$client = new dropbox_fake_http_client();
		$this->token($client, 'expired-token');
		$client->responses[] = $this->json_response(401, ['error_summary' => 'expired_access_token/']);
		$this->token($client, 'renewed-token');
		$client->responses[] = $this->error_response('path/not_found/');
		$provider = $this->provider($client);

		$this->assertFalse($provider->exists(provider_interface::SOURCE, 'missing.jpg'));
		$this->assertSame('Bearer expired-token', $client->requests[1]['headers']['Authorization']);
		$this->assertSame('Bearer renewed-token', $client->requests[3]['headers']['Authorization']);
	}

	public function test_configured_factory_uses_environment_without_persisting_secrets(): void
	{
		$config = new \ArrayObject([
			'phpbb_gallery_dropbox_app_key' => '',
			'phpbb_gallery_dropbox_app_secret' => '',
			'phpbb_gallery_dropbox_refresh_token' => '',
			'phpbb_gallery_dropbox_root' => '/phpbbgallery',
		]);
		$client = new dropbox_fake_http_client();
		$this->token($client);
		$client->responses[] = $this->error_response('path/not_found/');
		$request = $this->createMock(\phpbb\request\request_interface::class);
		$factory = new configured_factory($client, $config, $request, [
			'PHPBBGALLERY_DROPBOX_APP_KEY' => 'environment-key',
			'PHPBBGALLERY_DROPBOX_APP_SECRET' => 'environment-secret',
			'PHPBBGALLERY_DROPBOX_REFRESH_TOKEN' => 'environment-refresh',
		]);
		$provider = $factory->create_from(['root' => '/submitted']);

		$this->assertSame('dropbox', $factory->get_id());
		$this->assertSame(['app_key', 'app_secret', 'refresh_token'], $factory->environment_overrides());
		$this->assertFalse($factory->field_definitions()['app_key']['secret']);
		$this->assertTrue($factory->field_definitions()['app_secret']['secret']);
		$this->assertTrue($factory->field_definitions()['refresh_token']['secret']);
		$this->assertFalse($provider->exists(provider_interface::SOURCE, 'image.jpg'));
		$this->assertSame('', $config['phpbb_gallery_dropbox_app_secret']);
		$this->assertSame('/submitted/source/image.jpg',
			json_decode($client->requests[1]['body'], true)['path']);
	}

	private function provider(
		dropbox_fake_http_client $client,
		int $simple_upload_limit = 157286400,
		int $chunk_size = 8388608
	): provider
	{
		$configuration = new configuration('app-key', 'app-secret', 'refresh-token');

		return new provider(
			$configuration,
			new token_manager($configuration, $client, static fn (): int => 1000),
			$client,
			$simple_upload_limit,
			$chunk_size
		);
	}

	private function token(dropbox_fake_http_client $client, string $token = 'short-lived-token'): void
	{
		$client->responses[] = $this->json_response(200, [
			'access_token' => $token,
			'expires_in' => 14400,
		]);
	}

	/** @param array<string, mixed> $data */
	private function json_response(int $status, array $data): response
	{
		return $this->body_response($status, json_encode($data, JSON_THROW_ON_ERROR));
	}

	private function error_response(string $summary): response
	{
		return $this->json_response(409, ['error_summary' => $summary]);
	}

	private function body_response(int $status, string $body): response
	{
		$stream = fopen('php://temp', 'w+b');
		fwrite($stream, $body);
		rewind($stream);

		return new response($status, [], $stream);
	}
}

// phpcs:disable Generic.Files.OneClassPerFile.MultipleFound -- Isolated Dropbox HTTP test double.
final class dropbox_fake_http_client implements client_interface
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
			throw new \RuntimeException('No fake Dropbox HTTP response is available.');
		}

		return array_shift($this->responses);
	}
}
