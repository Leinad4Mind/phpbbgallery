<?php
/**
* @package cBB QuickMod
* @version v1.1.2 01/03/2020
*
* @copyright (c) 2020 CaniDev
* @license https://opensource.org/licenses/gpl-license.php GNU Public License
*/

namespace canidev\quickmod\migrations;

class v112 extends \phpbb\db\migration\migration
{
	/**
	 * {@inheritDoc}
	 */
	public function effectively_installed()
	{
		return isset($this->config['qm_version']) && version_compare($this->config['qm_version'], '1.1.2', '>=');
	}

	/**
	 * {@inheritDoc}
	 */
	static public function depends_on()
	{
		return array(
			'\canidev\quickmod\migrations\v111',
		);
	}

	/**
	 * {@inheritDoc}
	 */
	public function update_data()
	{
		return array(
			array('config.update',	array('qm_version', '1.1.2')),
		);
	}
}
