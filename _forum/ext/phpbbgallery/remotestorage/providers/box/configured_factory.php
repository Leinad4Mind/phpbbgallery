<?php
/**
 * phpBB Gallery - Remote Storage Add-on
 *
 * @package   phpbbgallery/remotestorage
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\remotestorage\providers\box;

use phpbb\request\request_interface;
use phpbb\db\driver\driver_interface;
use phpbbgallery\remotestorage\configured_provider_factory_interface;
use phpbbgallery\remotestorage\http\client_interface;
use phpbbgallery\remotestorage\rotating_credentials_factory_interface;

/** Combine Box ACP configuration with safe process-level overrides. */
final class configured_factory implements configured_provider_factory_interface, rotating_credentials_factory_interface
{
	private const FIELDS = ['client_id', 'client_secret', 'refresh_token', 'root_name'];
	private const INTERNAL_FIELDS = ['access_token', 'access_expires'];
	/** @var array<string, string>|null */
	private ?array $environment;
	private ?memory_token_store $tested_store = null;

	/** @param array<string, string>|null $environment */
	public function __construct(
		private client_interface $client,
		private \ArrayAccess $config,
		private request_interface $request,
		private driver_interface $db,
		private string $config_table,
		private string $lock_file,
		?array $environment = null
	)
	{
		$this->environment = $environment;
	}

	public function get_id(): string
	{
		return 'box';
	}

	public function get_name_language_key(): string
	{
		return 'REMOTE_STORAGE_BOX_SETTINGS';
	}

	public function field_definitions(): array
	{
		return [
			'client_id' => $this->field('text', 255, 'REMOTE_STORAGE_BOX_CLIENT_ID'),
			'client_secret' => $this->field('password', 4096, 'REMOTE_STORAGE_BOX_CLIENT_SECRET', '', '', true),
			'refresh_token' => $this->field(
				'password',
				4096,
				'REMOTE_STORAGE_BOX_REFRESH_TOKEN',
				'REMOTE_STORAGE_BOX_REFRESH_TOKEN_EXPLAIN',
				'',
				true
			),
			'root_name' => $this->field(
				'text',
				255,
				'REMOTE_STORAGE_BOX_ROOT_NAME',
				'REMOTE_STORAGE_BOX_ROOT_NAME_EXPLAIN',
				'phpbbgallery'
			),
		];
	}

	public function config_key(string $field): string
	{
		if (!in_array($field, array_merge(self::FIELDS, self::INTERNAL_FIELDS), true))
		{
			throw new \InvalidArgumentException('The Box configuration field is invalid.');
		}

		return 'phpbb_gallery_box_' . $field;
	}

	public function create(): \phpbbgallery\core\storage\provider_interface
	{
		$settings = $this->settings([]);
		$configuration = $this->configuration($settings);
		$store = new config_token_store($this->config, $this->lock_file, $this->db, $this->config_table);

		return new provider($configuration, new token_manager($configuration, $store, $this->client), $this->client);
	}

	public function create_from(array $submitted): \phpbbgallery\core\storage\provider_interface
	{
		$settings = $this->settings($submitted);
		$configuration = $this->configuration($settings);
		$this->tested_store = new memory_token_store($settings['refresh_token']);

		return new provider(
			$configuration,
			new token_manager($configuration, $this->tested_store, $this->client),
			$this->client
		);
	}

	public function finalize_tested_settings(array $settings): array
	{
		if ($this->tested_store === null)
		{
			throw new \LogicException('The Box connection has not been tested.');
		}
		$credentials = $this->tested_store->load();
		if ($credentials['refresh_token'] === '' || $credentials['access_token'] === ''
			|| $credentials['access_expires'] <= 0)
		{
			throw new \RuntimeException('The Box connection test did not rotate valid credentials.');
		}
		$settings['refresh_token'] = $credentials['refresh_token'];
		$settings['access_token'] = $credentials['access_token'];
		$settings['access_expires'] = (string) $credentials['access_expires'];

		return $settings;
	}

	public function environment_overrides(): array
	{
		$overrides = [];
		foreach (['client_id', 'client_secret', 'root_name'] as $field)
		{
			if ($this->external_value('PHPBBGALLERY_BOX_' . strtoupper($field)) !== false)
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
			if ($field !== 'refresh_token')
			{
				$external = $this->external_value('PHPBBGALLERY_BOX_' . strtoupper($field));
				$value = $external === false ? $value : $external;
			}
			$settings[$field] = trim($value);
		}

		return $settings;
	}

	/** @param array<string, string> $settings */
	private function configuration(array $settings): configuration
	{
		return new configuration($settings['client_id'], $settings['client_secret'], $settings['root_name']);
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
