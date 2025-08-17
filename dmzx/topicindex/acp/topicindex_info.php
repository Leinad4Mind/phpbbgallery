<?php
/**
*
* @package phpBB Extension - Topic Index
* @copyright (c) 2015 dmzx - http://www.dmzx-web.net
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace dmzx\topicindex\acp;

class topicindex_info
{
	function module()
	{
		return array(
			'filename'	=> '\dmzx\topicindex\acp\topicindex_module',
			'title'		=> 'ACP_CAT_OINDEX',
			'modes'		=> array(
				'main'	=> array(
					'title'	=> 'ACP_OINDEX_CFG',
					'auth' 	=> 'ext_dmzx/topicindex && acl_a_board',
					'cat' 	=> array('ACP_CAT_DOT_MODS'
				),
			)),
		);
	}
}
