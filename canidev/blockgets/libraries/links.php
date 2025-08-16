<?php
/**
 * @package cBB Blockgets
 * @version 2.0.5 15/01/2023
 *
 * @copyright (c) 2023 CaniDev
 * @license https://creativecommons.org/licenses/by-nc/4.0/
 */

namespace canidev\blockgets\libraries;

use \canidev\core\json_response;

class links
{
	protected $data			= [];
	protected $source_id	= 0;
	protected $cache_id		= 0;
	protected $base_url		= '';
	
	protected $options		= [
		'btn_title'	=> 'ADD_ITEM',
		'format'	=> 'full',
		'title'		=> 'LINKS',
		'type'		=> false,
		'key'		=> 'list',
		'mask'		=> [
			'title'		=> 'title',
			'subtitle'	=> 'url',
		]
	];

	protected $cache;
	protected $core;
	protected $db;
	protected $dispatcher;
	protected $helper;
	protected $language;
	protected $media;
	protected $request;
	protected $template;
	protected $tools;
	protected $user;
	
	/**
	 * Constructor
	 *
	 * @param \phpbb\cache\driver\driver_interface 		$cache 				Cache instance
	 * @param \canidev\core\lib 						$core 				Core Object
	 * @param \phpbb\db\driver\driver_interface			$db					DB Object
	 * @param \phpbb\event\dispatcher_interface			$phpbb_dispatcher	Event dispatcher
	 * @param \canidev\blockgets\libraries\helper		$helper				Blockgets helper Object
	 * @param \phpbb\language\language					$language			Language Object
	 * @param \phpbb\request\request 					$request			Request object
	 * @param \phpbb\template\template					$template     		Template object
	 * @param \canidev\core\tools 						$tools 				Core Tools Object
	 * @param \phpbb\user								$user				User object
	 *
	 * @access public
	 */
	public function __construct(
		\phpbb\cache\driver\driver_interface $cache,
		\canidev\core\lib $core,
		\phpbb\db\driver\driver_interface $db,
		\phpbb\event\dispatcher_interface $phpbb_dispatcher,
		\canidev\blockgets\libraries\helper $helper,
		\phpbb\language\language $language,
		\phpbb\request\request $request,
		\phpbb\template\template $template,
		\canidev\core\tools $tools,
		\phpbb\user $user)
	{
		$this->cache			= $cache;
		$this->core 			= $core;
		$this->db				= $db;
		$this->dispatcher		= $phpbb_dispatcher;
		$this->helper			= $helper;
		$this->language			= $language;
		$this->request			= $request;
		$this->template			= $template;
		$this->tools 			= $tools;
		$this->user				= $user;
		
		$this->cache_id = $this->request->variable('cache_id', '');
		$this->media 	= $this->helper->get_media();
	}
	

	/**
	 * Create menu template for ACP panel
	 * 
	 * @param bool $rtn_output 		Define if template html will be returned
	 * @return mixed
	 */
	public function acp_template($rtn_output = false)
	{
		$item_ary = $this->load();

		$this->media->do_actions();
		
		if(!$this->cache_id)
		{
			$cache_id = ($this->source_id) ? $this->source_id : gen_rand_string(3);
			$this->cache->put('_blockgets_list_' . $cache_id, $item_ary, 3600);
			
			$this->template->assign_vars([
				'S_ADD_ITEM'		=> $this->language->lang($this->options['btn_title']),
				'S_LIST'			=> !$this->request->is_ajax(),
				'S_LIST_ID'			=> gen_rand_string(4),
				'S_LIST_FORMAT'		=> $this->options['format'],
				
				'S_LIST_HIDDEN_FIELDS'	=> build_hidden_fields([
					'cache_id'	=> $cache_id,
				]),
				
				'U_ADD_ITEM'	=> $this->base_url . '&amp;laction=add',
				'U_BATCH'		=> $this->base_url . '&amp;laction=batch',
			]);
		
			$this->display($item_ary);
		}
		
		if($rtn_output)
		{
			$this->template->set_filenames([
				'list' => 'acp_list_edit.html'
			]);
			
			return $this->template->assign_display('list');
		}
		
		return $this;
	}
	
