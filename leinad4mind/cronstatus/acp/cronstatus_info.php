<?php
/**
 *
 * @package       Cron Status
 * @copyright (c) 2014 - 2021 Igor Lavrov, John Peskens | (c) 2022-2026 Leinad4Mind
 * @license       http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 */

namespace leinad4mind\cronstatus\acp;

class cronstatus_info
{
	public function module()
	{
		return array(
			'filename' => 'leinad4mind\cronstatus\acp\cronstatus_module',
			'title'    => 'ACP_CRON_STATUS_TITLE',
			'version'  => '3.4.0',
			'modes'    => array(
				'config' => array(
					'title' => 'ACP_CRON_STATUS_CONFIG_TITLE',
					'auth'  => 'ext_leinad4mind/cronstatus',
					'cat'   => array('ACP_FORUM_LOGS'),
				),
			),
		);
	}

	public function install()
	{
	}

	public function uninstall()
	{
	}
}
