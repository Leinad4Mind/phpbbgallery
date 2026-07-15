<?php
/*
* @package cBB Blockgets
* @version v2.0.1 01/02/2020
*
* @copyright (c) 2020 CaniDev
* @license https://opensource.org/licenses/gpl-license.php GNU Public License
*/

namespace canidev\blockgets\migrations;

class v201 extends \phpbb\db\migration\migration
{
	protected $block_ary = null;

	public function effectively_installed()
	{
		return isset($this->config['blg_version']) && version_compare($this->config['blg_version'], '2.0.1', '>=');
	}

	static public function depends_on()
	{
		return array(
			'\canidev\blockgets\migrations\v200',
		);
	}
	
	public function update_schema()
	{
		$this->prepare();

		return array(
			'change_columns' => array(
				BLG_BLOCK_TABLE	=> array(
					'block_groups'	=> array('VCHAR:255', 'all'),
				),
			),
		);
	}

	public function update_data()
	{
		$this->prepare();

		return array(
			array('config.update',	array('blg_version', '2.0.1')),
			array('config.remove', 	array('blg_resize_enabled')),
			array('config.add',		array('blg_calendar_birthdays', 1)),
			
			array('custom', array(array($this, 'update_events'))),
			array('custom', array(array($this, 'update_icons'))),
			array('custom', array(array($this, 'update_block_config'))),
		);
	}
	
	public function prepare()
	{
		if(!defined('BLG_BLOCK_TABLE'))
		{
			$table_prefix = $this->table_prefix;
			include($this->phpbb_root_path . 'ext/canidev/blockgets/libraries/constants.' . $this->php_ext);
		}
	}

	protected function obtain_blocks($filter = '')
	{
		if($this->block_ary === null)
		{
			$this->block_ary = array();

			$sql = 'SELECT *
				FROM ' . BLG_BLOCK_TABLE;
			$result = $this->db->sql_query($sql);
			while($row = $this->db->sql_fetchrow($result))
			{
				$block_id = (int)$row['block_id'];
				$this->block_ary[$block_id] = $row;
			}
			$this->db->sql_freeresult($result);
		}

		if($filter)
		{
			$result = array();

			foreach($this->block_ary as $block_id => $row)
			{
				if($row['block_alias'] != $filter)
				{
					continue;
				}

				$result[$block_id] = $row;
			}

			return $result;
		}

		return $this->block_ary;
	}

	public function update_events()
	{
		$events = array();

		$sql = 'SELECT data_id, data_settings
			FROM ' . BLG_DATA_TABLE . '
			WHERE data_type = ' . BLG_DATA_EVENT;
		$result = $this->db->sql_query($sql);
		while($row = $this->db->sql_fetchrow($result))
		{
			$events[$row['data_id']] = array(
				'groups'	=> $row['data_settings'],
				'color'		=> '',
			);
		}
		$this->db->sql_freeresult($result);

		foreach($events as $id => $settings)
		{
			$sql = 'UPDATE ' . BLG_DATA_TABLE . "
				SET data_settings = '" . serialize($settings) . "'
				WHERE data_id = $id
				AND data_type = " . BLG_DATA_EVENT;
			$this->db->sql_query($sql);
		}
	}
	
