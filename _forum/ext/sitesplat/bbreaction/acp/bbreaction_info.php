<?php
/**
*
* BBreaction
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\bbreaction\acp;

class bbreaction_info
{
	public function module()
	{
		return array(
			'filename'	=> '\sitesplat\bbreaction\acp\bbreaction_module',
			'title'		=> 'ACP_BBREACTION',
			'modes'		=> array(
				'settings'	=> array(
					'title'	=> 'ACP_BBREACTION',
					'auth'	=> 'ext_sitesplat/bbreaction && acl_a_board',
					'cat'	=> array('ACP_QUICK_ACCESS')),
			),
		);
	}
}
