<?php
/**
 * phpBB Gallery - Remote Storage Add-on
 *
 * @package   phpbbgallery/remotestorage
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\remotestorage\box;

use phpbbgallery\core\storage\provider_interface;
use phpbbgallery\remotestorage\http\client_interface;
use phpbbgallery\remotestorage\http\response;

/** Private Box storage using dedicated folders and rotating OAuth tokens. */
final class provider implements provider_interface
{
	private const API = 'https://api.box.com/2.0';
	private const UPLOAD_API = 'https://upload.box.com/api/2.0';
	private const MAX_JSON_RESPONSE = 1048576;
	private const DEFAULT_SIMPLE_UPLOAD_LIMIT = 52428800;
	/** @var array<string, string> */
	private array $variant_ids = [];
	private ?string $root_id = null;
	private \Closure $sleeper;

	public function __construct(
		private configuration $configuration,
		private token_manager $tokens,
		private client_interface $client,
		private int $simple_upload_limit = self::DEFAULT_SIMPLE_UPLOAD_LIMIT,
		?\Closure $sleeper = null
	)
	{
		if ($simple_upload_limit < 1 || $simple_upload_limit > self::DEFAULT_SIMPLE_UPLOAD_LIMIT)
		{
			throw new \InvalidArgumentException('The Box simple upload limit is invalid.');
		}
		$this->sleeper = $sleeper ?? static function (int $seconds): void
		{
			sleep($seconds);
		};
	}

	public function get_id(): string
	{
		return 'box';
	}

	public function prepare(string $variant, string $key): bool
	{
		$this->configuration->object_name($variant, $key);
		$this->variant_folder_id($variant);

		return true;
	}

	public function write(string $variant, string $key, string $local_file): bool
	{
		return $this->upload($variant, $key, $local_file, true);
	}

	public function replace(string $variant, string $key, string $local_file): bool
	{
		return $this->upload($variant, $key, $local_file, false);
	}

	public function open_stream(string $variant, string $key): mixed
	{
		$file = $this->find_object($variant, $key);
		if ($file === null)
		{
			return null;
		}
		$url = self::API . '/files/' . rawurlencode((string) $file['id']) . '/content';
		$response = null;
		for ($attempt = 0; $attempt < 5; $attempt++)
		{
			$response = $this->authorized_request('GET', $url, [], static fn (): mixed => null);
			if ($response->status() !== 202)
			{
				break;
			}
			$retry = (string) ($response->header('retry-after') ?? '');
			if (preg_match('/^[1-9]$|^10$/D', $retry) !== 1)
			{
				throw new \RuntimeException('Box returned an invalid download retry delay.');
			}
			($this->sleeper)((int) $retry);
		}
		if (!$response instanceof response)
		{
			throw new \RuntimeException('Box returned no download response.');
		}
		if ($response->status() === 200)
		{
			return $this->body($response, 'Box returned no file content.');
		}
		if ($response->status() !== 302)
		{
			$this->unexpected_status($response->status());
		}
		$url = $this->download_url((string) ($response->header('location') ?? ''));
		$download = $this->client->request('GET', $url);
		if ($download->status() !== 200)
		{
			$this->unexpected_status($download->status());
		}

		return $this->body($download, 'Box returned no redirected file content.');
	}

	public function local_path(string $variant, string $key): ?string
	{
		return null;
	}

	public function exists(string $variant, string $key): bool
	{
		return $this->find_object($variant, $key) !== null;
	}

	public function delete(string $variant, string $key): bool
	{
		$file = $this->find_object($variant, $key);
		if ($file === null)
		{
			return false;
		}
		$response = $this->authorized_request(
			'DELETE',
			self::API . '/files/' . rawurlencode((string) $file['id']),
			[],
			static fn (): mixed => null
		);
		if (!in_array($response->status(), [204, 404], true))
		{
			$this->unexpected_status($response->status());
		}

		return true;
	}

	public function size(string $variant, string $key): ?int
	{
		$size = $this->find_object($variant, $key)['size'] ?? null;

		return is_int($size) && $size >= 0 ? $size : null;
	}

