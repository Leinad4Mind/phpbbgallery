<?php
/**
 * phpBB Gallery - Remote Storage Add-on
 *
 * @package   phpbbgallery/remotestorage
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\remotestorage\providers\fourshared;

use phpbbgallery\core\storage\provider_interface;

/** Private 4shared storage with verified folders and recoverable publication. */
final class provider implements provider_interface
{
	private const CHUNK_SIZE = 8388608;
	private const MAX_OBJECTS = 100000;
	private const PAGE_SIZE = 100;
	private const SIMPLE_UPLOAD_LIMIT = 157286400;
	/** @var array<string, string> */
	private array $variant_ids = [];
	/** @var array<string, mixed>|null */
	private ?array $user = null;
	private ?string $root_id = null;
	private int $chunk_size;
	private int $simple_upload_limit;

	public function __construct(
		private configuration $configuration,
		private api_client $api,
		private operation_lock $lock,
		int $simple_upload_limit = self::SIMPLE_UPLOAD_LIMIT,
		int $chunk_size = self::CHUNK_SIZE
	)
	{
		if ($simple_upload_limit < 1 || $simple_upload_limit > self::SIMPLE_UPLOAD_LIMIT
			|| $chunk_size < 1 || $chunk_size > 67108864)
		{
			throw new \InvalidArgumentException('The 4shared upload limits are invalid.');
		}
		$this->simple_upload_limit = $simple_upload_limit;
		$this->chunk_size = $chunk_size;
	}

	public function get_id(): string
	{
		return 'fourshared';
	}

	public function prepare(string $variant, string $key): bool
	{
		$this->configuration->object_name($variant, $key);
		$this->with_variant($variant, static fn (string $folder_id, array $files): bool => true);

		return true;
	}

	public function write(string $variant, string $key, string $local_file): bool
	{
		$local = $this->local_file($local_file);
		if ($local === null)
		{
			return false;
		}
		return $this->with_variant($variant, function (string $folder_id, array $files) use ($variant, $key, $local): bool
		{
			$target = $this->configuration->object_name($variant, $key);
			if ($this->named_file($files, $target) !== null)
			{
				return false;
			}
			$pending_name = $this->temporary_name('p', $target);
			$pending = $this->upload_private($folder_id, $pending_name, $local);
			try
			{
				$this->rename_file($pending, $target, $folder_id, $local);
			}
			catch (\Throwable $exception)
			{
				$this->safe_delete($this->file_id($pending));
				throw $exception;
			}

			return true;
		});
	}

	public function replace(string $variant, string $key, string $local_file): bool
	{
		$local = $this->local_file($local_file);
		if ($local === null)
		{
			return false;
		}
		return $this->with_variant($variant, function (string $folder_id, array $files) use ($variant, $key, $local): bool
		{
			$target = $this->configuration->object_name($variant, $key);
			$existing = $this->named_file($files, $target);
			if ($existing === null)
			{
				return false;
			}
			$pending = $this->upload_private($folder_id, $this->temporary_name('p', $target), $local);
			$backup_name = $this->temporary_name('b', $target);
			$backup = null;
			try
			{
				$backup = $this->rename_file($existing, $backup_name, $folder_id);
				$this->rename_file($pending, $target, $folder_id, $local);
			}
			catch (\Throwable $exception)
			{
				if (is_array($backup))
				{
					try
					{
						$this->rename_file($backup, $target, $folder_id);
					}
					catch (\Throwable)
					{
					}
				}
				$this->safe_delete($this->file_id($pending));
				throw $exception;
			}
			$this->delete_file_id($this->file_id($backup));

			return true;
		});
	}

	public function open_stream(string $variant, string $key): mixed
	{
		return $this->with_variant($variant, function (string $folder_id, array $files) use ($variant, $key): mixed
		{
			$file = $this->named_file($files, $this->configuration->object_name($variant, $key));
			if ($file === null)
			{
				return null;
			}
			$response = $this->api->request('GET', $this->configuration->api_url(
				'/files/' . rawurlencode($this->file_id($file)) . '/download'
			));
			if ($response->status() === 404)
			{
				return null;
			}
			if ($response->status() !== 200)
			{
				throw new \RuntimeException('4shared could not download the Gallery object. HTTP status '
					. $response->status() . '.');
			}
			$body = $response->detach_body();
			if (!is_resource($body))
			{
				throw new \RuntimeException('4shared returned no file content.');
			}

			return $body;
		});
	}

	public function local_path(string $variant, string $key): ?string
	{
		return null;
	}

