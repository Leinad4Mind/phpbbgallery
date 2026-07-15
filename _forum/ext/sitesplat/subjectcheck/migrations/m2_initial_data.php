<?php
/**
 *
 * Subject Check. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2016, SiteSplat
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace sitesplat\subjectcheck\migrations;

class m2_initial_data extends \phpbb\db\migration\migration
{

	static public function depends_on()
	{
		return array('\sitesplat\subjectcheck\migrations\m1_initial_schema');
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
