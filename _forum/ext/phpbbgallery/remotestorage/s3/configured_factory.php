<?php
/**
 * phpBB Gallery - Remote Storage Add-on
 *
 * @package   phpbbgallery/remotestorage
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\remotestorage\s3;

use phpbb\request\request_interface;
use phpbbgallery\remotestorage\http\client_interface;
use phpbbgallery\remotestorage\configured_provider_factory_interface;

/** Combine ACP configuration with optional process-level secret overrides. */
final class configured_factory implements configured_provider_factory_interface
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
	public function __construct(
		client_interface $client,
		\ArrayAccess $config,
		private request_interface $request,
		?array $environment = null
	)
	{
		$this->client = $client;
		$this->config = $config;
		$this->environment = $environment;
	}

	public function create(): provider
	{
		return $this->create_from([]);
	}

	public function get_id(): string
	{
		return 's3';
	}

	public function get_name_language_key(): string
	{
		return 'REMOTE_STORAGE_S3_SETTINGS';
	}

	public function field_definitions(): array
	{
		return [
			'endpoint' => $this->field('url', 255, 'REMOTE_STORAGE_S3_ENDPOINT', 'REMOTE_STORAGE_S3_ENDPOINT_EXPLAIN'),
			'bucket' => $this->field('text', 63, 'REMOTE_STORAGE_S3_BUCKET'),
			'region' => $this->field('text', 64, 'REMOTE_STORAGE_S3_REGION', 'REMOTE_STORAGE_S3_REGION_EXPLAIN', 'us-east-1'),
			'prefix' => $this->field('text', 255, 'REMOTE_STORAGE_S3_PREFIX', 'REMOTE_STORAGE_S3_PREFIX_EXPLAIN', 'phpbbgallery'),
			'access_key' => $this->field('text', 255, 'REMOTE_STORAGE_S3_ACCESS_KEY'),
			'secret_key' => $this->field('password', 255, 'REMOTE_STORAGE_S3_SECRET_KEY', '', '', true),
		];
	}

	public function config_key(string $field): string
	{
		if (!array_key_exists($field, self::FIELDS))
		{
			throw new \InvalidArgumentException('The S3 configuration field is invalid.');
		}

		return 'phpbb_gallery_s3_' . $field;
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

		$value = $this->request->server($variable, '');

		return $value === '' ? false : (string) $value;
	}

	/** @return array{type: string, maxlength: int, label: string, explain: string, required: bool, secret: bool, default: string} */
	private function field(
		string $type,
		int $maxlength,
		string $label,
		string $explain = '',
		string $default = '',
		bool $secret = false
	): array
	{
		return compact('type', 'maxlength', 'label', 'explain', 'default', 'secret') + ['required' => true];
	}
}