	public function exists(string $variant, string $key): bool
	{
		return $this->with_variant($variant, fn (string $folder_id, array $files): bool =>
			$this->named_file($files, $this->configuration->object_name($variant, $key)) !== null);
	}

	public function delete(string $variant, string $key): bool
	{
		return $this->with_variant($variant, function (string $folder_id, array $files) use ($variant, $key): bool
		{
			$file = $this->named_file($files, $this->configuration->object_name($variant, $key));
			if ($file === null)
			{
				return false;
			}
			$this->delete_file_id($this->file_id($file));

			return true;
		});
	}

	public function size(string $variant, string $key): ?int
	{
		return $this->with_variant($variant, function (string $folder_id, array $files) use ($variant, $key): ?int
		{
			$file = $this->named_file($files, $this->configuration->object_name($variant, $key));

			return is_array($file) ? (int) $file['_size'] : null;
		});
	}

	public function modified_time(string $variant, string $key): ?int
	{
		return $this->with_variant($variant, function (string $folder_id, array $files) use ($variant, $key): ?int
		{
			$file = $this->named_file($files, $this->configuration->object_name($variant, $key));

			return is_array($file) ? (int) $file['_modified'] : null;
		});
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
		$offset = $this->decode_cursor($cursor);
		$limit = max(1, min(1000, $limit));

		return $this->with_variant($variant, function (string $folder_id, array $files) use ($variant, $offset, $limit): array
		{
			if ($offset > count($files))
			{
				throw new \RuntimeException('4shared returned an inconsistent folder cursor.');
			}
			$selected = array_slice($files, $offset, $limit);
			$keys = [];
			foreach ($selected as $file)
			{
				$key = $this->configuration->relative_key($variant, (string) $file['name']);
				if ($key === null)
				{
					throw new \RuntimeException('4shared returned an invalid Gallery object name.');
				}
				$keys[] = $key;
			}
			$next = $offset + count($selected);

			return ['keys' => $keys, 'cursor' => $next < count($files) ? 'o:' . $next : null];
		});
	}

	/** @param callable(string, list<array<string, mixed>>): mixed $operation */
	private function with_variant(string $variant, callable $operation): mixed
	{
		$this->configuration->object_name($variant, 'validation');

		return $this->lock->synchronized(function () use ($variant, $operation): mixed
		{
			$folder_id = $this->variant_folder_id($variant);
			$files = $this->reconcile_files($folder_id, $variant);

			return $operation($folder_id, $files);
		});
	}

	/** @return array{path: string, size: int, md5: string}|null */
	private function local_file(string $path): ?array
	{
		if (!is_file($path) || is_link($path) || !is_readable($path))
		{
			return null;
		}
		$size = filesize($path);
		$md5 = hash_file('md5', $path);
		if (!is_int($size) || $size < 1 || !is_string($md5))
		{
			return null;
		}

		return compact('path', 'size', 'md5');
	}

	/** @param array{path: string, size: int, md5: string} $local @return array<string, mixed> */
	private function upload_private(string $folder_id, string $name, array $local): array
	{
		$user = $this->user();
		if ($local['size'] > (int) $user['_upload_limit'] || $local['size'] > (int) $user['_free_space'])
		{
			throw new \RuntimeException('The 4shared account cannot accept the Gallery object size.');
		}
		$file = $local['size'] < $this->simple_upload_limit
			? $this->simple_upload($folder_id, $name, $local)
			: $this->chunked_upload($folder_id, $name, $local);
		$id = $this->file_id($file);
		try
		{
			$file = $this->api->json('PUT', $this->configuration->api_url('/files/' . rawurlencode($id)), [], [
				'ownerOnly' => 'true',
			]);

			return $this->validated_file($file, $folder_id, $name, $local);
		}
		catch (\Throwable $exception)
		{
			$this->safe_delete($id);
			throw $exception;
		}
	}

	/** @param array{path: string, size: int, md5: string} $local @return array<string, mixed> */
	private function simple_upload(string $folder_id, string $name, array $local): array
	{
		$source = fopen($local['path'], 'rb');
		if ($source === false)
		{
			throw new \RuntimeException('Could not open the Gallery object for 4shared upload.');
		}
		try
		{
			return $this->api->json('POST', $this->configuration->upload_url('/files'), [
				'folderId' => $folder_id,
				'fileName' => $name,
			], [], [
				'Content-Length' => (string) $local['size'],
				'Content-Type' => 'application/octet-stream',
			], $source);
		}
		finally
		{
			fclose($source);
		}
	}

