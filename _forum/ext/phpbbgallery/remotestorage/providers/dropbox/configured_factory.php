<?php
/**
 * phpBB Gallery - Remote Storage Add-on
 *
 * @package   phpbbgallery/remotestorage
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\remotestorage\providers\dropbox;

use phpbb\request\request_interface;
use phpbbgallery\remotestorage\configured_provider_factory_interface;
use phpbbgallery\remotestorage\http\client_interface;

/** Combine Dropbox ACP configuration with optional environment overrides. */
final class configured_factory implements configured_provider_factory_interface
{
	private const FIELDS = ['app_key', 'app_secret', 'refresh_token', 'root'];
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
		return 'dropbox';
	}

	public function get_name_language_key(): string
	{
		return 'REMOTE_STORAGE_DROPBOX_SETTINGS';
	}

	public function field_definitions(): array
	{
		return [
			'app_key' => $this->field('text', 255, 'REMOTE_STORAGE_DROPBOX_APP_KEY'),
			'app_secret' => $this->field('password', 4096, 'REMOTE_STORAGE_DROPBOX_APP_SECRET', '', '', true),
			'refresh_token' => $this->field(
				'password',
				4096,
				'REMOTE_STORAGE_DROPBOX_REFRESH_TOKEN',
				'REMOTE_STORAGE_DROPBOX_REFRESH_TOKEN_EXPLAIN',
				'',
				true
			),
			'root' => $this->field(
				'text',
				512,
				'REMOTE_STORAGE_DROPBOX_ROOT',
				'REMOTE_STORAGE_DROPBOX_ROOT_EXPLAIN',
				'/phpbbgallery'
			),
		];
	}

	public function config_key(string $field): string
	{
		if (!in_array($field, self::FIELDS, true))
		{
			throw new \InvalidArgumentException('The Dropbox configuration field is invalid.');
		}

		return 'phpbb_gallery_dropbox_' . $field;
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
			$external = $this->external_value('PHPBBGALLERY_DROPBOX_' . strtoupper($field));
			$settings[$field] = $external === false ? $value : $external;
		}

		return (new factory($this->client, [
			'PHPBBGALLERY_DROPBOX_APP_KEY' => $settings['app_key'],
			'PHPBBGALLERY_DROPBOX_APP_SECRET' => $settings['app_secret'],
			'PHPBBGALLERY_DROPBOX_REFRESH_TOKEN' => $settings['refresh_token'],
			'PHPBBGALLERY_DROPBOX_ROOT' => $settings['root'],
		]))->create();
	}

	public function environment_overrides(): array
	{
		$overrides = [];
		foreach (self::FIELDS as $field)
		{
			if ($this->external_value('PHPBBGALLERY_DROPBOX_' . strtoupper($field)) !== false)
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
