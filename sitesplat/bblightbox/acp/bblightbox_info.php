<?php
/**
*
* BBlightbox
* @copyright (c) 2017 sitesplat.com All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\bblightbox\acp;

class bblightbox_info
{
	function module()
	{
		return array(
			'filename'	=> '\sitesplat\bblightbox\acp\bblightbox_module',
			'title'		=> 'ACP_BBLIGHTBOX_TITLE',
			'version'	=> '1.0.0',
			'modes'		=> array(
				'settings'	=> array('title' => 'ACP_BBLIGHTBOX_TITLE', 'auth' => 'ext_sitesplat/bblightbox && acl_a_board', 'cat' => array('ACP_MESSAGES')),
			),
		);
	}
}
