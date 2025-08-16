<?php
/*
* @package Ext Common Core
* @version v1.0.4 01/02/2020
*
* @copyright (c) 2020 CaniDev
* @license https://opensource.org/licenses/gpl-license.php GNU Public License
*/

namespace canidev\core;

// @ignore
if(!defined('IN_PHPBB'))
{
	exit;
}

use Symfony\Component\DependencyInjection\ContainerInterface;
use \canidev\core\json_response;

class media
{
	private $params = array(
		'action'		=> '',
		'allow_gallery'	=> true,
		'custom'		=> false,
		'sources'		=> array(),
		'type'			=> 'image', // image, icon, attachment
	);
	
	private $max_filesize		= 0;
	private $upload_path		= '';
	private $referer_ext		= '';
	private $events_assigned	= false;

	protected $config;
	protected $container;
	protected $core;
	protected $dispatcher;
	protected $json;
	protected $lang;
	protected $path;
	protected $php_ini;
	protected $request;
	protected $template;
	protected $uploader;
	protected $user;
	
	protected $phpbb_root_path;
	protected $php_ext;
	
	static $instances = array();
	
	/**
	* Constructor
	*
	* @param ContainerInterface 	$container		Service container interface
	*
	* @access public
	*/
	public function __construct(ContainerInterface $container)
	{
		$this->config			= $container->get('config');
		$this->container		= $container;
		$this->core				= \canidev\core\lib::get_instance($container);
		$this->dispatcher		= $container->get('dispatcher');
		$this->json				= new json_response;
		$this->lang				= $container->get('language');
		$this->path				= $container->get('path_helper');
		$this->php_ini			= new \phpbb\php\ini;
		$this->request			= $container->get('request');
		$this->template			= \canidev\core\template::get_instance($container);
		$this->uploader 		= $container->get('files.upload');
		$this->user				= $container->get('user');
		$this->phpbb_root_path	= $container->getParameter('core.root_path');
		$this->php_ext			= $container->getParameter('core.php_ext');
	}

	public function preload()
	{
		$this->lang->add_lang('media', 'canidev/core');
		
		$this->template->append_asset('css', '@canidev_core/../theme/mediaManager.css');
		$this->template->append_asset('js', '@canidev_core/js/jquery-ui.min.js');
		$this->template->append_asset('js', '@canidev_core/js/mediaManager.js');

		return $this;
	}

	public function set_events($event_ary)
	{
		if(!$this->events_assigned)
		{
			foreach($event_ary as $event_name => $params)
			{
				$this->dispatcher->addListener('media.' . $event_name, $params);
			}
			
			$this->events_assigned = true;
		}
		
		return $this;
	}
	
	public function set_referer_ext($ext_name)
	{
		if($this->referer_ext == $ext_name)
		{
			return $this;
		}

		$this->referer_ext = $ext_name;
		
		// Try to autoload extension events
		$service_name = 'canidev.' . $ext_name . '.media_events';

		if($this->container->has($service_name))
		{
			$this->set_events($this->container->get($service_name)->getSubscribedEvents());
		}
		
		return $this;
	}
	
	public function set_upload_path($path)
	{
		$this->upload_path = $path;
		
		if(substr($this->upload_path, -1) != '/')
		{
			$this->upload_path .= '/';
		}
		
		return $this;
	}
	
	public function build_icon_html($image)
	{
		if(!$image)
		{
			return '';
		}

		if($this->is_icon($image))
		{
			return '<i class="fa ' . $image . '" aria-hidden="true"></i>';
		}
		
		return '<img src="' . $this->get_full_path($image) . '" alt="" class="cbb-media-icon" />';
	}
	
	
	public function build_selector($key, $type, $value, $use_config = 0)
	{
		$label = strtoupper($type);

		return sprintf(
			'<a href="#" data-module="media" data-type="%1$s" data-value="%2$s" data-value-parsed="%3$s" data-id="%4$s" data-key="%5$s" data-label-btn="%6$s" data-label-delete="%7$s"></a>',
			$type,
			$value,
			($this->is_icon($value)) ? '' : $this->get_full_path($value),
			gen_rand_string(4),
			($use_config) ? "config[$key]" : $key,
			$this->lang->lang("SELECT_$label"),
			$this->lang->lang("DELETE_$label")
		);
	}
	
	public function delete_items($item_ids)
	{
		$this->params['items'] = array_map('intval', $item_ids);

		$params = &$this->params;
		$rowset	= array();
		
		/*
		* @event media.gallery.delete
		* @var array		params		The input params
		* @var array		rowset		Array with files to delete
		* @since 1.0.1
		*/
		$vars = array('params', 'rowset');
		extract($this->dispatcher->trigger_event('media.gallery.delete', compact($vars)));
		
		// Try to delete the files from the server
		foreach($rowset as $filename)
		{
			@unlink($this->get_full_path($filename, false, true));
		}
	}

