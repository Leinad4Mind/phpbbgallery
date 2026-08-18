<?php
/**
 * phpBB Gallery - Effective permission masks ACP module.
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\migrations;

use phpbb\db\migration\migration;

/** Add the read-only Gallery permission masks page to the ACP. */
class gallery_permission_masks extends migration
{
	public static function depends_on(): array
	{
		return ['\phpbbgallery\core\migrations\forum_index_personal_images'];
	}

	public function update_data(): array
	{
		return [
			['module.add', ['acp', 'ACP_PERMISSION_MASKS', [
				'module_basename' => '\phpbbgallery\core\acp\permissions_module',
				'module_langname' => 'ACP_VIEW_GALLERY_PERMISSIONS',
				'module_mode' => 'masks',
				'module_auth' => 'ext_phpbbgallery/core && acl_a_viewauth',
			]]],
		];
	}
}
