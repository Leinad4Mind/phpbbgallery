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

class new_posts_today extends base
{
	protected $posts_table;
	public function set_posts_table($posts_table)
	{
		$this->posts_table = $posts_table;
	}

	public function get_type()
	{
		return 'sitesplat.bbajaxnews.ajaxnews.type.new_posts_today';
	}

	public function get_lang_array($data)
	{
		$sql = 'SELECT COUNT(post_id) as total_posts
				FROM ' . $this->posts_table . '
				WHERE post_time > ' . strtotime('midnight');
		$this->db->sql_query($sql);

		return [
			(int) $this->db->sql_fetchfield('total_posts'),
		];
	}

	public function is_special()
	{
		return false;
	}
}
