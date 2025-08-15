<?php
/**
*
* BBAwards extension for the phpBB Forum Software package.
*
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\badge\ucp;

class badge_info
{
	function module()
	{
		return array(
			'filename'	=> '\sitesplat\badge\ucp\badge_module',
			'title'     => 'UCP_BADGE_TITLE',
			'version'   => '1.0.0',
			'modes'     => array(
				'badge'	=> array(
						'title'	=> 'UCP_BADGE_TITLE',
						'auth'	=> 'ext_sitesplat/badge',
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
