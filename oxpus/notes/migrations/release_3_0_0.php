<?php

/**
*
* @package phpBB Extension - Personal notes
* @copyright (c) 2014 OXPUS - www.oxpus.net
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace oxpus\notes\migrations;

class release_3_0_0 extends \phpbb\db\migration\migration
{
	var $ext_version = '3.0.0';

	public function effectively_installed()
	{
		return isset($this->config['notes_version']) && version_compare($this->config['notes_version'], $this->ext_version, '>=');
	}

	public function update_data()
	{
		return [
			// Set the current version
			['config.add', ['notes_version', $this->ext_version]],

			// Preset the config data
			['config.add', ['notes', '50']],

			['module.add', [
				'acp',
				'ACP_CAT_DOT_MODS',
				'ACP_NOTES'
			]],
			['module.add', [
				'acp',
				'ACP_NOTES',
				[
					'module_basename'	=> '\oxpus\notes\acp\main_module',
					'modes'				=> ['main'],
				],
			]],
			['module.add', [
				'ucp',
				false,
				'UCP_NOTES'
			]],
			['module.add', [
				'ucp',
				'UCP_NOTES',
				[
					'module_basename'	=> '\oxpus\notes\ucp\main_module',
					'modes'				=> ['main'],
				],
			]],

			// The needed permissions
			['permission.add', ['a_notes']],

			// Join permissions to administrators
			['permission.permission_set', ['ROLE_ADMIN_FULL', 'a_notes']],
		];
	}

	public function update_schema()
	{
		return [
			'add_tables'	=> [
				$this->table_prefix . 'notes' => [
					'COLUMNS'		=> [
						'note_id'		=> ['UINT:11', 0],
						'note_user_id'	=> ['UINT:11', 0],
						'note_subject'	=> ['STEXT_UNI', ''],
						'note_text'		=> ['MTEXT_UNI', ''],
						'note_time'		=> ['UINT:11', 0],
						'note_uid'		=> ['CHAR:8', 1],
						'note_bitfield'	=> ['VCHAR', ''],
						'note_flags'	=> ['UINT:11', 0],
						'note_mem'		=> ['UINT:11', 0],
						'note_memx'		=> ['BOOL', 1],
					],
					'PRIMARY_KEY'	=> 'note_id',
					'KEYS'	=> [
						'note_user_id'	=> ['INDEX', 'note_user_id'],
					],
				],
			],

			'add_columns' => [
				$this->table_prefix . 'users'		=> [
					'user_popup_notes' => ['TINT:1', 0],
				],
			],
		];
	}

	public function revert_schema()
	{
		return [
			'drop_tables' => [
				$this->table_prefix . 'notes',
			],

			'drop_columns'	=> [
				$this->table_prefix . 'users' => [
					'user_popup_notes',
				],
			],
		];
	}
}
