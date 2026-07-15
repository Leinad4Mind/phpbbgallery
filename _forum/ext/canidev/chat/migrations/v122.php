<?php
/*
* @package cBB Chat
* @version v1.2.2 29/03/2021
*
* @copyright (c) 2021 CaniDev
* @license https://creativecommons.org/licenses/by-nc/4.0/
*/

namespace canidev\chat\migrations;

class v122 extends \phpbb\db\migration\migration
{
	public function effectively_installed()
	{
		return isset($this->config['chat_version']) && version_compare($this->config['chat_version'], '1.2.2', '>=');
	}

	static public function depends_on()
	{
		return array(
			'\canidev\chat\migrations\v121',
		);
	}

	public function update_data()
	{
		return array(
			array('config.add',		array('chat_row_align', 'left')),
			array('config.add',		array('chat_row_format', 'normal')),
			array('config.update',	array('chat_version', '1.2.2')),
		);
	}
}
