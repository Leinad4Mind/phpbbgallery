<?php
/**
 * phpBB Gallery - Remote Storage Add-on
 *
 * @package   phpbbgallery/remotestorage
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\remotestorage\providers\mediafire;

use phpbbgallery\remotestorage\http\client_interface;
use phpbbgallery\remotestorage\http\response;

/** Serialized MediaFire Core API 1.5 client using Session Token v2 signatures. */
final class api_client
{
	private const API_ROOT = 'https://www.mediafire.com/api/1.5/';
	private const MAX_RESPONSE = 2097152;
	private const SESSION_SAFE_LIFETIME = 62208000;
	private const KEY_MULTIPLIER = 16807;
	private const KEY_MODULUS = 2147483647;
	private \Closure $clock;

	public function __construct(
		private configuration $configuration,
		private session_store_interface $store,
		private client_interface $client,
		?\Closure $clock = null
	)
	{
		$this->clock = $clock ?? static fn (): int => time();
	}

	/**
	 * @param array<string, int|string> $parameters
	 * @param array<string, string> $headers
	 * @param \Closure(): resource|null $body_factory
	 * @return array<string, mixed>
	 */
	public function call(
		string $path,
		array $parameters = [],
		array $headers = [],
		?\Closure $body_factory = null
	): array
	{
		if (preg_match('/^[a-z_]+\/[a-z_]+$/D', $path) !== 1)
		{
			throw new \InvalidArgumentException('The MediaFire API path is invalid.');
		}
		foreach ($parameters as $name => $value)
		{
			if (preg_match('/^[a-z_]+$/D', (string) $name) !== 1 || (!is_int($value) && !is_string($value)))
			{
				throw new \InvalidArgumentException('A MediaFire API parameter is invalid.');
			}
		}

		return $this->store->synchronized(function () use ($path, $parameters, $headers, $body_factory): array
		{
			$state = $this->store->load();
			if (!$this->valid_state($state))
			{
				$state = $this->authenticate();
			}
			for ($attempt = 0; $attempt < 2; $attempt++)
			{
				$data = $this->signed_request($path, $parameters, $headers, $body_factory, $state);
				if (in_array((int) ($data['error'] ?? 0), [105, 127], true) && $attempt === 0)
				{
					$state = $this->authenticate();
					continue;
				}
				if (($data['new_key'] ?? '') === 'yes')
				{
					$state['secret_key'] = $this->next_secret_key($state['secret_key']);
					$this->store->save_secret_key($state['secret_key']);
				}

				return $data;
			}

			throw new \RuntimeException('MediaFire authentication failed.');
		});
	}

	/** @return array{session_token: string, secret_key: int, time: string, issued_at: int} */
	public function credentials(): array
	{
		return $this->store->load();
	}

	/**
	 * @param array<string, int|string> $parameters
	 * @param array<string, string> $headers
	 * @param \Closure(): resource|null $body_factory
	 * @param array{session_token: string, secret_key: int, time: string, issued_at: int} $state
	 * @return array<string, mixed>
	 */
	private function signed_request(
		string $path,
		array $parameters,
		array $headers,
		?\Closure $body_factory,
		array $state
	): array
	{
		$query = ['session_token' => $state['session_token']] + $parameters + ['response_format' => 'json'];
		$uri = '/api/1.5/' . $path . '.php?'
			. http_build_query($query, '', '&', PHP_QUERY_RFC3986);
		// The MediaFire Session Token v2 wire protocol mandates MD5 for call signatures.
		$signature = hash('md5', (string) ($state['secret_key'] % 256) . $state['time'] . $uri);
		$body = $body_factory === null ? null : $body_factory();
		if ($body !== null && !is_resource($body))
		{
			throw new \RuntimeException('The MediaFire request body is invalid.');
		}
		try
		{
			$response = $this->client->request(
				$body === null ? 'GET' : 'POST',
				'https://www.mediafire.com' . $uri . '&signature=' . $signature,
				$headers,
				$body
			);
		}
		finally
		{
			if (is_resource($body))
			{
				fclose($body);
			}
		}
		if ($response->status() !== 200)
		{
			throw new \RuntimeException('MediaFire returned HTTP status ' . $response->status() . '.');
		}

		return $this->response_json($response);
	}

