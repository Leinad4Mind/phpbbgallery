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

class albums_info
{
	public function module(): array
	{
		return [
			'title'		=> 'PHPBB_GALLERY',
			'version'	=> '1.0.0',
			'modes'		=> [
				'manage'	=> [
					'title' => 'ACP_GALLERY_MANAGE_ALBUMS',
					'auth' => 'ext_phpbbgallery/core && acl_a_gallery_albums',
					'cat' => ['PHPBB_GALLERY']
				],
			],
		];
	}
}
