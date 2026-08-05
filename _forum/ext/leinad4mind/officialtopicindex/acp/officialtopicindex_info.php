<?php
/**
*
* @package phpBB Extension - Official Topic Index
 * @copyright (c) 2015-2022 Leinad4Mind - https://leinad4mind.top/forum
* @copyright (c) 2015 dmzx - https://www.dmzx-web.net
 * @copyright (c) 2026 Leinad4Mind
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace leinad4mind\officialtopicindex\acp;

class officialtopicindex_info
{
	public function module()
	{
		return array(
			'filename'	=> '\leinad4mind\officialtopicindex\acp\officialtopicindex_module',
			'title'		=> 'ACP_CAT_OFFICIALINDEX',
			'modes'		=> array(
				'main'	=> array(
					'title'	=> 'ACP_OFFICIALINDEX_CFG',
					'auth' 	=> 'ext_leinad4mind/officialtopicindex && acl_a_board',
					'cat' 	=> array('ACP_CAT_DOT_MODS'
				),
			)),
		);
	}
}
