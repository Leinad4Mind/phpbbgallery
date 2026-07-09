<?php
/**
*
* @package BBfront
* @copyright (c) 2016 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\bbfront\acp;

class bbfront_info
{
	function module()
	{
		return array(
			'filename'	=> '\sitesplat\bbfront\acp\main_module',
			'title'		=> 'ACP_BBFRONT_TITLE',
			'modes'		=> array(
				'settings'	=> array(
					'title'	=> 'ACP_BBFRONT',
					'auth'	=> 'ext_sitesplat/bbfront && acl_a_board',
					'cat'	=> array('ACP_BBFRONT_TITLE')
				),
			),
		);
	}
}
