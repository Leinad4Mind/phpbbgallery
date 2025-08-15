<?php
/**
*
* @package BBSidebar
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\sidebar\acp;

/**
* @ignore
*/
if (!defined('IN_PHPBB'))
{
	exit;
}

/**
* @package module_install
*/
class sidebar_info
{
	function module()
	{
		return array(
			'filename'	=> '\sitesplat\sidebar\acp\sidebar_module',
			'title'		=> 'ACP_SIDEBAR',
			'version'	=> '1.0.1',
			'modes'		=> array(
				'settings'	=> array('title' => 'ACP_SIDEBAR_CONFIG', 'auth' => 'ext_sitesplat/sidebar && acl_a_board', 'cat' => array('ACP_QUICK_ACCESS')),
			),
		);
	}
}