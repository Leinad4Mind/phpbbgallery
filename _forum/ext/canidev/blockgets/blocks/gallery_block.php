<?php
/*
* @package cBB Blockgets
* @version v2.0.3 26/07/2021
*
* @copyright (c) 2021 CaniDev
* @license https://opensource.org/licenses/gpl-license.php GNU Public License
*/

namespace canidev\blockgets\blocks;

class gallery_block extends base
{
	static $icon = 'fa-camera';
	
	const SOURCE_ALL			= 1;
	const SOURCE_ATTACHMENTS	= 2;
	const SOURCE_IMAGES			= 3;

	public function init()
	{
		$this->tpl_name = 'gallery_block';

		if(($data = $this->unserialize()) === false)
		{
			return false;
		}
		
		// Delete the array in the template if exists, prevent errors between blocks
		$this->template->destroy_block_vars('image');
		
		$topic_ids = $post_ids = $images = array();
		
		/* Do some checks
		---------------------------------------- */

		// Forums
		if(!empty($data['gallery_forums']))
		{
			foreach($data['gallery_forums'] as $id => $forum_id)
			{
				if(!$this->auth->acl_get('f_download', $forum_id))
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
				if(!$this->auth->acl_get('f_download', $row['forum_id']))
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
				if(!$this->auth->acl_get('f_download', $row['forum_id']))
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
			$sql_where = array();

			if(!empty($data['gallery_forums']))
			{
				$sql_where[] = $this->db->sql_in_set('t.forum_id', $data['gallery_forums']);
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
				$sql_ary = array(
					'SELECT'	=> 'a.*, t.forum_id',
					'FROM'		=> array(ATTACHMENTS_TABLE => 'a'),
					
					'LEFT_JOIN'	=> array(
						array('FROM' => array(TOPICS_TABLE => 't'),	'ON' => 't.topic_id = a.topic_id')
					),
					
					'WHERE'		=> $this->db->sql_in_set('a.extension', array('jpg', 'gif', 'png')) . '
						AND a.is_orphan = 0
						AND a.filesize > 0
						AND (' . implode(' OR ', $sql_where) . ')',
						
					'ORDER_BY'	=> ($data['image_order'] == 'last') ? 'a.filetime DESC' : 'RAND()',
				);
				
				/*
				* @event block.gallery_attachments_query
				* @var array	sql_ary		The SQL data
				* @var array	data		Block Configuration
				* @since 2.0.0
				*/
				$vars = array('sql_ary', 'data');
				extract($this->dispatcher->trigger_event('block.gallery_attachments_query', compact($vars)));
				
				$sql = $this->db->sql_build_query('SELECT', $sql_ary);
				$result = $this->db->sql_query_limit($sql, $data['max_number']);
				while($row = $this->db->sql_fetchrow($result))
				{
					$image = array(
						'SRC'		=> $this->helper->url('download/file', array('mode' => 'view', 'id' => $row['attach_id'])),
						'ACTION'	=> $this->helper->url('viewtopic', array(
							'f'	=> $row['forum_id'],
							'p'	=> $row['post_msg_id'],
							'#'	=> 'p' . $row['post_msg_id']
						))
					);

					/*
					* @event block.gallery_row
					* @var array		$image		The row array
					* @var array		$data		Block Configuration
					* @var array 		$row		Row data
					* @since 2.0.3
					*/
					$vars = array('image', 'data', 'row');
					extract($this->dispatcher->trigger_event('block.gallery_row', compact($vars)));

					$images[] = $image;
				}
				$this->db->sql_freeresult($result);
			}
		}
		
		/* Load the images from posts
		---------------------------------------- */
		if($data['gallery_source'] != self::SOURCE_ATTACHMENTS)
		{
			$sql_where = array();

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
				$sql_ary = array(
					'SELECT'		=> 'p.post_id, p.forum_id, p.topic_id, p.post_text',
					'FROM'			=> array(POSTS_TABLE => 'p'),
					'WHERE'			=> '(' . implode(' OR ', $sql_where) . ")
						AND p.bbcode_uid <> ''
						AND p.post_text " . $this->db->sql_like_expression($this->db->get_any_char() . '[album]' . $this->db->get_any_char()),
					'ORDER_BY'		=> ($data['image_order'] == 'last') ? 'p.post_time DESC' : 'RAND()',
				);

				/*
				* @event block.gallery_posts_query
				* @var array	sql_ary		The SQL data
				* @var array	data		Block Configuration
				* @since 2.0.3
				*/
				$vars = array('sql_ary', 'data');
				extract($this->dispatcher->trigger_event('block.gallery_posts_query', compact($vars)));

				$sql 	= $this->db->sql_build_query('SELECT', $sql_ary);
				$result = $this->db->sql_query_limit($sql, $data['max_number']);
				while($row = $this->db->sql_fetchrow($result))
				{
					$row_images = array();

					preg_match_all('#<ALBUM content="(.*?)">#i', $row['post_text'], $matches, PREG_SET_ORDER);

					foreach($matches as $match)
					{
						$row_images[] = array(
							'ACTION'	=> '/forum/viewtopic.php?f='.$row['forum_id'].'&t='. $row['topic_id'],
							'SRC'		=> '/forum/gallery/image/'.$match[1].'/source',
							'TITLE'		=>  $row['post_subject'],
						);
					}

					/*
					* @event block.gallery_posts_row
					* @var array		$row_images		The rows array
					* @var array		$data			Block Configuration
					* @var array 		$row			Row data
					* @since 2.0.3
					*/
					$vars = array('row_images', 'data', 'row');
					extract($this->dispatcher->trigger_event('block.gallery_posts_row', compact($vars)));

					$images = array_merge($images, $row_images);
				}
				$this->db->sql_freeresult($result);
			}
		}
		
		$images = array_slice($images, 0, (int)$data['max_number']);
		
		/* Load the custom images
		---------------------------------------- */
		if(sizeof($data['item_ids']))
		{
			$items = $gallery_items = array();
			
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
					FROM ' . BLG_DATA_TABLE . '
					WHERE data_type = ' . BLG_DATA_ATTACHMENT . '
					AND ' . $this->db->sql_in_set('data_id', $gallery_items);
				$result = $this->db->sql_query($sql);
				
				$gallery_items = array();

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
					
					$image = array(
						'ACTION'	=> $this->helper->build_image_filename($settings['filename']),
						'SRC'		=> $this->helper->build_image_filename($settings['filename']),
						'TITLE'		=> $source['data_title'],
					);
				}
				else if(preg_match('#^([^&\'"<>]+)\.(?:gif|png|jpg|jpeg)$#i', $source, $match))
				{
					$image = array(
						'ACTION'	=> $this->helper->build_image_filename($source),
						'SRC'		=> $this->helper->build_image_filename($source),
						'TITLE'		=> '',
					);
				}
				else
				{
					continue;
				}

				/*
				* @event block.gallery_row
				* @var array		$image		The row array
				* @var array		$data		Block Configuration
				* @var mixed		$source		Row data
				* @since 2.0.3
				*/
				$vars = array('image', 'data', 'source');
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

		$this->template->assign_json_var('S_GALLERY_OPTIONS', array(
			'height'		=> $data['gallery_height'],
			'margin'		=> $data['image_margin'],
			'fps'			=> $data['gallery_fps'],
			'direction'		=> $data['gallery_dir'],
			'zoom'			=> $data['image_zoom']
		));

		unset($data, $images);
		return true;
	}

