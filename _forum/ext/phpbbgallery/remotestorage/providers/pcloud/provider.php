<?php
/**
 * phpBB Gallery - Remote Storage Add-on
 *
 * @package   phpbbgallery/remotestorage
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\remotestorage\providers\pcloud;

use phpbbgallery\core\storage\provider_interface;
use phpbbgallery\remotestorage\http\client_interface;

/** Private pCloud storage using OAuth and dedicated owned folders. */
final class provider implements provider_interface
{
	/** @var array<string, string> */
	private array $variant_ids = [];
	private ?string $root_id = null;
	/** @var array{files: array<string, true>, folders: array<string, true>}|null */
	private ?array $public_ids = null;

	public function __construct(
		private configuration $configuration,
		private api_client $api,
		private client_interface $client
	)
	{
	}

	public function get_id(): string
	{
		return 'pcloud';
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
		$data = $this->api->call('getfilelink', [
			'fileid' => $this->file_id($file),
			'skipfilename' => 1,
		]);
		$this->require_success($data, 'pCloud could not create a private download link.');
		$hosts = $data['hosts'] ?? null;
		$path = (string) ($data['path'] ?? '');
		if (!is_array($hosts) || $hosts === [] || count($hosts) > 64)
		{
			throw new \RuntimeException('pCloud returned invalid private download metadata.');
		}
		$url = 'https://' . $this->content_host((string) $hosts[0]) . $this->content_path($path);
		for ($attempt = 0; $attempt < 4; $attempt++)
		{
			$response = $this->client->request('GET', $url);
			if ($response->status() === 200)
			{
				$body = $response->detach_body();
				if (!is_resource($body))
				{
					throw new \RuntimeException('pCloud returned no file content.');
				}

				return $body;
			}
			if (!in_array($response->status(), [301, 302, 303, 307, 308], true))
			{
				throw new \RuntimeException('pCloud download returned HTTP status '
					. $response->status() . '.');
			}
			$url = $this->redirect_url((string) ($response->header('location') ?? ''));
		}

		throw new \RuntimeException('pCloud exceeded the private download redirect limit.');
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
		$data = $this->api->call('deletefile', ['fileid' => $this->file_id($file)]);
		if ((int) ($data['result'] ?? -1) !== 0 && (int) ($data['result'] ?? -1) !== 2009)
		{
			$this->require_success($data, 'pCloud could not delete the Gallery object.');
		}

		return true;
	}

	public function size(string $variant, string $key): ?int
	{
		$file = $this->find_object($variant, $key);
		$value = is_array($file) ? ($file['size'] ?? null) : null;
		if ((!is_int($value) && (!is_string($value) || preg_match('/^[0-9]+$/D', $value) !== 1))
			|| (int) $value < 0)
		{
			return null;
		}

		return (int) $value;
	}

	public function modified_time(string $variant, string $key): ?int
	{
		$file = $this->find_object($variant, $key);
		$value = is_array($file) ? ($file['modified'] ?? null) : null;
		if (is_int($value) && $value >= 0)
		{
			return $value;
		}
		if (is_string($value) && preg_match('/^[0-9]{1,12}$/D', $value) === 1)
		{
			return (int) $value;
		}

		return null;
	}

