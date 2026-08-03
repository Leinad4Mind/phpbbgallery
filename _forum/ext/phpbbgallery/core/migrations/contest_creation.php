<?php
/**
 * phpBB Gallery - Core Extension
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\migrations;

use phpbb\db\migration\migration;

/**
 * Preserve the historical migration identifier after ownership moved to the
 * optional Contest add-on.
 */
class contest_creation extends migration
{
	public static function depends_on(): array
	{
		return ['\phpbbgallery\core\migrations\image_subtitle'];
	}

}
