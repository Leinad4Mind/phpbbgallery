<?php
/**
 * phpBB Gallery - Google Drive storage settings.
 *
 * @package   phpbbgallery/remotestorage
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\remotestorage\migrations;

use phpbb\db\migration\migration;

final class m6_google_drive extends migration
{
	public static function depends_on(): array
	{
		return ['\phpbbgallery\remotestorage\migrations\m5_dropbox'];
	}

	public function update_data(): array
	{
		return [
			['config.add', ['phpbb_gallery_google_drive_client_id', '']],
			['config.add', ['phpbb_gallery_google_drive_client_secret', '']],
			['config.add', ['phpbb_gallery_google_drive_refresh_token', '']],
			['config.add', ['phpbb_gallery_google_drive_root_name', 'phpbbgallery']],
		];
	}

	public function revert_data(): array
	{
		return array_map(static fn (string $key): array => ['config.remove', [$key]], [
			'phpbb_gallery_google_drive_client_id',
			'phpbb_gallery_google_drive_client_secret',
			'phpbb_gallery_google_drive_refresh_token',
			'phpbb_gallery_google_drive_root_name',
		]);
	}
}
