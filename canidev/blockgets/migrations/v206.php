<?php
/**
 * @package cBB Blockgets
 * @version 2.0.6 20/09/2023
 *
 * @copyright (c) 2023 CaniDev
 * @license https://creativecommons.org/licenses/by-nc/4.0/
 */

namespace canidev\blockgets\migrations;

class v206 extends \canidev\blockgets\libraries\migration_base
{
	protected $version = '2.0.6';

	/**
	 * {@inheritDoc}
	 */
	static public function depends_on()
	{
		return [
			'\canidev\blockgets\migrations\v205',
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
