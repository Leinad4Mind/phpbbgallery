<?php
/**
 * phpBB Gallery - Remote Storage Add-on
 *
 * @package   phpbbgallery/remotestorage
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\remotestorage\providers\dropbox;

use phpbbgallery\core\storage\provider_interface;
use phpbbgallery\remotestorage\http\client_interface;
use phpbbgallery\remotestorage\http\response;

/** Private Dropbox App Folder provider for Gallery objects. */
final class provider implements provider_interface
{
	private const API_ENDPOINT = 'https://api.dropboxapi.com/2/files/';
	private const CONTENT_ENDPOINT = 'https://content.dropboxapi.com/2/files/';
	private const MAX_JSON_RESPONSE = 8388608;
	private const DEFAULT_SIMPLE_UPLOAD_LIMIT = 157286400;
	private const DEFAULT_CHUNK_SIZE = 8388608;

	/** @var array<string, true> */
	private array $prepared_folders = [];

	public function __construct(
		private configuration $configuration,
		private token_manager $tokens,
		private client_interface $client,
		private int $simple_upload_limit = self::DEFAULT_SIMPLE_UPLOAD_LIMIT,
		private int $chunk_size = self::DEFAULT_CHUNK_SIZE
	)
	{
		if ($simple_upload_limit < 1 || $simple_upload_limit > self::DEFAULT_SIMPLE_UPLOAD_LIMIT
			|| $chunk_size < 1 || $chunk_size > self::DEFAULT_SIMPLE_UPLOAD_LIMIT)
		{
			throw new \InvalidArgumentException('The Dropbox upload limits are invalid.');
		}
	}

	public function get_id(): string
	{
		return 'dropbox';
	}

	public function prepare(string $variant, string $key): bool
	{
		foreach ($this->configuration->parent_paths($variant, $key) as $path)
		{
			if (isset($this->prepared_folders[strtolower($path)]))
			{
				continue;
			}
			[$status, $data] = $this->api('create_folder_v2', [
				'path' => $path,
				'autorename' => false,
			], [200, 409]);
			if ($status === 409)
			{
				$metadata = $this->metadata_path($path);
				if (($metadata['.tag'] ?? '') !== 'folder')
				{
					throw new \RuntimeException('A Dropbox Gallery path is occupied by a file.');
				}
			}
			$this->prepared_folders[strtolower($path)] = true;
		}

		return true;
	}

	public function write(string $variant, string $key, string $local_file): bool
	{
		return $this->upload($variant, $key, $local_file, true);
	}

	public function replace(string $variant, string $key, string $local_file): bool
	{
		return $this->exists($variant, $key) && $this->upload($variant, $key, $local_file, false);
	}

	public function open_stream(string $variant, string $key): mixed
	{
		$response = $this->content('download', [
			'path' => $this->configuration->object_path($variant, $key),
		], null);
		if ($response->status() === 409)
		{
			$data = $this->response_json($response);

			return $this->is_not_found($data) ? false : $this->unexpected_status($response->status());
		}
		if ($response->status() !== 200)
		{
			$this->unexpected_status($response->status());
		}
		$body = $response->detach_body();
		if (!is_resource($body))
		{
			throw new \RuntimeException('Dropbox returned no downloadable object body.');
		}

		return $body;
	}

	public function local_path(string $variant, string $key): ?string
	{
		$this->configuration->object_path($variant, $key);

		return null;
	}

	public function exists(string $variant, string $key): bool
	{
		return $this->metadata($variant, $key) !== null;
	}

	public function delete(string $variant, string $key): bool
	{
		[$status, $data] = $this->api('delete_v2', [
			'path' => $this->configuration->object_path($variant, $key),
		], [200, 409]);
		if ($status === 409 && !$this->is_not_found($data))
		{
			$this->unexpected_status($status);
		}

		return true;
	}

	public function size(string $variant, string $key): ?int
	{
		$size = $this->metadata($variant, $key)['size'] ?? null;

		return is_int($size) && $size >= 0 ? $size : null;
	}

