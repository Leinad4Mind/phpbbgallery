<?php
/**
* @package Splicker Giphy Embed
* @copyright (c) 2021 SplickerSnap.com
* @author Splicker
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace splicker\giphyembed\acp;

class giphyembed_info
{
	function module()
	{
		return array(
			'filename'	  => '\splicker\giphyembed\acp\giphyembed_module',
			'title'		 => 'Giphy Embed',
			'modes'		 => array(
				'config'	=> array(
					'title' => 'ACP_GE_SETTINGS_TITLE',
					'auth'  => 'ext_splicker/giphyembed && acl_a_board',
					'cat'   => array('ACP_GE')
				),
			),
		);
	}
}
