<?php
/**
* @package cBB QuickMod
* @version 1.1.4 01/06/2022
*
* @copyright (c) 2022 CaniDev
* @license https://creativecommons.org/licenses/by-nc/4.0/
*/

namespace canidev\quickmod\migrations;

class v114 extends \phpbb\db\migration\migration
{
	/**
	 * {@inheritDoc}
	 */
	public function effectively_installed()
	{
		return isset($this->config['qm_version']) && version_compare($this->config['qm_version'], '1.1.4', '>=');
	}

	/**
	 * {@inheritDoc}
	 */
	static public function depends_on()
	{
		return array(
			'\canidev\quickmod\migrations\v113',
		);
	}

	/**
	 * {@inheritDoc}
	 */
	public function update_data()
	{
		return array(
			array('config.update',	array('qm_version', '1.1.4')),
		);
	}
}
