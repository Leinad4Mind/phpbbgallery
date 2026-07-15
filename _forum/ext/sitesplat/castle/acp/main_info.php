<?php
/**
*
* Castle
*
* @copyright (c) 2018 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\castle\acp;

class main_info
{
	function module()
	{
		return array(
			'filename'	=> '\sitesplat\castle\acp\main_module',
			'title'		=> 'ACP_CASTLE_TITLE',
			'version'	=> '1.0.0',
			'modes'		=> array(
				'settings'	=> array('title' => 'SETTINGS', 'auth' => 'ext_sitesplat/castle && acl_a_board', 'cat' => array('ACP_BUGSNAG_TITLE')),
			),
		);
	}
}
