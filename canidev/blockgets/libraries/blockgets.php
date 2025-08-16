<?php
/**
 * @package cBB Blockgets
 * @version 2.0.6 20/09/2023
 *
 * @copyright (c) 2023 CaniDev
 * @license https://creativecommons.org/licenses/by-nc/4.0/
 */

namespace canidev\blockgets\libraries;

use \Symfony\Component\DependencyInjection\ContainerInterface;

class blockgets
{
	static $block_position_names	= ['', 'left', 'center', 'right', 'top', 'bottom'];
	
	public $active	= true;
	
	public $phpbb_root_path;
	public $php_ext;

	protected $page	= null;
	protected $forum_block_order;
	protected $center_classes;

	protected $auth;
	protected $cache;
	protected $config;
	protected $container;
	protected $dispatcher;
	protected $db;
	protected $helper;
	protected $language;
	protected $request;
	protected $template;
	protected $user;

	protected $tables;

	/**
	 * Constructor
	 *
	 * @param \phpbb\auth\auth 							$auth				Authentication object
	 * @param \phpbb\cache\driver\driver_interface 		$cache 				Cache instance
	 * @param \phpbb\config\config 						$config				Config Object
	 * @param ContainerInterface 						$container			Service container interface
	 * @param \phpbb\event\dispatcher_interface			$phpbb_dispatcher	Event dispatcher
	 * @param \phpbb\db\driver\driver_interface			$db					DB Object
	 * @param \canidev\blockgets\libraries\helper		$helper				Blockgets helper Object
	 * @param \phpbb\language\language					$language			Language Object
	 * @param \phpbb\request\request 					$request			Request object
	 * @param \canidev\core\template 					$template 			Canidev Core Template
	 * @param \phpbb\user								$user				User object
	 * @param string									$root_path			phpBB root path
	 * @param string									$php_ext			phpEx
	 * @param array 									$tables 			Blockgets DB Tables
	 *
	 * @access public
	 */
	public function __construct(
		\phpbb\auth\auth $auth,
		\phpbb\cache\driver\driver_interface $cache,
		\phpbb\config\config $config,
		ContainerInterface $container,
		\phpbb\event\dispatcher_interface $phpbb_dispatcher,
		\phpbb\db\driver\driver_interface $db,
		\canidev\blockgets\libraries\helper $helper,
		\phpbb\language\language $language,
		\phpbb\request\request $request,
		\canidev\core\template $template,
		\phpbb\user $user,
		$root_path,
		$php_ext,
		$tables)
	{
		$this->auth				= $auth;
		$this->cache			= $cache;
		$this->config 			= $config;
		$this->container		= $container;
		$this->dispatcher		= $phpbb_dispatcher;
		$this->db				= $db;
		$this->helper			= $helper;
		$this->language			= $language;
		$this->request			= $request;
		$this->template			= $template;
		$this->user				= $user;

		$this->phpbb_root_path	= $root_path;
		$this->php_ext			= $php_ext;
		$this->tables 			= $tables;
	}

	/**
	 * Set current page
	 * 
	 * @param string 	$page 		Page Slug
	 */
	public function set_page($page = '')
	{
		if($page)
		{
			$this->page = (string)$page;
		}
	}
	
