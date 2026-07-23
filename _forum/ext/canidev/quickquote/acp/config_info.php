<?php
/**
 * @package cBB Quickquote
 * @version 1.0.5 08/04/2025
 *
 * @copyright (c) 2025 CaniDev
 * @license https://creativecommons.org/licenses/by-nc/4.0/
 */

namespace canidev\quickquote\acp;

class config_info
{
	function module()
	{
		return [
			'filename'	=> '\canidev\quickquote\acp\config_module',
			'title'		=> 'ACP_CAT_QUICKQUOTE',
			'version'	=> '1.0.5',
			'modes'		=> [
				'config'	=> ['title' => 'ACP_QUICKQUOTE_CONFIG',		'auth' => 'ext_canidev/quickquote && acl_a_board', 'cat' => ['ACP_CAT_QUICKQUOTE']],
			],
		];
	}
}
