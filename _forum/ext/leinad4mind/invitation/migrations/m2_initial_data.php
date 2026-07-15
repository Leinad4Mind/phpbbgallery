<?php

/**
 *
 * Invite. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2010-2015, KillBill
 * @copyright (c) 2017, kasimi
 * @copyright (c) 2017-2022, Leinad4Mind, https://leinad4mind.top/forum
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

			array('permission.add', array('u_invite_sending', true)),
			array('permission.add', array('u_invite_request', true)),
			array('permission.add', array('u_invite_delete', true)),
			array('permission.add', array('u_invite_max', true)),
			array('permission.add', array('u_invite_users', true)),
			array('permission.add', array('m_invite_claiming', true)),
			array('permission.add', array('a_invite', true)),
			array('permission.add', array('a_invite_config', true)),
			array('permission.add', array('a_invite_send', true)),
			array('permission.add', array('a_invite_delete', true)),
			array('permission.add', array('a_invite_claiming', true)),
			array('permission.add', array('a_invite_users', true)),
			array('permission.add', array('a_invite_pend', true)),

			array('if', array(
				array('permission.role_exists', array('ROLE_ADMIN_STANDARD')),
				array('permission.permission_set', array('ROLE_ADMIN_STANDARD', 'a_invite')),
				array('permission.permission_set', array('ROLE_ADMIN_STANDARD', 'a_invite_config')),
				array('permission.permission_set', array('ROLE_ADMIN_STANDARD', 'a_invite_send')),
				array('permission.permission_set', array('ROLE_ADMIN_STANDARD', 'a_invite_claiming')),
				array('permission.permission_set', array('ROLE_ADMIN_STANDARD', 'a_invite_users')),
				array('permission.permission_set', array('ROLE_ADMIN_STANDARD', 'a_invite_pend')),
			)),

			array('if', array(
				array('permission.role_exists', array('ROLE_ADMIN_FULL')),
				array('permission.permission_set', array('ROLE_ADMIN_FULL', 'a_invite')),
				array('permission.permission_set', array('ROLE_ADMIN_FULL', 'a_invite_config')),
				array('permission.permission_set', array('ROLE_ADMIN_FULL', 'a_invite_send')),
				array('permission.permission_set', array('ROLE_ADMIN_FULL', 'a_invite_delete')),
				array('permission.permission_set', array('ROLE_ADMIN_FULL', 'a_invite_claiming')),
				array('permission.permission_set', array('ROLE_ADMIN_FULL', 'a_invite_users')),
				array('permission.permission_set', array('ROLE_ADMIN_FULL', 'a_invite_pend')),
			)),
			
			array('if', array(
				array('permission.role_exists', array('ROLE_ADMIN_FORUM')),
				array('permission.permission_set', array('ROLE_ADMIN_FORUM', 'a_invite_send')),
				array('permission.permission_set', array('ROLE_ADMIN_FORUM', 'a_invite_claiming')),
				array('permission.permission_set', array('ROLE_ADMIN_FORUM', 'a_invite_users')),
			)),

			array('if', array(
				array('permission.role_exists', array('ROLE_ADMIN_USERGROUP')),
				array('permission.permission_set', array('ROLE_ADMIN_USERGROUP', 'a_invite_config')),
				array('permission.permission_set', array('ROLE_ADMIN_USERGROUP', 'a_invite_send')),
				array('permission.permission_set', array('ROLE_ADMIN_USERGROUP', 'a_invite_claiming')),
				array('permission.permission_set', array('ROLE_ADMIN_USERGROUP', 'a_invite_users')),
			)),
			
			array('if', array(
				array('permission.role_exists', array('ROLE_USER_STANDARD')),
				array('permission.permission_set', array('ROLE_USER_STANDARD', 'u_invite_sending')),
				array('permission.permission_set', array('ROLE_USER_STANDARD', 'u_invite_request')),
				array('permission.permission_set', array('ROLE_USER_STANDARD', 'u_invite_users')),
			)),
			
			array('if', array(
				array('permission.role_exists', array('ROLE_USER_FULL')),
				array('permission.permission_set', array('ROLE_USER_FULL', 'u_invite_sending')),
				array('permission.permission_set', array('ROLE_USER_FULL', 'u_invite_request')),
				array('permission.permission_set', array('ROLE_USER_FULL', 'u_invite_users')),
				array('permission.permission_set', array('ROLE_USER_FULL', 'u_invite_delete')),
				array('permission.permission_set', array('ROLE_USER_FULL', 'u_invite_max')),
			)),
			
			array('if', array(
				array('permission.role_exists', array('ROLE_USER_NOPM')),
				array('permission.permission_set', array('ROLE_USER_NOPM', 'u_invite_sending')),
				array('permission.permission_set', array('ROLE_USER_NOPM', 'u_invite_request')),
				array('permission.permission_set', array('ROLE_USER_NOPM', 'u_invite_users')),
			)),
			
			array('if', array(
				array('permission.role_exists', array('ROLE_USER_NOAVATAR')),
				array('permission.permission_set', array('ROLE_USER_NOAVATAR', 'u_invite_sending')),
				array('permission.permission_set', array('ROLE_USER_NOAVATAR', 'u_invite_request')),
				array('permission.permission_set', array('ROLE_USER_NOAVATAR', 'u_invite_users')),
			)),
			
			array('if', array(
				array('permission.role_exists', array('ROLE_MOD_STANDARD')),
				array('permission.permission_set', array('ROLE_MOD_STANDARD', 'm_invite_claiming')),
			)),
			array('if', array(
				array('permission.role_exists', array('ROLE_MOD_FULL')),
				array('permission.permission_set', array('ROLE_MOD_FULL', 'm_invite_claiming')),
			)),
			array('if', array(
				array('permission.role_exists', array('ROLE_MOD_QUEUE')),
				array('permission.permission_set', array('ROLE_MOD_QUEUE', 'm_invite_claiming')),
			)),
			
			array('module.add', array(
				'acp',
				'ACP_CAT_DOT_MODS',
				'ACP_INVITE',
			)),

			array('module.add', array(
				'acp',
				'ACP_INVITE',
				array(
					'module_basename' => '\leinad4mind\invitation\acp\acp_invite_module',
					'modes' => array(
						'main',
						'config',
						'handling',
						'claiming',
						'users',
						'pend',
					),
				),
			)),

			array('module.add', array(
				'mcp',
				0,
				'MCP_INVITE',
			)),

			array('module.add', array(
				'mcp',
				'MCP_INVITE',
				array(
					'module_basename' => '\leinad4mind\invitation\mcp\mcp_invite_module',
					'modes' => array(
						'confirmation',
					),
				),
			)),

			array('module.add', array(
				'ucp',
				0,
				'UCP_INVITE',
			)),

			array('module.add', array(
				'ucp',
				'UCP_INVITE',
				array(
					'module_basename' => '\leinad4mind\invitation\ucp\ucp_invite_module',
					'modes' => array(
						'data',
						'send',
						'request',
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
			'invite_install_time'		=> time(),
			'invite_captcha_enable'		=> 1,
			'invite_validity'				=> 86400,
			'invite_db'						=> 0,
			'invite_page_list'			=> 25,
			'invite_new_reg'				=> 0,
			'invite_birthdays'			=> 0,
			'invite_day_db'				=> 5,
			'invite_email_db'				=> 1,
			'invite_enable'				=> 0,
			'invite_delete_time'			=> 5,
			'invite_req_max'				=> 20,
			'invite_req_cause'			=> 5,
			'email_address_change'		=> 1,
			'invite_post_limit'			=> 0,
			'total_users'					=> 0,
			'total_pend'					=> 0,
			'total_petition'				=> 0,
			'verify_time'					=> 0,
			'invite_email_priority'		=> 3,
			'invite_group_enabled'		=> 0,
			'default_group'				=> 0,
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
