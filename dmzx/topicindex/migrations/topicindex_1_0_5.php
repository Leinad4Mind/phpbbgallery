<?php
/**
*
* @package phpBB Extension - Topic Index
* @copyright (c) 2020 dmzx - https://www.dmzx-web.net
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace dmzx\topicindex\migrations;

class topicindex_1_0_5 extends \phpbb\db\migration\migration
{
	static public function depends_on()
	{
		return [
			'\dmzx\topicindex\migrations\topicindex_1_0_4',
		];
	}

	public function update_data()
	{
		return [
			['config.update', ['topicindex_version', '1.0.5']],
		];
	}
}
