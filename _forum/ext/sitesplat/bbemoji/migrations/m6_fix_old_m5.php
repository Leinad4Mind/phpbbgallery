<?php
/**
*
* @package BBemoji
* @copyright (c) 2018 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\bbemoji\migrations;

class m6_fix_old_m5 extends \phpbb\db\migration\migration
{
	static public function depends_on()
	{
		return array('\sitesplat\bbemoji\migrations\m5_copy_topic_icons');
	}

	public function update_data() {
		return array(
			array('custom', array(array($this, 'fix_icons'))),
		);
	}

	public function fix_icons()
	{
		// Get outta here if an initial install
		if (defined('BBEMOJI_RUN_M3')) {
			return;
		}

//		$sql = "SELECT MAX(icons_id) AS max_id FROM {$this->table_prefix}emoji_icons";
//		$result = $this->db->sql_query($sql);
//		$max_id = (int) $this->db->sql_fetchfield('max_id');
//		$this->db->sql_freeresult($result);

		include(__DIR__ . DIRECTORY_SEPARATOR . 'm0_default_icon_sql.php');
		$this->db->sql_query("TRUNCATE {$this->table_prefix}emoji_icons");
		$this->db->sql_query("INSERT INTO {$this->table_prefix}emoji_icons VALUES " . BBEMOJI_DEFAULT_ICON_SQL);

		// Copy system topic icons with icon IDs larger than BBEMOJI_DEFAULT_ICON_MAX
		$max_id = BBEMOJI_DEFAULT_ICON_MAX;

		$xtra_icons = [];
		$sql = "SELECT icons_id, icons_url, display_on_posting FROM {$this->table_prefix}icons WHERE icons_id > $max_id ORDER BY icons_id ASC";
		$result = $this->db->sql_query($sql);
		While ($row = $this->db->sql_fetchrow($result)) {
			$max_id++;
			$xtra_icons[] = "({$row['icons_id']},'{$this->config['icons_path']}/{$row['icons_url']}',$max_id,{$row['display_on_posting']})";
		}

		$this->db->sql_freeresult($result);
		if (count($xtra_icons)) {
			$this->db->sql_query("INSERT INTO {$this->table_prefix}emoji_icons VALUES " . implode(',', $xtra_icons));
		}

		// Fix icon IDs in topics/posts tables. Max ID was 10 in old BBemoji. Slow query alert!!!
		$this->db->sql_query("UPDATE {$this->table_prefix}topics SET icon_id = icon_id - 10 WHERE icon_id > 10");
		$this->db->sql_query("UPDATE {$this->table_prefix}posts SET icon_id = icon_id - 10 WHERE icon_id > 10");
	}
}
