<?php
/*
* @package cBB Debugger
* @version v1.0.0 21/06/2021
*
* @copyright (c) 2021 CaniDev
* @license https://opensource.org/licenses/gpl-license.php GNU Public License
*/

namespace canidev\debugger\acp;

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

		$this->controller = $phpbb_container->get('canidev.debugger.controller.admin');

		$this->controller->u_action = $this->u_action;
		$this->controller->display($mode);
		
		$this->tpl_name		= $this->controller->get_template();
		$this->page_title	= $this->controller->get_title();
	}
}