	public function modified_time(string $variant, string $key): ?int
	{
		$value = $this->find_object($variant, $key)['modified_at'] ?? null;
		$timestamp = is_string($value) ? strtotime($value) : false;

		return $timestamp === false ? null : $timestamp;
	}

	public function checksum(string $variant, string $key, string $algorithm = 'sha256'): ?string
	{
		if ($algorithm !== 'sha256')
		{
			return null;
		}
		$stream = $this->open_stream($variant, $key);
		if (!is_resource($stream))
		{
			return null;
		}
		try
		{
			$context = hash_init('sha256');
			if (hash_update_stream($context, $stream) === false)
			{
				return null;
			}

			return hash_final($context);
		}
		finally
		{
			fclose($stream);
		}
	}

	public function list_objects(string $variant, ?string $cursor = null, int $limit = 500): array
	{
		$this->assert_cursor($cursor);
		$page = $this->folder_page($this->variant_folder_id($variant), $cursor, max(1, min(1000, $limit)));
		$keys = [];
		foreach ($page['entries'] as $entry)
		{
			if (!is_array($entry) || ($entry['type'] ?? '') !== 'file')
			{
				throw new \RuntimeException('Box returned an unexpected item in the Gallery folder.');
			}
			$key = $this->configuration->relative_key($variant, (string) ($entry['name'] ?? ''));
			if ($key === null)
			{
				throw new \RuntimeException('Box returned an invalid Gallery object key.');
			}
			$keys[] = $key;
		}

		return ['keys' => $keys, 'cursor' => $page['next_marker']];
	}

	private function upload(string $variant, string $key, string $local_file, bool $create_only): bool
	{
		if (!is_file($local_file) || is_link($local_file) || !is_readable($local_file))
		{
			return false;
		}
		$size = filesize($local_file);
		if (!is_int($size) || $size < 0)
		{
			return false;
		}
		$name = $this->configuration->object_name($variant, $key);
		$existing = $this->find_object($variant, $key);
		if (($create_only && $existing !== null) || (!$create_only && $existing === null))
		{
			return false;
		}
		$folder_id = $this->variant_folder_id($variant);
		if ($size <= $this->simple_upload_limit)
		{
			return $this->simple_upload($name, $folder_id, $existing, $local_file, $create_only);
		}

		return $this->chunked_upload($name, $folder_id, $existing, $local_file, $size, $create_only);
	}

	/** @param array<string, mixed>|null $existing */
	private function simple_upload(
		string $name,
		string $folder_id,
		?array $existing,
		string $local_file,
		bool $create_only
	): bool
	{
		$attributes = ['name' => $name];
		if ($create_only)
		{
			$attributes['parent'] = ['id' => $folder_id];
		}
		$boundary = 'phpbbgallery_' . bin2hex(random_bytes(16));
		$url = self::UPLOAD_API . '/files/'
			. ($create_only ? 'content' : rawurlencode((string) $existing['id']) . '/content');
		$digest = hash_file('sha1', $local_file, true);
		if (!is_string($digest))
		{
			return false;
		}
		$response = $this->authorized_request('POST', $url, [
			'Content-MD5' => base64_encode($digest),
			'Content-Type' => 'multipart/form-data; boundary=' . $boundary,
		], fn (): mixed => $this->multipart_stream($boundary, $attributes, $name, $local_file));
		if ($response->status() === 409)
		{
			return false;
		}
		if ($response->status() !== 201)
		{
			$this->unexpected_status($response->status());
		}

		return true;
	}

