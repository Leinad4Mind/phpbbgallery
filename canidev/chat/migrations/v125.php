<?php
/**
 * @package cBB Chat
 * @version 1.2.5 01/02/2023
 *
 * @copyright (c) 2023 CaniDev
 * @license https://creativecommons.org/licenses/by-nc/4.0/
 */

namespace canidev\chat\migrations;

class v125 extends \phpbb\db\migration\migration
{
	/**
	 * {@inheritDoc}
	 */
	public function effectively_installed()
	{
		// "chat_version" is deprecated, migration ignored
		return true;
	}

	/**
	 * {@inheritDoc}
	 */
	static public function depends_on()
	{
		return [
			'\canidev\chat\migrations\v124',
		];
	}

	/**
	 * {@inheritDoc}
	 */
	public function update_data()
	{
		return [
			['config.update',	['chat_version', '1.2.5']],
		];
	}
}
