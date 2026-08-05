<?php
/**
 * phpBB Gallery - TIFF Extension
 *
 * @package   phpbbgallery/tiff
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\tiff\acp;

class main_info
{
	public function module(): array
	{
		return [
			'filename' => '\phpbbgallery\tiff\acp\main_module',
			'title' => 'PHPBB_GALLERY',
			'version' => '1.0.0',
			'modes' => [
				'settings' => [
					'title' => 'ACP_GALLERY_TIFF',
					'auth' => 'acl_a_board && ext_phpbbgallery/tiff',
					'cat' => ['PHPBB_GALLERY'],
				],
			],
		];
	}
}
