<?php
/**
 * phpBB Gallery - Core Extension
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\image;

/** Contract implemented by trusted processors for browser-unsafe source formats. */
interface external_processor_interface
{
	/**
	 * Inspect an image without trusting its filename or client-supplied MIME type.
	 *
	 * @return array{extension: string, mime: string, width: int, height: int, filesize: int}|null
	 */
	public function inspect(string $source): ?array;

	/**
	 * Apply requested source transformations in place and return verified metadata.
	 *
	 * @param array{max_width: int, max_height: int, max_filesize: int, allow_resize: bool, rotation: int} $options
	 * @return array{extension: string, mime: string, width: int, height: int, filesize: int}|null
	 */
	public function prepare_source(string $source, array $options): ?array;

	/**
	 * Create one browser-safe WebP derivative and return verified metadata.
	 *
	 * @return array{extension: string, mime: string, width: int, height: int, filesize: int}|null
	 */
	public function create_derivative(string $source, string $destination, int $max_width, int $max_height, int $quality): ?array;
}
