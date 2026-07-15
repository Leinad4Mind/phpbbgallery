<?php
/*
* @name v113.php
* @package cBB Chat
* @version v1.1.3 10/03/2017
*
* @copyright (c) 2017 CaniDev
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/

namespace canidev\chat\migrations;

class v113 extends \phpbb\db\migration\migration
{
	public function effectively_installed()
	{
		return isset($this->config['chat_version']) && version_compare($this->config['chat_version'], '1.1.3', '>=');
	}

	static public function depends_on()
	{
		return array(
			'\canidev\chat\migrations\v112',
		);
	}

	public function update_data()
	{
		return array(
			array('config.add',		array('chat_purge_mark', 0)),
			array('config.add',		array('chat_anonymous_allowed', 0)),
			array('config.update',	array('chat_version', '1.1.3p')),

			array('module.add', array(
				'mcp',
				'MCP_BAN',
				array(
					'module_basename'	=> '\canidev\chat\mcp\main_module',
					'modes'				=> array('config'),
				),
			)),
		);
	}
}
