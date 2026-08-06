<?php
/**
 * phpBB Gallery - Remote Storage Add-on
 *
 * @package   phpbbgallery/remotestorage
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\remotestorage\koofr;

use phpbbgallery\core\storage\provider_interface;
use phpbbgallery\remotestorage\http\client_interface;
use phpbbgallery\remotestorage\http\response;

/** Private Koofr storage over its official TLS WebDAV endpoint. */
final class provider implements provider_interface
{
	private const MAX_XML_RESPONSE = 16777216;
	/** @var array<string, true> */
	private array $prepared_variants = [];
	private bool $root_prepared = false;

	public function __construct(private configuration $configuration, private client_interface $client)
	{
	}

	public function get_id(): string
	{
		return 'koofr';
	}

	public function prepare(string $variant, string $key): bool
	{
		$this->configuration->object_name($variant, $key);
		$this->prepare_variant($variant);

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
		$url = $this->configuration->object_url($variant, $key);
		$response = $this->client->request('GET', $url, $this->headers());
		if ($response->status() === 404)
		{
			return null;
		}
		if ($response->status() !== 200)
		{
			$this->unexpected_status($response->status(), 'download the Gallery object');
		}
		$body = $response->detach_body();
		if (!is_resource($body))
		{
			throw new \RuntimeException('Koofr returned no file content.');
		}

		return $body;
	}

	public function local_path(string $variant, string $key): ?string
	{
		return null;
	}

	public function exists(string $variant, string $key): bool
	{
		return $this->resource($variant, $key) !== null;
	}

	public function delete(string $variant, string $key): bool
	{
		$response = $this->client->request(
			'DELETE',
			$this->configuration->object_url($variant, $key),
			$this->headers(['If-Match' => '*'])
		);
		if (in_array($response->status(), [404, 412], true))
		{
			return false;
		}
		if (!in_array($response->status(), [200, 204], true))
		{
			$this->unexpected_status($response->status(), 'delete the Gallery object');
		}

		return true;
	}

	public function size(string $variant, string $key): ?int
	{
		return $this->resource($variant, $key)['size'] ?? null;
	}

