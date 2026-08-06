<?php
/**
 * phpBB Gallery - Remote Storage Add-on
 *
 * @package   phpbbgallery/remotestorage
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\remotestorage\providers\dropbox;

use phpbbgallery\remotestorage\http\client_interface;

/** Build a Dropbox provider from validated process-level settings. */
final class factory
{
	/** @param array<string, string> $environment */
	public function __construct(private client_interface $client, private array $environment)
	{
	}

	public function create(): provider
	{
		$configuration = new configuration(
			$this->value('PHPBBGALLERY_DROPBOX_APP_KEY'),
			$this->value('PHPBBGALLERY_DROPBOX_APP_SECRET'),
			$this->value('PHPBBGALLERY_DROPBOX_REFRESH_TOKEN'),
			$this->value('PHPBBGALLERY_DROPBOX_ROOT', '/phpbbgallery')
		);

		return new provider($configuration, new token_manager($configuration, $this->client), $this->client);
	}

	private function value(string $name, string $default = ''): string
	{
		return trim((string) ($this->environment[$name] ?? $default));
	}
}
