<?php
/*
* @package cBB Blockgets
* @version v2.0.3 26/07/2021
*
* @copyright (c) 2021 CaniDev
* @license https://creativecommons.org/licenses/by-nc/4.0/
*/

namespace canidev\blockgets\migrations;

class v203 extends \canidev\blockgets\libraries\migration_base
{
	protected $version = '2.0.3';

	static public function depends_on()
	{
		return array(
			'\canidev\blockgets\migrations\v202',
		);
	}

	public function _update_data()
	{
		return [
			['custom', [[$this, 'update_block_config']]],
		];
	}

	public function update_block_config()
	{
		$block_manager = new \canidev\blockgets\libraries\block_manager($this->db, $this->table_prefix);

		$block_manager->add_config(array(
			'gallery_block'	=> ['image_order' 	=> 'rand'],
			'login_block'	=> ['alt_login' 	=> 1],
		));
	}
}
