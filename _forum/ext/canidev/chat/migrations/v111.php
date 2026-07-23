<?php
/*
* @name v111.php
* @package cBB Chat
* @version v1.1.1 01/07/2015
*
* @copyright (c) 2015 CaniDev
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/

namespace canidev\chat\migrations;

class v111 extends \phpbb\db\migration\migration
{
	/**
	 * {@inheritdoc}
	 */
	public function effectively_installed()
	{
		// "chat_version" is deprecated, migration ignored
		return true;
	}

	/**
	 * {@inheritdoc}
	 */
	static public function depends_on()
	{
		return array(
			'\canidev\chat\migrations\v110',
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
