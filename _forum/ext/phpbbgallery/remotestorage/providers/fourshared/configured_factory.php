<?php
/**
 * phpBB Gallery - Remote Storage Add-on
 *
 * @package   phpbbgallery/remotestorage
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\remotestorage\providers\fourshared;

use phpbb\request\request_interface;
use phpbbgallery\remotestorage\configured_provider_factory_interface;
use phpbbgallery\remotestorage\http\client_interface;

/** Combine 4shared ACP configuration with safe process-level overrides. */
final class configured_factory implements configured_provider_factory_interface
{
	private const FIELDS = [
		'consumer_key', 'consumer_secret', 'access_token', 'access_token_secret', 'root_name',
	];
	/** @var array<string, string>|null */
	private ?array $environment;

	/** @param array<string, string>|null $environment */
	public function __construct(
		private client_interface $client,
		private \ArrayAccess $config,
		private request_interface $request,
		private string $lock_path,
		?array $environment = null
	)
	{
		$this->environment = $environment;
	}

	public function get_id(): string
	{
		return 'fourshared';
	}

	public function get_name_language_key(): string
	{
		return 'REMOTE_STORAGE_FOURSHARED_SETTINGS';
	}

	public function field_definitions(): array
	{
		return [
			'consumer_key' => $this->field('text', 4096, 'REMOTE_STORAGE_FOURSHARED_CONSUMER_KEY'),
			'consumer_secret' => $this->field('password', 4096,
				'REMOTE_STORAGE_FOURSHARED_CONSUMER_SECRET', '', '', true),
			'access_token' => $this->field('password', 4096,
				'REMOTE_STORAGE_FOURSHARED_ACCESS_TOKEN', 'REMOTE_STORAGE_FOURSHARED_ACCESS_TOKEN_EXPLAIN', '', true),
			'access_token_secret' => $this->field('password', 4096,
				'REMOTE_STORAGE_FOURSHARED_ACCESS_TOKEN_SECRET', '', '', true),
			'root_name' => $this->field('text', 255, 'REMOTE_STORAGE_FOURSHARED_ROOT_NAME',
				'REMOTE_STORAGE_FOURSHARED_ROOT_NAME_EXPLAIN', 'phpbbgallery'),
		];
	}

	public function config_key(string $field): string
	{
		if (!in_array($field, self::FIELDS, true))
		{
			throw new \InvalidArgumentException('The 4shared configuration field is invalid.');
		}

		return 'phpbb_gallery_fourshared_' . $field;
	}

	public function create(): \phpbbgallery\core\storage\provider_interface
	{
		return $this->provider($this->settings([]));
	}

	public function create_from(array $submitted): \phpbbgallery\core\storage\provider_interface
	{
		return $this->provider($this->settings($submitted));
	}

	public function environment_overrides(): array
	{
		$overrides = [];
		foreach (self::FIELDS as $field)
		{
			if ($this->external_value('PHPBBGALLERY_FOURSHARED_' . strtoupper($field)) !== false)
			{
				$overrides[] = $field;
			}
		}

		return $overrides;
	}

	/** @param array<string, string> $submitted @return array<string, string> */
	private function settings(array $submitted): array
	{
		$settings = [];
		foreach (self::FIELDS as $field)
		{
			$value = array_key_exists($field, $submitted) ? (string) $submitted[$field]
				: (string) ($this->config[$this->config_key($field)] ?? '');
			$external = $this->external_value('PHPBBGALLERY_FOURSHARED_' . strtoupper($field));
			$settings[$field] = trim($external === false ? $value : $external);
		}

		return $settings;
	}

	/** @param array<string, string> $settings */
	private function provider(array $settings): provider
	{
		$configuration = new configuration(
			$settings['consumer_key'],
			$settings['consumer_secret'],
			$settings['access_token'],
			$settings['access_token_secret'],
			$settings['root_name']
		);
		$api = new api_client(new oauth_signer($configuration), $this->client);

		return new provider($configuration, $api, new operation_lock($this->lock_path));
	}

	private function external_value(string $name): string|false
	{
		if ($this->environment !== null)
		{
			return array_key_exists($name, $this->environment) ? (string) $this->environment[$name] : false;
		}
		$value = $this->request->server($name, '');

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
