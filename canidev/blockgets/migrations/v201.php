<?php
/*
* @package cBB Blockgets
* @version v2.0.1 26/07/2021
*
* @copyright (c) 2021 CaniDev
* @license https://creativecommons.org/licenses/by-nc/4.0/
*/

namespace canidev\blockgets\migrations;

use canidev\blockgets\libraries\constants;

class v201 extends \canidev\blockgets\libraries\migration_base
{
	protected $block_manager;

	protected $version = '2.0.1';

	static public function depends_on()
	{
		return array(
			'\canidev\blockgets\migrations\v200',
		);
	}
	
	public function update_schema()
	{
		return array(
			'change_columns' => array(
				$this->table_prefix . 'blockgets_blocks'	=> array(
					'block_groups'	=> array('VCHAR:255', 'all'),
				),
			),
		);
	}

	public function _update_data()
	{
		$this->block_manager = new \canidev\blockgets\libraries\block_manager($this->db, $this->table_prefix);
		
		return array(
			array('config.remove', 	array('blg_resize_enabled')),
			array('config.add',		array('blg_calendar_birthdays', 1)),
			
			array('custom', array(array($this, 'update_events'))),
			array('custom', array(array($this, 'update_icons'))),
			array('custom', array(array($this, 'update_block_config'))),
		);
	}

	public function update_events()
	{
		$events = [];

		$sql = 'SELECT data_id, data_settings
			FROM ' . $this->table_prefix . 'blockgets_data
			WHERE data_type = ' . constants::DATA_EVENT;
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
			$sql = 'UPDATE ' . $this->table_prefix . "blockgets_data
				SET data_settings = '" . serialize($settings) . "'
				WHERE data_id = $id
				AND data_type = " . constants::DATA_EVENT;
			$this->db->sql_query($sql);
		}
	}
	
	public function update_icons()
	{
		// Update block's icons
		$update_ary = [];

		$block_ary = $this->block_manager->get();

		foreach($block_ary as $block_id => $row)
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
		
		foreach($update_ary as $block_id => $ary)
		{
			$this->block_manager->update_block($block_id, $ary);
		}
		
		// Update page's icons
		$update_ary = [];

		$sql = 'SELECT page_id, page_data
			FROM ' . $this->table_prefix . 'blockgets_pages';
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
				$sql = 'UPDATE ' . $this->table_prefix . "blockgets_pages
					SET page_data = '" . $page_data . "'
					WHERE page_id = $page_id";
				$this->db->sql_query($sql);
			}
		}
	}

	public function update_block_config()
	{
		$this->block_manager->add_config(array(
			'clock_block' 		=> 'simple',
			'gallery_block' 	=> array(
				'max_number' 		=> 50,
				'gallery_source'	=> 1, // gallery_block::SOURCE_ALL
			),
			'leaders_block'			=> array('use_all_groups' 	=> 0),
			'recent_topics_block'	=> array('topic_design' 	=> 'simple'),
			'topic_index_block'		=> array('topic_design' 	=> 'simple'),
			'top_topics_block'		=> array('topic_design' 	=> 'simple'),
		));

		$block_ary = $this->block_manager->get();

		foreach($block_ary as $block_id => $row)
		{
			$data = null;

			switch($row['block_alias'])
			{
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
					$params		= [];

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

					$data['share_buttons'] = array_values($data['share_buttons']);

					unset($data['share_counter']);

					$data['show_names'] = 1;
				break;
			}

			if($data !== null)
			{
				$this->block_manager->update_block($block_id, array(
					'block_content'		=> is_array($data) ? serialize($data) : $data
				));
			}
		}
	}
}
