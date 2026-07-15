<?php
/**
*
* @package BBCore vendor
* @copyright (c) 2016 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\BBCore\ucp;

class ir_info
{
	function module()
	{
		return array(
			'filename'	=> '\sitesplat\BBCore\ucp\ir_module',
			'title'     => 'UCP_IR',
			'version'   => '1.0.0',
			'modes'     => array(
				'ir'	=> array(
						'title'		=> 'UCP_IR',
						'auth'		=> 'ext_sitesplat/BBCore',
						'display'	=> 0,
						'cat'		=> array('UCP_PROFILE')
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
