<?php
/**
*
* @package phpBB Extension - Form Creator
* @copyright (c) 2017 dmzx - http://www.dmzx-web.net & michaelo - http://www.phpbbireland.com
* @copyright (c) 2019 Leinad4Mind - https://leinad4mind.top/forum
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace leinad4mind\formcreator\migrations;

class formcreator_name_visible extends \phpbb\db\migration\migration
{
	public static function depends_on()
	{
		return ['\leinad4mind\formcreator\migrations\formcreator_explain'];
	}

	public function update_schema()
	{
		return [
			'add_columns'	=> [
				$this->table_prefix . 'form_creator' => [
					'name_visible' => ['BOOL', 1],
				],
			],
		];
	}

	public function revert_schema()
	{
		return [
			'drop_columns'	=> [
				$this->table_prefix . 'form_creator' => [
					'name_visible',
				],
			],
		];
	}
}
