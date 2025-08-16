<?php
/**
* @package cBB QuickMod
* @version 1.1.0 17/01/2017
*
* @copyright (c) 2017 CaniDev
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/

namespace canidev\quickmod\migrations;

class v110 extends \phpbb\db\migration\migration
{
	/**
	 * {@inheritDoc}
	 */
	public function effectively_installed()
	{
		return isset($this->config['qm_version']) && version_compare($this->config['qm_version'], '1.1.0', '>=');
	}

	/**
	 * {@inheritDoc}
	 */
	public function update_data()
	{
		return array(
			array('config.add', array('qm_buttons', 'rename,approve,delete,restore,lock,unlock,make_normal,make_sticky')),
			array('config.add', array('qm_confirm', 1)),
			array('config.add', array('qm_type', 'icon')),
			array('config.add', array('qm_version', '1.1.0')),
	
			array('module.add', array(
				'acp',
				'ACP_CAT_DOT_MODS',
				'ACP_CAT_QUICKMOD'
			)),
			array('module.add', array(
				'acp',
				'ACP_CAT_QUICKMOD',
				array(
					'module_basename'	=> '\canidev\quickmod\acp\main_module',
					'modes'				=> array('config'),
				),
			)),
		);
	}
}
