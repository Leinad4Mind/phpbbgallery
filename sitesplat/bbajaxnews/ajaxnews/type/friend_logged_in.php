<?php
/**
*
* @package BBajaxnews
* @copyright (c) 2018 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\bbajaxnews\ajaxnews\type;

class friend_logged_in extends base
{
	protected $zebra_table;
	public function set_tables($zebra_table)
	{
		$this->zebra_table = $zebra_table;
	}

	public function get_type()
	{
		return 'sitesplat.bbajaxnews.ajaxnews.type.friend_logged_in';
	}

	public function get_lang_array($data)
	{
		return [
			get_username_string('full', $data['user_id'], $data['username'], $data['user_colour']),
		];
	}

	public function get_receivers($data)
	{
		$sql_ary = $this->get_basic_query();

		$sql_ary['LEFT_JOIN'][] = [
			'FROM'	=> [$this->zebra_table => 'z'],
			'ON'	=> 'z.user_id = u.user_id',
		];
		$sql_ary['WHERE'] .= ' AND z.zebra_id = ' . (int) $data['user_id'];

		return $this->query_receivers($sql_ary);
	}

	public function is_special()
	{
		return true;
	}
}
