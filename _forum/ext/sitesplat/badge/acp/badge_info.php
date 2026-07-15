<?php
/**
*
* BBAwards extension for the phpBB Forum Software package.
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\badge\acp;

class badge_info
{
	public function module()
	{
		return array(
			'filename'	=> '\sitesplat\badge\acp\badge_module',
			'title'		=> 'ACP_BADGE_MANAGE',
			'modes'		=> array(
				'manage'	=> array(
					'title'	=> 'ACP_BADGE_MANAGE',
					'auth'	=> 'ext_sitesplat/badge && acl_a_group',
					'cat'	=> array('ACP_CAT_USERS')),
			),
		);
	}
}
