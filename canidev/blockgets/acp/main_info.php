<?php
/**
 * @package cBB Blockgets
 * @version 2.0.7 01/07/2024
 *
 * @copyright (c) 2024 CaniDev
 * @license https://creativecommons.org/licenses/by-nc/4.0/
 */

namespace canidev\blockgets\acp;

class main_info
{
	function module()
	{
		return [
			'filename'	=> '\canidev\blockgets\acp\main_module',
			'title'		=> 'ACP_BLOCKGETS',
			'version'	=> '2.0.7',
			'modes'		=> [
				'main'		=> ['title' => 'ACP_BLG_CONFIG_MAIN',			'auth' => 'ext_canidev/blockgets && acl_a_blockgets', 'cat' => ['ACP_BLOCKGETS_GENERAL']],
				'optional'	=> ['title' => 'ACP_BLG_CONFIG_OPTIONAL',		'auth' => 'ext_canidev/blockgets && acl_a_blockgets', 'cat' => ['ACP_BLOCKGETS_GENERAL']],
				'pages'		=> ['title' => 'ACP_PAGES_AND_BLOCKS',			'auth' => 'ext_canidev/blockgets && acl_a_blockgets', 'cat' => ['ACP_BLOCKGETS_GENERAL']],
			],
		];
	}
}