	/**
	 * Display extension page
	 */
	public function display_page()
	{
		// Load the template context in this point to get all variables
		$this->template->load_context($this->container);

		if(defined('IN_ERROR_HANDLER') || $this->template->get_var('MESSAGE_TEXT'))
		{
			$this->active = false;
		}

		$service_params = [];

		// Set global data in template
		if(!defined('IN_ADMIN'))
		{
			$this->load_page();
			
			// Redirect pages if neccessary or not allowed
			$board_url = generate_board_url() . '/';
			
			if(defined('BLG_HOME_PAGE') && !$this->active && !empty($this->page))
			{
				redirect(append_sid("{$board_url}index.{$this->php_ext}"));
			}

			$this->load_assets();

			$service_params += [
				'avatarsMaxWidth'	=> (int)$this->config['blg_avatar_max_width'],
				'imagesMaxWidth'	=> (int)$this->config['blg_image_max_width'],
				'resizeOnPosts'		=> (bool)$this->config['blg_resize_on_post'],
			];

			$this->template->assign_vars([
				'U_BLG_ACTION'		=> $this->helper->current_url(),
			]);
			
			if($this->config['blg_admin_bar'] && $this->auth->acl_get('a_blockgets'))
			{
				$admin_base = $this->phpbb_root_path . 'adm/index.' . $this->php_ext . '?i=-canidev-blockgets-acp-main_module&amp;mode=pages';
				$page_alias = (($this->user->page['page_dir']) ? $this->user->page['page_dir'] . '/' : '') . str_replace(".{$this->php_ext}", '', $this->user->page['page_name']);
				$page_param	= isset($this->page['page_id']) ? 'p=' . $this->page['page_id'] : 'alias=' . $page_alias;
				
				if(!in_array($page_alias, ['app/calendar', 'app/player']))
				{
					$this->template->assign_vars([
						'BLG_ADMIN_BAR'			=> true,
						'U_BLG_MANAGE_BLOCKS'	=> append_sid($admin_base . '&amp;action=manage&amp;' . $page_param, false, true, $this->user->session_id),
						'U_BLG_PAGE_ADD'		=> append_sid($admin_base . '&amp;action=add&amp;page_file=custom', false, true, $this->user->session_id),
						'U_BLG_PAGE_EDIT'		=> append_sid($admin_base . '&amp;action=edit&amp;' . $page_param, false, true, $this->user->session_id),
					]);

					$service_params['showAdminBar'] = true;
				}
			}

			if($this->active)
			{
				$service_params += [
					'background'	=> ($this->page['page_theme'] == 'background') ? $this->page['background'] : '',
					'page_id'		=> $this->page['page_id'],
				];

				$this->template->assign_vars([
					'BLG_ENABLED'			=> true,
					'BLG_ON_BOARD'			=> ($this->config['blg_on_board'] != constants::BOARD_BLOCK_NONE && !defined('BLG_HOME_PAGE')),
					'BLG_BLOCK_SPACE'		=> $this->page['block_space'],
					'BLG_LOGO'				=> $this->page['logo'],

					'LEFT_COLUMN_WIDTH'		=> $this->page['left_column_width'],
					'RIGHT_COLUMN_WIDTH'	=> $this->page['right_column_width'],
					'SHOW_LEFT_COLUMN'		=> ((int)$this->page['left_column_width']) ? true : false,
					'SHOW_RIGHT_COLUMN'		=> ((int)$this->page['right_column_width']) ? true : false,
					
					// Apply the page title
					'PAGE_TITLE'			=> ($this->page['page_title']) ? $this->get_title() : $this->template->get_var('PAGE_TITLE'),
				]);
				
				// Apply the page stylesheet
				if($this->page['page_theme'] == 'stylesheet')
				{
					$this->page['stylesheet'] = trim($this->page['stylesheet']);

					if(strpos($this->page['stylesheet'], 'http') === 0)
					{
						foreach(explode("\n", $this->page['stylesheet']) as $css_file)
						{
							$this->template->append_asset('css', $css_file);
						}
					}
					else if(strpos($this->page['stylesheet'], '{') !== false)
					{
						$find 		= ['&quot;', "\t", "\n", '}'];
						$replace	= ['"', ' ', '', " }\n"];
						
						$this->template->append_asset('style', str_replace($find, $replace, $this->page['stylesheet']));
					}
				}
				
				$body_class = (!$this->page['header']) ? ' blg-noheader' : '';
				$body_class .= (!$this->page['footer']) ? ' blg-nofooter' : '';

				$this->template->append_var('BODY_CLASS', $body_class);
				
				if($this->page['page_type'] != constants::PAGE_FORUM && !empty($this->page['description']))
				{
					$this->template->append_var('META', '<meta name="description" content="' . $this->page['description'] . "\"  />\n");
				}

				$this->load_blocks();
			}

			$this->template->set_js_lang([
				'EXPAND_CONTRACT',
			]);

			$this->load_page_links();
		}

		$this->template->assign_json_var('S_BLG_OPTIONS', $service_params);

		/**
		 * @event blockgets.display
		 * @since 2.0.0
		 */
		$this->dispatcher->trigger_event('blockgets.display');
	}
	
