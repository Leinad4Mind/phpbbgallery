<?php
/**
 * Gallery BBTags administrative policy module definition.
 *
 * @package   phpbbgallery/bbtagsimages
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\bbtagsimages\acp;

final class policy_info
{
	public function module(): array
	{
		return [
			'title' => 'ACP_BBTAGSIMAGES_POLICIES',
			'version' => '1.0.0',
			'modes' => [
				'policies' => [
					'title' => 'ACP_BBTAGSIMAGES_POLICIES',
					'auth' => 'ext_phpbbgallery/bbtagsimages && acl_a_gallery_albums',
					'cat' => ['PHPBB_GALLERY'],
				],
			],
		];
	}
}
