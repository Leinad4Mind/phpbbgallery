<?php
/**
 * phpBB Gallery - Remote Storage Add-on
 *
 * @package   phpbbgallery/remotestorage
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\remotestorage\sftp;

final class factory
{
	/** @param array<string, string> $settings */
	public function __construct(private array $settings)
	{
	}

	public function create(): provider
	{
		$configuration = new configuration(
			(string) ($this->settings['host'] ?? ''),
			(int) ($this->settings['port'] ?? 22),
			(string) ($this->settings['username'] ?? ''),
			(string) ($this->settings['password'] ?? ''),
			(string) ($this->settings['host_fingerprint'] ?? ''),
			(string) ($this->settings['root'] ?? '/phpbbgallery')
		);

		return new provider($configuration, new native_client($configuration));
	}
}
