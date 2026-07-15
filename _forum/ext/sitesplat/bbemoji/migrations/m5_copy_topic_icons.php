<?php
/**
*
* @package BBemoji
* @copyright (c) 2018 SiteSplat All rights reserved
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

	public function update_data() {
        return array(
            array('custom', array(array($this, 'copy_topic_icons'))),
        );
	}

	public function copy_topic_icons() {
		$sql = 'SELECT icons_order
			FROM ' . $this->table_prefix . 'icons
			ORDER BY icons_order DESC';
		$result = $this->db->sql_query_limit($sql, 1);
		$order = $this->db->sql_fetchfield('icons_order');
		$this->db->sql_freeresult($result);

		$sql = 'SELECT icons_url, display_on_posting
			FROM ' . $this->table_prefix . 'icons
			ORDER BY icons_order ASC';
		$result = $this->db->sql_query($sql);

		$ary = [];
		while ($row = $this->db->sql_fetchrow($result))
		{
			$ary[] = [
				'icons_emoji'			=> 'images/icons/' . $row['icons_url'],
				'icons_order'			=> ++$order,
				'display_on_posting'	=> $row['display_on_posting'],
			];
		}
		$this->db->sql_freeresult($result);

		$this->db->sql_multi_insert($this->table_prefix . 'emoji_icons', $ary);
	}
}
