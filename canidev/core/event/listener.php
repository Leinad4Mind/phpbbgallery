<?php
/**
* @package Ext Common Core
* @version 1.1.0 01/06/2022
*
* @copyright (c) 2022 CaniDev
* @license https://creativecommons.org/licenses/by-nc/4.0/
*/

namespace canidev\core\event;

use canidev\core\dom;
use canidev\core\json_response;
use canidev\core\constants;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class listener implements EventSubscriberInterface
{
	protected $cache;
	protected $config;
	protected $container;
	protected $dispatcher;
	protected $language;
	protected $request;
	protected $template;
	protected $user;

	protected $phpbb_root_path;
	protected $php_ext;

	private $items				= array();
	private $in_acp_extensions 	= false;

	/**
	 * Constructor
	 * 
	 * @param \phpbb\cache\driver\driver_interface 							$cache 				Cache instance
	 * @param \phpbb\config\config 											$config				Config Object
	 * @param \Symfony\Component\DependencyInjection\ContainerInterface 	$container			Service container interface
	 * @param \phpbb\event\dispatcher_interface								$dispatcher			Event dispatcher
	 * @param \phpbb\language\language 										$language			Language Object
	 * @param \phpbb\request\request 										$request			Request object
	 * @param \canidev\core\template 										$template 			Core Template object
	 * @param \phpbb\user													$user				User object
	 * @param string														$root_path			phpBB root path
	 * @param string														$php_ext			phpEx
	 */
	public function __construct(
		\phpbb\cache\driver\driver_interface $cache,
		\phpbb\config\config $config,
		\Symfony\Component\DependencyInjection\ContainerInterface  $container,
		\phpbb\event\dispatcher_interface $dispatcher,
		\phpbb\language\language $language,
		\phpbb\request\request $request,
		\canidev\core\template $template,
		\phpbb\user $user,
		$phpbb_root_path,
		$php_ext
	)
	{
		$this->cache 		= $cache;
		$this->config 		= $config;
		$this->container 	= $container;
		$this->dispatcher 	= $dispatcher;
		$this->language 	= $language;
		$this->request 		= $request;
		$this->template 	= $template;
		$this->user 		= $user;

		$this->phpbb_root_path 	= $phpbb_root_path;
		$this->php_ext 			= $php_ext;
	}

	/**
	 * {@inheritDoc}
	 */
	static public function getSubscribedEvents()
	{
		return array(
			'core.common'								=> 'load_plugins',
			'core.user_setup_after' 					=> array('user_setup_after',	99), // Make sure it is loaded first
			'core.page_footer' 							=> array('page_footer',			-10),
			'core.adm_page_footer' 						=> array('adm_page_footer',		-10),
			'core.append_sid' 							=> 'fix_controller_urls',
			'core.acp_extensions_run_action' 			=> 'check_acp_extensions_module', // for phpBB < 3.2.1
			'core.acp_extensions_run_action_before' 	=> 'check_acp_extensions_module', // for phpBB >= 3.2.1

			'core.modify_text_for_display_after' 		=> 'modify_text_for_display',
			'core.modify_format_display_text_after' 	=> 'modify_text_for_display',
		);
	}

	/**
	 * Execute actions on admin footer
	 */
	public function adm_page_footer()
	{
		$this->page_footer();

		// Build links to extensions configurations
		if($this->in_acp_extensions)
		{
			$template_ary = $this->template->load_context($this->container);

			if(!isset($template_ary['enabled']))
			{
				return;
			}

			$module_ary = $this->cache->get('_modules_acp');
			$modules 	= array();

			if($module_ary !== false)
			{
				foreach($module_ary['modules'] as $row)
				{
					if(preg_match('#^\\\(canidev\\\[a-z_\-0-9]+)\\\acp\\\([a-z_\-0-9]+)$#', $row['module_basename'], $match))
					{
						$ext_key = str_replace('\\', '/', $match[1]);

						if(!isset($modules[$ext_key]))
						{
							$modules[$ext_key] = $match[2];
						}
					}
				}
			}

			foreach($template_ary['enabled'] as $ext_key => $ext_data)
			{
				if(isset($modules[$ext_data['NAME']]))
				{
					$this->template->alter_block_array(
						'enabled[' . $ext_key . '].actions',
						array(
							'ACTION_AJAX' 	=> 'false',
							'L_ACTION'		=> $this->language->lang('CONFIGURE'),
		                    'U_ACTION'	 	=> append_sid($this->phpbb_root_path . 'adm/index.' . $this->php_ext, 'i=-' . str_replace('/', '-', $ext_data['NAME']) . '-acp-' . $modules[$ext_data['NAME']], true, $this->user->session_id),
		                )
					);
				}
			}
		}
	}

	/**
	 * Workaround to check if the user is in acp extensions module
	 */
	public function check_acp_extensions_module()
	{
		$this->in_acp_extensions = true;
	}

	/**
	 * In some strange cases, the url is not formed correctly, doubling "app.php" so, we fix it.
	 * 
	 * @param \phpbb\event\data 	$event
	 */
	public function fix_controller_urls($event)
	{
		if(!$this->config['enable_mod_rewrite'] && substr_count($event['url'], 'app.') > 1)
		{
			$event['url'] = preg_replace('#(app\.' . $this->php_ext . '/){2,}#', '$1', $event['url']);
		}
	}

	/**
	 * Get additional plugins for the extensions
	 */
	public function load_plugins()
	{
		if(($this->items = $this->cache->get('_cbbext_plugins')) === false)
		{
			$this->items = array();

			$base_path	= $this->phpbb_root_path . 'ext/' . constants::PLUGINS_PATH;
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

			$this->cache->put('_cbbext_plugins', $this->items);
		}
		
		// Initialize items and parse core events
		foreach($this->items as $namespace => $items)
		{
			foreach($items as $id => $item)
			{
				$fullname	= constants::PLUGINS_PATH . $namespace . '/' . $item;
				$filename	= $this->phpbb_root_path . 'ext/' . $fullname . '.' . $this->php_ext;
				$class_name = '\\' . str_replace('/', '\\', $fullname);

				if(!file_exists($filename) || !class_exists($class_name))
				{
					unset($this->items[$namespace][$id]);
					continue;
				}
					
				$this->items[$namespace][$id] = $item = new $class_name($this->container);
				
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
	}

	/**
	 * Wordaround to modify text for posts with custom event
	 * 
	 * @param \phpbb\event\data 	$event
	 */
	public function modify_text_for_display($event)
	{
		if($this->dispatcher->hasListeners('canidev.core.modify_text_for_display'))
		{
			$text 	= $event['text'];
			$flags 	= $event['flags'];
			$finder = dom::string_to_xpath($text);

			if($finder === false)
			{
				return $text;
			}
			
			/**
			* @event canidev.core.modify_text_for_display
			* @var	DomXPath		finder		XPath Object
			* @var	string			text		Original Post Text (Read Only)
			* @var 	int				flags		The BBCode Flags
			* @since 1.0.4
			*/
			$vars = array('finder', 'text', 'flags');
			extract($this->dispatcher->trigger_event('canidev.core.modify_text_for_display', compact($vars)));

			$event['text'] = dom::xpath_to_string($finder);
		}
	}

	/**
	 * Do actions on footer
	 */
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
		
		$this->template->assign_var('PHPBB_BRANCH', str_replace('.', '', substr(PHPBB_VERSION, 0, 3)) . 'x');
		
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

	/**
	 * Load core language and namespace
	 */
	public function user_setup_after()
	{
		$this->language->add_lang('main', 'canidev/core');

		// Set Core template directories
		$this->template->add_custom_namespace('canidev_core', $this->phpbb_root_path . 'ext/canidev/core/', true);
		$this->template->assign_var('CANIDEV_CORE_STARTED', true);
	}

	/**
	 * Get javascript events of plugins
	 * 
	 * @param string 		$namespace 		Plugin namespace
	 * @param bool 			$is_admin 		Determine if load admin or frontend events
	 * 
	 * @return string
	 * @access private
	 */
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
}
