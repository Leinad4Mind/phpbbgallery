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

class lib
{
	const VERSION		= '1.0.5';
	
	private $items		= array();
	private $langkeys	= array();
	
	private $config;
	private $db;
	private $dispatcher;
	private $lang;
	private $request;
	private $template;
	private $user;
	private $phpbb_root_path;
	private $php_ext;
	
	static $instance;

	/**
	* Constructor
	*
	* @param ContainerInterface 	$container		Service container interface
	*
	* @access public
	*/
	public function __construct(ContainerInterface $container)
	{
		$cache 			= $container->get('cache.driver');
		$plugins_path 	= 'canidev/core/plugins/';

		$this->config			= $container->get('config');
		$this->db				= $container->get('dbal.conn');
		$this->dispatcher 		= $container->get('dispatcher');
		$this->lang				= $container->get('language');
		$this->request 			= $container->get('request');
		$this->template			= \canidev\core\template::get_instance($container);
		$this->user				= $container->get('user');
		$this->phpbb_root_path	= $container->getParameter('core.root_path');
		$this->php_ext			= $container->getParameter('core.php_ext');

		// Get additional addons for the extensions
		if(($this->items = $cache->get('_cbbext_plugins')) === false)
		{
			$this->items = array();

			$base_path	= $this->phpbb_root_path . 'ext/' . $plugins_path;
			$directory	= new \RecursiveDirectoryIterator($base_path);
			$iterator	= new \RecursiveIteratorIterator($directory);
			$regex		= new \RegexIterator($iterator, '/([a-z0-9_\-]+)\.' . $this->php_ext . '$/i');

			foreach($regex as $file)
			{
				$basename = $file->getBasename('.' . $this->php_ext);
				
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

			$cache->put('_cbbext_plugins', $this->items);
		}
		
		// Initialize items and parse core events
		foreach($this->items as $namespace => $items)
		{
			foreach($items as $id => $item)
			{
				$fullname	= $plugins_path . $namespace . '/' . $item;
				$filename	= $this->phpbb_root_path . 'ext/' . $fullname . ".$this->php_ext";
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
							$this->dispatcher->addListener($event_name, array($item, $params), -1);
						}
						else if(is_string($params[0]))
						{
							$this->dispatcher->addListener($event_name, array($item, $params[0]), isset($params[1]) ? $params[1] : -1);
						}
						else
						{
							foreach($params as $listener)
							{
								$this->dispatcher->addListener($event_name, array($item, $listener[0]), isset($listener[1]) ? $listener[1] : -1);
							}
						}
					}
				}
			}
		}
	
		// Custom events
		$this->dispatcher->addListener('core.user_setup_after', 	array($this, 'user_setup_after'),	99); // Make sure it is loaded first
		$this->dispatcher->addListener('core.page_footer', 			array($this, 'page_footer'),		-10);
		$this->dispatcher->addListener('core.adm_page_footer', 		array($this, 'page_footer'),		-10);
		$this->dispatcher->addListener('core.append_sid',			array($this, 'fix_controller_urls'));
		
		$this->dispatcher->addListener('core.modify_text_for_display_after',	array($this, 'modify_text_for_display'));
		$this->dispatcher->addListener('core.modify_format_display_text_after',	array($this, 'modify_text_for_display'));
	}
	
	public function user_setup_after()
	{
		$this->user->add_lang_ext('canidev/core', 'main');

		// Set Core template directories
		$this->template->add_custom_namespace('canidev_core', $this->phpbb_root_path . 'ext/canidev/core/', true);
		$this->template->assign_var('CANIDEV_CORE_STARTED', true);
	}
	
	public function page_footer()
	{
		$is_admin	= defined('IN_ADMIN');
		$js_events 	= array();

		// Execute ajax request
		if($this->request->is_ajax())
		{
			$json_request = json_response::get_instance();

			if($json_request->is_requested())
			{
				$json_request
					->add_html($this->template->assign_display('body'))
					->send();
			}
		}

		foreach($this->items as $namespace => $null)
		{
			if($event_string = $this->get_js_events($namespace, $is_admin))
			{
				$js_events[] = $event_string;
			}
		}
		
		$this->template->assign_vars(array(
			'PHPBB_BRANCH'	=> str_replace('.', '', substr(PHPBB_VERSION, 0, 3)) . 'x',
		));
		
		// Add core assets
		$this->template->prepend_assets = true;
		$this->template->append_asset('css', '@canidev_core/../theme/cbbcore.css');

		$this->template->append_asset('script', array(
			'type'		=> 'text/javascript',
			'content'	=> implode("\n", $js_events),
		));

		$this->template->append_asset('js', '@canidev_core/js/cbbcore.min.js');

		if(sizeof($this->langkeys))
		{
			$this->template->append_asset('script', array(
				'id'		=> 'core-lang',
				'type'		=> 'application/json',
				'content'	=> json_encode($this->langkeys, JSON_PRETTY_PRINT),
			));
		}

		$this->template->assets_to_template();
	}
	
	public function fix_controller_urls($event)
	{
		// In some strange cases, the url is not formed correctly, doubling "app.php" so, we fix it.
		if(!$this->config['enable_mod_rewrite'] && substr_count($event['url'], 'app.') > 1)
		{
			$event['url'] = preg_replace('#(app\.' . $this->php_ext . '/){2,}#', '$1', $event['url']);
		}
	}
	
	public function modify_text_for_display($event)
	{
		if($this->dispatcher->hasListeners('canidev.core.modify_text_for_display'))
		{
			$dom	= new \DOMDocument('1.0', 'utf-8');
			$text	= $event['text'];
		
			if(!$dom->loadXML('<div>' . $text . '</div>', LIBXML_NOCDATA | LIBXML_NOWARNING | LIBXML_NOERROR))
			{
				return $text;
			}

			$finder = new \DomXPath($dom);
			
			/*
			* @event canidev.core.modify_text_for_display
			* @var	DomXPath		$finder		XPath Object
			* @var	string			$text		Original Post Text (Read Only)
			* @since 1.0.4
			*/
			$vars = array('finder', 'text');
			extract($this->dispatcher->trigger_event('canidev.core.modify_text_for_display', compact($vars)));
			
			$event['text'] = preg_replace('#(^<div>|</div>$)#', '', $dom->saveXML($dom->documentElement));
		}
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

	public function set_js_lang($ary)
	{
		if(array_keys($ary) === range(0, count($ary) - 1))
		{
			$new_ary = array();

			foreach($ary as $key)
			{
				$new_ary[$key] = $this->lang->lang($key);
			}

			return $this->set_js_lang($new_ary);
		}

		$this->langkeys = array_merge($this->langkeys, $ary);

		if($this->request->is_ajax())
		{
			\canidev\core\json_response::get_instance()->add_component('lang', $this->langkeys);
		}
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
