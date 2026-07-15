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

class m1_initial_schema extends \phpbb\db\migration\migration
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

}