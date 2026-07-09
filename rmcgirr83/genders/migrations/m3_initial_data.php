<?php
/**
*
* @package Genders
* @copyright (c) 2020 Rich Mcgirr (RMcGirr83)
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace rmcgirr83\genders\migrations;

class m3_initial_data extends \phpbb\db\migration\migration
{
	static public function depends_on()
	{
		return ['\rmcgirr83\genders\migrations\m2_initial_data'];
	}

	public function update_data()
	{
		return [
			['config.remove', ['genders_version']],
		];
	}
}
