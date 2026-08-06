<?php
/**
 * phpBB Gallery - Remote Storage Add-on
 *
 * @package   phpbbgallery/remotestorage
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\remotestorage\fourshared;

/** OAuth 1.0 HMAC-SHA1 request signer restricted to the official 4shared API hosts. */
final class oauth_signer
{
	private \Closure $nonce_factory;
	private \Closure $time_factory;

	public function __construct(
		private configuration $configuration,
		?\Closure $nonce_factory = null,
		?\Closure $time_factory = null
	)
	{
		$this->nonce_factory = $nonce_factory ?? static fn (): string => bin2hex(random_bytes(16));
		$this->time_factory = $time_factory ?? static fn (): int => time();
	}

	/** @param array<string, int|string> $query @param array<string, int|string> $form */
	public function authorization(string $method, string $url, array $query = [], array $form = []): string
	{
		$method = strtoupper($method);
		if (!in_array($method, ['DELETE', 'GET', 'POST', 'PUT'], true))
		{
			throw new \InvalidArgumentException('The 4shared OAuth method is invalid.');
		}
		$this->assert_url($url);
		if (array_intersect_key($query, $form) !== [])
		{
			throw new \InvalidArgumentException('A 4shared OAuth parameter was supplied twice.');
		}
		$parameters = $this->parameters($query + $form);
		$timestamp = ($this->time_factory)();
		if (!is_int($timestamp) || $timestamp < 1)
		{
			throw new \RuntimeException('The 4shared OAuth clock returned an invalid timestamp.');
		}
		$oauth = [
			'oauth_consumer_key' => $this->configuration->consumer_key(),
			'oauth_nonce' => $this->nonce(),
			'oauth_signature_method' => 'HMAC-SHA1',
			'oauth_timestamp' => (string) $timestamp,
			'oauth_token' => $this->configuration->access_token(),
			'oauth_version' => '1.0',
		];
		$normalized = $this->normalized($parameters + $oauth);
		$base = $method . '&' . rawurlencode($url) . '&' . rawurlencode($normalized);
		$key = rawurlencode($this->configuration->consumer_secret()) . '&'
			. rawurlencode($this->configuration->access_token_secret());
		$oauth['oauth_signature'] = base64_encode(hash_hmac('sha1', $base, $key, true));
		ksort($oauth, SORT_STRING);
		$quote = chr(34);

		return 'OAuth ' . implode(', ', array_map(static fn (string $name, string $value): string =>
			$name . '=' . $quote . rawurlencode($value) . $quote, array_keys($oauth), $oauth));
	}

	/** @param array<string, int|string> $parameters @return array<string, string> */
	private function parameters(array $parameters): array
	{
		if (count($parameters) > 64)
		{
			throw new \InvalidArgumentException('The 4shared OAuth parameter limit was exceeded.');
		}
		$validated = [];
		foreach ($parameters as $name => $value)
		{
			$name = (string) $name;
			if (preg_match('/^[A-Za-z][A-Za-z0-9_-]{0,63}$/D', $name) !== 1
				|| str_starts_with($name, 'oauth_') || (!is_int($value) && !is_string($value))
				|| strlen((string) $value) > 4096)
			{
				throw new \InvalidArgumentException('A 4shared OAuth parameter is invalid.');
			}
			$validated[$name] = (string) $value;
		}

		return $validated;
	}

	/** @param array<string, string> $parameters */
	private function normalized(array $parameters): string
	{
		$pairs = [];
		foreach ($parameters as $name => $value)
		{
			$pairs[] = [rawurlencode($name), rawurlencode($value)];
		}
		usort($pairs, static fn (array $left, array $right): int =>
			strcmp($left[0], $right[0]) ?: strcmp($left[1], $right[1]));

		return implode('&', array_map(static fn (array $pair): string => $pair[0] . '=' . $pair[1], $pairs));
	}

	private function nonce(): string
	{
		$nonce = (string) ($this->nonce_factory)();
		if (preg_match('/^[A-Za-z0-9]{16,128}$/D', $nonce) !== 1)
		{
			throw new \RuntimeException('The 4shared OAuth nonce generator returned an invalid value.');
		}

		return $nonce;
	}

	private function assert_url(string $url): void
	{
		$parts = parse_url($url);
		if (!is_array($parts) || strtolower((string) ($parts['scheme'] ?? '')) !== 'https'
			|| !in_array(strtolower((string) ($parts['host'] ?? '')), [
				'api.4shared.com', 'upload.4shared.com',
			], true)
			|| isset($parts['user']) || isset($parts['pass']) || isset($parts['port'])
			|| isset($parts['query']) || isset($parts['fragment']))
		{
			throw new \InvalidArgumentException('The 4shared OAuth URL is invalid.');
		}
	}
}
