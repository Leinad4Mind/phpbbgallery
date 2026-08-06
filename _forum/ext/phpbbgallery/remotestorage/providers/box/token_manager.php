<?php
/**
 * phpBB Gallery - Remote Storage Add-on
 *
 * @package   phpbbgallery/remotestorage
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\remotestorage\providers\box;

use phpbbgallery\remotestorage\http\client_interface;
use phpbbgallery\remotestorage\http\response;

/** Refresh and atomically persist Box single-use rotating OAuth tokens. */
final class token_manager
{
	private const TOKEN_ENDPOINT = 'https://api.box.com/oauth2/token';
	private const MAX_RESPONSE = 1048576;
	private \Closure $clock;
	private string $last_token = '';

	public function __construct(
		private configuration $configuration,
		private token_store_interface $store,
		private client_interface $client,
		?\Closure $clock = null
	)
	{
		$this->clock = $clock ?? static fn (): int => time();
	}

	public function token(): string
	{
		$token = $this->store->synchronized(function (): string
		{
			$now = ($this->clock)();
			if (!is_int($now))
			{
				throw new \RuntimeException('The Box OAuth clock is invalid.');
			}
			$current = $this->store->load();
			if ($this->valid_token($current['access_token'])
				&& $now < $current['access_expires'] - 60)
			{
				return $current['access_token'];
			}
			if (!$this->valid_token($current['refresh_token']))
			{
				throw new \RuntimeException('The Box refresh token is not configured.');
			}
			$body = $this->stream(http_build_query([
				'grant_type' => 'refresh_token',
				'refresh_token' => $current['refresh_token'],
				'client_id' => $this->configuration->client_id(),
				'client_secret' => $this->configuration->client_secret(),
			], '', '&', PHP_QUERY_RFC3986));
			try
			{
				$response = $this->client->request('POST', self::TOKEN_ENDPOINT, [
					'Content-Type' => 'application/x-www-form-urlencoded',
				], $body);
			}
			finally
			{
				fclose($body);
			}
			if ($response->status() !== 200)
			{
				throw new \RuntimeException('Box OAuth rejected the configured credentials.');
			}
			$data = $this->json($response);
			$access = (string) ($data['access_token'] ?? '');
			$refresh = (string) ($data['refresh_token'] ?? '');
			$expires_in = (int) ($data['expires_in'] ?? 0);
			if (!$this->valid_token($access) || !$this->valid_token($refresh)
				|| $expires_in < 120 || $expires_in > 86400)
			{
				throw new \RuntimeException('Box OAuth returned invalid rotating credentials.');
			}
			$this->store->save($access, $now + $expires_in, $refresh);

			return $access;
		});
		if (!is_string($token))
		{
			throw new \RuntimeException('The Box OAuth token store returned an invalid value.');
		}
		$this->last_token = $token;

		return $token;
	}

	public function invalidate(): void
	{
		$issued = $this->last_token;
		$this->store->synchronized(function () use ($issued): void
		{
			$current = $this->store->load();
			if ($issued !== '' && hash_equals($current['access_token'], $issued))
			{
				$this->store->save('', 0, $current['refresh_token']);
			}
		});
		$this->last_token = '';
	}

	/** @return array{access_token: string, access_expires: int, refresh_token: string} */
	public function credentials(): array
	{
		return $this->store->load();
	}

	private function valid_token(string $token): bool
	{
		return $token !== '' && strlen($token) <= 4096
			&& !preg_match('/[\x00-\x1f\x7f]/', $token);
	}

	/** @return array<string, mixed> */
	private function json(response $response): array
	{
		$body = $response->detach_body();
		if (!is_resource($body))
		{
			throw new \RuntimeException('Box OAuth returned no response body.');
		}
		try
		{
			$json = stream_get_contents($body, self::MAX_RESPONSE + 1);
			if ($json === false || strlen($json) > self::MAX_RESPONSE || !feof($body))
			{
				throw new \RuntimeException('Box OAuth exceeded the response safety limit.');
			}
		}
		finally
		{
			fclose($body);
		}
		try
		{
			$data = json_decode($json, true, 32, JSON_THROW_ON_ERROR);
		}
		catch (\JsonException $exception)
		{
			throw new \RuntimeException('Box OAuth returned invalid JSON.', 0, $exception);
		}
		if (!is_array($data))
		{
			throw new \RuntimeException('Box OAuth returned invalid JSON.');
		}

		return $data;
	}

	/** @return resource */
	private function stream(string $contents): mixed
	{
		$stream = fopen('php://temp', 'w+b');
		if ($stream === false || fwrite($stream, $contents) !== strlen($contents))
		{
			throw new \RuntimeException('Could not create the Box OAuth request.');
		}
		rewind($stream);

		return $stream;
	}
}
