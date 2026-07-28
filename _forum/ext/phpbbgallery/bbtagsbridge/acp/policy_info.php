<?php
/**
 * Gallery BBTags administrative policy module definition.
 *
 * @package   phpbbgallery/bbtagsbridge
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\bbtagsbridge\acp;

final class policy_info
{
	public function module(): array
	{
		return [
			'title' => 'ACP_BBTAGSBRIDGE_POLICIES',
			'version' => '1.0.0',
			'modes' => [
				'policies' => [
					'title' => 'ACP_BBTAGSBRIDGE_POLICIES',
					'auth' => 'ext_phpbbgallery/bbtagsbridge && acl_a_gallery_albums',
					'cat' => ['PHPBB_GALLERY'],
				],
			],
		];
	}
}
