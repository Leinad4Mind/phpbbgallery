<?php
/**
*
* @package BBSidebar
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\sidebar\migrations\v31x;

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
		//return array('\phpbb\db\migration\data\v310\gold');
		return array('\sitesplat\BBCore\migrations\v31x\m1_initial_file');
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
			'add_tables'	=> array(
				$this->table_prefix . 'sidebar_types'	=> array(
					'COLUMNS'		=> array(
						'sidebar_type_id'	=> array('USINT', null, 'auto_increment'),
						'sidebar_type_name'	=> array('VCHAR:255', ''),
						'sidebar_options'	=> array('VCHAR:2', '00')
					),
					'PRIMARY_KEY'	=> array('sidebar_type_id'),
					'KEYS'			=> array(
						'type'		=> array('UNIQUE', array('sidebar_type_name')),
					),
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
				$this->table_prefix . 'sidebar_types',
			),
		);
	}
}
