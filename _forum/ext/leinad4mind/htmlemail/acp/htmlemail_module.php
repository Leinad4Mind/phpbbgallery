<?php
/**
 *
 * HTML email extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2015 ForumHulp.com <http://forumhulp.com>
 * @copyright (c) 2026 Leinad4Mind <https://leinad4mind.top>
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace leinad4mind\htmlemail\acp;

class htmlemail_module
{
	public $u_action;
	public $tpl_name;
	public $page_title;

	public function main($id, $mode)
	{
		global $phpbb_container;

		/** @var \leinad4mind\htmlemail\controller\admin_controller $admin_controller */
		$admin_controller = $phpbb_container->get('leinad4mind.htmlemail.admin_controller');

		$this->tpl_name = 'acp_htmlemail';
		$this->page_title = $phpbb_container->get('user')->lang('ACP_HTMLEMAIL_TITLE');

		$admin_controller->handle($mode, $this->u_action);
	}
}
