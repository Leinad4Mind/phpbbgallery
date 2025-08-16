<?php

namespace canidev\blockgets\libraries;

class template
{
	public $prepend_assets = false;

	protected $assets 			= array();
	protected $context_ary		= array();

	protected $config;
	protected $filesystem;
	protected $path_helper;
	protected $phpbb_template;

	/**
	* Constructor
	*
	* @param \phpbb\config\config 				$config				Config Object
	* @param \phpbb\filesystem					$filesystem			Filesystem Object
	* @param \phpbb\path_helper					$path_helper		Path Helper Object
	* @param \phpbb\template\template			$template     		Template object
	*
	* @access public
	*/
	public function __construct(\phpbb\config\config $config, $filesystem, \phpbb\path_helper $path_helper, \phpbb\template\template $template)
	{
		$this->config			= $config;
		$this->filesystem 		= $filesystem;
		$this->path_helper		= $path_helper;
		$this->phpbb_template	= $template;
	}
	
	public function __call($name, $args)
	{
		if(method_exists($this->phpbb_template, $name))
		{
			return call_user_func_array(array($this->phpbb_template, $name), $args);
		}
		
		return false;
	}

	public function append_asset($type, $data, $space = 'common', $return_filename = false)
	{
		// Don't load admin assets in normal styles and vice versa
		if(($space == 'admin' && !defined('IN_ADMIN')) || ($space == 'frontend' && defined('IN_ADMIN')))
		{
			return false;
		}
		
		$asset_id		= '';
		$asset_data		= $data;
		$asset_media 	= '';
		
		if(is_array($data))
		{
			$asset_id		= $data[0];
			$asset_data		= $data[1];
			$asset_media	= (isset($data[2]) ? $data[2] : '');
		}

		switch($type)
		{
			case 'css':
			case 'js':
				$asset = new \phpbb\template\asset($asset_data, $this->path_helper, $this->filesystem);
				
				if(substr($asset_data, 0, 2) !== './' && $asset->is_relative())
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
						$asset_data = $asset->get_url();
					}
				}
				
				unset($asset);
				
				// If we only need the asset url, return here
				if($return_filename)
				{
					return $asset_data;
				}
				
				// Check, if the asset is already loaded, don't load it again
				if(isset($this->assets[$type]))
				{
					foreach($this->assets[$type] as $row)
					{
						if($row['DATA'] == $asset_data)
						{
							return false;
						}
					}
				}

			// no break
			
			case 'javascript':
			case 'style':
				if(!isset($this->assets[$type]))
				{
					$this->assets[$type] = array();
				}
				
				$params = '';
				$params .= ($asset_id) ? ' id="' . $asset_id . '"' : '';
				$params .= ($asset_media) ? ' media="' . $asset_media . '"' : '';
				
				$new_asset = array(
					'DATA'		=> trim($asset_data),
					'PARAMS'	=> $params,
				);

				if($this->prepend_assets)
				{
					array_unshift($this->assets[$type], $new_asset);
					break;
				}

				$this->assets[$type][] = $new_asset;
			break;
			
			default:
				return false;
		}
	}
	
	public function assets_to_template()
	{
		foreach($this->assets as $asset_type => $rows)
		{
			foreach($rows as $row)
			{
				$this->phpbb_template->assign_block_vars("asset_$asset_type", $row);
			}
		}
	}
	
	public function assign_vars(array $vars)
	{
		$this->phpbb_template->assign_vars($vars);
		$this->context_ary = array_merge($this->context_ary, $vars);
	}
	
	public function get_var($name, $default = '')
	{
		return (isset($this->context_ary[$name]) ? $this->context_ary[$name] : $default);
	}
	
	public function load_context($phpbb_container)
	{
		$this->context_ary = $phpbb_container->get('template_context')->get_root_ref();
	}
	
	private function find_asset($path, $is_admin = false)
	{
		if(strpos($path, '@') === 0)
		{
			$uri = preg_replace_callback('#^@([A-Za-z\_0-9]+)/#', function($match) {
					return '%1$sext/' . str_replace('_', '/', $match[1]) . '/%2$s/';
				}, $path);
		}
		else
		{
			$uri = '%1$sext/canidev/blockgets/%2$s/' . $path;
		}
		
		if($is_admin)
		{
			$filename = sprintf($uri, $this->path_helper->get_phpbb_root_path(), 'adm/style');
			
			if(file_exists($filename))
			{
				return $filename;
			}
		}
		
		$paths = array_merge($this->phpbb_template->get_user_style(), array('all'));
			
		foreach($paths as $style_path)
		{
			$filename = sprintf($uri, $this->path_helper->get_phpbb_root_path(), 'styles/' . $style_path . '/template');

			if(file_exists($filename))
			{
				return $filename;
			}
		}

		return false;
	}
}
