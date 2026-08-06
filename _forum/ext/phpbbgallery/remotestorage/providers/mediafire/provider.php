<?php
/**
 * phpBB Gallery - Remote Storage Add-on
 *
 * @package   phpbbgallery/remotestorage
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\remotestorage\providers\mediafire;

use phpbbgallery\core\storage\provider_interface;
use phpbbgallery\remotestorage\http\client_interface;
use phpbbgallery\remotestorage\http\response;

/** Private MediaFire storage with resumable SHA-256 uploads. */
final class provider implements provider_interface
{
	private const API_ROOT = 'https://www.mediafire.com/api/1.5/';
	private const MAX_JSON_RESPONSE = 2097152;
	private const MAX_UNIT_SIZE = 67108864;
	/** @var array<string, string> */
	private array $variant_keys = [];
	private ?string $root_key = null;
	private \Closure $sleeper;

	public function __construct(
		private configuration $configuration,
		private api_client $api,
		private client_interface $client,
		?\Closure $sleeper = null
	)
	{
		$this->sleeper = $sleeper ?? static function (int $seconds): void
		{
			sleep($seconds);
		};
	}

	public function get_id(): string
	{
		return 'mediafire';
	}

	public function prepare(string $variant, string $key): bool
	{
		$this->configuration->object_name($variant, $key);
		$this->variant_folder_key($variant);

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
		$data = $this->api->call('file/get_links', [
			'link_type' => 'direct_download',
			'quick_key' => $this->configuration->assert_quickkey((string) $file['quickkey']),
		]);
		$this->require_success($data, 'MediaFire could not create a private download link.');
		$links = $data['links'] ?? null;
		$link = is_array($links) ? ($links[0] ?? null) : null;
		if (!is_array($link) || (string) ($link['quickkey'] ?? '') !== (string) $file['quickkey'])
		{
			throw new \RuntimeException('MediaFire returned invalid private download metadata.');
		}
		$url = $this->download_url((string) ($link['direct_download'] ?? ''));
		for ($attempt = 0; $attempt < 4; $attempt++)
		{
			$response = $this->client->request('GET', $url);
			if ($response->status() === 200)
			{
				$body = $response->detach_body();
				if (!is_resource($body))
				{
					throw new \RuntimeException('MediaFire returned no file content.');
				}

				return $body;
			}
			if (!in_array($response->status(), [301, 302, 303, 307, 308], true))
			{
				throw new \RuntimeException('MediaFire download returned HTTP status '
					. $response->status() . '.');
			}
			$url = $this->download_url((string) ($response->header('location') ?? ''));
		}

		throw new \RuntimeException('MediaFire exceeded the private download redirect limit.');
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
		$data = $this->api->call('file/purge', [
			'quick_key' => $this->configuration->assert_quickkey((string) $file['quickkey']),
		]);
		if (($data['result'] ?? '') !== 'Success' && (int) ($data['error'] ?? 0) !== 110)
		{
			$this->require_success($data, 'MediaFire could not delete the Gallery object.');
		}

		return true;
	}

	public function size(string $variant, string $key): ?int
	{
		$size = $this->find_object($variant, $key)['size'] ?? null;
		if ((!is_int($size) && (!is_string($size) || preg_match('/^[0-9]+$/D', $size) !== 1))
			|| (int) $size < 0)
		{
			return null;
		}

		return (int) $size;
	}

	public function modified_time(string $variant, string $key): ?int
	{
		$file = $this->find_object($variant, $key);
		$value = is_array($file) ? (string) ($file['created_utc'] ?? $file['created'] ?? '') : '';
		$timestamp = $value === '' ? false : strtotime($value);

		return $timestamp === false ? null : $timestamp;
	}

	public function checksum(string $variant, string $key, string $algorithm = 'sha256'): ?string
	{
		if ($algorithm !== 'sha256')
		{
			return null;
		}
		$hash = strtolower((string) ($this->find_object($variant, $key)['hash'] ?? ''));

		return preg_match('/^[a-f0-9]{64}$/D', $hash) === 1 ? $hash : null;
	}

