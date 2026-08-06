<?php
/**
 * phpBB Gallery - Remote Storage Add-on
 *
 * @package   phpbbgallery/remotestorage
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\remotestorage\http;

/** Guzzle adapter with redirects and automatic HTTP exceptions disabled. */
final class guzzle_client implements client_interface
{
	private \GuzzleHttp\ClientInterface $client;

	public function __construct(?\GuzzleHttp\ClientInterface $client = null)
	{
		$this->client = $client ?? new \GuzzleHttp\Client();
	}

	public function request(string $method, string $url, array $headers = [], mixed $body = null): response
	{
		$method = strtoupper($method);
		if (!in_array($method, ['DELETE', 'GET', 'HEAD', 'PATCH', 'POST', 'PUT'], true)
			|| ($body !== null && !is_resource($body)))
		{
			throw new \InvalidArgumentException('The remote storage HTTP request is invalid.');
		}

		$options = [
			'allow_redirects' => false,
			'connect_timeout' => 10,
			'headers' => $headers,
			'http_errors' => false,
			'stream' => true,
			'timeout' => 60,
			'verify' => true,
		];
		if ($body !== null)
		{
			$options['body'] = $body;
		}

		$resource = null;
		try
		{
			$remote = $this->client->request($method, $url, $options);
			$stream = $remote->getBody();
			$resource = $stream->detach();
			if ($resource !== null && !is_resource($resource))
			{
				throw new \RuntimeException('The remote storage response stream is invalid.');
			}

			return new response($remote->getStatusCode(), $remote->getHeaders(), $resource);
		}
		catch (\Throwable $exception)
		{
			if (is_resource($resource))
			{
				fclose($resource);
			}
			throw new \RuntimeException('The remote storage HTTP request failed.', 0, $exception);
		}
	}
}