	/**
	 * Get page title
	 * 
	 * @param array|false 	$page 		Page Data
	 */
	public function get_title($page = false)
	{
		$page_title = ($page !== false) ? $page['page_title'] : $this->page['page_title'];

		return ($page_title) ? $this->language->lang($page_title) : '';
	}

	/**
	 * Load basic assets
	 */
	public function load_assets()
	{
		$asset_ary = [
			['css', '@canidev_blockgets/common.css'],
			['css', '@canidev_blockgets/acp.css', false, 'admin'],

			['js', '@canidev_core/js/jquery-ui.min.js', false, 'admin'],
			['js', '@canidev_blockgets/js/jblockgets.min.js'],
			['js', '@canidev_blockgets/js/jblockgets-acp.js', false, 'admin'],
		];

		foreach($asset_ary as $asset)
		{
			call_user_func_array([$this->template, 'append_asset'], $asset);
		}
	}
	
	/** 
	 * Load blocks and put into template
	 * @access private
	 */
	private function load_blocks()
	{
		if(empty($this->page) || defined('BLG_IN_AJAX'))
		{
			return $this;
		}

		$this->forum_block_order	= 0;
		$this->center_classes		= ['hasleft' => false, 'hasright' => false];

		// Load the blocks
		$block_rows = [0 => []];

		$sql = 'SELECT *
			FROM ' . $this->tables['blocks'] . '
			WHERE block_enabled = 1
			AND block_page = ' . $this->page['page_id'] . '
			ORDER BY block_position ASC, block_order ASC';
		$result = $this->db->sql_query($sql);
		while($row = $this->db->sql_fetchrow($result))
		{
			$parent_id = (int)$row['parent_id'];

			if(!isset($block_rows[$parent_id]))
			{
				$block_rows[$parent_id] = [];
			}
			
			$block_rows[$parent_id][] = $row;
		}
		$this->db->sql_freeresult($result);
		
		foreach($block_rows[0] as $row)
		{
			$block_position = (isset(self::$block_position_names[$row['block_position']]) ? self::$block_position_names[$row['block_position']] : false);

			if($block_position === false)
			{
				continue;
			}
			
			if($row['block_alias'] == 'group')
			{
				if(!empty($block_rows[$row['block_id']]))
				{
					$item_count		= sizeof($block_rows[$row['block_id']]);
					$block_sizes 	= ($row['block_content']) ? explode(',', $row['block_content']) : [];

					$this->template->assign_block_vars("{$block_position}_blockrow", [
						'BLOCK_ID'			=> $row['block_id'],
						'IS_GROUP'			=> true,
						'AFTER_FORUM'		=> (defined('BLG_HOME_PAGE') || ($this->forum_block_order != 0 && $row['block_order'] > $this->forum_block_order)) ? true : false,
					]);

					foreach($block_rows[$row['block_id']] as $i => $subrow)
					{
						$subrow['sibling_count'] = $item_count - 1;

						if(isset($block_sizes[$i]))
						{
							$subrow['block_width'] = $block_sizes[$i];
						}

						$this->block_to_template($subrow, "{$block_position}_blockrow.blocks");
					}
				}
			}
			else
			{
				$row['sibling_count'] = 0;
				$this->block_to_template($row, "{$block_position}_blockrow");
			}
		}
	
		$this->template->assign_vars([
			'CENTER_COLUMN_CLASSES'	=> implode(' ', array_keys(array_filter($this->center_classes))),
			'DISPLAY_FORUM_BLOCK'	=> ($this->forum_block_order == 0) ? false : true
		]);
		
		return $this;
	}
	
