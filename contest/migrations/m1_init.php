<?php
/**
 * phpBB Gallery - Contest Add-on initial migration.
 *
 * @package   phpbbgallery/contest
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\contest\migrations;

use phpbb\db\migration\migration;

class m1_init extends migration
{
	/**
	 * Start after the Core 4.0.0 compatibility baseline.
	 */
	public static function depends_on(): array
	{
		return ['\phpbbgallery\core\migrations\release_4_0_0'];
	}
}
