<?php
/**
*
* BBbbprofile. An extension for the phpBB Forum Software package.
* @copyright (c) 2016, SiteSplat
* @license Proprietary
*
*/

namespace sitesplat\bbprofile\acp;

/**
 * BBprofile ACP module info.
 */
class main_info
{
	public function module()
	{
		return array(
			'filename'	=> '\sitesplat\bbprofile\acp\main_module',
			'title'		=> 'ACP_BBPROFILE',
			'modes'		=> array(
				'settings'	=> array(
					'title'	=> 'ACP_BBPROFILE',
					'auth'	=> 'ext_sitesplat/bbprofile && acl_a_board',
					'cat'	=> array('ACP_BBPROFILE')
				),
			),
		);
	}
}
