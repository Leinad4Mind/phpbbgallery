<?php
/**
*
* BBmembership extension for the phpBB Forum Software package.
*
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\bbmembership\acp;

class bbmembership_info
{
	public function module()
	{
		return array(
			'filename'	=> '\sitesplat\bbmembership\acp\bbmembership_module',
			'title'		=> 'ACP_BBMEMBERSHIP',
			'modes'		=> array(
				'index'	=> array(
					'title'	=> 'ACP_BBMEMBERSHIP_TITLE',
					'auth'	=> 'ext_sitesplat/bbmembership && acl_a_board',
					'cat'	=> array('ACP_QUICK_ACCESS')
				),
			),
		);
	}
}
