<?php
/**
 *
* @package BBprefix
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
 *
 */

namespace sitesplat\bbprefix\acp;

class bbprefix_info
{
	function module()
	{
		return array(
			'filename'	=> '\sitesplat\bbprefix\acp\bbprefix_module',
			'title'		=> 'ACP_BBPREFIX_MANAGEMENT',
			'version'	=> '1.0.0',
			'modes'		=> array(
				'prefixes'		=> array('title' => 'ACP_BBPREFIX_MANAGE', 'auth' => '', 'cat' => array('ACP_MESSAGES')),
			),
		);
	}
}
