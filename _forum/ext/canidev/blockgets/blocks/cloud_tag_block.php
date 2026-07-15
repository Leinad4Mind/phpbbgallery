<?php
/*
* @name cloud_tag_block.php
* @package cBB Blockgets
* @version v2.0.0 30/05/2017
*
* @copyright (c) 2017 CaniDev
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/

namespace canidev\blockgets\blocks;

// @ignore
if(!defined('IN_PHPBB'))
{
	exit;
}

class cloud_tag_block extends base
{
	static $icon = 'blg-icon-tags';

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
				$sql = 'SELECT word_text
					FROM ' . SEARCH_WORDLIST_TABLE . '
					ORDER BY word_count DESC';
				$result = $this->db->sql_query_limit($sql, $data['max_words']);
				while($row = $this->db->sql_fetchrow($result))
				{
					$tag_rows[] = array(
						'S_TAG_NAME'	=> $row['word_text'],
						'U_TAG_URL'		=> $this->helper->url('search', array(
							'i' 		=> 'search',
							'mode'		=> 'search',
							'keywords'	=> urlencode($row['word_text'])
						)),
					);
				}
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
			break;

			default:
				return false;
			break;
		}
		$this->db->sql_freeresult($result);
		
		foreach($tag_rows as $row)
		{
			$row['S_TAG_SIZE'] = ($data['animation']) ?  rand(10, 16) : rand(8, 22);

			/**
			* @event block.cloud_tag_row
			* @var array	row		The output array
			* @since 2.0.0
			*/
			$vars = array('row');
			extract($this->dispatcher->trigger_event('block.cloud_tag_row', compact($vars)));

			$this->template->assign_block_vars('clouds', $row);
		}

		$this->template->assign_var('S_SHOW_ANIMATION', $data['animation']);

		unset($data, $tag_rows);
		return true;
	}

	public function get_config()
	{
		$modes = array('search' => 'MODE_SEARCH',	'users'	=> 'MODE_USERS');

		$this->display_vars = array(
			'animation'		=> array('lang' => 'CLOUD_ANIMATION',	'validate' => 'bool',		'type' => 'radio:yes_no', 	'default' => 1),
			'max_words'		=> array('lang' => 'CLOUD_WORDS',		'validate' => 'int:1:50',	'type' => 'text:4:3', 		'default' => 25),
			'list_mode'		=> array('lang' => 'CLOUD_MODE',		'validate' => 'string',		'type' => 'select', 		'method' => 'helper',	'params' => array('make_select', $modes, '{CONFIG_VALUE}'),  'default' => 'search'),
		);

		return true;
	}
}
