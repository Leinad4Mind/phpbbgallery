<?php
/**
 *
 * @package       Cron Status
 * @copyright (c) 2014 - 2021 Igor Lavrov, John Peskens | (c) 2022-2026 Leinad4Mind
 * @license       http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 */

namespace leinad4mind\cronstatus\migrations\v340;

class m2_acp_module extends \phpbb\db\migration\migration
{
	static public function depends_on()
	{
		return array('\leinad4mind\cronstatus\migrations\v340\m1_config_data');
	}

	public function update_data()
	{
		return array(
			array('module.add', array(
				'acp', 'ACP_FORUM_LOGS', array(
					'module_basename' => '\leinad4mind\cronstatus\acp\cronstatus_module',
					'auth'            => 'ext_leinad4mind/cronstatus',
					'modes'           => array('config'),
				),
			)),
		);
	}
}