	/** @param array<string, mixed>|null $existing */
	private function chunked_upload(
		string $name,
		string $folder_id,
		?array $existing,
		string $local_file,
		int $size,
		bool $create_only
	): bool
	{
		$session_url = self::UPLOAD_API . '/files/'
			. ($create_only ? 'upload_sessions' : rawurlencode((string) $existing['id']) . '/upload_sessions');
		$session_data = ['file_size' => $size];
		if ($create_only)
		{
			$session_data += ['file_name' => $name, 'folder_id' => $folder_id];
		}
		$response = $this->authorized_json_request('POST', $session_url, $session_data);
		if ($response->status() === 409)
		{
			return false;
		}
		if ($response->status() !== 201)
		{
			$this->unexpected_status($response->status());
		}
		$session = $this->response_json($response);
		$part_size = (int) ($session['part_size'] ?? 0);
		$total_parts = (int) ($session['total_parts'] ?? 0);
		if ($part_size < 1 || $part_size > self::DEFAULT_SIMPLE_UPLOAD_LIMIT
			|| $total_parts !== (int) ceil($size / $part_size) || $total_parts > 10000)
		{
			throw new \RuntimeException('Box returned an invalid upload session.');
		}
		$endpoints = $session['session_endpoints'] ?? null;
		if (!is_array($endpoints))
		{
			throw new \RuntimeException('Box returned invalid upload session endpoints.');
		}
		$upload_url = $this->upload_session_url((string) ($endpoints['upload_part'] ?? ''));
		$commit_url = $this->upload_session_url((string) ($endpoints['commit'] ?? ''));
		$abort_url = $this->upload_session_url((string) ($endpoints['abort'] ?? ''));
		$source = fopen($local_file, 'rb');
		if ($source === false)
		{
			return false;
		}
		try
		{
			$parts = $this->upload_parts($upload_url, $source, $size, $part_size);
			$this->commit_session($commit_url, $parts, $local_file);
		}
		catch (\Throwable $exception)
		{
			$this->abort_session($abort_url);
			throw $exception;
		}
		finally
		{
			fclose($source);
		}

		return true;
	}

	/** @param resource $source @return list<array{part_id: string, offset: int, size: int, sha1: string}> */
	private function upload_parts(string $url, mixed $source, int $size, int $part_size): array
	{
		$parts = [];
		for ($offset = 0; $offset < $size; $offset += $part_size)
		{
			$length = min($part_size, $size - $offset);
			$chunk = $this->read_chunk($source, $length);
			$context = hash_init('sha1');
			hash_update_stream($context, $chunk);
			$sha1 = hash_final($context);
			rewind($chunk);
			try
			{
				$response = $this->authorized_request('PUT', $url, [
					'Content-Range' => 'bytes ' . $offset . '-' . ($offset + $length - 1) . '/' . $size,
					'Content-Type' => 'application/octet-stream',
					'Digest' => 'sha=' . base64_encode((string) hex2bin($sha1)),
				], static function () use ($chunk): mixed
				{
					rewind($chunk);

					return $chunk;
				}, false);
			}
			finally
			{
				fclose($chunk);
			}
			if ($response->status() !== 200)
			{
				$this->unexpected_status($response->status());
			}
			$data = $this->response_json($response)['part'] ?? null;
			if (!is_array($data) || (int) ($data['offset'] ?? -1) !== $offset
				|| (int) ($data['size'] ?? -1) !== $length
				|| strtolower((string) ($data['sha1'] ?? '')) !== $sha1
				|| preg_match('/^[A-Za-z0-9_-]{1,255}$/D', (string) ($data['part_id'] ?? '')) !== 1)
			{
				throw new \RuntimeException('Box returned invalid uploaded part metadata.');
			}
			$parts[] = [
				'part_id' => (string) $data['part_id'],
				'offset' => $offset,
				'size' => $length,
				'sha1' => $sha1,
			];
		}

		return $parts;
	}

	/** @param list<array{part_id: string, offset: int, size: int, sha1: string}> $parts */
	private function commit_session(string $url, array $parts, string $local_file): void
	{
		$digest = hash_file('sha1', $local_file, true);
		if (!is_string($digest))
		{
			throw new \RuntimeException('Could not hash the Box upload source.');
		}
		for ($attempt = 0; $attempt < 5; $attempt++)
		{
			$response = $this->authorized_json_request('POST', $url, ['parts' => $parts], [
				'Digest' => 'sha=' . base64_encode($digest),
			]);
			if ($response->status() === 201)
			{
				return;
			}
			if ($response->status() !== 202)
			{
				$this->unexpected_status($response->status());
			}
			$retry = (string) ($response->header('retry-after') ?? '');
			if (preg_match('/^[1-9]$|^10$/D', $retry) !== 1)
			{
				throw new \RuntimeException('Box returned an invalid upload commit delay.');
			}
			($this->sleeper)((int) $retry);
		}
		throw new \RuntimeException('Box did not commit the upload session in time.');
	}

