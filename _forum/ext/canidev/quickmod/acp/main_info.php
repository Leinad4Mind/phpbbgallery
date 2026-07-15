<?php
/*
* @package cBB QuickMod
* @version v1.1.3 16/04/2021
*
* @copyright (c) 2021 CaniDev
* @license https://opensource.org/licenses/gpl-license.php GNU Public License
*/

namespace canidev\quickmod\acp;

class main_info
{
	function module()
	{
		return array(
			'filename'	=> '\canidev\quickmod\acp\main_module',
			'title'		=> 'ACP_CAT_QUICKMOD',
			'version'	=> '1.1.3',
			'modes'		=> array(
				'config'	=> array('title' => 'ACP_QUICKMOD_CONFIG', 	'auth' => 'ext_canidev/quickmod && acl_a_board', 'cat' => array('ACP_CAT_QUICKMOD')),
			),
		);
	}
}
