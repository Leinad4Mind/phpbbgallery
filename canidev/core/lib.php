<?php
/*
* @name lib.php
* @package Ext Common Core
* @version v1.0.1 05/02/2019
*
* @copyright (c) 2019 CaniDev
* @license https://opensource.org/licenses/gpl-license.php GNU Public License
*/

namespace canidev\core;

// @ignore
if(!defined('IN_PHPBB'))
{
	exit;
}

class lib
{
	const VERSION		= '1.0.1';
	
	private $items		= array();
	
	private $db;
	private $lang;
	private $template;
	private $user;
	private $phpbb_root_path;
	
	static $instance;

	/**
	* Constructor
	*
	* @param ContainerInterface 	$container		Service container interface
	*
	* @access public
	*/
	public function __construct($container)
	{
		$cache 					= $container->get('cache.driver');
		$dispatcher 			= $container->get('dispatcher');
		$php_ext				= $container->getParameter('core.php_ext');
		$compatibility_path 	= 'canidev/core/compatibility/';

		$this->db				= $container->get('dbal.conn');
		$this->lang				= $container->get('language');
		$this->template			= \canidev\core\template::get_instance($container);
		$this->user				= $container->get('user');
		$this->phpbb_root_path	= $container->getParameter('core.root_path');

		// Get additional addons for the extensions
		if(($this->items = $cache->get('_cbbext_compatibility')) === false)
		{
			$this->items = array();

			$base_path	= $this->phpbb_root_path . 'ext/' . $compatibility_path;
			$directory	= new \RecursiveDirectoryIterator($base_path);
			$iterator	= new \RecursiveIteratorIterator($directory);
			$regex		= new \RegexIterator($iterator, '/([a-z0-9_\-]+)\.' . $php_ext . '$/i');

			foreach($regex as $file)
			{
				$basename = $file->getBasename('.' . $php_ext);
				
				if($basename == 'base')
				{
					continue;
				}

				$path = str_replace(
					array('\\', $base_path),
					array('/', ''),
					$file->getPathInfo()->getPathname()
				);

				if(strpos($path, '/') !== false)
				{
					$path_parts = explode('/', $path, 2);
					
					$path 		= $path_parts[0];
					$basename	= $path_parts[1] . '/' . $basename;
				}

				if(!isset($this->items[$path]))
				{
					$this->items[$path] = array();
				}
				
				$this->items[$path][] = $basename;
			}

			$cache->put('_cbbext_compatibility', $this->items);
		}
		
		// Initiaize items and parse core events
		foreach($this->items as $namespace => $items)
		{
			foreach($items as $id => $item)
			{
				$fullname	= $compatibility_path . $namespace . '/' . $item;
				$filename	= $this->phpbb_root_path . 'ext/' . $fullname . ".$php_ext";
				$class_name = '\\' . str_replace('/', '\\', $fullname);
				$ext_path	= $this->phpbb_root_path . 'ext/canidev/' . $namespace;

				if(!file_exists($filename) || !file_exists($ext_path) || !class_exists($class_name))
				{
					unset($this->items[$namespace][$id]);
					continue;
				}
					
				$this->items[$namespace][$id] = $item = new $class_name($container);
				
				if($item->is_runnable())
				{
					foreach($item->core_events() as $event_name => $params)
					{
						if(is_string($params))
						{
							$dispatcher->addListener($event_name, array($item, $params), -1);
						}
						else if(is_string($params[0]))
						{
							$dispatcher->addListener($event_name, array($item, $params[0]), isset($params[1]) ? $params[1] : -1);
						}
						else
						{
							foreach($params as $listener)
							{
								$dispatcher->addListener($event_name, array($item, $listener[0]), isset($listener[1]) ? $listener[1] : -1);
							}
						}
					}
				}
			}
		}
	
		// Custom event to add variables to template
		$dispatcher->addListener('core.user_setup_after', 	array($this, 'user_setup_after'),	99); // Make sure it is loaded first
		$dispatcher->addListener('core.page_footer', 		array($this, 'page_footer'),		-10);
		$dispatcher->addListener('core.adm_page_footer', 	array($this, 'page_footer'),		-10);
	}
	
