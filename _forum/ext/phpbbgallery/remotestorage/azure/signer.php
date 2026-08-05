<?php
/**
 * phpBB Gallery - Remote Storage Add-on
 *
 * @package   phpbbgallery/remotestorage
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\remotestorage\azure;

/** Azure Blob Storage Shared Key request signer. */
final class signer
{
	private const API_VERSION = '2023-11-03';

	private string $account;
	private string $key;

	public function __construct(string $account, string $account_key)
	{
		$decoded = base64_decode(trim($account_key), true);
		if (preg_match('/^[a-z0-9]{3,24}$/D', $account) !== 1
			|| !is_string($decoded) || strlen($decoded) < 32)
		{
			throw new \InvalidArgumentException('The Azure Storage Shared Key credentials are invalid.');
		}
		$this->account = $account;
		$this->key = $decoded;
	}

	/**
	 * @param array<string, string> $headers
	 * @return array<string, string>
	 */
	public function sign(string $method, string $url, array $headers, \DateTimeImmutable $time): array
	{
		$method = strtoupper($method);
		$parts = parse_url($url);
		if (!is_array($parts) || !isset($parts['scheme'], $parts['host'])
			|| !in_array(strtolower((string) $parts['scheme']), ['http', 'https'], true))
		{
			throw new \InvalidArgumentException('The Azure Blob request URL is invalid.');
		}

		$headers['x-ms-date'] = $time->setTimezone(new \DateTimeZone('UTC'))->format('D, d M Y H:i:s') . ' GMT';
		$headers['x-ms-version'] = self::API_VERSION;
		$normalized = $this->normalize_headers($headers);
		$string_to_sign = $method . chr(10)
			. $this->standard_header($normalized, 'content-encoding') . chr(10)
			. $this->standard_header($normalized, 'content-language') . chr(10)
			. $this->content_length($normalized) . chr(10)
			. $this->standard_header($normalized, 'content-md5') . chr(10)
			. $this->standard_header($normalized, 'content-type') . chr(10)
			. chr(10)
			. $this->standard_header($normalized, 'if-modified-since') . chr(10)
			. $this->standard_header($normalized, 'if-match') . chr(10)
			. $this->standard_header($normalized, 'if-none-match') . chr(10)
			. $this->standard_header($normalized, 'if-unmodified-since') . chr(10)
			. $this->standard_header($normalized, 'range') . chr(10)
			. $this->canonical_ms_headers($normalized)
			. $this->canonical_resource($parts);
		$signature = base64_encode(hash_hmac('sha256', $string_to_sign, $this->key, true));
		$headers['Authorization'] = 'SharedKey ' . $this->account . ':' . $signature;

		return $headers;
	}

	/** @param array<string, string> $headers
	 * @return array<string, string>
	 */
	private function normalize_headers(array $headers): array
	{
		$normalized = [];
		foreach ($headers as $name => $value)
		{
			$name = strtolower(trim((string) $name));
			$value = preg_replace('/[\t ]+/', ' ', trim((string) $value));
			if ($name === '' || preg_match('/^[a-z0-9-]+$/D', $name) !== 1
				|| $value === null || preg_match('/[\r\n]/', $value))
			{
				throw new \InvalidArgumentException('An Azure Blob request header is invalid.');
			}
			$normalized[$name] = $value;
		}
		ksort($normalized, SORT_STRING);

		return $normalized;
	}

	/** @param array<string, string> $headers */
	private function content_length(array $headers): string
	{
		$value = $headers['content-length'] ?? '';

		return $value === '0' ? '' : $value;
	}

	/** @param array<string, string> $headers */
	private function standard_header(array $headers, string $name): string
	{
		return $headers[$name] ?? '';
	}

	/** @param array<string, string> $headers */
	private function canonical_ms_headers(array $headers): string
	{
		$canonical = '';
		foreach ($headers as $name => $value)
		{
			if (str_starts_with($name, 'x-ms-'))
			{
				$canonical .= $name . ':' . $value . chr(10);
			}
		}

		return $canonical;
	}

	/** @param array<string, mixed> $parts */
	private function canonical_resource(array $parts): string
	{
		$canonical = '/' . $this->account . (string) ($parts['path'] ?? '/');
		$query = [];
		parse_str((string) ($parts['query'] ?? ''), $query);
		$query = array_change_key_case($query, CASE_LOWER);
		ksort($query, SORT_STRING);
		foreach ($query as $name => $values)
		{
			$values = array_map('strval', is_array($values) ? $values : [$values]);
			sort($values, SORT_STRING);
			$canonical .= chr(10) . $name . ':' . implode(',', $values);
		}

		return $canonical;
	}
}