	public function do_actions()
	{
		if(!($this->request->variable('cbbModule', '') == 'media') && ($this->request->is_ajax() || $this->request->variable('ajaxRequest', false)))
		{
			return false;
		}
		
		$error 	= array();
		$post 	= $this->request->get_super_global(\phpbb\request\request_interface::POST);

		if(isset($post['media']))
		{
			$this->params = array_merge($this->params, $post['media']);
			$this->params['custom'] = (int)$this->params['custom'];
		}

		$this->json->add(array(
			'status'	=> json_response::JSON_STATUS_SUCCESS,
			'action'	=> $this->params['action'],
		));
		
		$this->max_filesize = $this->config['max_filesize'];
		
		if(function_exists('ini_get'))
		{
			$server_max_filesize = min(
				$this->php_ini->get_bytes('post_max_size'),
				max(1, $this->php_ini->get_bytes('memory_limit')),
				$this->php_ini->get_bytes('upload_max_filesize')
			);
			
			if($server_max_filesize)
			{
				$this->max_filesize = ($this->max_filesize) ? min($this->max_filesize, $server_max_filesize) : $server_max_filesize;
			}
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
					'CAN_INSERT_COPY'	=> ($this->upload_path) ? true : false,
					'S_MAX_FILESIZE'	=> ($this->max_filesize) ? $this->lang->lang('MAX_FILESIZE', get_formatted_filesize($this->max_filesize)) : '',
					'S_SUBMIT_LABEL'	=> $this->lang->lang($submit_label),
				));
			
				$this
					->load_sections()
					->display();
			break;
			
			case 'delete':
				if(confirm_box(true))
				{
					if(!empty($this->params['items']))
					{
						$this->delete_items($this->params['items']);
					
						$this->json->send(array(
							'message'	=> $this->lang->lang('FILES_DELETED'),
							'items'		=> $this->params['items'],
						));
					}
					
					$error[] = $this->lang->lang('AJAX_ERROR_TEXT');
				}
				else
				{
					confirm_box(
						false,
						$this->lang->lang('FILES_REMOVE_CONFIRM'),
						build_hidden_fields(array(
							'action'	=> 'delete',
						)),
						'@canidev_core/confirmbox.html'
					);

					return false;
				}
			break;
			
			case 'insert':
				$headers 	= @get_headers($this->params['url'], 1);
				$params		= &$this->params;
				$filename	= $this->params['url'];
					
				if(!isset($headers['Content-Type']) || !preg_match('#image/(.*)#', $headers['Content-Type'], $match))
				{
					$error[] = $this->lang->lang('FORMAT_INVALID');
					break;
				}
				
				if($this->params['copy'] && $this->upload_path)
				{
					$extension 			= $match[1];
					$filename			= $this->user->data['user_id'] . '_' . md5(unique_id()) . '.' . $extension;
					$filename_full		= $this->phpbb_root_path . $this->upload_path . $filename;
					
					if($this->php_ini->get_bool('allow_url_fopen'))
					{
						$image_data = @file_get_contents($this->params['url']);
						
						if(!@file_put_contents($filename_full, $image_data))
						{
							$error[] = $this->lang->lang('IMAGE_SAVE_ERROR');
							break;
						}
					}
					else
					{
						if(($ch = @curl_init($this->params['url'])) === false)
						{
							$error[] = $this->lang->lang('IMAGE_SAVE_ERROR');
							break;
						}
						
						$fp = fopen($filename_full, 'wb');
						curl_setopt($ch, CURLOPT_FILE, $fp);
						curl_setopt($ch, CURLOPT_HEADER, 0);
						curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
						curl_exec($ch);
						curl_close($ch);
						fclose($fp);
					}
				}
				
				$rowset = array(
					'id'			=> time(),
					'description'	=> isset($this->params['description']) ? $this->params['description'] : '',
					'title'			=> isset($this->params['title']) ? $this->params['title'] : '',
					'time'			=> time(),
					'filename'		=> $filename,
					'filesize'		=> isset($headers['Content-Length']) ? (int)$headers['Content-Length'] : '',
					'width'			=> (int)$this->params['width'],
					'height'		=> (int)$this->params['height'],
				);
				
				/*
				* @event media.gallery.insert
				* @var array		rowset		The output array
				* @var array		params		The input params
				* @var array		headers		Returned headers of image url
				* @since 1.0.1
				*/
				$vars = array('rowset', 'params', 'headers');
				extract($this->dispatcher->trigger_event('media.gallery.insert', compact($vars)));

