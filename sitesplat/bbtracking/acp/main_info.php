<?php
/**
*
* BBtracking
*
* @copyright (c) 2018 Ken F. Innes IV <https://www.absoluteanime.com>
* @license GNU General Public License, version 2 (GPL-2.0)
*
* @copyright (c) 2017, Sitesplat
* @license private
*/

namespace sitesplat\bbtracking\acp;

/**
 * BBtracking ACP module info.
 */
class main_info
{
	public function module()
	{
		return array(
			'filename'	=> '\sitesplat\bbtracking\acp\main_module',
			'title'		=> 'ACP_BBTRACKING',
			'modes'		=> array(
				'settings'	=> array(
					'title'	=> 'ACP_BBTRACKING_SETTINGS',
					'auth'	=> 'ext_sitesplat/bbtracking && acl_a_board',
					'cat'	=> array('ACP_BBTRACKING')
				),
				'logs'	=> array(
					'title'	=> 'ACP_BBTRACKING_LOGS',
					'auth'	=> 'ext_sitesplat/bbtracking && acl_a_board',
					'cat'	=> array('ACP_BBTRACKING')
				),
			),
		);
	}
}
