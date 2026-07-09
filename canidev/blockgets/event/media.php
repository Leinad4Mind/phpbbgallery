<?php
/**
 * @package cBB Blockgets
 * @version 2.0.7 01/07/2024
 *
 * @copyright (c) 2024 CaniDev
 * @license https://creativecommons.org/licenses/by-nc/4.0/
 */

namespace canidev\blockgets\event;

use canidev\blockgets\libraries\constants;

class media
{
	protected $db;
	protected $language;
	protected $user;

	protected $tables;

	/**
	 * Constructor
	 *
	 * @param \phpbb\db\driver\driver_interface		$db				DB Object
	 * @param \phpbb\language\language				$language		Language Object
	 * @param \phpbb\user							$user			User object
	 * @param array 								$tables 		Blockgets DB Tables
	 *
	 * @access public
	 */
	public function __construct(
		\phpbb\db\driver\driver_interface $db,
		\phpbb\language\language $language,
		\phpbb\user $user,
		$tables)
	{
		$this->db		= $db;
		$this->language	= $language;
		$this->user		= $user;

		$this->tables 	= $tables;
	}

	/**
	 * Get media events
	 * @return array
	 */
	public function getSubscribedEvents()
	{
		return [
			'gallery.before_action'	=> [$this, 'media_gallery_options'],
			'gallery.delete'		=> [$this, 'media_gallery_delete'],
			'gallery.insert'		=> [$this, 'media_gallery_upload'],
			'gallery.load'			=> [$this, 'media_gallery_load'],
			'gallery.update'		=> [$this, 'media_gallery_update'],
			'gallery.upload'		=> [$this, 'media_gallery_upload'],
			'sections.load'			=> [$this, 'media_sections_load'],
		];
	}

	/**
	 * Set gallery options
	 * 
	 * @param array 	$event 		Event Data
	 */
	public function media_gallery_options($event)
	{
		$event['instance']->set_option('allowPagination', true);
	}

	/**
	 * Load gallery items
	 * 
	 * @param array 	$event 		Event Data
	 */
	public function media_gallery_load($event)
	{
		$rowset 	= [];
		$sql_where 	= 'data_type = ' . constants::DATA_ATTACHMENT;
		$start 		= $event['instance']->get_param('start', 0);
		$query 		= strtolower($event['instance']->get_param('query', ''));
		
		if(!empty($event['item_ary']))
		{
			$sql_where .= ' AND ' . $this->db->sql_in_set('data_id', $event['item_ary']);
		}
		else if($query)
		{
			$like_exp = $this->db->sql_like_expression($this->db->get_any_char() . $query . $this->db->get_any_char());
			
			$sql_where .= ' AND (LOWER(data_title) ' . $like_exp . ' OR LOWER(data_content) ' . $like_exp . ')';
		}

		// Count total for pagination
		if($event['item_ary'] === false)
		{
			$sql = 'SELECT COUNT(*) AS total
				FROM ' . $this->tables['data'] . '
				WHERE ' . $sql_where;
			$result = $this->db->sql_query($sql);
			$event['total_items'] = (int)$this->db->sql_fetchfield('total');
			$this->db->sql_freeresult($result);
		}
	
		// Get items
		$sql = 'SELECT *
			FROM ' . $this->tables['data'] . '
			WHERE ' . $sql_where . '
			ORDER BY data_time DESC';
		$result = ($event['item_ary'] === false) ? $this->db->sql_query_limit($sql, $event['instance']->get_option('itemsPerPage'), $start) : $this->db->sql_query($sql);
		while($row = $this->db->sql_fetchrow($result))
		{
			$params = @unserialize($row['data_settings']);
			
			$rowset[] = array_merge($params, [
				'id'			=> $row['data_id'],
				'title'			=> $row['data_title'],
				'description'	=> $row['data_content'],
			]);
		}
		$this->db->sql_freeresult($result);
		
		$event['rowset'] = $rowset;
	}

	/**
	 * Update gallery item
	 * 
	 * @param array 	$event 		Event Data
	 */
	public function media_gallery_update($event)
	{
		$sql_ary = [
			'data_title'	=> $event['instance']->get_param('title', ''),
			'data_content'	=> $event['instance']->get_param('description', ''),
		];

		$sql = 'UPDATE ' . $this->tables['data'] . '
			SET ' . $this->db->sql_build_array('UPDATE', $sql_ary) . '
			WHERE data_type = ' . constants::DATA_ATTACHMENT . '
			AND data_id = ' . (int)$event['instance']->get_param('originalId', 0);
		$this->db->sql_query($sql);
	}
	
	/**
	 * Upload item to gallery
	 * 
	 * @param array 	$event 		Event Data
	 */
	public function media_gallery_upload($event)
	{
		$rowset = $event['rowset'];

		$image_data = [
			'user_id'		=> $this->user->data['user_id'],
			'data_type'		=> constants::DATA_ATTACHMENT,
			'data_title'	=> $rowset['title'],
			'data_content'	=> '',
			'data_time'		=> time(),
			'data_settings'	=> serialize([
				'filename'	=> $rowset['filename'],
				'filesize'	=> $rowset['filesize'],
				'width'		=> $rowset['width'],
				'height'	=> $rowset['height'],
			]),
		];
		
		$sql = 'INSERT INTO ' . $this->tables['data'] . $this->db->sql_build_array('INSERT', $image_data);
		$this->db->sql_query($sql);
		
		$rowset['id'] = (int)$this->db->sql_nextid();

		$event['rowset'] = $rowset;
	}
	
	/**
	 * Delete gallery item
	 * 
	 * @param array 	$event 		Event Data
	 */
	public function media_gallery_delete($event)
	{
		$rowset = [];
		
		$sql_where = 'data_type = ' . constants::DATA_ATTACHMENT . '
			AND ' . $this->db->sql_in_set('data_id', $event['params']['items']);

		$sql = 'SELECT data_settings
			FROM ' . $this->tables['data'] . "
			WHERE $sql_where";
		$result = $this->db->sql_query($sql);
		while($row = $this->db->sql_fetchrow($result))
		{
			$data = unserialize($row['data_settings']);
			
			if(isset($data['filename']) && preg_match('#^([0-9]+)_(.*)#', $data['filename']))
			{
				$rowset[] = $data['filename'];
			}
		}
		$this->db->sql_freeresult($result);
		
		// Delete items in the db
		$sql = 'DELETE FROM ' . $this->tables['data'] . "
			WHERE $sql_where";
		$this->db->sql_query($sql);
		
		$event['rowset'] = $rowset;
	}
	
	/**
	 * Load Custom sections
	 * 
	 * @param array 	$event 		Event Data
	 */
	public function media_sections_load($event)
	{
		$sections = [
			[
				'id'			=> 'icons',
				'icon'			=> 'fa-folder',
				'title'			=> $this->language->lang('ICONS'),
				'editable'		=> false,
				'sortable'		=> false,
				'image_paths'	=> ['./icons/', './attach/'],
			],
			[
				'id'			=> 'banners',
				'icon'			=> 'fa-th',
				'title'			=> $this->language->lang('BANNERS'),
				'editable'		=> false,
				'sortable'		=> false,
				'image_paths'	=> ['./banners/'],
				]
			];
		
		$event['sections'] = $sections;
	}
}
