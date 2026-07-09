<?php
/**
 * @package cBB QuickQuote
 * @version 1.0.5 08/04/2025
 *
 * @copyright (c) 2025 CaniDev
 * @license https://creativecommons.org/licenses/by-nc/4.0/
 */

namespace canidev\quickquote\acp;

class config_module
{
	public $u_action;

	public $page_title;
	public $tpl_name;

	/**
	 * Loads module
	 * 
	 * @param string 	$id 		Module ID
	 * @param string 	$mode 		Current Mode
	 */
	public function main($id, $mode)
	{
		global $phpbb_container;

		/** @var \canidev\quickquote\controller\admin_controller_config */
		$controller = $phpbb_container->get('canidev.quickquote.admin.config');

		$controller
			->set_form_action($this->u_action)
			->display($mode);
		
		$this->tpl_name		= $controller->get_template();
		$this->page_title	= $controller->get_title('ACP_CAT_QUICKQUOTE');
	}
}
