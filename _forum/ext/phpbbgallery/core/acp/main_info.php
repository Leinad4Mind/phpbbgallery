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

class main_info
{
	public function module(): array
	{
		return [
			'title'		=> 'PHPBB_GALLERY',
			'version'	=> '1.0.0',
			'modes'		=> [
				'overview'			=> [
					'title' => 'ACP_GALLERY_OVERVIEW',
					'auth' => 'ext_phpbbgallery/core && acl_a_gallery_manage',
					'cat' => ['PHPBB_GALLERY']
				],
			],
		];
	}
}
