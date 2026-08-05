<?php
/**
 *
 * @package phpBB Extension - Who Visited This Topic
 * @copyright (c) 2016 dmzx - https://www.dmzx-web.net
 * @copyright (c) 2026 Leinad4Mind
 * @license https://opensource.org/licenses/GPL-2.0 GNU General Public License v2
 *
 */

namespace dmzx\whovisitedthistopic\acp;

class acp_whovisitedthistopic_module
{
	public $u_action;

	public function main($id, $mode)
	{
		global $phpbb_container;

		$admin_controller = $phpbb_container->get('dmzx.whovisitedthistopic.admin.controller');
		$admin_controller->set_page_url($this->u_action);

		if ($mode === 'settings')
		{
			$this->tpl_name = 'acp_whovisitedthistopic';
			$this->page_title = $phpbb_container->get('language')->lang('ACP_WHOVISITEDTHISTOPIC_TITLE');
			$admin_controller->display_options();
		}
	}
}
