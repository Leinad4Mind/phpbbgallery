<?php
/**
 * phpBB Gallery - Remote Storage Add-on
 *
 * @package   phpbbgallery/remotestorage
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\remotestorage\pcloud;

use phpbbgallery\remotestorage\http\client_interface;
use phpbbgallery\remotestorage\http\response;

/** Minimal pCloud HTTP JSON client using an OAuth bearer token. */
final class api_client
{
	private const MAX_RESPONSE = 33554432;

	public function __construct(private configuration $configuration, private client_interface $client)
	{
	}

	/**
	 * @param array<string, int|string> $parameters
	 * @param array<string, string> $headers
	 * @param resource|null $body
	 * @return array<string, mixed>
	 */
	public function call(
		string $method,
		array $parameters = [],
		string $http_method = 'GET',
		array $headers = [],
		mixed $body = null
	): array
	{
		if (preg_match('/^[a-z][a-z0-9_]{1,63}$/D', $method) !== 1
			|| !in_array($http_method, ['GET', 'PUT'], true)
			|| ($body !== null && !is_resource($body)))
		{
			throw new \InvalidArgumentException('The pCloud API request is invalid.');
		}
		foreach ($parameters as $name => $value)
		{
			if (preg_match('/^[a-z][a-z0-9_]*$/D', (string) $name) !== 1
				|| (!is_int($value) && !is_string($value)))
			{
				throw new \InvalidArgumentException('A pCloud API parameter is invalid.');
			}
		}
		$url = $this->configuration->api_root() . '/' . $method;
		if ($parameters !== [])
		{
			$url .= '?' . http_build_query($parameters, '', '&', PHP_QUERY_RFC3986);
		}
		$response = $this->client->request($http_method, $url, [
			'Authorization' => 'Bearer ' . $this->configuration->access_token(),
			'Accept' => 'application/json',
		] + $headers, $body);
		if ($response->status() !== 200)
		{
			throw new \RuntimeException('pCloud returned HTTP status ' . $response->status() . '.');
		}

		return $this->response_json($response);
	}

	/** @return array<string, mixed> */
	private function response_json(response $response): array
	{
		$body = $response->detach_body();
		if (!is_resource($body))
		{
			throw new \RuntimeException('pCloud returned no JSON response body.');
		}
		try
		{
			$json = stream_get_contents($body, self::MAX_RESPONSE + 1);
			if ($json === false || strlen($json) > self::MAX_RESPONSE || !feof($body))
			{
				throw new \RuntimeException('pCloud exceeded the JSON response safety limit.');
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
			throw new \RuntimeException('pCloud returned invalid JSON.', 0, $exception);
		}
		if (!is_array($data) || !array_key_exists('result', $data))
		{
			throw new \RuntimeException('pCloud returned an invalid API envelope.');
		}

		return $data;
	}
}
