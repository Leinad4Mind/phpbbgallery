<?php
/**
*
* @package BBnewsletter
* @copyright (c) 2016 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\newsletter\acp;

class newsletter_info
{
	function module()
	{
		return array(
			'filename'    => 'sitesplat\newsletter\acp\newsletter_module',
			'title'        => 'ACP_NEWSLETTER',
			'version'    => '1.0.0',
			'modes'        => array(
				'newsletter'		=> array(
											'title'	=> 'ACP_NEWSLETTER',
											'auth'	=> 'ext_sitesplat/newsletter && acl_a_board',
											'cat'	=> array('ACP_CLIENT_COMMUNICATION')
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
