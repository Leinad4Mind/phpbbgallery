<?php
/**
 *
 * No DEA Emails. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2020, Picaron, https://github.com/picaronin/
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace pikaron\nodeaemails\migrations;

class v130 extends \phpbb\db\migration\migration
{
	static public function depends_on()
	{
		return array('\pikaron\nodeaemails\migrations\v120');
	}

	public function update_data()
	{
		return array(
			array('config.update', array('nodeaemails_version', '1.3.0')),
		);
	}

	public function update_schema()
	{
		return array(
			'add_columns'	=> array(
				$this->table_prefix . 'users' => array(
					'user_chg_email_force' => array('TINT:1', 0),
				),
			),
		);
	}

	public function revert_schema()
	{
		return	array(
			'drop_columns' => array(
				$this->table_prefix . 'users'	=> array(
					'user_chg_email_force',
				),
			),
		);
	}

}
