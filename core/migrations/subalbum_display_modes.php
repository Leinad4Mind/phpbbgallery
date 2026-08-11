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

/** Replace the global icon switch with a per-parent subalbum display mode. */
class subalbum_display_modes extends migration
{
	public static function depends_on(): array
	{
		return ['\phpbbgallery\core\migrations\subalbum_icon_display'];
	}

	public function update_data(): array
	{
		return [
			['custom', [[$this, 'migrate_display_modes']]],
			['config.remove', ['phpbb_gallery_disp_subalbum_icons']],
		];
	}

	public function revert_data(): array
	{
		return [
			['config.add', ['phpbb_gallery_disp_subalbum_icons', 1]],
			['custom', [[$this, 'restore_boolean_modes']]],
		];
	}

	public function migrate_display_modes(): bool
	{
		$visible_mode = !empty($this->config['phpbb_gallery_disp_subalbum_icons']) ? 2 : 1;
		$sql = 'UPDATE ' . $this->table_prefix . 'gallery_albums
			SET display_subalbum_list = ' . $visible_mode . '
			WHERE display_subalbum_list <> 0';
		$this->db->sql_query($sql);

		return true;
	}

	public function restore_boolean_modes(): bool
	{
		$sql = 'UPDATE ' . $this->table_prefix . 'gallery_albums
			SET display_subalbum_list = 1
			WHERE display_subalbum_list > 0';
		$this->db->sql_query($sql);

		return true;
	}
}
