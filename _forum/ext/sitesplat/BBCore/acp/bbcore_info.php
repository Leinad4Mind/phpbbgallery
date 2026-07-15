<?php
/**
*
* @package sitesplat BBcore
* @copyright (c) 2020 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\BBCore\acp;

class bbcore_info
{
	function module()
	{
		return array(
			'filename'	=> '\sitesplat\BBCore\acp\bbcore_module',
			'title'		=> 'BBCore',
			'version'	=> '1.0.0',
			'modes'		=> array(
				'dash'		=> array('title' => 'BBCORE_DASHBOARD', 'auth' => 'ext_sitesplat/BBCore && acl_a_board', 'cat' => array('BBCore')),
				'update'	=> array('title' => 'SITESPLAT_UPDATE_MANAGER', 'auth' => 'ext_sitesplat/BBCore && acl_a_board', 'cat' => array('BBCore')),
				'settings'	=> array('title' => 'BBCORE_SETTINGS', 'auth' => 'ext_sitesplat/BBCore && acl_a_board', 'cat' => array('BBCore')),
			),
		);
	}
}
