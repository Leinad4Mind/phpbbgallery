<?php
/**
 * @package cBB Blockgets
 * @version 2.0.5 15/01/2023
 *
 * @copyright (c) 2023 CaniDev
 * @license https://creativecommons.org/licenses/by-nc/4.0/
 */

namespace canidev\blockgets\migrations;

class v205 extends \canidev\blockgets\libraries\migration_base
{
	protected $version = '2.0.5';

	/**
	 * {@inheritDoc}
	 */
	static public function depends_on()
	{
		return [
			'\canidev\blockgets\migrations\v204',
		];
	}

	/**
	 * {@inheritDoc}
	 */
	public function _update_data()
	{
		return [
			['permission.add', 				['u_blockgets_birthdays', true]],
			['permission.permission_set', 	['REGISTERED', 'u_blockgets_birthdays', 'group']],
		];
	}
}
