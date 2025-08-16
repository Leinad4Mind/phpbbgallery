<?php
/**
 * @package cBB Blockgets
 * @version 2.0.5 15/01/2023
 *
 * @copyright (c) 2023 CaniDev
 * @license https://creativecommons.org/licenses/by-nc/4.0/
 */

namespace canidev\blockgets\libraries;

abstract class migration_base extends \phpbb\db\migration\migration
{
	protected $version = '';

	/**
	 * {@inheritDoc}
	 */
	public function effectively_installed()
	{
		return isset($this->config['blg_version']) && version_compare($this->config['blg_version'], $this->version, '>=');
	}

	/**
	 * {@inheritDoc}
	 */
	public function update_data()
	{
		$actions = [
			['config.update',	['blg_version', $this->version]],
		];

		return array_merge($actions, $this->_update_data());
	}

	/**
	 * Add extra steps for update
	 * @return array
	 */
	public function _update_data()
	{
		return [];
	}
}
