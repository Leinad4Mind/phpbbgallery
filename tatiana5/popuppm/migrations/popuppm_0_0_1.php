<?php
/**
*
* @package phpBB Extension - Popup PM
* @copyright (c) 2016 Татьяна5
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/
namespace tatiana5\popuppm\migrations;

class popuppm_0_0_1 extends \phpbb\db\migration\migration
{
	public function effectively_installed()
	{
		return isset($this->config['popuppm_version']) && version_compare($this->config['popuppm_version'], '0.0.1', '>=');
	}

	static public function depends_on()
	{
		return ['\phpbb\db\migration\data\v310\dev'];
	}

	public function update_schema()
	{
		return [
			'add_columns' => [
				$this->table_prefix . 'users' => [
					'popuppm_user_popup'    => ['BOOL', 1],
					'popuppm_user_blink'    => ['BOOL', 1],
				],
			],
		];
	}

	public function revert_schema()
	{
		return [
			'drop_columns'    => [
				$this->table_prefix . 'users' => ['popuppm_user_popup'],
				$this->table_prefix . 'users' => ['popuppm_user_blink'],
			],
		];
	}

	public function update_data()
	{
		return [
			// Current version
			['config.add', ['popuppm_version', '0.0.1']],

			['config.add', ['popuppm_enable_popup', 1]],
			['config.add', ['popuppm_enable_blink', 1]],

			// Add ACP modules
			['module.add', ['acp', 'ACP_CAT_DOT_MODS', 'ACP_POPUPPM']],
			['module.add', ['acp', 'ACP_POPUPPM', [
					'module_basename'	=> '\tatiana5\popuppm\acp\popuppm_module',
					'module_langname'	=> 'ACP_POPUPPM_EXPLAIN',
					'module_mode'		=> 'config_popuppm',
					'module_auth'		=> 'ext_tatiana5/popuppm && acl_a_board',
			]]],
		];
	}
}
