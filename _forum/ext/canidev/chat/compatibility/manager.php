<?php
/*
* @name manager.php
* @package cBB Chat
* @version v1.1.3 10/03/2017
*
* @copyright (c) 2017 CaniDev
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/

namespace canidev\chat\compatibility;

// @ignore
if(!defined('IN_PHPBB'))
{
	exit;
}

class manager
{
	private $items = array();
	
	private $cache;
	private $dispatcher;
	private $phpbb_root_path;
	private $php_ext;

	/**
	* Constructor
	*
	* @param \phpbb\cache\driver\driver_interface 	$cache 				Cache instance
	* @param \phpbb\event\dispatcher_interface		$phpbb_dispatcher	Event dispatcher
	* @param \phpbb\extension\manager 				$extension_manager	extension manager
	* @param string									$root_path			phpBB root path
	* @param string									$php_ext			phpEx
	*
	* @access public
	*/
	public function __construct(\phpbb\cache\driver\driver_interface $cache, $phpbb_dispatcher, \phpbb\extension\manager $extension_manager, $root_path, $php_ext)
	{
		$this->cache			= $cache;
		$this->dispatcher		= $phpbb_dispatcher;
		$this->phpbb_root_path	= $root_path;
		$this->php_ext			= $php_ext;
		
		$ext_path = 'ext/canidev/chat/';
		
		if(($this->items = $this->cache->get('_chat_compatibility')) === false)
		{
			$this->items = array();

			// Get autoloaded plugins
			if($dir = @opendir($this->phpbb_root_path . $ext_path . 'compatibility/'))
			{
				while(($file = @readdir($dir)) !== false)
				{
					if(preg_match('#^([a-z0-9_\-]+)\.' . $this->php_ext . '$#i', $file, $match))
					{
						if($match[1] != 'manager' && $match[1] != 'base')
						{
							$this->items[] = $match[1];
						}
					}
				}
				closedir($dir);
			}
			
			$this->cache->put('_chat_compatibility', $this->items);
		}
		
		foreach($this->items as $id => $item)
		{
			$filename	= $this->phpbb_root_path . $ext_path . 'compatibility/' . $item . '.' . $this->php_ext;
			$class_name = '\\canidev\\chat\\compatibility\\' . $item;
			
			if(file_exists($filename) && class_exists($class_name))
			{
				$this->items[$id] = new $class_name($extension_manager);
			}
			else
			{
				unset($this->items[$id]);
			}
		}
	}
	
	public function get_core_events()
	{
		foreach($this->items as $item)
		{
			if($item->is_runnable())
			{
				foreach($item->get_core_events() as $event_name => $params)
				{
					if(is_string($params))
					{
						$this->dispatcher->addListener($event_name, array($item, $params));
					}
					else if(is_string($params[0]))
					{
						$this->dispatcher->addListener($event_name, array($item, $params[0]), isset($params[1]) ? $params[1] : 0);
					}
					else
					{
						foreach($params as $listener)
						{
							$this->dispatcher->addListener($event_name, array($item, $listener[0]), isset($listener[1]) ? $listener[1] : 0);
						}
					}
				}
			}
		}
	}
	
	public function get_js_events()
	{
		$js_code = array();

		foreach($this->items as $item)
		{
			if($item->is_runnable())
			{
				$events = $item->get_js_events();
				
				if(sizeof($events))
				{
					$js_code[] = "\n/* " . $item->name . ' */';

					foreach($events as $event_name => $code)
					{
						$js_code[] = "$.cbbEvent.addListener('$event_name'," . str_replace(array("\n", "\t", '{ ', ' }'), '', $code) . ');';
					}
				}
			}
		}
		
		return implode("\n", $js_code);
	}
}
