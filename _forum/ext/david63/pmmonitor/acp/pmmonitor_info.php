<?php
/**
 * @package PM Monitor
 * @copyright (c) 2026 Leinad4Mind
 * @license GNU General Public License, version 2 (GPL-2.0)
 */

namespace david63\pmmonitor\acp;

class pmmonitor_info
{
	public function module()
	{
		return array(
			'filename' => '\\david63\\pmmonitor\\acp\\pmmonitor_module',
			'title' => 'ACP_PM_MONITOR',
			'modes' => array(
				'main' => array(
					'title' => 'ACP_PM_MONITOR',
					'auth' => 'ext_david63/pmmonitor && acl_a_pmmonitor_view',
					'cat' => array('ACP_CAT_USERS'),
				),
			),
		);
	}
}
