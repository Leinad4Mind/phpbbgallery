<?php
/**
 * phpBB Gallery - Remote Storage Add-on
 *
 * @package   phpbbgallery/remotestorage
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\remotestorage\providers\s3;

use phpbbgallery\core\storage\provider_interface;
use phpbbgallery\remotestorage\http\client_interface;
use phpbbgallery\remotestorage\http\response;

/** Private path-style S3/S3-compatible Gallery storage provider. */
final class provider implements provider_interface
{
	private const EMPTY_HASH = 'e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855';
	private const MAX_LIST_RESPONSE = 8388608;

	private configuration $configuration;
	private signer $signer;
	private client_interface $client;
	private \Closure $clock;

	public function __construct(
		configuration $configuration,
		signer $signer,
		client_interface $client,
		?\Closure $clock = null
	)
	{
		$this->configuration = $configuration;
		$this->signer = $signer;
		$this->client = $client;
		$this->clock = $clock ?? static fn (): \DateTimeImmutable => new \DateTimeImmutable('now', new \DateTimeZone('UTC'));
	}

	public function get_id(): string
	{
		return 's3';
	}

	public function prepare(string $variant, string $key): bool
	{
		$this->configuration->object_key($variant, $key);

		return true;
	}

	public function write(string $variant, string $key, string $local_file): bool
	{
		return $this->put($variant, $key, $local_file, true);
	}

	public function replace(string $variant, string $key, string $local_file): bool
	{
		if (!$this->exists($variant, $key))
		{
			return false;
		}

		return $this->put($variant, $key, $local_file, false);
	}

	public function open_stream(string $variant, string $key): mixed
	{
		$response = $this->request('GET', $this->configuration->object_url($variant, $key));
		if ($response->status() === 404)
		{
			return false;
		}
		$this->require_status($response, [200]);
		$body = $response->detach_body();
		if (!is_resource($body))
		{
			throw new \RuntimeException('The S3 object response has no readable body.');
		}

		return $body;
	}

	public function local_path(string $variant, string $key): ?string
	{
		$this->configuration->object_key($variant, $key);

		return null;
	}

	public function exists(string $variant, string $key): bool
	{
		return $this->metadata($variant, $key) !== null;
	}

	public function delete(string $variant, string $key): bool
	{
		$response = $this->request('DELETE', $this->configuration->object_url($variant, $key));
		$this->require_status($response, [200, 204, 404]);

		return true;
	}

	public function size(string $variant, string $key): ?int
	{
		$response = $this->metadata($variant, $key);
		if ($response === null)
		{
			return null;
		}
		$value = $response->header('content-length');

		return is_string($value) && preg_match('/^[0-9]+$/D', $value) ? (int) $value : null;
	}

	public function modified_time(string $variant, string $key): ?int
	{
		$response = $this->metadata($variant, $key);
		$value = $response?->header('last-modified');
		$timestamp = $value === null ? false : strtotime($value);

		return $timestamp === false ? null : $timestamp;
	}

	public function checksum(string $variant, string $key, string $algorithm = 'sha256'): ?string
	{
		if ($algorithm !== 'sha256')
		{
			return null;
		}
		$response = $this->metadata($variant, $key);
		$value = strtolower((string) ($response?->header('x-amz-meta-sha256') ?? ''));

		return preg_match('/^[a-f0-9]{64}$/D', $value) ? $value : null;
	}