	/**
	 * Output block to template
	 * 
	 * @param array 		$block_row 		Block Data
	 * @param string		$tpl_var 		Template key var
	 * 
	 * @access private
	 */
	private function block_to_template($block_row, $tpl_var)
	{
		$class_name		= '\\canidev\\blockgets\\blocks\\' . $block_row['block_alias'];
		$block_position	= (isset(self::$block_position_names[$block_row['block_position']]) ? self::$block_position_names[$block_row['block_position']] : false);
		
		// If the current column is disabled or the position is incorrect, don't load the block -.-
		if($block_position === false || (in_array($block_position, ['left', 'right']) && empty($this->page["{$block_position}_column_width"])))
		{
			return false;
		}

		if($block_row['block_alias'] == 'forum_content')
		{
			$this->forum_block_order = $block_row['block_order'];
			return true;
		}
		else if(!class_exists($class_name) || !$this->helper->group_auth($block_row['block_groups']))
		{
			return false;
		}

		// Initialize and load the block
		$block_class = new $class_name($this->container, $block_row);

		if($block_class->init() !== false)
		{
			$block_style = $block_class->get_block_style();
			
			// Build all the block classes
			$dom_classes = ['style-' . $block_style];
			
			if($this->config['blg_collapse_blocks'] && $block_row['allow_collapse'] != constants::BLOCK_COLLAPSE_NONE && $block_row['block_style'] != constants::BLOCK_STYLE_CONTENT_SIMPLE)
			{
				$dom_classes[] = 'collapsable';

				if($block_row['allow_collapse'] == constants::BLOCK_COLLAPSE_HIDDEN)
				{
					$dom_classes[] = 'collapsed';
				}
			}
			
			if($block_class->view_is_small())
			{
				$dom_classes[] = 'shorted';
			}

			// Put block into general template to display
			$template_ary = [
				'BLOCK_ID'    		=> $block_row['block_id'],
				'BLOCK_TITLE'		=> $this->language->lang($block_row['block_title']),
				'BLOCK_CONTENT'		=> $block_class->display(),
				'BLOCK_ICON'		=> $this->helper->get_media(false, false)->build_icon_html($block_row['block_icon']),
				'BLOCK_CLASSES'		=> implode(' ', $dom_classes),
				'BLOCK_STYLE'		=> $block_style,
				'DOM_STYLE'			=> !empty($block_row['block_width']) ? sprintf('width:%1$s%%; flex:1 1 %1$s%%', $block_row['block_width']) : '',
				
				'AFTER_FORUM'		=> (defined('BLG_HOME_PAGE') || ($this->forum_block_order != 0 && $block_row['block_order'] > $this->forum_block_order)) ? true : false,
			];

			/**
			 * @event blockgets.block_row
			 * @var array	template_ary	The output array
			 * @var array	block_row		The original data
			 * @var string	tpl_var			Variable for block position
			 * @since 2.0.0
			 */
			$vars = ['template_ary', 'block_row', 'tpl_var'];
			extract($this->dispatcher->trigger_event('blockgets.block_row', compact($vars)));
			
			$this->template->assign_block_vars($tpl_var, $template_ary);
			
			if($block_position == 'left' || $block_position == 'right')
			{
				$this->center_classes["has$block_position"] = true;
			}
		}

		unset($block_class);
	}
	
	/**
	 * Load page links
	 * 
	 * @return blockgets
	 * @access private
	 */
	private function load_page_links()
	{
		$page_cache = $this->get_pages();
		
		// Build link of home page
		if(!empty($page_cache['pages'][constants::PAGE_HOME]))
		{
			$home_page = array_shift($page_cache['pages'][constants::PAGE_HOME]);
			
			if($home_page['page_enabled'] && $this->helper->group_auth($home_page['page_groups']))
			{
				$this->template->assign_vars([
					'L_SITE_HOME'		=> $this->get_title($home_page),
					'U_SITE_HOME'		=> $this->helper->route('canidev_blockgets_controller'),
				]);
			}
			
			unset($home_page);
		}
		
		// Build links for custom pages
		if(!empty($page_cache['pages'][constants::PAGE_CUSTOM]))
		{
			foreach($page_cache['pages'][constants::PAGE_CUSTOM] as $row)
			{
				if($row['link_position'] && $row['page_enabled'] && $this->helper->group_auth($row['page_groups']))
				{
					$this->template->assign_block_vars('blglink_' . $row['link_position'], [
						'HREF'		=> $this->helper->route('canidev_blockgets_page_' . $row['page_id']),
						'ICON'		=> $this->helper->get_media(false, false)->build_icon_html($row['link_icon']),
						'TITLE'		=> $this->get_title($row),
					]);
				}
			}
		}
		
		// Link for calendar
		if($this->config['blg_calendar_enabled'] && $this->config['blg_calendar_link'] && $this->auth->acl_get('u_blockgets_calendar'))
		{
			$this->template->assign_block_vars('blglink_' . $this->config['blg_calendar_link'], [
				'HREF'		=> $this->helper->route('canidev_blockgets_calendar_controller'),
				'ICON'		=> $this->helper->get_media(false, false)->build_icon_html('fa-calendar'),
				'TITLE'		=> $this->language->lang('CALENDAR'),
			]);
		}
		
		unset($page_cache);
		return $this;
	}
	
