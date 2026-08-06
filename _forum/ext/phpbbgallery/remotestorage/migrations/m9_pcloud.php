<?php
/**
 * phpBB Gallery - pCloud storage settings.
 *
 * @package   phpbbgallery/remotestorage
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\remotestorage\migrations;

use phpbb\db\migration\migration;

final class m9_pcloud extends migration
{
	public static function depends_on(): array
	{
		return ['\phpbbgallery\remotestorage\migrations\m8_mediafire'];
	}

	public function update_data(): array
	{
		return [
			['config.add', ['phpbb_gallery_pcloud_api_host', 'eapi.pcloud.com']],
			['config.add', ['phpbb_gallery_pcloud_access_token', '']],
			['config.add', ['phpbb_gallery_pcloud_root_name', 'phpbbgallery']],
		];
	}

	public function revert_data(): array
	{
		return array_map(static fn (string $key): array => ['config.remove', [$key]], [
			'phpbb_gallery_pcloud_api_host',
			'phpbb_gallery_pcloud_access_token',
			'phpbb_gallery_pcloud_root_name',
		]);
	}
}
