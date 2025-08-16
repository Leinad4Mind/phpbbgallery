<?php
/*
* @package Ext Common Core
* @version v1.0.16 22/04/2022
*
* @copyright (c) 2022 CaniDev
* @license https://creativecommons.org/licenses/by-nc/4.0/
*/

namespace canidev\core;

use Symfony\Component\DependencyInjection\ContainerInterface;

class lib
{
	const VERSION		= '1.0.16';
	
	private $items				= array();
	private $langkeys			= array();
	private $in_acp_extensions 	= false;
	
	private $config;
	private $container;
	private $db;
	private $dispatcher;
	private $language;
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
		$this->container 		= $container;
		$this->db				= $container->get('dbal.conn');
		$this->dispatcher 		= $container->get('dispatcher');
		$this->language			= $container->get('language');
		$this->request 			= $container->get('request');
		$this->template			= template::get_instance($container);
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
		$this->dispatcher->addListener('core.user_setup_after', 				array($this, 'user_setup_after'),	99); // Make sure it is loaded first
		$this->dispatcher->addListener('core.page_footer', 						array($this, 'page_footer'),		-10);
		$this->dispatcher->addListener('core.adm_page_footer', 					array($this, 'adm_page_footer'),	-10);
		$this->dispatcher->addListener('core.append_sid',						array($this, 'fix_controller_urls'));
		$this->dispatcher->addListener('core.acp_extensions_run_action',		array($this, 'check_acp_extensions_module')); // for phpBB < 3.2.1
		$this->dispatcher->addListener('core.acp_extensions_run_action_before',	array($this, 'check_acp_extensions_module')); // for phpBB >= 3.2.1
		
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
		
		$this->template->assign_var('PHPBB_BRANCH', str_replace('.', '', substr(PHPBB_VERSION, 0, 3)) . 'x');
		
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

	public function check_acp_extensions_module()
	{
		$this->in_acp_extensions = true;
	}

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

			$module_ary = $this->container->get('cache')->get('_modules_acp');
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
			$text 	= $event['text'];
			$flags 	= $event['flags'];
			$finder = dom::string_to_xpath($text);

			if($finder === false)
			{
				return $text;
			}
			
			/*
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
				return $this->language->is_set($matches[1]) ? $this->language->lang($matches[1]) : '';
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
				$new_ary[$key] = $this->language->lang($key);
			}

			return $this->set_js_lang($new_ary);
		}

		$this->langkeys = array_merge($this->langkeys, $ary);

		if($this->request->is_ajax())
		{
			\canidev\core\json_response::get_instance()->add_component('lang', $this->langkeys);
		}
	}

	/*
	 * modal_dialog (only ajax)
	*/
	public function modal_dialog($check, $title = '', $hidden = array(), $html_body = 'confirm_body.html', $u_action = '')
	{
		if(!$this->request->is_ajax())
		{
			return false;
		}

		$path_helper 	= $this->container->get('path_helper');
		$confirm 		= $this->request->variable('confirm', false, false, \phpbb\request\request_interface::POST);

		if($check)
		{
			$user_id 		= $this->request->variable('confirm_uid', 0);
			$session_id 	= $this->request->variable('sess', '');

			if(!$confirm || $user_id != $this->user->data['user_id'] || $session_id != $this->user->session_id)
			{
				return false;
			}

			return true;
		}

		$hidden = array_merge($hidden, array(
			'confirm_uid'	=> $this->user->data['user_id'],
			'sess'			=> $this->user->session_id,
			'sid'			=> $this->user->session_id,
		));

		$title = (!$this->language->is_set($title)) ? $this->language->lang('CONFIRM') : $this->language->lang($title);

		if(defined('IN_ADMIN') && isset($this->user->data['session_admin']) && $this->user->data['session_admin'])
		{
			adm_page_header($title);
		}
		else
		{
			page_header($title);
		}

		$this->template->set_filenames(array(
			'body' => $html_body
		));

		// re-add sid / transform & to &amp; for user->page (user->page is always using &)
		$use_page = ($u_action) ? $u_action : str_replace('&', '&amp;', $this->user->page['page']);
		$u_action = reapply_sid($path_helper->get_valid_page($use_page, $this->config['enable_mod_rewrite']));

		$this->template->assign_vars(array(
			'MESSAGE_TITLE'		=> $title,
			'MESSAGE_TEXT'		=> (!$this->language->is_set($title . '_CONFIRM')) ? $title : $this->language->lang($title . '_CONFIRM'),

			'YES_VALUE'			=> $this->language->lang('YES'),
			'S_CONFIRM_ACTION'	=> $u_action,
			'S_HIDDEN_FIELDS'	=> build_hidden_fields($hidden),
			'S_AJAX_REQUEST'	=> true,
		));

		$response = \canidev\core\json_response::get_instance();
		$response->send(array(
			'isModalDialog'		=> true,
			
			'MESSAGE_BODY'		=> $this->template->assign_display('body'),
			'MESSAGE_TITLE'		=> $title,
			'MESSAGE_TEXT'		=> (!$this->language->is_set($title . '_CONFIRM')) ? $title : $this->language->lang($title . '_CONFIRM'),

			'YES_VALUE'			=> $this->language->lang('YES'),
			'S_CONFIRM_ACTION'	=> str_replace('&amp;', '&', $u_action),
			'S_HIDDEN_FIELDS'	=> build_hidden_fields($hidden),
		));
	}
	
	static public function get_instance($container = null)
	{
		if(!self::$instance && $container !== null)
		{
			self::$instance = new self($container);
		}

		return self::$instance;
	}
}
