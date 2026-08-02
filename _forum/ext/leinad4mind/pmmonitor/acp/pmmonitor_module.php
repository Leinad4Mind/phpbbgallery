<?php
/**
 * @package PM Monitor
 * @copyright (c) 2026 Leinad4Mind
 * @license GNU General Public License, version 2 (GPL-2.0)
 */

namespace leinad4mind\pmmonitor\acp;

class pmmonitor_module
{
	public $u_action;
	public $tpl_name;
	public $page_title;

	public function main($id, $mode)
	{
		global $phpbb_container;
		$this->tpl_name = 'pmmonitor';
		$this->page_title = $phpbb_container->get('language')->lang('ACP_PM_MONITOR');
		$controller = $phpbb_container->get('leinad4mind.pmmonitor.admin.controller');
		$controller->set_page_url($this->u_action);
		$controller->display_output();
	}
}
