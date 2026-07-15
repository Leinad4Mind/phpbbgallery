<?php
/*
* @package cBB Quickquote
* @version v1.0.2 21/04/2021
*
* @copyright (c) 2021 CaniDev
* @license https://opensource.org/licenses/gpl-license.php GNU Public License
*/

namespace canidev\quickquote\acp;

class config_info
{
	function module()
	{
		return array(
			'filename'	=> '\canidev\quickquote\acp\config_module',
			'title'		=> 'ACP_QUICKQUOTE',
			'version'	=> '1.0.2',
			'modes'		=> array(
				'config'	=> array('title' => 'ACP_QUICKQUOTE_CONFIG',		'auth' => 'ext_canidev/quickquote && acl_a_board', 'cat' => array('ACP_CAT_QUICKQUOTE')),
			),
		);
	}
}
