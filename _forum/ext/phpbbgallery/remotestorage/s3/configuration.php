<?php
/**
 * phpBB Gallery - Remote Storage Add-on
 *
 * @package   phpbbgallery/remotestorage
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\remotestorage\s3;

/** Validated path-style S3 endpoint and object namespace. */
final class configuration
{
	private string $endpoint;
	private string $bucket;
	private string $prefix;

	public function __construct(string $endpoint, string $bucket, string $prefix = 'phpbbgallery')
	{
		$endpoint = rtrim(trim($endpoint), '/');
		$parts = parse_url($endpoint);
		if (!is_array($parts) || !isset($parts['scheme'], $parts['host'])
			|| !in_array(strtolower((string) $parts['scheme']), ['http', 'https'], true)
			|| isset($parts['user']) || isset($parts['pass']) || isset($parts['query']) || isset($parts['fragment']))
		{
			throw new \InvalidArgumentException('The S3 endpoint is invalid.');
		}
		if (preg_match('/^[a-z0-9][a-z0-9.-]{1,61}[a-z0-9]$/D', $bucket) !== 1
			|| filter_var($bucket, FILTER_VALIDATE_IP) !== false)
		{
			throw new \InvalidArgumentException('The S3 bucket name is invalid.');
		}

		$prefix = trim(str_replace('\\', '/', $prefix), '/');
		if ($prefix !== '' && !$this->valid_key($prefix))
		{
			throw new \InvalidArgumentException('The S3 object prefix is invalid.');
		}
		$this->endpoint = $endpoint;
		$this->bucket = $bucket;
		$this->prefix = $prefix;
	}

	public function object_url(string $variant, string $key): string
	{
		return $this->endpoint . '/' . rawurlencode($this->bucket) . '/'
			. implode('/', array_map('rawurlencode', explode('/', $this->object_key($variant, $key))));
	}

	/** @param array<string, scalar> $query */
	public function bucket_url(array $query = []): string
	{
		$url = $this->endpoint . '/' . rawurlencode($this->bucket);

		return $query === [] ? $url : $url . '?' . http_build_query($query, '', '&', PHP_QUERY_RFC3986);
	}

	public function object_key(string $variant, string $key): string
	{
		$this->assert_variant($variant);
		if (!$this->valid_key($key))
		{
			throw new \InvalidArgumentException('The S3 object key is invalid.');
		}

		return ($this->prefix === '' ? '' : $this->prefix . '/') . $variant . '/' . $key;
	}

	public function variant_prefix(string $variant): string
	{
		$this->assert_variant($variant);

		return ($this->prefix === '' ? '' : $this->prefix . '/') . $variant . '/';
	}

	public function relative_key(string $variant, string $stored_key): ?string
	{
		$prefix = $this->variant_prefix($variant);
		if (!str_starts_with($stored_key, $prefix))
		{
			return null;
		}
		$key = substr($stored_key, strlen($prefix));

		return $this->valid_key($key) ? $key : null;
	}

	private function assert_variant(string $variant): void
	{
		if (!in_array($variant, [
			\phpbbgallery\core\storage\provider_interface::SOURCE,
			\phpbbgallery\core\storage\provider_interface::MEDIUM,
			\phpbbgallery\core\storage\provider_interface::MINI,
		], true))
		{
			throw new \InvalidArgumentException('The S3 storage variant is invalid.');
		}
	}

	private function valid_key(string $key): bool
	{
		if ($key === '' || strlen($key) > 1024 || strpos($key, chr(0)) !== false
			|| strpos($key, '\\') !== false || preg_match('/[\x00-\x1f\x7f]/', $key))
		{
			return false;
		}
		foreach (explode('/', $key) as $segment)
		{
			if ($segment === '' || $segment === '.' || $segment === '..')
			{
				return false;
			}
		}

		return true;
	}
}