	public function list_objects(string $variant, ?string $cursor = null, int $limit = 500): array
	{
		$limit = max(1, min(1000, $limit));
		$query = [
			'list-type' => 2,
			'prefix' => $this->configuration->variant_prefix($variant),
			'max-keys' => $limit,
		];
		if ($cursor !== null)
		{
			if ($cursor === '' || strlen($cursor) > 4096 || preg_match('/[\x00-\x1f\x7f]/', $cursor))
			{
				throw new \InvalidArgumentException('The S3 continuation cursor is invalid.');
			}
			$query['continuation-token'] = $cursor;
		}

		$response = $this->request('GET', $this->configuration->bucket_url($query));
		$this->require_status($response, [200]);
		$xml = $this->parse_list_response($this->response_body($response));
		$keys = [];
		foreach ($xml->Contents as $content)
		{
			$key = $this->configuration->relative_key($variant, (string) $content->Key);
			if ($key === null)
			{
				throw new \RuntimeException('The S3 provider returned an invalid Gallery object key.');
			}
			$keys[] = $key;
		}
		if (count($keys) > $limit)
		{
			throw new \RuntimeException('The S3 provider exceeded the requested object page size.');
		}

		$truncated = strtolower((string) $xml->IsTruncated) === 'true';
		$next = trim((string) $xml->NextContinuationToken);
		if ($truncated && $next === '')
		{
			throw new \RuntimeException('The S3 provider omitted its continuation cursor.');
		}

		return ['keys' => $keys, 'cursor' => $truncated ? $next : null];
	}

	private function put(string $variant, string $key, string $local_file, bool $create_only): bool
	{
		if (!is_file($local_file) || is_link($local_file) || !is_readable($local_file))
		{
			return false;
		}
		$hash = hash_file('sha256', $local_file);
		$size = filesize($local_file);
		if (!is_string($hash) || $size === false)
		{
			return false;
		}
		$headers = [
			'Content-Length' => (string) $size,
			'Content-Type' => 'application/octet-stream',
			'X-Amz-Meta-Sha256' => $hash,
		];
		if ($create_only)
		{
			$headers['If-None-Match'] = '*';
		}
		$body = fopen($local_file, 'rb');
		if ($body === false)
		{
			return false;
		}
		try
		{
			$response = $this->request('PUT', $this->configuration->object_url($variant, $key), $headers, $hash, $body);
		}
		finally
		{
			fclose($body);
		}
		if ($create_only && $response->status() === 412)
		{
			return false;
		}
		$this->require_status($response, [200, 201, 204]);

		return true;
	}

	private function metadata(string $variant, string $key): ?response
	{
		$response = $this->request('HEAD', $this->configuration->object_url($variant, $key));
		if ($response->status() === 404)
		{
			return null;
		}
		$this->require_status($response, [200]);

		return $response;
	}

	/**
	 * @param array<string, string> $headers
	 * @param resource|null $body
	 */
	private function request(
		string $method,
		string $url,
		array $headers = [],
		string $payload_hash = self::EMPTY_HASH,
		mixed $body = null
	): response
	{
		$time = ($this->clock)();
		if (!$time instanceof \DateTimeImmutable)
		{
			throw new \RuntimeException('The S3 request clock is invalid.');
		}
		$headers = $this->signer->sign($method, $url, $headers, $payload_hash, $time);

		return $this->client->request($method, $url, $headers, $body);
	}

	/** @param list<int> $allowed */
	private function require_status(response $response, array $allowed): void
	{
		if (!in_array($response->status(), $allowed, true))
		{
			throw new \RuntimeException('The S3 provider returned HTTP status ' . $response->status() . '.');
		}
	}

	private function response_body(response $response): string
	{
		$body = $response->detach_body();
		if (!is_resource($body))
		{
			throw new \RuntimeException('The S3 list response has no readable body.');
		}
		try
		{
			$data = stream_get_contents($body, self::MAX_LIST_RESPONSE + 1);
			if ($data === false || strlen($data) > self::MAX_LIST_RESPONSE || !feof($body))
			{
				throw new \RuntimeException('The S3 list response exceeded the safety limit.');
			}

			return $data;
		}
		finally
		{
			fclose($body);
		}
	}

	private function parse_list_response(string $body): \SimpleXMLElement
	{
		$previous = libxml_use_internal_errors(true);
		try
		{
			$xml = simplexml_load_string($body, \SimpleXMLElement::class, LIBXML_NONET | LIBXML_NOCDATA);
		}
		finally
		{
			libxml_clear_errors();
			libxml_use_internal_errors($previous);
		}
		if (!$xml instanceof \SimpleXMLElement || $xml->getName() !== 'ListBucketResult')
		{
			throw new \RuntimeException('The S3 list response is invalid.');
		}

		return $xml;
	}
}
