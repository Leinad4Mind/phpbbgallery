<?php
/**
 * phpBB Gallery - selectable Gallery index album layouts.
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\migrations;

use phpbb\db\migration\migration;

/** Add the Gallery index album layout preference. */
class index_album_layout extends migration
{
	public static function depends_on(): array
	{
		return [
			'\\phpbbgallery\\core\\migrations\\image_dimensions',
			'\\phpbbgallery\\core\\migrations\\image_orientation',
		];
	}

	public function update_data(): array
	{
		return [
			['config.add', ['phpbb_gallery_index_album_layout', 'cards']],
		];
	}

	public function revert_data(): array
	{
		return [
			['config.remove', ['phpbb_gallery_index_album_layout']],
		];
	}
}
