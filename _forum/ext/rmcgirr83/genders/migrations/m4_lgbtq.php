<?php
/**
*
* @package Genders
* @copyright (c) 2015 Rich Mcgirr (RMcGirr83)
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace rmcgirr83\genders\migrations;

class m4_lgbtq extends \phpbb\db\migration\migration
{
	public function effectively_installed()
	{
		return isset($this->config['gender_required']);
	}

	static public function depends_on()
	{
		return array('\rmcgirr83\genders\migrations\m3_required');
	}

	public function update_data()
	{
		return array(
			array('config.add', array('gender_lgbtq', true)),
		);
	}
}
