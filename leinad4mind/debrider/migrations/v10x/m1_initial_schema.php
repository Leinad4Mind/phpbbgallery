<?php

/**
 * Debrider extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2014 phpBB Limited <https://www.phpbb.com>
 * @license GNU General Public License, version 2 (GPL-2.0)
 */

namespace leinad4mind\debrider\migrations\v10x;

class m1_initial_schema extends \phpbb\db\migration\migration
{
	static public function depends_on()
	{
		return ['\phpbb\db\migration\data\v330\v330'];
	}

	/**
	 * Returns true if the extension is installed by checking for the existence of a specific setting in the config table
	 */
	public function effectively_installed()
	{
		return isset($this->config['debrider_enabled']);
	}

	public function update_schema()
	{
		return [
			'add_columns' => [
				$this->table_prefix . 'topics' => [
					'debrider_enabled'  => ['UINT:1', 1],
				],
				$this->table_prefix . 'forums' => [
					'can_debrider_enabled'  => ['UINT:1', 1],
				],
			],
		];
	}

	public function revert_schema()
	{
		return [
			'drop_columns' => [
				$this->table_prefix . 'topics'  => [
					'debrider_enabled',
				],
				$this->table_prefix . 'forums'  => [
					'can_debrider_enabled',
				],
			],
		];
	}

	/**
	 * Note: these changes will automatically get reverted by phpbb if the extension is uninstalled.
	 * Hence the reason why no corresponding revert_data() function exists.
	 *
	 * @return array Array of table data to set
	 * @access public
	 */
	public function update_data()
	{
		return [
			['config.add', ['debrider_enabled', 0]],
			['config.add', ['debrider_api_key', '']],
			['config.add', ['debrider_provider', 1]],
			['config.add', ['debrider_use_proxy', 0]],
			['config.add', ['debrider_proxy_host', '']],
			['config.add', ['debrider_proxy_credentials', '']],
			['config.add', ['debrider_proxy_type', 1]],

			// Standard ACP module data
			['module.add', [
				'acp',
				'ACP_CAT_DOT_MODS',
				'ACP_DEBRIDER'
			]],
			['module.add', [
				'acp',
				'ACP_DEBRIDER',
				[
					'module_basename'	=> '\leinad4mind\debrider\acp\main_module',
					'modes'				=> ['settings'],
				],
			]],

			['permission.add', ['m_debrider_can_enable', true]],
			['permission.add', ['u_debrider_can_generate_url', true]],

			['if', [
				['permission.role_exists', ['ROLE_MOD_FULL']], // Check if ROLE_MOD_FULL exists before updating it
				['permission.permission_set', ['ROLE_MOD_FULL', 'm_debrider_can_enable', 'role', true]], // Give ROLE_MOD_FULL m_debrider_can_enable permission
				// ['permission.permission_set', ['GLOBAL_MODERATORS', 'm_debrider_can_enable', 'group', true]],
			
			]],
			['if', [
				['permission.role_exists', ['ROLE_USER_FULL']], // Check if ROLE_USER_FULL exists before updating it
				['permission.permission_set', ['ROLE_USER_FULL', 'u_debrider_can_generate_url', 'role', true]], // Give ROLE_USER_FULL u_debrider_can_generate_url permission
				// ['permission.permission_set', ['REGISTERED', 'u_debrider_can_generate_url', 'group', true]],
			]],
		];
	}
}
