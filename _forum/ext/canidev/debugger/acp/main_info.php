<?php
/**
 * @package cBB Debugger
 * @version 1.0.1 20/09/2023
 *
 * @copyright (c) 2023 CaniDev
 * @license https://creativecommons.org/licenses/by-nc/4.0/
 */

namespace canidev\debugger\acp;

class main_info
{
	function module()
	{
		return [
			'filename'	=> '\canidev\debugger\acp\main_module',
			'title'		=> 'ACP_DEBUGGER',
			'version'	=> '1.0.1',
			'modes'		=> [
				'config'	=> ['title' => 'ACP_DEBUGGER', 	'auth' => 'ext_canidev/debugger && acl_a_board', 'cat' => ['ACP_GENERAL_TASKS']],
			],
		];
	}
}
