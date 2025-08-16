<?php
/*
* @package cBB Chat
* @version v1.2.3 22/04/2022
*
* @copyright (c) 2022 CaniDev
* @license https://creativecommons.org/licenses/by-nc/4.0/
*/

namespace canidev\chat\migrations;

class v123 extends \phpbb\db\migration\migration
{
	/**
	 * {@inheritDoc}
	 */
	public function effectively_installed()
	{
		return isset($this->config['chat_version']) && version_compare($this->config['chat_version'], '1.2.3', '>=');
	}

	/**
	 * {@inheritDoc}
	 */
	static public function depends_on()
	{
		return array(
			'\canidev\chat\migrations\v122',
		);
	}

	/**
	 * {@inheritDoc}
	 */
	public function update_data()
	{
		return array(
			array('config.update',	array('chat_version', '1.2.3')),
		);
	}
}
