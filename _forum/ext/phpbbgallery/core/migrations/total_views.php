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

class total_views extends migration
{
	public static function depends_on(): array
	{
		return ['\phpbbgallery\core\migrations\protect_personal_album_profile_field'];
	}

	public function update_data(): array
	{
		return [
			['config.add', ['phpbb_gallery_num_views', 0, true]],
			['custom', [[$this, 'resync_total_views']]],
		];
	}

	public function revert_data(): array
	{
		return [
			['config.remove', ['phpbb_gallery_num_views']],
		];
	}

	public function resync_total_views(): bool
	{
		global $config;

		$sql = 'SELECT SUM(image_view_count) AS total_views
			FROM ' . $this->table_prefix . 'gallery_images';
		$result = $this->db->sql_query($sql);
		$total_views = (int) $this->db->sql_fetchfield('total_views');
		$this->db->sql_freeresult($result);

		$config->set('phpbb_gallery_num_views', $total_views, false);

		return true;
	}
}
