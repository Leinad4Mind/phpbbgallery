<?php
/**
*
* @package phpBB Extension - Topic Index
* @copyright (c) 2015 dmzx - http://www.dmzx-web.net
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace dmzx\topicindex\migrations;

class topicindex_1_0_3 extends \phpbb\db\migration\migration
{
	static public function depends_on()
	{
		return array(
			'\dmzx\topicindex\migrations\topicindex_1_0_2',
		);
	}

	public function update_data()
	{
		return array(
			// Update config
			array('config.update', array('topicindex_version', '1.0.3')),
			// Permission
			array('permission.add', array('u_topicindex_view', true)),
			// Set Permission
			array('permission.permission_set', array('REGISTERED', 'u_topicindex_view', 'group', true)),
		);
	}
}
