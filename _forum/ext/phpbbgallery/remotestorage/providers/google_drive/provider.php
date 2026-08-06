<?php
/**
 * phpBB Gallery - Remote Storage Add-on
 *
 * @package   phpbbgallery/remotestorage
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\remotestorage\providers\google_drive;

use phpbbgallery\core\storage\provider_interface;
use phpbbgallery\remotestorage\http\client_interface;
use phpbbgallery\remotestorage\http\response;

/** Private Google Drive provider limited to files created by the Gallery application. */
final class provider implements provider_interface
{
	private const API_ENDPOINT = 'https://www.googleapis.com/drive/v3/files';
	private const UPLOAD_ENDPOINT = 'https://www.googleapis.com/upload/drive/v3/files';
	private const FOLDER_MIME = 'application/vnd.google-apps.folder';
	private const MAX_JSON_RESPONSE = 8388608;
	private const DEFAULT_CHUNK_SIZE = 8388608;

	private ?string $root_id = null;
	/** @var array<string, string> */
	private array $variant_ids = [];

	public function __construct(
		private configuration $configuration,
		private token_manager $tokens,
		private client_interface $client,
		private int $chunk_size = self::DEFAULT_CHUNK_SIZE
	)
	{
		if ($chunk_size < 262144 || $chunk_size > 157286400 || $chunk_size % 262144 !== 0)
		{
			throw new \InvalidArgumentException('The Google Drive upload chunk size is invalid.');
		}
	}

	public function get_id(): string
	{
		return 'google_drive';
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
			return false;
		}
		$response = $this->authorized_request(
			'GET',
			self::API_ENDPOINT . '/' . rawurlencode((string) $file['id']) . '?alt=media',
			[],
			static fn (): mixed => null
		);
		if ($response->status() === 404)
		{
			return false;
		}
		if ($response->status() !== 200)
		{
			$this->unexpected_status($response->status());
		}
		$body = $response->detach_body();
		if (!is_resource($body))
		{
			throw new \RuntimeException('Google Drive returned no downloadable object body.');
		}

