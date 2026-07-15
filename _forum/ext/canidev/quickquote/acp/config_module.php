<?php
/*
* @package cBB QuickQuote
* @version v1.0.1 10/02/2019
*
* @copyright (c) 2019 CaniDev
* @license https://opensource.org/licenses/gpl-license.php GNU Public License
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
}
