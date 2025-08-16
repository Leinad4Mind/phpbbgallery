<?php
/*
* @name release_1_1_1.php
* @package cBB Chat
* @version v1.1.1 01/07/2015
*
* @copyright (c) 2015 CaniDev
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/

namespace canidev\chat\migrations;

class release_1_1_1 extends \phpbb\db\migration\migration
{
	/**
	 * {@inheritdoc}
	 */
	public function effectively_installed()
	{
		return isset($this->config['chat_version']) && version_compare($this->config['chat_version'], '1.1.1', '>=');
	}

	/**
	 * {@inheritdoc}
	 */
	static public function depends_on()
	{
		return array(
			'\canidev\chat\migrations\release_1_1_0',
		);
	}

	/**
	 * {@inheritdoc}
	 */
	public function update_data()
	{
		return array(
			array('config.update', array('chat_version', '1.1.1')),
		);
	}
}
