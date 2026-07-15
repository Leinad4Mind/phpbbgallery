<?php
/**
 *
 * @package Dropbox Upload
 * @copyright (c) 2022 devspace
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace devspace\dropboxupload\acp;

class dropboxupload_info
{
	public function module()
	{
		return [
			'filename' => '\devspace\dropboxupload\acp\dropboxupload_module',
			'title' => 'DROPBOX_UPLOAD',
			'modes' => [
				'main' => ['title' => 'DROPBOX_UPLOAD_MANAGE', 'auth' => 'ext_devspace/dropboxupload && acl_a_backup', 'cat' => ['ACP_AUTO_DB_BACKUP']],
			],
		];
	}
}
