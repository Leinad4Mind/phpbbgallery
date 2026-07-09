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

class formcreator_schema extends \phpbb\db\migration\migration
{
	public function update_schema()
	{
		return [
			'add_tables'	=> [
				$this->table_prefix . 'form_creator'	=> [
					'COLUMNS'	=> [
						'id'				=> ['UINT', null, 'auto_increment'],
						'form_id'			=> ['UINT', '0'],
						'ndx_order'			=> ['UINT', '0'],
						'name'				=> ['VCHAR', ''],
						'type'				=> ['VCHAR', ''],
						'hint'				=> ['VCHAR', ''],
						'options'			=> ['VCHAR', ''],
						'mandatory'			=> ['BOOL', '0'],
					],
					'PRIMARY_KEY'	=> 'id',
				],
			],
		];
	}

	public function revert_schema()
	{
		return 	[
			'drop_tables' => [
				$this->table_prefix . 'form_creator',
			],
		];
	}
}
