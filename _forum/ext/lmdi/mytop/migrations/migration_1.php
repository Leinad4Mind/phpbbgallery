<?php
/**
*
* @package phpBB Extension - LMDI Mytop
* @copyright (c) 2017 Pierre Duhem - LMDI
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace lmdi\mytop\migrations;

class migration_1 extends \phpbb\db\migration\migration
{

	public function effectively_installed()
	{
		return isset($this->config['lmdi_mytop']);
	}


	static public function depends_on()
	{
		return array('\phpbb\db\migration\data\v310\alpha2');
	}


	public function update_data()
	{
		return array(
			array('module.add', array('acp', 'ACP_CAT_DOT_MODS', 'ACP_MYTOP_TITLE')),
			array('module.add', array('acp', 'ACP_MYTOP_TITLE', array(
					'module_basename'	=> '\lmdi\mytop\acp\mytop_module',
					'auth'			=> 'ext_lmdi/mytop && acl_a_board',
					'modes'			=> array('settings'),
					),
			)),

			array('config.add', array('lmdi_mytop', 0)),
		);
	}

}
