<?php
/**
*
* @package phpBB Extension - Official Topic Index
 * @copyright (c) 2015-2022 Leinad4Mind - https://leinad4mind.top/forum
* @copyright (c) 2015 dmzx - http://www.dmzx-web.net
 * @copyright (c) 2026 Leinad4Mind
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace leinad4mind\officialtopicindex\acp;

class officialtopicindex_module
{
	public $u_action;
	public $tpl_name;
	public $page_title;

	public function main($id, $mode)
	{
		global $phpbb_container;

		$language = $phpbb_container->get('language');
		$language->add_lang('acp_officialtopicindex', 'leinad4mind/officialtopicindex');

		// Get an instance of the admin controller
		$admin_controller = $phpbb_container->get('leinad4mind.officialtopicindex.admin.controller');

		// Make the $u_action url available in the admin controller
		$admin_controller->set_page_url($this->u_action);

		switch ($mode)
		{
			case 'main':
				// Load a template from adm/style for our ACP page
				$this->tpl_name = 'acp_officialindex';
				// Set the page title for our ACP page
				$this->page_title = $language->lang('ACP_OFFICIALINDEX_CFG');
				// Load the display options handle in the admin controller
				$admin_controller->display_options();
			break;
		}
	}
}
