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

class formcreator_before_after_type extends \phpbb\db\migration\migration
{
	public static function depends_on()
	{
		return ['\leinad4mind\formcreator\migrations\formcreator_before_after'];
	}

	public function update_schema()
	{
		return [
			'change_columns'	=> [
				$this->table_prefix . 'form_creator' => [
					'name_before'	=> ['STEXT', 0],
					'name_after'	=> ['STEXT', 0],
					'value_before'	=> ['STEXT', 0],
					'value_after'	=> ['STEXT', 0],
				],
			],
		];
	}

	public function revert_schema()
	{
		// Skip
	}
}
