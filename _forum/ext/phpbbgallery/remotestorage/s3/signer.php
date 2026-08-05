<?php
/**
 * phpBB Gallery - Remote Storage Add-on
 *
 * @package   phpbbgallery/remotestorage
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\remotestorage\s3;

/** AWS Signature Version 4 signer for S3-compatible object stores. */
final class signer
{
	private string $access_key;
	private string $secret_key;
	private string $region;

	public function __construct(string $access_key, string $secret_key, string $region)
	{
		if ($access_key === '' || $secret_key === '' || preg_match('/^[a-z0-9-]{1,64}$/iD', $region) !== 1)
		{
			throw new \InvalidArgumentException('The S3 signing credentials or region are invalid.');
		}
		$this->access_key = $access_key;
		$this->secret_key = $secret_key;
		$this->region = strtolower($region);
	}

	/**
	 * @param array<string, string> $headers
	 * @return array<string, string>
	 */
	public function sign(string $method, string $url, array $headers, string $payload_hash, \DateTimeImmutable $time): array
	{
		if (preg_match('/^[a-f0-9]{64}$/D', $payload_hash) !== 1)
		{
			throw new \InvalidArgumentException('The S3 payload hash is invalid.');
		}
		$parts = parse_url($url);
		if (!is_array($parts) || !isset($parts['scheme'], $parts['host'])
			|| !in_array(strtolower((string) $parts['scheme']), ['http', 'https'], true))
		{
			throw new \InvalidArgumentException('The S3 request URL is invalid.');
		}

		$time = $time->setTimezone(new \DateTimeZone('UTC'));
		$amz_date = $time->format('Ymd\THis\Z');
		$date = $time->format('Ymd');
		$host = strtolower((string) $parts['host']);
		if (isset($parts['port']))
		{
			$host .= ':' . (int) $parts['port'];
		}
		$headers['Host'] = $host;
		$headers['X-Amz-Date'] = $amz_date;
		$headers['X-Amz-Content-Sha256'] = $payload_hash;
		[$canonical_headers, $signed_headers] = $this->canonical_headers($headers);
		$canonical_request = strtoupper($method) . chr(10)
			. $this->canonical_uri((string) ($parts['path'] ?? '/')) . chr(10)
			. $this->canonical_query((string) ($parts['query'] ?? '')) . chr(10)
			. $canonical_headers . chr(10)
			. $signed_headers . chr(10)
			. $payload_hash;
		$scope = $date . '/' . $this->region . '/s3/aws4_request';
		$string_to_sign = 'AWS4-HMAC-SHA256' . chr(10) . $amz_date . chr(10) . $scope . chr(10)
			. hash('sha256', $canonical_request);
		$signature = hash_hmac('sha256', $string_to_sign, $this->signing_key($date));
		$headers['Authorization'] = 'AWS4-HMAC-SHA256 Credential=' . $this->access_key . '/' . $scope
			. ', SignedHeaders=' . $signed_headers . ', Signature=' . $signature;

		return $headers;
	}

	/**
	 * @param array<string, string> $headers
	 * @return array{0: string, 1: string}
	 */
	private function canonical_headers(array $headers): array
	{
		$normalized = [];
		foreach ($headers as $name => $value)
		{
			$name = strtolower(trim((string) $name));
			if ($name === '' || preg_match('/^[a-z0-9-]+$/D', $name) !== 1)
			{
				throw new \InvalidArgumentException('An S3 request header name is invalid.');
			}
			$value = preg_replace('/[\t ]+/', ' ', trim((string) $value));
			if ($value === null || preg_match('/[\r\n]/', $value))
			{
				throw new \InvalidArgumentException('An S3 request header value is invalid.');
			}
			$normalized[$name] = $value;
		}
		ksort($normalized, SORT_STRING);
		$canonical = '';
		foreach ($normalized as $name => $value)
		{
			$canonical .= $name . ':' . $value . chr(10);
		}

		return [$canonical, implode(';', array_keys($normalized))];
	}

	private function canonical_uri(string $path): string
	{
		$segments = explode('/', $path === '' ? '/' : $path);
		foreach ($segments as &$segment)
		{
			$segment = rawurlencode(rawurldecode($segment));
		}
		unset($segment);
		$canonical = implode('/', $segments);

		return str_starts_with($canonical, '/') ? $canonical : '/' . $canonical;
	}

	private function canonical_query(string $query): string
	{
		if ($query === '')
		{
			return '';
		}
		$pairs = [];
		foreach (explode('&', $query) as $part)
		{
			[$name, $value] = array_pad(explode('=', $part, 2), 2, '');
			$pairs[] = [rawurlencode(rawurldecode($name)), rawurlencode(rawurldecode($value))];
		}
		usort($pairs, static function (array $left, array $right): int
		{
			return $left[0] <=> $right[0] ?: $left[1] <=> $right[1];
		});

		return implode('&', array_map(static fn (array $pair): string => $pair[0] . '=' . $pair[1], $pairs));
	}

	private function signing_key(string $date): string
	{
		$date_key = hash_hmac('sha256', $date, 'AWS4' . $this->secret_key, true);
		$region_key = hash_hmac('sha256', $this->region, $date_key, true);
		$service_key = hash_hmac('sha256', 's3', $region_key, true);

		return hash_hmac('sha256', 'aws4_request', $service_key, true);
	}
}
