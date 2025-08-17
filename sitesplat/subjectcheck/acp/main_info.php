<?php
/**
 *
 * Subject Check. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2016, SiteSplat
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace sitesplat\subjectcheck\acp;

/**
 * Subject Check ACP module info.
 */
class main_info
{
	public function module()
	{
		return array(
			'filename'	=> '\sitesplat\subjectcheck\acp\main_module',
			'title'		=> 'ACP_SUBJECT_CHECK_TITLE',
			'modes'		=> array(
				'settings'	=> array(
					'title'	=> 'SETTINGS',
					'auth'	=> 'ext_sitesplat/subjectcheck && acl_a_board',
					'cat'	=> array('ACP_SUBJECT_CHECK_TITLE')
				),
			),
		);
	}
}