	public function modified_time(string $variant, string $key): ?int
	{
		return $this->resource($variant, $key)['modified'] ?? null;
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
		$this->prepare_variant($variant);
		$offset = $this->decode_cursor($cursor);
		$limit = max(1, min(1000, $limit));
		$resources = $this->propfind($this->configuration->variant_url($variant), 1);
		$keys = [];
		foreach ($resources as $resource)
		{
			if ($resource['self'])
			{
				if (!$resource['collection'])
				{
					throw new \RuntimeException('The Koofr Gallery variant is not a folder.');
				}
				continue;
			}
			if ($resource['collection'])
			{
				throw new \RuntimeException('Koofr returned an unexpected nested Gallery folder.');
			}
			$key = $this->configuration->relative_key($variant, $resource['name']);
			if ($key === null)
			{
				throw new \RuntimeException('Koofr returned an invalid Gallery object name.');
			}
			$keys[] = $key;
		}
		sort($keys, SORT_STRING);
		if ($offset > count($keys))
		{
			throw new \RuntimeException('Koofr returned an inconsistent folder cursor.');
		}
		$selected = array_slice($keys, $offset, $limit);
		$next = $offset + count($selected);

		return [
			'keys' => $selected,
			'cursor' => $next < count($keys) ? 'o:' . $next : null,
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
		$this->prepare_variant($variant);
		$source = fopen($local_file, 'rb');
		if ($source === false)
		{
			return false;
		}
		try
		{
			$response = $this->client->request(
				'PUT',
				$this->configuration->object_url($variant, $key),
				$this->headers([
					'Content-Length' => (string) $size,
					'Content-Type' => 'application/octet-stream',
					$create_only ? 'If-None-Match' : 'If-Match' => '*',
				]),
				$source
			);
		}
		finally
		{
			fclose($source);
		}
		if (in_array($response->status(), [404, 409, 412], true))
		{
			return false;
		}
		if (!in_array($response->status(), [200, 201, 204], true))
		{
			$this->unexpected_status($response->status(), 'upload the Gallery object');
		}
		$resource = $this->resource($variant, $key);
		if ($resource === null || $resource['collection'] || $resource['size'] !== $size)
		{
			throw new \RuntimeException('Koofr did not persist the complete Gallery object.');
		}

		return true;
	}

	/** @return array{name: string, self: bool, collection: bool, size: int|null, modified: int|null, etag: string}|null */
	private function resource(string $variant, string $key): ?array
	{
		$url = $this->configuration->object_url($variant, $key);
		$resources = $this->propfind($url, 0, true);
		if ($resources === [])
		{
			return null;
		}
		if (count($resources) !== 1 || !$resources[0]['self'] || $resources[0]['collection'])
		{
			throw new \RuntimeException('Koofr returned invalid Gallery object metadata.');
		}

		return $resources[0];
	}

	private function prepare_variant(string $variant): void
	{
		$this->configuration->variant_url($variant);
		if (!$this->root_prepared)
		{
			$this->make_collection($this->configuration->root_url());
			$this->root_prepared = true;
		}
		if (!isset($this->prepared_variants[$variant]))
		{
			$this->make_collection($this->configuration->variant_url($variant));
			$this->prepared_variants[$variant] = true;
		}
	}

	private function make_collection(string $url): void
	{
		$response = $this->client->request('MKCOL', $url, $this->headers());
		if (!in_array($response->status(), [201, 405], true))
		{
			$this->unexpected_status($response->status(), 'create the Gallery folder');
		}
		$resources = $this->propfind($url, 0);
		if (count($resources) !== 1 || !$resources[0]['self'] || !$resources[0]['collection'])
		{
			throw new \RuntimeException('The configured Koofr Gallery path is not a folder.');
		}
	}

	/**
	 * @return list<array{name: string, self: bool, collection: bool, size: int|null, modified: int|null, etag: string}>
	 */
	private function propfind(string $url, int $depth, bool $missing_allowed = false): array
	{
		$request_body = $this->propfind_body();
		$body = $this->stream($request_body);
		try
		{
			$response = $this->client->request('PROPFIND', $url, $this->headers([
				'Content-Length' => (string) strlen($request_body),
				'Content-Type' => 'application/xml; charset=utf-8',
				'Depth' => (string) $depth,
			]), $body);
		}
		finally
		{
			fclose($body);
		}
		if ($missing_allowed && $response->status() === 404)
		{
			return [];
		}
		if ($response->status() !== 207)
		{
			$this->unexpected_status($response->status(), 'read Gallery WebDAV metadata');
		}

		return $this->parse_multistatus($response, $url, $depth);
	}

	private function propfind_body(): string
	{
		$quote = chr(39);

		return '<?xml version=' . $quote . '1.0' . $quote . ' encoding=' . $quote . 'utf-8' . $quote . '?>'
			. '<d:propfind xmlns:d=' . $quote . 'DAV:' . $quote . '><d:prop><d:resourcetype/>'
			. '<d:getcontentlength/><d:getlastmodified/><d:getetag/></d:prop></d:propfind>';
	}

	/**
	 * @return list<array{name: string, self: bool, collection: bool, size: int|null, modified: int|null, etag: string}>
	 */
	private function parse_multistatus(response $response, string $url, int $depth): array
	{
		$xml = $this->response_body($response);
		if (stripos($xml, '<!DOCTYPE') !== false || stripos($xml, '<!ENTITY') !== false)
		{
			throw new \RuntimeException('Koofr returned forbidden WebDAV XML declarations.');
		}
		$previous = libxml_use_internal_errors(true);
		try
		{
			$document = simplexml_load_string($xml, \SimpleXMLElement::class,
				LIBXML_NONET | LIBXML_NOBLANKS | LIBXML_COMPACT);
		}
		finally
		{
			libxml_clear_errors();
			libxml_use_internal_errors($previous);
		}
		if (!$document instanceof \SimpleXMLElement || $document->getName() !== 'multistatus')
		{
			throw new \RuntimeException('Koofr returned invalid WebDAV XML.');
		}
		$target = $this->url_path($url);
		$resources = [];
		$seen = [];
		foreach ($document->children('DAV:')->response as $node)
		{
			$dav = $node->children('DAV:');
			if (count($dav->href) !== 1)
			{
				throw new \RuntimeException('Koofr returned ambiguous WebDAV metadata.');
			}
			$path = $this->href_path((string) $dav->href);
			$self = $path === $target;
			if (!$self && ($depth !== 1 || !str_starts_with($path, $target . '/')))
			{
				throw new \RuntimeException('Koofr returned an object outside the requested Gallery folder.');
			}
			$name = $self ? '' : substr($path, strlen($target) + 1);
			if (!$self && ($name === '' || str_contains($name, '/')))
			{
				throw new \RuntimeException('Koofr returned an invalid nested Gallery path.');
			}
			$key = strtolower($path);
			if (isset($seen[$key]))
			{
				throw new \RuntimeException('Koofr returned duplicate WebDAV metadata.');
			}
			$seen[$key] = true;
			$properties = $this->successful_properties($dav);
			$collection = isset($properties['resourcetype'])
				&& count($properties['resourcetype']->children('DAV:')->collection) > 0;
			$size = $this->non_negative_integer((string) ($properties['getcontentlength'] ?? ''));
			$modified_value = (string) ($properties['getlastmodified'] ?? '');
			$modified = $modified_value === '' ? null : strtotime($modified_value);
			$etag = (string) ($properties['getetag'] ?? '');
			if (!$collection && ($size === null || $etag === '' || $modified === false))
			{
				throw new \RuntimeException('Koofr returned incomplete Gallery file metadata.');
			}
			$resources[] = [
				'name' => $name,
				'self' => $self,
				'collection' => $collection,
				'size' => $size,
				'modified' => $modified === false ? null : $modified,
				'etag' => $etag,
			];
			if (count($resources) > 100000)
			{
				throw new \RuntimeException('Koofr exceeded the Gallery folder entry limit.');
			}
		}
		if ($resources === [])
		{
			throw new \RuntimeException('Koofr returned no WebDAV metadata.');
		}

		return $resources;
	}

	/** @return array<string, \SimpleXMLElement> */
	private function successful_properties(\SimpleXMLElement $dav): array
	{
		$properties = [];
		foreach ($dav->propstat as $node)
		{
			$propstat = $node->children('DAV:');
			if (preg_match('/\s200\s/', (string) $propstat->status) !== 1)
			{
				continue;
			}
			foreach ($propstat->prop->children('DAV:') as $name => $value)
			{
				if (isset($properties[$name]))
				{
					throw new \RuntimeException('Koofr returned duplicate WebDAV properties.');
				}
				$properties[$name] = $value;
			}
		}
		if (!isset($properties['resourcetype']))
		{
			throw new \RuntimeException('Koofr returned no successful WebDAV properties.');
		}

		return $properties;
	}

	private function url_path(string $url): string
	{
		$parts = parse_url($url);
		if (!is_array($parts) || strtolower((string) ($parts['scheme'] ?? '')) !== 'https'
			|| strtolower((string) ($parts['host'] ?? '')) !== 'app.koofr.net'
			|| isset($parts['user']) || isset($parts['pass']) || isset($parts['port'])
			|| isset($parts['query']) || isset($parts['fragment']))
		{
			throw new \RuntimeException('The Koofr WebDAV URL is invalid.');
		}

		return $this->decoded_path((string) ($parts['path'] ?? ''));
	}

	private function href_path(string $href): string
	{
		$parts = parse_url($href);
		if (!is_array($parts))
		{
			throw new \RuntimeException('Koofr returned an invalid WebDAV href.');
		}
		if (isset($parts['host']) && (strtolower((string) ($parts['scheme'] ?? '')) !== 'https'
			|| strtolower((string) $parts['host']) !== 'app.koofr.net'))
		{
			throw new \RuntimeException('Koofr returned an external WebDAV href.');
		}
		if (isset($parts['user']) || isset($parts['pass']) || isset($parts['port'])
			|| isset($parts['query']) || isset($parts['fragment']))
		{
			throw new \RuntimeException('Koofr returned an invalid WebDAV href.');
		}

		return $this->decoded_path((string) ($parts['path'] ?? ''));
	}

	private function decoded_path(string $path): string
	{
		$decoded = rawurldecode($path);
		if ($path === '' || !str_starts_with($path, '/') || preg_match('/[\x00-\x1f\x7f]/', $path)
			|| preg_match('/[\x00-\x1f\x7f]/', $decoded) || str_contains($decoded, '//'))
		{
			throw new \RuntimeException('Koofr returned an invalid WebDAV path.');
		}

		return rtrim($decoded, '/');
	}

	private function non_negative_integer(string $value): ?int
	{
		if (preg_match('/^(?:0|[1-9][0-9]{0,18})$/D', $value) !== 1)
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
			throw new \InvalidArgumentException('The Koofr continuation cursor is invalid.');
		}

		return (int) $matches[1];
	}

	/** @param array<string, string> $extra @return array<string, string> */
	private function headers(array $extra = []): array
	{
		return ['Authorization' => $this->configuration->authorization()] + $extra;
	}

	private function response_body(response $response): string
	{
		$body = $response->detach_body();
		if (!is_resource($body))
		{
			throw new \RuntimeException('Koofr returned no WebDAV response body.');
		}
		try
		{
			$contents = stream_get_contents($body, self::MAX_XML_RESPONSE + 1);
			if ($contents === false || strlen($contents) > self::MAX_XML_RESPONSE || !feof($body))
			{
				throw new \RuntimeException('Koofr exceeded the WebDAV response safety limit.');
			}
		}
		finally
		{
			fclose($body);
		}

		return $contents;
	}

	/** @return resource */
	private function stream(string $contents): mixed
	{
		$stream = fopen('php://temp', 'w+b');
		if ($stream === false || fwrite($stream, $contents) !== strlen($contents))
		{
			throw new \RuntimeException('Could not create the Koofr WebDAV request body.');
		}
		rewind($stream);

		return $stream;
	}

	private function unexpected_status(int $status, string $operation): never
	{
		throw new \RuntimeException('Koofr could not ' . $operation . '. HTTP status ' . $status . '.');
	}
}
