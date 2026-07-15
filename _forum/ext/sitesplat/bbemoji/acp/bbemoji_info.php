<?php
/**
*
* @package BBemoji
* @copyright (c) 2016 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\bbemoji\acp;

class bbemoji_info
{
	public function module()
	{
		return array(
			'filename'	=> '\sitesplat\bbemoji\acp\bbemoji_module',
			'title'		=> 'ACP_ICONS_SMILIES',
			'modes'		=> array(
				'icons'	=> array(
					'title'	=> 'ACP_ICONS',
					'auth'	=> 'ext_sitesplat/bbemoji && acl_a_icons',
					'cat'	=> array('ACP_MESSAGES')),
			),
		);
	}
}
