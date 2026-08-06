<?php
/**
 * phpBB Gallery - Remote Storage Add-on
 *
 * @package   phpbbgallery/remotestorage
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\remotestorage\google_drive;

use phpbb\request\request_interface;
use phpbbgallery\remotestorage\configured_provider_factory_interface;
use phpbbgallery\remotestorage\http\client_interface;

/** Combine Google Drive ACP configuration with optional environment overrides. */
final class configured_factory implements configured_provider_factory_interface
{
	private const FIELDS = ['client_id', 'client_secret', 'refresh_token', 'root_name'];
	/** @var array<string, string>|null */
	private ?array $environment;

	/** @param array<string, string>|null $environment */
	public function __construct(
		private client_interface $client,
		private \ArrayAccess $config,
		private request_interface $request,
		?array $environment = null
	)
	{
		$this->environment = $environment;
	}

	public function get_id(): string
	{
		return 'google_drive';
	}

	public function get_name_language_key(): string
	{
		return 'REMOTE_STORAGE_GOOGLE_DRIVE_SETTINGS';
	}

	public function field_definitions(): array
	{
		return [
			'client_id' => $this->field('text', 255, 'REMOTE_STORAGE_GOOGLE_DRIVE_CLIENT_ID'),
			'client_secret' => $this->field('password', 4096, 'REMOTE_STORAGE_GOOGLE_DRIVE_CLIENT_SECRET', '', '', true),
			'refresh_token' => $this->field(
				'password',
				4096,
				'REMOTE_STORAGE_GOOGLE_DRIVE_REFRESH_TOKEN',
				'REMOTE_STORAGE_GOOGLE_DRIVE_REFRESH_TOKEN_EXPLAIN',
				'',
				true
			),
			'root_name' => $this->field(
				'text',
				255,
				'REMOTE_STORAGE_GOOGLE_DRIVE_ROOT_NAME',
				'REMOTE_STORAGE_GOOGLE_DRIVE_ROOT_NAME_EXPLAIN',
				'phpbbgallery'
			),
		];
	}

	public function config_key(string $field): string
	{
		if (!in_array($field, self::FIELDS, true))
		{
			throw new \InvalidArgumentException('The Google Drive configuration field is invalid.');
		}

		return 'phpbb_gallery_google_drive_' . $field;
	}

	public function create(): \phpbbgallery\core\storage\provider_interface
	{
		return $this->create_from([]);
	}

	public function create_from(array $submitted): \phpbbgallery\core\storage\provider_interface
	{
		$settings = [];
		foreach (self::FIELDS as $field)
		{
			$value = array_key_exists($field, $submitted) ? (string) $submitted[$field]
				: (string) ($this->config[$this->config_key($field)] ?? '');
			$external = $this->external_value('PHPBBGALLERY_GOOGLE_DRIVE_' . strtoupper($field));
			$settings[$field] = $external === false ? $value : $external;
		}

		return (new factory($this->client, [
			'PHPBBGALLERY_GOOGLE_DRIVE_CLIENT_ID' => $settings['client_id'],
			'PHPBBGALLERY_GOOGLE_DRIVE_CLIENT_SECRET' => $settings['client_secret'],
			'PHPBBGALLERY_GOOGLE_DRIVE_REFRESH_TOKEN' => $settings['refresh_token'],
			'PHPBBGALLERY_GOOGLE_DRIVE_ROOT_NAME' => $settings['root_name'],
		]))->create();
	}

	public function environment_overrides(): array
	{
		$overrides = [];
		foreach (self::FIELDS as $field)
		{
			if ($this->external_value('PHPBBGALLERY_GOOGLE_DRIVE_' . strtoupper($field)) !== false)
			{
				$overrides[] = $field;
			}
		}

		return $overrides;
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
