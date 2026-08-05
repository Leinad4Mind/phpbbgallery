<?php
/**
 *
 * @package phpBB Extension - Faulty Logins
 * @copyright (c) 2014 John Peskens (http://ForumHulp.com)
 * @copyright (c) 2026 Leinad4Mind
 * @license https://opensource.org/licenses/GPL-2.0 GNU General Public License v2
 *
 */

namespace forumhulp\faultylogins\acp;

class faultylogins_module
{
	public $u_action;

	public function main($id, $mode)
	{
		global $phpbb_container;

		header('Cache-Control: no-store, private, max-age=0');
		header('Pragma: no-cache');
		header('Referrer-Policy: no-referrer');

		$controller = $phpbb_container->get('forumhulp.faultylogins.admin.controller');
		$controller->set_page_url($this->u_action);
		$this->page_title = $phpbb_container->get('language')->lang('ACP_FAULTYLOGINS_TITLE');

		if ($mode === 'security')
		{
			$this->tpl_name = 'acp_faultylogins_security';
			$controller->security();
			return;
		}

		$this->tpl_name = 'acp_faultylogins_logs';
		$controller->logs();
	}
}
