<?php
/*
* @name media.php
* @package cBB Blockgets
* @version v2.0.0 30/05/2017
*
* @copyright (c) 2017 CaniDev
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/

namespace canidev\blockgets\libraries;

// @ignore
if(!defined('IN_PHPBB'))
{
	exit;
}

use Symfony\Component\DependencyInjection\ContainerInterface;

class media
{
	private $params = array(
		'action'	=> '',
		'custom'	=> false,
		'sources'	=> array(),
		'type'		=> 'image', // image, icon, attachment
	);
	
	private $max_filesize = 0;

	protected $config;
	protected $container;
	protected $db;
	protected $helper;
	protected $json;
	protected $lang;
	protected $php_ini;
	protected $request;
	protected $template;
	protected $user;
	
	protected $phpbb_root_path;
	protected $php_ext;
	
	/**
	* Constructor
	*
	* @param \phpbb\config\config 						$config				Config Object
	* @param ContainerInterface 						$container			Service container interface
	* @param \phpbb\db\driver\driver_interface			$db					DB Object
	* @param \canidev\blockgets\libraries\helper		$helper				Blockgets helper Object
	* @param \canidev\blockgets\libraries\json_response	$json_response		Blockgets Json Object
	* @param \canidev\blockgets\libraries\language		$language			Blockgets language Object
	* @param \phpbb\request\request 					$request			Request object
	* @param \phpbb\template\template					$template     		Template object
	* @param \phpbb\user								$user				User object
	* @param string										$root_path			phpBB root path
	* @param string										$php_ext			phpEx
	*
	* @access public
	*/
	public function __construct(\phpbb\config\config $config, ContainerInterface $container, \phpbb\db\driver\driver_interface $db, \canidev\blockgets\libraries\helper $helper, \canidev\blockgets\libraries\json_response $json_response, \canidev\blockgets\libraries\language $language, \phpbb\request\request $request, \phpbb\template\template $template, \phpbb\user $user, $root_path, $php_ext)
	{
		$this->config		= $config;
		$this->container	= $container;
		$this->db			= $db;
		$this->helper		= $helper;
		$this->json			= $json_response;
		$this->lang			= $language;
		$this->php_ini		= new \phpbb\php\ini;
		$this->request		= $request;
		$this->template		= $template;
		$this->user			= $user;

		$this->phpbb_root_path	= $root_path;
		$this->php_ext			= $php_ext;
	}

	public function init()
	{
		$upload_path	= 'files/blockgets/';
		$error 			= array();
		$post 			= $this->request->get_super_global(\phpbb\request\request_interface::POST);
		
		if(isset($post['media']))
		{
			$this->params = array_merge($this->params, $post['media']);
			$this->params['custom'] = (int)$this->params['custom'];
		}

		$this->json->add(array(
			'status'	=> BLG_JSON_SUCCESS,
			'action'	=> $this->params['action'],
		));
		
		$this->max_filesize = $this->config['max_filesize'];
		
		if(function_exists('ini_get'))
		{
			$this->max_filesize = min(
				$this->php_ini->get_bytes('post_max_size'),
				max(1, $this->php_ini->get_bytes('memory_limit')),
				$this->php_ini->get_bytes('upload_max_filesize'),
				$this->max_filesize
			);
		}
		
		switch($this->params['action'])
		{
			case 'create':
				switch($this->params['type'])
				{
					case 'icon':
						$submit_label = 'SET_ICON';
					break;
					
					case 'image':
						$submit_label = ($this->params['custom']) ? 'SAVE' : 'SET_IMAGE';
					break;
					
					default:
						$submit_label = 'INSERT_ON_ENTRY';
					break;
				}

				$this->template->assign_vars(array(
					'S_MAX_FILESIZE'	=> $this->lang->get('MAX_FILESIZE', get_formatted_filesize($this->max_filesize)),
					'S_SUBMIT_LABEL'	=> $this->lang->get($submit_label),
				));
			
				$this
					->load_sections()
					->display();
			break;
			
			case 'delete':
				if($this->helper->confirm_box(true))
				{
					if(!empty($this->params['items']))
					{
						$this->params['items'] = array_map('intval', $this->params['items']);
						
						// Get the filenames and try to delete from the server
						$sql = 'SELECT data_id, data_settings
							FROM ' . BLG_DATA_TABLE . '
							WHERE ' . $this->db->sql_in_set('data_id', $this->params['items']);
						$result = $this->db->sql_query($sql);
						while($row = $this->db->sql_fetchrow($result))
						{
							$settings = unserialize($row['data_settings']);
							
							if(isset($settings['filename']) && preg_match('#^([0-9]+)_(.*)#', $settings['filename'], $match))
							{
								@unlink($this->helper->build_image_filename($settings['filename']));
							}
						}
						$this->db->sql_freeresult($result);
						
						// Delete items in the db
						$sql = 'DELETE FROM ' . BLG_DATA_TABLE . '
							WHERE data_type = ' . BLG_DATA_ATTACHMENT . '
							AND ' . $this->db->sql_in_set('data_id', $this->params['items']);
						$this->db->sql_query($sql);
					}
					
					$this->json->send(array(
						'message'	=> $this->lang->get('FILES_DELETED'),
						'items'		=> $this->params['items'],
					));
				}
				else
				{
					$this->helper->confirm_box(false, $this->lang->get('FILES_REMOVE_CONFIRM'));
					return false;
				}
			break;
			
			case 'insert':
				$headers = @get_headers($this->params['url'], 1);
					
				if(!isset($headers['Content-Type']) || !preg_match('#image/(.*)#', $headers['Content-Type'], $match))
				{
					$error[] = $this->lang->get('FORMAT_INVALID');
					break;
				}
				
				$sql_data = array(
					'user_id'		=> $this->user->data['user_id'],
					'data_type'		=> BLG_DATA_ATTACHMENT,
					'data_title'	=> $this->params['title'],
					'data_content'	=> $this->params['description'],
					'data_time'		=> time(),
				);
				
				$settings = array(
					'filename'	=> $this->params['url'],
					'filesize'	=> isset($headers['Content-Length']) ? (int)$headers['Content-Length'] : '',
					'width'		=> (int)$this->params['width'],
					'height'	=> (int)$this->params['height'],
				);
				
				if($this->params['copy'])
				{
					$extension 			= $match[1];
					$new_filename		= $this->user->data['user_id'] . '_' . md5(unique_id()) . '.' . $extension;
					$new_filename_full	= $this->phpbb_root_path . $upload_path . $new_filename;
					
					if($this->php_ini->get_bool('allow_url_fopen'))
					{
						$image_data = @file_get_contents($this->params['url']);
						
						if(!@file_put_contents($new_filename_full, $image_data))
						{
							$error[] = $this->lang->get('IMAGE_SAVE_ERROR');
							break;
						}
					}
					else
					{
						if(($ch = @curl_init($this->params['url'])) === false)
						{
							$error[] = $this->lang->get('IMAGE_SAVE_ERROR');
							break;
						}
						
						$fp = fopen($new_filename_full, 'wb');
						curl_setopt($ch, CURLOPT_FILE, $fp);
						curl_setopt($ch, CURLOPT_HEADER, 0);
						curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
						curl_exec($ch);
						curl_close($ch);
						fclose($fp);
					}
					
					$settings['filename'] = $new_filename;
				}
				
				$sql_data['data_settings'] = serialize($settings);
				
				$sql = 'INSERT INTO ' . BLG_DATA_TABLE . ' ' . $this->db->sql_build_array('INSERT', $sql_data);
				$this->db->sql_query($sql);
				
				$sql_data['data_id'] = $this->db->sql_nextid();

				$this->json->send(array(
					'item'	=> $this->get_output('attachment', $sql_data)
				));
			break;
			
			case 'update':
				$sql_ary = array(
					'data_title'	=> $this->params['title'],
					'data_content'	=> $this->params['description'],
				);
				
				$sql = 'UPDATE ' . BLG_DATA_TABLE . '
					SET ' . $this->db->sql_build_array('UPDATE', $sql_ary) . '
					WHERE data_id = ' . (int)$this->params['originalId'] . '
					AND data_type = ' . BLG_DATA_ATTACHMENT;
				$this->db->sql_query($sql);
				
				$this->json->send(array(
					'message'	=> $this->lang->get('MEDIA_UPDATED'),
				));
			break;
			
			case 'upload':
				$this->lang->add('posting');

				if($this->container->has('files.upload'))
				{
					// phpBB 3.2 behavior
					$upload = $this->container->get('files.upload');
				}
				else
				{
					// phpBB 3.1 behavior
					if(!class_exists('fileupload', false))
					{
						include($this->phpbb_root_path . 'includes/functions_upload.' . $this->php_ext);
					}

					$upload = new \fileupload();
				}

				if(!$upload->is_valid('file'))
				{
					$error[] = $this->lang->get('FORM_INVALID');
				}
				
				if(!sizeof($error))
				{
					$allowed_extensions = array('jpg', 'png', 'gif', 'mp4', 'mov');
					$upload->set_allowed_extensions($allowed_extensions);
					$upload->set_max_filesize($this->max_filesize);

					if(method_exists($upload, 'form_upload'))
					{
						$file = $upload->form_upload('file');
					}
					else
					{
						$file = $upload->handle_upload('files.types.form', 'file');
					}

					$file->clean_filename('unique_ext', $this->user->data['user_id'] . '_');
					$file->move_file($upload_path, false, true);

					if(sizeof($file->error))
					{
						$file->remove();
						$error = array_merge($error, $file->error);
					}
					else if($free_space = @disk_free_space($this->phpbb_root_path . $upload_path))
					{
						// Check free disk space
						if($free_space <= $file->get('filesize'))
						{
							$error[] = $this->lang->get('ATTACH_QUOTA_REACHED');
							$file->remove();
						}
					}
					
					if(!sizeof($error))
					{
						@chmod($this->phpbb_root_path . $upload_path . $file->get('realname'), 0644);
						
						$filename = $this->helper->build_image_filename($file->get('realname'));
						
						list($width, $height) = @getimagesize($filename);
						
						$image_data = array(
							'user_id'		=> $this->user->data['user_id'],
							'data_type'		=> BLG_DATA_ATTACHMENT,
							'data_title'	=> str_replace('.' . $file->get('extension'), '', $file->get('uploadname')),
							'data_content'	=> '',
							'data_time'		=> time(),
							'data_settings'	=> serialize(array(
								'filename'	=> $file->get('realname'),
								'filesize'	=> $file->get('filesize'),
								'width'		=> $width,
								'height'	=> $height,
							)),
						);
						
						$sql = 'INSERT INTO ' . BLG_DATA_TABLE . $this->db->sql_build_array('INSERT', $image_data);
						$this->db->sql_query($sql);
						
						$image_data['data_id'] = (int)$this->db->sql_nextid();
						
						$this->json->send(array(
							'item'	=> $this->get_output('attachment', $image_data)
						));
					}
				}
			break;
		}
		
		if(sizeof($error))
		{
			$this->json->send(array(
				'status'	=> BLG_JSON_ERROR,
				'message'	=> implode('<br />', $error)
			));
		}
	}
	
	private function load_sections()
	{
		switch($this->params['type'])
		{
			case 'image':
			case 'attachment':
				$sections = array(
					array(
						'id'		=> 'icons',
						'icon'		=> 'blg-icon-folder',
						'title'		=> $this->lang->get('ICONS'),
						'editable'	=> false,
						'sortable'	=> false,
						'items'		=> array_merge(
							$this->get_images('./icons/'),
							$this->get_images('./attach/')
						)
					),
					array(
						'id'		=> 'banners',
						'icon'		=> 'blg-icon-th',
						'title'		=> $this->lang->get('BANNERS'),
						'editable'	=> false,
						'sortable'	=> false,
						'items'		=> $this->get_images('./banners/')
					),
					array(
						'id'		=> 'gallery',
						'icon'		=> 'blg-icon-camera',
						'title'		=> $this->lang->get('GALLERY'),
						'editable'	=> true,
						'sortable'	=> false,
						'items'		=> $this->get_gallery()
					)
				);
				
				if($this->params['type'] == 'image' && $this->params['custom'])
				{
					$sections[] = 'separator';
					$sections[] = array(
						'id'		=> 'list',
						'icon'		=> 'blg-icon-file-o',
						'title'		=> $this->lang->get('CURRENT_LIST'),
						'editable'	=> true,
						'sortable'	=> true,
						'items'		=> $this->get_custom_list()
					);
				}
				
				$sections = array_merge($sections, array(
					'separator',
					array(
						'id'		=> 'upload',
						'icon'		=> 'blg-icon-upload',
						'title'		=> $this->lang->get('UPLOAD_IMAGE'),
						'editable'	=> true,
						'sortable'	=> false,
					),
					array(
						'id'		=> 'insert',
						'icon'		=> 'blg-icon-cloud-download',
						'title'		=> $this->lang->get('INSERT_URL'),
						'editable'	=> false,
						'sortable'	=> false,
					)
				));
			break;
			
			case 'icon':
				$sections	= array();
				$input_file = $this->helper->get_ext_path() . 'styles/all/theme/31x.css';
				
				$raw_lines = @file($input_file, FILE_SKIP_EMPTY_LINES | FILE_IGNORE_NEW_LINES);
				
				$icon_ary = array(
					'other'	=> array(
						'icon'	=> 'blg-icon-asterisk',
						'items'	=> array(),
					)
				);
				
				if(($id = array_search('/*** Definitions ***/', $raw_lines)) !== false)
				{
					$current_category = 'other';

					for($i = $id; $i < sizeof($raw_lines); $i++)
					{
						if(preg_match('#/\* cat:([\w\d\-\_]+)(?: \| icon:([\w\d\-]+))? \*/#', $raw_lines[$i], $match))
						{
							$current_category = $match[1];
							$current_category = $this->lang->get($current_category);
							
							$icon_ary[$current_category] = array(
								'icon'	=> (!empty($match[2]) ? $match[2] : 'blg-icon-asterisk'),
								'items'	=> array()
							);
						}
						else if(preg_match('#\.(blg-icon-[a-z0-9\-]+):before#', $raw_lines[$i], $match))
						{
							$icon_ary[$current_category]['items'][] = array(
								'code'	=> $match[1],
							);
						}
					}
				}
				
				foreach($icon_ary as $title => $options)
				{
					if(sizeof($options['items']))
					{
						$sections[] = array(
							'id'		=> $title,
							'icon'		=> $options['icon'],
							'title'		=> $title,
							'editable'	=> false,
							'items'		=> $options['items'],
						);
					}
				}
			break;
			
			default:
				return $this;
		}

		$this->json->add(array(
			'sections'	=> $sections
		));

		return $this;
	}
	
	private function get_gallery($start = 0, $item_ary = false, $return_index = false)
	{
		$rowset = array();
		$sql_where = 'data_type = ' . BLG_DATA_ATTACHMENT;
		
		if(!empty($item_ary))
		{
			$sql_where .= ' AND ' . $this->db->sql_in_set('data_id', $item_ary);
		}
	
		$sql = 'SELECT *
			FROM ' . BLG_DATA_TABLE . '
			WHERE ' . $sql_where . '
			ORDER BY data_time DESC';
		$result = ($item_ary === false) ? $this->db->sql_query_limit($sql, 100, $start) : $this->db->sql_query($sql);
		while($row = $this->db->sql_fetchrow($result))
		{
			$rowset[] = $row;
		}
		$this->db->sql_freeresult($result);
		
		return $this->get_output('attachment', $rowset, $return_index);
	}
	
	private function get_custom_list()
	{
		$items = $gallery_items = array();
		
		foreach($this->params['sources'] as $i => $source)
		{
			if(is_numeric($source))
			{
				$source = (int)$source;
				$gallery_items[$source] = $source;
			}

			$items[] = $source;
		}
		
		$gallery_items = $this->get_gallery(0, $gallery_items, true);
		
		foreach($items as $i => $source)
		{
			if(is_int($source) && isset($gallery_items[$source]))
			{
				$items[$i] = $gallery_items[$source];
			}
			else if(preg_match('#^([^&\'"<>]+)\.(?:gif|png|jpg|jpeg)$#i', $source, $match))
			{
				$items[$i] = $this->get_output('image', array(
					'code'		=> $source,
					'name'		=> ucfirst(str_replace('_', ' ', $match[1])),
				));
			}
			else
			{
				unset($items[$i]);
			}
		}

		return array_values($items);
	}
	
	private function get_images($path = '')
	{
		$image_ary	= array();
		$full_path	= $this->helper->get_ext_path() . 'images/' . substr($path, 2);
		
		if(!file_exists($full_path))
		{
			return array();
		}
		
		$iterator = new \DirectoryIterator($full_path);
		
		foreach($iterator as $fileinfo)
		{
			$file = $fileinfo->getFilename();
			
			if(preg_match('#^([^&\'"<>]+)\.(?:gif|png|jpg|jpeg)$#i', $file, $match))
			{
				$image_ary[] = $this->get_output('image', array(
					'code'		=> $path . $file,
					'name'		=> ucfirst(str_replace('_', ' ', $match[1])),
				));
			}
		}

		return $image_ary;
	}
	
	private function display()
	{
		$this->template->set_filenames(array(
			'body'	=> 'media_manager_body.html'
		));
		
		$this->json->send(array(
			'htmlContent'	=> $this->template->assign_display('body'),
		));
	}
	
	private function get_output($type, $rowset, $return_ids = false)
	{
		$output = array();
		
		if(empty($rowset))
		{
			return $output;
		}

		// Recursive task
		if(isset($rowset[0]))
		{
			foreach($rowset as $row)
			{
				if($type == 'attachment' && $return_ids)
				{
					$output[$row['data_id']] = $this->get_output($type, $row);
					continue;
				}

				$output[] = $this->get_output($type, $row);
			}
			
			return $output;
		}
		
		switch($type)
		{
			case 'attachment':
				$settings 	= unserialize($rowset['data_settings']);
				
				$output = array(
					'originalId'	=> (int)$rowset['data_id'],
					'code'			=> $settings['filename'],
					'title'			=> $rowset['data_title'],
					'description'	=> $rowset['data_content'],
					'filename'		=> $this->helper->build_image_filename($settings['filename']),
					'filesize'		=> get_formatted_filesize($settings['filesize']),
					'url'			=> $this->helper->build_image_filename($settings['filename'], true),
					'width'			=> $settings['width'],
					'height'		=> $settings['height'],
				);
			break;
			
			case 'image':
				$filename = $this->helper->build_image_filename($rowset['code']);
				list($width, $height) = @getimagesize($filename);
				
				$output = array_merge($rowset, array(
					'filename'	=> $filename,
					'filesize'	=> get_formatted_filesize(@filesize($filename)),
					'url'		=> $this->helper->build_image_filename($rowset['code'], true),
					'width'		=> $width,
					'height'	=> $height,
				));
			break;
		}
		
		$output['type'] = $type;
		
		return ($return_ids && $type == 'attachment') ? array($rowset['data_id'] => $output) : $output;
	}
}
