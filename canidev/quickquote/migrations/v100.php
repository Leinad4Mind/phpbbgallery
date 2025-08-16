<?php
/*
* @name v100.php
* @package cBB QuickQuote
* @version 1.0.0 01/03/2018
*
* @copyright (c) 2018 CaniDev
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/

namespace canidev\quickquote\migrations;

class v100 extends \phpbb\db\migration\migration
{
	public function effectively_installed()
	{
		return isset($this->config['quickquote_version']) && version_compare($this->config['quickquote_version'], '1.0.0', '>=');
	}

	public function update_schema()
	{
		return array();
	}

	public function revert_schema()
	{
		return array();
	}

	public function update_data()
	{
		return array(
			array('config.add', array('quickquote_version', '1.0.0')),
			array('config.add', array('quickquote_floatbtn', 1)),
			array('config.add', array('quickquote_groups', 'all')),
			array('config.add', array('cbb_asset_check', 0)),

			array('module.add', array('acp', 'ACP_CAT_DOT_MODS', 'ACP_CAT_QUICKQUOTE')),
			
			array('module.add', array(
				'acp',
				'ACP_CAT_QUICKQUOTE',
				array(
					'module_basename'	=> '\canidev\quickquote\acp\config_module',
					'modes'				=> array('config'),
				),
			)),
		);
	}
}