				$this->json->send(array(
					'item'	=> $this->get_output('attachment', $rowset)
				));
			break;
			
			case 'update':
				$params = &$this->params;

				/*
				* @event media.gallery.update
				* @var array		params		Array with item variables
				* @since 1.0.1
				*/
				$vars = array('params');
				extract($this->dispatcher->trigger_event('media.gallery.update', compact($vars)));
				
				$this->json->send(array(
					'message'	=> $this->lang->lang('MEDIA_UPDATED'),
				));
			break;
			
			case 'upload':
				$this->lang->add_lang('posting');
				
				if(!$this->upload_path)
				{
					break;
				}

				if(!$this->uploader->is_valid('file'))
				{
					$error[] = $this->lang->lang('FORM_INVALID');
				}
				
				if(!sizeof($error))
				{
					$allowed_extensions = array('jpg', 'png', 'gif', 'mp4', 'mov');
					$this->uploader->set_allowed_extensions($allowed_extensions);
					
					if($this->max_filesize)
					{
						$this->uploader->set_max_filesize($this->max_filesize);
					}

					$file = $this->uploader->handle_upload('files.types.form', 'file');

					$file->clean_filename('unique_ext', $this->user->data['user_id'] . '_');
					$file->move_file($this->upload_path, false, true);

					if(sizeof($file->error))
					{
						$file->remove();
						$error = array_merge($error, $file->error);
					}
					else if($free_space = @disk_free_space($this->phpbb_root_path . $this->upload_path))
					{
						// Check free disk space
						if($free_space <= $file->get('filesize'))
						{
							$error[] = $this->lang->lang('ATTACH_QUOTA_REACHED');
							$file->remove();
						}
					}
					
					if(!sizeof($error))
					{
						@chmod($this->phpbb_root_path . $this->upload_path . $file->get('realname'), 0644);
						
						$filename	= $this->get_full_path($file->get('realname'), false, true);
						$rowset		= array();
						
						list($width, $height) = @getimagesize($filename);
						
						$rowset = array(
							'id'			=> time(),
							'description'	=> '',
							'title'			=> str_replace('.' . $file->get('extension'), '', $file->get('uploadname')),
							'time'			=> time(),
							'filename'		=> $file->get('realname'),
							'filesize'		=> $file->get('filesize'),
							'width'			=> (int)$width,
							'height'		=> (int)$height,
						);
						
						/*
						* @event media.gallery.upload
						* @var array		rowset		The output array
						* @var object		file		The uploaded file object
						* @var string		filename	Complete route of the file
						* @since 1.0.1
						*/
						$vars = array('rowset', 'file', 'filename');
						extract($this->dispatcher->trigger_event('media.gallery.upload', compact($vars)));
						
						$this->json->send(array(
							'item'	=> $this->get_output('attachment', $rowset)
						));
					}
				}
			break;
		}
		
		if(sizeof($error))
		{
			$this->json->send(array(
				'status'	=> json_response::JSON_STATUS_ERROR,
				'message'	=> implode('<br />', $error)
			));
		}
	}

	public function is_icon($image)
	{
		return strpos($image, 'fa-') === 0;
	}
	
	private function load_sections()
	{
		$sections	= array();
		$type		= $this->params['type'];

		if($this->params['type'] == 'icon')
		{
			$json_ary = @json_decode($this->core->get_data('font-awesome.json'), true);
				
			if($json_ary !== null)
			{
				foreach($json_ary as $cat_title => $row)
				{
					$items = array();
					
					foreach($row['items'] as $icon_code)
					{
						$items[] = array(
							'code'	=> $icon_code,
							'type'	=> 'icon',
						);
					}
					
					$sections[] = array(
						'id'		=> $cat_title,
						'icon'		=> $row['icon'],
						'title'		=> $this->lang->lang($cat_title),
						'editable'	=> false,
						'items'		=> $items,
					);
				}
			}
		}
		else
		{
			/*
			* @event media.sections.load
			* @var array		sections	The output array
			* @var string		type		Type of media required (image | attachment)
			* @since 1.0.1
			*/
			$vars = array('sections', 'type');
			extract($this->dispatcher->trigger_event('media.sections.load', compact($vars)));
			
			foreach($sections as $id => $section)
			{
				if(isset($section['image_paths']))
				{
					$sections[$id]['items'] = array();
					
					foreach($section['image_paths'] as $path)
					{
						$sections[$id]['items'] = array_merge(
							$sections[$id]['items'],
							$this->get_images($path)
						);
					}
				}
			}
		}
		
		if(sizeof($sections))
		{
			$sections[] = 'separator';
		}
		
		if($this->params['allow_gallery'])
		{
			$sections[] = array(
				'id'		=> 'gallery',
				'icon'		=> 'fa-camera',
				'title'		=> $this->lang->lang('GALLERY'),
				'editable'	=> true,
				'sortable'	=> false,
				'items'		=> $this->get_gallery()
			);
		}
		
		if($this->params['type'] == 'image' && $this->params['custom'])
		{
			$sections[] = array(
				'id'		=> 'list',
				'icon'		=> 'fa-file-o',
				'title'		=> $this->lang->lang('CURRENT_LIST'),
				'editable'	=> true,
				'sortable'	=> true,
				'items'		=> $this->get_custom_list()
			);
		}
		
		$sections[] = 'separator';
		
		if($this->upload_path)
		{
			$sections[] = array(
				'id'		=> 'upload',
				'icon'		=> 'fa-upload',
				'title'		=> $this->lang->lang('UPLOAD_IMAGE'),
				'editable'	=> true,
				'sortable'	=> false,
			);
		}
		
		$sections[] = array(
			'id'		=> 'insert',
			'icon'		=> 'fa-cloud-download',
			'title'		=> $this->lang->lang('INSERT_URL'),
			'editable'	=> false,
			'sortable'	=> false,
		);

		$this->json->add(array(
			'sections'	=> $sections
		));

		return $this;
	}
	
	private function get_gallery($start = null, $item_ary = false, $return_index = false)
	{
		$rowset = array();

		/*
		* @event media.gallery.load
		* @var array		rowset		The output array
		* @var array|bool	item_ary	The input array or false if no items
		* @var int			start		Point to start (null to load all elements without pagination)
		* @since 1.0.1
		*/
		$vars = array('rowset', 'item_ary', 'start');
		extract($this->dispatcher->trigger_event('media.gallery.load', compact($vars)));
		
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
		
		$gallery_items = $this->get_gallery(null, $gallery_items, true);

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
		$full_path	= $this->get_full_path($path, false, true);
		
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
		$this->json->send(array(
			'htmlContent'	=> $this->template->render('media', '@canidev_core/media_body.html', true),
		));
	}
	
	public function get_output($type, $rowset, $return_ids = false)
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
					$output[$row['id']] = $this->get_output($type, $row);
					continue;
				}

				$output[] = $this->get_output($type, $row);
			}
			
			return $output;
		}
		
		switch($type)
		{
			case 'attachment':
				$output = array(
					'originalId'	=> (int)$rowset['id'],
					'code'			=> $rowset['filename'],
					'title'			=> $rowset['title'],
					'description'	=> $rowset['description'],
					'filename'		=> $this->get_full_path($rowset['filename']),
					'filesize'		=> get_formatted_filesize($rowset['filesize']),
					'url'			=> $this->get_full_path($rowset['filename'], true),
					'width'			=> $rowset['width'],
					'height'		=> $rowset['height'],
				);
			break;
			
			case 'image':
				$filename = $this->get_full_path($rowset['code'], false, true);
				list($width, $height) = @getimagesize($filename);
				
				$output = array_merge($rowset, array(
					'filename'	=> $this->get_full_path($rowset['code']),
					'filesize'	=> get_formatted_filesize(@filesize($filename)),
					'url'		=> $this->get_full_path($rowset['code'], true),
					'width'		=> $width,
					'height'	=> $height,
				));
			break;
		}
		
		$output['type'] = $type;
		
		return ($return_ids && $type == 'attachment') ? array($rowset['id'] => $output) : $output;
	}
	
	public function get_full_path($image, $full_url = false, $server_path = false)
	{
		$filename = '';
		$web_path = ($server_path) ? $this->path->get_phpbb_root_path() : $this->path->get_web_root_path();
		
		if(substr($image, 0, 2) == './')
		{
			$filename = $web_path . (($this->referer_ext) ? 'ext/canidev/' . $this->referer_ext . '/' : '') . 'images/' . substr($image, 2);
		}
		else if(substr($image, 0, 4) == 'http' || substr($image, 0, 2) == '//')
		{
			return $image;
		}
		else if($image)
		{
			$filename = $web_path . $this->upload_path . $image;
		}
		
		if($full_url && $filename)
		{
			return generate_board_url() . '/' . str_replace($web_path, '', $filename);
		}
		
		return $filename;
	}
	
	static public function get_instance($container, $instanceName = 'default')
	{
		if(!isset(self::$instances[$instanceName]))
		{
			self::$instances[$instanceName] = new self($container);
		}

		return self::$instances[$instanceName];
	}
}
