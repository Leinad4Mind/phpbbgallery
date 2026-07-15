<?php
/**
 * @package cBB Blockgets
 * @version 2.0.5 15/01/2023
 *
 * @copyright (c) 2023 CaniDev
 * @license https://creativecommons.org/licenses/by-nc/4.0/
 */

namespace canidev\blockgets\acp;

class main_module
{
	public $u_action;

	public $page_title;
	public $tpl_name;
	
	protected $controller;

	/**
	 * Loads module
	 * 
	 * @param string 	$id 		Module ID
	 * @param string 	$mode 		Current Mode
	 */
	public function main($id, $mode)
	{
		global $phpbb_container;
		
		$controller = ($mode == 'optional') ? 'main' : $mode;

		$this->controller = $phpbb_container->get('canidev.blockgets.controller.admin.' . $controller);

		$this->controller
			->set_form_action($this->u_action)
			->display($mode);
		
		$this->tpl_name		= $this->controller->get_template();
		$this->page_title	= $this->controller->get_title('ACP_BLOCKGETS');
	}

	/**
	 * Helper for blocks
	 */
	public function helper()
	{
		$args 	= func_get_args();
		$method = array_shift($args);

		if(method_exists($this->controller->helper_acp, $method))
		{
			return call_user_func_array([$this->controller->helper_acp, $method], $args);
		}
		
		return call_user_func_array([$this->controller->tools, $method], $args);
	}
}