	/** @param array{path: string, size: int, md5: string} $local @return array<string, mixed> */
	private function chunked_upload(string $folder_id, string $name, array $local): array
	{
		$file = $this->api->json('POST', $this->configuration->upload_url('/upload'), [], [
			'name' => $name,
			'folderId' => $folder_id,
			'size' => (string) $local['size'],
		]);
		$id = $this->file_id($file);
		$source = fopen($local['path'], 'rb');
		if ($source === false)
		{
			$this->safe_delete($id);
			throw new \RuntimeException('Could not open the Gallery object for chunked 4shared upload.');
		}
		try
		{
			for ($offset = 0; $offset < $local['size']; $offset += $this->chunk_size)
			{
				$length = min($this->chunk_size, $local['size'] - $offset);
				$chunk = $this->chunk($source, $length);
				try
				{
					$response = $this->api->request('POST', $this->configuration->upload_url(
						'/upload/' . rawurlencode($id)
					), [], [], [
						'Content-Length' => (string) $length,
						'Content-Range' => 'bytes ' . $offset . '-' . ($offset + $length - 1) . '/' . $local['size'],
						'Content-Type' => 'application/octet-stream',
					], $chunk);
				}
				finally
				{
					fclose($chunk);
				}
				$final = $offset + $length === $local['size'];
				if (($final && $response->status() !== 201)
					|| (!$final && !in_array($response->status(), [200, 308], true)))
				{
					throw new \RuntimeException('4shared rejected a Gallery upload chunk. HTTP status '
						. $response->status() . '.');
				}
			}
		}
		catch (\Throwable $exception)
		{
			$this->safe_delete($id);
			throw $exception;
		}
		finally
		{
			fclose($source);
		}

		return $this->api->json('GET', $this->configuration->api_url('/files/' . rawurlencode($id)));
	}

	/** @param resource $source @return resource */
	private function chunk(mixed $source, int $length): mixed
	{
		$chunk = fopen('php://temp/maxmemory:' . $this->chunk_size, 'w+b');
		if ($chunk === false || stream_copy_to_stream($source, $chunk, $length) !== $length)
		{
			if (is_resource($chunk))
			{
				fclose($chunk);
			}
			throw new \RuntimeException('Could not read a complete 4shared upload chunk.');
		}
		rewind($chunk);

		return $chunk;
	}

	/** @param array<string, mixed> $file @param array{path: string, size: int, md5: string}|null $local @return array<string, mixed> */
	private function rename_file(array $file, string $name, string $folder_id, ?array $local = null): array
	{
		$id = $this->file_id($file);
		$renamed = $this->api->json('PUT', $this->configuration->api_url('/files/' . rawurlencode($id)), [], [
			'name' => $name,
			'ownerOnly' => 'true',
		]);

		return $this->validated_file($renamed, $folder_id, $name, $local);
	}

	/** @return list<array<string, mixed>> */
	private function reconcile_files(string $folder_id, string $variant): array
	{
		$files = $this->folder_files($folder_id);
		$regular = [];
		$temporary = [];
		foreach ($files as $file)
		{
			$name = (string) $file['name'];
			if ($this->configuration->relative_key($variant, $name) !== null)
			{
				if (isset($regular[$name]))
				{
					throw new \RuntimeException('4shared returned duplicate Gallery objects.');
				}
				$regular[$name] = $file;
				continue;
			}
			if (preg_match('/^([pb])_[a-f0-9]{32}_(g_[a-f0-9]+)$/D', $name, $matches) !== 1
				|| $this->configuration->relative_key($variant, $matches[2]) === null)
			{
				throw new \RuntimeException('4shared returned an unexpected Gallery folder object.');
			}
			$type = $matches[1];
			$target = $matches[2];
			if (isset($temporary[$target][$type]))
			{
				throw new \RuntimeException('4shared returned ambiguous recovery objects.');
			}
			$temporary[$target][$type] = $file;
		}
		foreach ($temporary as $target => $operations)
		{
			if (isset($regular[$target]))
			{
				foreach ($operations as $file)
				{
					$this->delete_file_id($this->file_id($file));
				}
				continue;
			}
			if (isset($operations['p']))
			{
				$regular[$target] = $this->rename_file($operations['p'], $target, $folder_id);
				if (isset($operations['b']))
				{
					$this->delete_file_id($this->file_id($operations['b']));
				}
				continue;
			}
			$regular[$target] = $this->rename_file($operations['b'], $target, $folder_id);
		}
		ksort($regular, SORT_STRING);

		return array_values($regular);
	}

