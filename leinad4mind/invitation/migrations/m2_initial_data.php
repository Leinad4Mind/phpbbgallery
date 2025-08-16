<?php

/**
 *
 * Invitation. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2010-2015, KillBill
 * @copyright (c) 2017, kasimi
 * @copyright (c) 2017-2021, Leinad4Mind, https://leinad4mind.top/forum
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace leinad4mind\invitation\migrations;

use leinad4mind\invitation\ext;

class m2_initial_data extends \phpbb\db\migration\migration
{
	public static function depends_on()
	{
		return array('\leinad4mind\invitation\migrations\m1_initial_schema');
	}

	public function effectively_installed()
	{
		return $this->config['require_ac_invite'] !== '';
	}

	public function update_data()
	{
		return array(
			array('custom', array(array($this, 'populate_invite_config'))),

			array('config.add', array('require_ac_invite', ext::ACC_INVITE_REGISTER)),
			array('config.add', array('invite_notification_id', 1)),

			array('permission.add', array('u_meghivo_kuld', true)),
			array('permission.add', array('u_meghivo_keres', true)),
			array('permission.add', array('u_meghivo_delet', true)),
			array('permission.add', array('u_meghivo_max', true)),
			array('permission.add', array('u_meghivo_users', true)),
			array('permission.add', array('m_meghivo_igeny', true)),
			array('permission.add', array('a_meghivo', true)),
			array('permission.add', array('a_meghivo_config', true)),
			array('permission.add', array('a_meghivo_kuldes', true)),
			array('permission.add', array('a_meghivo_delete', true)),
			array('permission.add', array('a_meghivo_igeny', true)),
			array('permission.add', array('a_meghivo_users', true)),
			array('permission.add', array('a_meghivo_pend', true)),

			array('permission.permission_set', array('ROLE_ADMIN_STANDARD', 'a_meghivo')),
			array('permission.permission_set', array('ROLE_ADMIN_STANDARD', 'a_meghivo_config')),
			array('permission.permission_set', array('ROLE_ADMIN_STANDARD', 'a_meghivo_kuldes')),
			array('permission.permission_set', array('ROLE_ADMIN_STANDARD', 'a_meghivo_igeny')),
			array('permission.permission_set', array('ROLE_ADMIN_STANDARD', 'a_meghivo_users')),
			array('permission.permission_set', array('ROLE_ADMIN_STANDARD', 'a_meghivo_pend')),

			array('permission.permission_set', array('ROLE_ADMIN_FULL', 'a_meghivo')),
			array('permission.permission_set', array('ROLE_ADMIN_FULL', 'a_meghivo_config')),
			array('permission.permission_set', array('ROLE_ADMIN_FULL', 'a_meghivo_kuldes')),
			array('permission.permission_set', array('ROLE_ADMIN_FULL', 'a_meghivo_delete')),
			array('permission.permission_set', array('ROLE_ADMIN_FULL', 'a_meghivo_igeny')),
			array('permission.permission_set', array('ROLE_ADMIN_FULL', 'a_meghivo_users')),
			array('permission.permission_set', array('ROLE_ADMIN_FULL', 'a_meghivo_pend')),

			array('permission.permission_set', array('ROLE_ADMIN_FORUM', 'a_meghivo_kuldes')),
			array('permission.permission_set', array('ROLE_ADMIN_FORUM', 'a_meghivo_igeny')),
			array('permission.permission_set', array('ROLE_ADMIN_FORUM', 'a_meghivo_users')),

			array('permission.permission_set', array('ROLE_ADMIN_USERGROUP', 'a_meghivo_config')),
			array('permission.permission_set', array('ROLE_ADMIN_USERGROUP', 'a_meghivo_kuldes')),
			array('permission.permission_set', array('ROLE_ADMIN_USERGROUP', 'a_meghivo_igeny')),
			array('permission.permission_set', array('ROLE_ADMIN_USERGROUP', 'a_meghivo_users')),

			array('permission.permission_set', array('ROLE_USER_STANDARD', 'u_meghivo_kuld')),
			array('permission.permission_set', array('ROLE_USER_STANDARD', 'u_meghivo_keres')),
			array('permission.permission_set', array('ROLE_USER_STANDARD', 'u_meghivo_users')),

			array('permission.permission_set', array('ROLE_USER_FULL', 'u_meghivo_kuld')),
			array('permission.permission_set', array('ROLE_USER_FULL', 'u_meghivo_keres')),
			array('permission.permission_set', array('ROLE_USER_FULL', 'u_meghivo_users')),
			array('permission.permission_set', array('ROLE_USER_FULL', 'u_meghivo_delet')),
			array('permission.permission_set', array('ROLE_USER_FULL', 'u_meghivo_max')),

			array('permission.permission_set', array('ROLE_USER_NOPM', 'u_meghivo_kuld')),
			array('permission.permission_set', array('ROLE_USER_NOPM', 'u_meghivo_keres')),
			array('permission.permission_set', array('ROLE_USER_NOPM', 'u_meghivo_users')),

			array('permission.permission_set', array('ROLE_USER_NOAVATAR', 'u_meghivo_kuld')),
			array('permission.permission_set', array('ROLE_USER_NOAVATAR', 'u_meghivo_keres')),
			array('permission.permission_set', array('ROLE_USER_NOAVATAR', 'u_meghivo_users')),

			array('permission.permission_set', array('ROLE_MOD_STANDARD', 'm_meghivo_igeny')),
			array('permission.permission_set', array('ROLE_MOD_FULL', 'm_meghivo_igeny')),
			array('permission.permission_set', array('ROLE_MOD_QUEUE', 'm_meghivo_igeny')),

			array('module.add', array(
				'acp',
				'ACP_CAT_DOT_MODS',
				'ACP_MEGHIVO',
			)),

			array('module.add', array(
				'acp',
				'ACP_MEGHIVO',
				array(
					'module_basename' => '\leinad4mind\invitation\acp\acp_invite_module',
					'modes' => array(
						'main',
						'config',
						'kezeles',
						'igeny',
						'users',
						'pend',
					),
				),
			)),

			array('module.add', array(
				'mcp',
				0,
				'MCP_MEGHIVO',
			)),

			array('module.add', array(
				'mcp',
				'MCP_MEGHIVO',
				array(
					'module_basename' => '\leinad4mind\invitation\mcp\mcp_invite_module',
					'modes' => array(
						'jovahagyas',
					),
				),
			)),

			array('module.add', array(
				'ucp',
				0,
				'UCP_MEGHIVO',
			)),

			array('module.add', array(
				'ucp',
				'UCP_MEGHIVO',
				array(
					'module_basename' => '\leinad4mind\invitation\ucp\ucp_invite_module',
					'modes' => array(
						'adat',
						'kuldes',
						'keres',
						'user',
						'delete',
					),
				),
			)),
		);
	}

	public function populate_invite_config()
	{
		$invite_config = array(
			'meghivo_install_time'			=> time(),
			'meghivo_captcha_enable'		=> 1,
			'meghivo_ervenyessege'			=> 86400,
			'meghivo_db'					=> 0,
			'meghivo_oldal_list'			=> 25,
			'meghivo_uj_reg'				=> 0,
			'meghivo_birthdays'				=> 0,
			'meghivo_day_db'				=> 5,
			'meghivo_email_db'				=> 1,
			'meghivo_enable'				=> 0,
			'meghivo_delet_time'			=> 5,
			'meghivo_req_max'				=> 20,
			'meghivo_req_cause'				=> 5,
			'email_address_change'			=> 1,
			'meghivo_post_limit'			=> 0,
			'total_users'					=> 0,
			'total_pend'					=> 0,
			'total_petition'				=> 0,
			'verify_time'					=> 0,
			'meghivo_email_priority'		=> 3,
			'invite_group_enabled'			=> 0,
			'default_group'					=> 0,
			'invite_group'					=> 0,
			'new_member_post_limit_ignored'	=> 0,
			'gift_invited_users'			=> 0,
			'gift_invited_users_invitation'	=> 0,
		);

		$insert_values = array();

		foreach ($invite_config as $name => $value)
		{
			$insert_values[] = array(
				'config_name'	=> $name,
				'config_value'	=> $value,
			);
		}

		$this->db->sql_multi_insert($this->table_prefix . 'invite_config', $insert_values);
	}
}
