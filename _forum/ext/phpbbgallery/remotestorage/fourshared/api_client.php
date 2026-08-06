<?php
/**
 * phpBB Gallery - Remote Storage Add-on
 *
 * @package   phpbbgallery/remotestorage
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\remotestorage\fourshared;

use phpbbgallery\remotestorage\http\client_interface;
use phpbbgallery\remotestorage\http\response;

/** Bounded 4shared JSON and binary API client with OAuth-signed fixed-host requests. */
final class api_client
{
	private const MAX_JSON_RESPONSE = 16777216;

	public function __construct(
		private oauth_signer $signer,
		private client_interface $client
	)
	{
	}

	/**
	 * @param array<string, int|string> $query
	 * @param array<string, int|string> $form
	 * @param array<string, string> $headers
	 * @param resource|null $body
	 */
	public function request(
		string $method,
		string $url,
		array $query = [],
		array $form = [],
		array $headers = [],
		mixed $body = null
	): response
	{
		$method = strtoupper($method);
		if (!in_array($method, ['DELETE', 'GET', 'POST', 'PUT'], true)
			|| ($body !== null && !is_resource($body)) || ($body !== null && $form !== []))
		{
			throw new \InvalidArgumentException('The 4shared API request is invalid.');
		}
		$url = $this->url($url, $query);
		$authorization_url = strtok($url, '?');
		if (!is_string($authorization_url))
		{
			throw new \RuntimeException('Could not build the 4shared authorization URL.');
		}
		$owned_body = null;
		if ($form !== [])
		{
			$content = http_build_query($form, '', '&', PHP_QUERY_RFC3986);
			$owned_body = $this->stream($content);
			$body = $owned_body;
			$headers['Content-Length'] = (string) strlen($content);
			$headers['Content-Type'] = 'application/x-www-form-urlencoded';
		}
		$headers = [
			'Accept' => 'application/json',
			'Authorization' => $this->signer->authorization($method, $authorization_url, $query, $form),
		] + $headers;
		try
		{
			return $this->client->request($method, $url, $headers, $body);
		}
		finally
		{
			if (is_resource($owned_body))
			{
				fclose($owned_body);
			}
		}
	}

	/**
	 * @param array<string, int|string> $query
	 * @param array<string, int|string> $form
	 * @param array<string, string> $headers
	 * @param resource|null $body
	 * @param list<int> $statuses
	 * @return array<string, mixed>
	 */
	public function json(
		string $method,
		string $url,
		array $query = [],
		array $form = [],
		array $headers = [],
		mixed $body = null,
		array $statuses = [200]
	): array
	{
		$response = $this->request($method, $url, $query, $form, $headers, $body);
		if (!in_array($response->status(), $statuses, true))
		{
			throw new \RuntimeException('4shared returned HTTP status ' . $response->status() . '.');
		}

		return $this->response_json($response);
	}

	/** @return array<string, mixed> */
	public function response_json(response $response): array
	{
		$body = $response->detach_body();
		if (!is_resource($body))
		{
			throw new \RuntimeException('4shared returned no JSON response body.');
		}
		try
		{
			$json = stream_get_contents($body, self::MAX_JSON_RESPONSE + 1);
			if ($json === false || strlen($json) > self::MAX_JSON_RESPONSE || !feof($body))
			{
				throw new \RuntimeException('4shared exceeded the JSON response safety limit.');
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
			throw new \RuntimeException('4shared returned invalid JSON.', 0, $exception);
		}
		if (!is_array($data) || array_is_list($data))
		{
			throw new \RuntimeException('4shared returned an invalid API envelope.');
		}

		return $data;
	}

	private function url(string $url, array $query): string
	{
		foreach ($query as $name => $value)
		{
			if (preg_match('/^[A-Za-z][A-Za-z0-9_-]{0,63}$/D', (string) $name) !== 1
				|| (!is_int($value) && !is_string($value)) || strlen((string) $value) > 4096)
			{
				throw new \InvalidArgumentException('A 4shared API query parameter is invalid.');
			}
		}
		if ($query !== [])
		{
			$url .= '?' . http_build_query($query, '', '&', PHP_QUERY_RFC3986);
		}

		return $url;
	}

	/** @return resource */
	private function stream(string $contents): mixed
	{
		$stream = fopen('php://temp', 'w+b');
		if ($stream === false || fwrite($stream, $contents) !== strlen($contents))
		{
			throw new \RuntimeException('Could not create the 4shared request body.');
		}
		rewind($stream);

		return $stream;
	}
}
