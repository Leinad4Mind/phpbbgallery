<?php
/*
* @package cBB QuickMod
* @version v1.1.3 16/04/2021
*
* @copyright (c) 2021 CaniDev
* @license https://opensource.org/licenses/gpl-license.php GNU Public License
*/

namespace canidev\quickmod\migrations;

class v113 extends \phpbb\db\migration\migration
{
	public function effectively_installed()
	{
		return isset($this->config['qm_version']) && version_compare($this->config['qm_version'], '1.1.3', '>=');
	}

	static public function depends_on()
	{
		return array(
			'\canidev\quickmod\migrations\v112',
		);
	}

	public function update_data()
	{
		return array(
			array('config.update',	array('qm_version', '1.1.3')),
		);
	}
}
