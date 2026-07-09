<?php
/**
 * @package cBB QuickMod
 * @version 1.1.5 20/10/2023
 *
 * @copyright (c) 2023 CaniDev
 * @license https://creativecommons.org/licenses/by-nc/4.0/
 */

namespace canidev\quickmod\migrations;

class v115 extends \phpbb\db\migration\migration
{
	/**
	 * {@inheritDoc}
	 */
	public function effectively_installed()
	{
		return isset($this->config['qm_version']) && version_compare($this->config['qm_version'], '1.1.5', '>=');
	}

	/**
	 * {@inheritDoc}
	 */
	static public function depends_on()
	{
		return [
			'\canidev\quickmod\migrations\v114',
		];
	}

	/**
	 * {@inheritDoc}
	 */
	public function update_data()
	{
		return [
			['config.update',	['qm_version', '1.1.5']],
		];
	}
}
