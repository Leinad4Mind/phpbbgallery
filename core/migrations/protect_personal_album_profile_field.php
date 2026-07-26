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

class protect_personal_album_profile_field extends migration
{
	public static function depends_on(): array
	{
		return ['\phpbbgallery\core\migrations\performance_indexes'];
	}

	public function update_data(): array
	{
		return [
			['custom', [[$this, 'hide_managed_profile_field']]],
		];
	}

	/**
	 * Keep the Gallery-managed album identifier out of the editable UCP fields.
	 *
	 * @return void
	 */
	public function hide_managed_profile_field(): void
	{
		$sql = 'UPDATE ' . $this->table_prefix . "profile_fields
			SET field_show_profile = 0
			WHERE field_ident = '" . $this->db->sql_escape('gallery_palbum') . "'";
		$this->db->sql_query($sql);
	}
}