	public function update_icons()
	{
		// Update block's icons
		$update_ary = array();

		$this->obtain_blocks();

		foreach($this->block_ary as $block_id => $row)
		{
			$update_ary[$block_id] = array(
				'block_icon'	=> str_replace('blg-icon-', 'fa-', $row['block_icon'])
			);
			
			if(($data = @unserialize($row['block_content'])) !== false)
			{
				if(isset($data['list'][0]['image']))
				{
					foreach($data['list'] as $key => $list_row)
					{
						$data['list'][$key]['image'] = str_replace('blg-icon-', 'fa-', $data['list'][$key]['image']);
					}
					
					$update_ary[$block_id]['block_content'] = serialize($data);
				}
			}
		}
		
		if(sizeof($update_ary))
		{
			foreach($update_ary as $block_id => $ary)
			{
				$sql = 'UPDATE ' . BLG_BLOCK_TABLE . '
					SET ' . $this->db->sql_build_array('UPDATE', $ary) . '
					WHERE block_id = ' . $block_id;
				$this->db->sql_query($sql);
			}
		}
		
		// Update page's icons
		$update_ary = array();

		$sql = 'SELECT page_id, page_data
			FROM ' . BLG_PAGES_TABLE;
		$result = $this->db->sql_query($sql);
		while($row = $this->db->sql_fetchrow($result))
		{
			$page_id = (int)$row['page_id'];
			
			if(($data = @unserialize($row['page_data'])) !== false)
			{
				if(!empty($data['link_icon']))
				{
					$data['link_icon'] = str_replace('blg-icon-', 'fa-', $data['link_icon']);
					
					$update_ary[$page_id] = serialize($data);
				}
			}
		}
		$this->db->sql_freeresult($result);
		
		if(sizeof($update_ary))
		{
			foreach($update_ary as $page_id => $page_data)
			{
				$sql = 'UPDATE ' . BLG_PAGES_TABLE . "
					SET page_data = '" . $page_data . "'
					WHERE page_id = $page_id";
				$this->db->sql_query($sql);
			}
		}
	}

	public function update_block_config()
	{
		$block_ary 	= $this->obtain_blocks();

		foreach($this->block_ary as $block_id => $row)
		{
			$data = null;

			switch($row['block_alias'])
			{
				case 'clock_block':
					$data = 'simple';
				break;

				case 'gallery_block':
					$data = unserialize($row['block_content']);

					$data['max_number'] 		= 50;
					$data['gallery_source'] 	= 1; // gallery_block::SOURCE_ALL
				break;

				case 'google_translate_block':
					// Remove en_us language
					$row['block_content'] = preg_replace('#en_us,?#', '', $row['block_content']);

					$data = array(
						'langs'			=> explode(',', $row['block_content']),
						'show_names'	=> 0,
					);
				break;

				case 'post_view_block':
					$data 		= unserialize($row['block_content']);
					$params		= array();

					switch($data['mode'])
					{
						case 'custom':
							$params = array('topic', 'p', $data['item_id']);
						break;

						case 'forum':
							$params = array('forum', 'f', $data['item_id']);
						break;

						case 'topic_first':
							$sql = 'SELECT topic_first_post_id
								FROM ' . TOPICS_TABLE . '
								WHERE topic_id = ' . (int)$data['item_id'];
							$result = $this->db->sql_query($sql);
							$post_id = (int)$this->db->sql_fetchfield('topic_first_post_id');
							$this->db->sql_freeresult($result);

							$params = array('topic', 'p', $post_id);
						break;

						case 'topic_last':
							$params = array('topic', 't', $data['item_id']);
						break;
					}

					$data['item_url'] = vsprintf(generate_board_url() . '/view%s.' . $this->php_ext . '?%s=%d', $params);

					unset($data['mode'], $data['item_id']);
				break;

				case 'share_block':
					$replaces = array(
						2	=> 'twitter',
						3	=> 'facebook',
						4	=> 'linkedin',
					);

					$data = unserialize($row['block_content']);

					foreach($data['share_buttons'] as $i => $button_id)
					{
						if(isset($replaces[$button_id]))
						{
							$data['share_buttons'][$i] = $replaces[$button_id];
						}
						else
						{
							unset($data['share_buttons'][$i]);
						}
					}

					unset($data['share_counter']);

					$data['show_names'] = 1;
				break;

				case 'recent_topics_block':
				case 'topic_index_block':
				case 'top_topics_block':
					$data = unserialize($row['block_content']);

					$data['topic_design'] = 'simple';
				break;
			}

			if($data !== null)
			{
				$sql = 'UPDATE ' . BLG_BLOCK_TABLE . "
					SET block_content = '" . (is_array($data) ? serialize($data) : $data) . "'
					WHERE block_id = $block_id";
				$this->db->sql_query($sql);
			}
		}
	}
}
