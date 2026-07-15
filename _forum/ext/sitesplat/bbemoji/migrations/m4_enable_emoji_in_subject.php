<?php

/**
 *
 * @package BBEmoji
 * @copyright (c) 2018-2022 SiteSplat All rights reserved
 * @license Proprietary
 *
 */

namespace sitesplat\bbemoji\migrations;

/**
 * Migration stage 4: Enable emoji in subject
 */
class m4_enable_emoji_in_subject extends \phpbb\db\migration\migration
{
	/**
	 * Assign migration file dependencies for this migration
	 *
	 * @return array Array of migration files
	 * @static
	 * @access public
	 */
	static public function depends_on()
	{
		return array('\sitesplat\bbemoji\migrations\m3_initial_bbemoji_data');
	}

	/**
	 * Add the emoji table schema to the database:
	 *
	 * @return array Array of table schema
	 * @access public
	 */
	public function update_schema()
	{
		return array(
			'add_columns'	=> array(
				$this->table_prefix . 'forums'	=> array(
					'enable_subject_emoji'	=> array('BOOL', 0),
				),
			)
		);
	}

	/**
	 * Drop the emoji table schema from the database
	 *
	 * @return array Array of table schema
	 * @access public
	 */
	public function revert_schema()
	{
		return array(
			'drop_columns'	=> array(
				$this->table_prefix . 'forums'	=> array(
					'enable_subject_emoji',
				),
			),
		);
	}
}