	/**
	 * Do actions on submit in ACP
	 * @return array
	 */
	public function acp_submit()
	{
		if(!$this->request->variable('list_changed', false))
		{
			return false;
		}
		
		$item_sorted	= $this->request->variable('item', [0 => 0]);
		$item_ary		= $this->load();
		$result			= [];
		
		// Return sorted list
		foreach($item_sorted as $key)
		{
			if(isset($item_ary[$key]))
			{
				$result[] = $item_ary[$key];
			}
		}
		
		if($this->cache_id)
		{
			$this->cache->destroy('_blockgets_list_' . $this->cache_id);
		}
		
		return $result;
	}
	
	/**
	 * Load list items from cache
	 * @return array
	 */
	public function load()
	{
		if($this->cache_id)
		{
			return $this->cache->get('_blockgets_list_' . $this->cache_id);
		}

		if($this->data)
		{
			return $this->data;
		}

		return [];
	}
	
	/**
	 * Get list title
	 * @return string
	 */
	public function get_title()
	{
		return $this->language->lang($this->options['title']);
	}
	
	/**
	 * Set base URL for actions
	 * @return links
	 */
	public function set_base_url($url)
	{
		$this->base_url = $url;
		return $this;
	}
	
	/**
	 * Set data
	 * 
	 * @param array 	$data
	 * @param int 		$source_id
	 * 
	 * @return links
	 */
	public function set_data($data, $source_id = 0)
	{
		if($data !== false)
		{
			$data	= is_string($data) ? unserialize($data) : $data;
			$key	= $this->options['key'];
			
			$this->data = isset($data[$key]) ? $data[$key] : [];
		}

		if($source_id)
		{
			$this->source_id = $source_id;
		}
		
		return $this;
	}
	
	/**
	 * Set Events
	 * 
	 * @param array 	$event_ary
	 */
	public function set_events($event_ary)
	{
		foreach($event_ary as $event_name => $params)
		{
			$this->dispatcher->addListener('list.' . $event_name, $params);
		}
	}

	/**
	 * Set list type
	 * 
	 * @param int 	$type 		LIST_TYPE_NONE|LIST_TYPE_ICON|LIST_TYPE_IMAGE
	 * @return links
	 */
	public function set_type($type)
	{
		$this->options['type'] = $type;
		return $this;
	}
	
	/**
	 * Set options
	 * 
	 * @param array 	$option_ary
	 * @return links
	 */
	public function set_options($option_ary)
	{
		$this->options = array_merge($this->options, $option_ary);
		return $this;
	}
	
