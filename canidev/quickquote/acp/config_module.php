<?php
/*
* @name config_module.php
* @package cBB QuickQuote
* @version 1.0.0 01/03/2018
*
* @copyright (c) 2018 CaniDev
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/

namespace canidev\quickquote\acp;

// @ignore
if(!defined('IN_PHPBB'))
{
	exit;
}

/**
* @package acp
*/
class config_module
{
	public $u_action;
	
	protected $controller;

	public function main($id, $mode)
	{
		global $phpbb_container;

		$this->controller = $phpbb_container->get('canidev.quickquote.admin.config');

		$this->controller->u_action = $this->u_action;
		$this->controller->display($mode);
		
		$this->tpl_name		= $this->controller->get_template();
		$this->page_title	= $this->controller->get_title();
	}

	public function helper()
	{
		$args 	= func_get_args();
		$method = array_shift($args);
		
		return call_user_func_array(array($this->controller, $method), $args);
	}
}
