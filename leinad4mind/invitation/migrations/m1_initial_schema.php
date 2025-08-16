<?php

/**
 *
 * Invite. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2010-2015, KillBill
 * @copyright (c) 2017, kasimi
 * @copyright (c) 2017-2018, Leinad4Mind, https://leinad4mind.top/forum
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace leinad4mind\invitation\migrations;

class m1_initial_schema extends \phpbb\db\migration\migration
{
	public function effectively_installed()
	{
		return $this->db_tools->sql_table_exists($this->table_prefix . 'invite');
	}

	public function update_schema()
	{
		return array(
			'add_tables' => array(
				$this->table_prefix . 'invite' => array(
					'COLUMNS'						=> array(
						'id'							=> array('UINT', null, 'auto_increment'),
						'user_id'						=> array('UINT', 0),
						'invite_code'					=> array('VCHAR:32', ''),
						'invite_time'					=> array('TIMESTAMP', 0),
						'invite_time_end'				=> array('TIMESTAMP', 0),
						'invite_email'					=> array('VCHAR_UNI:100', ''),
						'friend'						=> array('BOOL', 0),
					),
					'PRIMARY_KEY'					=> 'id',
				),
				$this->table_prefix . 'invite_config' => array(
					'COLUMNS'							=> array(
						'config_name'					=> array('VCHAR', ''),
						'config_value'					=> array('VCHAR', ''),
					),
					'PRIMARY_KEY'					=> 'config_name',
				),
				$this->table_prefix . 'invite_users' => array(
					'COLUMNS'							=> array(
						'user_id'						=> array('UINT', 0),
						'user_name'						=> array('VCHAR', ''),
						'user_colour'					=> array('VCHAR:6', ''),
						'user_reg_email'				=> array('VCHAR_UNI:100', ''),
						'user_regdate'					=> array('TIMESTAMP', 0),
						'invite_uid'					=> array('UINT', 0),
					),
					'PRIMARY_KEY'					=> 'user_id',
				),
				$this->table_prefix . 'invite_claimed' => array(
					'COLUMNS'							=> array(
						'user_id'						=> array('UINT', 0),
						'message'						=> array('STEXT', ''),
						'message_time'					=> array('TIMESTAMP', 0),
						'ip'							=> array('VCHAR:40', ''),
						'db'							=> array('UINT', 0),
					),
					'PRIMARY_KEY'					=> 'user_id',
				),
			),
			'add_columns' => array(
				$this->table_prefix . 'users' => array(
					'user_invite'						=> array('UINT:8', 0),
					'user_invite_member'				=> array('UINT:8', 0),
					'user_invite_block'					=> array('TIMESTAMP', 0),
				),
			),
		);
	}

	public function revert_schema()
	{
		return array(
			'drop_columns'	=> array(
				$this->table_prefix . 'users' => array(
					'user_invite',
					'user_invite_member',
					'user_invite_block,'
				),
			),
			'drop_tables' => array(
				$this->table_prefix . 'invite',
				$this->table_prefix . 'invite_config',
				$this->table_prefix . 'invite_users',
				$this->table_prefix . 'invite_claimed',
			),
		);
	}
}
