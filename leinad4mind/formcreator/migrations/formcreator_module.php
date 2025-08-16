<?php
/**
*
* @package phpBB Extension - Form Creator
* @copyright (c) 2017 dmzx - http://www.dmzx-web.net & michaelo - http://www.phpbbireland.com
* @copyright (c) 2019 Leinad4Mind - https://leinad4mind.top/forum
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace leinad4mind\formcreator\migrations;

class formcreator_module extends \phpbb\db\migration\migration
{
	public function update_data()
	{
		return array(
			array('module.add', array('acp', 'ACP_CAT_DOT_MODS', 'ACP_FORM_CREATOR')),
			array('module.add', array(
			'acp', 'ACP_FORM_CREATOR', array(
					'module_basename'	=> '\leinad4mind\formcreator\acp\formcreator_module', 'modes' => array('manage'),
				),
			)),
		);
	}
}
