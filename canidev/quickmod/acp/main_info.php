<?php
/*
* @name main_info.php
* @package cBB QuickMod
* @version 1.1.0 17/01/2017
*
* @copyright (c) 2017 CaniDev
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/

namespace canidev\quickmod\acp;

class main_info
{
	function module()
	{
		return array(
			'filename'	=> '\canidev\quickmod\acp\main_module',
			'title'		=> 'ACP_CAT_QUICKMOD',
			'version'	=> '1.1.0',
			'modes'		=> array(
				'config'	=> array('title' => 'ACP_QUICKMOD_CONFIG', 	'auth' => 'ext_canidev/quickmod && acl_a_board', 'cat' => array('ACP_CAT_QUICKMOD')),
			),
		);
	}
}
