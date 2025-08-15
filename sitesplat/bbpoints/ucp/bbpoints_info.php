<?php
/**
*
* BBPoints extension for the phpBB Forum Software package.
*
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\bbpoints\ucp;

class bbpoints_info
{
	function module()
	{
		return array(
			'filename'	=> 'sitesplat\bbpoints\ucp\bbpoints_module',
			'title'     => 'BBPOINTS',
			'version'   => '1.0.0',
			'modes'     => array(
				'bbpoints'	=> array(
						'title'	=> 'BBPOINTS',
						'auth'	=> 'ext_sitesplat/bbpoints',
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
