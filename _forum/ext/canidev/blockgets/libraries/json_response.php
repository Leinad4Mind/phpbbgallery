<?php
/*
* @name json_response.php
* @package cBB Blockgets
* @version v2.0.0 30/05/2017
*
* @copyright (c) 2017 CaniDev
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/

namespace canidev\blockgets\libraries;

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
	protected $cache = array(
		'htmlContent'	=> '',
	);
	
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
	
	public function send($data = false)
	{
		header('Content-Type: application/json');
		
		if($data !== false)
		{
			$this->add($data);
		}
		
		echo json_encode($this->cache);

		garbage_collection();
		exit_handler();
	}
}
