<?php
/**
 * @package cBB Chat
 * @version 1.2.5 20/09/2023
 *
 * @copyright (c) 2023 CaniDev
 * @license https://creativecommons.org/licenses/by-nc/4.0/
 */

namespace canidev\chat\acp;

class main_module
{
	public $u_action;

	public $page_title;
	public $tpl_name;

	public function main($id, $mode)
	{
		global $phpbb_container;

		$controller = $phpbb_container->get('canidev.chat.controller.admin.' . $mode);

		$controller
			->set_form_action($this->u_action)
			->display($mode);
		
		$this->tpl_name		= $controller->get_template();
		$this->page_title	= $controller->get_title('ACP_CAT_CHAT');
	}
}
