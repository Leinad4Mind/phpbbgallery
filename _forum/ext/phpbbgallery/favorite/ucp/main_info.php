<?php
/**
 * phpBB Gallery - Favorite Extension
 *
 * @package   phpbbgallery/favorite
 * @author    Leinad4Mind
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\favorite\ucp;

class main_info
{
	public function module(): array
	{
		return [
			'filename'	=> '\phpbbgallery\favorite\ucp\main_module',
			'title'		=> 'UCP_GALLERY',
			'modes'		=> [
				'manage_favorites'	=> [
					'title'	=> 'UCP_GALLERY_FAVORITES',
					'auth'	=> 'ext_phpbbgallery/favorite',
					'cat'	=> ['UCP_GALLERY'],
				],
			],
		];
	}
}
