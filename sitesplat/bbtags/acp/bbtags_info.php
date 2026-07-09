<?php
/**
*
* BBtags
*
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\bbtags\acp;

class bbtags_info
{
	function module()
	{
		return array(
			'filename'	=> 'sitesplat\bbtags\acp\bbtags_info',
			'title'		=> 'ACP_BBTAGS',
			'version'	=> '1.0.0',
			'modes'		=> array(
				'tag'	=> array(
					'title'	=> 'ACP_BBTAGS',
					'auth'	=> 'ext_sitesplat/bbtags && acl_a_words',
					'cat'	=> array('ACP_MESSAGES')
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
