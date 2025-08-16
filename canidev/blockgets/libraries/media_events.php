<?php
/*
* @package cBB Blockgets
* @version v2.0.1 01/02/2020
*
* @copyright (c) 2020 CaniDev
* @license https://opensource.org/licenses/gpl-license.php GNU Public License
*/

namespace canidev\blockgets\libraries;

class media_events
{
	protected $db;
	protected $language;
	protected $user;

	/**
	* Constructor
	*
	* @param \phpbb\db\driver\driver_interface		$db				DB Object
	* @param \phpbb\language\language				$language		Language Object
	* @param \phpbb\user							$user			User object
	*
	* @access public
	*/
	public function __construct(
		\phpbb\db\driver\driver_interface $db,
		\phpbb\language\language $language,
		\phpbb\user $user)
	{
		$this->db		= $db;
		$this->language	= $language;
		$this->user		= $user;
	}

	public function getSubscribedEvents()
	{
		return array(
			'gallery.delete'	=> array($this, 'media_gallery_delete'),
			'gallery.insert'	=> array($this, 'media_gallery_upload'),
			'gallery.load'		=> array($this, 'media_gallery_load'),
			'gallery.upload'	=> array($this, 'media_gallery_upload'),
			'sections.load'		=> array($this, 'media_sections_load'),
		);
	}

	public function media_gallery_load($event)
	{
		$rowset = array();
		$sql_where = 'data_type = ' . BLG_DATA_ATTACHMENT;
		
		if(!empty($event['item_ary']))
		{
			$sql_where .= ' AND ' . $this->db->sql_in_set('data_id', $event['item_ary']);
		}
	
		$sql = 'SELECT *
			FROM ' . BLG_DATA_TABLE . '
			WHERE ' . $sql_where . '
			ORDER BY data_time DESC';
		$result = ($event['item_ary'] === false) ? $this->db->sql_query_limit($sql, 100, $event['start']) : $this->db->sql_query($sql);
		while($row = $this->db->sql_fetchrow($result))
		{
			$params = @unserialize($row['data_settings']);
			
			$rowset[] = array_merge($params, array(
				'id'			=> $row['data_id'],
				'title'			=> $row['data_title'],
				'description'	=> $row['data_content'],
			));
		}
		$this->db->sql_freeresult($result);
		
		$event['rowset'] = $rowset;
	}
	
	public function media_gallery_upload($event)
	{
		$rowset = $event['rowset'];

		$image_data = array(
			'user_id'		=> $this->user->data['user_id'],
			'data_type'		=> BLG_DATA_ATTACHMENT,
			'data_title'	=> $rowset['title'],
			'data_content'	=> '',
			'data_time'		=> time(),
			'data_settings'	=> serialize(array(
				'filename'	=> $rowset['filename'],
				'filesize'	=> $rowset['filesize'],
				'width'		=> $rowset['width'],
				'height'	=> $rowset['height'],
			)),
		);
		
		$sql = 'INSERT INTO ' . BLG_DATA_TABLE . $this->db->sql_build_array('INSERT', $image_data);
		$this->db->sql_query($sql);
		
		$rowset['id'] = (int)$this->db->sql_nextid();

		$event['rowset'] = $rowset;
	}
	
	public function media_gallery_delete($event)
	{
		$rowset = array();
		
		$sql_where = 'data_type = ' . BLG_DATA_ATTACHMENT . '
			AND ' . $this->db->sql_in_set('data_id', $event['params']['items']);

		$sql = 'SELECT data_settings
			FROM ' . BLG_DATA_TABLE . "
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
		$sql = 'DELETE FROM ' . BLG_DATA_TABLE . "
			WHERE $sql_where";
		$this->db->sql_query($sql);
		
		$event['rowset'] = $rowset;
	}
	
	public function media_sections_load($event)
	{
		$sections = array(
			array(
				'id'			=> 'icons',
				'icon'			=> 'fa-folder',
				'title'			=> $this->language->lang('ICONS'),
				'editable'		=> false,
				'sortable'		=> false,
				'image_paths'	=> array('./icons/', './attach/'),
			),
			array(
				'id'			=> 'banners',
				'icon'			=> 'fa-th',
				'title'			=> $this->language->lang('BANNERS'),
				'editable'		=> false,
				'sortable'		=> false,
				'image_paths'	=> array('./banners/'),
			)
		);
		
		$event['sections'] = $sections;
	}
}
