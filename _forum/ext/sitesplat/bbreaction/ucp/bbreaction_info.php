<?php

/**
 *
 * BBReaction
 * @copyright (c) 2015-2022 SiteSplat All rights reserved
 * @license Proprietary
 *
 */

namespace sitesplat\bbreaction\ucp;

class bbreaction_info
{
	function module()
	{
		return [
			'filename'	=> '\sitesplat\bbreaction\ucp\bbreaction_module',
			'title'     => 'BBREACTION',
			'version'   => '1.0.0',
			'modes'     => [
				'bbreaction'	=> [
					'title'	=> 'BBREACTION',
					'auth'  => 'ext_sitesplat/bbreaction && acl_u_bbreaction_module',
					'cat'	=> ['UCP_PROFILE']
				],
			],
		];
	}

	function install()
	{
	}

	function uninstall()
	{
	}
}