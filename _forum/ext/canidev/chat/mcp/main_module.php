<?php
/*
* @package cBB Chat
* @version v1.2.2 29/03/2021
*
* @copyright (c) 2021 CaniDev
* @license https://opensource.org/licenses/gpl-license.php GNU Public License
*/

namespace canidev\chat\mcp;

// @ignore
if(!defined('IN_PHPBB'))
{
	exit;
}

/**
* @package acp
*/
class main_module
{
	public $u_action;
	
	protected $controller;

	public function main($id, $mode)
	{
		global $phpbb_container;

		$this->controller = $phpbb_container->get('canidev.chat.controller.mcp.' . $mode);

		$this->controller->u_action = $this->u_action;
		$this->controller->display($mode);
		
		$this->tpl_name		= $this->controller->get_template();
		$this->page_title	= $this->controller->get_title();
	}
}
