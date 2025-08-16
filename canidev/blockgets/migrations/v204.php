<?php
/**
* @package cBB Blockgets
* @version v2.0.4 30/08/2021
*
* @copyright (c) 2021 CaniDev
* @license https://creativecommons.org/licenses/by-nc/4.0/
*/

namespace canidev\blockgets\migrations;

class v204 extends \canidev\blockgets\libraries\migration_base
{
	protected $version = '2.0.4';

	static public function depends_on()
	{
		return array(
			'\canidev\blockgets\migrations\v203',
		);
	}

	public function update_schema()
	{
		return array(
			'change_columns' => array(
				$this->table_prefix . 'blockgets_pages'	=> array(
					'page_groups'	=> ['VCHAR:255', 'all'],
				),
			),
		);
	}
}