	public function user_setup_after()
	{
		// Set Core template directories
		$this->template->add_custom_namespace('canidev_core', $this->phpbb_root_path . 'ext/canidev/core/', true);
		$this->template->assign_var('CANIDEV_CORE_STARTED', true);
	}
	
	public function page_footer()
	{
		$is_admin	= defined('IN_ADMIN');
		$js_events 	= array();

		foreach($this->items as $namespace => $null)
		{
			if($event_string = $this->get_js_events($namespace, $is_admin))
			{
				$js_events[] = $event_string;
			}
		}
		
		$this->template->assign_vars(array(
			'PHPBB_BRANCH'			=> str_replace('.', '', substr(PHPBB_VERSION, 0, 3)) . 'x',
		));
		
		// Add core assets
		$this->template->prepend_assets = true;
		$this->template->append_asset('css', '@canidev_core/../theme/cbbcore.css');
		$this->template->append_asset('script', array(
			'type'		=> 'text/javascript',
			'content'	=> implode("\n", $js_events),
		));
		$this->template->append_asset('js', '@canidev_core/js/cbbcore.min.js');
		$this->template->assets_to_template();
	}
	
	/* List all the groups for the current user */
	public function get_user_groups()
	{
		if(empty($this->user->data['group_ary']))
		{
			$this->user->data['group_ary'] = array();

			$sql = 'SELECT group_id
				FROM ' . USER_GROUP_TABLE . '
				WHERE user_id = ' . (int)$this->user->data['user_id'] . '
				AND user_pending = 0';
			$result = $this->db->sql_query($sql);
			while($row = $this->db->sql_fetchrow($result))
			{
				$this->user->data['group_ary'][] = (int)$row['group_id'];
			}
			$this->db->sql_freeresult($result);
		}
		
		return $this->user->data['group_ary'];
	}
	
	public function group_auth($valid_groups, $check_groups = false)
	{
		$check_groups	= ($check_groups === false) ? $this->get_user_groups() : $check_groups;
		$check_groups	= (is_array($check_groups) ? $check_groups : explode(',', $check_groups));
		$group_ary		= (is_array($valid_groups) ? $valid_groups : explode(',', $valid_groups));

		if($valid_groups == 'all' || sizeof(array_intersect($group_ary, $check_groups)))
		{
			return true;
		}
		
		return false;
	}
	
	public function get_data($file, $process = false)
	{
		$filename = $this->phpbb_root_path . 'ext/canidev/core/data/' . $file;
		$output = @file_get_contents($filename);
		
		if($process)
		{
			$output = preg_replace_callback('#\{L_([A-Z0-9_\-]+)\}#', function($matches) {
				return $this->lang->is_set($matches[1]) ? $this->lang->lang($matches[1]) : '';
			}, $output);
		}

		return $output;
	}
	
	private function get_js_events($namespace, $is_admin)
	{
		$js_code = array();

		foreach($this->items[$namespace] as $item)
		{
			if($item->is_runnable())
			{
				$events = (!$is_admin) ? $item->frontend_js_events() : $item->admin_js_events();
				
				if(sizeof($events))
				{
					foreach($events as $event_name => $code)
					{
						$js_code[] = "cbbCore.addListener('$event_name'," . str_replace(array("\n", "\t", '{ ', ' }'), array('', '', '{', '}'), $code) . ');';
					}
				}
			}
		}
		
		if(sizeof($js_code))
		{
			array_unshift($js_code, "\n/* " . $namespace . ' */');
		}
		
		return trim(implode("\n", $js_code));
	}
	
	static public function get_instance($container)
	{
		if(!self::$instance)
		{
			self::$instance = new self($container);
		}

		return self::$instance;
	}
}
