<?php
/**
 * phpBB Gallery - Remote Storage Add-on
 *
 * @package   phpbbgallery/remotestorage
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\remotestorage\sftp;

interface client_interface
{
	public function ensure_directory(string $path): bool;
	public function upload(string $remote_path, string $local_file, bool $create_only): bool;
	public function open_read(string $path): mixed;
	/** @return array{size: int, mtime: int}|null */
	public function stat(string $path): ?array;
	public function delete(string $path): bool;
	/** @return iterable<string> */
	public function list_files(string $root): iterable;
}
