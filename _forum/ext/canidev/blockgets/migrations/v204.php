<?php
/*
* @package cBB Blockgets
* @version v2.0.4 30/08/2021
*
* @copyright (c) 2021 CaniDev
* @license https://opensource.org/licenses/gpl-license.php GNU Public License
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
		$this->prepare();

		return array(
			'change_columns' => array(
				BLG_PAGES_TABLE	=> array(
					'page_groups'	=> array('VCHAR:255', 'all'),
				),
			),
		);
	}
}