	private function abort_session(string $url): void
	{
		try
		{
			$this->authorized_request('DELETE', $url, [], static fn (): mixed => null);
		}
		catch (\Throwable)
		{
		}
	}

	/** @return array<string, mixed>|null */
	private function find_object(string $variant, string $key): ?array
	{
		return $this->find_child(
			$this->variant_folder_id($variant),
			$this->configuration->object_name($variant, $key),
			'file'
		);
	}

	private function variant_folder_id(string $variant): string
	{
		$name = $this->configuration->variant_name($variant);
		if (isset($this->variant_ids[$name]))
		{
			return $this->variant_ids[$name];
		}
		$root_id = $this->root_folder_id();
		$folder = $this->find_child($root_id, $name, 'folder');
		$this->variant_ids[$name] = $folder === null
			? $this->create_folder($name, $root_id)
			: $this->configuration->assert_item_id((string) $folder['id']);

		return $this->variant_ids[$name];
	}

	private function root_folder_id(): string
	{
		if ($this->root_id !== null)
		{
			return $this->root_id;
		}
		$folder = $this->find_child('0', $this->configuration->root_name(), 'folder');
		$this->root_id = $folder === null
			? $this->create_folder($this->configuration->root_name(), '0')
			: $this->configuration->assert_item_id((string) $folder['id']);

		return $this->root_id;
	}

	/** @return array<string, mixed>|null */
	private function find_child(string $folder_id, string $name, string $type): ?array
	{
		$marker = null;
		do
		{
			$page = $this->folder_page($folder_id, $marker, 1000);
			$found = null;
			foreach ($page['entries'] as $entry)
			{
				if (is_array($entry) && ($entry['type'] ?? '') === $type
					&& strcasecmp((string) ($entry['name'] ?? ''), $name) === 0)
				{
					if ($found !== null)
					{
						throw new \RuntimeException('Box returned an ambiguous Gallery item.');
					}
					$entry['id'] = $this->configuration->assert_item_id((string) ($entry['id'] ?? ''));
					$found = $entry;
				}
			}
			if ($found !== null)
			{
				return $found;
			}
			$marker = $page['next_marker'];
		}
		while ($marker !== null);

		return null;
	}

	private function create_folder(string $name, string $parent_id): string
	{
		$response = $this->authorized_json_request('POST', self::API . '/folders', [
			'name' => $name,
			'parent' => ['id' => $parent_id],
		]);
		if ($response->status() === 409)
		{
			$existing = $this->find_child($parent_id, $name, 'folder');
			if ($existing !== null)
			{
				return (string) $existing['id'];
			}
		}
		if ($response->status() !== 201)
		{
			$this->unexpected_status($response->status());
		}
		$data = $this->response_json($response);

		return $this->configuration->assert_item_id((string) ($data['id'] ?? ''));
	}

	/** @return array{entries: list<mixed>, next_marker: string|null} */
	private function folder_page(string $folder_id, ?string $marker, int $limit): array
	{
		$this->assert_cursor($marker);
		$query = [
			'usemarker' => 'true',
			'limit' => max(1, min(1000, $limit)),
			'fields' => 'id,type,name,size,modified_at,sha1',
		];
		if ($marker !== null)
		{
			$query['marker'] = $marker;
		}
		$data = $this->api_json('GET', self::API . '/folders/'
			. rawurlencode($this->configuration->assert_item_id($folder_id)) . '/items?'
			. http_build_query($query, '', '&', PHP_QUERY_RFC3986), null, [200]);
		$entries = $data['entries'] ?? null;
		if (!is_array($entries) || count($entries) > $limit)
		{
			throw new \RuntimeException('Box returned an invalid folder page.');
		}
		$next = $data['next_marker'] ?? null;
		if ($next !== null && (!is_string($next) || $next === '' || strlen($next) > 4096
			|| preg_match('/[\x00-\x1f\x7f]/', $next)))
		{
			throw new \RuntimeException('Box returned an invalid continuation marker.');
		}

		return ['entries' => array_values($entries), 'next_marker' => $next];
	}

