<?php
/**
*
* Cloudflare IP
*
* @copyright (c) 2017 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\cloudflareip\acp;

class cf_info
{
	public function module()
	{
		return array(
			'filename'	=> '\sitesplat\cloudflareip\acp\cf_module',
			'title'		=> 'ACP_CLOUDFLARE',
			'modes'		=> array(
				'settings'	=> array(
                    'title' => 'ACP_CLOUDFLARE',
                    'auth' => 'ext_sitesplat/cloudflareip && acl_a_board',
                    'cat' => array('ACP_CLOUDFLARE')
                ),
			),
		);
	}
}
