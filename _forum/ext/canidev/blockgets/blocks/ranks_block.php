<?php
/*
* @package cBB Blockgets
* @version v2.0.4 30/08/2021
*
* @copyright (c) 2021 CaniDev
* @license https://opensource.org/licenses/gpl-license.php GNU Public License
*/

namespace canidev\blockgets\blocks;

class ranks_block extends base
{
	static $icon = 'fa-star-half-o';

	public function init()
	{
		$this->tpl_name = 'ranks_block';

		if(($data = $this->unserialize()) === false)
		{
			return false;
		}
		
		// Delete the array in the template if exists, prevent errors between blocks
		$this->template->destroy_block_vars('rank');
		
		$sql_ary = array(
			'SELECT'	=> 'r.*',
			'FROM'		=> array(RANKS_TABLE => 'r'),
			'WHERE'		=> '',
			'ORDER_BY'	=> 'r.rank_special DESC, r.rank_title ASC',
		);

		if(!$data['show_orphan'])
		{
			$sql_ary['LEFT_JOIN'] = array(
				array('FROM' => array(USERS_TABLE => 'u'),	'ON' => 'u.user_rank = r.rank_id'),
			);

			$sql_ary['WHERE'] = 'u.user_id IS NOT NULL';
		}

		if($data['only_special'])
		{
			$sql_ary['WHERE'] .= (($sql_ary['WHERE']) ? ' AND' : '') . ' r.rank_special = 1';
		}

		/*
		* @event block.ranks_query
		* @var array	sql_ary		The SQL data
		* @var	array	data		Block Configuration
		* @since 2.0.0
		*/
		$vars = array('sql_ary', 'data');
		extract($this->dispatcher->trigger_event('block.ranks_query', compact($vars)));

		$sql = $this->db->sql_build_query('SELECT', $sql_ary);
		$result = $this->db->sql_query($sql);
		while($row = $this->db->sql_fetchrow($result))
		{
			$rank_row = array(
				'S_TITLE'		=> $row['rank_title'],
				'S_IMG_SRC'		=> ($row['rank_image']) ? $this->helper->get_web_root_path() . $this->config['ranks_path'] . '/' . $row['rank_image'] : '',
				'S_MIN_POSTS'	=> $row['rank_min'],
				'IS_SPECIAL'	=> ($row['rank_special']) ? true : false,
			);

			/*
			* @event block.ranks_row
			* @var array	rank_row		The output array
			* @var array	row				The original data
			* @var	array	data			Block Configuration
			* @since 2.0.0
			*/
			$vars = array('rank_row', 'row', 'data');
			extract($this->dispatcher->trigger_event('block.ranks_row', compact($vars)));
			
			$this->template->assign_block_vars('rank', $rank_row);
		}
		$this->db->sql_freeresult($result);

		unset($data);
		return true;
	}

	public function get_config()
	{
		$this->display_vars = array(
			'show_orphan'	=> array('lang' => 'ORPHAN_RANKS',			'validate' => 'bool',	'type' => 'radio:yes_no',	'default' => 1),
			'only_special'	=> array('lang' => 'ONLY_SPECIAL_RANKS',	'validate' => 'bool',	'type' => 'radio:yes_no',	'default' => 0),
		);

		return true;
	}
}
