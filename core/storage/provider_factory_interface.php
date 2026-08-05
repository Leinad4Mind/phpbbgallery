<?php
/**
 * phpBB Gallery - Core Extension
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\storage;

/** Create one non-local storage provider only when it is selected. */
interface provider_factory_interface
{
	public function get_id(): string;

	public function create(): provider_interface;
}
