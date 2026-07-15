<?php
/**
*
* @package subjectcheck
* @copyright (c) 2016 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\subjectcheck\migrations;

class v100_m1_init extends \phpbb\db\migration\migration
{
	public function effectively_installed()
	{
		return isset($this->config['subject_check_enable']);
	}

	static public function depends_on()
	{
		return array('\phpbb\db\migration\data\v310\gold');
	}

	public function update_schema()
	{
		return array(
			'add_columns'	=> array(
				$this->table_prefix . 'forums'	=> array(
					'forum_subject_check'	=> array('BOOL', 1),
				),
			),
		);
	}

	public function revert_schema()
	{
		return array(
			'drop_columns'	=> array(
				$this->table_prefix . 'forums'	=> array(
					'forum_subject_check',
				),
			),
		);
	}

	public function update_data()
	{
		return array(
			array('config.add', array('subject_check_enable', true)),
			array('config.add', array('subject_check_bypass', 1)),
			array('config.add', array('subject_check_strict', false)),
			array('config.add', array('subject_check_ajax', true)),
			array('config.add', array('subject_check_locked', false)),
			array('config.add', array('subject_check_pop', true)),
			array('config.add', array('subject_check_admin', false)),
			array('config.add', array('subject_check_mod', false)),
			array('config.add', array('subject_check_forums', false)),
			array('config.add', array('subject_check_fnames', false)),
			array('config.add', array('subject_check_limit', 0)),
			array('config.add', array('subject_check_active', 0)),
			array('config.add', array('subject_check_count', 0)),

			array('module.add', array(
				'acp',
				'ACP_CAT_DOT_MODS',
				'ACP_SUBJECT_CHECK_TITLE'
			)),
			array('module.add', array(
				'acp',
				'ACP_SUBJECT_CHECK_TITLE',
				array(
					'module_basename'	=> '\sitesplat\subjectcheck\acp\main_module',
					'modes'				=> array('settings'),
				),
			)),
		);
	}
}
