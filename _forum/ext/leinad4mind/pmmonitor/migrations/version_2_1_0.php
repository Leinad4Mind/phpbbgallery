<?php
/**
 * @package PM Monitor
 * @copyright (c) 2026 Leinad4Mind
 * @license GNU General Public License, version 2 (GPL-2.0)
 */

namespace leinad4mind\pmmonitor\migrations;

use phpbb\db\migration\migration;

class version_2_1_0 extends migration
{
	public function update_data()
	{
		return array(
			array('module.add', array('acp', 'ACP_CAT_USERS', 'ACP_USER_UTILS')),
			array('module.add', array(
				'acp',
				'ACP_USER_UTILS',
				array(
					'module_basename' => '\\leinad4mind\\pmmonitor\\acp\\pmmonitor_module',
					'modes' => array('main'),
				),
			)),
			array('permission.add', array('a_pmmonitor_view', true)),
			array('permission.add', array('a_pmmonitor_delete', true)),
			array('permission.permission_set', array('ROLE_ADMIN_FULL', 'a_pmmonitor_view')),
			array('permission.permission_set', array('ROLE_ADMIN_FULL', 'a_pmmonitor_delete')),
		);
	}
}
