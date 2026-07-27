<?php
/**
 * phpBB Gallery - Image Revisions Extension
 *
 * @package   phpbbgallery/imagerevisions
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\imagerevisions\acp;

class main_info
{
	public function module(): array
	{
		return [
			'filename' => '\phpbbgallery\imagerevisions\acp\main_module',
			'title' => 'PHPBB_GALLERY',
			'version' => '1.0.0',
			'modes' => [
				'settings' => [
					'title' => 'ACP_GALLERY_IMAGE_REVISIONS',
					'auth' => 'acl_a_gallery_imagerevisions && ext_phpbbgallery/imagerevisions',
					'cat' => ['PHPBB_GALLERY'],
				],
			],
		];
	}
}
