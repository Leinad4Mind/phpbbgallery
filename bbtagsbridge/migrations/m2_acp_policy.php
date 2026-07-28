<?php
/**
 * Gallery BBTags administrative policy module migration.
 *
 * @package   phpbbgallery/bbtagsbridge
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\bbtagsbridge\migrations;

use phpbb\db\migration\migration;

final class m2_acp_policy extends migration
{
	public static function depends_on(): array
	{
		return ['\phpbbgallery\bbtagsbridge\migrations\m1_init'];
	}

	public function update_data(): array
	{
		return [
			['module.add', [
				'acp',
				'PHPBB_GALLERY',
				[
					'module_basename' => '\phpbbgallery\bbtagsbridge\acp\policy_module',
					'module_langname' => 'ACP_BBTAGSBRIDGE_POLICIES',
					'module_mode' => 'policies',
					'module_auth' => 'ext_phpbbgallery/bbtagsbridge && acl_a_gallery_albums',
				],
			]],
		];
	}

	public function revert_data(): array
	{
		return [
			['module.remove', ['acp', 'PHPBB_GALLERY', 'ACP_BBTAGSBRIDGE_POLICIES']],
		];
	}
}