	public function modified_time(string $variant, string $key): ?int
	{
		$value = $this->metadata($variant, $key)['server_modified'] ?? null;
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
			if (!hash_update_stream($context, $stream))
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
		$limit = max(1, min(2000, $limit));
		if ($cursor !== null && ($cursor === '' || strlen($cursor) > 4096
			|| preg_match('/[\x00-\x1f\x7f]/', $cursor)))
		{
			throw new \InvalidArgumentException('The Dropbox continuation cursor is invalid.');
		}
		[$status, $data] = $cursor === null
			? $this->api('list_folder', [
				'path' => $this->configuration->variant_path($variant),
				'recursive' => true,
				'include_deleted' => false,
				'include_mounted_folders' => false,
				'limit' => $limit,
			], [200, 409])
			: $this->api('list_folder/continue', ['cursor' => $cursor], [200, 409]);
		if ($status === 409)
		{
			if ($this->is_not_found($data))
			{
				return ['keys' => [], 'cursor' => null];
			}
			$this->unexpected_status($status);
		}
		$entries = $data['entries'] ?? null;
		if (!is_array($entries) || count($entries) > 2000)
		{
			throw new \RuntimeException('Dropbox returned an invalid object page.');
		}
		$keys = [];
		foreach ($entries as $entry)
		{
			if (!is_array($entry) || ($entry['.tag'] ?? '') !== 'file')
			{
				continue;
			}
			$path = $entry['path_display'] ?? null;
			$key = is_string($path) ? $this->configuration->relative_key($variant, $path) : null;
			if ($key === null)
			{
				throw new \RuntimeException('Dropbox returned an invalid Gallery object key.');
			}
			$keys[] = $key;
		}
		$has_more = $data['has_more'] ?? false;
		$next = $data['cursor'] ?? null;
		if (!is_bool($has_more) || ($has_more && (!is_string($next) || $next === '')))
		{
			throw new \RuntimeException('Dropbox returned an invalid continuation cursor.');
		}

		return ['keys' => $keys, 'cursor' => $has_more ? $next : null];
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
		$path = $this->configuration->object_path($variant, $key);

		return $size <= $this->simple_upload_limit
			? $this->simple_upload($path, $local_file, $size, $create_only)
			: $this->session_upload($path, $local_file, $size, $create_only);
	}

	private function simple_upload(string $path, string $local_file, int $size, bool $create_only): bool
	{
		$body = fopen($local_file, 'rb');
		if ($body === false)
		{
			return false;
		}
		try
		{
			$response = $this->content('upload', $this->commit($path, $create_only), $body, [
				'Content-Length' => (string) $size,
				'Content-Type' => 'application/octet-stream',
			]);
		}
		finally
		{
			fclose($body);
		}
		if ($response->status() === 409)
		{
			$data = $this->response_json($response);
			if ($create_only && $this->is_conflict($data))
			{
				return false;
			}
		}
		if ($response->status() !== 200)
		{
			$this->unexpected_status($response->status());
		}

		return true;
	}

	private function session_upload(string $path, string $local_file, int $size, bool $create_only): bool
	{
		$empty = $this->memory_stream('');
		try
		{
			$start = $this->content('upload_session/start', ['close' => false], $empty, [
				'Content-Type' => 'application/octet-stream',
			]);
		}
		finally
		{
			fclose($empty);
		}
		if ($start->status() !== 200)
		{
			$this->unexpected_status($start->status());
		}
		$data = $this->response_json($start);
		$session_id = $data['session_id'] ?? null;
		if (!is_string($session_id) || $session_id === '' || strlen($session_id) > 4096)
		{
			throw new \RuntimeException('Dropbox returned an invalid upload session.');
		}

		$source = fopen($local_file, 'rb');
		if ($source === false)
		{
			return false;
		}
		$offset = 0;
		try
		{
			while ($offset < $size)
			{
				$length = min($this->chunk_size, $size - $offset);
				$chunk = $this->read_chunk($source, $length);
				$last = $offset + $length === $size;
				$arguments = [
					'cursor' => ['session_id' => $session_id, 'offset' => $offset],
				];
				if ($last)
				{
					$arguments['commit'] = $this->commit($path, $create_only);
				}
				else
				{
					$arguments['close'] = false;
				}
				try
				{
					$response = $this->content(
						$last ? 'upload_session/finish' : 'upload_session/append_v2',
						$arguments,
						$chunk,
						[
							'Content-Length' => (string) $length,
							'Content-Type' => 'application/octet-stream',
						]
					);
				}
				finally
				{
					fclose($chunk);
				}
				if ($response->status() === 409)
				{
					$error = $this->response_json($response);
					if ($last && $create_only && $this->is_conflict($error))
					{
						return false;
					}
				}
				if ($response->status() !== 200)
				{
					$this->unexpected_status($response->status());
				}
				$offset += $length;
			}
		}
		finally
		{
			fclose($source);
		}

		return true;
	}

