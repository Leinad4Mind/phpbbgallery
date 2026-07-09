<?php

/**
*
* @package Double Account Preventer
* @copyright (c) 2014 www.phpbb-work.ru
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

namespace shredder\dap\acp;

class dap_info
{
	function module()
	{
		return array(
			'filename'	=> '\shredder\dap\acp\dap_module',
			'title'		=> 'ACP_CAT_DAP_MOD',
			'modes'		=> array(
				'settings'				=> array('title' => 'ACP_DAP_SETTINGS', 'auth' => 'ext_shredder/dap && acl_a_board', 'cat' => array('ACP_CAT_DAP_MOD')),
				'dupe_user_list'		=> array('title' => 'ACP_DAP_DUPE_USER_LIST', 'auth' => 'ext_shredder/dap && acl_a_board', 'cat' => array('ACP_CAT_DAP_MOD')),
				'dupe_log'		=> array('title' => 'ACP_DAP_DUPE_LOG', 'auth' => 'ext_shredder/dap && acl_a_viewlogs', 'cat' => array('ACP_CAT_DAP_MOD')),
				'dap_blacklist'		=> array('title' => 'ACP_DAP_BLACKLIST', 'auth' => 'ext_shredder/dap && acl_a_ban', 'cat' => array('ACP_CAT_DAP_MOD')),
			),
		);
	}
}