	/**
	 * Select the page to show if available
	 * 
	 * @param bool $rtn_result 		Set if result page must be returned
	 * @return bool|string|array
	 */
	public function load_page($rtn_result = false)
	{
		// Ok, page already loaded, return
		if(is_array($this->page) || $this->page === false)
		{
			return ($rtn_result) ? $this->page : false;
		}

		$page_cache = $this->get_pages();
		
		if(defined('BLG_HOME_PAGE'))
		{
			// If previous page was defined use it, else, request a value
			$page = (!empty($this->page) && is_string($this->page)) ? $this->page : '';

			if($page)
			{
				$page_type	= constants::PAGE_CUSTOM;
				$page_id	= (is_numeric($page)) ? (int)$page : (isset($page_cache['alias'][$page]) ? $page_cache['alias'][$page] : 0);
			}
			else
			{
				$page_type	= constants::PAGE_HOME;
				$page_id	= (isset($page_cache['alias']['home']) ? $page_cache['alias']['home'] : 0);
			}
		}
		else
		{
			if($this->config['blg_on_board'] == constants::BOARD_BLOCK_SAME)
			{
				$page_alias = 'index';
			}
			else
			{
				$page_alias = (($this->user->page['page_dir']) ? $this->user->page['page_dir'] . '/' : '') . str_replace(".{$this->php_ext}", '', $this->user->page['page_name']);
			
				// If is a route of other extension, remove params from the page alias
				$controller_params = $this->container->get('symfony_request')->attributes->all();

				if(isset($controller_params['_route']))
				{
					foreach($controller_params['_route_params'] as $i => $val)
					{
						$page_alias = str_replace('/' . $val, '', $page_alias);
					}
				}
			}
			
			$page_type	= constants::PAGE_FORUM;
			$page_id	= (isset($page_cache['alias'][$page_alias]) ? $page_cache['alias'][$page_alias] : 0);
		}

		// Reset page
		$this->page = null;

		if(isset($page_cache['pages'][$page_type][$page_id]))
		{
			$page	= $page_cache['pages'][$page_type][$page_id];
			$bValid	= [true];
			
			// Check filters for forum pages
			if($page_type == constants::PAGE_FORUM && !empty($page['filters']))
			{
				foreach($page['filters'] as $filter)
				{
					preg_match_all('#(!)?([\w\d\-\_]+)(?:\=(.*?))?(?:,|$)#', $filter['param'], $f_matches);

					foreach($f_matches[2] as $i => $key)
					{
						$check_key 	= ($filter['method'] == 'POST') ? \phpbb\request\request_interface::POST : \phpbb\request\request_interface::GET;
						$is_negate	= ($f_matches[1][$i] == '!') ? true : false;
						$value		= (!empty($f_matches[3][$i]) ? $f_matches[3][$i] : true);
						$gvalue		= ($this->request->is_set($key, $check_key) ? $this->request->variable($key, '', false, $check_key) : false);
						$valid      = true;

						// If is a route of other extension, check filter on route params
						if($gvalue === false && isset($controller_params) && $filter['method'] == 'GET')
						{
							$gvalue = isset($controller_params['_route_params'][$key]) ? $controller_params['_route_params'][$key] : false;
						}
						
						if($value === true)
						{
							$valid = ($gvalue === false) ? false : true;
						}
						else
						{
							$valid = ($gvalue == $value) ? true : false;
						}
						
						$bValid[] = ($is_negate) ? !$valid : $valid;
					}
				}
			}
			
			if(!in_array(false, $bValid, true))
			{
				$this->page = $page;
			}
		}
		
		unset($page_cache);
		
		// Display 404 error for custom pages if no exist
		if($page_type == constants::PAGE_CUSTOM && empty($this->page))
		{
			$this->page = false;
			throw new \phpbb\exception\http_exception(404, 'NO_PAGE');
		}

		if(empty($this->page) ||
			!$this->page['page_enabled'] ||
			($page_type == constants::PAGE_FORUM && ($this->config['blg_on_board'] == constants::BOARD_BLOCK_NONE || $this->user->page['page_dir'])) ||
			!$this->helper->group_auth($this->page['page_groups']))
		{
			$this->active = false;
			return false;
		}

		return ($rtn_result) ? $this->page : true;
	}
	