	/** @return array{session_token: string, secret_key: int, time: string, issued_at: int} */
	private function authenticate(): array
	{
		$fields = [
			'application_id' => $this->configuration->application_id(),
			'email' => $this->configuration->email(),
			'password' => $this->configuration->password(),
			'response_format' => 'json',
			// The MediaFire authentication wire protocol mandates SHA-1 for this proof.
			'signature' => hash('sha1',
				$this->configuration->email()
				. $this->configuration->password()
				. $this->configuration->application_id()
				. $this->configuration->api_key()
			),
			'token_version' => '2',
		];
		$encoded = http_build_query($fields, '', '&', PHP_QUERY_RFC3986);
		$body = $this->stream($encoded);
		try
		{
			$response = $this->client->request('POST', self::API_ROOT . 'user/get_session_token.php', [
				'Content-Type' => 'application/x-www-form-urlencoded',
			], $body);
		}
		finally
		{
			fclose($body);
		}
		if ($response->status() !== 200)
		{
			throw new \RuntimeException('MediaFire authentication returned HTTP status '
				. $response->status() . '.');
		}
		$data = $this->response_json($response);
		$state = [
			'session_token' => (string) ($data['session_token'] ?? ''),
			'secret_key' => (int) ($data['secret_key'] ?? 0),
			'time' => (string) ($data['time'] ?? ''),
			'issued_at' => ($this->clock)(),
		];
		if (($data['result'] ?? '') !== 'Success' || !$this->valid_state($state))
		{
			throw new \RuntimeException('MediaFire rejected the configured account credentials.');
		}
		$this->store->save(
			$state['session_token'],
			$state['secret_key'],
			$state['time'],
			$state['issued_at']
		);

		return $state;
	}

	/** @param array{session_token: string, secret_key: int, time: string, issued_at: int} $state */
	private function valid_state(array $state): bool
	{
		return preg_match('/^[A-Za-z0-9]{32,4096}$/D', $state['session_token']) === 1
			&& $state['secret_key'] > 0 && $state['secret_key'] < self::KEY_MODULUS
			&& preg_match('/^[0-9]{9,13}(?:\.[0-9]{1,12})?$/D', $state['time']) === 1
			&& $state['issued_at'] > 0
			&& ($this->clock)() < $state['issued_at'] + self::SESSION_SAFE_LIFETIME;
	}

	private function next_secret_key(int $current): int
	{
		return (int) (($current * self::KEY_MULTIPLIER) % self::KEY_MODULUS);
	}

	/** @return array<string, mixed> */
	private function response_json(response $response): array
	{
		$body = $response->detach_body();
		if (!is_resource($body))
		{
			throw new \RuntimeException('MediaFire returned no JSON response body.');
		}
		try
		{
			$json = stream_get_contents($body, self::MAX_RESPONSE + 1);
			if ($json === false || strlen($json) > self::MAX_RESPONSE || !feof($body))
			{
				throw new \RuntimeException('MediaFire exceeded the JSON response safety limit.');
			}
		}
		finally
		{
			fclose($body);
		}
		try
		{
			$decoded = json_decode($json, true, 64, JSON_THROW_ON_ERROR);
		}
		catch (\JsonException $exception)
		{
			throw new \RuntimeException('MediaFire returned invalid JSON.', 0, $exception);
		}
		$data = is_array($decoded) ? ($decoded['response'] ?? null) : null;
		if (!is_array($data))
		{
			throw new \RuntimeException('MediaFire returned an invalid API envelope.');
		}

		return $data;
	}

	/** @return resource */
	private function stream(string $contents): mixed
	{
		$stream = fopen('php://temp', 'w+b');
		if ($stream === false || fwrite($stream, $contents) !== strlen($contents))
		{
			throw new \RuntimeException('Could not create the MediaFire request body.');
		}
		rewind($stream);

		return $stream;
	}
}
