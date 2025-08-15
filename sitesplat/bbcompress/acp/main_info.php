<?php
/**
*
* BBcompress
*
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\bbcompress\acp;

class main_info
{
	function module()
	{
		return array(
			'filename'	=> '\sitesplat\bbcompress\acp\main_module',
			'title'		=> 'ACP_BBCOMPRESS_TITLE',
			'version'	=> '1.0.0',
			'modes'		=> array(
				'settings'	=> array('title' => 'ACP_SETTINGS', 'auth' => 'ext_sitesplat/bbcompress && acl_a_board', 'cat' => array('ACP_BBCOMPRESS_TITLE')),
			),
		);
	}
}