	public function checksum(string $variant, string $key, string $algorithm = 'sha256'): ?string
	{
		if ($algorithm !== 'sha256')
		{
			return null;
		}
		$file = $this->find_object($variant, $key);
		if ($file === null)
		{
			return null;
		}
		$data = $this->api->call('checksumfile', ['fileid' => $this->file_id($file)]);
		$this->require_success($data, 'pCloud could not checksum the Gallery object.');
		$hash = strtolower((string) ($data['sha256'] ?? ''));
		if (preg_match('/^[a-f0-9]{64}$/D', $hash) === 1)
		{
			return $hash;
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
		$offset = $this->decode_cursor($cursor);
		$limit = max(1, min(1000, $limit));
		$files = $this->folder_files($this->variant_folder_id($variant));
		if ($offset > count($files))
		{
			throw new \RuntimeException('pCloud returned an inconsistent folder cursor.');
		}
		$selected = array_slice($files, $offset, $limit);
		$keys = [];
		foreach ($selected as $file)
		{
			$key = $this->configuration->relative_key($variant, (string) ($file['name'] ?? ''));
			if ($key === null)
			{
				throw new \RuntimeException('pCloud returned an invalid Gallery object name.');
			}
			$keys[] = $key;
		}
		$next_offset = $offset + count($selected);

		return [
			'keys' => $keys,
			'cursor' => $next_offset < count($files) ? 'o:' . $next_offset : null,
		];
	}

	private function upload(string $variant, string $key, string $local_file, bool $create_only): bool
	{
		if (!is_file($local_file) || is_link($local_file) || !is_readable($local_file))
		{
			return false;
		}
		$size = filesize($local_file);
		if (!is_int($size) || $size < 1)
		{
			return false;
		}
		$name = $this->configuration->object_name($variant, $key);
		$existing = $this->find_object($variant, $key);
		if (($create_only && $existing !== null) || (!$create_only && $existing === null))
		{
			return false;
		}
		$source = fopen($local_file, 'rb');
		if ($source === false)
		{
			return false;
		}
		try
		{
			$parameters = [
				'filename' => $name,
				'folderid' => $this->variant_folder_id($variant),
				'nopartial' => 1,
				'timeformat' => 'timestamp',
			];
			if ($create_only)
			{
				$parameters['renameifexists'] = 1;
			}
			$data = $this->api->call('uploadfile', $parameters, 'PUT', [
				'Content-Length' => (string) $size,
				'Content-Type' => 'application/octet-stream',
			], $source);
		}
		finally
		{
			fclose($source);
		}
		$this->require_success($data, 'pCloud could not upload the Gallery object.');
		$metadata = $data['metadata'] ?? null;
		$file = is_array($metadata) ? ($metadata[0] ?? null) : null;
		if (!is_array($file) || count($metadata) !== 1)
		{
			throw new \RuntimeException('pCloud returned invalid upload metadata.');
		}
		$this->assert_private_file($file);
		$uploaded_id = $this->file_id($file);
		if ((string) ($file['name'] ?? '') !== $name
			|| (!$create_only && is_array($existing) && $uploaded_id !== $this->file_id($existing)))
		{
			$this->delete_file_id($uploaded_id);

			return false;
		}

		return true;
	}

	/** @return array<string, mixed>|null */
	private function find_object(string $variant, string $key): ?array
	{
		$name = $this->configuration->object_name($variant, $key);
		$found = null;
		foreach ($this->folder_files($this->variant_folder_id($variant)) as $file)
		{
			if (strcasecmp((string) ($file['name'] ?? ''), $name) !== 0)
			{
				continue;
			}
			if ($found !== null)
			{
				throw new \RuntimeException('pCloud returned an ambiguous Gallery object.');
			}
			$found = $file;
		}

		return $found;
	}

	/** @return list<array<string, mixed>> */
	private function folder_files(string $folder_id): array
	{
		$data = $this->api->call('listfolder', [
			'folderid' => $folder_id,
			'noshares' => 1,
			'timeformat' => 'timestamp',
		]);
		$this->require_success($data, 'pCloud could not enumerate the Gallery folder.');
		$metadata = $data['metadata'] ?? null;
		$contents = is_array($metadata) ? ($metadata['contents'] ?? null) : null;
		if (!is_array($metadata) || !is_array($contents) || count($contents) > 100000)
		{
			throw new \RuntimeException('pCloud returned an invalid folder listing.');
		}
		$this->assert_private_folder($metadata, $folder_id);
		$files = [];
		foreach ($contents as $item)
		{
			if (!is_array($item) || ($item['isfolder'] ?? null) !== false)
			{
				throw new \RuntimeException('pCloud returned an unexpected Gallery folder object.');
			}
			$this->assert_private_file($item);
			$files[] = $item;
		}
		usort($files, static fn (array $left, array $right): int => strcmp(
			(string) ($left['name'] ?? ''),
			(string) ($right['name'] ?? '')
		));

		return $files;
	}

	private function variant_folder_id(string $variant): string
	{
		$name = $this->configuration->variant_name($variant);
		if (!isset($this->variant_ids[$name]))
		{
			$this->variant_ids[$name] = $this->create_private_folder($name, $this->root_folder_id());
		}

		return $this->variant_ids[$name];
	}

	private function root_folder_id(): string
	{
		if ($this->root_id === null)
		{
			$this->root_id = $this->create_private_folder($this->configuration->root_name(), '0');
		}

		return $this->root_id;
	}

	private function create_private_folder(string $name, string $parent_id): string
	{
		$data = $this->api->call('createfolderifnotexists', [
			'folderid' => $this->configuration->id($parent_id, true),
			'name' => $name,
			'timeformat' => 'timestamp',
		]);
		$this->require_success($data, 'pCloud could not create the Gallery folder.');
		$metadata = $data['metadata'] ?? null;
		if (!is_array($metadata) || (string) ($metadata['name'] ?? '') !== $name)
		{
			throw new \RuntimeException('pCloud returned invalid Gallery folder metadata.');
		}
		$id = $this->configuration->id($metadata['folderid'] ?? null);
		$this->assert_private_folder($metadata, $id);

		return $id;
	}

	/** @param array<string, mixed> $folder */
	private function assert_private_folder(array $folder, string $expected_id): void
	{
		$id = $this->configuration->id($folder['folderid'] ?? null);
		if ($id !== $expected_id || ($folder['isfolder'] ?? null) !== true
			|| ($folder['ismine'] ?? null) !== true || ($folder['isshared'] ?? null) !== false
			|| isset($this->public_object_ids()['folders'][$id]))
		{
			throw new \RuntimeException('The configured pCloud Gallery folder is not private and exclusively owned.');
		}
	}

	/** @param array<string, mixed> $file */
	private function assert_private_file(array $file): void
	{
		$id = $this->file_id($file);
		if (($file['isfolder'] ?? null) !== false || ($file['ismine'] ?? null) !== true
			|| ($file['isshared'] ?? null) !== false || isset($this->public_object_ids()['files'][$id]))
		{
			throw new \RuntimeException('The pCloud Gallery object is not private and exclusively owned.');
		}
	}

	/** @return array{files: array<string, true>, folders: array<string, true>} */
	private function public_object_ids(): array
	{
		if ($this->public_ids !== null)
		{
			return $this->public_ids;
		}
		$data = $this->api->call('listpublinks');
		$this->require_success($data, 'pCloud could not verify private Gallery storage.');
		$links = $data['publinks'] ?? null;
		if (!is_array($links) || count($links) > 100000)
		{
			throw new \RuntimeException('pCloud returned an invalid public-link listing.');
		}
		$this->public_ids = ['files' => [], 'folders' => []];
		foreach ($links as $link)
		{
			$metadata = is_array($link) ? ($link['metadata'] ?? null) : null;
			if (!is_array($metadata) || !is_bool($metadata['isfolder'] ?? null))
			{
				throw new \RuntimeException('pCloud returned invalid public-link metadata.');
			}
			$type = $metadata['isfolder'] ? 'folders' : 'files';
			$field = $metadata['isfolder'] ? 'folderid' : 'fileid';
			$this->public_ids[$type][$this->configuration->id($metadata[$field] ?? null)] = true;
		}

		return $this->public_ids;
	}

	/** @param array<string, mixed> $file */
	private function file_id(array $file): string
	{
		return $this->configuration->id($file['fileid'] ?? null);
	}

	private function delete_file_id(string $file_id): void
	{
		$data = $this->api->call('deletefile', ['fileid' => $this->configuration->id($file_id)]);
		$this->require_success($data, 'pCloud could not remove a conflicting upload.');
	}

	private function decode_cursor(?string $cursor): int
	{
		if ($cursor === null)
		{
			return 0;
		}
		if (preg_match('/^o:([1-9][0-9]{0,8})$/D', $cursor, $matches) !== 1)
		{
			throw new \InvalidArgumentException('The pCloud continuation cursor is invalid.');
		}

		return (int) $matches[1];
	}

	private function content_host(string $host): string
	{
		$host = strtolower($host);
		if (preg_match('/^[a-z][0-9]+\.pcloud\.com$/D', $host) !== 1)
		{
			throw new \RuntimeException('pCloud returned an invalid private download host.');
		}

		return $host;
	}

	private function content_path(string $path): string
	{
		$decoded = rawurldecode($path);
		if ($path === '' || !str_starts_with($path, '/') || str_starts_with($path, '//')
			|| preg_match('/[\x00-\x1f\x7f]/', $path)
			|| preg_match('/[\x00-\x1f\x7f]/', $decoded))
		{
			throw new \RuntimeException('pCloud returned an invalid private download path.');
		}

		return $path;
	}

	private function redirect_url(string $url): string
	{
		$parts = parse_url($url);
		if (!is_array($parts))
		{
			throw new \RuntimeException('pCloud returned an invalid private download redirect.');
		}
		$host = $this->content_host((string) ($parts['host'] ?? ''));
		$path = (string) ($parts['path'] ?? '');
		$query = isset($parts['query']) ? '?' . (string) $parts['query'] : '';
		if (strtolower((string) ($parts['scheme'] ?? '')) !== 'https'
			|| isset($parts['user']) || isset($parts['pass']) || isset($parts['port']) || isset($parts['fragment']))
		{
			throw new \RuntimeException('pCloud returned an invalid private download redirect.');
		}

		return 'https://' . $host . $this->content_path($path . $query);
	}

	/** @param array<string, mixed> $data */
	private function require_success(array $data, string $message): void
	{
		if ((int) ($data['result'] ?? -1) !== 0)
		{
			$result = (int) ($data['result'] ?? -1);
			throw new \RuntimeException($message . ($result > 0 ? ' Error ' . $result . '.' : ''));
		}
	}
}
