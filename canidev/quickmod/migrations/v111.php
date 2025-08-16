<?php
/**
* @package cBB QuickMod
* @version v1.1.1 22/03/2019
*
* @copyright (c) 2019 CaniDev
* @license https://opensource.org/licenses/gpl-license.php GNU Public License
*/

namespace canidev\quickmod\migrations;

class v111 extends \phpbb\db\migration\migration
{
	/**
	 * {@inheritDoc}
	 */
	public function effectively_installed()
	{
		return isset($this->config['qm_version']) && version_compare($this->config['qm_version'], '1.1.1', '>=');
	}

	/**
	 * {@inheritDoc}
	 */
	static public function depends_on()
	{
		return array(
			'\canidev\quickmod\migrations\v110',
		);
	}

	/**
	 * {@inheritDoc}
	 */
	public function update_data()
	{
		return array(
			array('config.add', 	array('cbb_asset_check', 0)),
			array('config.update',	array('qm_version', '1.1.1')),
		);
	}
}