	/** @return list<array<string, mixed>> */
	private function folder_files(string $folder_id): array
	{
		$files = [];
		for ($offset = 0;; $offset += self::PAGE_SIZE)
		{
			$data = $this->api->json('GET', $this->configuration->api_url(
				'/folders/' . rawurlencode($folder_id) . '/files'
			), ['offset' => $offset, 'limit' => self::PAGE_SIZE]);
			$page = $data['files'] ?? null;
			if (!is_array($page) || !array_is_list($page) || count($page) > self::PAGE_SIZE)
			{
				throw new \RuntimeException('4shared returned an invalid Gallery file listing.');
			}
			foreach ($page as $file)
			{
				if (!is_array($file))
				{
					throw new \RuntimeException('4shared returned invalid Gallery file metadata.');
				}
				$files[] = $this->validated_file($file, $folder_id);
				if (count($files) > self::MAX_OBJECTS)
				{
					throw new \RuntimeException('4shared exceeded the Gallery folder entry limit.');
				}
			}
			if (count($page) < self::PAGE_SIZE)
			{
				break;
			}
		}

		return $files;
	}

	/** @param list<array<string, mixed>> $files @return array<string, mixed>|null */
	private function named_file(array $files, string $name): ?array
	{
		$found = null;
		foreach ($files as $file)
		{
			if (strcasecmp((string) $file['name'], $name) !== 0)
			{
				continue;
			}
			if ($found !== null)
			{
				throw new \RuntimeException('4shared returned an ambiguous Gallery object.');
			}
			$found = $file;
		}

		return $found;
	}

	private function variant_folder_id(string $variant): string
	{
		if (!isset($this->variant_ids[$variant]))
		{
			$this->variant_ids[$variant] = $this->private_folder($variant, $this->root_folder_id());
		}

		return $this->variant_ids[$variant];
	}

	private function root_folder_id(): string
	{
		if ($this->root_id === null)
		{
			$this->root_id = $this->private_folder($this->configuration->root_name(),
				(string) $this->user()['_root_id']);
		}

		return $this->root_id;
	}

	private function private_folder(string $name, string $parent_id): string
	{
		$found = null;
		foreach ($this->child_folders($parent_id) as $folder)
		{
			if (strcasecmp((string) ($folder['name'] ?? ''), $name) !== 0)
			{
				continue;
			}
			if ($found !== null)
			{
				throw new \RuntimeException('4shared returned an ambiguous Gallery folder.');
			}
			$found = $folder;
		}
		if ($found === null)
		{
			$found = $this->api->json('POST', $this->configuration->api_url('/folders'), [], [
				'parentId' => $parent_id,
				'name' => $name,
			]);
		}
		$id = $this->configuration->id($found['id'] ?? null);
		$found = $this->api->json('PUT', $this->configuration->api_url('/folders/' . rawurlencode($id)), [], [
			'access' => 'private',
		]);
		$this->assert_private_folder($found, $id, $parent_id, $name);

		return $id;
	}

	/** @return list<array<string, mixed>> */
	private function child_folders(string $parent_id): array
	{
		$folders = [];
		for ($offset = 0;; $offset += self::PAGE_SIZE)
		{
			$data = $this->api->json('GET', $this->configuration->api_url(
				'/folders/' . rawurlencode($parent_id) . '/children'
			), ['offset' => $offset, 'limit' => self::PAGE_SIZE]);
			$page = $data['folders'] ?? null;
			if (!is_array($page) || !array_is_list($page) || count($page) > self::PAGE_SIZE)
			{
				throw new \RuntimeException('4shared returned an invalid Gallery folder listing.');
			}
			foreach ($page as $folder)
			{
				if (!is_array($folder))
				{
					throw new \RuntimeException('4shared returned invalid folder metadata.');
				}
				$this->configuration->id($folder['id'] ?? null);
				$folders[] = $folder;
				if (count($folders) > self::MAX_OBJECTS)
				{
					throw new \RuntimeException('4shared exceeded the folder entry limit.');
				}
			}
			if (count($page) < self::PAGE_SIZE)
			{
				break;
			}
		}

		return $folders;
	}

