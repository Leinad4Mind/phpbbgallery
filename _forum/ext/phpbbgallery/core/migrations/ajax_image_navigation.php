<?php
/**
 * phpBB Gallery - Core Extension
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\migrations;

use phpbb\db\migration\migration;

/**
 * Add the optional progressive image-page navigation switch.
 */
class ajax_image_navigation extends migration
{
	public static function depends_on(): array
	{
		return ['\\phpbbgallery\\core\\migrations\\viewtopic_profiles'];
	}

	public function update_data(): array
	{
		return [
			['config.add', ['phpbb_gallery_ajax_navigation', 0]],
		];
	}

	public function revert_data(): array
	{
		return [
			['config.remove', ['phpbb_gallery_ajax_navigation']],
		];
	}
}
