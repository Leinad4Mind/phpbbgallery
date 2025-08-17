<?php
/**
*
* @package Dropbox Upload
* @copyright (c) 2016 david63
* @license GNU General Public License, version 2 (GPL-2.0)
*
*/

namespace david63\dropboxupload\acp;

class dropboxupload_info
{
	function module()
	{
		return array(
			'filename'	=> '\david63\dropboxupload\acp\dropboxupload_module',
			'title'		=> 'DROPBOX_UPLOAD',
			'modes'		=> array(
				'main'	=> array('title' => 'DROPBOX_UPLOAD_MANAGE', 'auth' => 'ext_david63/dropboxupload && acl_a_backup', 'cat' => array('ACP_AUTO_DB_BACKUP')),
			),
		);
	}
}
