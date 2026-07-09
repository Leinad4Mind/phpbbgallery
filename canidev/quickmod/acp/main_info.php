<?php
/**
 * @package cBB QuickMod
 * @version 1.1.6 01/11/2024
 *
 * @copyright (c) 2024 CaniDev
 * @license https://creativecommons.org/licenses/by-nc/4.0/
 */

namespace canidev\quickmod\acp;

class main_info
{
	public function module()
	{
		return [
			'filename'	=> '\canidev\quickmod\acp\main_module',
			'title'		=> 'ACP_CAT_QUICKMOD',
			'version'	=> '1.1.6',
			'modes'		=> [
				'config'	=> ['title' => 'ACP_QUICKMOD_CONFIG', 	'auth' => 'ext_canidev/quickmod && acl_a_board', 'cat' => ['ACP_CAT_QUICKMOD']],
			],
		];
	}
}
