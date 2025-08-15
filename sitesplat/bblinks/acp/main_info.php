<?php
/**
*
* @package sitesplat BBlinks
* @copyright (c) 2017 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\bblinks\acp;

class main_info
{
	public function module()
	{
		return array(
			'filename'	=> '\sitesplat\bblinks\acp\main_module',
			'title'		=> 'BBLINKS_TITLE',
			'modes'		=> array(
				'settings'	=> array(
					'title'	=> 'BBLINKS_TITLE',
					'auth'	=> 'ext_sitesplat/bblinks && acl_a_board',
					'cat'	=> array('BBLINKS_TITLE')
				),
			),
		);
	}
}
