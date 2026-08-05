<?php
/**
 * phpBB Gallery - SFTP storage settings.
 *
 * @package   phpbbgallery/remotestorage
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\remotestorage\migrations;

use phpbb\db\migration\migration;

final class m4_sftp extends migration
{
	public static function depends_on(): array
	{
		return ['\phpbbgallery\remotestorage\migrations\m3_azure_blob'];
	}

	public function update_data(): array
	{
		return [
			['config.add', ['phpbb_gallery_sftp_host', '']],
			['config.add', ['phpbb_gallery_sftp_port', '22']],
			['config.add', ['phpbb_gallery_sftp_username', '']],
			['config.add', ['phpbb_gallery_sftp_password', '']],
			['config.add', ['phpbb_gallery_sftp_host_fingerprint', '']],
			['config.add', ['phpbb_gallery_sftp_root', '/phpbbgallery']],
		];
	}

	public function revert_data(): array
	{
		return array_map(static fn (string $key): array => ['config.remove', [$key]], [
			'phpbb_gallery_sftp_host',
			'phpbb_gallery_sftp_port',
			'phpbb_gallery_sftp_username',
			'phpbb_gallery_sftp_password',
			'phpbb_gallery_sftp_host_fingerprint',
			'phpbb_gallery_sftp_root',
		]);
	}
}
