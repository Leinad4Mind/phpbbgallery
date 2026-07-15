<?php
/**
*
* @package BBnewsletter
* @copyright (c) 2016 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\newsletter\migrations\v31x;

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
		return array('\phpbb\db\migration\data\v310\gold');
	}

	/**
	 * Add the table schema to the database:
	 *
	 * @return array Array of table schema
	 * @access public
	 */
	public function update_schema()
	{
		return array(
			// We have to create our own tables
			'add_tables'		=> array(
				$this->table_prefix . 'newsletter'	=> array(
					'COLUMNS'			=> array(
						'id'			=> array('UINT', null, 'auto_increment'),
						'user_id'		=> array('UINT', 0),
						'username'		=> array('VCHAR:255', ''),
						'user_colour'	=> array('VCHAR:20', ''),
						'subject'		=> array('VCHAR:255', ''),
						'message'		=> array('MTEXT_UNI', 0),
						'display_it'	=> array('TINT:1', 1),
						'time'			=> array('UINT:11', 0),
						'hits'			=> array('UINT:11', 0),
					),
					'PRIMARY_KEY'	=> 'id',
				),
			),
		);
	}

	/**
	 * Drop the table schema from the database
	 *
	 * @return array Array of table schema
	 * @access public
	 */
	public function revert_schema()
	{
		return array(
			'drop_tables'	=> array(
				$this->table_prefix . 'newsletter',
			),
		);
	}
}
