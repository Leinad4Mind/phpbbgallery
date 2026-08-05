<?php
/**
 *
 * @package phpBB Extension - Faulty Logins
 * @copyright (c) 2014 John Peskens (http://ForumHulp.com)
 * @copyright (c) 2026 Leinad4Mind
 * @license https://opensource.org/licenses/GPL-2.0 GNU General Public License v2
 *
 */

namespace forumhulp\faultylogins\migrations;

use phpbb\db\migration\migration;

class install_faultylogins_3_2_0 extends migration
{
	static public function depends_on()
	{
		return ['\phpbb\db\migration\data\v330\dev'];
	}

	public function update_data()
	{
		return [
			['config.add', ['faultylogins_initialized', 0]],
			['config.add', ['faultylogins_public_key', '', true]],
			['config.add', ['faultylogins_private_key_cipher', '', true]],
			['config.add', ['faultylogins_private_key_nonce', '', true]],
			['config.add', ['faultylogins_kdf_salt', '', true]],
			['config.add', ['faultylogins_retention_days', 30]],
			['config.add', ['faultylogins_throttle_seconds', 10]],
			['config.add', ['faultylogins_prune_last_gc', 0, true]],
			['module.add', ['acp', 'ACP_CAT_DOT_MODS', 'ACP_FAULTYLOGINS_TITLE']],
			['module.add', [
				'acp',
				'ACP_FAULTYLOGINS_TITLE',
				[
					'module_basename' => '\forumhulp\faultylogins\acp\faultylogins_module',
					'modes' => ['logs', 'security'],
				],
			]],
		];
	}

	public function update_schema()
	{
		return [
			'add_tables' => [
				$this->table_prefix . 'faultylogins_attempts' => [
					'COLUMNS' => [
						'attempt_id' => ['UINT', null, 'auto_increment'],
						'attempt_time' => ['TIMESTAMP', 0],
						'actor_user_id' => ['UINT', 1],
						'attempted_user_id' => ['UINT', 0],
						'attempted_username' => ['VCHAR_UNI:255', ''],
						'ip_address' => ['VCHAR:40', ''],
						'login_status' => ['UINT', 0],
						'error_key' => ['VCHAR:255', ''],
						'error_text' => ['VCHAR_UNI:255', ''],
						'password_cipher' => ['MTEXT_UNI', ''],
						'password_truncated' => ['BOOL', 0],
					],
					'PRIMARY_KEY' => 'attempt_id',
					'KEYS' => [
						'attempt_time' => ['INDEX', ['attempt_time']],
						'ip_time' => ['INDEX', ['ip_address', 'attempt_time']],
					],
				],
			],
		];
	}

	public function revert_schema()
	{
		return [
			'drop_tables' => [$this->table_prefix . 'faultylogins_attempts'],
		];
	}
}
