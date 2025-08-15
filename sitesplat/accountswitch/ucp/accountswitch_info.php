<?php
/**
*
* @package BBSwitch
* @copyright (c) 2016 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\accountswitch\ucp;

class accountswitch_info
{
	function module()
	{
		return array(
			'filename'	=> 'sitesplat\accountswitch\ucp\accountswitch_module',
			'title'     => 'ACCOUNTSWITCH',
			'version'   => '1.0.0',
			'modes'     => array(
				'accountswitch'	=> array(
						'title'	=> 'ACCOUNTSWITCH',
						'auth'	=> 'ext_sitesplat/accountswitch',
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
