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

namespace lukewcs\limitreplies\migrations;

class v_1_0_0 extends \phpbb\db\migration\migration
{
	public function effectively_installed()
	{
		return isset($this->config['limitreplies_switch_enable']);
	}

	public static function depends_on()
	{
		return ['\phpbb\db\migration\data\v33x\v332'];
	}

	public function update_data()
	{
		return [
			['config.add', ['limitreplies_switch_enable'	, 0]],
			['config.add', ['limitreplies_number_wait_time'	, 60]],
			['config.add', ['limitreplies_select_hint_mode'	, 1]],

			['module.add', [
				'acp',
				'ACP_CAT_DOT_MODS',
				'LIMITREPLIES_NAV_TITLE'
			]],
			['module.add', [
				'acp',
				'LIMITREPLIES_NAV_TITLE', [
					'module_basename'	=> '\lukewcs\limitreplies\acp\acp_limitreplies_module',
					'module_langname'	=> 'LIMITREPLIES_NAV_CONFIG',
					'module_mode'		=> 'settings',
					'module_auth'		=> 'ext_lukewcs/limitreplies && acl_a_board',
				],
			]],

			['permission.add', ['u_limitreplies_bypass_lock']],

			['permission.permission_set', ['ADMINISTRATORS',	'u_limitreplies_bypass_lock', 'group']],
			['permission.permission_set', ['GLOBAL_MODERATORS',	'u_limitreplies_bypass_lock', 'group']],
			['if', [
				['permission.role_exists',		['ROLE_USER_NEW_MEMBER']],
				['permission.permission_set',	['ROLE_USER_NEW_MEMBER', 'u_limitreplies_bypass_lock', 'role', false]],
			]],
		];
	}
}
