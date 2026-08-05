<?php
/**
 * phpBB Gallery - Remote Storage Add-on
 *
 * @package   phpbbgallery/remotestorage
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\remotestorage\migrations;

use phpbb\db\migration\migration;

class m1_acp_settings extends migration
{
	public static function depends_on(): array
	{
		return ['\phpbbgallery\core\migrations\storage_provider'];
	}

	public function update_data(): array
	{
		return [
			['permission.add', ['a_gallery_remote_storage', true, 'a_board']],
			['module.add', ['acp', 'PHPBB_GALLERY', [
				'module_basename' => '\phpbbgallery\remotestorage\acp\main_module',
				'module_langname' => 'ACP_GALLERY_REMOTE_STORAGE',
				'module_mode' => 'settings',
				'module_auth' => 'ext_phpbbgallery/remotestorage && acl_a_gallery_remote_storage',
			]]],
			['config.add', ['phpbb_gallery_s3_endpoint', '']],
			['config.add', ['phpbb_gallery_s3_bucket', '']],
			['config.add', ['phpbb_gallery_s3_access_key', '']],
			['config.add', ['phpbb_gallery_s3_secret_key', '']],
			['config.add', ['phpbb_gallery_s3_region', 'us-east-1']],
			['config.add', ['phpbb_gallery_s3_prefix', 'phpbbgallery']],
		];
	}
}
