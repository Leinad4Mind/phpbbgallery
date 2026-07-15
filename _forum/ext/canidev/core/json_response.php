<?php
/*
* @package Ext Common Core
* @version v1.0.10 09/07/2021
*
* @copyright (c) 2021 CaniDev
* @license https://opensource.org/licenses/gpl-license.php GNU Public License
*/

namespace canidev\core;

/**
* JSON class
*/
class json_response
{
	const JSON_STATUS_ERROR		= 1;
	const JSON_STATUS_SUCCESS	= 2;

	protected $cache;

	static $instance;
	
	public function __construct()
	{
		$this->reset();
	}
	
	public function add($data)
	{
		foreach($data as $key => $value)
		{
			if(is_array($value) && isset($this->cache[$key]) && is_array($this->cache[$key]))
			{
				$this->cache[$key] = array_merge($this->cache[$key], $value);
				continue;
			}

			$this->cache[$key] = $value;
		}

		return $this;
	}

	public function add_component($type, $component)
	{
		if(!isset($this->cache['components'][$type]))
		{
			$this->cache['components'][$type] = array();
		}

		if($type == 'lang')
		{
			$this->cache['components'][$type] = array_merge($this->cache['components'][$type], $component);
			return;
		}

		$this->cache['components'][$type][] = $component;
	}
	
	public function add_html($html, $append = false)
	{
		if(!$append)
		{
			$this->cache['htmlContent'] = '';
		}
		
		$this->cache['htmlContent'] .= trim($html);
		
		return $this;
	}
	
	public function is_requested()
	{
		return (sizeof($this->cache) > 2);
	}
	
	public function reset()
	{
		$this->cache = array(
			'components'	=> array(),
			'htmlContent'	=> '',
		);
	}
	
	public function send($data = false, $ignore_html = false)
	{
		header('Content-Type: application/json');
		
		if($data !== false)
		{
			$this->add($data);
		}
		
		if($ignore_html)
		{
			unset($this->cache['htmlContent']);
		}

		if(!isset($this->cache['status']))
		{
			$this->cache['status'] = self::JSON_STATUS_SUCCESS;
		}
		
		echo json_encode($this->cache);

		garbage_collection();
		exit_handler();
	}

	static public function get_instance()
	{
		if(!self::$instance)
		{
			self::$instance = new self();
		}

		return self::$instance;
	}
}