	/** @return array<string, mixed> */
	private function user(): array
	{
		if ($this->user !== null)
		{
			return $this->user;
		}
		$user = $this->api->json('GET', $this->configuration->api_url('/user'));
		$id = $this->configuration->id($user['id'] ?? null);
		$root_id = $this->configuration->id($user['rootFolderId'] ?? null);
		$status = $user['status'] ?? null;
		$free_space = $this->non_negative_integer($user['freeSpace'] ?? null);
		$upload_limit = $this->non_negative_integer($user['uploadSizeLimit'] ?? null);
		if (($user['verified'] ?? null) !== true || !in_array($status, [null, 'active', 'trial'], true)
			|| $free_space === null || $upload_limit === null || $upload_limit < 1)
		{
			throw new \RuntimeException('The configured 4shared account is not active and verified.');
		}
		$user['_id'] = $id;
		$user['_root_id'] = $root_id;
		$user['_free_space'] = $free_space;
		$user['_upload_limit'] = $upload_limit;
		$this->user = $user;

		return $user;
	}

	/** @param array<string, mixed> $folder */
	private function assert_private_folder(array $folder, string $id, string $parent_id, string $name): void
	{
		if ($this->configuration->id($folder['id'] ?? null) !== $id
			|| $this->configuration->id($folder['parentId'] ?? null) !== $parent_id
			|| (string) ($folder['name'] ?? '') !== $name
			|| $this->configuration->id($folder['ownerId'] ?? null) !== (string) $this->user()['_id']
			|| ($folder['access'] ?? null) !== 'private' || ($folder['userPermissions'] ?? null) !== 'owner'
			|| ($folder['hasMembers'] ?? null) !== false || ($folder['status'] ?? null) !== 'normal')
		{
			throw new \RuntimeException('The configured 4shared Gallery folder is not private and exclusively owned.');
		}
	}

	/**
	 * @param array<string, mixed> $file
	 * @param array{path: string, size: int, md5: string}|null $local
	 * @return array<string, mixed>
	 */
	private function validated_file(array $file, string $folder_id, ?string $name = null, ?array $local = null): array
	{
		$this->file_id($file);
		$size = $this->non_negative_integer($file['size'] ?? null);
		$modified_value = $file['modified'] ?? null;
		$modified = is_string($modified_value) ? strtotime($modified_value) : false;
		$md5 = strtolower((string) ($file['md5'] ?? ''));
		$virus = strtolower((string) ($file['virusScanResult'] ?? ''));
		if ($this->configuration->id($file['parentId'] ?? null) !== $folder_id
			|| $this->configuration->id($file['ownerId'] ?? null) !== (string) $this->user()['_id']
			|| ($file['ownerOnly'] ?? null) !== true || ($file['status'] ?? null) !== 'normal'
			|| $size === null || $modified === false || preg_match('/^[a-f0-9]{32}$/D', $md5) !== 1
			|| ($name !== null && (string) ($file['name'] ?? '') !== $name)
			|| ($local !== null && ($size !== $local['size'] || !hash_equals($local['md5'], $md5)))
			|| in_array($virus, ['infected', 'virus', 'malware'], true))
		{
			throw new \RuntimeException('4shared returned invalid or non-private Gallery file metadata.');
		}
		$file['_size'] = $size;
		$file['_modified'] = $modified;
		$file['_md5'] = $md5;

		return $file;
	}

	/** @param array<string, mixed> $file */
	private function file_id(array $file): string
	{
		return $this->configuration->id($file['id'] ?? null);
	}

	private function delete_file_id(string $id): void
	{
		$response = $this->api->request('DELETE', $this->configuration->api_url(
			'/files/' . rawurlencode($this->configuration->id($id))
		));
		if (!in_array($response->status(), [204, 404], true))
		{
			throw new \RuntimeException('4shared could not delete the Gallery object. HTTP status '
				. $response->status() . '.');
		}
	}

	private function safe_delete(string $id): void
	{
		try
		{
			$this->delete_file_id($id);
		}
		catch (\Throwable)
		{
		}
	}

	private function temporary_name(string $type, string $target): string
	{
		return $type . '_' . bin2hex(random_bytes(16)) . '_' . $target;
	}

	private function non_negative_integer(mixed $value): ?int
	{
		if ((!is_int($value) && (!is_string($value) || preg_match('/^(?:0|[1-9][0-9]{0,18})$/D', $value) !== 1)))
		{
			return null;
		}
		$integer = (int) $value;

		return $integer >= 0 ? $integer : null;
	}

	private function decode_cursor(?string $cursor): int
	{
		if ($cursor === null)
		{
			return 0;
		}
		if (preg_match('/^o:([1-9][0-9]{0,8})$/D', $cursor, $matches) !== 1)
		{
			throw new \InvalidArgumentException('The 4shared continuation cursor is invalid.');
		}

		return (int) $matches[1];
	}
}
