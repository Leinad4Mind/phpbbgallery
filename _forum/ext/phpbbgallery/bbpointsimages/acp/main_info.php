<?php
/**
 * phpBB Gallery - BBPoints Images ACP definition
 *
 * @package   phpbbgallery/bbpointsimages
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\bbpointsimages\acp;

final class main_info
{
	public function module(): array
	{
		return [
			'filename' => '\phpbbgallery\bbpointsimages\acp\main_module',
			'title' => 'PHPBB_GALLERY',
			'version' => '1.0.0',
			'modes' => [
				'settings' => [
					'title' => 'ACP_BBPOINTSIMAGES_SETTINGS',
					'auth' => 'acl_a_gallery_albums && ext_phpbbgallery/bbpointsimages',
					'cat' => ['PHPBB_GALLERY'],
				],
			],
		];
	}
}
