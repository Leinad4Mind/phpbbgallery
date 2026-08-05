<?php
/**
 * phpBB Gallery - Remote Storage Add-on
 *
 * @package   phpbbgallery/remotestorage
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\remotestorage\s3;

use phpbbgallery\remotestorage\http\client_interface;

/** Combine ACP configuration with optional process-level secret overrides. */
final class configured_factory
{
	private const FIELDS = [
		'endpoint' => 'PHPBBGALLERY_S3_ENDPOINT',
		'bucket' => 'PHPBBGALLERY_S3_BUCKET',
		'access_key' => 'PHPBBGALLERY_S3_ACCESS_KEY',
		'secret_key' => 'PHPBBGALLERY_S3_SECRET_KEY',
		'region' => 'PHPBBGALLERY_S3_REGION',
		'prefix' => 'PHPBBGALLERY_S3_PREFIX',
	];

	private client_interface $client;
	private \ArrayAccess $config;
	/** @var array<string, string>|null */
	private ?array $environment;

	/** @param array<string, string>|null $environment */
	public function __construct(client_interface $client, \ArrayAccess $config, ?array $environment = null)
	{
		$this->client = $client;
		$this->config = $config;
		$this->environment = $environment;
	}

	public function create(): provider
	{
		return $this->create_from([]);
	}

	/**
	 * Build a provider from submitted values without persisting them.
	 *
	 * @param array<string, string> $submitted
	 */
	public function create_from(array $submitted): provider
	{
		$environment = [];
		foreach (self::FIELDS as $field => $variable)
		{
			$value = array_key_exists($field, $submitted)
				? (string) $submitted[$field]
				: (string) ($this->config['phpbb_gallery_s3_' . $field] ?? '');
			$external = $this->external_value($variable);
			$environment[$variable] = $external === false ? $value : (string) $external;
		}

		return (new factory($this->client, $environment))->create();
	}

	/** @return list<string> */
	public function environment_overrides(): array
	{
		$overrides = [];
		foreach (self::FIELDS as $field => $variable)
		{
			if ($this->external_value($variable) !== false)
			{
				$overrides[] = $field;
			}
		}

		return $overrides;
	}

	/** @return string|false */
	private function external_value(string $variable): string|false
	{
		if ($this->environment !== null)
		{
			return array_key_exists($variable, $this->environment)
				? (string) $this->environment[$variable]
				: false;
		}

		return getenv($variable);
	}
}