	private function assert_cursor(?string $cursor): void
	{
		if ($cursor !== null && ($cursor === '' || strlen($cursor) > 4096
			|| preg_match('/[\x00-\x1f\x7f]/', $cursor)))
		{
			throw new \InvalidArgumentException('The Box continuation cursor is invalid.');
		}
	}

	/**
	 * @param array<string, mixed>|null $data
	 * @param list<int> $allowed
	 * @return array<string, mixed>
	 */
	private function api_json(string $method, string $url, ?array $data, array $allowed): array
	{
		$response = $data === null
			? $this->authorized_request($method, $url, [], static fn (): mixed => null)
			: $this->authorized_json_request($method, $url, $data);
		if (!in_array($response->status(), $allowed, true))
		{
			$this->unexpected_status($response->status());
		}

		return $this->response_json($response);
	}

	/** @param array<string, mixed> $data @param array<string, string> $headers */
	private function authorized_json_request(string $method, string $url, array $data, array $headers = []): response
	{
		$json = $this->encode($data);

		return $this->authorized_request($method, $url, [
			'Content-Type' => 'application/json',
		] + $headers, static fn (): mixed => self::memory_stream($json));
	}

	/**
	 * @param array<string, string> $headers
	 * @param \Closure(): resource|null $body_factory
	 */
	private function authorized_request(
		string $method,
		string $url,
		array $headers,
		\Closure $body_factory,
		bool $close_body = true
	): response
	{
		for ($attempt = 0; $attempt < 2; $attempt++)
		{
			$body = $body_factory();
			try
			{
				$response = $this->client->request($method, $url, [
					'Authorization' => 'Bearer ' . $this->tokens->token(),
				] + $headers, $body);
			}
			finally
			{
				if ($close_body && is_resource($body))
				{
					fclose($body);
				}
			}
			if ($response->status() !== 401 || $attempt === 1)
			{
				return $response;
			}
			$this->tokens->invalidate();
		}

		throw new \RuntimeException('Box authorization failed.');
	}

	/** @return array<string, mixed> */
	private function response_json(response $response): array
	{
		$body = $response->detach_body();
		if (!is_resource($body))
		{
			throw new \RuntimeException('Box returned no JSON response body.');
		}
		try
		{
			$json = stream_get_contents($body, self::MAX_JSON_RESPONSE + 1);
			if ($json === false || strlen($json) > self::MAX_JSON_RESPONSE || !feof($body))
			{
				throw new \RuntimeException('Box exceeded the JSON response safety limit.');
			}
		}
		finally
		{
			fclose($body);
		}
		try
		{
			$data = json_decode($json, true, 64, JSON_THROW_ON_ERROR);
		}
		catch (\JsonException $exception)
		{
			throw new \RuntimeException('Box returned invalid JSON.', 0, $exception);
		}
		if (!is_array($data))
		{
			throw new \RuntimeException('Box returned invalid JSON.');
		}

		return $data;
	}

	/** @param array<string, mixed> $value */
	private function encode(array $value): string
	{
		try
		{
			return json_encode($value, JSON_THROW_ON_ERROR | JSON_UNESCAPED_SLASHES);
		}
		catch (\JsonException $exception)
		{
			throw new \RuntimeException('Could not encode a Box request.', 0, $exception);
		}
	}