	/** @return array<string, mixed>|null */
	private function metadata(string $variant, string $key): ?array
	{
		return $this->metadata_path($this->configuration->object_path($variant, $key));
	}

	/** @return array<string, mixed>|null */
	private function metadata_path(string $path): ?array
	{
		[$status, $data] = $this->api('get_metadata', [
			'path' => $path,
			'include_deleted' => false,
		], [200, 409]);
		if ($status === 409)
		{
			if ($this->is_not_found($data))
			{
				return null;
			}
			$this->unexpected_status($status);
		}

		return $data;
	}

	/** @return array{path: string, mode: string, autorename: bool, mute: bool, strict_conflict: bool} */
	private function commit(string $path, bool $create_only): array
	{
		return [
			'path' => $path,
			'mode' => $create_only ? 'add' : 'overwrite',
			'autorename' => false,
			'mute' => true,
			'strict_conflict' => true,
		];
	}

	/**
	 * @param array<string, mixed> $arguments
	 * @param list<int> $allowed
	 * @return array{int, array<string, mixed>}
	 */
	private function api(string $route, array $arguments, array $allowed): array
	{
		$json = $this->encode($arguments);
		$response = $this->authorized_request(
			'POST',
			self::API_ENDPOINT . $route,
			['Content-Type' => 'application/json'],
			static fn (): mixed => self::memory_stream_static($json)
		);
		if (!in_array($response->status(), $allowed, true))
		{
			$this->unexpected_status($response->status());
		}

		return [$response->status(), $this->response_json($response)];
	}

	/**
	 * @param array<string, mixed> $arguments
	 * @param resource|null $body
	 * @param array<string, string> $headers
	 */
	private function content(string $route, array $arguments, mixed $body, array $headers = []): response
	{
		$body_position = is_resource($body) ? ftell($body) : false;
		$headers['Dropbox-API-Arg'] = $this->encode($arguments);

		return $this->authorized_request(
			'POST',
			self::CONTENT_ENDPOINT . $route,
			$headers,
			static function () use ($body, $body_position): mixed
			{
				if (is_resource($body) && $body_position !== false)
				{
					fseek($body, $body_position);
				}

				return $body;
			},
			false
		);
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

		throw new \RuntimeException('Dropbox authorization failed.');
	}

	/** @return array<string, mixed> */
	private function response_json(response $response): array
	{
		$body = $response->detach_body();
		if (!is_resource($body))
		{
			throw new \RuntimeException('Dropbox returned no JSON response body.');
		}
		try
		{
			$json = stream_get_contents($body, self::MAX_JSON_RESPONSE + 1);
			if ($json === false || strlen($json) > self::MAX_JSON_RESPONSE || !feof($body))
			{
				throw new \RuntimeException('Dropbox exceeded the JSON response safety limit.');
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
			throw new \RuntimeException('Dropbox returned invalid JSON.', 0, $exception);
		}
		if (!is_array($data))
		{
			throw new \RuntimeException('Dropbox returned invalid JSON.');
		}

		return $data;
	}

	/** @param array<string, mixed> $data */
	private function is_not_found(array $data): bool
	{
		return str_contains((string) ($data['error_summary'] ?? ''), 'not_found');
	}

	/** @param array<string, mixed> $data */
	private function is_conflict(array $data): bool
	{
		return str_contains((string) ($data['error_summary'] ?? ''), 'conflict');
	}

	private function unexpected_status(int $status): never
	{
		throw new \RuntimeException('Dropbox returned HTTP status ' . $status . '.');
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
			throw new \RuntimeException('Could not encode a Dropbox request.', 0, $exception);
		}
	}

	/** @return resource */
	private function memory_stream(string $contents): mixed
	{
		return self::memory_stream_static($contents);
	}

	/** @return resource */
	private static function memory_stream_static(string $contents): mixed
	{
		$stream = fopen('php://temp', 'w+b');
		if ($stream === false || fwrite($stream, $contents) !== strlen($contents))
		{
			throw new \RuntimeException('Could not create a Dropbox request body.');
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
			throw new \RuntimeException('Could not create a Dropbox upload chunk.');
		}
		$copied = stream_copy_to_stream($source, $chunk, $length);
		if ($copied !== $length)
		{
			fclose($chunk);
			throw new \RuntimeException('Could not read the complete Dropbox upload chunk.');
		}
		rewind($chunk);

		return $chunk;
	}
}
