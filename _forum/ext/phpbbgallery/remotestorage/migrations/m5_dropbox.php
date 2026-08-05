<?php
/**
 * phpBB Gallery - Dropbox storage settings.
 *
 * @package   phpbbgallery/remotestorage
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\remotestorage\migrations;

use phpbb\db\migration\migration;

final class m5_dropbox extends migration
{
	public static function depends_on(): array
	{
		return ['\phpbbgallery\remotestorage\migrations\m4_sftp'];
	}

	public function update_data(): array
	{
		return [
			['config.add', ['phpbb_gallery_dropbox_app_key', '']],
			['config.add', ['phpbb_gallery_dropbox_app_secret', '']],
			['config.add', ['phpbb_gallery_dropbox_refresh_token', '']],
			['config.add', ['phpbb_gallery_dropbox_root', '/phpbbgallery']],
		];
	}

	public function revert_data(): array
	{
		return array_map(static fn (string $key): array => ['config.remove', [$key]], [
			'phpbb_gallery_dropbox_app_key',
			'phpbb_gallery_dropbox_app_secret',
			'phpbb_gallery_dropbox_refresh_token',
			'phpbb_gallery_dropbox_root',
		]);
	}
}
