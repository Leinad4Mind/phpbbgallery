<?php
/**
 * phpBB Gallery - Koofr storage settings.
 *
 * @package   phpbbgallery/remotestorage
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\remotestorage\migrations;

use phpbb\db\migration\migration;

final class m10_koofr extends migration
{
	public static function depends_on(): array
	{
		return ['\phpbbgallery\remotestorage\migrations\m9_pcloud'];
	}

	public function update_data(): array
	{
		return [
			['config.add', ['phpbb_gallery_koofr_email', '']],
			['config.add', ['phpbb_gallery_koofr_app_password', '']],
			['config.add', ['phpbb_gallery_koofr_root_name', 'phpbbgallery']],
		];
	}

	public function revert_data(): array
	{
		return array_map(static fn (string $key): array => ['config.remove', [$key]], [
			'phpbb_gallery_koofr_email',
			'phpbb_gallery_koofr_app_password',
			'phpbb_gallery_koofr_root_name',
		]);
	}
}
