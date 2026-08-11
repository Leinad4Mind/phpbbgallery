<?php
/**
 * phpBB Gallery - relocate the managed personal-album profile link.
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\migrations;

use phpbb\db\migration\migration;

/** Stop presenting a Gallery album as if it were a contact method. */
class relocate_personal_album_profile_field extends migration
{
	public static function depends_on(): array
	{
		return ['\phpbbgallery\core\migrations\group_leader_permissions'];
	}

	public function update_data(): array
	{
		return [
			['custom', [[$this, 'hide_legacy_contact_field']]],
		];
	}

	public function revert_data(): array
	{
		return [];
	}

	public function hide_legacy_contact_field(): bool
	{
		$sql = 'UPDATE ' . $this->table_prefix . "profile_fields
			SET field_show_on_vt = 0,
				field_show_on_pm = 0,
				field_show_profile = 0,
				field_is_contact = 0
			WHERE field_ident = '" . $this->db->sql_escape('gallery_palbum') . "'";
		$this->db->sql_query($sql);

		return true;
	}
}
