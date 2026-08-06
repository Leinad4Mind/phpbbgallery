<?php
/**
 * phpBB Gallery - Box storage settings.
 *
 * @package   phpbbgallery/remotestorage
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\remotestorage\migrations;

use phpbb\db\migration\migration;

final class m7_box extends migration
{
	public static function depends_on(): array
	{
		return ['\phpbbgallery\remotestorage\migrations\m6_google_drive'];
	}

	public function update_data(): array
	{
		return [
			['config.add', ['phpbb_gallery_box_client_id', '']],
			['config.add', ['phpbb_gallery_box_client_secret', '']],
			['config.add', ['phpbb_gallery_box_refresh_token', '']],
			['config.add', ['phpbb_gallery_box_access_token', '']],
			['config.add', ['phpbb_gallery_box_access_expires', 0]],
			['config.add', ['phpbb_gallery_box_root_name', 'phpbbgallery']],
		];
	}

	public function revert_data(): array
	{
		return array_map(static fn (string $key): array => ['config.remove', [$key]], [
			'phpbb_gallery_box_client_id',
			'phpbb_gallery_box_client_secret',
			'phpbb_gallery_box_refresh_token',
			'phpbb_gallery_box_access_token',
			'phpbb_gallery_box_access_expires',
			'phpbb_gallery_box_root_name',
		]);
	}
}
