<?php
/**
 * phpBB Gallery - Remote Storage Add-on
 *
 * @package   phpbbgallery/remotestorage
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\remotestorage\providers\mediafire;

use phpbb\db\driver\driver_interface;
use phpbb\request\request_interface;
use phpbbgallery\remotestorage\configured_provider_factory_interface;
use phpbbgallery\remotestorage\http\client_interface;
use phpbbgallery\remotestorage\rotating_credentials_factory_interface;

/** Combine MediaFire ACP configuration with safe process-level overrides. */
final class configured_factory implements configured_provider_factory_interface, rotating_credentials_factory_interface
{
	private const FIELDS = ['application_id', 'api_key', 'email', 'password', 'root_name'];
	private const INTERNAL_FIELDS = ['session_token', 'secret_key', 'session_time', 'session_issued_at'];
	/** @var array<string, string>|null */
	private ?array $environment;
	private ?memory_session_store $tested_store = null;

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
		return 'mediafire';
	}

	public function get_name_language_key(): string
	{
		return 'REMOTE_STORAGE_MEDIAFIRE_SETTINGS';
	}

	public function field_definitions(): array
	{
		return [
			'application_id' => $this->field('text', 20, 'REMOTE_STORAGE_MEDIAFIRE_APPLICATION_ID'),
			'api_key' => $this->field('password', 4096, 'REMOTE_STORAGE_MEDIAFIRE_API_KEY', '', '', true),
			'email' => $this->field('email', 254, 'REMOTE_STORAGE_MEDIAFIRE_EMAIL'),
			'password' => $this->field(
				'password',
				4096,
				'REMOTE_STORAGE_MEDIAFIRE_PASSWORD',
				'REMOTE_STORAGE_MEDIAFIRE_PASSWORD_EXPLAIN',
				'',
				true
			),
			'root_name' => $this->field(
				'text',
				255,
				'REMOTE_STORAGE_MEDIAFIRE_ROOT_NAME',
				'REMOTE_STORAGE_MEDIAFIRE_ROOT_NAME_EXPLAIN',
				'phpbbgallery'
			),
		];
	}

	public function config_key(string $field): string
	{
		if (!in_array($field, array_merge(self::FIELDS, self::INTERNAL_FIELDS), true))
		{
			throw new \InvalidArgumentException('The MediaFire configuration field is invalid.');
		}

		return 'phpbb_gallery_mediafire_' . $field;
	}

	public function create(): \phpbbgallery\core\storage\provider_interface
	{
		$configuration = $this->configuration($this->settings([]));
		$store = new config_session_store($this->config, $this->lock_file, $this->db, $this->config_table);

		return new provider($configuration, new api_client($configuration, $store, $this->client), $this->client);
	}

	public function create_from(array $submitted): \phpbbgallery\core\storage\provider_interface
	{
		$configuration = $this->configuration($this->settings($submitted));
		$this->tested_store = new memory_session_store();

		return new provider(
			$configuration,
			new api_client($configuration, $this->tested_store, $this->client),
			$this->client
		);
	}

	public function finalize_tested_settings(array $settings): array
	{
		if ($this->tested_store === null)
		{
			throw new \LogicException('The MediaFire connection has not been tested.');
		}
		$state = $this->tested_store->load();
		if ($state['session_token'] === '' || $state['secret_key'] <= 0
			|| $state['time'] === '' || $state['issued_at'] <= 0)
		{
			throw new \RuntimeException('The MediaFire connection test did not create valid signing state.');
		}
		$settings['session_token'] = $state['session_token'];
		$settings['secret_key'] = (string) $state['secret_key'];
		$settings['session_time'] = $state['time'];
		$settings['session_issued_at'] = (string) $state['issued_at'];

		return $settings;
	}

	public function environment_overrides(): array
	{
		$overrides = [];
		foreach (self::FIELDS as $field)
		{
			if ($this->external_value('PHPBBGALLERY_MEDIAFIRE_' . strtoupper($field)) !== false)
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
			$external = $this->external_value('PHPBBGALLERY_MEDIAFIRE_' . strtoupper($field));
			$settings[$field] = trim($external === false ? $value : $external);
		}

		return $settings;
	}

	/** @param array<string, string> $settings */
	private function configuration(array $settings): configuration
	{
		return new configuration(
			$settings['application_id'],
			$settings['api_key'],
			$settings['email'],
			$settings['password'],
			$settings['root_name']
		);
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
