<?php
/*
* @package cBB Blockgets
* @version v2.0.3 26/07/2021
*
* @copyright (c) 2021 CaniDev
* @license https://opensource.org/licenses/gpl-license.php GNU Public License
*/

namespace canidev\blockgets\blocks;

class cloud_tag_block extends base
{
	static $icon = 'fa-tags';

	public function init()
	{
		$this->tpl_name = 'cloud_tag_block';

		if(($data = $this->unserialize()) === false)
		{
			return false;
		}
		
		$tag_rows = array();

		switch($data['list_mode'])
		{
			case 'search':
				// Handle large objects differently for Oracle and MSSQL
				switch ($this->db->get_sql_layer())
				{
					case 'oracle':
						$sql = 'SELECT search_time, search_keywords
							FROM ' . SEARCH_RESULTS_TABLE . '
							WHERE dbms_lob.getlength(search_keywords) > 0
							ORDER BY search_time DESC';
					break;

					case 'mssql_odbc':
					case 'mssqlnative':
						$sql = 'SELECT search_time, search_keywords
							FROM ' . SEARCH_RESULTS_TABLE . '
							WHERE DATALENGTH(search_keywords) > 0
							ORDER BY search_time DESC';
					break;

					default:
						$sql = 'SELECT search_time, search_keywords
							FROM ' . SEARCH_RESULTS_TABLE . '
							WHERE search_keywords <> \'\'
							ORDER BY search_time DESC';
					break;
				}
				$result = $this->db->sql_query_limit($sql, $data['max_words']);
				while($row = $this->db->sql_fetchrow($result))
				{
					$tag_rows[] = array(
						'S_TAG_NAME'	=> $row['search_keywords'],
						'U_TAG_URL'		=> $this->helper->url('search', array(
							'i' 		=> 'search',
							'mode'		=> 'search',
							'keywords'	=> urlencode(htmlspecialchars_decode($row['search_keywords']))
						)),
					);
				}
				$this->db->sql_freeresult($result);
			break;

			case 'users':
				$sql = 'SELECT user_id, username
					FROM ' . USERS_TABLE . '
					WHERE user_type <> ' . USER_IGNORE . '
					ORDER BY user_posts DESC';
				$result = $this->db->sql_query_limit($sql, $data['max_words']);
				while($row = $this->db->sql_fetchrow($result))
				{
					$tag_rows[] = array(
						'S_TAG_NAME'	=> $row['username'],
						'U_TAG_URL'		=> $this->helper->url('memberlist', array(
							'mode'	=> 'viewprofile',
							'u'		=> $row['user_id']
						))
					);
				}
				$this->db->sql_freeresult($result);
			break;

			default:
				/*
				* @event block.cloud_tag_custom_mode
				* @var	array	tag_rows	Data to put in template
				* @var	array	data		Block Configuration
				* @since 2.0.2
				*/
				$vars = array('tag_rows', 'data');
				extract($this->dispatcher->trigger_event('block.cloud_tag_custom_mode', compact($vars)));
			break;
		}
		
		foreach($tag_rows as $row)
		{
			if(!isset($row['S_TAG_SIZE']))
			{
				$row['S_TAG_SIZE'] = ($data['animation']) ?  rand(10, 16) : rand(8, 22);
			}

			$this->template->assign_block_vars('clouds', $row);
		}

		$this->template->assign_var('S_SHOW_ANIMATION', ($data['animation'] && sizeof($tag_rows)));
		$this->template->append_asset('js', '@canidev_blockgets/js/tagcanvas.min.js');

		unset($data, $tag_rows);
		return true;
	}

	public function get_config()
	{
		$modes = array('search' => 'MODE_SEARCH',	'users'	=> 'MODE_USERS');

		$this->display_vars = array(
			'animation'		=> array('lang' => 'CLOUD_ANIMATION',	'validate' => 'bool',		'type' => 'radio:yes_no', 	'default' => 1),
			'max_words'		=> array('lang' => 'CLOUD_WORDS',		'validate' => 'int:1:50',	'type' => 'number:1:50', 	'default' => 25),
			'list_mode'		=> array('lang' => 'CLOUD_MODE',		'validate' => 'string',		'type' => 'custom', 		'method' => 'helper',	'params' => array('make_select', $modes, '{KEY}', '{CONFIG_VALUE}'),  'default' => 'search'),
		);

		return true;
	}
}
