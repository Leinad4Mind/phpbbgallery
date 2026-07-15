<?php
/*
* @package cBB Blockgets
* @version v2.0.4 30/08/2021
*
* @copyright (c) 2021 CaniDev
* @license https://opensource.org/licenses/gpl-license.php GNU Public License
*/

namespace canidev\blockgets\acp;

class main_info
{
	function module()
	{
		return array(
			'filename'	=> '\canidev\blockgets\acp\main_module',
			'title'		=> 'ACP_BLOCKGETS',
			'version'	=> '2.0.4',
			'modes'		=> array(
				'main'		=> array('title' => 'ACP_BLG_CONFIG_MAIN',			'auth' => 'ext_canidev/blockgets && acl_a_blockgets', 'cat' => array('ACP_BLOCKGETS_GENERAL')),
				'optional'	=> array('title' => 'ACP_BLG_CONFIG_OPTIONAL',		'auth' => 'ext_canidev/blockgets && acl_a_blockgets', 'cat' => array('ACP_BLOCKGETS_GENERAL')),
				'pages'		=> array('title' => 'ACP_PAGES_AND_BLOCKS',			'auth' => 'ext_canidev/blockgets && acl_a_blockgets', 'cat' => array('ACP_BLOCKGETS_GENERAL')),
			),
		);
	}
}
