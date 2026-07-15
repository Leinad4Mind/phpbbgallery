<?php

/**
 *
 * BBPoints extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2015-2022 SiteSplat All rights reserved
 * @license Proprietary
 *
 */

namespace sitesplat\bbpoints\ucp;

class bbpoints_info
{
	function module()
	{
		return [
			'filename'	=> '\sitesplat\bbpoints\ucp\bbpoints_module',
			'title'     => 'BBPOINTS',
			'version'   => '1.0.0',
			'modes'     => [
				'bbpoints'	=> [
					'title'	=> 'BBPOINTS',
					'auth'	=> 'ext_sitesplat/bbpoints',
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