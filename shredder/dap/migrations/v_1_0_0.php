<?php

/**
*
* @package Double Account Preventer
* @copyright (c) 2014 www.phpbb-work.ru
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

namespace shredder\dap\migrations;

class v_1_0_0 extends \phpbb\db\migration\migration
{
	public function effectively_installed()
	{
		return isset($this->config['dap_version']) && version_compare($this->config['dap_version'], '1.0.0', '>=');
	}

	static public function depends_on()
	{
		return array('\phpbb\db\migration\data\v310\dev');
	}

	public function update_schema()
	{
		return array(
			'add_columns'        => array(
				$this->table_prefix . 'users'	=> array(
					'user_double'	=> array('BOOL', 0),
					'user_banned_cookie'	=> array('BOOL', 0),
					'ip_common_names'	=> array('TEXT', ''),
					'c_common_names'	=> array('TEXT', ''),
				),
			),
		);
	}

	public function revert_schema()
	{
		return array(
			'drop_columns'	=> array(
				$this->table_prefix . 'users'	=> array(
					'user_double',
					'user_banned_cookie',
					'ip_common_names',
					'c_common_names',
				),
			),
		);
	}

	public function update_data()
	{
		global $user;

		$user->add_lang_ext('shredder/dap', 'info_acp_dap');

		return array(
			// Add configs
			array('config.add', array('dap_ip_check', 0)),
			array('config.add', array('dap_cookie_check', 0)),
			array('config.add', array('dap_post_forum_id', 2)),
			array('config.add', array('dap_email_notification', 0)),
			array('config.add', array('dap_pm_notification', 0)),
			array('config.add', array('dap_alert_user_id', 2)),
			array('config.add', array('dap_cookie_ban', 0)),
			array('config.add', array('dap_cookie_autoban', 0)),
			array('config.add', array('dap_cookie_ban_message', $user->lang['DAP_COOKIE_BAN_MESSAGE_TEXT'])),
			array('config.add', array('dap_cookie_reg_deny', 0)),
			array('config.add', array('dap_reg_deny_message', $user->lang['DAP_COOKIE_DENY_REGISTER_TEXT'])),
			array('config.add', array('dap_users_per_page', 25)),
			array('config.add', array('dap_ignore_inactive', 0)),
			array('config.add', array('dap_quick_deletion', 0)),
			array('config.add', array('dap_user_notes_entry', 0)),
			array('config_text.add', array('dap_log_excludes', '')),

			// Current version
			array('config.add', array('dap_version', '1.0.0')),

			// Add ACP modules
			array('module.add', array('acp', 'ACP_CAT_DOT_MODS', 'ACP_CAT_DAP_MOD')),
			array('module.add', array('acp', 'ACP_CAT_DAP_MOD', array(
					'module_basename'	=> '\shredder\dap\acp\dap_module',
					'module_langname'	=> 'ACP_DAP_SETTINGS',
					'module_mode'		=> 'settings',
					'module_auth'		=> 'ext_shredder/dap && acl_a_board',
			))),
			array('module.add', array('acp', 'ACP_CAT_DAP_MOD', array(
					'module_basename'	=> '\shredder\dap\acp\dap_module',
					'module_langname'	=> 'ACP_DAP_DUPE_USER_LIST',
					'module_mode'		=> 'dupe_user_list',
					'module_auth'		=> 'ext_shredder/dap && acl_a_board',
			))),
			array('module.add', array('acp', 'ACP_CAT_DAP_MOD', array(
					'module_basename'	=> '\shredder\dap\acp\dap_module',
					'module_langname'	=> 'ACP_DAP_DUPE_LOG',
					'module_mode'		=> 'dupe_log',
					'module_auth'		=> 'ext_shredder/dap && acl_a_viewlogs',
			))),
			array('module.add', array('acp', 'ACP_CAT_DAP_MOD', array(
					'module_basename'	=> '\shredder\dap\acp\dap_module',
					'module_langname'	=> 'ACP_DAP_BLACKLIST',
					'module_mode'		=> 'dap_blacklist',
					'module_auth'		=> 'ext_shredder/dap && acl_a_ban',
			))),

			// Add permissions
			array('permission.add', array('a_cleardupe', true)),
		);
	}
}
