<?php
/**
 * phpBB Gallery - Export Extension
 *
 * @package   phpbbgallery/export
 * @author    Leinad4Mind
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\export\ucp;

class main_info
{
	public function module(): array
	{
		return [
			'filename'	=> '\phpbbgallery\export\ucp\main_module',
			'title'		=> 'UCP_GALLERY',
			'modes'		=> [
				'export_images'	=> [
					'title'	=> 'UCP_GALLERY_EXPORT',
					'auth'	=> 'ext_phpbbgallery/export',
					'cat'	=> ['UCP_GALLERY'],
				],
			],
		];
	}
}
