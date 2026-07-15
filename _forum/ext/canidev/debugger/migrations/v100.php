<?php
/*
* @package cBB Debugger
* @version v1.0.0 21/06/2021
*
* @copyright (c) 2021 CaniDev
* @license https://opensource.org/licenses/gpl-license.php GNU Public License
*/

namespace canidev\debugger\migrations;

class v100 extends \phpbb\db\migration\migration
{
	public function effectively_installed()
	{
		return isset($this->config['debugger_version']) && version_compare($this->config['debugger_version'], '1.0.0', '>=');
	}

	public function update_data()
	{
		return array(
			array('config.add', array('cbb_asset_check', 0)),
			array('config.add', array('debugger_version', '1.0.0')),

			array('module.add', array(
				'acp',
				'ACP_GENERAL_TASKS',
				array(
					'module_basename'	=> '\canidev\debugger\acp\main_module',
					'modes'				=> array('config'),
				),
			)),
		);
	}
}
