<?php
/*
* @name lib.php
* @package Ext Common Core
* @version v1.0.0 01/03/2018
*
* @copyright (c) 2018 CaniDev
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/

namespace canidev\core;

// @ignore
if(!defined('IN_PHPBB'))
{
	exit;
}

class lib
{
	private $items		= array();
	private $js_version	= '1.0.0';
	
	private $db;
	private $template;
	private $user;
	
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
		$cache 				= $container->get('cache.driver');
		$dispatcher 		= $container->get('dispatcher');
		$phpbb_root_path	= $container->getParameter('core.root_path');
		$php_ext			= $container->getParameter('core.php_ext');
		$compatibility_path = 'canidev/core/compatibility/';
		
		$this->db			= $container->get('dbal.conn');
		$this->template		= $container->get('template');
		$this->user			= $container->get('user');

		// Get additional addons for the extensions
		if(($this->items = $cache->get('_cbbext_compatibility')) === false)
		{
			$this->items = array();

			$directory	= new \RecursiveDirectoryIterator($phpbb_root_path . 'ext/' . $compatibility_path);
			$iterator	= new \RecursiveIteratorIterator($directory);
			$regex		= new \RegexIterator($iterator, '/([a-z0-9_\-]+)\.' . $php_ext . '$/i');

			foreach($regex as $file)
			{
				$basename = $file->getBasename('.' . $php_ext);
				
				if($basename == 'base')
				{
					continue;
				}
					
				$path = $file->getPathInfo()->getBasename();
				
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
				$filename	= $phpbb_root_path . 'ext/' . $fullname . ".$php_ext";
				$class_name = '\\' . str_replace('/', '\\', $fullname);
				
				if(!file_exists($filename) || !class_exists($class_name))
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
							$dispatcher->addListener($event_name, array($item, $params));
						}
						else if(is_string($params[0]))
						{
							$dispatcher->addListener($event_name, array($item, $params[0]), isset($params[1]) ? $params[1] : 0);
						}
						else
						{
							foreach($params as $listener)
							{
								$dispatcher->addListener($event_name, array($item, $listener[0]), isset($listener[1]) ? $listener[1] : 0);
							}
						}
					}
				}
			}
		}
		
		// Custom event to add variables to template
		$dispatcher->addListener('core.page_footer', 		array($this, 'page_footer'));
		$dispatcher->addListener('core.adm_page_footer', 	array($this, 'page_footer'));
	}
	
	public function page_footer()
	{
		$is_admin = defined('IN_ADMIN');

		foreach($this->items as $namespace => $null)
		{
			if($event_string = $this->get_js_events($namespace, $is_admin))
			{
				$this->template->assign_var(strtoupper($namespace) . '_JS_EVENTS', $event_string);
			}
		}

		$this->template->assign_vars(array(
			'CBBCORE_JS_FILENAME'	=> generate_board_url() . '/ext/canidev/core/assets/js/cbbcore.' . $this->js_version . '.min.js',
			'PHPBB_BRANCH'			=> str_replace('.', '', substr(PHPBB_VERSION, 0, 3)) . 'x',
		));
	}
	
	/* List all the groups for the current user */
	public function get_user_groups()
	{
		if(empty($this->user->data['group_ary']))
		{
			$this->user->data['group_ary'] = array();

			$sql = 'SELECT group_id
				FROM ' . USER_GROUP_TABLE . '
				WHERE user_id = ' . $this->user->data['user_id'];
			$result = $this->db->sql_query($sql);
			while($row = $this->db->sql_fetchrow($result))
			{
				$this->user->data['group_ary'][] = (int)$row['group_id'];
			}
			$this->db->sql_freeresult($result);
		}
		
		return $this->user->data['group_ary'];
	}
	
	public function group_auth($groups)
	{
		$user_groups	= $this->get_user_groups();
		$group_ary		= (is_array($groups) ? $groups : explode(',', $groups));

		if($groups == 'all' || sizeof(array_intersect($group_ary, $user_groups)))
		{
			return true;
		}
		
		return false;
	}
	
	public function set_js_version($version)
	{
		// Always use the major version
		if(version_compare($version, $this->js_version, '>'))
		{
			$this->js_version = $version;
		}
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
					$js_code[] = "\n/* " . $item->name . ' */';

					foreach($events as $event_name => $code)
					{
						$js_code[] = "cbbCore.addListener('$event_name'," . str_replace(array("\n", "\t", '{ ', ' }'), array('', '', '{', '}'), $code) . ');';
					}
				}
			}
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
