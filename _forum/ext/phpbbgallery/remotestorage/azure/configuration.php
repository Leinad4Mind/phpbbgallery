<?php
/**
 * phpBB Gallery - Remote Storage Add-on
 *
 * @package   phpbbgallery/remotestorage
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\remotestorage\azure;

/** Validated Azure Blob endpoint and private container namespace. */
final class configuration
{
	private string $endpoint;
	private string $account;
	private string $container;
	private string $prefix;

	public function __construct(string $endpoint, string $account, string $container, string $prefix = 'phpbbgallery')
	{
		$endpoint = rtrim(trim($endpoint), '/');
		$parts = parse_url($endpoint);
		if (!is_array($parts) || !isset($parts['scheme'], $parts['host'])
			|| !in_array(strtolower((string) $parts['scheme']), ['http', 'https'], true)
			|| isset($parts['user']) || isset($parts['pass'])
			|| isset($parts['query']) || isset($parts['fragment']))
		{
			throw new \InvalidArgumentException('The Azure Blob endpoint is invalid.');
		}
		if (preg_match('/^[a-z0-9]{3,24}$/D', $account) !== 1)
		{
			throw new \InvalidArgumentException('The Azure Storage account name is invalid.');
		}
		if (strlen($container) < 3 || strlen($container) > 63
			|| preg_match('/^[a-z0-9](?:[a-z0-9-]*[a-z0-9])$/D', $container) !== 1
			|| str_contains($container, '--'))
		{
			throw new \InvalidArgumentException('The Azure Blob container name is invalid.');
		}
		$prefix = trim($prefix, '/');
		if ($prefix === '' || strlen($prefix) > 255 || !$this->valid_path($prefix))
		{
			throw new \InvalidArgumentException('The Azure Blob object prefix is invalid.');
		}

		$this->endpoint = $endpoint;
		$this->account = $account;
		$this->container = $container;
		$this->prefix = $prefix;
	}

	public function account(): string
	{
		return $this->account;
	}

	public function object_url(string $variant, string $key): string
	{
		return $this->container_url() . '/' . $this->encode_path($this->object_key($variant, $key));
	}

	/** @param array<string, int|string> $query */
	public function container_url(array $query = []): string
	{
		$url = $this->endpoint . '/' . rawurlencode($this->container);

		return $query === [] ? $url : $url . '?' . http_build_query($query, '', '&', PHP_QUERY_RFC3986);
	}

	public function object_key(string $variant, string $key): string
	{
		$this->assert_variant($variant);
		if (!$this->valid_path($key))
		{
			throw new \InvalidArgumentException('The Azure Blob object key is invalid.');
		}

		return $this->variant_prefix($variant) . $key;
	}

	public function variant_prefix(string $variant): string
	{
		$this->assert_variant($variant);

		return $this->prefix . '/' . $variant . '/';
	}

	public function relative_key(string $variant, string $object_key): ?string
	{
		$prefix = $this->variant_prefix($variant);
		if (!str_starts_with($object_key, $prefix))
		{
			return null;
		}
		$key = substr($object_key, strlen($prefix));

		return $this->valid_path($key) ? $key : null;
	}

	private function assert_variant(string $variant): void
	{
		if (!in_array($variant, [
			\phpbbgallery\core\storage\provider_interface::SOURCE,
			\phpbbgallery\core\storage\provider_interface::MEDIUM,
			\phpbbgallery\core\storage\provider_interface::MINI,
		], true))
		{
			throw new \InvalidArgumentException('The Azure Blob object variant is invalid.');
		}
	}

	private function valid_path(string $path): bool
	{
		return $path !== '' && strlen($path) <= 1024
			&& !str_contains($path, '\\') && !str_starts_with($path, '/')
			&& preg_match('/[\x00-\x1f\x7f]/', $path) !== 1
			&& !in_array('..', explode('/', $path), true);
	}

	private function encode_path(string $path): string
	{
		return implode('/', array_map('rawurlencode', explode('/', $path)));
	}
}
