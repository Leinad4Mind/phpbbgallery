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
interface configured_provider_factory_interface extends \phpbbgallery\core\storage\provider_factory_interface
{
	/** Return the stable provider identifier used by the Core storage service. */
	public function get_id(): string;

	/** Return the language key used to label the provider in the ACP. */
	public function get_name_language_key(): string;

	/**
	 * Return validated ACP field metadata in display order.
	 *
	 * @return array<string, array{type: string, maxlength: int, label: string, explain: string, required: bool, secret: bool, default: string}>
	 */
	public function field_definitions(): array;

	/** Return the phpBB config key that persists a field. */
	public function config_key(string $field): string;

	/** Build the provider from persisted configuration and environment overrides. */
	public function create(): provider_interface;

	/**
	 * Build the provider from unpersisted ACP values for connection testing.
	 *
	 * @param array<string, string> $submitted
	 */
	public function create_from(array $submitted): provider_interface;

	/** @return list<string> Return fields whose persisted values are overridden by the environment. */
	public function environment_overrides(): array;
}
