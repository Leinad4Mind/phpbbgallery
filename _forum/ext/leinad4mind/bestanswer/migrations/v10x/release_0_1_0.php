<?php
/**
 *
 * Best Answer extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2019-2021, Leinad4Mind, https://leinad4mind.top/forum
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace leinad4mind\bestanswer\migrations\v10x;

use \phpbb\db\migration\container_aware_migration;

class release_0_1_0 extends \phpbb\db\migration\container_aware_migration
{

	/**
	 * Add or update schema in the database
	 *
	 * @return array Array of table schema
	 * @access public
	 */
	public function update_schema()
	{
		return array(
			'add_columns'	=> array(
				$this->table_prefix . 'forums'			=> array(
					'bbpoints_answer'			=> array('UINT', 0),
				),
			),
		);
	}

	/**
	 * Drop schema in the database
	 *
	 * @return array Array of table schema
	 * @access public
	 */
	public function revert_schema()
	{
		return array(
			'drop_columns'							=> array(
				$this->table_prefix . 'forums'	=> array(
					'bbpoints_answer',
				),
			),
		);
	}
}
