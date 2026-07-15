<?php
/**
*
* BBPoints extension for the phpBB Forum Software package.
*
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\bbpoints\migrations\v11x;

/**
 * Migration stage 1: Initial schema
 */
class m1_initial_schema extends \phpbb\db\migration\migration
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
		return array('\sitesplat\bbpoints\migrations\v10x\m1_initial_schema');
	}

	/**
	 * Add collums to the database:
	 *
	 * @return array Array of table schema
	 * @access public
	 */
	public function update_schema()
	{
		return array(
			'add_columns'	=> array(
				$this->table_prefix . 'bbpoints'		=> array(
					'topic_id'	=> array('INT:11', '0'),
				),
				$this->table_prefix . 'topics'		=> array(
					'bbpoints_payed'	=> array('INT:11', '0'),
				),
			)
		);
	}

	/**
	 * Drop collumns from the database
	 *
	 * @return array Array of table schema
	 * @access public
	 */
	public function revert_schema()
	{
		return array(
			'drop_columns'	=> array(
				$this->table_prefix . 'topics'	=> array(
					'bbpoints_payed',
				),
			)
		);
	}
}
