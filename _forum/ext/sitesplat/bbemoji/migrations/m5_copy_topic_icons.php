<?php

/**
 *
 * @package BBEmoji
 * @copyright (c) 2018-2022 SiteSplat All rights reserved
 * @license Proprietary
 *
 */

namespace sitesplat\bbemoji\migrations;

class m5_copy_topic_icons extends \phpbb\db\migration\migration
{
	static public function depends_on()
	{
		return array('\sitesplat\bbemoji\migrations\m4_enable_emoji_in_subject');
	}

	public function update_data()
	{
		return array(
			array('custom', array(array($this, 'copy_topic_icons'))),
		);
	}

	public function copy_topic_icons()
	{
		if (!defined('BBEMOJI_DEFAULT_ICON_MAX')) {
			include(__DIR__ . DIRECTORY_SEPARATOR . 'm0_default_icon_sql.php');
		}

		$max_order = BBEMOJI_DEFAULT_ICON_MAX;

		// Copy system topic icons to emoji_icons table.
		//
		// If a system topic icon is added to a post while BBEmoji is enabled, it will disappear
		//   when BBEmoji is disabled! The code below fixes this...at a cost.
		//		$this->db->sql_query("INSERT INTO {$this->table_prefix}emoji_icons SELECT NULL, CONCAT('{$this->config['icons_path']}/', icons_url), icons_order + $max_order, display_on_posting FROM {$this->table_prefix}icons");

		// This block of code will only copy system topic icons with icon IDs larger than BBEMOJI_DEFAULT_ICON_MAX.
		//
		// It fixes the icon ID issues when disabling BBEmoji, at the cost of losing some
		//   system topic icons when BBEmoji is enabled. IMO by far the better option!
		$xtra_icons = [];
		$sql = "SELECT icons_id, icons_url, display_on_posting FROM {$this->table_prefix}icons WHERE icons_id > $max_order ORDER BY icons_id ASC";
		$result = $this->db->sql_query($sql);
		while ($row = $this->db->sql_fetchrow($result)) {
			$max_order++;
			$xtra_icons[] = "({$row['icons_id']},'{$this->config['icons_path']}/{$row['icons_url']}',$max_order,{$row['display_on_posting']})";
		}

		$this->db->sql_freeresult($result);
		if (count($xtra_icons)) {
			$this->db->sql_query("INSERT INTO {$this->table_prefix}emoji_icons VALUES " . implode(',', $xtra_icons));
		}
	}
}
