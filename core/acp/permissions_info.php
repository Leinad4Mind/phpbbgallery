<?php
/**
*
* @package phpBB Gallery
* @version $Id$
* @copyright (c) 2007 nickvergessen nickvergessen@gmx.de http://www.flying-bits.org
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

namespace phpbbgallery\core\acp;

class permissions_info
{
	public function module(): array
	{
		return [
			'title'		=> 'PHPBB_GALLERY',
			'version'	=> '1.0.0',
			'modes'		=> [
				'manage'	=> [
					'title' => 'ACP_GALLERY_ALBUM_PERMISSIONS',
					'auth' => 'ext_phpbbgallery/core && acl_a_gallery_albums',
					'cat' => ['PHPBB_GALLERY']
				],
				'copy'		=> [
					'title' => 'ACP_GALLERY_ALBUM_PERMISSIONS_COPY',
					'auth' => 'ext_phpbbgallery/core && acl_a_gallery_albums',
					'cat' => ['PHPBB_GALLERY']
				],
				'masks'		=> [
					'title' => 'ACP_VIEW_GALLERY_PERMISSIONS',
					'auth' => 'ext_phpbbgallery/core && acl_a_viewauth',
					'cat' => ['ACP_PERMISSION_MASKS']
				],
			],
		];
	}
}
