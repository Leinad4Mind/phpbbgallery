<?php
/**
 * phpBB Gallery - Remote Storage Add-on
 *
 * @package   phpbbgallery/remotestorage
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\remotestorage\sftp;

use phpbb\request\request_interface;
use phpbbgallery\remotestorage\configured_provider_factory_interface;

final class configured_factory implements configured_provider_factory_interface
{
	private const FIELDS = ['host', 'port', 'username', 'password', 'host_fingerprint', 'root'];
	/** @var array<string, string>|null */
	private ?array $environment;

	/** @param array<string, string>|null $environment */
	public function __construct(private \ArrayAccess $config, private request_interface $request, ?array $environment = null)
	{
		$this->environment = $environment;
	}

	public function get_id(): string
 {
 return 'sftp'; }
	public function get_name_language_key(): string
 {
 return 'REMOTE_STORAGE_SFTP_SETTINGS'; }

	public function field_definitions(): array
	{
		return [
			'host' => $this->field('text', 253, 'REMOTE_STORAGE_SFTP_HOST'),
			'port' => $this->field('number', 5, 'REMOTE_STORAGE_SFTP_PORT', '', '22'),
			'username' => $this->field('text', 255, 'REMOTE_STORAGE_SFTP_USERNAME'),
			'password' => $this->field('password', 4096, 'REMOTE_STORAGE_SFTP_PASSWORD', '', '', true),
			'host_fingerprint' => $this->field('text', 59, 'REMOTE_STORAGE_SFTP_HOST_FINGERPRINT', 'REMOTE_STORAGE_SFTP_HOST_FINGERPRINT_EXPLAIN'),
			'root' => $this->field('text', 1024, 'REMOTE_STORAGE_SFTP_ROOT', 'REMOTE_STORAGE_SFTP_ROOT_EXPLAIN', '/phpbbgallery'),
		];
	}

	public function config_key(string $field): string
	{
		if (!in_array($field, self::FIELDS, true))
		{
			throw new \InvalidArgumentException('The SFTP configuration field is invalid.');
		}

		return 'phpbb_gallery_sftp_' . $field;
	}

	public function create(): \phpbbgallery\core\storage\provider_interface
 {
 return $this->create_from([]); }

	public function create_from(array $submitted): \phpbbgallery\core\storage\provider_interface
	{
		$settings = [];
		foreach (self::FIELDS as $field)
		{
			$value = array_key_exists($field, $submitted) ? (string) $submitted[$field]
				: (string) ($this->config[$this->config_key($field)] ?? '');
			$external = $this->external_value('PHPBBGALLERY_SFTP_' . strtoupper($field));
			$settings[$field] = $external === false ? $value : $external;
		}

		return (new factory($settings))->create();
	}

	public function environment_overrides(): array
	{
		$overrides = [];
		foreach (self::FIELDS as $field)
		{
			if ($this->external_value('PHPBBGALLERY_SFTP_' . strtoupper($field)) !== false)
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
	private function field(string $type, int $maxlength, string $label, string $explain = '', string $default = '', bool $secret = false): array
	{
		return compact('type', 'maxlength', 'label', 'explain', 'default', 'secret') + ['required' => true];
	}
}
