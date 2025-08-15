<?php
/**
*
* @package BBdonations
* @copyright (c) 2016 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\donations\ucp;

class donations_info
{
	function module()
	{
		return array(
			'filename'		=> 'sitesplat\donations\ucp\donations_module',
			'title'			=> 'UCP_DONATION_TITLE',
			'version'		=> '1.0.0',
			'modes'			=> array(
				'donation'	=> array(
					'title'	=> 'UCP_DONATION_USER',
					'auth'	=> 'ext_sitesplat/donations',
					'cat'	=> array('UCP_MAIN')
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
