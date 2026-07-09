<?php
/**
 * @package cBB QuickMod
 * @version 1.1.6 01/11/2024
 *
 * @copyright (c) 2024 CaniDev
 * @license https://creativecommons.org/licenses/by-nc/4.0/
 */

namespace canidev\quickmod\acp;

/**
 * @package acp
 */
class main_module
{
	public $page_title;
	public $tpl_name;
	public $u_action;

	/**
	 * Loads module
	 * 
	 * @param string 	$id 		Module ID
	 * @param string 	$mode 		Current Mode
	 */
	public function main($id, $mode)
	{
		global $phpbb_container;

		$controller = $phpbb_container->get('canidev.quickmod.admin.config');

		$controller
			->set_form_action($this->u_action)
			->display($mode);
		
		$this->tpl_name		= $controller->get_template();
		$this->page_title	= $controller->get_title('ACP_CAT_QUICKMOD');
	}
}
