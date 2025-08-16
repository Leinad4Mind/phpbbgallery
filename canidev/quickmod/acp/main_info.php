<?php
/**
* @package cBB QuickMod
* @version 1.1.4 01/06/2022
*
* @copyright (c) 2022 CaniDev
* @license https://creativecommons.org/licenses/by-nc/4.0/
*/

namespace canidev\quickmod\acp;

class main_info
{
	public function module()
	{
		return array(
			'filename'	=> '\canidev\quickmod\acp\main_module',
			'title'		=> 'ACP_CAT_QUICKMOD',
			'version'	=> '1.1.4',
			'modes'		=> array(
				'config'	=> array('title' => 'ACP_QUICKMOD_CONFIG', 	'auth' => 'ext_canidev/quickmod && acl_a_board', 'cat' => array('ACP_CAT_QUICKMOD')),
			),
		);
	}
}
