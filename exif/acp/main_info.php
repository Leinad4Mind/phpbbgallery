<?php
/**
 * phpBB Gallery - EXIF ACP definition
 *
 * @package   phpbbgallery/exif
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\exif\acp;

final class main_info
{
	public function module(): array
	{
		return [
			'filename' => '\phpbbgallery\exif\acp\main_module',
			'title' => 'PHPBB_GALLERY',
			'version' => '1.4.0',
			'modes' => [
				'settings' => [
					'title' => 'ACP_GALLERY_EXIF',
					'auth' => 'acl_a_gallery_albums && ext_phpbbgallery/exif',
					'cat' => ['PHPBB_GALLERY'],
				],
			],
		];
	}
}
