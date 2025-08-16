<?php
/**
 * @package cBB Blockgets
 * @version 2.0.7 01/07/2024
 *
 * @copyright (c) 2024 CaniDev
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
}
