<?php
/**
 * phpBB Gallery - MediaFire storage settings.
 *
 * @package   phpbbgallery/remotestorage
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\remotestorage\migrations;

use phpbb\db\migration\migration;

final class m8_mediafire extends migration
{
	public static function depends_on(): array
	{
		return ['\phpbbgallery\remotestorage\migrations\m7_box'];
	}

	public function update_data(): array
	{
		return [
			['config.add', ['phpbb_gallery_mediafire_application_id', '']],
			['config.add', ['phpbb_gallery_mediafire_api_key', '']],
			['config.add', ['phpbb_gallery_mediafire_email', '']],
			['config.add', ['phpbb_gallery_mediafire_password', '']],
			['config.add', ['phpbb_gallery_mediafire_root_name', 'phpbbgallery']],
			['config.add', ['phpbb_gallery_mediafire_session_token', '']],
			['config.add', ['phpbb_gallery_mediafire_secret_key', 0]],
			['config.add', ['phpbb_gallery_mediafire_session_time', '']],
			['config.add', ['phpbb_gallery_mediafire_session_issued_at', 0]],
		];
	}

	public function revert_data(): array
	{
		return array_map(static fn (string $key): array => ['config.remove', [$key]], [
			'phpbb_gallery_mediafire_application_id',
			'phpbb_gallery_mediafire_api_key',
			'phpbb_gallery_mediafire_email',
			'phpbb_gallery_mediafire_password',
			'phpbb_gallery_mediafire_root_name',
			'phpbb_gallery_mediafire_session_token',
			'phpbb_gallery_mediafire_secret_key',
			'phpbb_gallery_mediafire_session_time',
			'phpbb_gallery_mediafire_session_issued_at',
		]);
	}
}
