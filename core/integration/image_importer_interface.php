<?php
/**
 * phpBB Gallery - Core Extension
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\integration;

/** Public service contract for optional extensions which publish into Gallery. */
interface image_importer_interface
{
	public const CONTRACT_VERSION = 1;

	public function get_capabilities(): array;

	/**
	 * @throws image_import_exception
	 */
	public function import(image_import_request $request): image_import_result;
}
