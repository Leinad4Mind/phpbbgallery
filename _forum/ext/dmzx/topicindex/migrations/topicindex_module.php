<?php
/**
*
* @package phpBB Extension - Topic Index
* @copyright (c) 2015 dmzx - http://www.dmzx-web.net
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace dmzx\topicindex\migrations;

class topicindex_module extends \phpbb\db\migration\migration
{
	public function update_data()
	{
		return array(
			array('module.add', array('acp', 'ACP_CAT_DOT_MODS', 'ACP_CAT_OINDEX')),
			array('module.add', array(
				'acp', 'ACP_CAT_OINDEX', array(
					'module_basename'	=> '\dmzx\topicindex\acp\topicindex_module', 'modes' => array('main'),
				),
			)),
		);
	}
}