	public function configure($mode, $block_row, &$new, &$submit)
	{
		if($mode == 'validate' && $submit)
		{
			$new['gallery_forums']	= $this->request->variable('forums', array(0));
			$new['item_ids']		= $this->request->variable('item_ids', array(0 => ''));
		}
	}

	public function get_config()
	{
		$gallery_order = array(
			'last'		=> 'GALLERY_ORDER_LAST',
			'rand'		=> 'GALLERY_ORDER_RAND',
		);

		$gallery_sources = array(
			self::SOURCE_ALL			=> 'GALLERY_SOURCE_ALL',
			self::SOURCE_ATTACHMENTS	=> 'GALLERY_SOURCE_ATTACHMENTS',
			self::SOURCE_IMAGES			=> 'GALLERY_SOURCE_IMAGES',
		);

		$this->display_vars = array(
			'gallery_height'	=> array('lang' => 'GALLERY_HEIGHT',		'validate' => 'int',		'type' => 'number:1:999',	'default' => 100),
			'gallery_fps'		=> array('lang' => 'GALLERY_FPS',			'validate' => 'int:1:10',	'type' => 'number:1:10',	'default' => 4),
			'gallery_dir'		=> array('lang' => 'GALLERY_DIRECTION',		'validate' => 'string',		'type' => 'select', 		'method' => 'helper',	'params' => array('scroll_select', '{CONFIG_VALUE}', 'direction_x'),  'default' => 'left'),
			'image_margin'		=> array('lang' => 'GALLERY_MARGIN',		'validate' => 'int',		'type' => 'number:0:999',	'default' => 4),
			'image_zoom'		=> array('lang' => 'GALLERY_ZOOM',			'validate' => 'int:1:10',	'type' => 'number:1:10',	'default' => 2),
			'max_number'		=> array('lang' => 'GALLERY_MAX_NUMBER',	'validate' => 'int:1:500',	'type' => 'number:1:500',	'default' => 50),
			'gallery_source'	=> array('lang' => 'GALLERY_SOURCE',		'validate' => 'string',		'type' => 'custom', 	'method' => 'helper',	'params' => array('make_select', $gallery_sources, '{KEY}', '{CONFIG_VALUE}'),  'default' => self::SOURCE_ATTACHMENTS),
			'gallery_forums'	=> array('lang' => 'GALLERY_FORUMS',		'type' => 'custom',			'method' => 'helper',	'params' => array('forums_select', 'forums', '{CONFIG_VALUE}', 1),	'default' => array()),
			'gallery_topics'	=> array('lang' => 'GALLERY_TOPICS',		'validate' => 'string',		'type' => 'text:40:255'),
			'gallery_posts'		=> array('lang' => 'GALLERY_POSTS',			'validate' => 'string',		'type' => 'text:40:255'),
			'image_order'		=> array('lang' => 'GALLERY_ORDER',			'validate' => 'string', 	'type' => 'custom', 	'method' => 'helper',	'params' => array('make_select', $gallery_order, '{KEY}', '{CONFIG_VALUE}'),  'default' => 'rand'),
			'item_ids'			=> array('lang' => 'GALLERY_CUSTOM',		'type' => 'custom', 		'function' => array($this, 'acp_build_image_browser'), 'params' => array('{KEY}', '{CONFIG_VALUE}')),
		);

		return true;
	}
	
	public function acp_build_image_browser($key, $ary)
	{
		$ary = (empty($ary) || !is_array($ary)) ? array() : $ary;
		$hidden_fields = '';
		
		foreach($ary as $id)
		{
			$hidden_fields .= '<input type="hidden" name="item_ids[]" value="' . $id . '" />';
		}
		
		$this->template->assign_vars(array(
			'ACP_MANAGE_GALLERY'		=> true,
			'S_BUTTON_ID'				=> gen_rand_string(4),
			'S_GALLERY_HIDDEN_FIELDS'	=> $hidden_fields,
		));
		
		$this->template->set_filenames(array(
			'gallery_body'	=> '@canidev_blockgets/blocks/gallery_block.html'
		));
		
		return $this->template->assign_display('gallery_body');
	}
}