	/**
	 * Get pages from cache
	 * @return array
	 */
	public function get_pages()
	{
		// Get cached pages
		if(($page_cache = $this->cache->get('_blockgets_pages')) === false)
		{
			$page_cache = [
				'pages' => [
					constants::PAGE_HOME 	=> [],
					constants::PAGE_FORUM 	=> [],
					constants::PAGE_CUSTOM	=> [],
				],
				'alias'		=> [],
			];

			$sql = 'SELECT *
				FROM ' . $this->tables['pages'];
			$result = $this->db->sql_query($sql);
			while($row = $this->db->sql_fetchrow($result))
			{
				$row['page_alias'] = str_replace(".{$this->php_ext}", '', $row['page_alias']);
				
				if($unserialize_config = @unserialize($row['page_data']))
				{
					$row = array_merge($row, $unserialize_config);
				}

				foreach(['left', 'right'] as $i)
				{
					if(isset($row[$i . '_column_width']) && preg_match('#^0(px|%)$#', $row[$i . '_column_width']))
					{
						$row[$i . '_column_width'] = 0;
					}
				}

				$page_cache['pages'][$row['page_type']][$row['page_id']] = $row;
				$page_cache['alias'][$row['page_alias']] = $row['page_id'];
			}
			$this->db->sql_freeresult($result);

			$this->cache->put('_blockgets_pages', $page_cache);
		}
		
		return $page_cache;
	}

	/**
	 * Parse ajax request
	 */
	public function parse_ajax()
	{
		$module	= $this->request->variable('jblgm', '');

		if($module && ($this->request->is_ajax() || $this->request->variable('ajaxModule', '') == 'blockgets'))
		{
			$this->template->assign_var('BLG_IN_AJAX', true);

			// Remove listeners to prevent infinite loop if $user->setup is called again
			$listeners = $this->dispatcher->getListeners('core.user_setup_after');

			foreach($listeners as $listener)
			{
				$this->dispatcher->removeListener('core.user_setup_after', $listener);
			}

			if(is_numeric($module))
			{
				$module = (int)$module;
				$method	= $this->request->variable('m', 'submit');
				
				$sql = 'SELECT *
					FROM ' . $this->tables['blocks'] . '
					WHERE block_id = ' . $module;
				$result = $this->db->sql_query($sql);
				$block_row = $this->db->sql_fetchrow($result);
				$this->db->sql_freeresult($result);

				// Get number of siblings to correct display
				$block_row['sibling_count'] = 0;

				if($block_row['parent_id'])
				{
					$sql = 'SELECT COUNT(block_id) AS item_count
						FROM ' . $this->tables['blocks'] . '
						WHERE parent_id = ' . $block_row['parent_id'] . '
						AND block_id <> ' . $block_row['block_id'];
					$result = $this->db->sql_query($sql);
					$block_row['sibling_count'] = (int)$this->db->sql_fetchfield('item_count');
					$this->db->sql_freeresult($result);
				}
				
				if($block_row)
				{
					$class_name	= '\\canidev\\blockgets\\blocks\\' . $block_row['block_alias'];

					if(class_exists($class_name))
					{
						page_header('', false, 0, 'forum', false);

						$block = new $class_name($this->container, $block_row);
						
						if(!$block->init($method))
						{
							$this->helper->json->send([
								'message'	=> $this->language->lang('BLOCK_LOAD_ERROR'),
								'status'	=> \canidev\core\JsonResponse::JSON_STATUS_ERROR
							]);
						}
						
						$this->helper->json
							->addHtml($block->display())
							->send();
					}
				}
			}
			else
			{
				$module = 'canidev.blockgets.' . $module;

				if($this->container->has($module))
				{
					page_header('', false, 0, 'forum', false);
					$this->container->get($module)->init();
				}
			}
			
			garbage_collection();
			exit_handler();
		}
	}
}
