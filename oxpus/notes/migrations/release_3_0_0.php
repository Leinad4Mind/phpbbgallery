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
		return array(
			// Set the current version
			array('config.add', array('notes_version', $this->ext_version)),

			// Preset the config data
			array('config.add', array('notes', '50')),

			array('module.add', array(
 				'acp',
 				'ACP_CAT_DOT_MODS',
 				'ACP_NOTES'
 			)),
			array('module.add', array(
				'acp',
				'ACP_NOTES',
				array(
					'module_basename'	=> '\oxpus\notes\acp\main_module',
					'modes'				=> array('main'),
				),
			)),
			array('module.add', array(
 				'ucp',
 				false,
 				'UCP_NOTES'
 			)),
			array('module.add', array(
				'ucp',
				'UCP_NOTES',
				array(
					'module_basename'	=> '\oxpus\notes\ucp\main_module',
					'modes'				=> array('main'),
				),
			)),

			// The needed permissions
			array('permission.add', array('a_notes')),

			// Join permissions to administrators
			array('permission.permission_set', array('ROLE_ADMIN_FULL', 'a_notes')),
		);
	}
			
	public function update_schema()
	{
		return array(
			'add_tables'	=> array(
				$this->table_prefix . 'notes' => array(
					'COLUMNS'		=> array(
						'note_id'		=> array('UINT:11', 0,),
						'note_user_id'	=> array('UINT:11', 0),
						'note_subject'	=> array('STEXT_UNI', ''),
						'note_text'		=> array('MTEXT_UNI', ''),
						'note_time'		=> array('UINT:11', 0),
						'note_uid'		=> array('CHAR:8', 1),
						'note_bitfield'	=> array('VCHAR', ''),
						'note_flags'	=> array('UINT:11', 0),
						'note_mem'		=> array('UINT:11', 0),
						'note_memx'		=> array('BOOL', 1),
					),
					'PRIMARY_KEY'	=> 'note_id',
					'KEYS'	=> array(
						'note_user_id'	=> array('INDEX', 'note_user_id'),
					),
				),
			),

			'add_columns' => array(
				$this->table_prefix . 'users'		=> array(
					'user_popup_notes' => array('TINT:1', 0),
				),
			),
		);
	}

	public function revert_schema()
	{
		return array(
			'drop_tables' => array(
				$this->table_prefix . 'notes',
			),

			'drop_columns'	=> array(
				$this->table_prefix . 'users' => array(
					'user_popup_notes',
				),
			),
		);
	}
}
