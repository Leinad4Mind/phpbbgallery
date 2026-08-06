<?php
/**
 * phpBB Gallery - Remote Storage Add-on
 *
 * @package   phpbbgallery/remotestorage
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\remotestorage;

/** Persist credentials rotated while an ACP connection test is running. */
interface rotating_credentials_factory_interface
{
	/**
	 * Return the tested settings with their current rotated credentials.
	 *
	 * @param array<string, string> $settings
	 * @return array<string, string>
	 */
	public function finalize_tested_settings(array $settings): array;
}
