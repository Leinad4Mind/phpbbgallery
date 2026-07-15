<?php
/**
 *
 * BBajaxnews. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2018, SiteSplat
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace sitesplat\bbajaxnews\ajaxnews\type;

class bbvote extends base
{
	protected $topics_table;
	public function set_dependencies($topics_table)
	{
		$this->topics_table = $topics_table;
	}

	public function get_type()
	{
		return 'sitesplat.bbajaxnews.ajaxnews.type.bbvote';
	}

	public function get_lang_array($data)
	{
		$sql_ary = [
			'SELECT'	=> 't.topic_title',
			'FROM'	=> [
				$this->topics_table	=> 't',
			],
			'WHERE'		=> 't.topic_id = ' . (int) $data['topic_id'],
		];
		$result = $this->db->sql_query($this->db->sql_build_query('SELECT', $sql_ary));
		$row = $this->db->sql_fetchrow($result);
		$this->db->sql_freeresult($result);

		return [
			'<a href="' . generate_board_url() . '/' . append_sid('viewtopic.' . $this->php_ext, 't=' .  (int) $data['topic_id']) . '">' . $row['topic_title'] . '</a>',
		];
	}

	public function is_special()
	{
		return true;
	}
}