	/**
	 * Execute ajax action
	 */
	public function execute_action()
	{
		$action		= $this->request->variable('laction', '');
		$link_id	= $this->request->variable('link_id', '');
		
		if(!$action)
		{
			return false;
		}
		
		if(!$this->cache_id)
		{
			$this->helper->json->send([
				'message'	=> $this->language->lang('AJAX_ERROR_TEXT'),
				'status'	=> json_response::JSON_STATUS_ERROR
			]);
		}
		
		$item_ary = $this->load();
		
		switch($action)
		{
			case 'edit':
				// If no data, quit in this point
				if(!isset($item_ary[$link_id]))
				{
					$this->helper->json->send([
						'message'	=> $this->language->lang('AJAX_ERROR_TEXT'),
						'status'	=> json_response::JSON_STATUS_ERROR
					]);
				}
				
				$item_row = $item_ary[$link_id];

			// no break;

			case 'add':
				$f_ary = [
					constants::LIST_CAT		=> 'CAT',
					constants::LIST_LINK	=> 'LINK'
				];
				
				$type 			= ($this->options['type'] == constants::LIST_TYPE_ICON) ? 'icon' : 'image';
				$dialog_title	= strtoupper($action);
				$error			= [];
				
				if($action == 'add')
				{
					$link_id = (sizeof($item_ary) ? max(array_keys($item_ary)) + 1 : 0);
					
					// Default values
					$item_row = [];
				}

				$display_vars = [
					'type'			=> ['lang' => 'LINK_TYPE',			'validate' => 'int',			'type' => 'select',			'function' => [$this->tools, 'make_select'],	'params' => [$f_ary, false, '{CONFIG_VALUE}'], 'default' => constants::LIST_LINK],
					'title'			=> ['lang' => 'LINK_TITLE',			'validate' => 'string:1:180',	'type' => 'text:40:180'],
					'description'	=> ['lang' => 'LINK_DESCRIPTION',	'validate' => 'string:0:255',	'type' => 'text:40:255'],
					'url'			=> ['lang' => 'LINK_URL',			'validate' => 'string:0:255',	'type' => 'custom',			'method' => 'helper',			'params' => ['url_template', '{KEY}', $item_row, 40, 255, 'window']],
					'image'			=> ['lang' => 'LINK_IMG',			'validate' => 'string', 		'type' => 'custom',			'function' => [$this->media, 'build_selector'],		'params' => ['{KEY}', $type, '{CONFIG_VALUE}', 1]],
					'groups'		=> ['lang' => 'LINK_GROUP',			'type' => 'custom',				'function' => [$this->tools, 'groups_select'],	'params' => ['groups', '{CONFIG_VALUE}'],	'default' => 'all'],
				];
				
				if($this->options['type'] == constants::LIST_TYPE_NONE)
				{
					unset($display_vars['image']);
				}

				/**
				 * @event list.edit.before
				 * @var array	item_row		The current item
				 * @var array	display_vars	The form fields to display
				 * @var string	action			The current action
				 * @var string	dialog_title	The dialogBox title
				 * @since 2.0.0
				 */
				$vars = ['item_row', 'display_vars', 'action', 'dialog_title'];
				extract($this->dispatcher->trigger_event('list.edit.before', compact($vars)));

				if($this->core->modal_dialog(true))
				{
					$new_config = utf8_normalize_nfc($this->request->variable('config', ['' => ''], true));
					
					// Always set the 'window' variable if url is present
					if(isset($new_config['url']) && !isset($new_config['window']))
					{
						$new_config['window'] = 0;
					}
					
					$item_row = array_merge($item_row, $new_config);
					
					if(isset($item_row['type']) && $item_row['type'] == constants::LIST_CAT)
					{
						unset($display_vars['url']['validate']);
					}
					
					foreach($display_vars as $config_name => $data)
					{
						if(strpos($config_name, 'legend') !== false)
						{
							continue;
						}

						if($config_name == 'groups')
						{
							$item_row[$config_name] = '';

							if($this->request->is_set_post($config_name) || $this->request->is_set_post('all_groups_groups'))
							{
								$item_row[$config_name] = ($this->request->is_set_post('all_groups_groups') ? 'all' : $this->request->variable($config_name, [0]));
								$item_row[$config_name] = (is_array($item_row[$config_name]) ? implode(',', $item_row[$config_name]) : $item_row[$config_name]);
							}
						}
					}
					
					// We validate the complete config if whished
					validate_config_vars($display_vars, $item_row, $error);
					
					/**
					 * @event list.edit.before
					 * @var array	item_row		The current item
					 * @var array	error			Array with error codes
					 * @since 2.0.0
					 */
					$vars = ['item_row', 'error'];
					extract($this->dispatcher->trigger_event('list.edit.after', compact($vars)));
					
					if(sizeof($error))
					{
						$this->helper->json->send([
							'message'	=> implode('<br />', $error),
							'status'	=> json_response::JSON_STATUS_ERROR,
						]);
					}
					
					$item_ary[$link_id] = $item_row;
					
					$this->cache->put('_blockgets_list_' . $this->cache_id, $item_ary, 3600);

					$this->template->assign_var('S_ITEM', true);
					
					$this->display([
						$link_id => $item_row
					]);

					$this->template->set_filenames([
						'list'	=> '@canidev_blockgets/acp_list_edit.html'
					]);
					
					$this->helper->json
						->add_html($this->template->assign_display('list'))
						->send();
				}
				else
				{
					// Display
					foreach($display_vars as $config_key => $vars)
					{
						if(!is_array($vars) && strpos($config_key, 'legend') === false)
						{
							continue;
						}

						if(strpos($config_key, 'legend') !== false)
						{
							$this->template->assign_block_vars('options', [
								'S_LEGEND'		=> true,
								'LEGEND'		=> $this->language->lang($vars)
							]);
							
							continue;
						}
						
						if(!isset($item_row[$config_key]) && isset($vars['default']))
						{
							$item_row[$config_key] = $vars['default'];
						}

						$type = explode(':', $vars['type']);

						$content = build_cfg_template($type, $config_key, $item_row, $config_key, $vars);
						if(empty($content))
						{
							continue;
						}

						$this->template->assign_block_vars('options', [
							'KEY'			=> $config_key,
							'TITLE'			=> $this->language->lang($vars['lang']),
							'S_EXPLAIN'		=> ($this->language->is_set($vars['lang'] . '_EXPLAIN') ? $this->language->lang($vars['lang'] . '_EXPLAIN') : ''),
							'CONTENT'		=> $content,
						]);

						unset($display_vars[$config_key]);
					}

					$this->template->assign_var('S_EDIT', true);

					$this->core->modal_dialog(
						false,
						$dialog_title, 
						[
							'cache_id'	=> $this->cache_id
						],
						'@canidev_blockgets/acp_list_edit.html'
					);
					
					return false;
				}
			break;
			
			case 'delete':
				$link_ids = $this->request->variable('item_list', [0]);
				$link_ids = (empty($link_ids) && $link_id != '') ? [$link_id] : $link_ids;

				foreach($link_ids as $i)
				{
					unset($item_ary[$i]);
				}
				
				$this->cache->put('_blockgets_list_' . $this->cache_id, $item_ary, 3600);

				$this->helper->json->send([
					'message'	=> $this->language->lang('ITEM_REMOVED'),
					'item_list'	=> $link_ids,
				]);
			break;
		}
	}
	
