<?php
/*
* @package cBB Debugger
* @version v1.0.0 21/06/2021
*
* @copyright (c) 2021 CaniDev
* @license https://opensource.org/licenses/gpl-license.php GNU Public License
*/

namespace canidev\debugger\acp;

class main_info
{
	function module()
	{
		return array(
			'filename'	=> '\canidev\debugger\acp\main_module',
			'title'		=> 'ACP_DEBUGGER',
			'version'	=> '1.0.0',
			'modes'		=> array(
				'config'	=> array('title' => 'ACP_DEBUGGER', 	'auth' => 'ext_canidev/debugger && acl_a_board', 'cat' => array('ACP_GENERAL_TASKS')),
			),
		);
	}
}
