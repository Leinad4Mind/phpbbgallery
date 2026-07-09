<?php
/**
*
* @package BBgdpr
* @copyright (c) 2018 SiteSplat All rights reserved
* @license Proprietary
*/

namespace sitesplat\bbgdpr\ucp;

/**
 * BBgdpr UCP module info.
 */
class main_info
{
	function module()
	{
		return array(
			'filename'	=> '\sitesplat\bbgdpr\ucp\main_module',
			'title'		=> 'UCP_PRIVACY',
			'modes'		=> array(
				'review'	=> array(
					'title'	=> 'UCP_REVIEW',
					'auth'	=> 'ext_sitesplat/bbgdpr',
					'cat'	=> array('UCP_PRIVACY')
				),
				'download'	=> array(
					'title'	=> 'UCP_DOWNLOAD',
					'auth'	=> 'ext_sitesplat/bbgdpr',
					'cat'	=> array('UCP_PRIVACY')
				),
				'delete'	=> array(
					'title'	=> 'UCP_DELETE',
					'auth'	=> 'ext_sitesplat/bbgdpr',
					'cat'	=> array('UCP_PRIVACY')
				),
			),
		);
	}
}
