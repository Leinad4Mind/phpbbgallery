<?php
/**
*
* @package PM Monitor Extension
* @copyright (c) 2015 david63
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace david63\pmmonitor\acp;

class pmmonitor_info
{
	function module()
	{
		return array(
			'filename'	=> '\david63\pmmonitor\acp\pmmonitor_module',
			'title'		=> 'ACP_PM_MONITOR',
			'modes'		=> array(
				'main'		=> array('title' => 'ACP_PM_MONITOR', 'auth' => 'ext_david63/pmmonitor && acl_a_comms_pm_manage', 'cat' => array('ACP_CAT_USERS')),
			),
		);
	}
}
