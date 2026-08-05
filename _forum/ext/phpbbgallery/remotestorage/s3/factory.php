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

/** Build the S3 provider from process-level secrets and endpoint settings. */
final class factory
{
	private client_interface $client;
	/** @var array<string, string>|null */
	private ?array $environment;

	/** @param array<string, string>|null $environment */
	public function __construct(client_interface $client, ?array $environment = null)
	{
		$this->client = $client;
		$this->environment = $environment;
	}

	public function create(): provider
	{
		$endpoint = $this->value('PHPBBGALLERY_S3_ENDPOINT');
		$bucket = $this->value('PHPBBGALLERY_S3_BUCKET');
		$access_key = $this->value('PHPBBGALLERY_S3_ACCESS_KEY');
		$secret_key = $this->value('PHPBBGALLERY_S3_SECRET_KEY');
		$region = $this->value('PHPBBGALLERY_S3_REGION', 'us-east-1');
		$prefix = $this->value('PHPBBGALLERY_S3_PREFIX', 'phpbbgallery');

		return new provider(
			new configuration($endpoint, $bucket, $prefix),
			new signer($access_key, $secret_key, $region),
			$this->client
		);
	}

	private function value(string $name, string $default = ''): string
	{
		if ($this->environment !== null)
		{
			return trim((string) ($this->environment[$name] ?? $default));
		}
		$value = getenv($name);

		return $value === false ? $default : trim($value);
	}
}