	/**
	 * Display
	 * 
	 * @param array		$item_ary 		Item list
	 * @access private
	 */
	protected function display($item_ary)
	{
		foreach($item_ary as $link_id => $row)
		{
			$row['type'] = (isset($row['type']) ? $row['type'] : constants::LIST_LINK);
			
			$img	= '';
			$title	= $row[$this->options['mask']['title']];
			$title	= $this->language->lang($title);

			if($row['type'] == constants::LIST_CAT)
			{
				$subtitle = $this->language->lang('CAT');
			}
			else
			{
				$subtitle 	= $this->language->lang($row[$this->options['mask']['subtitle']]);
				
				if(isset($row['image']))
				{
					$img = $this->media->build_icon_html($row['image']);
				}
			}

			$this->template->assign_block_vars('item', [
				'ID'			=> $link_id,
				'TITLE' 		=> $title,
				'SUBTITLE' 		=> $subtitle,
				'IMG' 			=> $img,
				'IS_DISABLED'	=> ($row['type'] == constants::LIST_CAT) ? true : false,
				
				'HIDDEN_FIELDS' => build_hidden_fields([
					'item[]'	=> $link_id,
				]),
				
				'U_EDIT'		=> $this->base_url . '&amp;laction=edit&amp;link_id=' . $link_id,
				'U_DELETE'		=> $this->base_url . '&amp;laction=delete&amp;link_id=' . $link_id,
			]);
		}
	}
}
