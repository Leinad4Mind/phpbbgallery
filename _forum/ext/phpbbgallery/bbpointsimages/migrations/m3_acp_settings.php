<?php
/**
 * phpBB Gallery - BBPoints Images ACP settings
 *
 * @package   phpbbgallery/bbpointsimages
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\bbpointsimages\migrations;

use phpbb\db\migration\migration;

final class m3_acp_settings extends migration
{
	public static function depends_on(): array
	{
		return ['\phpbbgallery\bbpointsimages\migrations\m2_reward_lifecycle'];
	}

	public function update_data(): array
	{
		return [[
			'module.add',
			['acp', 'PHPBB_GALLERY', [
				'module_basename' => '\phpbbgallery\bbpointsimages\acp\main_module',
				'module_langname' => 'ACP_BBPOINTSIMAGES_SETTINGS',
				'module_mode' => 'settings',
				'module_auth' => 'acl_a_gallery_albums && ext_phpbbgallery/bbpointsimages',
			]],
		]];
	}

	public function revert_data(): array
	{
		return [[
			'module.remove',
			['acp', 'PHPBB_GALLERY', 'ACP_BBPOINTSIMAGES_SETTINGS'],
		]];
	}
}
