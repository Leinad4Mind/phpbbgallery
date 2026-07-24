<?php
/**
 *
 * @package       Cron Status
 * @copyright (c) 2014 - 2021 Igor Lavrov, John Peskens | (c) 2022-2026 Leinad4Mind
 * @license       http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 */

namespace leinad4mind\cronstatus\migrations\v340;

class m1_config_data extends \phpbb\db\migration\migration
{
	public function effectively_installed()
	{
		return isset($this->config['cronstatus_default_sort']);
	}

	static public function depends_on()
	{
		return array('\phpbb\db\migration\data\v330\v330');
	}

	public function update_data()
	{
		return array(
			array('config.add', array('cronstatus_dateformat', '|d M Y|, H:i')),
			array('config.add', array('cronstatus_main_notice', 1)),
			array('config.add', array('cronstatus_default_sort', 'display_name|a')),
			array('config.add', array('cronstatus_run_always', 0)),
			array('config.add', array('cronstatus_latest_task', '')),
		);
	}
}
