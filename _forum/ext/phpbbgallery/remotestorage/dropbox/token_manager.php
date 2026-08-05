<?php
/**
 * phpBB Gallery - Remote Storage Add-on
 *
 * @package   phpbbgallery/remotestorage
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\remotestorage\dropbox;

use phpbbgallery\remotestorage\http\client_interface;
use phpbbgallery\remotestorage\http\response;

/** Exchange a long-lived refresh token for short-lived Dropbox access tokens. */
final class token_manager
{
	private const TOKEN_ENDPOINT = 'https://api.dropboxapi.com/oauth2/token';
	private const MAX_RESPONSE = 1048576;
	private string $access_token = '';
	private int $expires_at = 0;
	private \Closure $clock;

	public function __construct(
		private configuration $configuration,
		private client_interface $client,
		?\Closure $clock = null
	)
	{
		$this->clock = $clock ?? static fn (): int => time();
	}

	public function token(): string
	{
		$now = ($this->clock)();
		if (!is_int($now))
		{
			throw new \RuntimeException('The Dropbox OAuth clock is invalid.');
		}
		if ($this->access_token !== '' && $now < $this->expires_at - 60)
		{
			return $this->access_token;
		}

		$body = $this->stream(http_build_query([
			'grant_type' => 'refresh_token',
			'refresh_token' => $this->configuration->refresh_token(),
		], '', '&', PHP_QUERY_RFC3986));
		try
		{
			$response = $this->client->request('POST', self::TOKEN_ENDPOINT, [
				'Authorization' => 'Basic ' . base64_encode(
					$this->configuration->app_key() . ':' . $this->configuration->app_secret()
				),
				'Content-Type' => 'application/x-www-form-urlencoded',
			], $body);
		}
		finally
		{
			fclose($body);
		}
		if ($response->status() !== 200)
		{
			throw new \RuntimeException('Dropbox OAuth rejected the configured credentials.');
		}
		$data = $this->json($response);
		$token = (string) ($data['access_token'] ?? '');
		$expires_in = (int) ($data['expires_in'] ?? 0);
		if ($token === '' || strlen($token) > 4096 || $expires_in < 120 || $expires_in > 86400)
		{
			throw new \RuntimeException('Dropbox OAuth returned an invalid access token response.');
		}

		$this->access_token = $token;
		$this->expires_at = $now + $expires_in;

		return $token;
	}

	public function invalidate(): void
	{
		$this->access_token = '';
		$this->expires_at = 0;
	}

	/** @return array<string, mixed> */
	private function json(response $response): array
	{
		$body = $response->detach_body();
		if (!is_resource($body))
		{
			throw new \RuntimeException('Dropbox OAuth returned no response body.');
		}
		try
		{
			$contents = stream_get_contents($body, self::MAX_RESPONSE + 1);
			if ($contents === false || strlen($contents) > self::MAX_RESPONSE || !feof($body))
			{
				throw new \RuntimeException('Dropbox OAuth exceeded the response safety limit.');
			}
		}
		finally
		{
			fclose($body);
		}
		try
		{
			$data = json_decode($contents, true, 32, JSON_THROW_ON_ERROR);
		}
		catch (\JsonException $exception)
		{
			throw new \RuntimeException('Dropbox OAuth returned invalid JSON.', 0, $exception);
		}
		if (!is_array($data))
		{
			throw new \RuntimeException('Dropbox OAuth returned invalid JSON.');
		}

		return $data;
	}

	/** @return resource */
	private function stream(string $contents): mixed
	{
		$stream = fopen('php://temp', 'w+b');
		if ($stream === false || fwrite($stream, $contents) !== strlen($contents))
		{
			throw new \RuntimeException('Could not create a Dropbox OAuth request.');
		}
		rewind($stream);

		return $stream;
	}
}
