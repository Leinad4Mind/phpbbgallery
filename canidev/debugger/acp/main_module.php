<?php
/**
 * @package cBB Debugger
 * @version 1.0.2 11/03/2024
 *
 * @copyright (c) 2024 CaniDev
 * @license https://creativecommons.org/licenses/by-nc/4.0/
 */

namespace canidev\debugger\acp;

class main_module
{
	public $u_action;

	public $page_title;
	public $tpl_name;

	/**
	 * Loads module
	 */
	public function main()
	{
		global $phpbb_container;

		/** @var \canidev\debugger\controller\admin_controller */
		$controller = $phpbb_container->get('canidev.debugger.controller.admin');

		$controller
			->set_form_action($this->u_action)
			->display();
		
		$this->tpl_name		= $controller->get_template();
		$this->page_title	= $controller->get_title();
	}
}
