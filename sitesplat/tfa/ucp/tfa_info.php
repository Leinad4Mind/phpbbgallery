<?php
/**
*
* @package Two Factor Authentication
* @copyright (c) 2016 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\tfa\ucp;

class tfa_info
{
	function module()
	{
		return array(
			'filename'	=> '\sitesplat\tfa\ucp\tfa_module',
			'title'     => 'UCP_TFA',
			'version'   => '1.0.0',
			'modes'     => array(
				'tfa'	=> array(
						'title'	=> 'UCP_TFA',
						'auth'	=> 'ext_sitesplat/tfa && cfg_tfa_setting',
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
