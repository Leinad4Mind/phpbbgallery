<?php
/*
* @package cBB Blockgets
* @version v2.0.1 01/02/2020
*
* @copyright (c) 2020 CaniDev
* @license https://opensource.org/licenses/gpl-license.php GNU Public License
*/

namespace canidev\blockgets\acp;

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
		
		$controller = ($mode == 'optional') ? 'main' : $mode;

		$this->controller = $phpbb_container->get('canidev.blockgets.controller.admin.' . $controller);

		$this->controller->u_action = $this->u_action;
		$this->controller->display($mode);
		
		$this->tpl_name		= $this->controller->get_template();
		$this->page_title	= $this->controller->get_title('ACP_BLOCKGETS');
	}

	/*
	 * Helper for blocks
	*/
	public function helper()
	{
		$args 	= func_get_args();
		$method = array_shift($args);
		
		return call_user_func_array(array($this->controller->helper_acp, $method), $args);
	}
}
