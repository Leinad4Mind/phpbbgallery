<?php
/**
 *
 * BBajaxnews. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2018, SiteSplat
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace sitesplat\bbajaxnews\acp;

/**
 * BBajaxnews ACP module info.
 */
class main_info
{
	public function module()
	{
		return array(
			'filename'	=> '\sitesplat\bbajaxnews\acp\main_module',
			'title'		=> 'ACP_BBAJAXNEWS_TITLE',
			'modes'		=> array(
				'settings'	=> array(
					'title'	=> 'ACP_BBAJAXNEWS_TITLE',
					'auth'	=> 'ext_sitesplat/bbajaxnews && acl_a_board',
					'cat'	=> array('ACP_BBAJAXNEWS_TITLE')
				),
			),
		);
	}
}
