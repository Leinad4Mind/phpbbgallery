<?php
/**
*
* BBtracking
*
* @copyright (c) 2018 Ken F. Innes IV <https://www.absoluteanime.com>
* @license GNU General Public License, version 2 (GPL-2.0)
*
* @copyright (c) 2017, Sitesplat
* @license private
*/

namespace sitesplat\bbtracking\migrations;

class m2_initial_modules extends \phpbb\db\migration\migration
{
	static public function depends_on()
	{
		return array('\sitesplat\bbtracking\migrations\m1_initial_schema');
	}

	public function update_data()
	{
		return array(
			array('module.add', array(
				'acp',
				'ACP_CAT_DOT_MODS',
				'ACP_BBTRACKING'
			)),
			array('module.add', array(
				'acp',
				'ACP_BBTRACKING',
				array(
					'module_basename'	=> '\sitesplat\bbtracking\acp\main_module',
					'modes'				=> array('settings', 'logs'),
				),
			)),
		);
	}
}