	public function list_objects(string $variant, ?string $cursor = null, int $limit = 500): array
	{
		[$chunk, $offset] = $this->decode_cursor($cursor);
		$limit = max(1, min(1000, $limit));
		$page = $this->folder_page($this->variant_folder_key($variant), 'files', $chunk);
		$files = $page['items'];
		if ($offset > count($files))
		{
			throw new \RuntimeException('MediaFire returned an inconsistent folder cursor.');
		}
		$selected = array_slice($files, $offset, $limit);
		$keys = [];
		foreach ($selected as $file)
		{
			if (!is_array($file))
			{
				throw new \RuntimeException('MediaFire returned an invalid Gallery file.');
			}
			$this->ensure_private_file($file);
			$key = $this->configuration->relative_key($variant, (string) ($file['filename'] ?? ''));
			if ($key === null)
			{
				throw new \RuntimeException('MediaFire returned an invalid Gallery object name.');
			}
			$keys[] = $key;
		}
		$next_offset = $offset + count($selected);
		if ($next_offset < count($files))
		{
			$next = $chunk . ':' . $next_offset;
		}
		else
		{
			$next = $page['more'] ? ($chunk + 1) . ':0' : null;
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
		if (!is_int($size) || $size < 1 || !is_string($hash))
		{
			return false;
		}
		$name = $this->configuration->object_name($variant, $key);
		$existing = $this->find_object($variant, $key);
		if (($create_only && $existing !== null) || (!$create_only && $existing === null))
		{
			return false;
		}
		$folder_key = $this->variant_folder_key($variant);
		$check = $this->api->call('upload/check', [
			'filename' => $name,
			'folder_key' => $folder_key,
			'hash' => $hash,
			'resumable' => 'yes',
			'size' => $size,
		]);
		$this->require_success($check, 'MediaFire rejected the Gallery upload.');
		if (($check['storage_limit_exceeded'] ?? '') === 'yes')
		{
			throw new \RuntimeException('The MediaFire account has no storage capacity available.');
		}
		$quickkey = null;
		if (($check['hash_exists'] ?? '') === 'yes')
		{
			$quickkey = $this->instant_upload($name, $folder_key, $hash, $size, $existing, $create_only);
		}
		else
		{
			$quickkey = $this->resumable_upload(
				$name,
				$folder_key,
				$hash,
				$size,
				$local_file,
				$check,
				$existing,
				$create_only
			);
		}
		if ($quickkey === null)
		{
			return false;
		}
		$this->make_file_private($quickkey);

		return true;
	}

	/** @param array<string, mixed>|null $existing */
	private function instant_upload(
		string $name,
		string $folder_key,
		string $hash,
		int $size,
		?array $existing,
		bool $create_only
	): ?string
	{
		$params = [
			'action_on_duplicate' => $create_only ? 'skip' : 'replace',
			'filename' => $name,
			'folder_key' => $folder_key,
			'hash' => $hash,
			'size' => $size,
			'version_control' => 'none',
		];
		if (!$create_only && is_array($existing))
		{
			$params['previous_hash'] = (string) ($existing['hash'] ?? '');
			$params['quick_key'] = $this->configuration->assert_quickkey((string) $existing['quickkey']);
		}
		$data = $this->api->call('upload/instant', $params);
		if (($data['result'] ?? '') !== 'Success')
		{
			if ($create_only && in_array((int) ($data['error'] ?? 0), [119, 159], true))
			{
				return null;
			}
			$this->require_success($data, 'MediaFire instant upload failed.');
		}

		return $this->configuration->assert_quickkey((string) ($data['quickkey'] ?? ''));
	}

	/**
	 * @param array<string, mixed> $check
	 * @param array<string, mixed>|null $existing
	 */
	private function resumable_upload(
		string $name,
		string $folder_key,
		string $hash,
		int $size,
		string $local_file,
		array $check,
		?array $existing,
		bool $create_only
	): ?string
	{
		$resumable = $check['resumable_upload'] ?? null;
		if (!is_array($resumable))
		{
			throw new \RuntimeException('MediaFire returned no resumable upload session.');
		}
		$unit_size = (int) ($resumable['unit_size'] ?? 0);
		$unit_count = (int) ($resumable['number_of_units'] ?? 0);
		if ($unit_size < 1 || $unit_size > self::MAX_UNIT_SIZE || $unit_count < 1
			|| $unit_count !== (int) ceil($size / $unit_size) || $unit_count > 100000)
		{
			throw new \RuntimeException('MediaFire returned an invalid resumable upload session.');
		}
		$words = $resumable['bitmap']['words'] ?? [];
		if (!is_array($words) || count($words) > (int) ceil($unit_count / 16))
		{
			throw new \RuntimeException('MediaFire returned an invalid upload bitmap.');
		}
		$source = fopen($local_file, 'rb');
		if ($source === false)
		{
			return null;
		}
		$upload_key = (string) ($resumable['upload_key'] ?? '');
		try
		{
			for ($unit = 0; $unit < $unit_count; $unit++)
			{
				$length = min($unit_size, $size - ($unit * $unit_size));
				$contents = $this->read_bytes($source, $length);
				if ($this->unit_uploaded($words, $unit))
				{
					continue;
				}
				$params = [
					'action_on_duplicate' => $create_only ? 'skip' : 'replace',
					'folder_key' => $folder_key,
					'version_control' => 'none',
				];
				if (!$create_only && is_array($existing))
				{
					$params['previous_hash'] = (string) ($existing['hash'] ?? '');
					$params['quick_key'] = $this->configuration->assert_quickkey((string) $existing['quickkey']);
				}
				$data = $this->api->call('upload/resumable', $params, [
					'Content-Type' => 'application/octet-stream',
					'x-filehash' => $hash,
					'x-filename' => $name,
					'x-filesize' => (string) $size,
					'x-unit-hash' => hash('sha256', $contents),
					'x-unit-id' => (string) $unit,
					'x-unit-size' => (string) $length,
				], fn (): mixed => $this->stream($contents));
				$this->require_success($data, 'MediaFire resumable upload failed.');
				if ((int) ($data['doupload']['result'] ?? -1) !== 0)
				{
					throw new \RuntimeException('MediaFire rejected an upload unit.');
				}
				$upload_key = (string) ($data['doupload']['key'] ?? $upload_key);
			}
		}
		finally
		{
			fclose($source);
		}
		if (preg_match('/^[A-Za-z0-9]{1,128}$/D', $upload_key) !== 1)
		{
			throw new \RuntimeException('MediaFire returned an invalid upload key.');
		}

		return $this->poll_upload($upload_key, $create_only);
	}

	private function poll_upload(string $upload_key, bool $create_only): ?string
	{
		$url = self::API_ROOT . 'upload/poll_upload.php?'
			. http_build_query(['key' => $upload_key, 'response_format' => 'json'], '', '&', PHP_QUERY_RFC3986);
		for ($attempt = 0; $attempt < 20; $attempt++)
		{
			$response = $this->client->request('GET', $url);
			if ($response->status() !== 200)
			{
				throw new \RuntimeException('MediaFire upload polling returned HTTP status '
					. $response->status() . '.');
			}
			$data = $this->response_json($response);
			$this->require_success($data, 'MediaFire upload polling failed.');
			$upload = $data['doupload'] ?? (($data['douploads'][0] ?? null));
			if (!is_array($upload))
			{
				throw new \RuntimeException('MediaFire returned invalid upload status.');
			}
			$file_error = (int) ($upload['fileerror'] ?? 0);
			if ($file_error !== 0)
			{
				if ($create_only && $file_error === 13)
				{
					return null;
				}
				throw new \RuntimeException('MediaFire rejected the completed upload with file error '
					. $file_error . '.');
			}
			if ((int) ($upload['status'] ?? 0) === 99)
			{
				return $this->configuration->assert_quickkey((string) ($upload['quickkey'] ?? ''));
			}
			($this->sleeper)(1);
		}

		throw new \RuntimeException('MediaFire did not finish processing the upload in time.');
	}

	/** @return array<string, mixed>|null */
	private function find_object(string $variant, string $key): ?array
	{
		$name = $this->configuration->object_name($variant, $key);
		$chunk = 1;
		do
		{
			$page = $this->folder_page($this->variant_folder_key($variant), 'files', $chunk);
			$found = null;
			foreach ($page['items'] as $file)
			{
				if (is_array($file) && strcasecmp((string) ($file['filename'] ?? ''), $name) === 0)
				{
					if ($found !== null)
					{
						throw new \RuntimeException('MediaFire returned an ambiguous Gallery object.');
					}
					$file['quickkey'] = $this->configuration->assert_quickkey((string) ($file['quickkey'] ?? ''));
					$this->ensure_private_file($file);
					$found = $file;
				}
			}
			if ($found !== null)
			{
				return $found;
			}
			$chunk++;
		}
		while ($page['more']);

		return null;
	}

	private function variant_folder_key(string $variant): string
	{
		$name = $this->configuration->variant_name($variant);
		if (isset($this->variant_keys[$name]))
		{
			return $this->variant_keys[$name];
		}
		$this->variant_keys[$name] = $this->create_private_folder($name, $this->root_folder_key(), false);

		return $this->variant_keys[$name];
	}

	private function root_folder_key(): string
	{
		if ($this->root_key === null)
		{
			$this->root_key = $this->create_private_folder(
				$this->configuration->root_name(),
				'myfiles',
				true
			);
		}

		return $this->root_key;
	}

	private function create_private_folder(string $name, string $parent, bool $recursive): string
	{
		$data = $this->api->call('folder/create', [
			'action_on_duplicate' => 'replace',
			'foldername' => $name,
			'parent_key' => $parent,
		]);
		$this->require_success($data, 'MediaFire could not create the Gallery folder.');
		$key = $this->configuration->assert_folder_key((string) ($data['folder_key'] ?? ''));
		$updated = $this->api->call('folder/update', [
			'folder_key' => $key,
			'privacy' => 'private',
			'privacy_recursive' => $recursive ? 'yes' : 'no',
		]);
		$this->require_success($updated, 'MediaFire could not make the Gallery folder private.');

		return $key;
	}

	/** @param array<string, mixed> $file */
	private function ensure_private_file(array $file): void
	{
		if (($file['privacy'] ?? '') !== 'private')
		{
			$this->make_file_private(
				$this->configuration->assert_quickkey((string) ($file['quickkey'] ?? ''))
			);
		}
	}

	private function make_file_private(string $quickkey): void
	{
		$data = $this->api->call('file/update', [
			'privacy' => 'private',
			'quick_key' => $quickkey,
		]);
		$this->require_success($data, 'MediaFire could not make the Gallery object private.');
	}

	/** @return array{items: list<mixed>, more: bool} */
	private function folder_page(string $folder_key, string $type, int $chunk): array
	{
		if (!in_array($type, ['files', 'folders'], true) || $chunk < 1 || $chunk > 999999999)
		{
			throw new \InvalidArgumentException('The MediaFire folder page request is invalid.');
		}
		$data = $this->api->call('folder/get_content', [
			'chunk' => $chunk,
			'chunk_size' => 1000,
			'content_type' => $type,
			'folder_key' => $this->configuration->assert_folder_key($folder_key),
			'order_by' => 'name',
			'order_direction' => 'asc',
		]);
		$this->require_success($data, 'MediaFire could not enumerate the Gallery folder.');
		$content = $data['folder_content'] ?? null;
		$items = is_array($content) ? ($content[$type] ?? []) : null;
		if (!is_array($content) || !is_array($items) || count($items) > 1000
			|| (int) ($content['chunk_number'] ?? 0) !== $chunk
			|| !in_array((string) ($content['more_chunks'] ?? ''), ['yes', 'no'], true))
		{
			throw new \RuntimeException('MediaFire returned an invalid folder page.');
		}

		return ['items' => array_values($items), 'more' => $content['more_chunks'] === 'yes'];
	}

	/** @return array{0: int, 1: int} */
	private function decode_cursor(?string $cursor): array
	{
		if ($cursor === null)
		{
			return [1, 0];
		}
		if (preg_match('/^([1-9][0-9]{0,8}):([0-9]{1,4})$/D', $cursor, $matches) !== 1
			|| (int) $matches[2] > 999)
		{
			throw new \InvalidArgumentException('The MediaFire continuation cursor is invalid.');
		}

		return [(int) $matches[1], (int) $matches[2]];
	}

	/** @param list<mixed> $words */
	private function unit_uploaded(array $words, int $unit): bool
	{
		$word = $words[intdiv($unit, 16)] ?? 0;
		if ((!is_int($word) && (!is_string($word) || preg_match('/^[0-9]+$/D', $word) !== 1))
			|| (int) $word < 0 || (int) $word > 65535)
		{
			throw new \RuntimeException('MediaFire returned an invalid upload bitmap word.');
		}

		return (((int) $word >> ($unit % 16)) & 1) === 1;
	}

	/** @param resource $source */
	private function read_bytes(mixed $source, int $length): string
	{
		$contents = '';
		while (strlen($contents) < $length && !feof($source))
		{
			$part = fread($source, $length - strlen($contents));
			if ($part === false)
			{
				throw new \RuntimeException('Could not read the MediaFire upload source.');
			}
			$contents .= $part;
		}
		if (strlen($contents) !== $length)
		{
			throw new \RuntimeException('The MediaFire upload source ended unexpectedly.');
		}

		return $contents;
	}

	/** @return resource */
	private function stream(string $contents): mixed
	{
		$stream = fopen('php://temp/maxmemory:67108864', 'w+b');
		if ($stream === false || fwrite($stream, $contents) !== strlen($contents))
		{
			throw new \RuntimeException('Could not create the MediaFire upload unit.');
		}
		rewind($stream);

		return $stream;
	}

	private function download_url(string $url): string
	{
		$parts = parse_url($url);
		$host = strtolower((string) ($parts['host'] ?? ''));
		$path = (string) ($parts['path'] ?? '');
		$query = isset($parts['query']) ? '?' . (string) $parts['query'] : '';
		$decoded_target = rawurldecode($path . $query);
		if (!in_array(strtolower((string) ($parts['scheme'] ?? '')), ['http', 'https'], true)
			|| preg_match('/^download[0-9]+\.mediafire\.com$/D', $host) !== 1
			|| $path === '' || !str_starts_with($path, '/') || isset($parts['user']) || isset($parts['pass'])
			|| isset($parts['port']) || isset($parts['fragment'])
			|| preg_match('/[\x00-\x1f\x7f]/', $path . $query)
			|| preg_match('/[\x00-\x1f\x7f]/', $decoded_target))
		{
			throw new \RuntimeException('MediaFire returned an invalid private download URI.');
		}

		return 'https://' . $host . $path . $query;
	}

	/** @param array<string, mixed> $data */
	private function require_success(array $data, string $message): void
	{
		if (($data['result'] ?? '') !== 'Success')
		{
			$error = (int) ($data['error'] ?? 0);
			throw new \RuntimeException($message . ($error > 0 ? ' Error ' . $error . '.' : ''));
		}
	}

	/** @return array<string, mixed> */
	private function response_json(response $response): array
	{
		$body = $response->detach_body();
		if (!is_resource($body))
		{
			throw new \RuntimeException('MediaFire returned no JSON response body.');
		}
		try
		{
			$json = stream_get_contents($body, self::MAX_JSON_RESPONSE + 1);
			if ($json === false || strlen($json) > self::MAX_JSON_RESPONSE || !feof($body))
			{
				throw new \RuntimeException('MediaFire exceeded the JSON response safety limit.');
			}
		}
		finally
		{
			fclose($body);
		}
		try
		{
			$decoded = json_decode($json, true, 64, JSON_THROW_ON_ERROR);
		}
		catch (\JsonException $exception)
		{
			throw new \RuntimeException('MediaFire returned invalid JSON.', 0, $exception);
		}
		$data = is_array($decoded) ? ($decoded['response'] ?? null) : null;
		if (!is_array($data))
		{
			throw new \RuntimeException('MediaFire returned an invalid API envelope.');
		}

		return $data;
	}
}
