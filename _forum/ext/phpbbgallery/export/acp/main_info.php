<?php
/**
 * phpBB Gallery - Export Extension
 *
 * @package   phpbbgallery/export
 * @author    Leinad4Mind
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\export\acp;

/**
 * ACP Module Info class
 */
class main_info
{
	/**
	 * Returns module information
	 *
	 * @return array Module information
	 */
	public function module(): array
	{
		return [
				'filename' => '\phpbbgallery\export\acp\main_module',
				'title'    => 'PHPBB_GALLERY',
				'version'  => '1.0.0',
				'modes'    => [
					'export' => [
						'title' => 'ACP_GALLERY_EXPORT',
						'auth'  => 'acl_a_gallery_export && ext_phpbbgallery/export',
						'cat'   => ['PHPBB_GALLERY'],
					],
				],
		];
	}
}