		return $body;
	}

	public function local_path(string $variant, string $key): ?string
	{
		$this->configuration->object_name($variant, $key);

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
			return true;
		}
		$response = $this->authorized_request(
			'DELETE',
			self::API_ENDPOINT . '/' . rawurlencode((string) $file['id']),
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
		$value = $this->find_object($variant, $key)['size'] ?? null;

		return is_string($value) && preg_match('/^[0-9]+$/D', $value) ? (int) $value : null;
	}

	public function modified_time(string $variant, string $key): ?int
	{
		$value = $this->find_object($variant, $key)['modifiedTime'] ?? null;
		$timestamp = is_string($value) ? strtotime($value) : false;

		return $timestamp === false ? null : $timestamp;
	}

	public function checksum(string $variant, string $key, string $algorithm = 'sha256'): ?string
	{
		if ($algorithm !== 'sha256')
		{
			return null;
		}
		$value = strtolower((string) ($this->find_object($variant, $key)['appProperties']['phpbbgallery_sha256'] ?? ''));

		return preg_match('/^[a-f0-9]{64}$/D', $value) ? $value : null;
	}

	public function list_objects(string $variant, ?string $cursor = null, int $limit = 500): array
	{
		$limit = max(1, min(1000, $limit));
		if ($cursor !== null && ($cursor === '' || strlen($cursor) > 4096
			|| preg_match('/[\x00-\x1f\x7f]/', $cursor)))
		{
			throw new \InvalidArgumentException('The Google Drive continuation cursor is invalid.');
		}
		$query = [
			'q' => chr(39) . $this->configuration->query_literal($this->variant_folder_id($variant))
				. chr(39) . ' in parents and trashed = false' . $this->marker_query(),
			'pageSize' => $limit,
			'orderBy' => 'name',
			'spaces' => 'drive',
			'fields' => 'nextPageToken,incompleteSearch,files(id,name,mimeType)',
		];
		if ($cursor !== null)
		{
			$query['pageToken'] = $cursor;
		}
		$data = $this->api_json('GET', self::API_ENDPOINT . '?' . http_build_query(
			$query,
			'',
			'&',
			PHP_QUERY_RFC3986
		), null, [200]);
		if (($data['incompleteSearch'] ?? false) === true || !is_array($data['files'] ?? null))
		{
			throw new \RuntimeException('Google Drive returned an incomplete or invalid object page.');
		}
		$files = $data['files'];
		if (count($files) > $limit)
		{
			throw new \RuntimeException('Google Drive exceeded the requested object page size.');
		}
		$keys = [];
		foreach ($files as $file)
		{
			if (!is_array($file) || ($file['mimeType'] ?? '') === self::FOLDER_MIME)
			{
				throw new \RuntimeException('Google Drive returned an unexpected object in the Gallery folder.');
			}
			$key = $this->configuration->relative_key($variant, (string) ($file['name'] ?? ''));
			if ($key === null)
			{
				throw new \RuntimeException('Google Drive returned an invalid Gallery object key.');
			}
			$keys[] = $key;
		}
		$next = $data['nextPageToken'] ?? null;
		if ($next !== null && (!is_string($next) || $next === '' || strlen($next) > 4096))
		{
			throw new \RuntimeException('Google Drive returned an invalid continuation cursor.');
		}

		return ['keys' => $keys, 'cursor' => $next];
	}

	private function upload(string $variant, string $key, string $local_file, bool $create_only): bool
	{
		if (!is_file($local_file) || is_link($local_file) || !is_readable($local_file))
		{
			return false;
		}
		$size = filesize($local_file);
		$hash = hash_file('sha256', $local_file);
		if (!is_int($size) || $size < 0 || !is_string($hash))
		{
			return false;
		}
		$existing = $this->find_object($variant, $key);
		if (($create_only && $existing !== null) || (!$create_only && $existing === null))
		{
			return false;
		}
		$metadata = [
			'name' => $this->configuration->object_name($variant, $key),
			'appProperties' => [
				'phpbbgallery_provider' => 'google_drive',
				'phpbbgallery_sha256' => $hash,
			],
		];
		if ($create_only)
		{
			$metadata['parents'] = [$this->variant_folder_id($variant)];
		}
		$url = self::UPLOAD_ENDPOINT
			. ($create_only ? '' : '/' . rawurlencode((string) $existing['id']))
			. '?uploadType=resumable&fields=id,name,size,modifiedTime,appProperties';
		$json = $this->encode($metadata);
		$response = $this->authorized_request(
			$create_only ? 'POST' : 'PATCH',
			$url,
			[
				'Content-Length' => (string) strlen($json),
				'Content-Type' => 'application/json; charset=UTF-8',
				'X-Upload-Content-Length' => (string) $size,
				'X-Upload-Content-Type' => 'application/octet-stream',
			],
			static fn (): mixed => self::memory_stream_static($json)
		);
		if ($response->status() !== 200)
		{
			$this->unexpected_status($response->status());
		}
		$session_url = $this->session_url((string) ($response->header('location') ?? ''));
		$source = fopen($local_file, 'rb');
		if ($source === false)
		{
			return false;
		}
		try
		{
			$this->upload_content($session_url, $source, $size);
		}
		finally
		{
			fclose($source);
		}

		return true;
	}

	/** @param resource $source */
	private function upload_content(string $session_url, mixed $source, int $size): void
	{
		if ($size === 0)
		{
			$response = $this->authorized_request('PUT', $session_url, [
				'Content-Length' => '0',
			], static fn (): mixed => null);
			if (!in_array($response->status(), [200, 201], true))
			{
				$this->unexpected_status($response->status());
			}

			return;
		}
		$offset = 0;
		$failures = 0;
		while ($offset < $size)
		{
			$length = min($this->chunk_size, $size - $offset);
			if (fseek($source, $offset) !== 0)
			{
				throw new \RuntimeException('Could not seek the Google Drive upload source.');
			}
			$chunk = $this->read_chunk($source, $length);
			try
			{
				$response = $this->authorized_request('PUT', $session_url, [
					'Content-Length' => (string) $length,
					'Content-Range' => 'bytes ' . $offset . '-' . ($offset + $length - 1) . '/' . $size,
					'Content-Type' => 'application/octet-stream',
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
			if (in_array($response->status(), [500, 502, 503, 504], true))
			{
				if (++$failures > 3)
				{
					$this->unexpected_status($response->status());
				}
				$offset = $this->session_offset($session_url, $size);
				continue;
			}
			$failures = 0;
			$offset += $length;
			if ($offset < $size && ($response->status() !== 308
				|| $response->header('range') !== 'bytes=0-' . ($offset - 1)))
			{
				$this->unexpected_status($response->status());
			}
			if ($offset === $size && !in_array($response->status(), [200, 201], true))
			{
				$this->unexpected_status($response->status());
			}
		}
	}

	private function session_offset(string $session_url, int $size): int
	{
		$response = $this->authorized_request('PUT', $session_url, [
			'Content-Length' => '0',
			'Content-Range' => 'bytes */' . $size,
		], static fn (): mixed => null);
		if (in_array($response->status(), [200, 201], true))
		{
			return $size;
		}
		if ($response->status() !== 308)
		{
			$this->unexpected_status($response->status());
		}
		$range = $response->header('range');
		if ($range === null)
		{
			return 0;
		}
		if (preg_match('/^bytes=0-([0-9]+)$/D', $range, $matches) !== 1)
		{
			throw new \RuntimeException('Google Drive returned an invalid resumable upload offset.');
		}
		$offset = (int) $matches[1] + 1;
		if ($offset < 0 || $offset > $size)
		{
			throw new \RuntimeException('Google Drive returned an invalid resumable upload offset.');
		}

		return $offset;
	}

	/** @return array<string, mixed>|null */
	private function find_object(string $variant, string $key): ?array
	{
		return $this->find_child(
			$this->variant_folder_id($variant),
			$this->configuration->object_name($variant, $key),
			false
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
		$folder = $this->find_child($root_id, $name, true);
		$id = $folder === null ? $this->create_folder($name, $root_id) : (string) $folder['id'];
		$this->variant_ids[$name] = $this->configuration->assert_file_id($id);

		return $this->variant_ids[$name];
	}

	private function root_folder_id(): string
	{
		if ($this->root_id !== null)
		{
			return $this->root_id;
		}
		$folder = $this->find_child('root', $this->configuration->root_name(), true);
		$id = $folder === null
			? $this->create_folder($this->configuration->root_name(), 'root')
			: (string) $folder['id'];
		$this->root_id = $this->configuration->assert_file_id($id);

		return $this->root_id;
	}

	/** @return array<string, mixed>|null */
	private function find_child(string $parent_id, string $name, bool $folder): ?array
	{
		$parent = $parent_id === 'root' ? 'root' : $this->configuration->assert_file_id($parent_id);
		$q = chr(39) . $this->configuration->query_literal($parent) . chr(39) . ' in parents'
			. ' and name = ' . chr(39) . $this->configuration->query_literal($name) . chr(39)
			. ' and trashed = false' . $this->marker_query();
		if ($folder)
		{
			$q .= ' and mimeType = ' . chr(39) . self::FOLDER_MIME . chr(39);
		}
		$data = $this->api_json('GET', self::API_ENDPOINT . '?' . http_build_query([
			'q' => $q,
			'pageSize' => 2,
			'spaces' => 'drive',
			'fields' => 'incompleteSearch,files(id,name,mimeType,size,modifiedTime,appProperties)',
		], '', '&', PHP_QUERY_RFC3986), null, [200]);
		$files = $data['files'] ?? null;
		if (($data['incompleteSearch'] ?? false) === true || !is_array($files) || count($files) > 1)
		{
			throw new \RuntimeException('Google Drive returned an ambiguous Gallery object.');
		}
		if ($files === [])
		{
			return null;
		}
		$file = $files[0];
		if (!is_array($file) || ($folder && ($file['mimeType'] ?? '') !== self::FOLDER_MIME))
		{
			throw new \RuntimeException('Google Drive returned invalid Gallery metadata.');
		}
		$file['id'] = $this->configuration->assert_file_id((string) ($file['id'] ?? ''));

		return $file;
	}

	private function create_folder(string $name, string $parent_id): string
	{
		$data = $this->api_json('POST', self::API_ENDPOINT . '?fields=id,name,mimeType', [
			'name' => $name,
			'mimeType' => self::FOLDER_MIME,
			'parents' => [$parent_id],
			'appProperties' => ['phpbbgallery_provider' => 'google_drive'],
		], [200]);

		return $this->configuration->assert_file_id((string) ($data['id'] ?? ''));
	}

	private function marker_query(): string
	{
		return ' and appProperties has { key=' . chr(39) . 'phpbbgallery_provider' . chr(39)
			. ' and value=' . chr(39) . 'google_drive' . chr(39) . ' }';
	}

	/**
	 * @param array<string, mixed>|null $data
	 * @param list<int> $allowed
	 * @return array<string, mixed>
	 */
	private function api_json(string $method, string $url, ?array $data, array $allowed): array
	{
		$json = $data === null ? null : $this->encode($data);
		$response = $this->authorized_request(
			$method,
			$url,
			$json === null ? [] : [
				'Content-Length' => (string) strlen($json),
				'Content-Type' => 'application/json; charset=UTF-8',
			],
			$json === null ? static fn (): mixed => null
				: static fn (): mixed => self::memory_stream_static($json)
		);
		if (!in_array($response->status(), $allowed, true))
		{
			$this->unexpected_status($response->status());
		}

		return $this->response_json($response);
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

		throw new \RuntimeException('Google Drive authorization failed.');
	}

	/** @return array<string, mixed> */
	private function response_json(response $response): array
	{
		$body = $response->detach_body();
		if (!is_resource($body))
		{
			throw new \RuntimeException('Google Drive returned no JSON response body.');
		}
		try
		{
			$json = stream_get_contents($body, self::MAX_JSON_RESPONSE + 1);
			if ($json === false || strlen($json) > self::MAX_JSON_RESPONSE || !feof($body))
			{
				throw new \RuntimeException('Google Drive exceeded the JSON response safety limit.');
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
			throw new \RuntimeException('Google Drive returned invalid JSON.', 0, $exception);
		}
		if (!is_array($data))
		{
			throw new \RuntimeException('Google Drive returned invalid JSON.');
		}

		return $data;
	}

	private function session_url(string $url): string
	{
		$parts = parse_url($url);
		if (!is_array($parts) || strtolower((string) ($parts['scheme'] ?? '')) !== 'https'
			|| strtolower((string) ($parts['host'] ?? '')) !== 'www.googleapis.com'
			|| !str_starts_with((string) ($parts['path'] ?? ''), '/upload/drive/')
			|| isset($parts['user']) || isset($parts['pass']) || isset($parts['fragment'])
			|| strlen($url) > 4096)
		{
			throw new \RuntimeException('Google Drive returned an invalid resumable upload URI.');
		}

		return $url;
	}

	private function unexpected_status(int $status): never
	{
		throw new \RuntimeException('Google Drive returned HTTP status ' . $status . '.');
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
			throw new \RuntimeException('Could not encode a Google Drive request.', 0, $exception);
		}
	}

	/** @return resource */
	private static function memory_stream_static(string $contents): mixed
	{
		$stream = fopen('php://temp', 'w+b');
		if ($stream === false || fwrite($stream, $contents) !== strlen($contents))
		{
			throw new \RuntimeException('Could not create a Google Drive request body.');
		}
		rewind($stream);

		return $stream;
	}

	/** @param resource $source @return resource */
	private function read_chunk(mixed $source, int $length): mixed
	{
		$chunk = fopen('php://temp', 'w+b');
		if ($chunk === false)
		{
			throw new \RuntimeException('Could not create a Google Drive upload chunk.');
		}
		$copied = stream_copy_to_stream($source, $chunk, $length);
		if ($copied !== $length)
		{
			fclose($chunk);
			throw new \RuntimeException('Could not read the complete Google Drive upload chunk.');
		}
		rewind($chunk);

		return $chunk;
	}
}
