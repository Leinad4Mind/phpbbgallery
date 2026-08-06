<?php
/**
 * phpBB Gallery - Koofr provider tests
 *
 * @package   phpbbgallery/remotestorage
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\remotestorage\tests;

use PHPUnit\Framework\TestCase;
use phpbb\request\request_interface;
use phpbbgallery\core\storage\provider_interface;
use phpbbgallery\remotestorage\http\client_interface;
use phpbbgallery\remotestorage\http\response;
use phpbbgallery\remotestorage\providers\koofr\configuration;
use phpbbgallery\remotestorage\providers\koofr\configured_factory as koofr_configured_factory;
use phpbbgallery\remotestorage\providers\koofr\provider;

final class koofr_provider_test extends TestCase
{
	private string $temporary_directory;

	// phpcs:ignore PhpbbCodingStandard.NamingConventions.LowercaseUnderscoredFunctions.NotAllowed -- PHPUnit lifecycle API.
	protected function setUp(): void
	{
		$this->temporary_directory = sys_get_temp_dir() . '/phpbbgallery-koofr-' . bin2hex(random_bytes(6));
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

	public function test_configuration_fixes_tls_host_and_round_trips_safe_names(): void
	{
		$configuration = $this->configuration();
		foreach (['image.jpg', 'nested/name.webp', 'Upper Case.png'] as $key)
		{
			$name = $configuration->object_name(provider_interface::SOURCE, $key);
			$this->assertMatchesRegularExpression('/^g_[a-f0-9]+$/D', $name);
			$this->assertSame($key, $configuration->relative_key(provider_interface::SOURCE, $name));
		}
		$this->assertSame('https://app.koofr.net/dav/Koofr/phpbbgallery', $configuration->root_url());
		$this->assertSame('Basic ' . base64_encode('gallery@example.com:application-password'),
			$configuration->authorization());

		$this->expectException(\InvalidArgumentException::class);
		new configuration('gallery@example.com', 'application-password', '../shared');
	}

	public function test_configured_factory_keeps_application_password_secret_and_supports_environment(): void
	{
		$config = new \ArrayObject([
			'phpbb_gallery_koofr_email' => 'configured@example.com',
			'phpbb_gallery_koofr_app_password' => 'configured-password',
			'phpbb_gallery_koofr_root_name' => 'configured-root',
		]);
		$request = $this->createMock(request_interface::class);
		$factory = new koofr_configured_factory(new koofr_fake_http_client(), $config, $request, [
			'PHPBBGALLERY_KOOFR_EMAIL' => 'environment@example.com',
			'PHPBBGALLERY_KOOFR_APP_PASSWORD' => 'environment-password',
		]);

		$this->assertTrue($factory->field_definitions()['app_password']['secret']);
		$this->assertSame(['email', 'app_password'], $factory->environment_overrides());
		$this->assertSame('koofr', $factory->create_from([
			'root_name' => 'submitted-root',
		])->get_id());
	}

	public function test_prepare_creates_and_verifies_dedicated_webdav_folders(): void
	{
		$client = new koofr_fake_http_client();
		$this->prepare_responses($client);

		$this->assertTrue($this->provider($client)->prepare(provider_interface::SOURCE, 'image.jpg'));
		$this->assertSame(['MKCOL', 'PROPFIND', 'MKCOL', 'PROPFIND'],
			array_column($client->requests, 'method'));
		$this->assertSame('0', $client->requests[1]['headers']['Depth']);
		$this->assertSame('Basic ' . base64_encode('gallery@example.com:application-password'),
			$client->requests[0]['headers']['Authorization']);
		$this->assertStringNotContainsString('application-password', $client->requests[0]['url']);
		$this->assertStringContainsString('xmlns:d=' . chr(39) . 'DAV:' . chr(39),
			$client->requests[1]['body']);
	}

	public function test_write_streams_with_create_precondition_and_verifies_size(): void
	{
		$file = $this->temporary_directory . '/upload.bin';
		file_put_contents($file, 'koofr-image');
		$client = new koofr_fake_http_client();
		$this->prepare_responses($client);
		$client->responses[] = new response(201);
		$client->responses[] = $this->file_response('image.jpg', strlen('koofr-image'));

		$this->assertTrue($this->provider($client)->write(provider_interface::SOURCE, 'image.jpg', $file));
		$upload = $client->requests[4];
		$this->assertSame('PUT', $upload['method']);
		$this->assertSame('*', $upload['headers']['If-None-Match']);
		$this->assertArrayNotHasKey('If-Match', $upload['headers']);
		$this->assertSame('koofr-image', $upload['body']);
		$this->assertSame((string) strlen('koofr-image'), $upload['headers']['Content-Length']);
	}

	public function test_write_rejects_existing_object_and_replace_requires_existing_object(): void
	{
		$file = $this->temporary_directory . '/upload.bin';
		file_put_contents($file, 'replacement');
		$create_client = new koofr_fake_http_client();
		$this->prepare_responses($create_client);
		$create_client->responses[] = new response(412);
		$this->assertFalse($this->provider($create_client)->write(provider_interface::SOURCE, 'image.jpg', $file));

		$replace_client = new koofr_fake_http_client();
		$this->prepare_responses($replace_client);
		$replace_client->responses[] = new response(204);
		$replace_client->responses[] = $this->file_response('image.jpg', strlen('replacement'));
		$this->assertTrue($this->provider($replace_client)->replace(
			provider_interface::SOURCE, 'image.jpg', $file));
		$this->assertSame('*', $replace_client->requests[4]['headers']['If-Match']);
		$this->assertArrayNotHasKey('If-None-Match', $replace_client->requests[4]['headers']);
	}

	public function test_reads_metadata_content_checksum_and_conditional_delete(): void
	{
		$client = new koofr_fake_http_client();
		$client->responses[] = $this->file_response('image.jpg', 5);
		$client->responses[] = $this->file_response('image.jpg', 5);
		$client->responses[] = $this->content_response('image');
		$client->responses[] = $this->content_response('image');
		$client->responses[] = new response(204);
		$provider = $this->provider($client);

		$this->assertTrue($provider->exists(provider_interface::SOURCE, 'image.jpg'));
		$this->assertSame(5, $provider->size(provider_interface::SOURCE, 'image.jpg'));
		$stream = $provider->open_stream(provider_interface::SOURCE, 'image.jpg');
		$this->assertIsResource($stream);
		$this->assertSame('image', stream_get_contents($stream));
		fclose($stream);
		$this->assertSame(hash('sha256', 'image'), $provider->checksum(provider_interface::SOURCE, 'image.jpg'));
		$this->assertTrue($provider->delete(provider_interface::SOURCE, 'image.jpg'));
		$this->assertSame('*', $client->requests[4]['headers']['If-Match']);
	}

	public function test_list_is_bounded_sorted_and_uses_local_continuation_cursor(): void
	{
		$client = new koofr_fake_http_client();
		$this->prepare_responses($client);
		$client->responses[] = $this->listing_response(['z.jpg', 'a.jpg']);
		$client->responses[] = $this->listing_response(['z.jpg', 'a.jpg']);
		$provider = $this->provider($client);

		$first = $provider->list_objects(provider_interface::SOURCE, null, 1);
		$this->assertSame(['a.jpg'], $first['keys']);
		$this->assertSame('o:1', $first['cursor']);
		$second = $provider->list_objects(provider_interface::SOURCE, $first['cursor'], 1);
		$this->assertSame(['z.jpg'], $second['keys']);
		$this->assertNull($second['cursor']);
		$this->assertSame('1', $client->requests[4]['headers']['Depth']);
	}

	public function test_rejects_external_or_nested_webdav_metadata(): void
	{
		$client = new koofr_fake_http_client();
		$this->prepare_responses($client);
		$client->responses[] = $this->multistatus([[
			'href' => 'https://attacker.example/dav/object',
			'collection' => false,
			'size' => 4,
		]]);

		$this->expectException(\RuntimeException::class);
		$this->expectExceptionMessage('external WebDAV href');
		$this->provider($client)->list_objects(provider_interface::SOURCE);
	}

	public function test_rejects_webdav_doctype_before_xml_parsing(): void
	{
		$client = new koofr_fake_http_client();
		$this->prepare_responses($client);
		$quote = chr(39);
		$xml = '<?xml version=' . $quote . '1.0' . $quote . '?>'
			. '<!DOCTYPE d:multistatus [<!ENTITY secret SYSTEM '
			. $quote . 'file:///forbidden' . $quote . '>]>'
			. '<d:multistatus xmlns:d=' . $quote . 'DAV:' . $quote . '></d:multistatus>';
		$client->responses[] = new response(207, [], $this->stream($xml));

		$this->expectException(\RuntimeException::class);
		$this->expectExceptionMessage('forbidden WebDAV XML declarations');
		$this->provider($client)->list_objects(provider_interface::SOURCE);
	}

	public function test_missing_and_precondition_failures_do_not_become_success(): void
	{
		$client = new koofr_fake_http_client();
		$client->responses[] = new response(404);
		$client->responses[] = new response(404);
		$client->responses[] = new response(412);
		$provider = $this->provider($client);

		$this->assertFalse($provider->exists(provider_interface::SOURCE, 'missing.jpg'));
		$this->assertNull($provider->open_stream(provider_interface::SOURCE, 'missing.jpg'));
		$this->assertFalse($provider->delete(provider_interface::SOURCE, 'missing.jpg'));
	}

	private function configuration(): configuration
	{
		return new configuration('gallery@example.com', 'application-password', 'phpbbgallery');
	}

	private function provider(koofr_fake_http_client $client): provider
	{
		return new provider($this->configuration(), $client);
	}

	private function prepare_responses(koofr_fake_http_client $client): void
	{
		$client->responses[] = new response(201);
		$client->responses[] = $this->folder_response('/dav/Koofr/phpbbgallery');
		$client->responses[] = new response(201);
		$client->responses[] = $this->folder_response('/dav/Koofr/phpbbgallery/source');
	}

	private function folder_response(string $href): response
	{
		return $this->multistatus([['href' => $href, 'collection' => true, 'size' => 0]]);
	}

	private function file_response(string $key, int $size): response
	{
		$name = $this->configuration()->object_name(provider_interface::SOURCE, $key);

		return $this->multistatus([[
			'href' => '/dav/Koofr/phpbbgallery/source/' . $name,
			'collection' => false,
			'size' => $size,
		]]);
	}

	/** @param list<string> $keys */
	private function listing_response(array $keys): response
	{
		$entries = [['href' => '/dav/Koofr/phpbbgallery/source', 'collection' => true, 'size' => 0]];
		foreach ($keys as $key)
		{
			$entries[] = [
				'href' => '/dav/Koofr/phpbbgallery/source/'
					. $this->configuration()->object_name(provider_interface::SOURCE, $key),
				'collection' => false,
				'size' => strlen($key),
			];
		}

		return $this->multistatus($entries);
	}

	/** @param list<array{href: string, collection: bool, size: int}> $entries */
	private function multistatus(array $entries): response
	{
		$quote = chr(39);
		$xml = '<?xml version=' . $quote . '1.0' . $quote . ' encoding=' . $quote . 'utf-8' . $quote . '?>'
			. '<d:multistatus xmlns:d=' . $quote . 'DAV:' . $quote . '>';
		foreach ($entries as $entry)
		{
			$xml .= '<d:response><d:href>'
				. htmlspecialchars($entry['href'], ENT_QUOTES | ENT_XML1, 'UTF-8')
				. '</d:href><d:propstat><d:prop><d:resourcetype>'
				. ($entry['collection'] ? '<d:collection/>' : '')
				. '</d:resourcetype>';
			if (!$entry['collection'])
			{
				$xml .= '<d:getcontentlength>' . $entry['size'] . '</d:getcontentlength>'
					. '<d:getlastmodified>Wed, 06 Aug 2026 12:00:00 GMT</d:getlastmodified>'
					. '<d:getetag>' . $quote . 'etag' . $quote . '</d:getetag>';
			}
			$xml .= '</d:prop><d:status>HTTP/1.1 200 OK</d:status></d:propstat></d:response>';
		}
		$xml .= '</d:multistatus>';

		return new response(207, [], $this->stream($xml));
	}

	private function content_response(string $content): response
	{
		return new response(200, [], $this->stream($content));
	}

	/** @return resource */
	private function stream(string $content): mixed
	{
		$stream = fopen('php://temp', 'w+b');
		fwrite($stream, $content);
		rewind($stream);

		return $stream;
	}
}

// phpcs:disable Generic.Files.OneClassPerFile.MultipleFound -- Isolated Koofr HTTP test double.
final class koofr_fake_http_client implements client_interface
{
	/** @var list<response> */
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
		$this->requests[] = compact('method', 'url', 'headers') + ['body' => $content];
		if ($this->responses === [])
		{
			throw new \RuntimeException('No fake Koofr response was queued.');
		}

		return array_shift($this->responses);
	}
}
// phpcs:enable Generic.Files.OneClassPerFile.MultipleFound
