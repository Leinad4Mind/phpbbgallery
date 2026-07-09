<?php
/**
*
* @package BBdonations
* @copyright (c) 2016 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\donations\acp;

class donations_info
{
	public function module()
	{
		return array(
			'filename'	=> '\sitesplat\donations\acp\donations_module',
			'title'		=> 'ACP_DONATIONS',
			'modes'		=> array(
				'manage'	=> array(
					'title'	=> 'ACP_DONATIONS',
					'auth'	=> 'ext_sitesplat/donations && acl_a_group',
					'cat'	=> array('ACP_QUICK_ACCESS')),
			),
		);
	}
}
