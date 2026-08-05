<?php
/**
 * phpBB Gallery - Core Extension
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\storage;

/**
 * Storage backend contract used by the Gallery.
 *
 * Providers receive opaque, validated keys. They must never make stored objects
 * publicly accessible without passing through the Gallery authorization layer.
 */
interface provider_interface
{
	public const SOURCE = 'source';
	public const MEDIUM = 'medium';
	public const MINI = 'mini';

	/** Return the stable provider identifier. */
	public function get_id(): string;

	/** Prepare the provider to store an object. */
	public function prepare(string $variant, string $key): bool;

	/** Copy a local file into the provider. */
	public function write(string $variant, string $key, string $local_file): bool;

	/** Open an object as a readable stream resource. */
	public function open_stream(string $variant, string $key): mixed;

	/** Return a local path when the provider can expose one directly. */
	public function local_path(string $variant, string $key): ?string;

	public function exists(string $variant, string $key): bool;

	public function delete(string $variant, string $key): bool;

	public function size(string $variant, string $key): ?int;

	public function checksum(string $variant, string $key, string $algorithm = 'sha256'): ?string;
}
