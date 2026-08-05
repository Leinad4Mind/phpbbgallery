<?php
/**
 * phpBB Gallery - Remote Storage Add-on
 *
 * @package   phpbbgallery/remotestorage
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\remotestorage\acp;

class main_info
{
	public function module(): array
	{
		return [
			'filename' => '\phpbbgallery\remotestorage\acp\main_module',
			'title' => 'PHPBB_GALLERY',
			'version' => '1.0.0',
			'modes' => [
				'settings' => [
					'title' => 'ACP_GALLERY_REMOTE_STORAGE',
					'auth' => 'acl_a_gallery_remote_storage && ext_phpbbgallery/remotestorage',
					'cat' => ['PHPBB_GALLERY'],
				],
			],
		];
	}
}
