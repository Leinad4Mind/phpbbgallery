<?php

/**
 *
 * phpBB Ajax likeBB.
 *
 * @copyright (c) 2015-2022 SiteSplat All rights reserved
 * @license Proprietary
 *
 */

namespace sitesplat\likedd\ucp;

class likedd_info
{
	function module()
	{
		return [
			'filename'	=> '\sitesplat\likedd\ucp\likedd_module',
			'title'     => 'UCP_LIKEDD_TITLE',
			'version'   => '1.0.0',
			'modes'     => [
				'likedd'	=> [
					'title'	=> 'UCP_LIKEDD_TITLE',
					'auth'	=> 'ext_sitesplat/likedd && acl_u_likedd',
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