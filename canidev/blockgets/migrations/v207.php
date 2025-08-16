<?php
/**
 * @package cBB Blockgets
 * @version 2.0.7 26/01/2024
 *
 * @copyright (c) 2024 CaniDev
 * @license https://creativecommons.org/licenses/by-nc/4.0/
 */

namespace canidev\blockgets\migrations;

class v207 extends \canidev\blockgets\libraries\migration_base
{
	protected $version = '2.0.7';

	/**
	 * {@inheritDoc}
	 */
	static public function depends_on()
	{
		return [
			'\canidev\blockgets\migrations\v206',
		];
	}

	/**
	 * {@inheritDoc}
	 */
	public function _update_data()
	{
		return [];
	}
}
