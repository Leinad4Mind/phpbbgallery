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

class formcreator_data extends \phpbb\db\migration\migration
{
	public function update_data()
	{
		return [
			// Add config
			['config.add', ['form_creator_enabled', 1]],

			// Add permission
			['permission.add', ['a_form_creator', true]],

			// Set permission
			['permission.permission_set', ['ADMINISTRATORS', 'a_form_creator', 'group']],
		];
	}
}
