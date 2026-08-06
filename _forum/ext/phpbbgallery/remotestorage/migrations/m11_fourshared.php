<?php
/**
 * phpBB Gallery - 4shared storage settings.
 *
 * @package   phpbbgallery/remotestorage
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\remotestorage\migrations;

use phpbb\db\migration\migration;

final class m11_fourshared extends migration
{
	public static function depends_on(): array
	{
		return ['\phpbbgallery\remotestorage\migrations\m10_koofr'];
	}

	public function update_data(): array
	{
		return [
			['config.add', ['phpbb_gallery_fourshared_consumer_key', '']],
			['config.add', ['phpbb_gallery_fourshared_consumer_secret', '']],
			['config.add', ['phpbb_gallery_fourshared_access_token', '']],
			['config.add', ['phpbb_gallery_fourshared_access_token_secret', '']],
			['config.add', ['phpbb_gallery_fourshared_root_name', 'phpbbgallery']],
		];
	}

	public function revert_data(): array
	{
		return array_map(static fn (string $key): array => ['config.remove', [$key]], [
			'phpbb_gallery_fourshared_consumer_key',
			'phpbb_gallery_fourshared_consumer_secret',
			'phpbb_gallery_fourshared_access_token',
			'phpbb_gallery_fourshared_access_token_secret',
			'phpbb_gallery_fourshared_root_name',
		]);
	}
}
