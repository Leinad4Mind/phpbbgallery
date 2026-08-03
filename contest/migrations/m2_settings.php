<?php
/**
 * phpBB Gallery - Contest Add-on settings.
 *
 * @package   phpbbgallery/contest
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\contest\migrations;

use phpbb\db\migration\migration;

class m2_settings extends migration
{
	public static function depends_on(): array
	{
		return ['\phpbbgallery\contest\migrations\m1_init'];
	}

	public function update_data(): array
	{
		return [
			['config.add', ['phpbb_gallery_allow_contests', 1]],
			['config.add', ['phpbb_gallery_contests_ended', 0]],
		];
	}

	public function revert_data(): array
	{
		return [
			['config.remove', ['phpbb_gallery_allow_contests']],
			['config.remove', ['phpbb_gallery_contests_ended']],
		];
	}
}
