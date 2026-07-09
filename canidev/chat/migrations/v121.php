<?php
/*
* @package cBB Chat
* @version v1.2.1 01/02/2020
*
* @copyright (c) 2020 CaniDev
* @license https://creativecommons.org/licenses/by-nc/4.0/
*/

namespace canidev\chat\migrations;

class v121 extends \phpbb\db\migration\migration
{
	public function effectively_installed()
	{
		return $this->config->offsetExists('chat_hide_popup');
	}

	static public function depends_on()
	{
		return array(
			'\canidev\chat\migrations\v120',
		);
	}

	public function update_data()
	{
		return array(
			array('config.add',		array('chat_hide_popup', 0)),
			array('config.update',	array('chat_version', '1.2.1')),
		);
	}
}
