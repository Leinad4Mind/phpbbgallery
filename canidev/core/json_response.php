<?php
/*
* @name json_response.php
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

/**
* JSON class
*/
class json_response
{
	const JSON_STATUS_ERROR		= 1;
	const JSON_STATUS_SUCCESS	= 2;

	protected $cache;
	
	public function __construct()
	{
		$this->reset();
	}
	
	public function add($data)
	{
		$this->cache = array_merge($this->cache, $data);
		return $this;
	}
	
	public function add_html($html, $append = false)
	{
		if(!$append)
		{
			$this->cache['htmlContent'] = '';
		}
		
		$this->cache['htmlContent'] .= $html;
		
		return $this;
	}
	
	public function is_requested()
	{
		return (sizeof($this->cache) > 1);
	}
	
	public function reset()
	{
		$this->cache = array(
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
		
		echo json_encode($this->cache);

		garbage_collection();
		exit_handler();
	}
}
