<?php
/**
 * phpBB Gallery - Remote Storage Add-on
 *
 * @package   phpbbgallery/remotestorage
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\remotestorage;

use phpbbgallery\core\storage\provider_interface;

/** Build a configured remote provider without exposing stored credentials. */
interface configured_provider_factory_interface
{
	/** Return the stable provider identifier used by the Core storage service. */
	public function get_id(): string;

	/** Build the provider from persisted configuration and environment overrides. */
	public function create(): provider_interface;

	/**
	 * Build the provider from unpersisted ACP values for connection testing.
	 *
	 * @param array<string, string> $submitted
	 */
	public function create_from(array $submitted): provider_interface;

	/** Return fields whose persisted values are overridden by the environment. */
	public function environment_overrides(): array;
}
