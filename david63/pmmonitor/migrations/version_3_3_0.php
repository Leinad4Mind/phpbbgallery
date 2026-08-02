<?php
/**
 * @package PM Monitor
 * @copyright (c) 2026 Leinad4Mind
 * @license GNU General Public License, version 2 (GPL-2.0)
 */

namespace david63\pmmonitor\migrations;

use phpbb\db\migration\migration;

class version_3_3_0 extends migration
{
	public static function depends_on()
	{
		return '\\david63\\pmmonitor\\migrations\\version_2_1_0';
	}

	public function update_data()
	{
		return array(
			array('permission.add', array('a_pmmonitor_view', true)),
			array('permission.add', array('a_pmmonitor_delete', true)),
			array('permission.permission_set', array('ROLE_ADMIN_FULL', 'a_pmmonitor_view')),
			array('permission.permission_set', array('ROLE_ADMIN_FULL', 'a_pmmonitor_delete')),
		);
	}
}
