<?php
/*
* @package Ext Common Core
* @version v1.0.8 12/01/2021
*
* @copyright (c) 2021 CaniDev
* @license https://opensource.org/licenses/gpl-license.php GNU Public License
*/

namespace canidev\core;

// @ignore
if(!defined('IN_PHPBB'))
{
	exit;
}

use Symfony\Component\DependencyInjection\ContainerInterface;

class template
{
	public $prepend_assets = false;

	protected $assets 			= array();
	protected $assets_cache		= array();
	protected $context_ary		= array();

	protected $config;
	protected $container;
	protected $filesystem;
	protected $path_helper;
	protected $phpbb_template;
	protected $request;
	protected $twig;
	
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
		$this->config			= $container->get('config');
		$this->container 		= $container;
		$this->filesystem 		= $container->get('filesystem');
		$this->path_helper		= $container->get('path_helper');
		$this->phpbb_template	= $container->get('template');
		$this->request 			= $container->get('request');
		$this->twig				= $container->get('template.twig.environment');
	}
	
	public function __call($name, $args)
	{
		if(method_exists($this->phpbb_template, $name))
		{
			return call_user_func_array(array($this->phpbb_template, $name), $args);
		}
		
		return false;
	}
	
	public function add_custom_namespace($namespace, $path, $add_style_paths = true)
	{
		if(!file_exists($path))
		{
			return;
		}

		$this->twig->getLoader()->addSafeDirectory($path);

		if($add_style_paths)
		{
			$style_ary	= array_merge($this->phpbb_template->get_user_style(), array('all'));
			$path_ary	= array();

			foreach($style_ary as $style_path)
			{
				$style_template_path 	= $path . 'styles/' . $style_path . '/template/';
				$style_theme_path		= $path . 'styles/' . $style_path . '/theme/';
				
				if(file_exists($style_template_path))
				{
					$path_ary[] = $style_template_path;
				}
				
				if(file_exists($style_theme_path))
				{
					$path_ary[] = $style_theme_path;
				}
			}

			$path_ary[] =  $path . 'plugins/';

			if(sizeof($path_ary))
			{
				$this->twig->getLoader()->setPaths($path_ary, $namespace);
			}
		}
	}

	public function append_asset($type, $data, $return_filename = false, $space = 'common')
	{
		// Recursive
		if(is_array($data) && isset($data[0]))
		{
			foreach($data as $item)
			{
				$this->append_asset($type, $item, $return_filename, $space);
			}
			return;
		}

		// Don't load admin assets in normal styles and vice versa
		if(($space == 'admin' && !defined('IN_ADMIN')) || ($space == 'frontend' && defined('IN_ADMIN')))
		{
			return false;
		}

		$namespace 	= 'all';
		$is_single	= false;
		
		if(strpos($type, '.') !== false)
		{
			list($namespace, $type) = explode('.', $type, 2);
		}
		
		if(!is_array($data))
		{
			$data = array('content' => $data);
		}
		
		$data = array_merge(
			array(
				'id'		=> '',
				'type'		=> '',
			),
			$data
		);

		switch($type)
		{
			case 'css':
				$data['rel'] = 'stylesheet';
				
			// no break

			case 'js':
				$asset_url = $data['content'];

				if(!isset($this->assets_cache[$asset_url]))
				{
					$asset = new \phpbb\template\asset($asset_url, $this->path_helper, $this->filesystem);
					
					if(substr($asset_url, 0, 2) == './')
					{
						$root_path = $this->path_helper->get_phpbb_root_path();

						$data['content'] = $this->assets_cache[$asset_url] = $root_path . substr($asset->get_url(), 2);
					}
					else if($asset->is_relative())
					{
						$asset_path = $asset->get_path();
						$local_file = $this->path_helper->get_phpbb_root_path() . $asset_path;

						if(!file_exists($local_file))
						{
							if(!($local_file = $this->find_asset($asset_path, ($space == 'admin'))))
							{
								return false;
							}
							
							$asset->set_path($local_file, true);
							$asset->add_assets_version($this->config['assets_version']);

							$data['content'] = $this->assets_cache[$asset_url] = $asset->get_url();
						}
					}
					
					unset($asset);
				}
				else
				{
					$data['content'] = $this->assets_cache[$asset_url];
				}
				
				// If we only need the asset url, return here
				if($return_filename)
				{
					return $data['content'];
				}
				
				$is_single	= true;
				$file_key	= ($type == 'js') ? 'src' : 'href';

				$data[$file_key] 	= $data['content'];
				$data['content']	= '';

			// no break
			
			case 'javascript':
				if($type == 'javascript' || $type == 'js')
				{
					$data['type']	= 'text/javascript';
					$type			= 'script';
				}
				
			// no break

			case 'style':
			case 'script':
				if(!isset($this->assets[$namespace][$type]))
				{
					if(!isset($this->assets[$namespace]))
					{
						$this->assets[$namespace] = array();
					}

					$this->assets[$namespace][$type] = array();
				}
				else if($data['id'] || $is_single)
				{
					// Check, if the asset is already loaded, don't load it again
					foreach($this->assets[$namespace][$type] as $row)
					{
						if(($data['id'] && $row['ID'] == $data['id']) ||
							($is_single && isset($row['SRC']) && $row['SRC'] == $data[$file_key]))
						{
							return false;
						}
					}
				}
				
				$params = array();
				
				foreach($data as $key => $value)
				{
					if($key != 'content' && $value && $value != 'text/javascript')
					{
						$params[] = $key . '="' . $value . '"';
					}
				}
				
				if($data['content'])
				{
					if($data['type'] == 'text/javascript')
					{
						$data['content'] = "// <![CDATA[\n" . $data['content'] . "\n// ]]>";
					}
				
					$data['content'] = "\n" . trim($data['content']) . "\n";
				}
				else if(!$is_single)
				{
					break;
				}
				
				$new_asset = array(
					'ID'		=> $data['id'],
					'DATA'		=> $data['content'] ,
					'PARAMS'	=> implode(' ', $params),
					'IS_SINGLE'	=> $is_single,
					'TYPE'		=> $data['type'],
					'SRC'		=> ($is_single) ? $data[$file_key] : '',
				);

				$function = ($this->prepend_assets) ? 'array_unshift' : 'array_push';

				$function($this->assets[$namespace][$type], $new_asset);

				if($this->request->is_ajax())
				{
					\canidev\core\json_response::get_instance()->add_component('asset', $new_asset);
				}
			break;
			
			default:
				return false;
		}
	}
	
	public function assets_to_template($namespace = 'all')
	{
		if(!isset($this->assets[$namespace]))
		{
			return false;
		}

		foreach($this->assets[$namespace] as $asset_type => $rows)
		{
			$key = 'core_' . (($namespace == 'all') ? '' : $namespace . '_') . $asset_type;
			
			foreach($rows as $row)
			{
				$this->phpbb_template->assign_block_vars($key, $row);
			}
		}
	}
	
	public function assign_vars(array $vars)
	{
		$this->phpbb_template->assign_vars($vars);
		$this->context_ary = array_merge($this->context_ary, $vars);
	}

	public function assign_json_var($key, $options)
	{
		$options = array_map(
			function($item) {
				if(is_string($item))
				{
					return htmlspecialchars_decode($item);
				}

				return $item;
			},
			$options
		);

		$this->assign_var($key, json_encode($options));
	}
	
	public function get_var($name, $default = '')
	{
		return (isset($this->context_ary['.'][0][$name]) ? $this->context_ary['.'][0][$name] : $default);
	}
	
	public function load_context($phpbb_container)
	{
		$this->context_ary = $phpbb_container->get('template_context')->get_data_ref();
		return $this->context_ary;
	}
	
	public function render($id, $filename, $return = false)
	{
		$this->phpbb_template->set_filenames(array(
			$id		=> $filename
		));
		
		if($return)
		{
			return $this->phpbb_template->assign_display($id, null, true);
		}

		$this->phpbb_template->display($id);
	}
	
	private function find_asset($path, $is_admin = false)
	{
		$paths = array();

		if(strpos($path, '@') === 0)
		{
			$uri = preg_replace_callback('#^@([A-Za-z\_0-9]+)/#', function($match) {
					return '%1$sext/' . str_replace('_', '/', $match[1]) . '/%2$s/';
				}, $path);
		}
		else
		{
			$uri = '%1$s%2$s/' . $path;
		}
		
		if($is_admin)
		{
			$filename = sprintf($uri, $this->path_helper->get_phpbb_root_path(), 'adm/style');
			
			if(file_exists($filename))
			{
				return $filename;
			}
		}

		if(!defined('IN_ADMIN'))
		{
			$paths = $this->phpbb_template->get_user_style();
		}

		$paths[] = 'all';
			
		foreach($paths as $style_path)
		{
			$filename = sprintf($uri, $this->path_helper->get_phpbb_root_path(), 'styles/' . $style_path . '/template');

			if(file_exists($filename))
			{
				return $filename;
			}
		}
		
		// For "core" search in compatibility path too
		if(strpos($path, '@canidev_core') === 0)
		{
			$filename = sprintf($uri, $this->path_helper->get_phpbb_root_path(), 'compatibility');

			if(file_exists($filename))
			{
				return $filename;
			}
		}

		return false;
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