	/** @param array<string, mixed> $attributes @return resource */
	private function multipart_stream(string $boundary, array $attributes, string $name, string $local_file): mixed
	{
		$stream = fopen('php://temp/maxmemory:1048576', 'w+b');
		$source = fopen($local_file, 'rb');
		if ($stream === false || $source === false)
		{
			if (is_resource($stream))
			{
				fclose($stream);
			}
			if (is_resource($source))
			{
				fclose($source);
			}
			throw new \RuntimeException('Could not open the Box upload source.');
		}
		$quote = chr(34);
		$newline = chr(13) . chr(10);
		$suffix = $newline . '--' . $boundary . '--' . $newline;
		$prefix = '--' . $boundary . $newline
			. 'Content-Disposition: form-data; name=' . $quote . 'attributes' . $quote . $newline
			. 'Content-Type: application/json' . $newline . $newline
			. $this->encode($attributes) . $newline
			. '--' . $boundary . $newline
			. 'Content-Disposition: form-data; name=' . $quote . 'file' . $quote
			. '; filename=' . $quote . $name . $quote . $newline
			. 'Content-Type: application/octet-stream' . $newline . $newline;
		try
		{
			$size = filesize($local_file);
			if (!is_int($size) || fwrite($stream, $prefix) !== strlen($prefix)
				|| stream_copy_to_stream($source, $stream) !== $size
				|| fwrite($stream, $suffix) !== strlen($suffix))
			{
				throw new \RuntimeException('Could not build the Box multipart upload.');
			}
		}
		catch (\Throwable $exception)
		{
			fclose($stream);
			throw $exception;
		}
		finally
		{
			fclose($source);
		}
		rewind($stream);

		return $stream;
	}

	/** @return resource */
	private static function memory_stream(string $contents): mixed
	{
		$stream = fopen('php://temp', 'w+b');
		if ($stream === false || fwrite($stream, $contents) !== strlen($contents))
		{
			throw new \RuntimeException('Could not create a Box request body.');
		}
		rewind($stream);

		return $stream;
	}

	/** @param resource $source @return resource */
	private function read_chunk(mixed $source, int $length): mixed
	{
		$chunk = fopen('php://temp/maxmemory:1048576', 'w+b');
		if ($chunk === false)
		{
			throw new \RuntimeException('Could not create a Box upload chunk.');
		}
		$copied = stream_copy_to_stream($source, $chunk, $length);
		if ($copied !== $length)
		{
			fclose($chunk);
			throw new \RuntimeException('Could not read the complete Box upload chunk.');
		}
		rewind($chunk);

		return $chunk;
	}

	private function upload_session_url(string $url): string
	{
		$parts = parse_url($url);
		if (!is_array($parts))
		{
			throw new \RuntimeException('Box returned an invalid upload session URI.');
		}
		$host = strtolower((string) ($parts['host'] ?? ''));
		if (strtolower((string) ($parts['scheme'] ?? '')) !== 'https'
			|| !in_array($host, ['upload.box.com', 'upload.app.box.com'], true)
			|| !str_starts_with((string) ($parts['path'] ?? ''), '/api/2.0/files/upload_sessions/')
			|| isset($parts['user']) || isset($parts['pass']) || isset($parts['fragment'])
			|| strlen($url) > 4096)
		{
			throw new \RuntimeException('Box returned an invalid upload session URI.');
		}

		return $url;
	}

	private function download_url(string $url): string
	{
		$parts = parse_url($url);
		if (!is_array($parts) || strtolower((string) ($parts['scheme'] ?? '')) !== 'https'
			|| strtolower((string) ($parts['host'] ?? '')) !== 'dl.boxcloud.com'
			|| !str_starts_with((string) ($parts['path'] ?? ''), '/')
			|| isset($parts['user']) || isset($parts['pass']) || isset($parts['fragment'])
			|| strlen($url) > 8192)
		{
			throw new \RuntimeException('Box returned an invalid private download URI.');
		}

		return $url;
	}

	/** @return resource */
	private function body(response $response, string $message): mixed
	{
		$body = $response->detach_body();
		if (!is_resource($body))
		{
			throw new \RuntimeException($message);
		}

		return $body;
	}

	private function unexpected_status(int $status): never
	{
		throw new \RuntimeException('Box returned HTTP status ' . $status . '.');
	}
}
