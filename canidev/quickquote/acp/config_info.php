<?php
/*
* @name config_info.php
* @package cBB QuickQuote
* @version 1.0.0 01/03/2018
*
* @copyright (c) 2018 CaniDev
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/

namespace canidev\quickquote\acp;

class config_info
{
	function module()
	{
		return array(
			'filename'	=> '\canidev\quickquote\acp\config_module',
			'title'		=> 'ACP_QUICKQUOTE',
			'version'	=> '1.0.0',
			'modes'		=> array(
				'config'	=> array('title' => 'ACP_QUICKQUOTE_CONFIG',		'auth' => 'ext_canidev/quickquote && acl_a_board', 'cat' => array('ACP_CAT_QUICKQUOTE')),
			),
		);
	}
}
