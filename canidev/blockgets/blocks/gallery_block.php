<?php
/**
 * @package cBB Blockgets
 * @version 2.0.7 01/07/2024
 *
 * @copyright (c) 2024 CaniDev
 * @license https://creativecommons.org/licenses/by-nc/4.0/
 */

namespace canidev\blockgets\blocks;

use canidev\blockgets\libraries\constants;

class gallery_block extends base
{
	static $icon = 'fa-camera';
	
	const SOURCE_ALL			= 1;
	const SOURCE_ATTACHMENTS	= 2;
	const SOURCE_IMAGES			= 3;

	/**
	 * {@inheritDoc}
	 */
	public function init()
	{
		$this->tpl_name = 'gallery_block';

		if(($data = $this->unserialize()) === false)
		{
			return false;
		}

		switch($this->db->get_sql_layer())
		{
			case 'postgres':
			case 'sqlite3':
				$random_key = 'RANDOM()';
			break;

			default:
				$random_key = 'RAND()';
			break;
		}
		
		// Delete the array in the template if exists, prevent errors between blocks
		$this->template->destroy_block_vars('image');
		
		$topic_ids = $post_ids = $images = [];
		
		/* Do some checks
		---------------------------------------- */

		// Forums
		if(!empty($data['gallery_forums']))
		{
			foreach($data['gallery_forums'] as $id => $forum_id)
			{
				if(!$this->auth->acl_get('f_read', $forum_id) ||
					!$this->auth->acl_get('f_download', $forum_id))
				{
					unset($data['gallery_forums'][$id]);
				}
			}
		}
		
		// Topics
		foreach(explode(',', $data['gallery_topics']) as $topic_id)
		{
			$topic_id = (int)trim($topic_id);
			
			if($topic_id)
			{
				$topic_ids[$topic_id] = $topic_id;
			}
		}
		
		if(sizeof($topic_ids))
		{
			$sql = 'SELECT topic_id, forum_id
				FROM ' . TOPICS_TABLE . '
				WHERE ' . $this->db->sql_in_set('topic_id', $topic_ids);
			$result = $this->db->sql_query($sql);
			while($row = $this->db->sql_fetchrow($result))
			{
				if(!$this->auth->acl_get('f_read',  $row['forum_id']) ||
					!$this->auth->acl_get('f_download',  $row['forum_id']))
				{
					unset($topic_ids[$row['topic_id']]);
				}
			}
			$this->db->sql_freeresult($result);
		}
		
		// Posts
		foreach(explode(',', $data['gallery_posts']) as $post_id)
		{
			$post_id = (int)trim($post_id);
			
			if($post_id)
			{
				$post_ids[$post_id] = $post_id;
			}
		}
		
		if(sizeof($post_ids))
		{
			$sql = 'SELECT post_id, forum_id
				FROM ' . POSTS_TABLE . '
				WHERE ' . $this->db->sql_in_set('post_id', $post_ids);
			$result = $this->db->sql_query($sql);
			while($row = $this->db->sql_fetchrow($result))
			{
				if(!$this->auth->acl_get('f_read',  $row['forum_id']) ||
					!$this->auth->acl_get('f_download',  $row['forum_id']))
				{
					unset($post_ids[$row['post_id']]);
				}
			}
			$this->db->sql_freeresult($result);
		}
		
		/* Load the attachments
		---------------------------------------- */
		if($data['gallery_source'] != self::SOURCE_IMAGES)
		{
			$sql_where = [];

			if(!empty($data['gallery_forums']))
			{
				$sql_where[] = $this->db->sql_in_set('p.forum_id', $data['gallery_forums']);
			}

			if(!empty($topic_ids))
			{
				$sql_where[] = $this->db->sql_in_set('a.topic_id', $topic_ids);
			}
			
			if(!empty($post_ids))
			{
				$sql_where[] = $this->db->sql_in_set('a.post_msg_id', $post_ids);
			}

			if(sizeof($sql_where))
			{
				$rowset = [];

				$sql_ary = [
					'SELECT'	=> 'a.*, p.forum_id, p.post_subject',
					'FROM'		=> [ATTACHMENTS_TABLE => 'a'],
					
					'LEFT_JOIN'	=> [
						['FROM' => [POSTS_TABLE => 'p'],	'ON' => 'p.post_id = a.post_msg_id']
					],
					
					'WHERE'		=> $this->db->sql_in_set('a.extension', ['jpg', 'gif', 'png', 'webp']) . '
						AND a.is_orphan = 0
						AND a.filesize > 0
						AND p.post_visibility = ' . ITEM_APPROVED . '
						AND (' . implode(' OR ', $sql_where) . ')',
						
					'ORDER_BY'	=> ($data['image_order'] == 'last') ? 'a.filetime DESC' : $random_key,
				];
				
				/**
				 * @event block.gallery_attachments_query
				 * @var array	sql_ary		The SQL data
				 * @var array	data		Block Configuration
				 * @since 2.0.0
				 */
				$vars = ['sql_ary', 'data'];
				extract($this->dispatcher->trigger_event('block.gallery_attachments_query', compact($vars)));
				
				$sql = $this->db->sql_build_query('SELECT', $sql_ary);
				$result = $this->db->sql_query_limit($sql, $data['max_number']);
				while($row = $this->db->sql_fetchrow($result))
				{
					$row['gallery_image'] = [
						'SRC'		=> $this->helper->url('download/file', ['mode' => 'view', 'id' => $row['attach_id']]),
						'ACTION'	=> $this->helper->url('viewtopic', [
							'f'	=> $row['forum_id'],
							'p'	=> $row['post_msg_id'],
							'#'	=> 'p' . $row['post_msg_id']
						]),
						'TITLE'		=> $row['post_subject'],
					];

					$rowset[] = $row;
				}
				$this->db->sql_freeresult($result);

				/**
				 * @event block.gallery_attachments_rowset
				 * @var array		$rowset		Raw post rows
				 * @var array		data		Block Configuration
				 * @since 2.0.7
				 */
				$vars = ['rowset', 'data'];
				extract($this->dispatcher->trigger_event('block.gallery_attachments_rowset', compact($vars)));

				foreach($rowset as $row)
				{
					$images[] = $row['gallery_image'];
				}
			}
		}
		
		/* Load the images from posts
		---------------------------------------- */
		if($data['gallery_source'] != self::SOURCE_ATTACHMENTS)
		{
			$sql_where = [];

			if(!empty($data['gallery_forums']))
			{
				$sql_where[] = $this->db->sql_in_set('p.forum_id', $data['gallery_forums']);
			}

			if(!empty($topic_ids))
			{
				$sql_where[] = $this->db->sql_in_set('p.topic_id', $topic_ids);
			}
			
			if(!empty($post_ids))
			{
				$sql_where[] = $this->db->sql_in_set('p.post_id', $post_ids);
			}

			if(sizeof($sql_where))
			{
				$rowset = [];

				$sql_ary = [
					'SELECT'		=> 'p.post_id, p.forum_id, p.topic_id, p.post_subject, p.post_text',
					'FROM'			=> [POSTS_TABLE => 'p'],
					'WHERE'			=> 'p.post_visibility = ' . ITEM_APPROVED . '
						AND (' . implode(' OR ', $sql_where) . ")
						AND p.bbcode_uid NOT LIKE ''
						AND p.post_text " . $this->db->sql_like_expression($this->db->get_any_char() . '[img]' . $this->db->get_any_char()),
					'ORDER_BY'		=> ($data['image_order'] == 'last') ? 'p.post_time DESC' : $random_key,
				];

				/**
				 * @event block.gallery_posts_query
				 * @var array	sql_ary		The SQL data
				 * @var array	data		Block Configuration
				 * @since 2.0.3
				 */
				$vars = ['sql_ary', 'data'];
				extract($this->dispatcher->trigger_event('block.gallery_posts_query', compact($vars)));

				$sql 	= $this->db->sql_build_query('SELECT', $sql_ary);
				$result = $this->db->sql_query_limit($sql, $data['max_number']);
				while($row = $this->db->sql_fetchrow($result))
				{
					$row_images = [];

					preg_match_all('#<IMG src="(.*?)">#i', $row['post_text'], $matches, PREG_SET_ORDER);

					foreach($matches as $match)
					{
						$row_images[] = [
							'ACTION'	=> $this->helper->url('viewtopic', [
								'f'	=> $row['forum_id'],
								'p'	=> $row['post_id'],
								'#'	=> 'p' . $row['post_id']
							]),
							'SRC'		=> $match[1],
							'TITLE'		=> $row['post_subject'],
						];
					}

					$row['gallery_images'] = $row_images;

					$rowset[] = $row;
				}
				$this->db->sql_freeresult($result);

				/**
				 * @event block.gallery_posts_rowset
				 * @var array		$rowset		Raw post rows
				 * @var array		data		Block Configuration
				 * @since 2.0.7
				 */
				$vars = ['rowset', 'data'];
				extract($this->dispatcher->trigger_event('block.gallery_posts_rowset', compact($vars)));

				foreach($rowset as $row)
				{
					$images = array_merge($images, $row['gallery_images']);
				}
			}
		}
		
		$images = array_slice($images, 0, (int)$data['max_number']);
		
		/* Load the custom images
		---------------------------------------- */
		if(sizeof($data['item_ids']))
		{
			$items = $gallery_items = [];
			
			foreach($data['item_ids'] as $source)
			{
				if(is_numeric($source))
				{
					$source = (int)$source;
					$gallery_items[$source] = $source;
				}

				$items[] = $source;
			}
			
			if(sizeof($gallery_items))
			{
				$sql = 'SELECT data_id, data_title, data_settings
					FROM ' . $this->tables['data'] . '
					WHERE data_type = ' . constants::DATA_ATTACHMENT . '
					AND ' . $this->db->sql_in_set('data_id', $gallery_items);
				$result = $this->db->sql_query($sql);
				
				$gallery_items = [];

				while($row = $this->db->sql_fetchrow($result))
				{
					$gallery_items[$row['data_id']] = $row;
				}
				$this->db->sql_freeresult($result);
			}
			
			foreach($items as $i => $source)
			{
				if(is_int($source) && isset($gallery_items[$source]))
				{
					$source		= $gallery_items[$source];
					$settings	= unserialize($source['data_settings']);
					
					$image = [
						'ACTION'	=> $this->helper->build_image_filename($settings['filename']),
						'SRC'		=> $this->helper->build_image_filename($settings['filename']),
						'TITLE'		=> $source['data_title'],
					];
				}
				else if(preg_match('#^([^&\'"<>]+)\.(?:gif|png|jpg|jpeg|webp)$#i', $source, $match))
				{
					$image = [
						'ACTION'	=> $this->helper->build_image_filename($source),
						'SRC'		=> $this->helper->build_image_filename($source),
						'TITLE'		=> '',
					];
				}
				else
				{
					continue;
				}

				/**
				 * @event block.gallery_row
				 * @var array		$image		The row array
				 * @var array		$data		Block Configuration
				 * @var mixed		$source		Row data
				 * @since 2.0.3
				 */
				$vars = ['image', 'data', 'source'];
				extract($this->dispatcher->trigger_event('block.gallery_row', compact($vars)));

				$images[] = $image;
			}
		}

		if(empty($images))
		{
			return false;	
		}

		foreach($images as $row)
		{
			$this->template->assign_block_vars('image', $row);
		}

		$this->template->assign_json_var('S_GALLERY_OPTIONS', [
			'height'		=> $data['gallery_height'],
			'margin'		=> $data['image_margin'],
			'fps'			=> $data['gallery_fps'],
			'direction'		=> $data['gallery_dir'],
			'zoom'			=> $data['image_zoom']
		]);

		unset($data, $images);
		return true;
	}

	/**
	 * {@inheritDoc}
	 */
	public function configure($mode, $block_row, &$new, &$submit)
	{
		if($mode == 'validate' && $submit)
		{
			$new['gallery_forums']	= $this->request->variable('forums', [0]);
			$new['item_ids']		= $this->request->variable('item_ids', [0 => '']);
		}
	}

	/**
	 * {@inheritDoc}
	 */
	public function get_config()
	{
		$gallery_order = [
			'last'		=> 'GALLERY_ORDER_LAST',
			'rand'		=> 'GALLERY_ORDER_RAND',
		];

		$gallery_sources = [
			self::SOURCE_ALL			=> 'GALLERY_SOURCE_ALL',
			self::SOURCE_ATTACHMENTS	=> 'GALLERY_SOURCE_ATTACHMENTS',
			self::SOURCE_IMAGES			=> 'GALLERY_SOURCE_IMAGES',
		];

		$this->display_vars = [
			'gallery_height'	=> ['lang' => 'GALLERY_HEIGHT',			'validate' => 'int',		'type' => 'number:1:999',	'default' => 100],
			'gallery_fps'		=> ['lang' => 'GALLERY_FPS',			'validate' => 'int:1:10',	'type' => 'number:1:10',	'default' => 4],
			'gallery_dir'		=> ['lang' => 'GALLERY_DIRECTION',		'validate' => 'string',		'type' => 'select', 		'function' => ['helper_acp', 'scroll_select'],	'params' => ['{CONFIG_VALUE}', 'direction_x'],  'default' => 'left'],
			'image_margin'		=> ['lang' => 'GALLERY_MARGIN',			'validate' => 'int',		'type' => 'number:0:999',	'default' => 4],
			'image_zoom'		=> ['lang' => 'GALLERY_ZOOM',			'validate' => 'int:1:10',	'type' => 'number:1:10',	'default' => 2],
			'max_number'		=> ['lang' => 'GALLERY_MAX_NUMBER',		'validate' => 'int:1:500',	'type' => 'number:1:500',	'default' => 50],
			'gallery_source'	=> ['lang' => 'GALLERY_SOURCE',			'validate' => 'string',		'type' => 'custom', 		'function' => ['tools', 'make_select'],	'params' => [$gallery_sources, '{KEY}', '{CONFIG_VALUE}'],  'default' => self::SOURCE_ATTACHMENTS],
			'gallery_forums'	=> ['lang' => 'GALLERY_FORUMS',			'type' => 'custom',			'function' => ['tools', 'forums_select'],		'params' => ['forums', '{CONFIG_VALUE}', 1],	'default' => []],
			'gallery_topics'	=> ['lang' => 'GALLERY_TOPICS',			'validate' => 'string',		'type' => 'text:40:255'],
			'gallery_posts'		=> ['lang' => 'GALLERY_POSTS',			'validate' => 'string',		'type' => 'text:40:255'],
			'image_order'		=> ['lang' => 'GALLERY_ORDER',			'validate' => 'string', 	'type' => 'custom', 		'function' => ['tools', 'make_select'],	'params' => [$gallery_order, '{KEY}', '{CONFIG_VALUE}'],  'default' => 'rand'],
			'item_ids'			=> ['lang' => 'GALLERY_CUSTOM',			'type' => 'custom', 		'function' => [$this, 'acp_build_image_browser'], 	'params' => ['{KEY}', '{CONFIG_VALUE}']],
		];

		return true;
	}
	
	/**
	 * Build image browser
	 * 
	 * @param string 	$key
	 * @param array 	$ary
	 * 
	 * @return string
	 */
	public function acp_build_image_browser($key, $ary)
	{
		$ary = (empty($ary) || !is_array($ary)) ? [] : $ary;
		$hidden_fields = '';
		
		foreach($ary as $id)
		{
			$hidden_fields .= '<input type="hidden" name="item_ids[]" value="' . $id . '" />';
		}
		
		$this->template->assign_vars([
			'ACP_MANAGE_GALLERY'		=> true,
			'S_BUTTON_ID'				=> gen_rand_string(4),
			'S_GALLERY_HIDDEN_FIELDS'	=> $hidden_fields,
		]);
		
		$this->template->set_filenames([
			'gallery_body'	=> '@canidev_blockgets/blocks/gallery_block.html'
		]);
		
		return $this->template->assign_display('gallery_body');
	}
}
