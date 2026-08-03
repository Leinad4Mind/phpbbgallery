<?php
/**
 * @package User Defaults
 * @copyright (c) 2022 devspace
 * @copyright (c) 2026 Leinad4Mind
 * @license GNU General Public License, version 2 (GPL-2.0)
 */

namespace devspace\userdefaults\migrations;

use phpbb\db\migration\migration;

/** Remove settings no longer used by the hardened implementation. */
class version_3_3_1 extends migration
{
	/** @return string */
	public static function depends_on()
	{
		return '\\devspace\\userdefaults\\migrations\\version_3_3_0';
	}

	/** @return array */
	public function update_data()
	{
		return array(
			array('config.remove', array('ud_allow_viewonline')),
			array('config.remove', array('ud_notifications')),
		);
	}
}
