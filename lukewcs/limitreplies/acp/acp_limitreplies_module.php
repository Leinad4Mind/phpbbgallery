<?php
/**
*
* Limit Multiple Replies. An extension for the phpBB Forum Software package.
*
* @copyright (c) 2024, LukeWCS, https://github.com/LukeWCS
* @license GNU General Public License, version 2 (GPL-2.0-only)
*
* Note: This extension is 100% genuine handcraft and consists of selected
*       natural raw materials. There was no AI involved in making it.
*
*/

namespace lukewcs\limitreplies\acp;

class acp_limitreplies_module
{
	public $page_title;
	public $tpl_name;
	public $u_action;

	public function main()
	{
		global $phpbb_container;

		$language = $phpbb_container->get('language');
		$this->tpl_name = 'acp_limitreplies_settings';
		$this->page_title = $language->lang('LIMITREPLIES_NAV_TITLE') . ' - ' . $language->lang('LIMITREPLIES_NAV_CONFIG');

		$acp_controller = $phpbb_container->get('lukewcs.limitreplies.controller.acp');
		$acp_controller->set_page_url($this->u_action);
		$acp_controller->module_settings();
	}
}
