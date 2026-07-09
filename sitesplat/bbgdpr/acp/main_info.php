<?php
/**
*
* @package BBgdpr
* @copyright (c) 2018 SiteSplat All rights reserved
* @license Proprietary
*/

namespace sitesplat\bbgdpr\acp;

/**
 * BBgdpr ACP module info.
 */
class main_info
{
	public function module()
	{
		return array(
			'filename'	=> '\sitesplat\bbgdpr\acp\main_module',
			'title'		=> 'ACP_BBGDPR',
			'modes'		=> array(
				'settings'	=> array(
					'title'	=> 'GDPR',
					'auth'	=> 'ext_sitesplat/bbgdpr && acl_a_board',
					'cat'	=> array('ACP_BBGDPR')
				),
			),
		);
	}
}
