<?php
/**
*
* BBreaction
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\bbreaction\ucp;

class bbreaction_info
{
	function module()
	{
		return array(
			'filename'	=> '\sitesplat\bbreaction\ucp\bbreaction_module',
			'title'     => 'BBREACTION',
			'version'   => '1.0.0',
			'modes'     => array(
				'bbreaction'	=> array(
						'title'	=> 'BBREACTION',
						'auth'  => 'ext_sitesplat/bbreaction && acl_u_bbreaction_module',
						'cat'	=> array('UCP_PROFILE')
				),
			),
		);
	}

	function install()
	{
	}

	function uninstall()
	{
	}
}
